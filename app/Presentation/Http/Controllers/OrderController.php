<?php

namespace App\Presentation\Http\Controllers;

use App\Application\DTOs\OrderDTO;
use App\Application\UseCases\CreateOrder;
use App\Application\UseCases\DeleteOrderById;
use App\Application\UseCases\GetAllOrders;
use App\Application\UseCases\GetOrdersById;
use App\Application\UseCases\UpdateOrder;
use App\Presentation\Requests\CreateOrderRequest;
use Illuminate\Http\JsonResponse;

class OrderController
{
    public function __construct(
        private GetOrdersById $getOrderById,
        private GetAllOrders $getAllOrders,
        private CreateOrder $createOrder,
        private UpdateOrder $updateOrder,
        private DeleteOrderById $deleteOrderById,
    ) {}

    public function index(): JsonResponse
    {
        $orders = $this->getAllOrders->execute();

        return response()->json($orders);
    }

    public function show(int $id): JsonResponse
    {
        $order = $this->getOrderById->execute($id);

        return response()->json([
            'id' => $order->id,
            'customer_name' => $order->customerName,
            'total_amount' => $order->totalAmount,
            'status' => $order->status,
        ]);
    }

    public function store(CreateOrderRequest $request): JsonResponse
    {
        $dto = new OrderDTO(
            customerName: $request->customer_name,
            totalAmount: $request->total_amount
        );

        $order = $this->createOrder->execute($dto);

        return response()->json([
            'id' => $order->id,
            'customer_name' => $order->customerName,
            'total_amount' => $order->totalAmount,
            'status' => $order->status,
        ]);
    }

    public function update(int $id, CreateOrderRequest $request): JsonResponse
    {
        $dto = new OrderDTO(
            customerName: $request->customer_name,
            totalAmount: $request->total_amount
        );

        $order = $this->updateOrder->execute($id, $dto);

        return response()->json([
            'id' => $order->id,
            'customer_name' => $order->customerName,
            'total_amount' => $order->totalAmount,
            'status' => $order->status,
        ]);
    }

    public function destroy(int $id)
    {
        $this->deleteOrderById->execute($id);

        return response()->noContent();
    }
}
