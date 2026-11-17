<?php

namespace Database\Factories;

use App\Models\SyncAttempt;
use App\Enums\SyncAttemptStatus;
use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<SyncAttempt>
 */
class SyncAttemptFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'order_id' => Order::factory(),
            'integration_id' => null,
            'attempt_number' => 1,
            'status' => SyncAttemptStatus::PENDING,
            'request_payload' => [
                'order_id' => fake()->uuid(),
            ],
            'response_payload' => null,
            'error_message' => null,
            'started_at' => now(),
            'finished_at' => null,
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
