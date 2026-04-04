<!DOCTYPE html>
<html lang="{{ session('lang', 'en') }}" dir="{{ session('lang') === 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', $settings->seo['pageTitle'] ?? 'Freedom with DXN')</title>
    <meta name="description" content="@yield('description', $settings->seo['description'] ?? '')">
    <meta name="keywords" content="@yield('keywords', $settings->seo['keywords'] ?? '')">
    <link rel="canonical" href="{{ url()->current() }}">

    {{-- Open Graph --}}
    <meta property="og:title" content="@yield('title', $settings->seo['pageTitle'] ?? 'Freedom with DXN')">
    <meta property="og:description" content="@yield('description', $settings->seo['description'] ?? '')">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:site_name" content="Freedom with DXN">
    <meta property="og:type" content="@yield('og_type', 'website')">
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
    <link rel="icon" type="image/png" href="/favicon.png">
    {{-- Fonts self-hosted in /public/fonts/ — no external requests --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body class="min-h-screen flex flex-col">
    @include('partials.navbar')

    {{-- Flash Messages --}}
    @if(session('success'))
        <div class="max-w-4xl mx-auto mt-4 px-4">
            <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg flex items-center justify-between" x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)">
                <span>{{ session('success') }}</span>
                <button @click="show = false" class="text-green-500 hover:text-green-700">&times;</button>
            </div>
        </div>
    @endif
    @if(session('error'))
        <div class="max-w-4xl mx-auto mt-4 px-4">
            <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg flex items-center justify-between" x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)">
                <span>{{ session('error') }}</span>
                <button @click="show = false" class="text-red-500 hover:text-red-700">&times;</button>
            </div>
        </div>
    @endif
    @if($errors->any())
        <div class="max-w-4xl mx-auto mt-4 px-4">
            <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg">
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    <main class="flex-1">
        @yield('content')
    </main>

    @include('partials.footer')
    @include('partials.whatsapp-float')

    @stack('scripts')
</body>
</html>
