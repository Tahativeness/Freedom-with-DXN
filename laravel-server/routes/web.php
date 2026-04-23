<?php

use App\Http\Controllers\Web\AuthController;
use App\Http\Controllers\Web\CartController;
use App\Http\Controllers\Web\HomeController;
use App\Http\Controllers\Web\PageController;
use App\Http\Controllers\Web\ProductController;
use App\Http\Controllers\Web\BlogController;
use App\Http\Controllers\Web\AdminController;
use App\Http\Controllers\Web\CheckoutController;
use App\Http\Controllers\Web\DashboardController;
use App\Http\Controllers\Web\LandingController;
use Illuminate\Support\Facades\Route;

// Sitemap
Route::get('/sitemap.xml', function () {
    $products = \App\Models\Product::select('id', 'updated_at')->orderBy('updated_at', 'desc')->get();
    $blogs = \App\Models\Blog::where('published', true)->select('id', 'slug', 'updated_at')->orderBy('updated_at', 'desc')->get();
    $landings = \App\Models\LandingPage::where('published', true)->select('slug', 'updated_at')->orderBy('updated_at', 'desc')->get();

    $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
    $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";

    // Static pages
    $staticPages = [
        ['url' => '/', 'priority' => '1.0', 'changefreq' => 'weekly'],
        ['url' => '/products', 'priority' => '0.9', 'changefreq' => 'daily'],
        ['url' => '/blog', 'priority' => '0.8', 'changefreq' => 'daily'],
        ['url' => '/about', 'priority' => '0.7', 'changefreq' => 'monthly'],
        ['url' => '/join', 'priority' => '0.8', 'changefreq' => 'monthly'],
        ['url' => '/contact', 'priority' => '0.6', 'changefreq' => 'monthly'],
    ];

    foreach ($staticPages as $page) {
        $xml .= '  <url>' . "\n";
        $xml .= '    <loc>https://freedomwithdxn.com' . $page['url'] . '</loc>' . "\n";
        $xml .= '    <changefreq>' . $page['changefreq'] . '</changefreq>' . "\n";
        $xml .= '    <priority>' . $page['priority'] . '</priority>' . "\n";
        $xml .= '  </url>' . "\n";
    }

    // Products
    foreach ($products as $product) {
        $xml .= '  <url>' . "\n";
        $xml .= '    <loc>https://freedomwithdxn.com/products/' . $product->id . '</loc>' . "\n";
        $xml .= '    <lastmod>' . $product->updated_at->toW3cString() . '</lastmod>' . "\n";
        $xml .= '    <changefreq>weekly</changefreq>' . "\n";
        $xml .= '    <priority>0.7</priority>' . "\n";
        $xml .= '  </url>' . "\n";
    }

    // Blog posts
    foreach ($blogs as $blog) {
        $xml .= '  <url>' . "\n";
        $xml .= '    <loc>https://freedomwithdxn.com/blog/' . $blog->slug . '</loc>' . "\n";
        $xml .= '    <lastmod>' . $blog->updated_at->toW3cString() . '</lastmod>' . "\n";
        $xml .= '    <changefreq>monthly</changefreq>' . "\n";
        $xml .= '    <priority>0.6</priority>' . "\n";
        $xml .= '  </url>' . "\n";
    }

    // Landing pages
    foreach ($landings as $landing) {
        $xml .= '  <url>' . "\n";
        $xml .= '    <loc>https://freedomwithdxn.com/landing/' . $landing->slug . '</loc>' . "\n";
        $xml .= '    <lastmod>' . $landing->updated_at->toW3cString() . '</lastmod>' . "\n";
        $xml .= '    <changefreq>monthly</changefreq>' . "\n";
        $xml .= '    <priority>0.6</priority>' . "\n";
        $xml .= '  </url>' . "\n";
    }

    $xml .= '</urlset>';

    return response($xml, 200)->header('Content-Type', 'application/xml');
})->name('sitemap');

// Language toggle
Route::get('/lang/{locale}', function (string $locale) {
    if (in_array($locale, ['en', 'ar'])) {
        session(['lang' => $locale]);
    }
    return back();
})->name('lang.switch');

// Public pages
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/products', [ProductController::class, 'index'])->name('products');
Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');
Route::get('/join', [PageController::class, 'joinDxn'])->name('join');
Route::get('/zoom', function () { return redirect(route('join') . '#zoom'); })->name('zoom');
Route::get('/blog', [BlogController::class, 'index'])->name('blog');
Route::get('/blog/{blog}', [BlogController::class, 'show'])->name('blog.show');
Route::get('/blog/{blog}/raw', [BlogController::class, 'showRaw'])->name('blog.show.raw');
Route::get('/contact', [PageController::class, 'contact'])->name('contact');
Route::post('/contact', [PageController::class, 'contactStore'])->name('contact.store');
Route::get('/privacy-policy', [PageController::class, 'privacyPolicy'])->name('privacy-policy');
Route::get('/terms-of-service', [PageController::class, 'termsOfService'])->name('terms-of-service');

// Auth
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Authenticated routes
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/cart', [CartController::class, 'index'])->name('cart');
    Route::get('/cart/data', [CartController::class, 'data'])->name('cart.data');
    Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
    Route::put('/cart/update', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
});

// Admin routes
Route::middleware(['auth', 'admin.web'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('index');
    Route::get('/products', [AdminController::class, 'products'])->name('products');
    Route::post('/products', [AdminController::class, 'productStore'])->name('products.store');
    Route::put('/products/{product}', [AdminController::class, 'productUpdate'])->name('products.update');
    Route::delete('/products/{product}', [AdminController::class, 'productDestroy'])->name('products.destroy');
    Route::get('/orders', [AdminController::class, 'orders'])->name('orders');
    Route::put('/orders/{order}/status', [AdminController::class, 'orderStatus'])->name('orders.status');
    Route::get('/users', [AdminController::class, 'users'])->name('users');
    Route::get('/blogs', [AdminController::class, 'blogs'])->name('blogs');
    Route::post('/blogs', [AdminController::class, 'blogStore'])->name('blogs.store');
    Route::get('/blogs/{blog}/edit', [AdminController::class, 'blogEdit'])->name('blogs.edit');
    Route::match(['post', 'delete'], '/blogs/{blog}/upload-image', [AdminController::class, 'blogUploadImage'])->name('blogs.upload-image');
    Route::put('/blogs/{blog}', [AdminController::class, 'blogUpdate'])->name('blogs.update');
    Route::delete('/blogs/{blog}', [AdminController::class, 'blogDestroy'])->name('blogs.destroy');
    Route::get('/settings', [AdminController::class, 'settings'])->name('settings');
    Route::put('/settings', [AdminController::class, 'settingsUpdate'])->name('settings.update');
    Route::get('/landing-pages', [AdminController::class, 'landingPages'])->name('landing-pages');
    Route::get('/landing-pages/create', [AdminController::class, 'landingPageCreate'])->name('landing-pages.create');
    Route::post('/landing-pages', [AdminController::class, 'landingPageStore'])->name('landing-pages.store');
    Route::get('/landing-pages/{landingPage}/edit', [AdminController::class, 'landingPageEdit'])->name('landing-pages.edit');
    Route::put('/landing-pages/{landingPage}', [AdminController::class, 'landingPageUpdate'])->name('landing-pages.update');
    Route::delete('/landing-pages/{landingPage}', [AdminController::class, 'landingPageDestroy'])->name('landing-pages.destroy');
});

// Landing pages
Route::get('/landing/{slug}', [LandingController::class, 'show'])->name('landing');
