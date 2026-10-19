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
        // Logos de la section « Our Partners & Supporters »
        Schema::create('partners', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('logo');
            $table->string('url')->nullable();
            $table->unsignedInteger('position')->default(0);
            $table->timestamps();
        });

        $partners = [
            ['The Rufford Foundation', '/assets/images/clients/01.png'],
            ['SPUN – Society for the Protection of Underground Networks', '/assets/images/clients/03.jpg'],
            ['Université de Parakou', '/assets/images/clients/04.jpg'],
            ['MyTIPS – Tropical Mycology and Plants-Soil Fungi Interactions', '/assets/images/clients/05.jpg'],
            ['British Ecological Society', '/assets/images/clients/06.png'],
            ['Society for Molecular Biology & Evolution', '/assets/images/clients/07.jpeg'],
            ['CEBioS', '/assets/images/clients/image001.jpg'],
            ['Museum', '/assets/images/clients/image003.png'],
            ['MOPGA', '/assets/images/clients/mopga.jpg'],
            ['Partner', '/assets/images/clients/WhatsApp.jpeg'],
        ];

        foreach ($partners as $index => [$name, $logo]) {
            DB::table('partners')->insert(['name' => $name, 'logo' => $logo, 'position' => $index + 1, 'created_at' => now(), 'updated_at' => now()]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('partners');
    }
};
