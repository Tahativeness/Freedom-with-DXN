<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use Illuminate\Http\Request;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

class OrderController extends Controller
{
    // POST /api/orders
    public function store(Request $request)
    {
        $user = JWTAuth::parseToken()->authenticate();
        $items = $request->items ?? [];

        $totalAmount = collect($items)->sum(fn($i) => $i['price'] * $i['quantity']);

        $order = Order::create([
            'user_id'          => $user->id,
            'total_amount'     => $totalAmount,
            'shipping_address' => $request->shippingAddress,
            'payment_method'   => $request->paymentMethod,
            'notes'            => $request->notes,
            'referred_by'      => $user->referred_by,
        ]);

        foreach ($items as $item) {
            OrderItem::create([
                'order_id'   => $order->id,
                'product_id' => $item['product'] ?? null,
                'name'       => $item['name'],
                'image'      => $item['image'] ?? null,
                'price'      => $item['price'],
                'quantity'   => $item['quantity'],
            ]);
        }

        User::where('id', $user->id)->increment('total_sales', $totalAmount);

        return response()->json($order->load('items'), 201);
    }

    // GET /api/orders/my
    public function myOrders()
    {
        $user = JWTAuth::parseToken()->authenticate();
        $orders = Order::with('items')
            ->where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();
        return response()->json($orders);
    }

    // GET /api/orders (admin)
    public function index()
    {
        $orders = Order::with(['user:id,name,email', 'items'])
            ->orderBy('created_at', 'desc')
            ->get();
        return response()->json($orders);
    }

    // PUT /api/orders/:id/status (admin)
    public function updateStatus(Request $request, $id)
    {
        $order = Order::find($id);
        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }
        $order->update($request->only(['status', 'payment_status']));
        return response()->json($order->load('items'));
    }
}
