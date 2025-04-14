<?php

use App\Models\Order as OrderModel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrderControllerTest extends TestCase
{
    use RefreshDatabase;

    protected $orderData = [
        'customer_name' => 'Juan Perez',
        'total_amount' => 100.50,
    ];

    protected $defaultStatus = 'pending';

    public function test_should_create_order_endpoint()
    {
        $response = $this->postJson(route('orders.store'), $this->orderData);
        $response->assertStatus(200)
            ->assertJson([
                'data' => [
                    'customer_name' => $this->orderData['customer_name'],
                    'total_amount' => $this->orderData['total_amount'],
                    'status' => $this->defaultStatus,
                ],
            ]);

        $this->assertDatabaseHas('orders', [
            'customer_name' => $this->orderData['customer_name'],
            'total_amount' => $this->orderData['total_amount'],
            'status' => $this->defaultStatus,
        ]);
    }

    public function test_should_get_order_by_id()
    {
        $order = OrderModel::factory()->create($this->orderData);

        $response = $this->getJson(route('orders.show', ['order' => $order->id]));
        $response->assertStatus(200)
            ->assertJson([
                'data' => [
                    'customer_name' => $this->orderData['customer_name'],
                    'total_amount' => $this->orderData['total_amount'],
                ],
            ]);
    }

    public function test_should_update_order()
    {
        $order = OrderModel::factory()->create($this->orderData);
        $updatedData = [
            'customer_name' => 'Updated Name',
            'total_amount' => 200.00,
        ];

        $response = $this->putJson(route('orders.update', ['order' => $order->id]), $updatedData);
        $response->assertStatus(200)
            ->assertJson([
                'data' => [
                    'customer_name' => $updatedData['customer_name'],
                    'total_amount' => $updatedData['total_amount'],
                ],
            ]);

        $this->assertDatabaseHas('orders', [
            'customer_name' => $updatedData['customer_name'],
            'total_amount' => $updatedData['total_amount'],
        ]);
    }

    public function test_should_delete_order()
    {
        $order = OrderModel::factory()->create($this->orderData);

        $response = $this->deleteJson(route('orders.destroy', ['order' => $order->id]));
        $response->assertStatus(204);

        $this->assertDatabaseMissing('orders', [
            'id' => $order->id,
        ]);
    }

    public function test_should_get_orders_by_status()
    {
        OrderModel::factory()->create($this->orderData);

        $response = $this->getJson(route('orders.index', ['status' => 'pending']));
        $response->assertStatus(200)
            ->assertJson([
                'data' => [
                    [
                        'customer_name' => $this->orderData['customer_name'],
                        'total_amount' => $this->orderData['total_amount'],
                    ],
                ],
            ]);
    }
}
