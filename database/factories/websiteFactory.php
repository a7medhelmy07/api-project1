<?php

namespace Database\Factories;
use App\Models\Website;
use App\Models\User;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\website>
 */
class websiteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return
            [
                'title' => fake()->word(),
                'url' => fake()->url(),
                'user_id' => fake()->numberBetween(1,50)
        ];
    }
}
