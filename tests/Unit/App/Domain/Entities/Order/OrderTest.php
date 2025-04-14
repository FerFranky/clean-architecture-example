<?php

use App\Domain\Entities\Order\Order;
use Tests\TestCase;

class OrderTest extends TestCase
{
    protected $orderData = [
        'id' => 1,
        'customerName' => 'John Doe',
        'totalAmount' => 150.75,
        'status' => 'pending',
    ];

    public function test_should_inicialize_order_entity()
    {
        $order = new Order(
            $this->orderData['id'],
            $this->orderData['customerName'],
            $this->orderData['totalAmount'],
            $this->orderData['status']
        );

        $this->assertEquals($this->orderData['id'], $order->id);
        $this->assertEquals($this->orderData['customerName'], $order->customerName);
        $this->assertEquals($this->orderData['totalAmount'], $order->totalAmount);
        $this->assertEquals($this->orderData['status'], $order->status);
    }
}
