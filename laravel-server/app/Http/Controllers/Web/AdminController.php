<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\LandingPage;
use App\Models\Order;
use App\Models\Product;
use App\Models\SiteSettings;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminController extends Controller
{
    public function index()
    {
        $stats = [
            'products' => Product::count(),
            'orders' => Order::count(),
            'users' => User::count(),
            'revenue' => Order::where('status', 'delivered')->sum('total_amount'),
        ];

        return view('admin.index', compact('stats'));
    }

    public function products()
    {
        $products = Product::orderByDesc('created_at')->paginate(20);
        return view('admin.products', compact('products'));
    }

    public function productStore(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'category' => 'required|string',
        ]);

        Product::create($request->only([
            'name', 'description', 'price', 'category', 'image', 'landing_image',
            'in_stock', 'stock_count', 'sku', 'ingredients', 'usage',
            'featured', 'dxn_id', 'source_url', 'landing_page', 'dxn_category',
        ]));

        return back()->with('success', 'Product created successfully!');
    }

    public function productUpdate(Request $request, Product $product)
    {
        $product->update($request->only([
            'name', 'description', 'price', 'category', 'image', 'landing_image',
            'in_stock', 'stock_count', 'sku', 'ingredients', 'usage',
            'featured', 'dxn_id', 'source_url', 'landing_page', 'dxn_category',
        ]));

        return back()->with('success', 'Product updated successfully!');
    }

    public function productDestroy(Product $product)
    {
        $product->delete();
        return back()->with('success', 'Product deleted.');
    }

    public function orders()
    {
        $orders = Order::with('user', 'items.product')->orderByDesc('created_at')->paginate(20);
        return view('admin.orders', compact('orders'));
    }

    public function orderStatus(Request $request, Order $order)
    {
        $request->validate(['status' => 'required|in:pending,processing,shipped,delivered,cancelled']);
        $order->update(['status' => $request->status]);
        return back()->with('success', 'Order status updated.');
    }

    public function users()
    {
        $users = User::orderByDesc('created_at')->paginate(20);
        return view('admin.users', compact('users'));
    }

    public function blogs()
    {
        $blogs = Blog::orderByDesc('created_at')->paginate(20);
        return view('admin.blogs', compact('blogs'));
    }

    public function blogStore(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'content' => 'required|string',
            'category' => 'required|string',
        ]);

        $data = $request->only(['title', 'content', 'category', 'excerpt', 'image', 'tags', 'published']);
        $data['slug'] = \Illuminate\Support\Str::slug($request->title);
        $data['author_id'] = auth()->id();

        Blog::create($data);

        return back()->with('success', 'Blog post created!');
    }

    public function blogUpdate(Request $request, Blog $blog)
    {
        $blog->update($request->only(['title', 'content', 'category', 'excerpt', 'image', 'tags', 'published']));
        return back()->with('success', 'Blog post updated!');
    }

    public function blogDestroy(Blog $blog)
    {
        $blog->delete();
        return back()->with('success', 'Blog post deleted.');
    }

    // ── Landing Pages ──────────────────────────────────
    public function landingPages()
    {
        $pages = LandingPage::with('product')->orderByDesc('created_at')->paginate(20);
        $products = Product::orderBy('name')->get();
        return view('admin.landing-pages', compact('pages', 'products'));
    }

    public function landingPageCreate()
    {
        $products = Product::orderBy('name')->get();
        return view('admin.landing-page-form', ['page' => null, 'products' => $products]);
    }

    public function landingPageStore(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'hero_title' => 'required|string',
        ]);

        $data = $request->only([
            'title', 'product_id', 'hero_image', 'hero_title', 'hero_subtitle',
            'hero_bg_color', 'cta_text', 'cta_link', 'custom_css', 'custom_html', 'published',
        ]);
        $data['slug'] = Str::slug($request->title);
        $data['published'] = $request->has('published');

        // Handle JSON arrays
        if ($request->filled('features_text')) {
            $data['features'] = array_filter(array_map('trim', explode("\n", $request->features_text)));
        }
        if ($request->filled('benefits_text')) {
            $data['benefits'] = array_filter(array_map('trim', explode("\n", $request->benefits_text)));
        }
        if ($request->filled('gallery_text')) {
            $data['gallery'] = array_filter(array_map('trim', explode("\n", $request->gallery_text)));
        }

        $landing = LandingPage::create($data);

        // Auto-link product to this landing page
        if ($landing->product_id) {
            Product::where('id', $landing->product_id)->update([
                'landing_page' => '/landing/' . $landing->slug,
            ]);
        }

        return redirect()->route('admin.landing-pages')->with('success', 'Landing page created!');
    }

    public function landingPageEdit(LandingPage $landingPage)
    {
        $products = Product::orderBy('name')->get();
        return view('admin.landing-page-form', ['page' => $landingPage, 'products' => $products]);
    }

    public function landingPageUpdate(Request $request, LandingPage $landingPage)
    {
        $request->validate([
            'title' => 'required|string',
            'hero_title' => 'required|string',
        ]);

        $data = $request->only([
            'title', 'product_id', 'hero_image', 'hero_title', 'hero_subtitle',
            'hero_bg_color', 'cta_text', 'cta_link', 'custom_css', 'custom_html',
        ]);
        $data['slug'] = Str::slug($request->title);
        $data['published'] = $request->has('published');

        if ($request->filled('features_text')) {
            $data['features'] = array_filter(array_map('trim', explode("\n", $request->features_text)));
        } else {
            $data['features'] = [];
        }
        if ($request->filled('benefits_text')) {
            $data['benefits'] = array_filter(array_map('trim', explode("\n", $request->benefits_text)));
        } else {
            $data['benefits'] = [];
        }
        if ($request->filled('gallery_text')) {
            $data['gallery'] = array_filter(array_map('trim', explode("\n", $request->gallery_text)));
        } else {
            $data['gallery'] = [];
        }

        $landingPage->update($data);

        // Auto-link product
        if ($landingPage->product_id) {
            Product::where('id', $landingPage->product_id)->update([
                'landing_page' => '/landing/' . $landingPage->slug,
            ]);
        }

        return redirect()->route('admin.landing-pages')->with('success', 'Landing page updated!');
    }

    public function landingPageDestroy(LandingPage $landingPage)
    {
        // Unlink product
        if ($landingPage->product_id) {
            Product::where('id', $landingPage->product_id)->update(['landing_page' => '']);
        }
        $landingPage->delete();
        return back()->with('success', 'Landing page deleted.');
    }

    public function settings()
    {
        $settings = SiteSettings::global();
        return view('admin.settings', compact('settings'));
    }

    public function settingsUpdate(Request $request)
    {
        $settings = SiteSettings::global();
        $settings->update($request->only([
            'colors', 'fonts', 'hero', 'contact', 'social', 'seo', 'footer', 'navbar', 'charts',
        ]));

        return back()->with('success', 'Settings updated!');
    }
}
