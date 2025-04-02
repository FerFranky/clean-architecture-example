<?php

namespace App\Domain\Entities;

class Order
{
    public function __construct(
        public readonly int $id,
        public readonly string $customerName,
        public readonly float $totalAmount,
        public readonly string|null $status
    ) {}

    public static function create(string $customerName, float $totalAmount): self
    {
        return new self(0, $customerName, $totalAmount, 'pending');
    }

    public static function update(string $customerName, float $totalAmount): self
    {
        return new self(0, $customerName, $totalAmount, null);
    }
}
