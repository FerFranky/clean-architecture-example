<?php

namespace App\Domain\Entities\OrderEntity;

class Order
{
    public function __construct(
        public readonly int $id,
        public readonly string|null $customerName,
        public readonly float|null $totalAmount,
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

    public static function changeStatus(string $status): self
    {
        return new self(0, null, null, $status);
    }
}
