<?php

namespace Database\Factories;

use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Project>
 */
class ProjectFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

     protected $model = Project::class;

    public function definition(): array
    {

        $title = $this->faker->sentence(4);

        return [
            'slug' => Str::slug($title) . '-' . Str::random(5),
            'title' => $title,
            'brief_description' => $this->faker->paragraph,
            'content' => '<p>' . implode('</p><p>', $this->faker->paragraphs(5)) . '</p>', // HTML rich text
            'image' => 'https://via.placeholder.com/640x480.png?text=' . urlencode($title), // Fake image URL
            'category_id' => rand(1, 3),
            'status' => $this->faker->randomElement(['draft', 'published', 'approbation']),
            'user_id' => User::inRandomOrder()->first()?->id ?? 1, // Assure-toi qu’il y a au moins un user
        ];
    }
}
