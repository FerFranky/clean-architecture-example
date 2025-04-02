<?php

namespace App\Domain\Repositories;

use App\Domain\Entities\Order;

interface OrderRepositoryInterface
{
    public function findById(int $id): ?Order;
    public function findByStatus(string $status): array;
    public function findAll(): array;
    public function save(Order $order): Order;
    public function update(int $id, Order $order): Order;
    public function delete(int $id): bool;
}
