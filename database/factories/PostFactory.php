<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class PostFactory extends Factory
{
    /**
     * Create a random collection of string containing 3 characters '???'
     */
    public function definition(): array
    {
        $name = fake()->unique()->words(1, true);
        return [
            'name' => $name,
            'slug' => Str::slug($name),
            // 'description' => fake()->lexify('??????? ?????????????? ?????????? ?????'),
            'description' => fake()->paragraph(10),
            'image' => 'posts/default.jpg',
            'status' => fake()->boolean()
        ];
    }
}
