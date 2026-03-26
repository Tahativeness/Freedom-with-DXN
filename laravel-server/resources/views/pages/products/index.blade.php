@extends('layouts.app')
@section('title', 'Products - Freedom with DXN')

@php
    $lang = session('lang', 'en');
    $currentCategory = request('category', 'all');
    $currentSort = request('sort', 'default');
    $currentSearch = request('search', '');
    $catLabels = [
        'all' => 'All Products', 'coffee' => 'Coffee', 'beverages' => 'Beverages',
        'supplements' => 'Supplements', 'personal-care' => 'Personal Care',
        'skincare' => 'Skin Care', 'ganoderma' => 'Ganoderma', 'other' => 'Other',
    ];
    $catLabelsAr = [
        'all' => 'جميع المنتجات', 'coffee' => 'قهوة', 'beverages' => 'مشروبات',
        'supplements' => 'مكملات', 'personal-care' => 'العناية الشخصية',
        'skincare' => 'العناية بالبشرة', 'ganoderma' => 'غانوديرما', 'other' => 'أخرى',
    ];
    $catIcons = [
        'all' => '🌿', 'coffee' => '☕', 'beverages' => '🧃', 'supplements' => '💊',
        'personal-care' => '🧴', 'skincare' => '✨', 'ganoderma' => '🍄', 'other' => '📦',
    ];
@endphp

@section('content')

{{-- Hero Header --}}
<div class="py-16 px-4 relative overflow-hidden" style="background-color: #452aa8;">
    <div class="absolute top-0 right-0 w-64 h-64 rounded-full -translate-y-1/2 translate-x-1/2" style="background: rgba(67,175,115,0.08);"></div>
    <div class="absolute bottom-0 left-0 w-48 h-48 rounded-full translate-y-1/2 -translate-x-1/2" style="background: rgba(67,175,115,0.08);"></div>

    <div class="max-w-7xl mx-auto text-center relative z-10">
        <span class="inline-block bg-white/15 text-white px-5 py-1.5 rounded-full text-sm font-semibold mb-4 border border-white/20">
            {{ $lang === 'ar' ? 'منتجات DXN الرسمية' : 'Official DXN Products' }}
        </span>
        <h1 class="text-3xl md:text-5xl font-extrabold text-white mb-3">
            {{ $lang === 'ar' ? 'كتالوج منتجات DXN' : 'DXN Product Catalog' }}
        </h1>
        <p class="text-white/70 text-lg">
            {{ $lang === 'ar' ? 'منتجات صحية فاخرة مدعومة بفطر غانوديرما لوسيدوم' : 'Premium health products powered by Ganoderma Lucidum' }}
        </p>
    </div>
</div>

{{-- Category Tabs --}}
<div class="bg-white border-b shadow-sm">
    <div class="max-w-7xl mx-auto px-4">
        <div class="flex items-center gap-1.5 overflow-x-auto py-3 scrollbar-hide">
            @foreach($categories as $cat)
                <a href="{{ route('products', array_merge(request()->query(), ['category' => $cat, 'page' => 1])) }}"
                   class="flex items-center gap-1.5 px-4 py-2 rounded-full text-sm font-semibold whitespace-nowrap transition-all duration-200 {{ $currentCategory === $cat ? 'text-white shadow-md' : 'text-brand-violet border border-gray-200 hover:bg-[#e8f5ee]' }}"
                   style="{{ $currentCategory === $cat ? 'background-color: #43af73;' : '' }}">
                    <span>{{ $catIcons[$cat] ?? '📦' }}</span>
                    {{ $lang === 'ar' ? ($catLabelsAr[$cat] ?? $cat) : ($catLabels[$cat] ?? ucfirst($cat)) }}
                </a>
            @endforeach
        </div>
    </div>
</div>

{{-- Products Section --}}
<div class="bg-gray-50 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 py-10">

        {{-- Section Heading --}}
        <div class="text-center mb-8">
            <h2 class="text-2xl md:text-3xl font-extrabold inline-block" style="color: #452aa8;">
                {{ $catIcons[$currentCategory] ?? '🌿' }}
                {{ $lang === 'ar' ? ($catLabelsAr[$currentCategory] ?? 'جميع المنتجات') : ($catLabels[$currentCategory] ?? 'All Products') }}
            </h2>
            <div class="w-16 h-1 mx-auto mt-2 rounded-full" style="background: linear-gradient(90deg, #43af73, #5bc48a);"></div>
            <p class="text-gray-500 text-sm mt-2">{{ $products->total() }} {{ $lang === 'ar' ? 'منتج' : 'products' }}</p>
        </div>

        {{-- Search + Sort --}}
        <div class="flex flex-col md:flex-row gap-3 mb-8">
            <form method="GET" action="{{ route('products') }}" class="flex-1 flex gap-2">
                @if($currentCategory !== 'all')
                    <input type="hidden" name="category" value="{{ $currentCategory }}">
                @endif
                <input type="hidden" name="sort" value="{{ $currentSort }}">
                <div class="relative flex-1">
                    <svg class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                    <input type="text" name="search" value="{{ $currentSearch }}"
                           placeholder="{{ $lang === 'ar' ? 'ابحث عن منتج...' : 'Search products...' }}"
                           class="w-full pl-10 pr-4 py-2.5 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-brand-green/50 focus:border-brand-green bg-white transition-all">
                </div>
                <button type="submit" class="text-white px-5 py-2.5 rounded-xl font-semibold transition-colors" style="background-color: #43af73;" onmouseenter="this.style.backgroundColor='#369a60'" onmouseleave="this.style.backgroundColor='#43af73'">
                    {{ $lang === 'ar' ? 'بحث' : 'Search' }}
                </button>
            </form>

            <select onchange="window.location.href='{{ route('products') }}?category={{ $currentCategory }}&search={{ $currentSearch }}&sort='+this.value"
                    class="border border-gray-200 rounded-xl px-3 py-2.5 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-brand-green/50 focus:border-brand-green">
                <option value="default" {{ $currentSort === 'default' ? 'selected' : '' }}>{{ $lang === 'ar' ? 'افتراضي' : 'Default' }}</option>
                <option value="price-low" {{ $currentSort === 'price-low' ? 'selected' : '' }}>{{ $lang === 'ar' ? 'السعر: من الأقل' : 'Price: Low → High' }}</option>
                <option value="price-high" {{ $currentSort === 'price-high' ? 'selected' : '' }}>{{ $lang === 'ar' ? 'السعر: من الأعلى' : 'Price: High → Low' }}</option>
                <option value="rating" {{ $currentSort === 'rating' ? 'selected' : '' }}>{{ $lang === 'ar' ? 'الأعلى تقييماً' : 'Top Rated' }}</option>
                <option value="name" {{ $currentSort === 'name' ? 'selected' : '' }}>{{ $lang === 'ar' ? 'الاسم أ → ي' : 'Name A → Z' }}</option>
            </select>
        </div>

        {{-- Product Grid --}}
        @if($products->count() > 0)
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 md:gap-6">
                @foreach($products as $index => $product)
                    <div class="opacity-0 animate-fade-in h-full" style="animation-delay: {{ $index * 50 }}ms">
                        @include('components.product-card', ['product' => $product])
                    </div>
                @endforeach
            </div>

            <div class="mt-12">
                {{ $products->links() }}
            </div>
        @else
            <div class="text-center py-24">
                <div class="text-6xl mb-4">🔍</div>
                <p class="text-xl font-bold" style="color: #452aa8;">{{ $lang === 'ar' ? 'لم يتم العثور على منتجات' : 'No products found' }}</p>
                <p class="text-gray-500 text-sm mt-2">{{ $lang === 'ar' ? 'جرب فئة أو كلمة بحث مختلفة' : 'Try a different category or search term' }}</p>
                <a href="{{ route('products') }}" class="mt-5 inline-block text-white px-6 py-2.5 rounded-xl font-semibold transition-colors" style="background-color: #43af73;">
                    {{ $lang === 'ar' ? 'عرض جميع المنتجات' : 'View All Products' }}
                </a>
            </div>
        @endif
    </div>
</div>

@endsection

@push('styles')
<style>
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-fade-in {
        animation: fadeInUp 0.5s ease-out forwards;
    }
    .scrollbar-hide::-webkit-scrollbar { display: none; }
    .scrollbar-hide { -ms-overflow-style: none; scrollbar-width: none; }
</style>
@endpush
