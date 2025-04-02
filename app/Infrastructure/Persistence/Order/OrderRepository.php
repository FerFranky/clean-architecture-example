<?php

namespace App\Infrastructure\Persistence\Order;

use App\Domain\Entities\Order\Order;
use App\Domain\Repositories\Order\OrderRepositoryInterface;
use App\Models\Order as OrderModel;
use Illuminate\Support\Facades\DB;

class OrderRepository implements OrderRepositoryInterface
{
    public function findAll(): array
    {
        return OrderModel::get()
            ->map(fn($model) => new Order(
                id: $model->id,
                customerName: $model->customer_name,
                totalAmount: $model->total_amount,
                status: $model->status
            ))->toArray();
    }

    public function findById(int $id): ?Order
    {
        $model = OrderModel::findOrFail($id);

        return $model ? new Order(
            id: $model->id,
            customerName: $model->customer_name,
            totalAmount: $model->total_amount,
            status: $model->status
        ) : null;
    }

    public function findByStatus(string $status): array
    {
        return OrderModel::where('status', $status)
            ->get()
            ->map(fn($model) => new Order(
                id: $model->id,
                customerName: $model->customer_name,
                totalAmount: $model->total_amount,
                status: $model->status
            ))->toArray();
    }

    public function save(Order $order): Order
    {
        return DB::transaction(function () use ($order) {
            $model = OrderModel::create([
                'customer_name' => $order->customerName,
                'total_amount' => $order->totalAmount,
                'status' => $order->status,
            ]);

            return new Order(
                id: $model->id,
                customerName: $model->customer_name,
                totalAmount: $model->total_amount,
                status: $model->status
            );
        });
    }

    public function update(int $id, Order $order): Order
    {
        return DB::transaction(function () use ($id, $order) {
            $model = OrderModel::findOrFail($id);

            $model->update([
                'customer_name' => $order->customerName,
                'total_amount' => $order->totalAmount,
            ]);

            return new Order(
                id: $model->id,
                customerName: $model->customer_name,
                totalAmount: $model->total_amount,
                status: $model->status
            );
        });
    }

    public function changeStatus(int $id, Order $order): Order
    {
        return DB::transaction(function () use ($id, $order) {
            $model = OrderModel::findOrFail($id);

            $model->update([
                'status' => $order->status,
            ]);

            return new Order(
                id: $model->id,
                customerName: $model->customer_name,
                totalAmount: $model->total_amount,
                status: $model->status
            );
        });
    }

    public function delete(int $id): bool
    {
        $this->findById($id);
        return OrderModel::destroy($id);
    }
}
