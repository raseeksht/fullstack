<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Blog>
 */
class BlogFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $imagePath = fake()->image(storage_path('app/public/images'));
        $imageFilename = basename($imagePath);
        return [
            'title' => fake()->sentence(5),
            'content' => fake()->paragraph(20),
            'user_id' => User::factory(),
            'image' => $imageFilename
        ];
    }
}
