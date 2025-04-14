<?php

use App\Application\DTOs\Order\OrderDTO;
use App\Application\UseCases\Order\CreateOrder;
use App\Domain\Entities\Order\Order;
use App\Infrastructure\Persistence\Order\OrderRepository;
use Tests\TestCase;

class CreateOrderTest extends TestCase
{
    protected $orderData = [
        'id' => 1,
        'customerName' => 'Juan Perez',
        'totalAmount' => 100.50,
        'status' => 'pending',
    ];

    public function test_should_create_order_successfully_by_use_case()
    {
        $mockRepository = Mockery::mock(OrderRepository::class);
        $mockRepository->shouldReceive('save')
            ->once()
            ->andReturn(new Order(
                $this->orderData['id'],
                $this->orderData['customerName'],
                $this->orderData['totalAmount'],
                $this->orderData['status']
            ));

        $useCase = new CreateOrder($mockRepository);

        $orderDTO = new OrderDTO(
            $this->orderData['customerName'],
            $this->orderData['totalAmount']
        );

        $order = $useCase->execute($orderDTO);

        $this->assertInstanceOf(Order::class, $order);
        $this->assertEquals(1, $order->id);
        $this->assertEquals($this->orderData['customerName'], $order->customerName);
        $this->assertEquals($this->orderData['totalAmount'], $order->totalAmount);
    }
}
