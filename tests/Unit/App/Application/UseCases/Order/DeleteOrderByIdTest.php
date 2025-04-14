<?php

use App\Application\UseCases\Order\DeleteOrderById;
use App\Infrastructure\Persistence\Order\OrderRepository;
use Tests\TestCase;

class DeleteOrderByIdTest extends TestCase
{
    private $orderRepositoryMock;

    private $deleteOrderById;

    protected $orderId = 1;

    protected function setUp(): void
    {
        parent::setUp();

        $this->orderRepositoryMock = $this->createMock(OrderRepository::class);
        $this->deleteOrderById = new DeleteOrderById($this->orderRepositoryMock);
    }

    public function test_should_delete_order_by_id_successfully_by_use_case(): void
    {
        $this->orderRepositoryMock
            ->expects($this->once())
            ->method('delete')
            ->with($this->orderId)
            ->willReturn(true);
        $result = $this->deleteOrderById->execute($this->orderId);

        $this->assertTrue($result);
    }

    public function test_should_delete_order_by_id_fails_by_use_case(): void
    {
        $this->orderRepositoryMock
            ->expects($this->once())
            ->method('delete')
            ->with($this->orderId)
            ->willReturn(false);

        $result = $this->deleteOrderById->execute($this->orderId);

        $this->assertFalse($result);
    }
}
