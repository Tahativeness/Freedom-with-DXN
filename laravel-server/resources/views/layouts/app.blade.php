<!DOCTYPE html>
<html lang="{{ session('lang', 'en') }}" dir="{{ session('lang') === 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="theme-color" content="#46387b">
    <meta name="robots" content="index, follow">
    <title>@yield('title', $settings->seo['pageTitle'] ?? 'Freedom with DXN')</title>
    <meta name="description" content="@yield('description', $settings->seo['description'] ?? '')">
    <meta name="keywords" content="@yield('keywords', $settings->seo['keywords'] ?? '')">
    <link rel="canonical" href="{{ url()->current() }}">

    {{-- Hreflang for bilingual support --}}
    <link rel="alternate" hreflang="en" href="{{ url()->current() }}">
    <link rel="alternate" hreflang="ar" href="{{ url()->current() }}">
    <link rel="alternate" hreflang="x-default" href="{{ url()->current() }}">

    {{-- Open Graph --}}
    <meta property="og:title" content="@yield('title', $settings->seo['pageTitle'] ?? 'Freedom with DXN')">
    <meta property="og:description" content="@yield('description', $settings->seo['description'] ?? '')">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:site_name" content="Freedom with DXN">
    <meta property="og:type" content="@yield('og_type', 'website')">
    <meta property="og:locale" content="{{ session('lang', 'en') === 'ar' ? 'ar_AE' : 'en_US' }}">
    @hasSection('og_image')
        <meta property="og:image" content="@yield('og_image')">
    @else
        <meta property="og:image" content="{{ url('/logo.png') }}">
    @endif

    {{-- Twitter Card --}}
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@yield('title', $settings->seo['pageTitle'] ?? 'Freedom with DXN')">
    <meta name="twitter:description" content="@yield('description', $settings->seo['description'] ?? '')">
    @hasSection('og_image')
        <meta name="twitter:image" content="@yield('og_image')">
    @else
        <meta name="twitter:image" content="{{ url('/logo.png') }}">
    @endif
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">

    @stack('seo')
    <link rel="icon" type="image/png" href="/favicon.png" sizes="96x96">
    <link rel="apple-touch-icon" href="/favicon.png">

    {{-- Preconnect to external origins --}}
    <link rel="dns-prefetch" href="https://calendly.com">
    <link rel="dns-prefetch" href="https://wa.me">

    {{-- Preload LCP image (hero poster) --}}
    @hasSection('preload')
        @yield('preload')
    @endif

    {{-- Self-hosted DM Sans font (no Google Fonts request) --}}
    <style>
        @font-face { font-family: 'DM Sans'; font-style: normal; font-weight: 400; font-display: swap; src: url('/fonts/dm-sans-latin.woff2') format('woff2'); }
        @font-face { font-family: 'DM Sans'; font-style: normal; font-weight: 500; font-display: swap; src: url('/fonts/dm-sans-latin.woff2') format('woff2'); }
        @font-face { font-family: 'DM Sans'; font-style: normal; font-weight: 600; font-display: swap; src: url('/fonts/dm-sans-latin.woff2') format('woff2'); }
        @font-face { font-family: 'DM Sans'; font-style: normal; font-weight: 700; font-display: swap; src: url('/fonts/dm-sans-latin.woff2') format('woff2'); }

        /* Button system — inlined so they work regardless of Tailwind build purge */
        .btn-primary { background-color: #bf3c36; color: #fff; padding: 12px 24px; border-radius: 100px; font-weight: 600; transition: all 0.2s; display: inline-block; text-align: center; box-shadow: 0 1px 3px rgba(0,0,0,0.1); }
        .btn-primary:hover { background-color: #a3322d; box-shadow: 0 4px 12px rgba(0,0,0,0.15); }
        .btn-secondary { background-color: #43af73; color: #fff; padding: 12px 24px; border-radius: 100px; font-weight: 600; transition: all 0.2s; display: inline-block; text-align: center; box-shadow: 0 1px 3px rgba(0,0,0,0.1); }
        .btn-secondary:hover { background-color: #38a868; box-shadow: 0 4px 12px rgba(0,0,0,0.15); }
        .btn-gold { background-color: #bf3c36; color: #fff; padding: 12px 24px; border-radius: 100px; font-weight: 600; transition: all 0.2s; display: inline-block; text-align: center; box-shadow: 0 1px 3px rgba(0,0,0,0.1); }
        .btn-gold:hover { background-color: #a3322d; box-shadow: 0 4px 12px rgba(0,0,0,0.15); }
        .btn-outline-white { border: 2px solid #fff; color: #fff; background: transparent; padding: 10px 24px; border-radius: 100px; font-weight: 600; transition: all 0.2s; display: inline-block; text-align: center; }
        .btn-outline-white:hover { background-color: #fff; color: #46387b; }
        .btn-outline-violet { border: 2px solid #46387b; color: #46387b; background: transparent; padding: 10px 24px; border-radius: 100px; font-weight: 600; transition: all 0.2s; display: inline-flex; align-items: center; justify-content: center; gap: 8px; text-align: center; }
        .btn-outline-violet:hover { background-color: #46387b; color: #fff; }
        .hover-violet { background-color: #46387b; transition: background-color 0.2s; }
        .hover-violet:hover { background-color: #5a4a90; }
        .hover-green { background-color: #43af73; transition: background-color 0.2s; }
        .hover-green:hover { background-color: #38a868; }
        .hover-whatsapp { background-color: #25D366; transition: background-color 0.2s; }
        .hover-whatsapp:hover { background-color: #20ba5a; }
        .hover-red { background-color: #bf3c36; transition: background-color 0.2s; }
        .hover-red:hover { background-color: #a3322d; }
        .product-card-hover { box-shadow: inset 0 0 0 0 #bf3c36, 0 1px 8px rgba(0,0,0,0.06); transition: box-shadow 0.3s, transform 0.3s; }
        .product-card-hover:hover { box-shadow: inset 0 -4px 0 0 #bf3c36, 0 8px 30px rgba(0,0,0,0.12); transform: translateY(-4px); }
    </style>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @stack('styles')
</head>
<body class="min-h-screen flex flex-col" x-data>
    {{-- Alpine cart store --}}
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.store('cart', {
                open: false,
                count: {{ (int) array_sum(session('cart', [])) }},
                items: [],
                total: 0,
                justAdded: false,
                _csrf() { return document.querySelector('meta[name=csrf-token]')?.content || ''; },
                async refresh() {
                    try {
                        const res = await fetch('{{ route('cart.data') }}', { headers: { 'Accept': 'application/json' }, credentials: 'same-origin' });
                        if (!res.ok) return;
                        const data = await res.json();
                        this.items = data.items;
                        this.total = data.total;
                        this.count = data.count;
                    } catch (e) {}
                },
                async add(productId, quantity = 1) {
                    try {
                        const res = await fetch('{{ route('cart.add') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'Accept': 'application/json',
                                'X-CSRF-TOKEN': this._csrf(),
                                'X-Requested-With': 'XMLHttpRequest',
                            },
                            credentials: 'same-origin',
                            body: JSON.stringify({ product_id: productId, quantity }),
                        });
                        if (res.status === 401 || res.redirected) { window.location.href = '{{ route('login') }}'; return; }
                        if (!res.ok) return;
                        await this.refresh();
                        this.open = true;
                        this.justAdded = true;
                        window.scrollTo({ top: 0, behavior: 'smooth' });
                        setTimeout(() => { this.justAdded = false; }, 2500);
                    } catch (e) {}
                },
                async remove(productId) {
                    try {
                        await fetch('/cart/remove/' + productId, {
                            method: 'DELETE',
                            headers: { 'X-CSRF-TOKEN': this._csrf(), 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
                            credentials: 'same-origin',
                        });
                        await this.refresh();
                    } catch (e) {}
                },
            });
        });

        document.addEventListener('submit', (e) => {
            const form = e.target.closest('form[data-cart-add]');
            if (!form) return;
            e.preventDefault();
            const pid = form.querySelector('input[name="product_id"]')?.value;
            const qty = parseInt(form.querySelector('input[name="quantity"]')?.value || '1', 10);
            if (pid && window.Alpine) window.Alpine.store('cart').add(pid, qty);
        });
    </script>

    @include('partials.navbar')

    {{-- Flash Messages --}}
    @if(session('success'))
        @php
            $flashMsg  = session('success');
            $flashLang = session('lang', 'en');
            $isCartAdd = stripos($flashMsg, 'added to cart') !== false;
        @endphp
        <div class="fixed top-24 {{ $flashLang === 'ar' ? 'left-4' : 'right-4' }} z-[60] max-w-sm"
             x-data="{ show: true }"
             x-show="show"
             x-init="setTimeout(() => show = false, 4000)"
             x-transition:enter="transition transform ease-out duration-300"
             x-transition:enter-start="{{ $flashLang === 'ar' ? '-translate-x-full' : 'translate-x-full' }} opacity-0"
             x-transition:enter-end="translate-x-0 opacity-100"
             x-transition:leave="transition transform ease-in duration-200"
             x-transition:leave-start="translate-x-0 opacity-100"
             x-transition:leave-end="{{ $flashLang === 'ar' ? '-translate-x-full' : 'translate-x-full' }} opacity-0"
             role="alert">
            @if($isCartAdd)
                <a href="{{ route('cart') }}"
                   class="flex items-center gap-3 bg-white shadow-2xl rounded-xl px-4 py-3 border-l-4 hover:shadow-[0_20px_50px_rgba(0,0,0,0.25)] transition-shadow cursor-pointer group"
                   style="border-left-color: #43af73;">
                    <div class="w-10 h-10 rounded-full flex items-center justify-center shrink-0" style="background-color: rgba(35,107,67,0.12);">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#43af73" stroke-width="2.5" aria-hidden="true"><polyline points="20 6 9 17 4 12"/></svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="font-semibold text-sm" style="color: #43af73;">{{ $flashLang === 'ar' ? 'تمت الإضافة إلى السلة!' : 'Added to cart!' }}</p>
                        <p class="text-xs text-gray-500 group-hover:text-gray-700 transition-colors">{{ $flashLang === 'ar' ? 'انقر لعرض السلة ←' : 'Click to view cart →' }}</p>
                    </div>
                    <button @click.prevent="show = false" class="text-gray-300 hover:text-gray-600 text-xl leading-none shrink-0" aria-label="{{ $flashLang === 'ar' ? 'إغلاق' : 'Close' }}">&times;</button>
                </a>
            @else
                <div class="flex items-center gap-3 bg-white shadow-2xl rounded-xl px-4 py-3 border-l-4" style="border-left-color: #43af73;">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#43af73" stroke-width="2.5" aria-hidden="true" class="shrink-0"><polyline points="20 6 9 17 4 12"/></svg>
                    <span class="text-sm text-gray-800 flex-1">{{ $flashMsg }}</span>
                    <button @click="show = false" class="text-gray-300 hover:text-gray-600 text-xl leading-none shrink-0" aria-label="{{ $flashLang === 'ar' ? 'إغلاق' : 'Close' }}">&times;</button>
                </div>
            @endif
        </div>
    @endif
    @if(session('error'))
        <div class="max-w-4xl mx-auto mt-4 px-4" role="alert">
            <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg flex items-center justify-between" x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)">
                <span>{{ session('error') }}</span>
                <button @click="show = false" class="text-red-500 hover:text-red-700" aria-label="{{ session('lang', 'en') === 'ar' ? 'إغلاق' : 'Close' }}">&times;</button>
            </div>
        </div>
    @endif
    @if($errors->any())
        <div class="max-w-4xl mx-auto mt-4 px-4" role="alert">
            <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg">
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    <main id="main-content" class="flex-1">
        @yield('content')
    </main>

    @include('partials.footer')
    @include('partials.whatsapp-float')

    @stack('scripts')
    <script async type='text/javascript' src='https://static.klaviyo.com/onsite/js/Rks7DY/klaviyo.js?company_id=Rks7DY'></script>
          <script type="text/javascript"> 
          //Initialize Klaviyo object on page load
          !function(){if(!window.klaviyo){window._klOnsite=window._klOnsite||[];try{window.klaviyo=new Proxy({},{get:function(n,i){return"push"===i?function(){var n;(n=window._klOnsite).push.apply(n,arguments)}:function(){for(var n=arguments.length,o=new Array(n),w=0;w<n;w++)o[w]=arguments[w];var t="function"==typeof o[o.length-1]?o.pop():void 0,e=new Promise((function(n){window._klOnsite.push([i].concat(o,[function(i){t&&t(i),n(i)}]))}));return e}}})}catch(n){window.klaviyo=window.klaviyo||[],window.klaviyo.push=function(){var n;(n=window._klOnsite).push.apply(n,arguments)}}}}(); </script>
</body>
</html>
