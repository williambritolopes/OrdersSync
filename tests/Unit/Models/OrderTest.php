<?php

namespace Tests\Unit\Models;

use App\Enums\OrderStatus;
use App\Models\Company;
use App\Models\Integration;
use App\Models\Order;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrderTest extends TestCase
{
    use RefreshDatabase;

    public function test_order_belongs_to_a_company_and_integration(): void
    {
        $company = Company::factory()->create();

        $integration = Integration::factory()
            ->for($company)
            ->create();

        $order = Order::factory()
            ->for($company)
            ->for($integration)
            ->create();

        $this->assertTrue($order->company->is($company));
        $this->assertTrue($order->integration->is($integration));
    }

    public function test_order_status_is_cast_to_enum(): void
    {
        $order = Order::factory()->create([
            'status' => OrderStatus::PROCESSING,
        ]);

        $this->assertSame(
            OrderStatus::PROCESSING,
            $order->status
        );
    }

    public function test_order_payload_is_cast_to_array(): void
    {
        $payload = [
            'external_id' => 'EXT-123',
            'customer' => [
                'name' => 'John Doe',
            ],
        ];

        $order = Order::factory()->create([
            'payload' => $payload,
        ]);

        $this->assertSame($payload, $order->payload);
    }

    public function test_order_has_many_items(): void
    {
        $order = Order::factory()->create();

        $order->items()->createMany([
            [
                'sku' => 'SKU-001',
                'product_name' => 'Product One',
                'quantity' => 2,
                'unit_price' => 10.00,
                'subtotal' => 20.00,
            ],
            [
                'sku' => 'SKU-002',
                'product_name' => 'Product Two',
                'quantity' => 3,
                'unit_price' => 15.00,
                'subtotal' => 45.00,
            ],
        ]);

        $this->assertCount(2, $order->items);
    }
}
