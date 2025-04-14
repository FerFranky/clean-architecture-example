<?php

use App\Application\DTOs\Order\OrderStatusDTO;
use App\Application\UseCases\Order\ChangeStatusOrder;
use App\Domain\Entities\Order\Order;
use App\Infrastructure\Persistence\Order\OrderRepository;
use Tests\TestCase;

class ChangeStatusOrderTest extends TestCase
{
    protected $orderData = [
        'id' => 1,
        'customerName' => 'Juan Perez',
        'totalAmount' => 100.50,
        'status' => 'approved',
    ];

    public function test_should_change_order_status_successfully_by_use_case()
    {
        $mockRepository = Mockery::mock(OrderRepository::class);
        $mockRepository->shouldReceive('changeStatus')
            ->once()
            ->andReturn(new Order(
                $this->orderData['id'],
                $this->orderData['customerName'],
                $this->orderData['totalAmount'],
                $this->orderData['status']
            ));

        $useCase = new ChangeStatusOrder($mockRepository);

        $orderStatusDTO = new OrderStatusDTO($this->orderData['status']);

        $order = $useCase->execute($this->orderData['id'], $orderStatusDTO);

        $this->assertInstanceOf(Order::class, $order);
        $this->assertEquals(1, $order->id);
        $this->assertEquals($this->orderData['customerName'], $order->customerName);
        $this->assertEquals($this->orderData['totalAmount'], $order->totalAmount);
    }
}
