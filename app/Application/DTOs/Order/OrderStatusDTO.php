<?php

namespace App\Application\DTOs\Order;

class OrderStatusDTO
{
    public function __construct(
        public readonly string $status,
    ) {}
}
