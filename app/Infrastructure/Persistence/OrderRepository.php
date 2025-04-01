<?php

namespace App\Infrastructure\Persistence;

use App\Domain\Entities\Order;
use App\Domain\Repositories\OrderRepositoryInterface;
use App\Models\Order as OrderModel;

class OrderRepository implements OrderRepositoryInterface
{
    public function save(Order $order): Order
    {
        $model = OrderModel::create([
            'customer_name' => $order->customerName,
            'total_amount' => $order->totalAmount,
            'status' => $order->status,
        ]);

        return new Order($model->id, $model->customer_name, $model->total_amount, $model->status);
    }
}
