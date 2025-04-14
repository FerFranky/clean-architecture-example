<?php

use App\Application\UseCases\Order\GetAllOrders;
use App\Infrastructure\Persistence\Order\OrderRepository;
use Tests\TestCase;

class GetAllOrdersTest extends TestCase
{
    private $orderRepositoryMock;

    private $getAllOrders;

    protected $orders = [
        ['id' => 1, 'name' => 'Order 1'],
        ['id' => 2, 'name' => 'Order 2'],
    ];

    protected function setUp(): void
    {
        parent::setUp();

        $this->orderRepositoryMock = $this->createMock(OrderRepository::class);
        $this->getAllOrders = new GetAllOrders($this->orderRepositoryMock);
    }

    public function test_should_return_all_orders_by_use_case()
    {

        $this->orderRepositoryMock
            ->expects($this->once())
            ->method('findAll')
            ->willReturn($this->orders);

        $result = $this->getAllOrders->execute();

        $this->assertEquals($this->orders, $result);
    }
}
