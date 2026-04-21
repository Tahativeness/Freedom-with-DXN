@php $lang = session('lang', 'en'); $isAr = $lang === 'ar'; @endphp

{{-- Mini-Cart Popover — daisyUI card-compact style --}}
<div x-show="$store.cart.open"
     x-transition:enter="transition ease-out duration-200"
     x-transition:enter-start="opacity-0 scale-95 -translate-y-2"
     x-transition:enter-end="opacity-100 scale-100 translate-y-0"
     x-transition:leave="transition ease-in duration-150"
     x-transition:leave-start="opacity-100 scale-100 translate-y-0"
     x-transition:leave-end="opacity-0 scale-95 -translate-y-2"
     @keydown.escape.window="$store.cart.open = false"
     class="absolute top-full {{ $isAr ? 'left-0' : 'right-0' }} mt-3 w-52 z-[70] origin-top-{{ $isAr ? 'left' : 'right' }}"
     style="display: none;"
     role="dialog"
     aria-label="{{ $isAr ? 'عربة التسوق' : 'Shopping cart' }}">

    <div class="rounded-2xl bg-white shadow-lg overflow-hidden">
        <div class="p-4 space-y-1">

            {{-- Added banner --}}
            <div x-show="$store.cart.justAdded"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 class="text-xs font-semibold pb-1"
                 style="color: #43af73; display: none;">
                {{ $isAr ? '✓ تمت الإضافة إلى السلة!' : '✓ Added to cart!' }}
            </div>

            <span class="text-lg font-bold text-gray-800 block">
                <span x-text="$store.cart.count + ' {{ $isAr ? 'عنصر' : 'Items' }}'"></span>
            </span>

            <span class="block text-sm font-medium" style="color: #43af73;">
                {{ $isAr ? 'المجموع:' : 'Subtotal:' }} $<span x-text="$store.cart.total.toFixed(2)"></span>
            </span>

            <div class="pt-2">
                <a href="{{ route('cart') }}"
                   class="block w-full text-center text-white text-sm font-semibold py-2 rounded-lg transition-opacity hover:opacity-90"
                   style="background-color: #46387b;">
                    {{ $isAr ? 'عرض السلة' : 'View cart' }}
                </a>
            </div>

        </div>
    </div>

</div>
