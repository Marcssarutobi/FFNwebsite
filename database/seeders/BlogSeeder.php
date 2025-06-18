<?php

namespace Database\Seeders;

use App\Models\Blog;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

class BlogSeeder extends Seeder
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

            Blog::create([
                'slug' => $slug,
                'title' => $title,
                'brief_description' => $faker->sentence(12),
                'content' => '<p>' . implode('</p><p>', $faker->paragraphs(5)) . '</p>',
                'image' => 'https://picsum.photos/800/400?random=' . rand(1, 9999),
                'category_id' => rand(1, 3), // Assure-toi que ces catégories existent
                'status' => $faker->randomElement(['draft', 'published', 'approbation']),
                'user_id' => 3,
            ]);
        }

    }
}
