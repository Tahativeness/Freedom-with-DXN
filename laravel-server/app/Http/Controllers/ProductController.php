<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\Request;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

class ProductController extends Controller
{
    // GET /api/products
    public function index(Request $request)
    {
        $query = Product::query();

        if ($request->category) {
            $query->where('category', $request->category);
        }
        if ($request->featured) {
            $query->where('featured', true);
        }
        if ($request->search) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $page  = (int) ($request->page ?? 1);
        $limit = (int) ($request->limit ?? 12);
        $total = $query->count();

        $products = $query->orderBy('created_at', 'desc')
            ->skip(($page - 1) * $limit)
            ->take($limit)
            ->get();

        return response()->json([
            'products'    => $products,
            'total'       => $total,
            'pages'       => (int) ceil($total / $limit),
            'currentPage' => $page,
        ]);
    }

    // GET /api/products/:id
    public function show($id)
    {
        $product = Product::with('reviews')->find($id);
        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }
        return response()->json($product);
    }

    // POST /api/products (admin)
    public function store(Request $request)
    {
        $product = Product::create($request->all());
        return response()->json($product, 201);
    }

    // PUT /api/products/:id (admin)
    public function update(Request $request, $id)
    {
        $product = Product::find($id);
        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }
        $product->update($request->all());
        return response()->json($product);
    }

    // DELETE /api/products/:id (admin)
    public function destroy($id)
    {
        Product::destroy($id);
        return response()->json(['message' => 'Product deleted']);
    }

    // POST /api/products/:id/review
    public function addReview(Request $request, $id)
    {
        $product = Product::find($id);
        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        $user = JWTAuth::parseToken()->authenticate();

        Review::create([
            'product_id' => $product->id,
            'user_id'    => $user->id,
            'name'       => $request->name ?? $user->name,
            'rating'     => $request->rating,
            'comment'    => $request->comment,
        ]);

        // Recalculate average rating
        $avg = Review::where('product_id', $product->id)->avg('rating');
        $count = Review::where('product_id', $product->id)->count();
        $product->update(['rating' => round($avg, 2), 'num_reviews' => $count]);

        return response()->json($product->load('reviews'));
    }
}
