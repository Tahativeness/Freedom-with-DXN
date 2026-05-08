<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Services\MetaConversionsApi;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::query();

        if ($request->filled('category') && $request->category !== 'all') {
            $query->where('category', $request->category);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $sort = $request->get('sort', 'default');
        match ($sort) {
            'price-low'  => $query->orderBy('price', 'asc'),
            'price-high' => $query->orderBy('price', 'desc'),
            'rating'     => $query->orderBy('rating', 'desc'),
            'name'       => $query->orderBy('name', 'asc'),
            default      => $query->orderBy('featured', 'desc')->orderBy('created_at', 'desc'),
        };

        $products = $query->paginate(12)->appends($request->query());

        $categories = ['all', 'coffee', 'supplements', 'skincare', 'beverages', 'personal-care', 'other'];

        return view('pages.products.index', compact('products', 'categories'));
    }

    public function show(Product $product, MetaConversionsApi $capi)
    {
        $product->load('reviews.user');

        $landingPage = \App\Models\LandingPage::where('product_id', $product->id)->where('published', true)->first();

        $related = Product::where('category', $product->category)
            ->where('id', '!=', $product->id)
            ->take(4)
            ->get();

        $eventId = (string) Str::uuid();
        $capi->send('ViewContent', [
            'content_ids'      => [(string) $product->id],
            'content_type'     => 'product',
            'content_name'     => $product->name,
            'content_category' => $product->category,
            'value'            => (float) $product->price,
            'currency'         => 'USD',
        ], [], $eventId);

        return view('pages.products.show', compact('product', 'related', 'landingPage', 'eventId'));
    }
}
