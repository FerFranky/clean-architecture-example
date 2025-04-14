<?php

use App\Domain\Entities\Order\Order;
use App\Infrastructure\Persistence\Order\OrderRepository;
use App\Models\Order as OrderModel;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrderRepositoryTest extends TestCase
{
    use RefreshDatabase;

    private OrderRepository $orderRepository;

    protected $orderStatusPending = 'pending';

    protected $orderStatusCompleted = 'completed';

    protected $orderId = 999;

    protected $orderData = [
        'id' => 1,
        'customer_name' => 'John Doe',
        'total_amount' => 100.50,
        'status' => 'pending',
    ];

    protected function setUp(): void
    {
        parent::setUp();
        $this->orderRepository = new OrderRepository;
    }

    public function test_should_find_all_orders_by_repository(): void
    {
        OrderModel::factory()->count(3)->create();

        $orders = $this->orderRepository->findAll();

        $this->assertCount(3, $orders);
    }

    public function test_should_find_orders_by_status_by_repository(): void
    {
        OrderModel::factory()->count(2)->create(['status' => $this->orderStatusPending]);
        OrderModel::factory()->count(3)->create(['status' => $this->orderStatusCompleted]);

        $orders = $this->orderRepository->findByStatus($this->orderStatusPending);

        $this->assertCount(2, $orders);
    }

    public function test_should_find_orders_by_status_with_no_results_by_repository(): void
    {
        OrderModel::factory()->count(3)->create(['status' => $this->orderStatusCompleted]);

        $orders = $this->orderRepository->findByStatus($this->orderStatusPending);

        $this->assertCount(0, $orders);
    }

    public function test_should_it_can_save_an_order_by_repository(): void
    {
        $order = new Order(
            id: $this->orderData['id'],
            customerName: $this->orderData['customer_name'],
            totalAmount: $this->orderData['total_amount'],
            status: $this->orderData['status']
        );

        $result = $this->orderRepository->save($order);

        $this->assertInstanceOf(Order::class, $result);
        $this->assertEquals($this->orderData['id'], $result->id);
        $this->assertEquals($this->orderData['customer_name'], $result->customerName);
        $this->assertEquals($this->orderData['total_amount'], $result->totalAmount);
        $this->assertEquals($this->orderData['status'], $result->status);
    }

    public function test_should_find_an_order_by_id_by_repository(): void
    {
        $orderId = OrderModel::factory()->create()->id;

        $order = $this->orderRepository->findById($orderId);

        $this->assertNotNull($order);
        $this->assertEquals($orderId, $order->id);
    }

    public function test_should_it_can_update_an_order_by_repository(): void
    {
        $order = OrderModel::factory()->create([
            'customer_name' => $this->orderData['customer_name'],
            'total_amount' => $this->orderData['total_amount'],
            'status' => $this->orderData['status'],
        ]);

        $updatedData = [
            'id' => $order->id,
            'customer_name' => $this->orderData['customer_name'],
            'total_amount' => $this->orderData['total_amount'],
            'status' => $this->orderStatusCompleted,
        ];
        $orderEntity = new Order(
            id: $updatedData['id'],
            customerName: $updatedData['customer_name'],
            totalAmount: $updatedData['total_amount'],
            status: $updatedData['status']
        );

        $updatedOrder = $this->orderRepository->update($order->id, $orderEntity);

        $this->assertNotNull($updatedOrder);
        $this->assertEquals($updatedData['customer_name'], $updatedOrder->customerName);
        $this->assertEquals($updatedData['total_amount'], $updatedOrder->totalAmount);
    }

    public function test_should_it_can_change_status_by_repository(): void
    {
        $order = OrderModel::factory()->create([
            'status' => $this->orderStatusPending,
        ]);

        $newStatus = $this->orderStatusCompleted;

        $orderEntity = new Order(
            id: $order->id,
            customerName: $order->customer_name,
            totalAmount: $order->total,
            status: $newStatus
        );

        $updatedOrder = $this->orderRepository->changeStatus($order->id, $orderEntity);

        $this->assertNotNull($updatedOrder);
        $this->assertEquals($newStatus, $updatedOrder->status);
    }

    public function test_should_it_can_delete_an_order_by_repository(): void
    {
        $orderId = OrderModel::factory()->create()->id;

        $result = $this->orderRepository->delete($orderId);

        $this->assertTrue($result);
    }

    public function test_should_it_returns_null_for_non_existent_order_by_repository(): void
    {
        $this->expectException(ModelNotFoundException::class);

        $this->orderRepository->findById($this->orderId);
    }
}
