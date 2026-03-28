<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        $query = Blog::where('published', true)->orderByDesc('created_at');

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        $posts = $query->paginate(9)->appends($request->query());

        return view('pages.blog.index', compact('posts'));
    }

    public function show(Blog $blog)
    {
        $blog->increment('views');

        // Full HTML pages render as standalone documents
        if ($blog->content_type === 'full_html') {
            return response($blog->content);
        }

        $related = Blog::where('published', true)
            ->where('id', '!=', $blog->id)
            ->where('category', $blog->category)
            ->take(3)
            ->get();

        return view('pages.blog.show', compact('blog', 'related'));
    }
}
