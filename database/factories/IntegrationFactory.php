<?php

namespace Database\Factories;

use App\Models\Company;
use App\Models\Integration;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Integration>
 */
class IntegrationFactory extends Factory
{
    public function definition(): array
    {
        return [
            'company_id' => Company::factory(),
            'name' => fake()->company(),
            'type' => fake()->randomElement(['tiny', 'bling', 'custom']),
            'base_url' => fake()->url(),
            'credentials' => [
                'access_token' => fake()->sha256(),
                'secret' => fake()->sha256(),
            ],
            'is_active' => true,
        ];
    }
}
