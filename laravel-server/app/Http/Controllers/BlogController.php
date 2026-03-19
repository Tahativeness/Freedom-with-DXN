<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    // GET /api/blog
    public function index(Request $request)
    {
        $query = Blog::where('published', true);

        if ($request->category) {
            $query->where('category', $request->category);
        }

        $page  = (int) ($request->page ?? 1);
        $limit = (int) ($request->limit ?? 9);
        $total = $query->count();

        $posts = $query->orderBy('created_at', 'desc')
            ->skip(($page - 1) * $limit)
            ->take($limit)
            ->get();

        return response()->json([
            'posts'       => $posts,
            'total'       => $total,
            'pages'       => (int) ceil($total / $limit),
            'currentPage' => $page,
        ]);
    }

    // GET /api/blog/:slug
    public function show($slug)
    {
        $post = Blog::where('slug', $slug)->where('published', true)->first();
        if (!$post) {
            return response()->json(['message' => 'Post not found'], 404);
        }
        $post->increment('views');
        return response()->json($post->fresh());
    }

    // POST /api/blog (admin)
    public function store(Request $request)
    {
        $slug = preg_replace('/[^a-z0-9]+/', '-', strtolower($request->title));
        $slug = trim($slug, '-');

        $post = Blog::create(array_merge($request->all(), ['slug' => $slug]));
        return response()->json($post, 201);
    }

    // PUT /api/blog/:id (admin)
    public function update(Request $request, $id)
    {
        $post = Blog::find($id);
        if (!$post) {
            return response()->json(['message' => 'Post not found'], 404);
        }
        $post->update($request->all());
        return response()->json($post);
    }

    // DELETE /api/blog/:id (admin)
    public function destroy($id)
    {
        Blog::destroy($id);
        return response()->json(['message' => 'Post deleted']);
    }
}
