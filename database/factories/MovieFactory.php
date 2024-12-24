<?php

// database/factories/MovieFactory.php
namespace Database\Factories;

use App\Models\Movie;
use Illuminate\Database\Eloquent\Factories\Factory;

class MovieFactory extends Factory
{
    // Specify the corresponding model
    protected $model = Movie::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'title' => fake()->sentence(3),
            'description' => fake()->text(),
            'rating' => fake()->randomFloat(1, 0.1, 5.0),
            'featured' => fake()->boolean(),
            'release_date' => fake()->date(),
        ];
    }
}
