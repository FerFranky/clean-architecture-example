<?php

namespace App\Presentation\Http\Controllers\Order;

use App\Application\DTOs\Order\OrderStatusDTO;
use App\Application\UseCases\Order\ChangeStatusOrder;
use App\Application\UseCases\Order\GetOrdersByStatus;
use App\Presentation\Requests\Order\OrderStatusRequest;
use App\Presentation\Resources\Order\OrderResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class OrderStatusController
{
    public function __construct(
        private GetOrdersByStatus $getOrdersByStatus,
        private ChangeStatusOrder $changeStatusOrder,
        ) {}

    public function index(string $status): AnonymousResourceCollection
    {
        $orders = $this->getOrdersByStatus->execute($status);

        return OrderResource::collection($orders);
    }

    public function patch(int $id, OrderStatusRequest $request): OrderResource
    {
        $dto = new OrderStatusDTO(
            status: $request->status,
        );

        $order = $this->changeStatusOrder->execute($id, $dto);

        return OrderResource::make($order);
    }
}
