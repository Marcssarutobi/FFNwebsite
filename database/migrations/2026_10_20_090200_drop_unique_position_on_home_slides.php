<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Diapositives ajoutées / supprimées / réordonnées : la position n'est plus unique
        // (tinyint conservé : jusqu'à 255 diapositives ; ->change() demanderait doctrine/dbal)
        Schema::table('home_slides', function (Blueprint $table) {
            $table->dropUnique(['position']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('home_slides', function (Blueprint $table) {
            $table->unique('position');
        });
    }
};
