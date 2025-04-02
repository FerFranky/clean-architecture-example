<?php

namespace App\Domain\Repositories;

use App\Domain\Entities\Order;

interface OrderRepositoryInterface
{
    public function save(Order $order): Order;
    public function findById(int $id): ?Order;
    public function findByStatus(string $status): array;
}
