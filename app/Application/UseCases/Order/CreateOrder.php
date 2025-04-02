<?php

namespace App\Application\UseCases\Order;

use App\Application\DTOs\Order\OrderDTO;
use App\Domain\Entities\OrderEntity\Order;
use App\Domain\Repositories\Order\OrderRepositoryInterface;

class CreateOrder
{
    public function __construct(private OrderRepositoryInterface $orderRepository) {}

    public function execute(OrderDTO $dto): Order
    {
        $order = Order::create($dto->customerName, $dto->totalAmount);
        return $this->orderRepository->save($order);
    }
}
