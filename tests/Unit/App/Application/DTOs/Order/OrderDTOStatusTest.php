<?php

use App\Application\DTOs\Order\OrderStatusDTO;
use Tests\TestCase;

class OrderDTOStatusTest extends TestCase
{
    protected $status = 'pending';

    public function test_should_inicialize_order_status_dto()
    {
        $orderStatusDTO = new OrderStatusDTO($this->status);

        $this->assertEquals($this->status, $orderStatusDTO->status);
    }
}
