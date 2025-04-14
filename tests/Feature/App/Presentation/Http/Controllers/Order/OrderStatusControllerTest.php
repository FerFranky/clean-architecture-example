<?php

use App\Models\Order as OrderModel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrderStatusControllerTest extends TestCase
{
    use RefreshDatabase;

    protected $orderData = [
        'customer_name' => 'Juan Perez',
        'total_amount' => 100.50,
    ];

    protected $defaultStatus = 'pending';

    public function test_should_get_order_status()
    {
        $order = OrderModel::factory()->create($this->orderData);
        $response = $this->getJson(route('orders.status.index', ['status' => $order->status]));
        $response->assertStatus(200)
            ->assertJson([
                'data' => [[
                    'status' => $order->status,
                ]],
            ]);
    }

    public function test_should_update_order_status()
    {
        $order = OrderModel::factory()->create($this->orderData);
        $updatedStatus = 'approved';

        $response = $this->patchJson(route('orders.status.patch', ['id' => $order->id]), [
            'status' => $updatedStatus,
        ]);
        $response->assertStatus(200)
            ->assertJson([
                'data' => [
                    'status' => $updatedStatus,
                ],
            ]);

        $this->assertDatabaseHas('orders', [
            'id' => $order->id,
            'status' => $updatedStatus,
        ]);
    }
}
