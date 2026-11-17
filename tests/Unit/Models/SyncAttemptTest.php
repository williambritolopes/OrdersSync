<?php

namespace Tests\Unit\Models;

use App\Enums\SyncAttemptStatus;
use App\Models\Integration;
use App\Models\Order;
use App\Models\SyncAttempt;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SyncAttemptTest extends TestCase
{
    use RefreshDatabase;

    public function test_sync_attempt_belongs_to_an_order(): void
    {
        $order = Order::factory()->create();

        $attempt = SyncAttempt::factory()
            ->for($order)
            ->create();

        $this->assertTrue($attempt->order->is($order));
    }

    public function test_sync_attempt_can_belong_to_an_integration(): void
    {
        $integration = Integration::factory()->create();

        $attempt = SyncAttempt::factory()->create([
            'integration_id' => $integration->id,
        ]);

        $this->assertTrue($attempt->integration->is($integration));
    }

    public function test_sync_attempt_supports_nullable_integration(): void
    {
        $attempt = SyncAttempt::factory()->create([
            'integration_id' => null,
        ]);

        $this->assertNull($attempt->integration);
    }

    public function test_sync_attempt_status_is_cast_to_enum(): void
    {
        $attempt = SyncAttempt::factory()->create([
            'status' => SyncAttemptStatus::SUCCESS,
        ]);

        $this->assertSame(
            SyncAttemptStatus::SUCCESS,
            $attempt->status
        );
    }

    public function test_sync_attempt_payloads_are_cast_to_arrays(): void
    {
        $requestPayload = ['order_id' => 'EXT-123'];
        $responsePayload = ['success' => true];

        $attempt = SyncAttempt::factory()->create([
            'request_payload' => $requestPayload,
            'response_payload' => $responsePayload,
        ]);

        $this->assertSame($requestPayload, $attempt->request_payload);
        $this->assertSame($responsePayload, $attempt->response_payload);
    }
}
