<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Images de fond des 5 diapositives du slider de la page d'accueil (les textes restent dans home.vue)
        Schema::create('home_slides', function (Blueprint $table) {
            $table->id();
            $table->unsignedTinyInteger('position')->unique();
            $table->string('image');
            $table->timestamps();
        });

        $defaults = [
            '/assets/images/main-slider/direct.JPG',
            '/assets/images/main-slider/replace.jpeg',
            '/assets/images/main-slider/DSC00662.JPG',
            '/assets/images/main-slider/DSC00680.JPG',
            '/assets/images/main-slider/DSC00712.JPG',
        ];

        foreach ($defaults as $index => $image) {
            DB::table('home_slides')->insert([
                'position' => $index + 1,
                'image' => $image,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('home_slides');
    }
};
