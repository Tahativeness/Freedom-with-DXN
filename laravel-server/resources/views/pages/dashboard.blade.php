@extends('layouts.app')
@section('title', 'Dashboard - Freedom with DXN')

@php
    $lang = session('lang', 'en');
    $tab = request('tab', 'overview');
@endphp

@section('content')
<div class="bg-dxn-darkgreen py-10 px-4">
    <div class="max-w-6xl mx-auto">
        <h1 class="text-2xl font-bold text-white">{{ $lang === 'ar' ? 'مرحباً' : 'Welcome' }}, {{ $user->name }}!</h1>
        <p class="text-gray-300 mt-1">{{ $lang === 'ar' ? 'لوحة تحكم عضوك في DXN' : 'Your DXN member dashboard' }}</p>
    </div>
</div>

<div class="max-w-6xl mx-auto px-4 py-8">
    {{-- Stats --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
        <div class="card p-5 text-center">
            <div class="text-2xl font-bold text-dxn-darkgreen">{{ $downlines->count() }}</div>
            <div class="text-sm text-gray-600">{{ $lang === 'ar' ? 'أعضاء الفريق' : 'Team Members' }}</div>
        </div>
        <div class="card p-5 text-center">
            <div class="text-2xl font-bold text-dxn-darkgreen">{{ $orders->count() }}</div>
            <div class="text-sm text-gray-600">{{ $lang === 'ar' ? 'الطلبات' : 'Orders' }}</div>
        </div>
        <div class="card p-5 text-center">
            <div class="text-2xl font-bold text-dxn-darkgreen">${{ number_format($orders->sum('total_amount'), 2) }}</div>
            <div class="text-sm text-gray-600">{{ $lang === 'ar' ? 'إجمالي المبيعات' : 'Total Sales' }}</div>
        </div>
        <div class="card p-5 text-center">
            <div class="text-2xl font-bold text-dxn-gold">{{ ucfirst($user->role) }}</div>
            <div class="text-sm text-gray-600">{{ $lang === 'ar' ? 'الرتبة' : 'Rank' }}</div>
        </div>
    </div>

    {{-- Referral Link --}}
    <div class="card p-5 mb-8 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
        <div>
            <h3 class="font-bold text-dxn-darkgreen">{{ $lang === 'ar' ? 'رابط الإحالة الخاص بك' : 'Your Referral Link' }}</h3>
            <p class="text-sm text-gray-600 mt-1" id="referral-link">{{ route('register', ['ref' => $user->referral_code]) }}</p>
        </div>
        <button onclick="navigator.clipboard.writeText(document.getElementById('referral-link').textContent); this.textContent='Copied!'; setTimeout(() => this.textContent='Copy Link', 2000)"
                class="btn-gold text-sm px-4 py-2">Copy Link</button>
    </div>

    {{-- Tabs --}}
    <div class="flex gap-2 mb-6 overflow-x-auto">
        @foreach(['overview' => $lang === 'ar' ? 'نظرة عامة' : 'Overview', 'downlines' => $lang === 'ar' ? 'الفريق' : 'Downlines', 'orders' => $lang === 'ar' ? 'الطلبات' : 'Orders'] as $key => $label)
            <a href="?tab={{ $key }}" class="px-4 py-2 rounded-lg text-sm font-medium whitespace-nowrap {{ $tab === $key ? 'bg-dxn-green text-white' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">{{ $label }}</a>
        @endforeach
    </div>

    @if($tab === 'overview')
        <div class="card p-6">
            <h3 class="font-bold text-dxn-darkgreen mb-4">{{ $lang === 'ar' ? 'معلومات الحساب' : 'Profile Info' }}</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                <div><span class="text-gray-600">{{ $lang === 'ar' ? 'الاسم' : 'Name' }}:</span> <span class="font-medium">{{ $user->name }}</span></div>
                <div><span class="text-gray-600">{{ $lang === 'ar' ? 'البريد' : 'Email' }}:</span> <span class="font-medium">{{ $user->email }}</span></div>
                <div><span class="text-gray-600">{{ $lang === 'ar' ? 'الهاتف' : 'Phone' }}:</span> <span class="font-medium">{{ $user->phone ?? '-' }}</span></div>
                <div><span class="text-gray-600">{{ $lang === 'ar' ? 'الدولة' : 'Country' }}:</span> <span class="font-medium">{{ $user->country ?? '-' }}</span></div>
                <div><span class="text-gray-600">{{ $lang === 'ar' ? 'كود الإحالة' : 'Referral Code' }}:</span> <span class="font-medium text-dxn-gold">{{ $user->referral_code }}</span></div>
                <div><span class="text-gray-600">{{ $lang === 'ar' ? 'تاريخ الانضمام' : 'Joined' }}:</span> <span class="font-medium">{{ $user->created_at->format('M d, Y') }}</span></div>
            </div>
        </div>
    @elseif($tab === 'downlines')
        <div class="card overflow-hidden">
            <table class="w-full text-sm">
                <thead class="bg-gray-50"><tr><th class="px-4 py-3 text-left">Name</th><th class="px-4 py-3 text-left">Email</th><th class="px-4 py-3 text-left">Joined</th></tr></thead>
                <tbody>
                    @forelse($downlines as $dl)
                        <tr class="border-t"><td class="px-4 py-3">{{ $dl->name }}</td><td class="px-4 py-3 text-gray-600">{{ $dl->email }}</td><td class="px-4 py-3 text-gray-600">{{ $dl->created_at->format('M d, Y') }}</td></tr>
                    @empty
                        <tr><td colspan="3" class="px-4 py-8 text-center text-gray-400">No team members yet. Share your referral link!</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    @elseif($tab === 'orders')
        <div class="card overflow-hidden">
            <table class="w-full text-sm">
                <thead class="bg-gray-50"><tr><th class="px-4 py-3 text-left">Order #</th><th class="px-4 py-3 text-left">Total</th><th class="px-4 py-3 text-left">Status</th><th class="px-4 py-3 text-left">Date</th></tr></thead>
                <tbody>
                    @forelse($orders as $order)
                        <tr class="border-t">
                            <td class="px-4 py-3">#{{ $order->id }}</td>
                            <td class="px-4 py-3">${{ number_format($order->total_amount, 2) }}</td>
                            <td class="px-4 py-3">
                                <span class="badge {{ $order->status === 'delivered' ? 'bg-green-100 text-green-700' : ($order->status === 'cancelled' ? 'bg-red-100 text-red-700' : 'bg-yellow-100 text-yellow-700') }}">{{ ucfirst($order->status) }}</span>
                            </td>
                            <td class="px-4 py-3 text-gray-600">{{ $order->created_at->format('M d, Y') }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="px-4 py-8 text-center text-gray-400">No orders yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection
