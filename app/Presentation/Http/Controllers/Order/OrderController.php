<?php

namespace App\Presentation\Http\Controllers\Order;

use App\Application\DTOs\Order\OrderDTO;
use App\Application\UseCases\Order\CreateOrder;
use App\Application\UseCases\Order\DeleteOrderById;
use App\Application\UseCases\Order\GetAllOrders;
use App\Application\UseCases\Order\GetOrdersById;
use App\Application\UseCases\Order\UpdateOrder;
use App\Presentation\Requests\Order\OrderRequest;
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

    public function store(OrderRequest $request): OrderResource
    {
        $dto = new OrderDTO(
            customerName: $request->customer_name,
            totalAmount: $request->total_amount
        );

        $order = $this->createOrder->execute($dto);

        return OrderResource::make($order);
    }

    public function update(int $id, OrderRequest $request): OrderResource
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
