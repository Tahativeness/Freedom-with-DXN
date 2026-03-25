<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Product;

class HomeController extends Controller
{
    public function index()
    {
        $featured = Product::where('featured', true)->where('in_stock', true)->take(4)->get();
        $bestsellers = Product::where('in_stock', true)->orderByDesc('rating')->take(4)->get();

        return view('pages.home', compact('featured', 'bestsellers'));
    }
}
