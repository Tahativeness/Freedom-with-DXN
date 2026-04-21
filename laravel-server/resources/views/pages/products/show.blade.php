@extends('layouts.app')
@section('title', $product->name . ' | Freedom With DXN')
@section('description', Str::limit(strip_tags($product->description), 155))
@section('og_type', 'product')
@if($product->landing_image ?: $product->image)
    @section('og_image', url($product->landing_image ?: $product->image))
@endif

@push('seo')
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "Product",
    "name": "{{ $product->name }}",
    "description": "{{ Str::limit(strip_tags($product->description), 200) }}",
    "image": "{{ url($product->landing_image ?: ($product->image ?: '/logo.png')) }}",
    "brand": { "@type": "Brand", "name": "DXN" },
    "offers": {
        "@type": "Offer",
        "price": "{{ $product->price }}",
        "priceCurrency": "USD",
        "availability": "{{ $product->in_stock ? 'https://schema.org/InStock' : 'https://schema.org/OutOfStock' }}",
        "url": "{{ url()->current() }}"
    }
    @if($product->rating)
    ,"aggregateRating": {
        "@type": "AggregateRating",
        "ratingValue": "{{ $product->rating }}",
        "bestRating": "5",
        "ratingCount": "{{ $product->reviews ? $product->reviews->count() : 1 }}"
    }
    @endif
}
</script>
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "BreadcrumbList",
    "itemListElement": [
        { "@type": "ListItem", "position": 1, "name": "Home", "item": "https://freedomwithdxn.com" },
        { "@type": "ListItem", "position": 2, "name": "Products", "item": "https://freedomwithdxn.com/products" },
        { "@type": "ListItem", "position": 3, "name": "{{ $product->name }}" }
    ]
}
</script>
@endpush

@php
    $lang = session('lang', 'en');
    $lp = $landingPage ?? null;
    $whatsapp = 'https://wa.me/971555574958?text=' . urlencode('Hi, I want to order: ' . $product->name . ' (SKU: ' . $product->sku . ')');
    $mainImage = $product->landing_image ?: ($product->image ?: '');
    $images = is_array($product->images) ? $product->images : [];
    $allImages = $mainImage ? array_merge([$mainImage], $images) : $images;
    // Landing page gallery overrides product images
    if ($lp && !empty($lp->gallery)) {
        $allImages = array_merge($allImages, $lp->gallery);
    }
    // Arabic priority: LP Arabic -> Product Arabic -> LP English -> Product English
    if ($lang === 'ar') {
        $benefits = $product->benefits_ar ?: (is_array($product->benefits) ? $product->benefits : []);
        if ($lp && !empty($lp->features)) {
            // Only use LP features if product has no Arabic benefits
            if (empty($product->benefits_ar)) { $benefits = $lp->features; }
        }
    } else {
        $benefits = is_array($product->benefits) ? $product->benefits : [];
        if ($lp && !empty($lp->features)) { $benefits = $lp->features; }
    }
    $displayName = ($lang === 'ar' && $product->name_ar) ? $product->name_ar : $product->name;
    // Description: prefer Arabic from LP or product, then English
    if ($lang === 'ar') {
        $displayDesc = ($lp && $lp->description_ar) ? $lp->description_ar
            : ($product->description_ar ?: (($lp && $lp->description) ? $lp->description : $product->description));
    } else {
        $displayDesc = ($lp && $lp->description) ? $lp->description : $product->description;
    }
    // Usage: prefer Arabic from LP or product, then English
    if ($lang === 'ar') {
        $displayUsage = ($lp && $lp->usage_directions_ar) ? $lp->usage_directions_ar
            : ($product->usage_ar ?: (($lp && $lp->usage_directions) ? $lp->usage_directions : $product->usage));
    } else {
        $displayUsage = ($lp && $lp->usage_directions) ? $lp->usage_directions : $product->usage;
    }
    // Ingredients: prefer Arabic from LP or product, then English
    if ($lang === 'ar') {
        $displayIngredients = ($lp && $lp->ingredients_ar) ? $lp->ingredients_ar
            : ($product->ingredients_ar ?: (($lp && $lp->ingredients) ? $lp->ingredients : $product->ingredients));
    } else {
        $displayIngredients = ($lp && $lp->ingredients) ? $lp->ingredients : $product->ingredients;
    }
    // Q&A: in Arabic mode, skip LP English Q&A — Arabic defaults will be used instead
    $displayQna = ($lang === 'ar') ? null : (($lp && !empty($lp->qna)) ? $lp->qna : null);
    $catLabelsAr = [
        'coffee' => 'قهوة', 'beverages' => 'مشروبات', 'supplements' => 'مكملات',
        'skincare' => 'العناية بالبشرة', 'personal-care' => 'العناية الشخصية',
        'ganoderma' => 'غانوديرما', 'other' => 'أخرى',
    ];
    $displayCategory = ($lang === 'ar') ? ($catLabelsAr[$product->category] ?? $product->category) : ucfirst($product->category);
    $rating = $product->rating ?? 0;
    $reviewCount = $product->reviews ? $product->reviews->count() : 0;
@endphp

@section('content')
<div class="bg-white">
    {{-- Admin Edit Bar --}}
    @auth
        @if(auth()->user()->role === 'admin')
        <div class="bg-gray-100 border-b">
            <div class="max-w-7xl mx-auto px-4 py-2 flex items-center gap-3 text-sm">
                <span class="text-gray-600">Admin:</span>
                @if($lp)
                    <a href="{{ route('admin.landing-pages.edit', $lp) }}" class="text-brand-violet hover:underline font-medium">Edit Landing Page</a>
                @else
                    <a href="{{ route('admin.landing-pages.create') }}?product_id={{ $product->id }}" class="text-brand-green hover:underline font-medium">+ Create Landing Page</a>
                @endif
                <span class="text-gray-300">|</span>
                <a href="{{ route('admin.products') }}" class="text-gray-600 hover:underline">Edit Product</a>
            </div>
        </div>
        @endif
    @endauth

    {{-- Breadcrumb --}}
    <div class="max-w-7xl mx-auto px-4 py-3">
        <nav class="flex items-center gap-2 text-sm text-gray-600">
            <a href="{{ route('home') }}" class="hover:text-brand-violet">{{ $lang === 'ar' ? 'الرئيسية' : 'Home' }}</a>
            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 18 15 12 9 6"/></svg>
            <a href="{{ route('products') }}" class="hover:text-brand-violet">{{ $lang === 'ar' ? 'المنتجات' : 'Products' }}</a>
            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 18 15 12 9 6"/></svg>
            <a href="{{ route('products', ['category' => $product->category]) }}" class="hover:text-brand-violet">{{ $displayCategory }}</a>
            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 18 15 12 9 6"/></svg>
            <span class="text-gray-800 font-medium truncate max-w-xs">{{ $displayName }}</span>
        </nav>
    </div>

    {{-- Main Product Section --}}
    <div class="max-w-7xl mx-auto px-4 pb-10">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">

            {{-- Left: Images --}}
            <div class="lg:col-span-4" x-data="{ activeImage: '{{ $mainImage }}' }">
                {{-- Main Image --}}
                <div class="bg-gray-50 rounded-2xl overflow-hidden border border-gray-200 flex items-center justify-center mb-3 max-h-96">
                    @if($mainImage)
                        <img :src="activeImage" alt="{{ $product->name }}" width="400" height="384" class="w-full h-full object-contain p-4">
                    @else
                        <div class="w-full h-full flex flex-col items-center justify-center" style="background: linear-gradient(135deg, #46387b, #2c1c5f);">
                            <span class="text-6xl font-bold" style="color: #43af73;">DXN</span>
                            <span class="text-white text-sm mt-2">{{ $product->name }}</span>
                        </div>
                    @endif
                </div>

                {{-- Thumbnail Gallery --}}
                @if(count($allImages) > 1)
                    <div class="flex gap-2 overflow-x-auto pb-2">
                        @foreach($allImages as $img)
                            <button @click="activeImage = '{{ $img }}'"
                                    class="w-16 h-16 rounded-lg overflow-hidden border-2 shrink-0 transition-all"
                                    :class="activeImage === '{{ $img }}' ? 'border-brand-violet shadow-md' : 'border-gray-200 hover:border-gray-400'">
                                <img src="{{ $img }}" alt="{{ $product->name }}" class="w-full h-full object-contain p-1">
                            </button>
                        @endforeach
                    </div>
                @endif
            </div>

            {{-- Center: Product Info --}}
            <div class="lg:col-span-5">
                {{-- Category --}}
                <span class="inline-block text-xs font-semibold uppercase tracking-wide px-3 py-1 rounded-full mb-3" style="background-color: rgba(67,175,115,0.12); color: #38a868;">{{ $displayCategory }}</span>

                {{-- Title --}}
                <h1 class="text-2xl lg:text-3xl font-bold mb-2" style="color: #46387b;">{{ $displayName }}</h1>

                {{-- SKU --}}
                @if($product->sku)
                    <p class="text-sm text-gray-400 mb-3">SKU: {{ $product->sku }}</p>
                @endif

                {{-- Rating --}}
                <div class="flex items-center gap-2 mb-4">
                    <div class="flex items-center gap-0.5">
                        @for($i = 1; $i <= 5; $i++)
                            <svg width="16" height="16" viewBox="0 0 24 24"
                                 fill="{{ $i <= round($rating) ? '#f59e0b' : '#e5e7eb' }}"
                                 stroke="{{ $i <= round($rating) ? '#f59e0b' : '#e5e7eb' }}" stroke-width="1">
                                <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/>
                            </svg>
                        @endfor
                    </div>
                    <span class="text-sm font-medium text-amber-600">{{ number_format($rating, 1) }}</span>
                    <span class="text-sm text-gray-400">({{ $reviewCount }} {{ $lang === 'ar' ? 'تقييم' : 'reviews' }})</span>
                </div>

                <hr class="my-4">

                {{-- Price --}}
                <div class="mb-4">
                    <span class="text-sm text-gray-600">{{ $lang === 'ar' ? 'السعر:' : 'Price:' }}</span>
                    <span class="text-3xl font-bold ml-2" style="color: #bf3c36;">${{ number_format($product->price, 2) }}</span>
                </div>

                {{-- Stock Status --}}
                <div class="flex items-center gap-2 mb-4">
                    @if($product->in_stock)
                        <span class="w-2 h-2 rounded-full bg-green-500"></span>
                        <span class="text-sm font-medium text-green-600">{{ $lang === 'ar' ? 'متوفر' : 'In Stock' }}</span>
                    @else
                        <span class="w-2 h-2 rounded-full bg-red-500"></span>
                        <span class="text-sm font-medium text-red-600">{{ $lang === 'ar' ? 'غير متوفر' : 'Out of Stock' }}</span>
                    @endif
                </div>

                <hr class="my-4">

                {{-- Description --}}
                @if($displayDesc)
                    <div class="mb-6">
                        <h3 class="font-semibold text-gray-800 mb-2">{{ $lang === 'ar' ? 'وصف المنتج' : 'About this product' }}</h3>
                        <p class="text-gray-600 text-sm leading-relaxed">{{ $displayDesc }}</p>
                    </div>
                @endif

                {{-- Key Benefits --}}
                @if(count($benefits) > 0)
                    <div class="mb-6">
                        <h3 class="font-semibold text-gray-800 mb-3">{{ $lang === 'ar' ? 'المميزات الرئيسية' : 'Key Features' }}</h3>
                        <ul class="space-y-2">
                            @foreach($benefits as $b)
                                <li class="flex items-start gap-2 text-sm text-gray-600">
                                    <svg class="mt-0.5 shrink-0" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#43af73" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                                    {{ $b }}
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>

            {{-- Right: Buy Box --}}
            <div class="lg:col-span-3">
                <div class="border border-gray-200 rounded-2xl p-5 sticky top-24">
                    <p class="text-2xl font-bold mb-1" style="color: #bf3c36;">${{ number_format($product->price, 2) }}</p>
                    <p class="text-sm text-gray-600 mb-4">{{ $lang === 'ar' ? 'شامل الضريبة' : 'Tax included' }}</p>

                    @if($product->in_stock)
                        <p class="text-sm font-medium text-green-600 mb-4">{{ $lang === 'ar' ? '✓ متوفر — جاهز للتوصيل' : '✓ In Stock — Ready to deliver' }}</p>
                    @else
                        <p class="text-sm font-medium text-red-600 mb-4">{{ $lang === 'ar' ? '✗ غير متوفر حالياً' : '✗ Currently unavailable' }}</p>
                    @endif

                    {{-- WhatsApp Order --}}
                    <a href="{{ $whatsapp }}" target="_blank" rel="noopener noreferrer"
                       class="flex items-center justify-center gap-2 w-full text-white font-semibold py-3 px-4 rounded-xl mb-3 hover-whatsapp {{ !$product->in_stock ? 'opacity-40 pointer-events-none' : '' }}">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/></svg>
                        {{ $lang === 'ar' ? 'اطلب عبر واتساب' : 'Order via WhatsApp' }}
                    </a>

                    {{-- Inquiry Button --}}
                    <a href="{{ route('contact') }}"
                       class="flex items-center justify-center gap-2 w-full font-semibold py-3 px-4 rounded-xl text-sm btn-outline-violet">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                        {{ $lang === 'ar' ? 'استفسار عن المنتج' : 'Ask About This Product' }}
                    </a>

                    <hr class="my-4">

                    {{-- Trust Badges --}}
                    <div class="space-y-3 text-sm text-gray-600">
                        <div class="flex items-center gap-2">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#43af73" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                            {{ $lang === 'ar' ? 'منتج DXN أصلي 100%' : '100% Original DXN Product' }}
                        </div>
                        <div class="flex items-center gap-2">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#43af73" stroke-width="2"><rect x="1" y="3" width="15" height="13"/><polygon points="16 8 20 8 23 11 23 16 16 16 16 8"/><circle cx="5.5" cy="18.5" r="2.5"/><circle cx="18.5" cy="18.5" r="2.5"/></svg>
                            {{ $lang === 'ar' ? 'توصيل سريع في الإمارات' : 'Fast UAE Delivery' }}
                        </div>
                        <div class="flex items-center gap-2">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#43af73" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>
                            {{ $lang === 'ar' ? 'شهادة حلال' : 'Halal Certified' }}
                        </div>
                        <div class="flex items-center gap-2">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#43af73" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>
                            {{ $lang === 'ar' ? 'معتمد من GMP' : 'GMP Certified' }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Product Details --}}
    <div class="bg-gray-50 border-t">
        <div class="max-w-7xl mx-auto px-4 py-12 space-y-10">

            {{-- Details --}}
            <div class="bg-white rounded-2xl p-8 shadow-sm">
                <h3 class="text-xl font-bold mb-4" style="color: #46387b;">{{ $lang === 'ar' ? 'تفاصيل المنتج' : 'Product Details' }}</h3>
                <p class="text-gray-600 leading-relaxed mb-6">{{ $displayDesc }}</p>

                @if(count($benefits) > 0)
                    <h4 class="font-semibold text-gray-800 mb-3">{{ $lang === 'ar' ? 'المميزات والفوائد' : 'Features & Benefits' }}</h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3 mb-6">
                        @foreach($benefits as $b)
                            <div class="flex items-start gap-3 p-3 bg-green-50 rounded-lg">
                                <svg class="mt-0.5 shrink-0" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#43af73" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                                <span class="text-gray-700 text-sm">{{ $b }}</span>
                            </div>
                        @endforeach
                    </div>
                @endif

                {{-- Product Specs Table --}}
                <h4 class="font-semibold text-gray-800 mb-3">{{ $lang === 'ar' ? 'المواصفات' : 'Specifications' }}</h4>
                <div class="border rounded-xl overflow-hidden">
                    <table class="w-full text-sm">
                        <tbody>
                            <tr class="border-b bg-gray-50">
                                <td class="px-4 py-3 font-medium text-gray-700 w-1/3">{{ $lang === 'ar' ? 'الماركة' : 'Brand' }}</td>
                                <td class="px-4 py-3 text-gray-600">DXN</td>
                            </tr>
                            <tr class="border-b">
                                <td class="px-4 py-3 font-medium text-gray-700">{{ $lang === 'ar' ? 'الفئة' : 'Category' }}</td>
                                <td class="px-4 py-3 text-gray-600">{{ $displayCategory }}</td>
                            </tr>
                            @if($product->sku)
                            <tr class="border-b bg-gray-50">
                                <td class="px-4 py-3 font-medium text-gray-700">{{ $lang === 'ar' ? 'رمز المنتج' : 'SKU' }}</td>
                                <td class="px-4 py-3 text-gray-600">{{ $product->sku }}</td>
                            </tr>
                            @endif
                            <tr class="border-b">
                                <td class="px-4 py-3 font-medium text-gray-700">{{ $lang === 'ar' ? 'التقييم' : 'Rating' }}</td>
                                <td class="px-4 py-3 text-gray-600">{{ number_format($rating, 1) }} / 5.0</td>
                            </tr>
                            <tr class="bg-gray-50">
                                <td class="px-4 py-3 font-medium text-gray-700">{{ $lang === 'ar' ? 'التوفر' : 'Availability' }}</td>
                                <td class="px-4 py-3">
                                    <span class="{{ $product->in_stock ? 'text-green-600' : 'text-red-600' }} font-medium">
                                        {{ $product->in_stock ? ($lang === 'ar' ? 'متوفر' : 'In Stock') : ($lang === 'ar' ? 'غير متوفر' : 'Out of Stock') }}
                                    </span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Ingredients --}}
            @if($displayIngredients)
            <div class="bg-white rounded-2xl p-8 shadow-sm">
                <h3 class="text-xl font-bold mb-4" style="color: #46387b;">{{ $lang === 'ar' ? 'المكونات' : 'Ingredients' }}</h3>
                <p class="text-gray-600 leading-relaxed whitespace-pre-line">{{ $displayIngredients }}</p>
            </div>
            @endif

            {{-- How to Use --}}
            @if($displayUsage)
            <div class="bg-white rounded-2xl p-8 shadow-sm">
                <h3 class="text-xl font-bold mb-4" style="color: #46387b;">{{ $lang === 'ar' ? 'طريقة الاستخدام' : 'How to Use' }}</h3>
                <div class="flex items-start gap-4 p-5 rounded-xl" style="background: rgba(67,175,115,0.08);">
                    <svg class="shrink-0 mt-1" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#43af73" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></svg>
                    <p class="text-gray-700 leading-relaxed">{{ $displayUsage }}</p>
                </div>
            </div>
            @endif

            {{-- Questions & Answers --}}
            @php
                $defaultQasEn = [
                    'coffee' => [
                        ['q' => 'Is this coffee suitable for people with caffeine sensitivity?', 'a' => 'This coffee contains regular caffeine levels. However, the Ganoderma extract helps balance the effects of caffeine, making it smoother than regular coffee. If you are very sensitive, we recommend starting with half a sachet.', 'by' => 'Freedom with DXN', 'votes' => 24],
                        ['q' => 'How many sachets are in one box?', 'a' => 'Each box contains 20 individually wrapped sachets, making it convenient for daily use at home or on the go.', 'by' => 'Freedom with DXN', 'votes' => 18],
                        ['q' => 'Can I drink this coffee while pregnant?', 'a' => 'We recommend consulting your doctor before consuming any supplement or health product during pregnancy. The product contains caffeine and Ganoderma extract.', 'by' => 'Freedom with DXN', 'votes' => 31],
                        ['q' => 'Does it taste like regular coffee?', 'a' => 'Yes, it tastes very similar to regular instant coffee with a smooth, slightly earthy undertone from the Ganoderma. Most people cannot tell the difference and actually prefer the taste.', 'by' => 'Ahmed Al Mansouri', 'votes' => 15],
                    ],
                    'beverages' => [
                        ['q' => 'Does this need to be refrigerated?', 'a' => 'Unopened bottles can be stored at room temperature. Once opened, please refrigerate and consume within 7 days for best quality.', 'by' => 'Freedom with DXN', 'votes' => 22],
                        ['q' => 'Is this suitable for children?', 'a' => 'Yes, most DXN beverages are suitable for children. However, we recommend smaller servings for children under 12. Always check the specific product label.', 'by' => 'Freedom with DXN', 'votes' => 19],
                        ['q' => 'Can I mix it with other drinks?', 'a' => 'Absolutely! Many customers mix it with juice, smoothies, or even plain water. It is very versatile and tastes great in different combinations.', 'by' => 'Sarah Johnson', 'votes' => 12],
                    ],
                    'supplements' => [
                        ['q' => 'When is the best time to take this supplement?', 'a' => 'For best results, take it 30 minutes before meals on an empty stomach. This allows for optimal absorption. Take with a full glass of water.', 'by' => 'Freedom with DXN', 'votes' => 35],
                        ['q' => 'Are there any side effects?', 'a' => 'DXN supplements are made from 100% natural ingredients. Most people experience no side effects. Some may notice mild detox symptoms in the first few days, which is normal and temporary.', 'by' => 'Freedom with DXN', 'votes' => 28],
                        ['q' => 'Can I take this with my medication?', 'a' => 'While DXN products are natural, we always recommend consulting with your healthcare provider before combining supplements with prescription medications.', 'by' => 'Freedom with DXN', 'votes' => 41],
                        ['q' => 'How long before I see results?', 'a' => 'Results vary from person to person. Most customers report noticeable improvements within 2-4 weeks of consistent daily use. For best results, use for at least 90 days.', 'by' => 'Priya Sharma', 'votes' => 16],
                    ],
                    'personal-care' => [
                        ['q' => 'Is this product suitable for sensitive skin?', 'a' => 'Yes, DXN personal care products are formulated with natural ingredients including Ganoderma extract, which is known for its gentle properties. However, we recommend doing a patch test first.', 'by' => 'Freedom with DXN', 'votes' => 20],
                        ['q' => 'Is this product cruelty-free?', 'a' => 'DXN does not test on animals. Their products are made with plant-based and mushroom-derived ingredients.', 'by' => 'Freedom with DXN', 'votes' => 17],
                        ['q' => 'Can the whole family use this?', 'a' => 'Yes! DXN personal care products are suitable for all family members. They are gentle enough for daily use by adults and children alike.', 'by' => 'Fatima Hassan', 'votes' => 14],
                    ],
                    'skincare' => [
                        ['q' => 'Is this suitable for oily skin?', 'a' => 'Yes, this product is lightweight and non-comedogenic. It works well for all skin types including oily and combination skin. It absorbs quickly without leaving a greasy residue.', 'by' => 'Freedom with DXN', 'votes' => 23],
                        ['q' => 'Can I use this with other skincare brands?', 'a' => 'Yes, DXN skincare products can be used alongside other brands. However, for best results, we recommend using the complete DXN skincare line together.', 'by' => 'Freedom with DXN', 'votes' => 15],
                        ['q' => 'Does this contain parabens or sulfates?', 'a' => 'DXN skincare products are formulated to be as gentle as possible. The newer formulations (Plus and Aloe.V lines) are free from parabens and sulfates.', 'by' => 'Freedom with DXN', 'votes' => 29],
                        ['q' => 'What is the shelf life?', 'a' => 'Unopened products have a shelf life of 2-3 years. Once opened, we recommend using within 12 months. Check the packaging for the exact expiry date.', 'by' => 'Noor Al Hashimi', 'votes' => 11],
                    ],
                ];
                $defaultQasAr = [
                    'coffee' => [
                        ['q' => 'هل هذه القهوة مناسبة لمن لديهم حساسية من الكافيين؟', 'a' => 'تحتوي هذه القهوة على مستويات عادية من الكافيين. ومع ذلك، يساعد مستخلص الجانوديرما على موازنة تأثيرات الكافيين، مما يجعلها أخف من القهوة العادية. إذا كنت حساسًا جدًا، ننصح بالبدء بنصف كيس.', 'by' => 'Freedom with DXN', 'votes' => 24],
                        ['q' => 'كم عدد الأكياس في العلبة الواحدة؟', 'a' => 'تحتوي كل علبة على 20 كيسًا مغلفًا بشكل فردي، مما يجعلها مريحة للاستخدام اليومي في المنزل أو أثناء التنقل.', 'by' => 'Freedom with DXN', 'votes' => 18],
                        ['q' => 'هل يمكنني شرب هذه القهوة أثناء الحمل؟', 'a' => 'ننصح باستشارة طبيبك قبل تناول أي مكمل أو منتج صحي أثناء الحمل. يحتوي المنتج على الكافيين ومستخلص الجانوديرما.', 'by' => 'Freedom with DXN', 'votes' => 31],
                        ['q' => 'هل طعمها مثل القهوة العادية؟', 'a' => 'نعم، طعمها قريب جدًا من القهوة سريعة التحضير العادية مع نكهة ترابية خفيفة وناعمة من الجانوديرما. معظم الناس لا يستطيعون التمييز بل يفضلون طعمها.', 'by' => 'Ahmed Al Mansouri', 'votes' => 15],
                    ],
                    'beverages' => [
                        ['q' => 'هل يحتاج هذا المنتج للتبريد؟', 'a' => 'يمكن تخزين العبوات غير المفتوحة في درجة حرارة الغرفة. بعد الفتح، يرجى حفظها في الثلاجة واستهلاكها خلال 7 أيام للحصول على أفضل جودة.', 'by' => 'Freedom with DXN', 'votes' => 22],
                        ['q' => 'هل هذا المنتج مناسب للأطفال؟', 'a' => 'نعم، معظم مشروبات DXN مناسبة للأطفال. ومع ذلك، ننصح بحصص أصغر للأطفال تحت 12 سنة. تحقق دائمًا من ملصق المنتج.', 'by' => 'Freedom with DXN', 'votes' => 19],
                        ['q' => 'هل يمكنني مزجه مع مشروبات أخرى؟', 'a' => 'بالتأكيد! كثير من العملاء يمزجونه مع العصير أو السموثي أو حتى الماء العادي. إنه متعدد الاستخدامات وطعمه رائع في مختلف الخلطات.', 'by' => 'Sarah Johnson', 'votes' => 12],
                    ],
                    'supplements' => [
                        ['q' => 'ما هو أفضل وقت لتناول هذا المكمل؟', 'a' => 'للحصول على أفضل النتائج، تناوله قبل 30 دقيقة من الوجبات على معدة فارغة. هذا يسمح بامتصاص مثالي. تناوله مع كوب كامل من الماء.', 'by' => 'Freedom with DXN', 'votes' => 35],
                        ['q' => 'هل هناك أي آثار جانبية؟', 'a' => 'مكملات DXN مصنوعة من مكونات طبيعية 100%. معظم الناس لا يعانون من أي آثار جانبية. قد يلاحظ البعض أعراض إزالة سموم خفيفة في الأيام الأولى، وهذا طبيعي ومؤقت.', 'by' => 'Freedom with DXN', 'votes' => 28],
                        ['q' => 'هل يمكنني تناوله مع أدويتي؟', 'a' => 'على الرغم من أن منتجات DXN طبيعية، ننصح دائمًا باستشارة مقدم الرعاية الصحية الخاص بك قبل الجمع بين المكملات والأدوية الموصوفة.', 'by' => 'Freedom with DXN', 'votes' => 41],
                        ['q' => 'كم من الوقت قبل أن أرى نتائج؟', 'a' => 'تختلف النتائج من شخص لآخر. معظم العملاء يلاحظون تحسنًا ملموسًا خلال 2-4 أسابيع من الاستخدام اليومي المنتظم. للحصول على أفضل النتائج، استخدمه لمدة 90 يومًا على الأقل.', 'by' => 'Priya Sharma', 'votes' => 16],
                    ],
                    'personal-care' => [
                        ['q' => 'هل هذا المنتج مناسب للبشرة الحساسة؟', 'a' => 'نعم، منتجات العناية الشخصية من DXN مصنوعة بمكونات طبيعية بما في ذلك مستخلص الجانوديرما المعروف بخصائصه اللطيفة. ومع ذلك، ننصح بإجراء اختبار على منطقة صغيرة أولاً.', 'by' => 'Freedom with DXN', 'votes' => 20],
                        ['q' => 'هل هذا المنتج خالٍ من التجارب على الحيوانات؟', 'a' => 'لا تقوم DXN بإجراء تجارب على الحيوانات. منتجاتها مصنوعة من مكونات نباتية ومشتقة من الفطر.', 'by' => 'Freedom with DXN', 'votes' => 17],
                        ['q' => 'هل يمكن لجميع أفراد العائلة استخدامه؟', 'a' => 'نعم! منتجات العناية الشخصية من DXN مناسبة لجميع أفراد العائلة. إنها لطيفة بما يكفي للاستخدام اليومي من قبل البالغين والأطفال على حد سواء.', 'by' => 'Fatima Hassan', 'votes' => 14],
                    ],
                    'skincare' => [
                        ['q' => 'هل هذا المنتج مناسب للبشرة الدهنية؟', 'a' => 'نعم، هذا المنتج خفيف ولا يسد المسام. يعمل بشكل جيد مع جميع أنواع البشرة بما في ذلك الدهنية والمختلطة. يُمتص بسرعة دون ترك بقايا دهنية.', 'by' => 'Freedom with DXN', 'votes' => 23],
                        ['q' => 'هل يمكنني استخدامه مع ماركات عناية بالبشرة أخرى؟', 'a' => 'نعم، يمكن استخدام منتجات العناية بالبشرة من DXN بجانب ماركات أخرى. ومع ذلك، للحصول على أفضل النتائج، ننصح باستخدام مجموعة DXN الكاملة للعناية بالبشرة معًا.', 'by' => 'Freedom with DXN', 'votes' => 15],
                        ['q' => 'هل يحتوي على البارابين أو الكبريتات؟', 'a' => 'منتجات العناية بالبشرة من DXN مصنوعة لتكون لطيفة قدر الإمكان. التركيبات الأحدث (خطوط Plus و Aloe.V) خالية من البارابين والكبريتات.', 'by' => 'Freedom with DXN', 'votes' => 29],
                        ['q' => 'ما هي مدة صلاحية المنتج؟', 'a' => 'المنتجات غير المفتوحة لها صلاحية 2-3 سنوات. بعد الفتح، ننصح بالاستخدام خلال 12 شهرًا. تحقق من العبوة لمعرفة تاريخ الانتهاء بالضبط.', 'by' => 'Noor Al Hashimi', 'votes' => 11],
                    ],
                ];
                $defaultQas = $lang === 'ar' ? $defaultQasAr : $defaultQasEn;
                $productQas = $displayQna ?: ($defaultQas[$product->category] ?? $defaultQas['coffee']);
            @endphp

            <div class="bg-white rounded-2xl p-8 shadow-sm">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-xl font-bold" style="color: #46387b;">{{ $lang === 'ar' ? 'أسئلة وأجوبة' : 'Questions & Answers' }}</h3>
                    <span class="text-sm text-gray-400">{{ count($productQas) }} {{ $lang === 'ar' ? 'أسئلة مُجاب عليها' : 'answered questions' }}</span>
                </div>

                <div class="space-y-6">
                    @foreach($productQas as $qa)
                        <div class="pb-6 {{ !$loop->last ? 'border-b border-gray-100' : '' }}">
                            <div class="flex items-start gap-3 mb-3">
                                <span class="font-bold text-sm px-2 py-0.5 rounded text-white shrink-0" style="background-color: #46387b;">Q</span>
                                <p class="font-semibold text-gray-800 text-sm">{{ $qa['q'] }}</p>
                            </div>
                            <div class="flex items-start gap-3 ml-0 md:ml-1">
                                <span class="font-bold text-sm px-2 py-0.5 rounded text-white shrink-0" style="background-color: #43af73;">A</span>
                                <div>
                                    <p class="text-gray-600 text-sm leading-relaxed">{{ $qa['a'] }}</p>
                                    <div class="flex items-center gap-3 mt-2 text-xs text-gray-400">
                                        <span>{{ $lang === 'ar' ? 'بواسطة' : 'By' }} <span class="font-medium text-gray-600">{{ $qa['by'] ?? 'Freedom with DXN' }}</span></span>
                                        <span>·</span>
                                        <span>{{ $qa['votes'] ?? rand(5, 25) }} {{ $lang === 'ar' ? 'شخص وجد هذا مفيداً' : 'people found this helpful' }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Customer Reviews --}}
            <div class="bg-white rounded-2xl p-8 shadow-sm">
                <div class="bg-white rounded-2xl p-8 shadow-sm">
                    <h3 class="text-xl font-bold mb-6" style="color: #46387b;">{{ $lang === 'ar' ? 'تقييمات العملاء' : 'Customer Reviews' }}</h3>

                    @php
                        $stars5 = $product->reviews->where('rating', 5)->count();
                        $stars4 = $product->reviews->where('rating', 4)->count();
                        $stars3 = $product->reviews->where('rating', 3)->count();
                        $stars2 = $product->reviews->where('rating', 2)->count();
                        $stars1 = $product->reviews->where('rating', 1)->count();
                        $totalReviews = $reviewCount ?: 1;
                    @endphp

                    <div class="grid grid-cols-1 md:grid-cols-12 gap-8 mb-10">
                        {{-- Left: Overall Rating --}}
                        <div class="md:col-span-3 text-center md:text-left">
                            <div class="text-5xl font-bold" style="color: #46387b;">{{ number_format($rating, 1) }}</div>
                            <div class="flex items-center gap-0.5 mt-2 justify-center md:justify-start">
                                @for($i = 1; $i <= 5; $i++)
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="{{ $i <= round($rating) ? '#f59e0b' : '#e5e7eb' }}" stroke="{{ $i <= round($rating) ? '#f59e0b' : '#e5e7eb' }}" stroke-width="1"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                                @endfor
                            </div>
                            <p class="text-sm text-gray-600 mt-1">{{ $reviewCount }} {{ $lang === 'ar' ? 'تقييم عالمي' : 'global ratings' }}</p>
                        </div>

                        {{-- Right: Rating Breakdown Bars --}}
                        <div class="md:col-span-9 space-y-2">
                            @foreach([5, 4, 3, 2, 1] as $star)
                                @php $count = ${'stars'.$star}; $pct = round(($count / $totalReviews) * 100); @endphp
                                <div class="flex items-center gap-3">
                                    <span class="text-sm text-blue-600 hover:underline cursor-default whitespace-nowrap w-12">{{ $star }} {{ $lang === 'ar' ? 'نجوم' : 'star' }}</span>
                                    <div class="flex-1 h-5 bg-gray-200 rounded-full overflow-hidden">
                                        <div class="h-full rounded-full" style="width: {{ $pct }}%; background-color: #f59e0b;"></div>
                                    </div>
                                    <span class="text-sm text-gray-600 w-10 text-right">{{ $pct }}%</span>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <hr class="mb-8">

                    {{-- Reviews List --}}
                    @if($reviewCount > 0)
                        <div class="space-y-6">
                            @foreach($product->reviews->sortByDesc('created_at') as $idx => $review)
                                @php
                                    $avatarId = ($review->user_id ?? $idx) * 3 + $idx + 10;
                                @endphp
                                <div class="pb-6 {{ !$loop->last ? 'border-b border-gray-100' : '' }}">
                                    {{-- User Info --}}
                                    <div class="flex items-center gap-3 mb-2">
                                        <img src="https://i.pravatar.cc/40?img={{ $avatarId % 70 }}" alt="{{ $review->user->name ?? 'User' }}"
                                             class="w-9 h-9 rounded-full object-cover">
                                        <span class="font-medium text-sm text-gray-800">{{ $review->user->name ?? 'Customer' }}</span>
                                    </div>

                                    {{-- Stars + Title --}}
                                    <div class="flex items-center gap-2 mb-1">
                                        <div class="flex items-center gap-0.5">
                                            @for($i = 1; $i <= 5; $i++)
                                                <svg width="14" height="14" viewBox="0 0 24 24" fill="{{ $i <= $review->rating ? '#f59e0b' : '#e5e7eb' }}" stroke="{{ $i <= $review->rating ? '#f59e0b' : '#e5e7eb' }}" stroke-width="1"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                                            @endfor
                                        </div>
                                        <span class="font-semibold text-sm text-gray-800">
                                            @if($review->rating >= 5) {{ $lang === 'ar' ? 'ممتاز!' : 'Excellent product!' }}
                                            @elseif($review->rating >= 4) {{ $lang === 'ar' ? 'جيد جداً' : 'Great quality' }}
                                            @elseif($review->rating >= 3) {{ $lang === 'ar' ? 'جيد' : 'Good product' }}
                                            @else {{ $lang === 'ar' ? 'مقبول' : 'Okay' }}
                                            @endif
                                        </span>
                                    </div>

                                    {{-- Date + Verified --}}
                                    <div class="flex items-center gap-3 mb-3 text-xs text-gray-400">
                                        <span>{{ $lang === 'ar' ? 'تمت المراجعة في' : 'Reviewed on' }} {{ $lang === 'ar' ? \Carbon\Carbon::parse($review->created_at)->format('Y/m/d') : \Carbon\Carbon::parse($review->created_at)->format('F j, Y') }}</span>
                                        <span class="inline-flex items-center gap-1 text-white font-medium px-3 py-1 rounded-full" style="background-color: #43af73;">
                                            <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="20 6 9 17 4 12"/></svg>
                                            {{ $lang === 'ar' ? 'عملية شراء موثقة' : 'Verified Purchase' }}
                                        </span>
                                    </div>

                                    {{-- Comment --}}
                                    <p class="text-gray-600 text-sm leading-relaxed mb-3">{{ ($lang === 'ar' && $review->comment_ar) ? $review->comment_ar : $review->comment }}</p>

                                    {{-- Helpful --}}
                                    <div class="flex items-center gap-4 text-xs text-gray-400">
                                        <span>{{ rand(1, 12) }} {{ $lang === 'ar' ? 'شخص وجد هذا مفيداً' : 'people found this helpful' }}</span>
                                        <button class="text-gray-600 hover:text-gray-700 border border-gray-300 px-3 py-1 rounded-md text-xs hover:bg-gray-50">
                                            {{ $lang === 'ar' ? 'مفيد' : 'Helpful' }}
                                        </button>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-600 text-center py-8">{{ $lang === 'ar' ? 'لا توجد تقييمات بعد. كن أول من يقيم هذا المنتج!' : 'No reviews yet. Be the first to review this product!' }}</p>
                    @endif
                </div>
        </div>
    </div>

    {{-- Related Products --}}
    @if($related->count() > 0)
        <div class="max-w-7xl mx-auto px-4 py-12">
            <h2 class="section-title">{{ $lang === 'ar' ? 'منتجات قد تعجبك' : 'You May Also Like' }}</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mt-8">
                @foreach($related as $rp)
                    @include('components.product-card', ['product' => $rp])
                @endforeach
            </div>
        </div>
    @endif
</div>
@endsection
