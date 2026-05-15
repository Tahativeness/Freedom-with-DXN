<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\DxnLead;
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
            'leads' => DxnLead::count(),
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

        $data = $request->only([
            'name', 'name_ar', 'description', 'description_ar', 'price', 'category', 'image', 'landing_image',
            'in_stock', 'stock_count', 'sku', 'ingredients', 'ingredients_ar', 'usage', 'usage_ar',
            'featured', 'dxn_id', 'source_url', 'landing_page', 'dxn_category', 'rating',
        ]);
        $data['in_stock'] = $request->has('in_stock');
        $data['featured'] = $request->has('featured');

        if ($request->hasFile('image_file')) {
            $path = $request->file('image_file')->store('products', 'public');
            $data['image'] = '/storage/' . $path;
        }

        Product::create($data);

        return back()->with('success', 'Product created successfully!');
    }

    public function productUpdate(Request $request, Product $product)
    {
        $data = $request->only([
            'name', 'name_ar', 'description', 'description_ar', 'price', 'category', 'image', 'landing_image',
            'in_stock', 'stock_count', 'sku', 'ingredients', 'ingredients_ar', 'usage', 'usage_ar',
            'featured', 'dxn_id', 'source_url', 'landing_page', 'dxn_category', 'rating',
        ]);
        $data['in_stock'] = $request->has('in_stock');
        $data['featured'] = $request->has('featured');

        if ($request->hasFile('image_file')) {
            $path = $request->file('image_file')->store('products', 'public');
            $data['image'] = '/storage/' . $path;
        }

        $product->update($data);

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

    public function blogEdit(Blog $blog)
    {
        return view('admin.blog-edit', compact('blog'));
    }

    public function blogStore(Request $request)
    {
        set_time_limit(120);
        $isFullHtml = $request->input('content_type') === 'full_html';

        $request->validate([
            'title' => 'required|string',
            'content' => $isFullHtml ? 'nullable' : 'required|string',
            'content_html' => $isFullHtml ? 'required|string' : 'nullable',
            'category' => 'required|string',
        ]);

        $data = $request->only(['title', 'title_ar', 'content', 'content_type', 'category', 'excerpt', 'excerpt_ar', 'image', 'sub_image', 'tags', 'published']);
        $data['slug'] = \Illuminate\Support\Str::slug($request->title);
        $data['author_id'] = auth()->id();
        $data['content_type'] = $data['content_type'] ?? 'rich_text';
        $data['excerpt'] = $data['excerpt'] ?? '';
        $data['image'] = $data['image'] ?? '';
        $data['sub_image'] = $data['sub_image'] ?? '';

        // For full HTML mode, use the content_html field
        if ($isFullHtml) {
            $data['content'] = $request->input('content_html', '');
        }

        Blog::create($data);

        return back()->with('success', 'Blog post created!');
    }

    public function blogUpdate(Request $request, Blog $blog)
    {
        set_time_limit(120);
        $data = $request->only(['title', 'title_ar', 'content', 'content_ar', 'content_type', 'category', 'excerpt', 'excerpt_ar', 'image', 'sub_image', 'tags', 'published']);
        $data['excerpt'] = $data['excerpt'] ?? $blog->excerpt ?? '';
        $data['image'] = $data['image'] ?? $blog->image ?? '';
        $data['sub_image'] = $data['sub_image'] ?? $blog->sub_image ?? '';
        if (($data['content_type'] ?? $blog->content_type) === 'full_html' && $request->filled('content_html')) {
            $data['content'] = $request->input('content_html');
        }
        $blog->update($data);
        return redirect()->route('admin.blogs')->with('success', 'Blog post updated!');
    }

    public function blogUploadImage(Request $request, Blog $blog)
    {
        // DELETE request - remove image
        if ($request->isMethod('delete')) {
            $url = $request->input('url');
            $path = public_path(ltrim($url, '/'));
            if (file_exists($path) && str_contains($url, '/images/blog/' . $blog->id . '/')) {
                unlink($path);
                return response()->json(['success' => true]);
            }
            return response()->json(['success' => false, 'error' => 'File not found'], 404);
        }

        $request->validate(['image' => 'required|image|max:5120']);

        $dir = 'images/blog/' . $blog->id;
        $file = $request->file('image');
        $filename = time() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '', $file->getClientOriginalName());
        $file->move(public_path($dir), $filename);

        return response()->json(['url' => '/' . $dir . '/' . $filename]);
    }

    public function blogDestroy(Blog $blog)
    {
        $blog->delete();
        return back()->with('success', 'Blog post deleted.');
    }

    // ── Landing Pages ──────────────────────────────────
    public function landingPages()
    {
        $pages = LandingPage::with('product')->orderBy('id')->paginate(100);
        $products = Product::orderBy('name')->get();
        return view('admin.landing-pages', compact('pages', 'products'));
    }

    public function dxnBusinessLandingPage()
    {
        $settings = SiteSettings::global();
        $landingSettings = $this->dxnBusinessLandingSettings($settings);
        $recentLeads = DxnLead::latest()->limit(8)->get();
        $leadCounts = DxnLead::query()
            ->selectRaw('score, count(*) as total')
            ->groupBy('score')
            ->pluck('total', 'score');

        return view('admin.dxn-business-landing-page', compact('landingSettings', 'recentLeads', 'leadCounts'));
    }

    public function dxnBusinessLandingPageUpdate(Request $request)
    {
        $data = $request->validate([
            'content.seo_title' => 'required|string|max:255',
            'content.meta_description' => 'required|string|max:500',
            'content.hero_trust' => 'required|string|max:255',
            'content.hero_title' => 'required|string|max:500',
            'content.hero_subtitle' => 'required|string|max:700',
            'content.primary_cta_text' => 'required|string|max:120',
            'content.reassurance' => 'nullable|string|max:255',
            'content.chips_text' => 'nullable|string|max:2000',
            'content.overview_card_title' => 'required|string|max:255',
            'content.overview_card_text' => 'required|string|max:500',
            'content.stats_text' => 'nullable|string|max:2000',
            'content.trust_items_text' => 'nullable|string|max:2000',
            'content.overview_title' => 'required|string|max:255',
            'content.overview_description' => 'required|string|max:500',
            'content.video_poster' => 'nullable|string|max:500',
            'content.video_source' => 'nullable|string|max:500',
            'content.gift_kicker' => 'nullable|string|max:120',
            'content.gift_title' => 'required|string|max:255',
            'content.gift_description' => 'nullable|string|max:500',
            'content.gift_cta_text' => 'required|string|max:120',
            'content.gift_items_text' => 'nullable|string|max:2000',
            'content.why_eyebrow' => 'nullable|string|max:120',
            'content.why_title' => 'required|string|max:255',
            'content.why_description' => 'nullable|string|max:700',
            'content.why_cards_text' => 'nullable|string|max:4000',
            'content.why_note' => 'nullable|string|max:500',
            'content.problem_eyebrow' => 'nullable|string|max:120',
            'content.problem_title' => 'required|string|max:255',
            'content.problem_cards_text' => 'nullable|string|max:3000',
            'content.problem_bridge' => 'nullable|string|max:500',
            'content.opportunity_eyebrow' => 'nullable|string|max:120',
            'content.opportunity_title' => 'required|string|max:255',
            'content.opportunity_description' => 'nullable|string|max:500',
            'content.opportunity_steps_text' => 'nullable|string|max:3000',
            'content.stories_eyebrow' => 'nullable|string|max:120',
            'content.stories_title' => 'required|string|max:255',
            'content.testimonials_text' => 'nullable|string|max:4000',
            'content.proof_note' => 'nullable|string|max:500',
            'content.journey_eyebrow' => 'nullable|string|max:120',
            'content.journey_title' => 'required|string|max:255',
            'content.journey_steps_text' => 'nullable|string|max:3000',
            'content.qualifier_eyebrow' => 'nullable|string|max:120',
            'content.qualifier_title' => 'required|string|max:255',
            'content.qualifier_description' => 'required|string|max:500',
            'content.faq_eyebrow' => 'nullable|string|max:120',
            'content.faq_title' => 'required|string|max:255',
            'content.faq_items_text' => 'nullable|string|max:6000',
            'content.final_urgency' => 'nullable|string|max:255',
            'content.final_title' => 'required|string|max:255',
            'content.final_description' => 'nullable|string|max:500',
            'content.final_button_text' => 'required|string|max:120',
            'content.final_trust_line' => 'nullable|string|max:255',
            'content.mobile_cta_text' => 'required|string|max:120',
            'content.whatsapp_url' => 'required|string|max:500',
            'content.whatsapp_message' => 'required|string|max:500',
            'form.step_one_title' => 'required|string|max:255',
            'form.step_one_subtitle' => 'required|string|max:255',
            'form.interest_health_label' => 'required|string|max:120',
            'form.interest_income_label' => 'required|string|max:120',
            'form.interest_both_label' => 'required|string|max:120',
            'form.step_four_title' => 'required|string|max:255',
            'form.step_four_subtitle' => 'required|string|max:255',
            'form.learn_yes_label' => 'required|string|max:120',
            'form.learn_maybe_label' => 'required|string|max:120',
            'form.learn_no_label' => 'required|string|max:120',
            'form.contact_title' => 'required|string|max:255',
            'form.contact_subtitle' => 'required|string|max:255',
            'form.name_label' => 'required|string|max:120',
            'form.name_placeholder' => 'required|string|max:120',
            'form.email_label' => 'required|string|max:120',
            'form.email_placeholder' => 'required|string|max:120',
            'form.whatsapp_label' => 'required|string|max:120',
            'form.address_label' => 'required|string|max:120',
            'form.address_placeholder' => 'required|string|max:120',
            'form.country_search_placeholder' => 'required|string|max:120',
            'form.country_empty_text' => 'required|string|max:120',
            'form.phone_placeholder' => 'required|string|max:120',
            'form.phone_help' => 'nullable|string|max:255',
            'form.validation_error' => 'required|string|max:255',
            'form.submit_text' => 'required|string|max:120',
            'form.privacy_text' => 'required|string|max:255',
            'form.success_title' => 'required|string|max:120',
            'form.success_message' => 'required|string|max:255',
            'form.success_badge' => 'required|string|max:120',
        ]);

        $settings = SiteSettings::global();
        $settings->update([
            'dxn_business_landing' => array_replace_recursive($this->dxnBusinessLandingSettings($settings), $data),
        ]);

        return back()->with('success', 'DXN Business Landing page updated!');
    }

    private function dxnBusinessLandingSettings(SiteSettings $settings): array
    {
        $saved = is_array($settings->dxn_business_landing) ? $settings->dxn_business_landing : [];

        return array_replace_recursive(config('dxn_business_landing'), $saved);
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

        $slug = Str::slug($request->input('title'));
        $originalSlug = $slug;
        $counter = 1;
        while (LandingPage::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $counter++;
        }

        $data = [
            'title'            => $request->input('title'),
            'slug'             => $slug,
            'product_id'       => $request->input('product_id') ?: null,
            'hero_image'       => $request->input('hero_image', ''),
            'hero_title'       => $request->input('hero_title', ''),
            'hero_subtitle'    => $request->input('hero_subtitle', ''),
            'hero_bg_color'    => $request->input('hero_bg_color', '#2c1878'),
            'description'      => $request->input('description', ''),
            'description_ar'   => $request->input('description_ar', ''),
            'ingredients'      => $request->input('ingredients', ''),
            'ingredients_ar'   => $request->input('ingredients_ar', ''),
            'usage_directions' => $request->input('usage_directions', ''),
            'usage_directions_ar' => $request->input('usage_directions_ar', ''),
            'cta_text'         => $request->input('cta_text', ''),
            'cta_link'         => $request->input('cta_link', ''),
            'custom_css'       => $request->input('custom_css', ''),
            'custom_html'      => $request->input('custom_html', ''),
            'published'        => $request->has('published'),
        ];

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
        if ($request->has('qna')) {
            $data['qna'] = array_filter($request->input('qna', []), fn($item) => !empty($item['q']) && !empty($item['a']));
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
            'hero_bg_color', 'description', 'description_ar', 'ingredients', 'ingredients_ar',
            'usage_directions', 'usage_directions_ar',
            'cta_text', 'cta_link', 'custom_css', 'custom_html',
        ]);
        $slug = Str::slug($request->title);
        $originalSlug = $slug;
        $counter = 1;
        while (LandingPage::where('slug', $slug)->where('id', '!=', $landingPage->id)->exists()) {
            $slug = $originalSlug . '-' . $counter++;
        }

        $data['slug'] = $slug;
        $data['published'] = $request->has('published');
        $data['hero_image'] = $data['hero_image'] ?? '';
        $data['hero_bg_color'] = $data['hero_bg_color'] ?? '#2c1878';
        $data['cta_text'] = $data['cta_text'] ?? '';
        $data['cta_link'] = $data['cta_link'] ?? '';

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
        if ($request->has('qna')) {
            $data['qna'] = array_filter($request->input('qna', []), fn($item) => !empty($item['q']) && !empty($item['a']));
        } else {
            $data['qna'] = [];
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
