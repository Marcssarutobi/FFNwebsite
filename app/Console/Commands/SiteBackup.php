<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Process\Process;

// Sauvegarde automatique : base de données chaque jour, images téléversées une fois par semaine.
// Les copies sont rangées hors du site (~/backups/auto) et les plus anciennes sont supprimées.
class SiteBackup extends Command
{
    protected $signature = 'site:backup {--images : Sauvegarder aussi les images téléversées, quel que soit le jour}';

    protected $description = 'Sauvegarde la base de données (et les images chaque semaine) hors du dossier public';

    const KEEP_DATABASE = 14;
    const KEEP_IMAGES = 4;

    public function handle(): int
    {
        // public_html -> fungifornature.com -> domains -> dossier personnel
        $dir = env('BACKUP_PATH', dirname(base_path(), 3) . '/backups/auto');
        if (!is_dir($dir) && !mkdir($dir, 0700, true)) {
            $this->error("Dossier de sauvegarde inaccessible : $dir");
            return self::FAILURE;
        }

        $stamp = date('Ymd-His');
        $ok = $this->backupDatabase("$dir/database-$stamp.sql.gz");

        // Images : le dimanche, ou à la demande, ou si aucune copie n'a moins de 7 jours
        $lastImages = collect(glob("$dir/images-*.tar.gz"))->map(fn ($f) => filemtime($f))->max();
        if ($this->option('images') || date('N') == 7 || !$lastImages || $lastImages < strtotime('-7 days')) {
            $ok = $this->backupImages("$dir/images-$stamp.tar.gz") && $ok;
        }

        $this->prune("$dir/database-*.sql.gz", self::KEEP_DATABASE);
        $this->prune("$dir/images-*.tar.gz", self::KEEP_IMAGES);

        return $ok ? self::SUCCESS : self::FAILURE;
    }

    private function backupDatabase(string $file): bool
    {
        $db = config('database.connections.' . config('database.default'));
        $process = Process::fromShellCommandline(
            'set -o pipefail; mysqldump --no-tablespaces --single-transaction -h "$DB_HOST" -P "$DB_PORT" -u "$DB_USER" "$DB_NAME" | gzip > "$OUT"',
            null,
            [
                'MYSQL_PWD' => $db['password'],
                'DB_HOST' => $db['host'],
                'DB_PORT' => (string) $db['port'],
                'DB_USER' => $db['username'],
                'DB_NAME' => $db['database'],
                'OUT' => $file,
            ],
            null,
            600
        );
        $process->run();

        if (!$process->isSuccessful() || filesize($file) < 1000) {
            @unlink($file);
            $this->error('Échec de la sauvegarde de la base : ' . trim($process->getErrorOutput()));
            return false;
        }

        chmod($file, 0600);
        $this->info('Base sauvegardée : ' . basename($file) . ' (' . round(filesize($file) / 1024) . ' Ko)');
        return true;
    }

    private function backupImages(string $file): bool
    {
        $process = new Process(['tar', 'czf', $file, '-C', public_path(), 'images'], null, null, null, 1800);
        $process->run();

        if (!$process->isSuccessful()) {
            @unlink($file);
            $this->error('Échec de la sauvegarde des images : ' . trim($process->getErrorOutput()));
            return false;
        }

        chmod($file, 0600);
        $this->info('Images sauvegardées : ' . basename($file) . ' (' . round(filesize($file) / 1048576, 1) . ' Mo)');
        return true;
    }

    // Ne garde que les $keep copies les plus récentes
    private function prune(string $pattern, int $keep): void
    {
        $files = glob($pattern);
        usort($files, fn ($a, $b) => filemtime($b) <=> filemtime($a));
        foreach (array_slice($files, $keep) as $old) {
            @unlink($old);
        }
    }
}
