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

// Debug: test auth
Route::get('/test-auth', function () {
    return response()->json([
        'logged_in' => auth()->check(),
        'user' => auth()->user()?->only('id', 'name', 'email', 'role'),
        'session_id' => session()->getId(),
        'guard' => config('auth.defaults.guard'),
        'driver' => config('auth.guards.web.driver'),
        'session_driver' => config('session.driver'),
        'session_data' => session()->all(),
    ]);
});

// Debug: force login test
Route::get('/test-login', function () {
    $user = \App\Models\User::where('email', 'info@freedomwithdxn.com')->first();
    auth()->login($user);
    return response()->json([
        'after_login' => auth()->check(),
        'user' => auth()->user()?->only('id', 'name', 'email', 'role'),
    ]);
});

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
Route::get('/business', [PageController::class, 'business'])->name('business');
Route::get('/join', [PageController::class, 'joinDxn'])->name('join');
Route::get('/zoom', function () { return redirect(route('join') . '#zoom'); })->name('zoom');
Route::get('/blog', [BlogController::class, 'index'])->name('blog');
Route::get('/blog/{blog}', [BlogController::class, 'show'])->name('blog.show');
Route::get('/contact', [PageController::class, 'contact'])->name('contact');
Route::post('/contact', [PageController::class, 'contactStore'])->name('contact.store');

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
