<?php

namespace App\Presentation\Http\Controllers;

use App\Application\DTOs\OrderDTO;
use App\Application\UseCases\CreateOrder;
use App\Presentation\Requests\CreateOrderRequest;
use Illuminate\Http\JsonResponse;

class OrderController
{
    public function __construct(private CreateOrder $createOrder) {}

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
