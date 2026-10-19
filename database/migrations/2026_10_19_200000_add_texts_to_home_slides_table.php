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
        // Textes des diapositives : titre en deux parties (fine + grasse), sous-titre (diapositive 1), texte, bouton
        Schema::table('home_slides', function (Blueprint $table) {
            $table->string('title_light')->nullable()->after('image');
            $table->string('title')->nullable()->after('title_light');
            $table->string('subtitle')->nullable()->after('title');
            $table->text('text')->nullable()->after('subtitle');
            $table->string('button_label')->nullable()->after('text');
            $table->string('button_link')->nullable()->after('button_label');
        });

        // Reprise des textes qui étaient écrits en dur dans home.vue
        DB::table('home_slides')->where('position', 1)->update([
            'title_light' => 'Fungi',
            'title' => 'for Nature',
            'subtitle' => 'Save the world of mushrooms',
            'text' => "Our NGO works to protect mushrooms, an essential yet often overlooked\npart of our ecosystems. Through scientific research, and community projects,\nwe highlight the ecological, nutritional, and medicinal importance of mushrooms.",
            'button_label' => 'Learn More',
            'button_link' => '/domain',
        ]);

        DB::table('home_slides')->where('position', '>', 1)->update([
            'title_light' => 'Help us',
            'title' => 'promote the mushrooms',
            'text' => 'Working together to preserve and promote mushrooms for the next generation.',
            'button_label' => 'Learn More',
            'button_link' => '/domain',
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('home_slides', function (Blueprint $table) {
            $table->dropColumn(['title_light', 'title', 'subtitle', 'text', 'button_label', 'button_link']);
        });
    }
};
