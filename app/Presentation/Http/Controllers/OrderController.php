<?php

namespace App\Presentation\Http\Controllers;

use App\Application\DTOs\OrderDTO;
use App\Application\UseCases\CreateOrder;
use App\Application\UseCases\GetOrdersById;
use App\Presentation\Requests\CreateOrderRequest;
use Illuminate\Http\JsonResponse;

class OrderController
{
    public function __construct(private CreateOrder $createOrder, private GetOrdersById $getOrderById) {}

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
}
