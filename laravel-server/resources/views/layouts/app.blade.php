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

    @stack('seo')
    <link rel="icon" type="image/png" href="/favicon.png" sizes="96x96">

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
    </style>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @stack('styles')
</head>
<body class="min-h-screen flex flex-col">
    {{-- Skip to main content (accessibility) --}}
    <a href="#main-content" class="sr-only focus:not-sr-only focus:absolute focus:top-2 focus:left-2 focus:z-[100] focus:bg-white focus:text-brand-violet focus:px-4 focus:py-2 focus:rounded-lg focus:shadow-lg focus:font-semibold">
        {{ session('lang', 'en') === 'ar' ? 'انتقل إلى المحتوى الرئيسي' : 'Skip to main content' }}
    </a>

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
