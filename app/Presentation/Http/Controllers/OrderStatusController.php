<?php

namespace App\Presentation\Http\Controllers;

use App\Application\UseCases\GetOrdersByStatus;
use App\Presentation\Resources\Order\OrderResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class OrderStatusController
{
    public function __construct(private GetOrdersByStatus $getOrdersByStatus) {}

    public function index(string $status): AnonymousResourceCollection
    {
        $orders = $this->getOrdersByStatus->execute($status);

        return OrderResource::collection($orders);
    }
}
