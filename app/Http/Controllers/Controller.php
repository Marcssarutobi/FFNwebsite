<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    // Réduit et recompresse une image téléversée (sur place, même nom).
    // Une photo d'appareil de 20 Mo devient ~500 Ko sans perte visible ; ne fait rien si Imagick est absent.
    protected function optimizeImage($path, $maxSide = 1920)
    {
        if (!class_exists(\Imagick::class) || !is_file($path)) {
            return;
        }

        try {
            $img = new \Imagick($path);
            if ($img->getNumberImages() > 1) {
                return; // GIF animé : laissé tel quel
            }

            switch ($img->getImageOrientation()) {
                case \Imagick::ORIENTATION_BOTTOMRIGHT: $img->rotateImage('#000', 180); break;
                case \Imagick::ORIENTATION_RIGHTTOP:    $img->rotateImage('#000', 90);  break;
                case \Imagick::ORIENTATION_LEFTBOTTOM:  $img->rotateImage('#000', -90); break;
            }
            $img->setImageOrientation(\Imagick::ORIENTATION_TOPLEFT);

            $width = $img->getImageWidth();
            $height = $img->getImageHeight();
            if (max($width, $height) > $maxSide) {
                $img->resizeImage($width >= $height ? $maxSide : 0, $height > $width ? $maxSide : 0, \Imagick::FILTER_LANCZOS, 1);
            }

            $profiles = $img->getImageProfiles('icc', true);
            $img->stripImage();
            if (!empty($profiles['icc'])) {
                $img->profileImage('icc', $profiles['icc']);
            }

            $format = strtolower($img->getImageFormat());
            if (in_array($format, ['jpeg', 'jpg'])) {
                $img->setImageCompression(\Imagick::COMPRESSION_JPEG);
                $img->setImageCompressionQuality(82);
                $img->setInterlaceScheme(\Imagick::INTERLACE_PLANE);
            } elseif ($format === 'png') {
                $img->setOption('png:compression-level', '9');
            } else {
                $img->setImageCompressionQuality(82);
            }

            $blob = $img->getImagesBlob();
            $img->clear();

            // On ne remplace que si le résultat est plus léger
            if (strlen($blob) < filesize($path)) {
                file_put_contents($path, $blob);
            }
        } catch (\Throwable $e) {
            report($e); // l'image d'origine reste en place
        }
    }

    // Supprime un fichier téléversé, uniquement s'il se trouve dans public/images
    // (empêche de supprimer un autre fichier du site avec un chemin du type /../.env)
    protected function deletePublicImage($path)
    {
        if (!is_string($path) || $path === '') {
            return;
        }

        $base = realpath(public_path('images'));
        $file = realpath(public_path(ltrim($path, '/')));

        if ($base && $file && str_starts_with($file, $base . DIRECTORY_SEPARATOR) && is_file($file)) {
            @unlink($file);
        }
    }
}
