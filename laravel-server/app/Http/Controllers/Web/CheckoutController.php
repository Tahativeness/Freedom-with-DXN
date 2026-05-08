<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Services\MetaConversionsApi;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    public function index(MetaConversionsApi $capi)
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

        $eventId = (string) Str::uuid();
        $capi->send('InitiateCheckout', [
            'value'        => round((float) $total, 2),
            'currency'     => 'USD',
            'content_type' => 'product',
            'content_ids'  => array_map(fn($i) => (string) $i['product']->id, $items),
            'num_items'    => array_sum(array_column($items, 'quantity')),
        ], [], $eventId);

        return view('pages.checkout', compact('items', 'total', 'eventId'));
    }

    public function store(Request $request, MetaConversionsApi $capi)
    {
        $request->validate([
            'address' => 'required|string',
            'city' => 'required|string',
            'country' => 'required|string',
            'phone' => 'required|string',
            'email' => 'required|email',
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
                'email' => $request->email,
            ]),
        ]);

        foreach ($orderItems as $item) {
            OrderItem::create(array_merge($item, ['order_id' => $order->id]));
        }

        session()->forget('cart');

        $eventId = (string) Str::uuid();
        $contentIds = array_map(fn($i) => (string) $i['product_id'], $orderItems);
        $numItems   = array_sum(array_column($orderItems, 'quantity'));

        $capi->send('Purchase', [
            'value'        => round((float) $total, 2),
            'currency'     => 'USD',
            'content_type' => 'product',
            'content_ids'  => $contentIds,
            'num_items'    => $numItems,
            'order_id'     => (string) $order->id,
        ], array_filter([
            'em' => $capi->hash($request->email) ? [$capi->hash($request->email)] : null,
            'ph' => $capi->hashPhone($request->phone) ? [$capi->hashPhone($request->phone)] : null,
            'ct' => $capi->hash($request->city) ? [$capi->hash($request->city)] : null,
            'country' => $capi->hash($request->country) ? [$capi->hash($request->country)] : null,
        ]), $eventId);

        return redirect()->route('dashboard')
            ->with('success', 'Order placed successfully!')
            ->with('fbq_purchase', [
                'value' => round((float) $total, 2),
                'currency' => 'USD',
                'content_type' => 'product',
                'content_ids' => $contentIds,
                'num_items' => $numItems,
                'order_id' => $order->id,
                'event_id' => $eventId,
            ]);
    }
}
