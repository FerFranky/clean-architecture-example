<?php

namespace App\Presentation\Http\Controllers;

use App\Application\DTOs\OrderDTO;
use App\Application\UseCases\CreateOrder;
use App\Application\UseCases\DeleteOrderById;
use App\Application\UseCases\GetAllOrders;
use App\Application\UseCases\GetOrdersById;
use App\Application\UseCases\UpdateOrder;
use App\Presentation\Requests\CreateOrderRequest;
use App\Presentation\Resources\Order\OrderResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class OrderController
{
    public function __construct(
        private GetOrdersById $getOrderById,
        private GetAllOrders $getAllOrders,
        private CreateOrder $createOrder,
        private UpdateOrder $updateOrder,
        private DeleteOrderById $deleteOrderById,
    ) {}

    public function index(): AnonymousResourceCollection
    {
        $orders = $this->getAllOrders->execute();

        return OrderResource::collection($orders);
    }

    public function show(int $id): OrderResource
    {
        $order = $this->getOrderById->execute($id);
        return OrderResource::make($order);
    }

    public function store(CreateOrderRequest $request): OrderResource
    {
        $dto = new OrderDTO(
            customerName: $request->customer_name,
            totalAmount: $request->total_amount
        );

        $order = $this->createOrder->execute($dto);

        return OrderResource::make($order);
    }

    public function update(int $id, CreateOrderRequest $request): OrderResource
    {
        $dto = new OrderDTO(
            customerName: $request->customer_name,
            totalAmount: $request->total_amount
        );

        $order = $this->updateOrder->execute($id, $dto);

        return OrderResource::make($order);
    }

    public function destroy(int $id)
    {
        $this->deleteOrderById->execute($id);

        return response()->noContent();
    }
}
