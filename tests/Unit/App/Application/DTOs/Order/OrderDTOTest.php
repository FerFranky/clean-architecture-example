<?php

use App\Application\DTOs\Order\OrderDTO;
use Tests\TestCase;

class OrderDTOTest extends TestCase
{
    protected $customerName = 'John Doe';

    protected $totalAmount = 150.75;

    public function test_should_inicialize_order_dto()
    {
        $orderDTO = new OrderDTO($this->customerName, $this->totalAmount);

        $this->assertEquals($this->customerName, $orderDTO->customerName);
        $this->assertEquals($this->totalAmount, $orderDTO->totalAmount);
    }
}
