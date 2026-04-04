@extends('layouts.app')
@section('title', 'DXN Business Opportunity – Work From Home with Ganoderma Products | Freedom With DXN')
@section('description', 'Discover the DXN business opportunity. Build passive income from home with world-class Ganoderma products, free training, and a global network of distributors.')
@section('keywords', 'DXN business opportunity, work from home health business, DXN network marketing, passive income DXN')

@php
    $lang = session('lang', 'en');
    $incomeLevels = [
        ['rank' => 'Distributor', 'req' => 'Registration', 'bonus' => 'Retail Profit', 'c' => 'bg-gray-100 border-gray-300'],
        ['rank' => 'Star Agent', 'req' => 'Group PV 100+', 'bonus' => '10% Bonus', 'c' => 'bg-blue-50 border-blue-300'],
        ['rank' => 'Agent', 'req' => 'Group PV 300+', 'bonus' => '15% Bonus', 'c' => 'bg-green-50 border-green-300'],
        ['rank' => 'Star Ruby', 'req' => 'Group PV 1000+', 'bonus' => '18% Bonus', 'c' => 'bg-red-50 border-red-300'],
        ['rank' => 'Ruby', 'req' => 'Group PV 2000+', 'bonus' => '21% Bonus', 'c' => 'bg-red-100 border-red-400'],
        ['rank' => 'Diamond', 'req' => 'Group PV 5000+', 'bonus' => '25% Bonus + Royalty', 'c' => 'bg-yellow-50 border-yellow-400'],
    ];
    $howItWorks = [
        ['step' => '01', 'title' => 'Register', 'desc' => 'Sign up as a DXN member with a minimal one-time registration fee.'],
        ['step' => '02', 'title' => 'Use Products', 'desc' => 'Try the products yourself. Your experience is your best selling story.'],
        ['step' => '03', 'title' => 'Share & Sell', 'desc' => 'Share products with friends and family. Earn retail profits on every sale.'],
        ['step' => '04', 'title' => 'Build a Team', 'desc' => 'Refer others to join DXN using your referral link. Earn group bonuses.'],
        ['step' => '05', 'title' => 'Grow & Earn', 'desc' => 'As your network grows, your passive income grows with it.'],
    ];
    $faqs = [
        ['q' => 'How much does it cost to join DXN?', 'a' => 'DXN membership is very affordable. Registration is a one-time fee, typically under $20 in most countries. There are no monthly fees required.'],
        ['q' => 'Do I need to maintain a monthly quota?', 'a' => 'No! DXN does not require monthly purchase quotas. You can work at your own pace.'],
        ['q' => 'Can I join DXN online?', 'a' => "Yes! You can register using your upline's referral link. Contact us and we'll guide you through the process."],
        ['q' => 'How do I get paid?', 'a' => "DXN pays bonuses monthly based on your group's total point value (PV). Payments are made directly to your bank account."],
        ['q' => 'Is this a scam or pyramid scheme?', 'a' => 'No. DXN is a legitimate direct selling company with 35+ years of history, operating in 180+ countries.'],
    ];
@endphp

@section('content')
<section class="bg-hero py-20 px-4">
    <div class="max-w-4xl mx-auto text-center">
        <span class="inline-block bg-dxn-gold/20 text-dxn-gold px-4 py-1 rounded-full text-sm font-medium mb-4">Business Opportunity</span>
        <h1 class="text-4xl md:text-5xl font-bold text-white mb-6">Build Your Dream Business with DXN</h1>
        <p class="text-gray-300 text-lg mb-8">Join one of the world's fastest-growing network marketing companies. DXN offers a unique one-world, one-market business model.</p>
        <a href="{{ route('register') }}" class="btn-gold inline-flex items-center gap-2 text-lg">Start for Free →</a>
    </div>
</section>

<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4">
        <h2 class="section-title">Why DXN Business?</h2>
        <p class="section-subtitle">DXN is different from ordinary MLM companies. Here's why thousands choose DXN.</p>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach([
                ['title' => 'Low Startup Cost', 'desc' => 'Start with minimal investment. No expensive kits or inventory required.'],
                ['title' => 'Global Business', 'desc' => 'One membership works in 180+ countries. Travel and earn anywhere.'],
                ['title' => 'Strong Community', 'desc' => 'Join a supportive network of 9 million+ distributors worldwide.'],
                ['title' => 'Multiple Income Streams', 'desc' => 'Earn from retail profits, group bonuses, royalty income, and more.'],
            ] as $item)
                <div class="card p-6 text-center">
                    <div class="w-14 h-14 bg-dxn-green/10 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#16392d" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
                    </div>
                    <h3 class="font-bold text-dxn-darkgreen text-lg mb-2">{{ $item['title'] }}</h3>
                    <p class="text-gray-600 text-sm">{{ $item['desc'] }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>

<section class="py-20 bg-gray-50">
    <div class="max-w-5xl mx-auto px-4">
        <h2 class="section-title">How It Works</h2>
        <p class="section-subtitle">5 simple steps to start your DXN business journey</p>
        <div class="space-y-6">
            @foreach($howItWorks as $item)
                <div class="flex items-start gap-6">
                    <div class="w-14 h-14 bg-dxn-green rounded-full flex items-center justify-center text-white font-bold text-lg shrink-0 shadow-lg">{{ $item['step'] }}</div>
                    <div class="card p-6 flex-1">
                        <h3 class="font-bold text-dxn-darkgreen text-lg mb-2">{{ $item['title'] }}</h3>
                        <p class="text-gray-600">{{ $item['desc'] }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4">
        <h2 class="section-title">Income & Rank Structure</h2>
        <p class="section-subtitle">The more you grow, the more you earn.</p>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach($incomeLevels as $level)
                <div class="border-2 rounded-xl p-5 {{ $level['c'] }}">
                    <h3 class="font-bold text-dxn-darkgreen text-lg mb-1">{{ $level['rank'] }}</h3>
                    <p class="text-sm text-gray-600 mb-2">{{ $level['req'] }}</p>
                    <div class="flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#16392d" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>
                        <span class="text-dxn-green font-semibold">{{ $level['bonus'] }}</span>
                    </div>
                </div>
            @endforeach
        </div>
        <p class="text-center text-sm text-gray-400 mt-6">*PV = Point Value based on product purchases. Actual earnings may vary.</p>
    </div>
</section>

<section class="py-20 bg-gray-50">
    <div class="max-w-3xl mx-auto px-4">
        <h2 class="section-title">Frequently Asked Questions</h2>
        <div class="space-y-4 mt-8">
            @foreach($faqs as $faq)
                <details class="card p-5 cursor-pointer group">
                    <summary class="font-semibold text-dxn-darkgreen list-none flex justify-between items-center">
                        {{ $faq['q'] }}
                        <span class="text-dxn-green group-open:rotate-45 transition-transform text-xl">+</span>
                    </summary>
                    <p class="text-gray-600 mt-3 text-sm leading-relaxed">{{ $faq['a'] }}</p>
                </details>
            @endforeach
        </div>
    </div>
</section>

<section class="bg-hero py-16 px-4">
    <div class="max-w-2xl mx-auto text-center">
        <h2 class="text-3xl font-bold text-white mb-4">Ready to Change Your Life?</h2>
        <p class="text-gray-300 mb-8">Sign up today and I'll personally guide you through your first steps.</p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="{{ route('register') }}" class="btn-gold">Join Now — It's Free</a>
            <a href="{{ route('contact') }}" class="border-2 border-white text-white hover:bg-white hover:text-dxn-darkgreen px-6 py-3 rounded-lg font-semibold transition-all inline-block text-center">Ask Me Anything</a>
        </div>
    </div>
</section>
@endsection
