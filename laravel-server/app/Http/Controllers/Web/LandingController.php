<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\LandingPage;

class LandingController extends Controller
{
    public function show(string $slug)
    {
        $page = LandingPage::where('slug', $slug)->where('published', true)->first();

        if ($page) {
            return view('landing.dynamic', compact('page'));
        }

        // Fallback to static Blade view
        $viewName = 'landing.' . $slug;
        if (view()->exists($viewName)) {
            return view($viewName);
        }

        abort(404);
    }
}
