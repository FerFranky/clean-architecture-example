<?php

use App\Application\UseCases\Order\GetOrdersById;
use App\Domain\Entities\Order\Order;
use App\Infrastructure\Persistence\Order\OrderRepository;
use Tests\TestCase;

class GetOrdersByIdTest extends TestCase
{
    private $orderRepositoryMock;

    private $getOrdersById;

    protected $orderId = 1;

    protected $orderData = [
        'id' => 1,
        'customerName' => 'Juan Perez',
        'totalAmount' => 100.50,
        'status' => 'pending',
    ];

    protected function setUp(): void
    {
        parent::setUp();

        $this->orderRepositoryMock = $this->createMock(OrderRepository::class);
        $this->getOrdersById = new GetOrdersById($this->orderRepositoryMock);
    }

    public function test_should_get_orders_by_id_and_returns_order_by_use_case()
    {
        $orderId = 1;
        $expectedOrder = new Order(
            $this->orderData['id'],
            $this->orderData['customerName'],
            $this->orderData['totalAmount'],
            $this->orderData['status']
        );

        $this->orderRepositoryMock
            ->expects($this->once())
            ->method('findById')
            ->with($orderId)
            ->willReturn($expectedOrder);

        $result = $this->getOrdersById->execute($orderId);

        $this->assertInstanceOf(Order::class, $result);
        $this->assertEquals($expectedOrder, $result);
    }
}
