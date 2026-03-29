@extends('layouts.app')
@section('title', 'Zoom Training - Freedom with DXN')

@php
    $lang = session('lang', 'en');
    $whatsapp = $settings->contact['whatsapp'] ?? 'https://wa.me/message/EFSQ2IDNVG3YB1';
@endphp

@section('content')
<div class="bg-dxn-darkgreen py-20 px-4 relative overflow-hidden">
    <div class="absolute inset-0 opacity-10" style="background-image: radial-gradient(circle at 30% 50%, #dfc378 0%, transparent 60%)"></div>
    <div class="relative max-w-4xl mx-auto text-center">
        <span class="inline-block bg-blue-500/20 text-blue-300 px-4 py-1 rounded-full text-sm font-medium mb-4">{{ $lang === 'ar' ? 'مجاني 100%' : '100% Free' }}</span>
        <h1 class="text-4xl md:text-5xl font-bold text-white mb-4">{{ $lang === 'ar' ? 'جلسات تدريب زووم المجانية' : 'Free Zoom Training Sessions' }}</h1>
        <p class="text-gray-300 text-lg max-w-2xl mx-auto">{{ $lang === 'ar' ? 'تعلم عن منتجات DXN وفرصة العمل من خبراء حقيقيين' : 'Learn about DXN products and the business opportunity from real experts' }}</p>
    </div>
</div>

{{-- What You'll Learn + Schedule --}}
<div class="relative bg-cover bg-center bg-no-repeat" style="background-image: url('/images/zoom-bg.jpg')">
    <div class="absolute inset-0 bg-white/90"></div>
    <div class="relative">
        <section class="py-16">
            <div class="max-w-4xl mx-auto px-4">
                <h2 class="text-2xl font-bold text-dxn-darkgreen text-center mb-8">{{ $lang === 'ar' ? 'ماذا ستتعلم؟' : "What You'll Learn" }}</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @foreach([
                        $lang === 'ar' ? 'ما هي الغانودرما وفوائدها الصحية' : 'What is Ganoderma and its health benefits',
                        $lang === 'ar' ? 'استعراض منتجات DXN الأساسية' : 'Overview of DXN core products',
                        $lang === 'ar' ? 'كيف يعمل نموذج عمل DXN' : 'How the DXN business model works',
                        $lang === 'ar' ? 'خطة التعويض والمكافآت' : 'Compensation plan and bonuses',
                        $lang === 'ar' ? 'كيف تبدأ وتبني فريقك' : 'How to get started and build your team',
                        $lang === 'ar' ? 'قصص نجاح حقيقية' : 'Real success stories',
                    ] as $item)
                        <div class="flex items-center gap-3 p-3 bg-green-50/80 rounded-lg backdrop-blur-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#16392d" stroke-width="3"><polyline points="20 6 9 17 4 12"/></svg>
                            <span class="text-gray-700">{{ $item }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

        <section class="py-16">
            <div class="max-w-4xl mx-auto px-4">
                <h2 class="text-2xl font-bold text-dxn-darkgreen text-center mb-8">{{ $lang === 'ar' ? 'الجدول الأسبوعي' : 'Weekly Schedule' }}</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @foreach([
                        ['day' => $lang === 'ar' ? 'الاثنين' : 'Monday', 'time' => '8:00 PM GST', 'lang_label' => $lang === 'ar' ? 'عربي' : 'Arabic', 'c' => 'border-green-300 bg-green-50/80'],
                        ['day' => $lang === 'ar' ? 'الأربعاء' : 'Wednesday', 'time' => '8:00 PM GST', 'lang_label' => 'English', 'c' => 'border-blue-300 bg-blue-50/80'],
                        ['day' => $lang === 'ar' ? 'الجمعة' : 'Friday', 'time' => '5:00 PM GST', 'lang_label' => 'AR/EN', 'c' => 'border-purple-300 bg-purple-50/80'],
                        ['day' => $lang === 'ar' ? 'السبت' : 'Saturday', 'time' => '10:00 AM GST', 'lang_label' => 'English', 'c' => 'border-blue-300 bg-blue-50/80'],
                    ] as $session)
                        <div class="border-2 rounded-xl p-5 backdrop-blur-sm {{ $session['c'] }}">
                            <h3 class="font-bold text-dxn-darkgreen text-lg">{{ $session['day'] }}</h3>
                            <p class="text-gray-600 text-sm mt-1">{{ $session['time'] }}</p>
                            <span class="inline-block bg-white text-sm px-3 py-1 rounded-full mt-2 font-medium">{{ $session['lang_label'] }}</span>
                        </div>
                    @endforeach
                </div>
                <div class="text-center mt-8">
                    <a href="{{ $whatsapp }}" target="_blank" class="btn-gold inline-flex items-center gap-2">
                        {{ $lang === 'ar' ? 'احصل على رابط الزووم' : 'Get Zoom Link via WhatsApp' }}
                    </a>
                </div>
            </div>
        </section>
    </div>
</div>

<section class="bg-hero py-16 px-4">
    <div class="max-w-2xl mx-auto text-center">
        <h2 class="text-2xl font-bold text-white mb-4">{{ $lang === 'ar' ? 'لا تفوت الجلسة القادمة!' : "Don't Miss the Next Session!" }}</h2>
        <p class="text-gray-300 mb-6">{{ $lang === 'ar' ? 'أرسل لي رسالة واتساب وسأرسل لك التذكير والرابط.' : "Send me a WhatsApp message and I'll send you the reminder and link." }}</p>
        <a href="{{ $whatsapp }}" target="_blank" class="btn-gold">{{ $lang === 'ar' ? 'واتساب الآن' : 'WhatsApp Now' }}</a>
    </div>
</section>
@endsection
