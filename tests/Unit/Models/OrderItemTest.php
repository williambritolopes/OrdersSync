<?php

namespace Tests\Unit\Models;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrderItemTest extends TestCase
{
    use RefreshDatabase;

    public function test_order_item_belongs_to_an_order(): void
    {
        $order = Order::factory()->create();

        $item = OrderItem::factory()
            ->for($order)
            ->create();

        $this->assertTrue($item->order->is($order));
    }

    public function test_order_item_can_belong_to_a_product(): void
    {
        $product = Product::factory()->create();

        $item = OrderItem::factory()->create([
            'product_id' => $product->id,
        ]);

        $this->assertTrue($item->product->is($product));
    }

    public function test_order_item_supports_nullable_product(): void
    {
        $item = OrderItem::factory()->create([
            'product_id' => null,
        ]);

        $this->assertNull($item->product);
    }

    public function test_order_item_casts_numeric_values_correctly(): void
    {
        $item = OrderItem::factory()->create([
            'quantity' => 3,
            'unit_price' => 19.90,
            'subtotal' => 59.70,
        ]);

        $this->assertIsInt($item->quantity);
        $this->assertSame('19.90', $item->unit_price);
        $this->assertSame('59.70', $item->subtotal);
    }
}
