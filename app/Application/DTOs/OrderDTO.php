<?php

namespace App\Application\DTOs;

class OrderDTO
{
    public function __construct(
        public readonly string $customerName,
        public readonly float $totalAmount
    ) {}
}
