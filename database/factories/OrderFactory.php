<?php

namespace Database\Factories;

use App\Enums\OrderStatus;
use App\Models\Company;
use App\Models\Integration;
use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'company_id' => Company::factory(),
            'integration_id' => Integration::factory(),
            'external_id' => fake()->unique()->bothify('ORDER-#####'),
            'status' => OrderStatus::PENDING,
            'currency' => 'BRL',
            'total' => fake()->randomFloat(2, 1, 5000),
            'payload' => [
                'source' => 'test',
                'customer' => [
                    'name' => fake()->name(),
                ],
            ],
            'synced_at' => null,
        ];
    }

    public function synced(): static
    {
        return $this->state(fn () => [
            'status' => OrderStatus::SYNCED,
            'synced_at' => now(),
        ]);
    }
}
