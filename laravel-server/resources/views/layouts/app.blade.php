<!DOCTYPE html>
<html lang="{{ session('lang', 'en') }}" dir="{{ session('lang') === 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="theme-color" content="#452aa8">
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
        .btn-primary { background-color: #bf3c36; color: #fff; padding: 12px 24px; border-radius: 12px; font-weight: 600; transition: all 0.2s; display: inline-block; text-align: center; box-shadow: 0 1px 3px rgba(0,0,0,0.1); }
        .btn-primary:hover { background-color: #a3322d; box-shadow: 0 4px 12px rgba(0,0,0,0.15); }
        .btn-secondary { background-color: #236b43; color: #fff; padding: 12px 24px; border-radius: 12px; font-weight: 600; transition: all 0.2s; display: inline-block; text-align: center; box-shadow: 0 1px 3px rgba(0,0,0,0.1); }
        .btn-secondary:hover { background-color: #1b5535; box-shadow: 0 4px 12px rgba(0,0,0,0.15); }
        .btn-gold { background-color: #bf3c36; color: #fff; padding: 12px 24px; border-radius: 12px; font-weight: 600; transition: all 0.2s; display: inline-block; text-align: center; box-shadow: 0 1px 3px rgba(0,0,0,0.1); }
        .btn-gold:hover { background-color: #a3322d; box-shadow: 0 4px 12px rgba(0,0,0,0.15); }
        .btn-outline-white { border: 2px solid #fff; color: #fff; background: transparent; padding: 10px 24px; border-radius: 12px; font-weight: 600; transition: all 0.2s; display: inline-block; text-align: center; }
        .btn-outline-white:hover { background-color: #fff; color: #452aa8; }
        .btn-outline-violet { border: 2px solid #452aa8; color: #452aa8; background: transparent; padding: 10px 24px; border-radius: 12px; font-weight: 600; transition: all 0.2s; display: inline-block; text-align: center; }
        .btn-outline-violet:hover { background-color: #452aa8; color: #fff; }
        .hover-violet { background-color: #452aa8; transition: background-color 0.2s; }
        .hover-violet:hover { background-color: #4a2db5; }
        .hover-green { background-color: #236b43; transition: background-color 0.2s; }
        .hover-green:hover { background-color: #1b5535; }
        .hover-whatsapp { background-color: #25D366; transition: background-color 0.2s; }
        .hover-whatsapp:hover { background-color: #20ba5a; }
        .hover-red { background-color: #bf3c36; transition: background-color 0.2s; }
        .hover-red:hover { background-color: #a3322d; }
    </style>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @stack('styles')
</head>
<body class="min-h-screen flex flex-col">
    @include('partials.navbar')

    {{-- Flash Messages --}}
    @if(session('success'))
        <div class="max-w-4xl mx-auto mt-4 px-4" role="alert">
            <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg flex items-center justify-between" x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)">
                <span>{{ session('success') }}</span>
                <button @click="show = false" class="text-green-500 hover:text-green-700" aria-label="{{ session('lang', 'en') === 'ar' ? 'إغلاق' : 'Close' }}">&times;</button>
            </div>
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
</body>
</html>
