@extends('layouts.app')
@section('title', 'Join DXN - Freedom with DXN')

@php
    $lang = session('lang', 'en');
    $whatsapp = $settings->contact['whatsapp'] ?? 'https://wa.me/message/EFSQ2IDNVG3YB1';
    $calendly = 'https://calendly.com/freedom-with-dxn2026/welcome-to-freedom-with-dxn';

    $steps = $lang === 'ar' ? [
        ['num' => '01', 'title' => 'تواصل معي', 'desc' => 'أرسل لي رسالة واتساب أو أكمل نموذج الاتصال. أخبرني باسمك ودولتك وأنك تريد الانضمام إلى DXN.', 'tip' => 'يستغرق البدء دقيقتين فقط.'],
        ['num' => '02', 'title' => 'سجل كعضو', 'desc' => 'سأرسل لك رابط إحالة شخصي. سجل من خلاله على موقع DXN. رسوم التسجيل منخفضة جداً.', 'tip' => 'رسوم لمرة واحدة. لا تجديدات سنوية.'],
        ['num' => '03', 'title' => 'جرّب المنتجات', 'desc' => 'ابدأ بقهوة ليندزهي أو كبسولات ريشي غانو من DXN. استخدمها يومياً لمدة 30 يوماً على الأقل.', 'tip' => 'لا حد أدنى للشراء مطلوب.'],
        ['num' => '04', 'title' => 'احضر تدريب زووم', 'desc' => 'انضم إلى جلسات زووم الأسبوعية المجانية لتتعلم عن المنتجات وخطة التعويض وكيفية بناء فريقك.', 'tip' => 'مجاني. كل أسبوع. لا يلزم خبرة.'],
        ['num' => '05', 'title' => 'شارك واكسب', 'desc' => 'ابدأ بمشاركة تجربتك مع الأصدقاء والعائلة. عندما يطلبون أو يسجلون من خلال رابطك، تكسب عمولات.', 'tip' => 'بدون ضغط. شارك بشكل طبيعي.'],
        ['num' => '06', 'title' => 'ابنِ فريقك', 'desc' => 'ادعُ الآخرين للتسجيل كموزعين تحتك. مع نمو فريقك، يتزايد دخلك السلبي.', 'tip' => 'نجاحك هو نجاحنا.'],
    ] : [
        ['num' => '01', 'title' => 'Contact Me', 'desc' => "Send me a WhatsApp message or fill out the contact form. Tell me your name, country, and that you want to join DXN.", 'tip' => 'It only takes 2 minutes to get started.'],
        ['num' => '02', 'title' => 'Register as a Member', 'desc' => "I'll send you a personal referral link. Register through it on the DXN website. The registration fee is very low.", 'tip' => 'One-time fee. No annual renewals.'],
        ['num' => '03', 'title' => 'Try the Products', 'desc' => "Start with DXN's Lingzhi Coffee or Reishi Gano capsules. Use them daily for at least 30 days.", 'tip' => 'No minimum purchase required.'],
        ['num' => '04', 'title' => 'Attend Zoom Training', 'desc' => 'Join our free weekly Zoom sessions to learn about the products, the compensation plan, and how to build your team.', 'tip' => 'Free. Every week. No experience needed.'],
        ['num' => '05', 'title' => 'Share & Earn', 'desc' => 'Start sharing your experience with friends and family. When they order or register through your link, you earn commissions.', 'tip' => 'No pressure. Share naturally.'],
        ['num' => '06', 'title' => 'Build Your Team', 'desc' => "Invite others to register as distributors under you. As your team grows, so does your passive income.", 'tip' => 'Your success is our success.'],
    ];

    $faqs = $lang === 'ar' ? [
        ['q' => 'هل DXN شرعية؟', 'a' => 'نعم. تأسست DXN عام 1993 في ماليزيا وتعمل في أكثر من 180 دولة. إنها شركة بيع مباشر شرعية لديها ملايين الأعضاء.'],
        ['q' => 'كم يكلف البدء؟', 'a' => 'رسوم التسجيل عادةً 10-25 دولار. لا يوجد حصة شراء شهرية.'],
        ['q' => 'هل DXN حلال؟', 'a' => 'نعم. منتجات DXN حاصلة على شهادة حلال. فطر الغانودرما مكوّن نباتي.'],
        ['q' => 'هل أحتاج إلى خبرة؟', 'a' => 'لا تحتاج إلى أي خبرة. توفر DXN تدريباً مجانياً من خلال جلسات زووم.'],
        ['q' => 'كيف أكسب المال؟', 'a' => 'تكسب من ربح التجزئة والمكافأة الجماعية ومكافآت قيادية متنوعة مع تقدمك في الرتبة.'],
        ['q' => 'هل يمكنني القيام بهذا بدوام جزئي؟', 'a' => 'بالتأكيد. لا يوجد جدول زمني ولا حصة ولا ضغط. تعمل بوتيرتك الخاصة.'],
    ] : [
        ['q' => 'Is DXN legit?', 'a' => 'Yes. DXN was founded in 1993 in Malaysia and operates in 180+ countries. It is a legitimate direct-selling company with millions of members.'],
        ['q' => 'How much does it cost to start?', 'a' => 'The registration fee is typically $10–$25. There is NO monthly purchase quota.'],
        ['q' => 'Is DXN product halal?', 'a' => 'Yes. DXN products are halal-certified. The Ganoderma mushroom is a plant-based ingredient.'],
        ['q' => 'Do I need any experience?', 'a' => 'No experience needed. DXN provides free training through Zoom sessions and online resources.'],
        ['q' => 'How do I earn money?', 'a' => "You earn through retail profit, group bonus, and leadership bonuses as you advance in rank."],
        ['q' => 'Can I do this part-time?', 'a' => "Absolutely. No schedule, no quota, no pressure. Work at your own pace."],
    ];
@endphp

@section('content')
<div class="bg-dxn-darkgreen py-20 px-4 relative overflow-hidden">
    <div class="absolute inset-0 opacity-10" style="background-image: radial-gradient(circle at 30% 50%, #dfc378 0%, transparent 60%)"></div>
    <div class="relative max-w-4xl mx-auto text-center">
        <span class="inline-block bg-dxn-gold/20 text-dxn-gold px-4 py-1 rounded-full text-sm font-medium mb-4">{{ $lang === 'ar' ? 'انضم إلى DXN' : 'Join DXN' }}</span>
        <h1 class="text-4xl md:text-5xl font-bold text-white mb-4">{{ $lang === 'ar' ? 'ابدأ رحلتك مع DXN اليوم' : 'Start Your DXN Journey Today' }}</h1>
        <p class="text-gray-300 text-lg max-w-2xl mx-auto">{{ $lang === 'ar' ? 'انضم إلى ملايين الأعضاء حول العالم واكتشف صحة أفضل وفرصة عمل مرنة.' : 'Join millions of members worldwide and discover better health and a flexible business opportunity.' }}</p>
        <div class="flex flex-wrap gap-4 justify-center mt-8">
            <a href="{{ $whatsapp }}" target="_blank" class="btn-gold">{{ $lang === 'ar' ? 'ابدأ الآن عبر واتساب' : 'Get Started on WhatsApp' }}</a>
            <a href="{{ $calendly }}" target="_blank" rel="noopener noreferrer" class="border-2 border-white text-white hover:bg-white hover:text-dxn-darkgreen px-6 py-3 rounded-lg font-semibold transition-all inline-block">{{ $lang === 'ar' ? 'احضر زووم مجاني أولاً' : 'Attend Free Zoom First' }}</a>
        </div>
    </div>
</div>

{{-- Steps --}}
<section class="py-20" style="background-color: #fef2f2;">
    <div class="max-w-4xl mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-dxn-darkgreen">{{ $lang === 'ar' ? 'كيف تبدأ — خطوة بخطوة' : 'How to Get Started — Step by Step' }}</h2>
        </div>
        <div class="space-y-6">
            @foreach($steps as $step)
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 flex gap-6 items-start hover:shadow-md transition-shadow">
                    <div class="w-14 h-14 bg-dxn-green rounded-2xl flex items-center justify-center shrink-0">
                        <span class="text-white font-bold text-lg">{{ $step['num'] }}</span>
                    </div>
                    <div class="flex-1">
                        <h3 class="font-bold text-dxn-darkgreen text-lg mb-2">{{ $step['title'] }}</h3>
                        <p class="text-gray-600 leading-relaxed text-sm mb-3">{{ $step['desc'] }}</p>
                        <div class="inline-flex items-center gap-2 bg-green-50 text-dxn-green text-xs font-medium px-3 py-1 rounded-full">
                            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="20 6 9 17 4 12"/></svg>
                            {{ $step['tip'] }}
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="text-center mt-10">
            <a href="{{ $whatsapp }}" target="_blank" class="btn-gold">{{ $lang === 'ar' ? 'أنا مستعد للانضمام' : "I'm Ready to Join" }}</a>
        </div>
    </div>
</section>

{{-- Free Zoom Training --}}
<section class="py-20 bg-white" id="zoom">
    <div class="max-w-4xl mx-auto px-4">
        <div class="text-center mb-4">
            <span class="inline-block bg-blue-500/10 text-blue-600 px-4 py-1 rounded-full text-sm font-medium mb-3">{{ $lang === 'ar' ? 'مجاني 100%' : '100% Free' }}</span>
            <h2 class="text-3xl font-bold text-dxn-darkgreen">{{ $lang === 'ar' ? 'جلسات تدريب زووم المجانية' : 'Free Zoom Training Sessions' }}</h2>
            <p class="text-gray-600 mt-3 max-w-2xl mx-auto">{{ $lang === 'ar' ? 'تعلم عن منتجات DXN وفرصة العمل من خبراء حقيقيين' : 'Learn about DXN products and the business opportunity from real experts' }}</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-8 mb-8">
            @foreach([
                $lang === 'ar' ? 'ما هي الغانودرما وفوائدها الصحية' : 'What is Ganoderma and its health benefits',
                $lang === 'ar' ? 'استعراض منتجات DXN الأساسية' : 'Overview of DXN core products',
                $lang === 'ar' ? 'كيف يعمل نموذج عمل DXN' : 'How the DXN business model works',
                $lang === 'ar' ? 'خطة التعويض والمكافآت' : 'Compensation plan and bonuses',
                $lang === 'ar' ? 'كيف تبدأ وتبني فريقك' : 'How to get started and build your team',
                $lang === 'ar' ? 'قصص نجاح حقيقية' : 'Real success stories',
            ] as $item)
                <div class="flex items-center gap-3 p-3 bg-green-50 rounded-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#16392d" stroke-width="3"><polyline points="20 6 9 17 4 12"/></svg>
                    <span class="text-gray-700">{{ $item }}</span>
                </div>
            @endforeach
        </div>

        <h3 class="text-xl font-bold text-dxn-darkgreen text-center mb-6">{{ $lang === 'ar' ? 'الجدول الأسبوعي' : 'Weekly Schedule' }}</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @foreach([
                ['day' => $lang === 'ar' ? 'الاثنين' : 'Monday', 'time' => '8:00 PM GST', 'lang_label' => $lang === 'ar' ? 'عربي' : 'Arabic', 'c' => 'border-green-300 bg-green-50'],
                ['day' => $lang === 'ar' ? 'الأربعاء' : 'Wednesday', 'time' => '8:00 PM GST', 'lang_label' => 'English', 'c' => 'border-blue-300 bg-blue-50'],
                ['day' => $lang === 'ar' ? 'الجمعة' : 'Friday', 'time' => '5:00 PM GST', 'lang_label' => 'AR/EN', 'c' => 'border-purple-300 bg-purple-50'],
                ['day' => $lang === 'ar' ? 'السبت' : 'Saturday', 'time' => '10:00 AM GST', 'lang_label' => 'English', 'c' => 'border-blue-300 bg-blue-50'],
            ] as $session)
                <div class="border-2 rounded-xl p-5 {{ $session['c'] }}">
                    <h3 class="font-bold text-dxn-darkgreen text-lg">{{ $session['day'] }}</h3>
                    <p class="text-gray-600 text-sm mt-1">{{ $session['time'] }}</p>
                    <span class="inline-block bg-white text-sm px-3 py-1 rounded-full mt-2 font-medium">{{ $session['lang_label'] }}</span>
                </div>
            @endforeach
        </div>
        <div class="text-center mt-8">
            <a href="{{ $calendly }}" target="_blank" rel="noopener noreferrer" class="btn-gold inline-flex items-center gap-2">
                {{ $lang === 'ar' ? 'احجز جلسة زووم مجانية' : 'Book a Free Zoom Session' }}
            </a>
        </div>
    </div>
</section>

{{-- FAQs --}}
<section class="py-20 relative bg-cover bg-center bg-no-repeat" style="background-image: url('/images/faq-bg.png')">
    <div class="absolute inset-0 bg-gray-50/90"></div>
    <div class="max-w-3xl mx-auto px-4 relative">
        <h2 class="text-3xl font-bold text-dxn-darkgreen text-center mb-8">{{ $lang === 'ar' ? 'الأسئلة الشائعة' : 'Frequently Asked Questions' }}</h2>
        <div class="space-y-4">
            @foreach($faqs as $faq)
                <details class="group bg-white rounded-xl border border-gray-200 overflow-hidden">
                    <summary class="flex items-center justify-between p-5 cursor-pointer font-semibold text-dxn-darkgreen hover:bg-gray-50 transition-colors list-none">
                        <span>{{ $faq['q'] }}</span>
                        <span class="shrink-0 group-open:rotate-90 transition-transform">→</span>
                    </summary>
                    <div class="px-5 pb-5 text-gray-600 text-sm leading-relaxed border-t border-gray-200 pt-4">{{ $faq['a'] }}</div>
                </details>
            @endforeach
        </div>
    </div>
</section>

{{-- CTA --}}
<section class="py-20 relative overflow-hidden">
    <div class="absolute inset-0 bg-fixed bg-center bg-cover" style="background-image: url('/cta-bg.jpeg');"></div>
    <div class="absolute inset-0" style="background: rgba(0,0,0,0.6);"></div>
    <div class="max-w-3xl mx-auto px-4 text-center relative z-10">
        <h2 class="text-3xl font-bold text-white mb-4">{{ $lang === 'ar' ? 'خطوتك الأولى تبدأ هنا' : 'Your First Step Starts Here' }}</h2>
        <p class="text-white/70 mb-8">{{ $lang === 'ar' ? 'لا تنتظر اللحظة المثالية. ابدأ اليوم.' : "Don't wait for the perfect moment. Start today." }}</p>
        <div class="flex flex-wrap gap-4 justify-center">
            <a href="{{ $whatsapp }}" target="_blank" class="btn-gold flex items-center gap-2">{{ $lang === 'ar' ? 'واتساب الآن' : 'WhatsApp Us' }}</a>
            <a href="{{ $calendly }}" target="_blank" rel="noopener noreferrer" class="btn-primary">{{ $lang === 'ar' ? 'احضر زووم أولاً' : 'Attend Free Zoom' }}</a>
            <a href="{{ route('join') }}" style="border: 2px solid #ffffff; color: #ffffff; background: transparent; padding: 10px 24px; border-radius: 12px; font-weight: 600; transition: all 0.2s;" onmouseenter="this.style.backgroundColor='#ffffff'; this.style.color='#452aa8'" onmouseleave="this.style.backgroundColor='transparent'; this.style.color='#ffffff'">{{ $lang === 'ar' ? 'انضم كموزع' : 'Join as Distributor' }}</a>
        </div>
    </div>
</section>
@endsection
