@extends('layouts.app')
@section('title', 'Checkout - Freedom with DXN')

@php $lang = session('lang', 'en'); @endphp

@push('scripts')
<script>
    window.addEventListener('load', function () {
        if (window.fbq) fbq('track', 'InitiateCheckout', {
            value: {{ (float) ($total ?? 0) }},
            currency: 'USD',
            content_type: 'product',
            content_ids: @json(collect($items ?? [])->map(fn($i) => (string) $i['product']->id)->values()),
            num_items: {{ (int) collect($items ?? [])->sum('quantity') }},
        }@if(!empty($eventId)), { eventID: @json($eventId) }@endif);
    });
</script>
@endpush

@section('content')
<div class="max-w-5xl mx-auto px-4 py-12">
    <h1 class="text-2xl font-bold text-dxn-darkgreen mb-8">{{ $lang === 'ar' ? 'إتمام الشراء' : 'Checkout' }}</h1>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-2">
            <form method="POST" action="{{ route('checkout.store') }}" class="card p-6 space-y-4">
                @csrf
                <h3 class="font-bold text-dxn-darkgreen text-lg mb-2">{{ $lang === 'ar' ? 'عنوان الشحن' : 'Shipping Address' }}</h3>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">{{ $lang === 'ar' ? 'العنوان *' : 'Address *' }}</label>
                    <input type="text" name="address" required value="{{ old('address') }}" class="input-field" placeholder="Street address">
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">{{ $lang === 'ar' ? 'المدينة *' : 'City *' }}</label>
                        <input type="text" name="city" required value="{{ old('city') }}" class="input-field">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">{{ $lang === 'ar' ? 'الدولة *' : 'Country *' }}</label>
                        <input type="text" name="country" required value="{{ old('country') }}" class="input-field">
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">{{ $lang === 'ar' ? 'الهاتف *' : 'Phone *' }}</label>
                    <input type="tel" name="phone" required value="{{ old('phone') }}" class="input-field">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">{{ $lang === 'ar' ? 'البريد الإلكتروني *' : 'Email *' }}</label>
                    <input type="email" name="email" required value="{{ old('email', auth()->user()->email ?? '') }}" class="input-field" placeholder="your@email.com">
                </div>

                <h3 class="font-bold text-dxn-darkgreen text-lg mt-6 mb-2">{{ $lang === 'ar' ? 'طريقة الدفع' : 'Payment Method' }}</h3>
                <div class="space-y-2">
                    <label class="flex items-center gap-3 p-3 border rounded-lg cursor-pointer hover:bg-gray-50">
                        <input type="radio" name="payment_method" value="cash" checked class="accent-dxn-green">
                        <span>{{ $lang === 'ar' ? 'الدفع عند الاستلام' : 'Cash on Delivery' }}</span>
                    </label>
                    <label class="flex items-center gap-3 p-3 border rounded-lg cursor-pointer hover:bg-gray-50">
                        <input type="radio" name="payment_method" value="bank_transfer" class="accent-dxn-green">
                        <span>{{ $lang === 'ar' ? 'تحويل بنكي' : 'Bank Transfer' }}</span>
                    </label>
                </div>

                <button type="submit" class="btn-primary w-full mt-6">{{ $lang === 'ar' ? 'تأكيد الطلب' : 'Place Order' }}</button>
            </form>
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
        </div>
    </div>
</div>
@endsection
