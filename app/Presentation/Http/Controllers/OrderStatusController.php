<?php

namespace App\Presentation\Http\Controllers;

use App\Application\UseCases\GetOrdersByStatus;
use Illuminate\Http\JsonResponse;

class OrderStatusController
{
    public function __construct(private GetOrdersByStatus $getOrdersByStatus) {}

    public function index(string $status): JsonResponse
{
    $orders = $this->getOrdersByStatus->execute($status);

    return response()->json($orders);
}
}
