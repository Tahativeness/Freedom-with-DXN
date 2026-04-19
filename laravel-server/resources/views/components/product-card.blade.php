@props(['product'])

@php
    $lang = session('lang', 'en');
    $mainImage = $product->landing_image ?: ($product->image ?: '');
    $link = route('products.show', $product);
    $whatsapp = 'https://wa.me/971555574958';
    $rating = $product->rating ?? 0;
    $displayName = ($lang === 'ar' && $product->name_ar) ? $product->name_ar : $product->name;
    $catLabelsAr = [
        'coffee' => 'قهوة', 'beverages' => 'مشروبات', 'supplements' => 'مكملات',
        'skincare' => 'العناية بالبشرة', 'personal-care' => 'العناية الشخصية',
        'ganoderma' => 'غانوديرما', 'other' => 'أخرى',
    ];
    $displayCategory = ($lang === 'ar') ? ($catLabelsAr[$product->category] ?? $product->category) : $product->category;

    // Arabic numeral converter
    $toAr = function($num) use ($lang) {
        if ($lang !== 'ar') return $num;
        $arabic = ['٠','١','٢','٣','٤','٥','٦','٧','٨','٩'];
        return str_replace(range('0','9'), $arabic, $num);
    };

    $displayPrice = $lang === 'ar'
        ? $toAr(number_format($product->price, 2)) . ' $'
        : '$' . number_format($product->price, 2);
    $displayRating = $toAr(number_format($rating, 1));

    // Hover content: benefits (Arabic if available) with description fallback
    $hoverBenefits = ($lang === 'ar' && !empty($product->benefits_ar))
        ? $product->benefits_ar
        : (is_array($product->benefits) ? $product->benefits : []);
    $hoverDesc = ($lang === 'ar' && $product->description_ar) ? $product->description_ar : $product->description;
@endphp

<article class="group bg-white rounded-2xl overflow-hidden transition-all duration-300 flex flex-col h-full product-card-hover">

    <a href="{{ $link }}" class="block flex-1 flex flex-col" aria-label="{{ $displayName }} - {{ $displayPrice }}">
        {{-- Image --}}
        <div class="relative overflow-hidden bg-gray-50" style="height: 13rem;">
            @if($mainImage)
                <img src="{{ $mainImage }}" alt="{{ $product->name }}" loading="lazy" decoding="async" width="300" height="208"
                     class="w-full object-contain p-2 group-hover:scale-105 transition-transform duration-500" style="height: 13rem;">
            @else
                <div class="w-full flex flex-col items-center justify-center" style="height: 13rem; background: linear-gradient(135deg, #452aa8, #3a2290);" aria-hidden="true">
                    <span class="text-3xl font-bold" style="color: #43af73;">DXN</span>
                    <span class="text-white text-xs mt-1 px-4 text-center line-clamp-2">{{ $product->name }}</span>
                </div>
            @endif

            {{-- Hover overlay: benefits / description --}}
            @if($product->in_stock && (count($hoverBenefits) > 0 || $hoverDesc))
                <div class="absolute inset-0 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex flex-col justify-center p-3 pointer-events-none z-10"
                     style="background: rgba(0,0,0,0.75);">
                    @if(count($hoverBenefits) > 0)
                        <p class="text-xs font-bold uppercase tracking-wide mb-1.5" style="color: #f1d47f;">{{ $lang === 'ar' ? 'الفوائد' : 'Key Benefits' }}</p>
                        <ul class="text-white text-xs space-y-1">
                            @foreach(array_slice($hoverBenefits, 0, 3) as $b)
                                <li class="flex items-start gap-1.5">
                                    <svg class="mt-0.5 shrink-0" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="#43af73" stroke-width="3" aria-hidden="true"><polyline points="20 6 9 17 4 12"/></svg>
                                    <span class="line-clamp-2 leading-snug">{{ $b }}</span>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p class="text-white text-xs leading-relaxed line-clamp-5">{{ \Illuminate\Support\Str::limit(strip_tags($hoverDesc), 200) }}</p>
                    @endif
                </div>
            @endif

            @if($product->featured || $product->bestseller)
                <span class="absolute top-3 left-3 text-white text-xs font-bold px-3 py-1 rounded-full shadow-md flex items-center gap-1 whitespace-nowrap z-20" style="background-color: #bf3c36;">
                    <svg style="width: 12px; height: 12px; min-width: 12px;" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                    {{ $lang === 'ar' ? 'الأكثر مبيعاً' : 'Best Seller' }}
                </span>
            @endif

            @if(!$product->in_stock)
                <div class="absolute inset-0 bg-black/60 flex items-center justify-center">
                    <span class="bg-white/90 text-red-600 font-bold text-sm px-4 py-1.5 rounded-full">{{ $lang === 'ar' ? 'غير متوفر' : 'Out of Stock' }}</span>
                </div>
            @endif
        </div>

        {{-- Info --}}
        <div class="px-4 pt-3 flex-1 flex flex-col">
            <span class="inline-block text-xs font-semibold uppercase tracking-wide px-2 py-0.5 rounded-full w-fit" style="background-color: rgba(49,140,90,0.1); color: #1e6b42;">{{ $displayCategory }}</span>
            <h3 class="text-sm font-bold mt-2 mb-2 line-clamp-2 leading-snug group-hover:text-brand-green transition-colors" style="color: #452aa8; min-height: 2.5rem;">{{ $displayName }}</h3>

            {{-- Rating + Price pushed to bottom --}}
            <div class="mt-auto"></div>
            @if($rating > 0)
                <div class="flex items-center gap-0.5 mb-2" aria-label="{{ $lang === 'ar' ? 'التقييم: ' . number_format($rating, 1) . ' من 5' : 'Rating: ' . number_format($rating, 1) . ' out of 5' }}">
                    <svg style="width: 12px; height: 12px; min-width: 12px; color: #bf3c36;" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                    <span class="text-xs text-gray-600">{{ $displayRating }}</span>
                </div>
            @endif

            <span class="text-xl font-bold" style="color: #236b43;">{{ $displayPrice }}</span>
        </div>
    </a>

    {{-- Action Buttons --}}
    <div class="px-4 pt-2 pb-4 space-y-2">
        {{-- Add to Cart --}}
        <form method="POST" action="{{ route('cart.add') }}">
            @csrf
            <input type="hidden" name="product_id" value="{{ $product->id }}">
            <input type="hidden" name="quantity" value="1">
            <button type="submit"
                    class="flex items-center justify-center gap-2 w-full text-white text-sm font-semibold py-2.5 rounded-xl transition-all {{ !$product->in_stock ? 'opacity-40 pointer-events-none cursor-not-allowed' : 'hover:shadow-md' }}"
                    style="background-color: {{ $product->in_stock ? '#452aa8' : '#9ca3af' }};"
                    @if(!$product->in_stock) disabled aria-disabled="true" @endif>
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>
                {{ $lang === 'ar' ? 'أضف إلى السلة' : 'Add to Cart' }}
            </button>
        </form>

        {{-- WhatsApp Order --}}
        <a href="{{ $whatsapp }}" target="_blank" rel="noopener noreferrer"
           class="block w-full text-center text-white text-sm font-semibold py-2.5 rounded-xl hover-green {{ !$product->in_stock ? 'opacity-40 pointer-events-none' : '' }}"
           @if(!$product->in_stock) aria-disabled="true" tabindex="-1" @endif>
            {{ $lang === 'ar' ? 'اطلب عبر واتساب' : 'Order via WhatsApp' }}
        </a>
    </div>

</article>
