<?php

use App\Application\UseCases\Order\GetOrdersByStatus;
use App\Infrastructure\Persistence\Order\OrderRepository;
use Tests\TestCase;

class GetOrdersByStatusTest extends TestCase
{
    private $orderRepositoryMock;

    private $getOrdersByStatus;

    protected $status = 'pending';

    protected $expectedOrders = [
        ['id' => 1, 'status' => 'pending'],
        ['id' => 2, 'status' => 'pending'],
    ];

    protected function setUp(): void
    {
        parent::setUp();

        $this->orderRepositoryMock = $this->createMock(OrderRepository::class);
        $this->getOrdersByStatus = new GetOrdersByStatus($this->orderRepositoryMock);
    }

    public function test_should_return_orders_by_status_by_use_case(): void
    {
        $this->orderRepositoryMock
            ->expects($this->once())
            ->method('findByStatus')
            ->with($this->status)
            ->willReturn($this->expectedOrders);

        $result = $this->getOrdersByStatus->execute($this->status);

        $this->assertEquals($this->expectedOrders, $result);
    }

    public function test_should_returns_empty_array_when_no_orders_found_by_use_case(): void
    {
        $this->status = 'completed';

        $this->orderRepositoryMock
            ->expects($this->once())
            ->method('findByStatus')
            ->with($this->status)
            ->willReturn([]);

        $result = $this->getOrdersByStatus->execute($this->status);

        $this->assertEmpty($result);
    }
}
