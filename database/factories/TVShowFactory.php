<?php

namespace Database\Factories;

use App\Models\User_role;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Ramsey\Uuid\Type\Decimal;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TVShow>
 */
class tvShowFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->sentence(3),
            'description' => fake()->text(),
            'rating' => fake()->randomFloat(1, 0.1, 5.0),
            'featured' => fake()->boolean(),
            'release_date' => fake()->date(),
        ];
    }
}
