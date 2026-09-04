<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Http\Controllers\Controller;
use App\Services\Admin\OrderService;

class OrderController extends Controller
{
    public function __construct(
        protected OrderService $orderService
    ) {}

    public function index(Request $request)
    {
        $orders = $this->orderService->getOrders(
            $request->input('search'),
            $request->input('sort')
        );

        if ($request->ajax()) {
            $html = view(
                'admin.Orders.partials.table',
                compact('orders')
            )->render();

            return response()->json([
                'html' => $html,
            ]);
        }

        return view(
            'admin.Orders.index',
            compact('orders')
        );
    }

    public function show(Order $order)
    {
        $order = $this->orderService->getOrder($order);

        return view(
            'admin.Orders.show',
            compact('order')
        );
    }

    public function updateStatus(Request $request, Order $order)
    {
        $validated = $request->validate([
            'status' => [
                'required',
                'in:pending,confirmed,processing,shipped,delivered,cancelled,returned',
            ],
        ]);

        $this->orderService->updateStatus(
            $order,
            $validated['status']
        );

        return redirect()
            ->route('admin.orders.show', $order)
            ->with(
                'success',
                'Order status updated successfully.'
            );
    }
}