@php $lang = session('lang', 'en'); $isAr = $lang === 'ar'; @endphp

{{-- Mini-Cart Popover — drops down from the cart icon --}}
<div x-show="$store.cart.open"
     x-transition:enter="transition ease-out duration-200"
     x-transition:enter-start="opacity-0 scale-95 -translate-y-2"
     x-transition:enter-end="opacity-100 scale-100 translate-y-0"
     x-transition:leave="transition ease-in duration-150"
     x-transition:leave-start="opacity-100 scale-100 translate-y-0"
     x-transition:leave-end="opacity-0 scale-95 -translate-y-2"
     @keydown.escape.window="$store.cart.open = false"
     class="fixed top-16 sm:top-20 lg:top-28 {{ $isAr ? 'left-4' : 'right-4' }} mt-2 w-[22rem] max-w-[calc(100vw-2rem)] z-[70] origin-top-{{ $isAr ? 'left' : 'right' }}"
     style="display: none;"
     role="dialog"
     aria-label="{{ $isAr ? 'عربة التسوق' : 'Shopping cart' }}">

    {{-- Card --}}
    <div class="overflow-hidden rounded-2xl shadow-2xl border border-gray-100 bg-white">

    {{-- Header --}}
    <div class="flex items-center justify-between px-4 py-3" style="background-color: #46387b;">
        <h2 class="text-sm font-bold text-white flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                <circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/>
            </svg>
            {{ $isAr ? 'عربة التسوق' : 'Your Cart' }}
            <span x-text="'(' + $store.cart.count + ')'" class="text-xs opacity-80 font-semibold"></span>
        </h2>
        <button type="button" @click="$store.cart.open = false" aria-label="{{ $isAr ? 'إغلاق' : 'Close' }}" class="text-white/80 hover:text-white p-1 -mr-1">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
        </button>
    </div>

    {{-- Added banner --}}
    <div x-show="$store.cart.justAdded"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 -translate-y-2"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 -translate-y-2"
         class="flex items-center gap-2 px-4 py-2.5 text-sm font-semibold"
         style="background-color: #edfaf3; color: #43af73; display: none;">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#43af73" stroke-width="2.5" aria-hidden="true"><polyline points="20 6 9 17 4 12"/></svg>
        {{ $isAr ? '✓ تمت الإضافة إلى السلة!' : '✓ Added to cart!' }}
    </div>

    {{-- Items --}}
    <div class="max-h-[18rem] overflow-y-auto px-4 py-2">
        <template x-if="$store.cart.items.length === 0">
            <div class="text-center py-8 text-gray-500">
                <div class="text-4xl mb-2">🛒</div>
                <p class="text-sm font-medium">{{ $isAr ? 'عربتك فارغة' : 'Your cart is empty' }}</p>
                <a href="{{ route('products') }}" class="inline-block mt-3 text-xs font-semibold" style="color: #46387b;">{{ $isAr ? 'تصفح المنتجات ←' : '→ Browse products' }}</a>
            </div>
        </template>

        <template x-for="item in $store.cart.items" :key="item.id">
            <div class="flex gap-3 py-3 border-b border-gray-100 last:border-0">
                <div class="w-12 h-12 shrink-0 rounded-lg bg-gray-50 overflow-hidden flex items-center justify-center">
                    <img :src="item.image" :alt="item.name" class="w-full h-full object-contain p-1" x-show="item.image">
                </div>
                <div class="flex-1 min-w-0">
                    <h3 class="text-xs font-semibold text-gray-800 line-clamp-2 leading-snug" x-text="item.name"></h3>
                    <p class="text-[11px] text-gray-500 mt-0.5">
                        <span x-text="item.quantity"></span> × $<span x-text="item.price.toFixed(2)"></span>
                    </p>
                </div>
                <div class="flex flex-col items-end justify-between shrink-0">
                    <button type="button" @click="$store.cart.remove(item.id)" aria-label="{{ $isAr ? 'إزالة' : 'Remove' }}" class="text-gray-300 hover:text-red-600 transition-colors p-0.5">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
                    </button>
                    <p class="text-sm font-bold whitespace-nowrap" style="color: #43af73;">$<span x-text="item.subtotal.toFixed(2)"></span></p>
                </div>
            </div>
        </template>
    </div>

    {{-- Footer --}}
    <div x-show="$store.cart.items.length > 0" class="border-t border-gray-100 px-4 py-3 space-y-2 bg-gray-50 rounded-b-2xl">
        <div class="flex items-center justify-between text-sm font-semibold">
            <span class="text-gray-700">{{ $isAr ? 'المجموع' : 'Subtotal' }}</span>
            <span class="text-base font-bold" style="color: #43af73;">$<span x-text="$store.cart.total.toFixed(2)"></span></span>
        </div>
        <a href="{{ route('checkout') }}" class="block w-full text-center text-white text-sm font-semibold py-2.5 rounded-xl transition-all hover:shadow-md" style="background-color: #bf3c36;">
            {{ $isAr ? 'إتمام الشراء' : 'Checkout' }}
        </a>
        <a href="{{ route('cart') }}" class="block w-full text-center text-xs font-medium hover:underline" style="color: #46387b;">
            {{ $isAr ? 'عرض السلة الكاملة' : 'View full cart' }}
        </a>
    </div>

    </div>{{-- /card --}}
</div>
