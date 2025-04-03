<?php

namespace App\Application\UseCases\Order;

use App\Application\DTOs\Order\OrderDTO;
use App\Domain\Entities\Order\Order;
use App\Domain\Repositories\Order\OrderRepositoryInterface;

class UpdateOrder
{
    public function __construct(private OrderRepositoryInterface $orderRepository) {}

    public function execute(int $id, OrderDTO $dto): Order
    {
        $order = Order::update($dto->customerName, $dto->totalAmount);

        return $this->orderRepository->update($id, $order);
    }
}
