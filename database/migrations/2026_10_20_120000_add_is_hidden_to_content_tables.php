<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // Tables sans statut de publication : permet de masquer une fiche du site public sans l'effacer
    private array $tables = ['teams', 'expeditions', 'fungi_educations', 'videos'];

    public function up(): void
    {
        foreach ($this->tables as $table) {
            Schema::table($table, function (Blueprint $t) {
                $t->boolean('is_hidden')->default(false);
            });
        }
    }

    public function down(): void
    {
        foreach ($this->tables as $table) {
            Schema::table($table, function (Blueprint $t) {
                $t->dropColumn('is_hidden');
            });
        }
    }
};
