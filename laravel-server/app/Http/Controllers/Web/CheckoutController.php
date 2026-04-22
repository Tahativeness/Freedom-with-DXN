<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = session('cart', []);
        if (empty($cart)) {
            return redirect()->route('cart')->with('error', 'Your cart is empty.');
        }

        $items = [];
        $total = 0;

        foreach ($cart as $id => $qty) {
            $product = Product::find($id);
            if ($product) {
                $items[] = ['product' => $product, 'quantity' => $qty];
                $total += $product->price * $qty;
            }
        }

        return view('pages.checkout', compact('items', 'total'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'address' => 'required|string',
            'city' => 'required|string',
            'country' => 'required|string',
            'phone' => 'required|string',
            'payment_method' => 'required|in:cash,bank_transfer',
        ]);

        $cart = session('cart', []);
        if (empty($cart)) {
            return redirect()->route('cart')->with('error', 'Your cart is empty.');
        }

        $total = 0;
        $orderItems = [];

        foreach ($cart as $id => $qty) {
            $product = Product::find($id);
            if ($product) {
                $subtotal = $product->price * $qty;
                $total += $subtotal;
                $orderItems[] = [
                    'product_id' => $product->id,
                    'name' => $product->name,
                    'quantity' => $qty,
                    'price' => $product->price,
                ];
            }
        }

        $order = Order::create([
            'user_id' => auth()->id(),
            'total_amount' => $total,
            'status' => 'pending',
            'payment_method' => $request->payment_method,
            'shipping_address' => json_encode([
                'address' => $request->address,
                'city' => $request->city,
                'country' => $request->country,
                'phone' => $request->phone,
            ]),
        ]);

        foreach ($orderItems as $item) {
            OrderItem::create(array_merge($item, ['order_id' => $order->id]));
        }

        session()->forget('cart');

        return redirect()->route('dashboard')->with('success', 'Order placed successfully!');
    }
}
