@extends('layouts.app')
@section('title', $product->name . ' - Freedom with DXN')

@php
    $lang = session('lang', 'en');
    $whatsapp = 'https://wa.me/+971506662875';
    $mainImage = $product->landing_image ?: ($product->image ?: '');
    $images = is_array($product->images) ? $product->images : [];
    $benefits = ($lang === 'ar' && $product->benefits_ar) ? $product->benefits_ar : (is_array($product->benefits) ? $product->benefits : []);
    $displayName = ($lang === 'ar' && $product->name_ar) ? $product->name_ar : $product->name;
    $displayDesc = ($lang === 'ar' && $product->description_ar) ? $product->description_ar : $product->description;
    $displayUsage = ($lang === 'ar' && $product->usage_ar) ? $product->usage_ar : $product->usage;
    $catLabelsAr = [
        'coffee' => 'قهوة', 'beverages' => 'مشروبات', 'supplements' => 'مكملات',
        'skincare' => 'العناية بالبشرة', 'personal-care' => 'العناية الشخصية',
        'ganoderma' => 'غانوديرما', 'other' => 'أخرى',
    ];
    $displayCategory = ($lang === 'ar') ? ($catLabelsAr[$product->category] ?? $product->category) : $product->category;
@endphp

@section('content')
<div class="min-h-screen bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 py-10">
        <a href="{{ route('products') }}" class="inline-flex items-center gap-2 text-dxn-green hover:text-dxn-darkgreen mb-6">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
            {{ $lang === 'ar' ? 'العودة للمنتجات' : 'Back to Products' }}
        </a>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-10 bg-white rounded-2xl shadow-lg overflow-hidden p-8">
            {{-- Image --}}
            <div>
                <div class="bg-gray-100 rounded-xl overflow-hidden aspect-square mb-3">
                    @if($mainImage)
                        <img src="{{ $mainImage }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full bg-gradient-to-br from-dxn-green to-dxn-darkgreen flex items-center justify-center">
                            <span class="text-dxn-gold text-6xl font-bold">DXN</span>
                        </div>
                    @endif
                </div>
                @if(count($images) > 0)
                    <div class="grid grid-cols-5 gap-2">
                        @foreach($images as $img)
                            <div class="aspect-square rounded-lg overflow-hidden border-2 border-gray-200">
                                <img src="{{ $img }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            {{-- Info --}}
            <div>
                <span class="text-sm text-dxn-gold font-semibold uppercase tracking-widest">{{ $displayCategory }}</span>
                <h1 class="text-3xl font-bold text-dxn-darkgreen mt-2 mb-3">{{ $displayName }}</h1>

                <div class="flex items-center gap-2 mb-4">
                    @for($i = 0; $i < 5; $i++)
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"
                             fill="{{ $i < round($product->rating ?? 0) ? '#facc15' : 'none' }}"
                             stroke="{{ $i < round($product->rating ?? 0) ? '#facc15' : '#d1d5db' }}" stroke-width="2">
                            <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/>
                        </svg>
                    @endfor
                </div>

                <p class="text-3xl font-bold text-dxn-green mb-4">${{ number_format($product->price, 2) }}</p>
                <p class="text-gray-600 mb-6">{{ $displayDesc }}</p>

                @if(count($benefits) > 0)
                    <div class="mb-6">
                        <h3 class="font-semibold text-gray-800 mb-3">{{ $lang === 'ar' ? 'الفوائد الرئيسية' : 'Key Benefits' }}</h3>
                        <ul class="space-y-2">
                            @foreach($benefits as $b)
                                <li class="flex items-center gap-2 text-gray-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#16392d" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>
                                    {{ $b }}
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if($displayUsage)
                    <div class="mb-6 p-4 bg-green-50 rounded-lg">
                        <h3 class="font-semibold text-gray-800 mb-1">{{ $lang === 'ar' ? 'طريقة الاستخدام' : 'How to Use' }}</h3>
                        <p class="text-gray-600 text-sm">{{ $displayUsage }}</p>
                    </div>
                @endif

                <a href="{{ $whatsapp }}" target="_blank"
                   class="w-full flex items-center justify-center gap-3 bg-[#dfc378] hover:bg-[#dcca8b] text-[#16392d] font-bold py-4 px-6 rounded-xl text-lg transition-colors shadow-lg {{ !$product->in_stock ? 'opacity-50 pointer-events-none' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"/></svg>
                    {{ $product->in_stock ? ($lang === 'ar' ? 'اطلب عبر واتساب' : 'Order via WhatsApp') : ($lang === 'ar' ? 'غير متوفر' : 'Out of Stock') }}
                </a>
            </div>
        </div>

        {{-- Related Products --}}
        @if($related->count() > 0)
            <div class="mt-16">
                <h2 class="section-title">{{ $lang === 'ar' ? 'منتجات مشابهة' : 'Related Products' }}</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mt-8">
                    @foreach($related as $product)
                        @include('components.product-card', ['product' => $product])
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
