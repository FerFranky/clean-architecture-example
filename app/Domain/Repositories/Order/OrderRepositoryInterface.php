<?php

namespace App\Domain\Repositories\Order;

use App\Domain\Entities\Order\Order;

interface OrderRepositoryInterface
{
    public function findById(int $id): ?Order;
    public function findByStatus(string $status): array;
    public function findAll(): array;
    public function save(Order $order): Order;
    public function update(int $id, Order $order): Order;
    public function changeStatus(int $id, Order $order): Order;
    public function delete(int $id): bool;
}
