<?php

namespace Database\Seeders;

use App\Models\Event;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        
        $faker = Faker::create();
        
        for ($i = 0; $i < 25; $i++) {
            $title = $faker->sentence(6);
            $slug = Str::slug($title) . '-' . uniqid();

            Event::create([
                'slug' => $slug,
                'title' => $title,
                'brefdescription' => $faker->sentence(12),
                'content' => '<p>' . implode('</p><p>', $faker->paragraphs(5)) . '</p>',
                'start_date' => $start = $faker->dateTimeBetween('+1 days', '+2 months'),
                'end_date' => (clone $start)->modify('+'.rand(1, 5).' hours'),
                'location' => $faker->city,
                'image' => 'https://picsum.photos/800/400?random=' . rand(1, 9999),
                'category_id' => rand(1, 3), // Assure-toi que ces catégories existent
                'status' => $faker->randomElement(['draft', 'published', 'approbation']),
                'user_id' => 3,
            ]);
        }

    }
}
