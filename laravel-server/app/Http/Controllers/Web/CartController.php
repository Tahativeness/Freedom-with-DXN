<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Services\MetaConversionsApi;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CartController extends Controller
{
    public function index()
    {
        $cart = session('cart', []);
        $items = [];
        $total = 0;

        foreach ($cart as $id => $qty) {
            $product = Product::find($id);
            if ($product) {
                $items[] = ['product' => $product, 'quantity' => $qty];
                $total += $product->price * $qty;
            }
        }

        return view('pages.cart', compact('items', 'total'));
    }

    public function add(Request $request, MetaConversionsApi $capi)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'integer|min:1',
        ]);

        $cart = session('cart', []);
        $id = $request->product_id;
        $qty = (int) $request->get('quantity', 1);

        $cart[$id] = ($cart[$id] ?? 0) + $qty;
        session(['cart' => $cart]);

        $product = Product::find($id);
        $eventId = (string) Str::uuid();

        if ($product) {
            $capi->send('AddToCart', [
                'content_ids'  => [(string) $product->id],
                'content_type' => 'product',
                'content_name' => $product->name,
                'value'        => round((float) $product->price * $qty, 2),
                'currency'     => 'USD',
            ], [], $eventId);
        }

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'count' => array_sum($cart),
                'event_id' => $eventId,
            ]);
        }

        return back()->with('success', 'Product added to cart!');
    }

    public function data()
    {
        $cart = session('cart', []);
        $items = [];
        $total = 0;
        $count = 0;

        foreach ($cart as $id => $qty) {
            $product = Product::find($id);
            if ($product) {
                $items[] = [
                    'id' => $product->id,
                    'name' => $product->name,
                    'price' => (float) $product->price,
                    'image' => $product->landing_image ?: ($product->image ?: ''),
                    'quantity' => (int) $qty,
                    'subtotal' => (float) $product->price * $qty,
                ];
                $total += $product->price * $qty;
                $count += $qty;
            }
        }

        return response()->json([
            'items' => $items,
            'total' => $total,
            'count' => $count,
        ]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'product_id' => 'required',
            'quantity' => 'required|integer|min:0',
        ]);

        $cart = session('cart', []);
        $id = $request->product_id;

        if ($request->quantity <= 0) {
            unset($cart[$id]);
        } else {
            $cart[$id] = $request->quantity;
        }

        session(['cart' => $cart]);

        return back();
    }

    public function remove($id)
    {
        $cart = session('cart', []);
        unset($cart[$id]);
        session(['cart' => $cart]);

        return back()->with('success', 'Item removed from cart.');
    }
}
