@extends('layouts.app')
@section('title', 'Cart - Freedom with DXN')

@php $lang = session('lang', 'en'); @endphp

@section('content')
<div class="max-w-6xl mx-auto px-4 py-12">
    <h1 class="text-2xl font-bold text-dxn-darkgreen mb-8">{{ $lang === 'ar' ? 'سلة التسوق' : 'Shopping Cart' }}</h1>

    @if(count($items) === 0)
        <div class="text-center py-20">
            <div class="text-5xl mb-4">🛒</div>
            <p class="text-xl text-gray-600 mb-4">{{ $lang === 'ar' ? 'سلتك فارغة' : 'Your cart is empty' }}</p>
            <a href="{{ route('products') }}" class="btn-primary">{{ $lang === 'ar' ? 'تسوق المنتجات' : 'Shop Products' }}</a>
        </div>
    @else
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="lg:col-span-2 space-y-4">
                @foreach($items as $item)
                    <div class="card p-4 flex gap-4 items-center">
                        <div class="w-20 h-20 bg-gray-100 rounded-lg overflow-hidden shrink-0">
                            @if($item['product']->image)
                                <img src="{{ $item['product']->image }}" alt="{{ $item['product']->name }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full bg-dxn-green flex items-center justify-center text-dxn-gold font-bold">DXN</div>
                            @endif
                        </div>
                        <div class="flex-1">
                            <h3 class="font-semibold text-gray-800">{{ $item['product']->name }}</h3>
                            <p class="text-dxn-green font-bold">${{ number_format($item['product']->price, 2) }}</p>
                        </div>
                        <form method="POST" action="{{ route('cart.update') }}" class="flex items-center gap-2">
                            @csrf @method('PUT')
                            <input type="hidden" name="product_id" value="{{ $item['product']->id }}">
                            <button type="submit" name="quantity" value="{{ $item['quantity'] - 1 }}" class="w-8 h-8 bg-gray-100 rounded flex items-center justify-center hover:bg-gray-200">-</button>
                            <span class="w-8 text-center font-medium">{{ $item['quantity'] }}</span>
                            <button type="submit" name="quantity" value="{{ $item['quantity'] + 1 }}" class="w-8 h-8 bg-gray-100 rounded flex items-center justify-center hover:bg-gray-200">+</button>
                        </form>
                        <span class="font-bold text-dxn-darkgreen w-20 text-right">${{ number_format($item['product']->price * $item['quantity'], 2) }}</span>
                        <form method="POST" action="{{ route('cart.remove', $item['product']->id) }}">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-red-400 hover:text-red-600 text-xl">&times;</button>
                        </form>
                    </div>
                @endforeach
            </div>

            <div class="card p-6 h-fit">
                <h3 class="font-bold text-dxn-darkgreen mb-4">{{ $lang === 'ar' ? 'ملخص الطلب' : 'Order Summary' }}</h3>
                @foreach($items as $item)
                    <div class="flex justify-between text-sm text-gray-600 mb-2">
                        <span>{{ $item['product']->name }} x{{ $item['quantity'] }}</span>
                        <span>${{ number_format($item['product']->price * $item['quantity'], 2) }}</span>
                    </div>
                @endforeach
                <hr class="my-4">
                <div class="flex justify-between font-bold text-lg text-dxn-darkgreen">
                    <span>Total</span>
                    <span>${{ number_format($total, 2) }}</span>
                </div>
                <a href="{{ route('checkout') }}" class="btn-primary w-full mt-6 block text-center">{{ $lang === 'ar' ? 'إتمام الشراء' : 'Proceed to Checkout' }}</a>
            </div>
        </div>
    @endif
</div>
@endsection
