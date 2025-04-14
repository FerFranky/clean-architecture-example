<?php

use App\Application\DTOs\Order\OrderDTO;
use App\Application\UseCases\Order\UpdateOrder;
use App\Domain\Entities\Order\Order;
use App\Infrastructure\Persistence\Order\OrderRepository;
use Tests\TestCase;

class UpdateOrderTest extends TestCase
{
    private $orderRepositoryMock;

    private $updateOrder;

    protected $orderData = [
        'id' => 0,
        'customerName' => 'Juan Perez',
        'totalAmount' => 100.50,
        'status' => null,
    ];

    protected function setUp(): void
    {
        parent::setUp();

        $this->orderRepositoryMock = $this->createMock(OrderRepository::class);
        $this->updateOrder = new UpdateOrder($this->orderRepositoryMock);
    }

    public function test_should_update_order_by_use_case()
    {
        $orderId = 1;
        $updatedOrder = new Order(
            $this->orderData['id'],
            $this->orderData['customerName'],
            $this->orderData['totalAmount'],
            $this->orderData['status']
        );
        $orderDTO = new OrderDTO(
            $this->orderData['customerName'],
            $this->orderData['totalAmount']
        );

        $this->orderRepositoryMock
            ->expects($this->once())
            ->method('update')
            ->with($orderId, $updatedOrder)
            ->willReturn($updatedOrder);

        $result = $this->updateOrder->execute($orderId, $orderDTO);

        $this->assertInstanceOf(Order::class, $result);
        $this->assertEquals($updatedOrder, $result);
    }
}
