<?php

namespace App\Application\UseCases;

use App\Application\DTOs\OrderDTO;
use App\Domain\Entities\Order;
use App\Domain\Repositories\OrderRepositoryInterface;

class CreateOrder
{
    public function __construct(private OrderRepositoryInterface $orderRepository) {}

    public function execute(OrderDTO $dto): Order
    {
        $order = Order::create($dto->customerName, $dto->totalAmount);
        return $this->orderRepository->save($order);
    }
}
