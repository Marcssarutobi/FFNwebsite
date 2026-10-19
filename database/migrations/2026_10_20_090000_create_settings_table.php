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
        // Paramètres du site modifiables dans l'admin (coordonnées, réseaux sociaux, textes de l'accueil)
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->text('value')->nullable();
            $table->timestamps();
        });

        // Valeurs affichées jusqu'ici, écrites en dur dans le code
        $defaults = [
            'contact_email' => 'contact@fungifornature.com',
            'contact_phone' => '(+229) 0196975772',
            'contact_address' => 'Parakou, Bénin',
            'social_facebook' => null,
            'social_x' => null,
            'social_instagram' => null,
            'social_linkedin' => null,
            'facts_title' => 'We’re proud of the impact Fungi For Nature is making in preserving fungal biodiversity and promoting ecological sustainability',
            'facts_text' => 'Since its creation, Fungi For Nature has worked tirelessly to raise awareness about the ecological importance of fungi. Through education, research, and conservation, we are making an impact.',
            'ceo_message' => 'At Fungi For Nature, we believe fungi are not just organisms, but vital allies in restoring ecological balance. Our mission is to protect and promote fungal biodiversity, empower communities, and drive sustainable innovation through nature. Together, we can transform how we see and care for the world beneath our feet',
            'ceo_name' => 'Boris Armel Olou',
            'ceo_role' => 'CEO of Fungi For Nature',
            'ceo_photo' => '/assets/images/resource/Boris-Olou-ID-Photo.jpg',
        ];

        foreach ($defaults as $key => $value) {
            DB::table('settings')->insert(['key' => $key, 'value' => $value, 'created_at' => now(), 'updated_at' => now()]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
