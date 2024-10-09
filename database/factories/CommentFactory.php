<?php

namespace Database\Factories;

use App\Models\Blog;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Comment>
 */
class CommentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "user_id" => User::inRandomOrder()->get()->first()->id,
            "commentContent" => fake()->colorName() . "awesome post" . fake()->name(),
            "blog_id" => Blog::inRandomOrder()->get()->first()->id,
            // boolean(50) -> retrns true or false 50% probality
            // root comment lai parent null
            "parent" => fake()->boolean(50) ? Comment::inRandomOrder()->get()->first()?->id : null,
        ];
    }
}
