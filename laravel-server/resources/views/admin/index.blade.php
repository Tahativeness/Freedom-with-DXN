@extends('layouts.app')
@section('title', 'Admin Panel - Freedom with DXN')

@section('content')
<div class="bg-dxn-darkgreen py-10 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
        <h1 class="text-2xl font-bold text-white">Admin Panel</h1>
        <p class="text-gray-300 mt-1">Manage your store</p>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    {{-- Stats --}}
    <div class="grid grid-cols-2 md:grid-cols-5 gap-4 mb-8">
        <div class="card p-5 text-center">
            <div class="text-3xl font-bold text-dxn-darkgreen">{{ $stats['products'] }}</div>
            <div class="text-sm text-gray-500">Products</div>
        </div>
        <div class="card p-5 text-center">
            <div class="text-3xl font-bold text-dxn-darkgreen">{{ $stats['orders'] }}</div>
            <div class="text-sm text-gray-500">Orders</div>
        </div>
        <div class="card p-5 text-center">
            <div class="text-3xl font-bold text-dxn-darkgreen">{{ $stats['users'] }}</div>
            <div class="text-sm text-gray-500">Users</div>
        </div>
        <div class="card p-5 text-center">
            <div class="text-3xl font-bold text-dxn-gold">${{ number_format($stats['revenue'], 2) }}</div>
            <div class="text-sm text-gray-500">Revenue</div>
        </div>
        <div class="card p-5 text-center">
            <div class="text-3xl font-bold text-dxn-darkgreen">{{ $stats['leads'] }}</div>
            <div class="text-sm text-gray-500">Leads</div>
        </div>
    </div>

    {{-- Quick Links --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <a href="{{ route('admin.products') }}" class="card p-6 text-center hover:shadow-lg transition-shadow">
            <div class="text-3xl mb-2">📦</div>
            <h3 class="font-bold text-dxn-darkgreen">Products</h3>
            <p class="text-sm text-gray-500">Manage catalog</p>
        </a>
        <a href="{{ route('admin.orders') }}" class="card p-6 text-center hover:shadow-lg transition-shadow">
            <div class="text-3xl mb-2">🛒</div>
            <h3 class="font-bold text-dxn-darkgreen">Orders</h3>
            <p class="text-sm text-gray-500">View & update</p>
        </a>
        <a href="{{ route('admin.users') }}" class="card p-6 text-center hover:shadow-lg transition-shadow">
            <div class="text-3xl mb-2">👥</div>
            <h3 class="font-bold text-dxn-darkgreen">Users</h3>
            <p class="text-sm text-gray-500">Manage members</p>
        </a>
        <a href="{{ route('admin.blogs') }}" class="card p-6 text-center hover:shadow-lg transition-shadow">
            <div class="text-3xl mb-2">📝</div>
            <h3 class="font-bold text-dxn-darkgreen">Blog</h3>
            <p class="text-sm text-gray-500">Write & edit</p>
        </a>
        <a href="{{ route('admin.landing-pages') }}" class="card p-6 text-center hover:shadow-lg transition-shadow">
            <div class="text-3xl mb-2">🚀</div>
            <h3 class="font-bold text-dxn-darkgreen">Landing Pages</h3>
            <p class="text-sm text-gray-500">Product pages</p>
        </a>
        <a href="{{ route('admin.leads') }}" class="card p-6 text-center hover:shadow-lg transition-shadow">
            <div class="text-3xl mb-2">Leads</div>
            <h3 class="font-bold text-dxn-darkgreen">Leads</h3>
            <p class="text-sm text-gray-500">Klaviyo status</p>
        </a>
        <a href="{{ route('admin.dxn-business-landing') }}" class="card p-6 text-center hover:shadow-lg transition-shadow">
            <div class="text-3xl mb-2 font-bold text-dxn-gold">DXN</div>
            <h3 class="font-bold text-dxn-darkgreen">DXN Business Landing page</h3>
            <p class="text-sm text-gray-500">Edit content, form, leads</p>
        </a>
    </div>
</div>
@endsection
