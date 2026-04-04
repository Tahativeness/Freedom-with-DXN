@extends('layouts.app')
@section('title', 'About - Freedom with DXN')

@php
    $lang = session('lang', 'en');
    $whatsapp = $settings->contact['whatsapp'] ?? 'https://wa.me/message/EFSQ2IDNVG3YB1';

    $values = $lang === 'ar' ? [
        ['title' => 'الصحة أولاً', 'desc' => 'نؤمن بأن الصحة المثلى حق للجميع. ساعدت منتجات الغانودرما من DXN الملايين حول العالم على عيش حياة أكثر صحة ونشاطاً.'],
        ['title' => 'المجتمع والدعم', 'desc' => 'لست وحدك في هذه الرحلة. يدعم فريقنا كل موزع منذ اليوم الأول بالتدريب والإرشاد والمجتمع.'],
        ['title' => 'فرصة عالمية', 'desc' => 'تعمل DXN في أكثر من 180 دولة. عملك لا حدود له — ابنِ فريقاً عالمياً من راحة منزلك.'],
        ['title' => 'نتائج مثبتة', 'desc' => 'أكثر من 35 عاماً من التميز. DXN واحدة من أكثر شركات الصحة والعافية ثقةً في العالم.'],
    ] : [
        ['title' => 'Health First', 'desc' => "We believe optimal health is everyone's right. DXN's Ganoderma products have helped millions worldwide live healthier, more energetic lives."],
        ['title' => 'Community & Support', 'desc' => "You're never alone in this journey. Our team supports every distributor from day one with training, mentorship, and community."],
        ['title' => 'Global Opportunity', 'desc' => 'DXN operates in 180+ countries. Your business has no borders — build a global team from the comfort of your home.'],
        ['title' => 'Proven Results', 'desc' => "35+ years of excellence. DXN is one of the world's most trusted health and wellness companies."],
    ];

    $story = $lang === 'ar' ? [
        'اكتشفت DXN خلال فترة صعبة في رحلتي الصحية. أوصى بي صديق بقهوة ليندزهي، وفي غضون أسابيع، شعرت بفرق ملحوظ في مستويات طاقتي وصحتي العامة.',
        'ما بدأ كقرار صحي شخصي تحول بسرعة إلى شغف بالمشاركة. سجلت كموزع وبدأت أوصي بمنتجات DXN للأصدقاء والعائلة.',
        'مع مرور الوقت، بنيت فريقاً من الأشخاص المتشابهين في التفكير. اليوم، لديّ أعضاء في فريقي في دول متعددة، والرحلة تتواصل.',
        'مهمتي من خلال هذه المنصة بسيطة: مساعدتك على اكتشاف أفضل ما تقدمه DXN — سواء كنت تبحث عن منتجات صحية متميزة أو فرصة عمل مرنة أو كليهما.',
    ] : [
        "I discovered DXN during a difficult time in my health journey. A friend recommended the Lingzhi Coffee, and within weeks, I felt a noticeable difference in my energy levels and overall wellbeing.",
        "What started as a personal health decision quickly became a passion for sharing. I registered as a distributor and began recommending DXN products to friends and family.",
        "Over time, I built a team of like-minded people who wanted the same thing: better health and a smarter way to earn income. Today, I have team members across multiple countries.",
        "My mission with this platform is simple: to help you discover the best of DXN — whether you're looking for premium health products, a flexible business opportunity, or both.",
    ];

    $credentials = $lang === 'ar'
        ? ['موزع مستقل معتمد من DXN', 'مقيم في الإمارات، نخدم منطقة الخليج', 'دعم ثنائي اللغة — عربي وإنجليزي', 'جلسات تدريب زووم مجانية كل أسبوع', 'إرشاد شخصي من التسجيل حتى النجاح']
        : ['Certified DXN Independent Distributor', 'UAE-based, serving the Gulf region', 'Bilingual support — Arabic & English', 'Free Zoom training sessions every week', 'Personal guidance from registration to success'];
@endphp

@section('content')
{{-- Header --}}
<div class="bg-dxn-darkgreen py-20 px-4 text-center relative overflow-hidden">
    <div class="absolute inset-0 opacity-10" style="background-image: radial-gradient(circle at 70% 50%, #dfc378 0%, transparent 60%)"></div>
    <div class="relative max-w-3xl mx-auto">
        <span class="inline-block bg-dxn-gold/20 text-dxn-gold px-4 py-1 rounded-full text-sm font-medium mb-4">
            {{ $lang === 'ar' ? 'قصتنا' : 'Our Story' }}
        </span>
        <h1 class="text-4xl md:text-5xl font-bold text-white mb-4">{{ $lang === 'ar' ? 'من نحن' : 'About Us' }}</h1>
        <p class="text-gray-300 text-lg">{{ $lang === 'ar' ? 'رحلة حقيقية من الصحة والعمل الجاد' : 'A real journey of health and hard work' }}</p>
    </div>
</div>

{{-- Personal Story --}}
<section class="py-20 relative overflow-hidden">
    <div class="absolute inset-0 bg-center bg-cover bg-fixed" style="background-image: url('/about-story-bg.jpeg');"></div>
    <div class="absolute inset-0" style="background: rgba(67,175,115,0);"></div>
    <div class="relative z-10">
    <div class="max-w-6xl mx-auto px-4 grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
        <div class="flex flex-col items-center gap-6">
            <div class="w-48 h-48 bg-gradient-to-br from-dxn-green to-dxn-darkgreen rounded-full flex items-center justify-center shadow-2xl">
                <div class="text-center text-white">
                    <div class="text-5xl font-bold text-dxn-gold">DXN</div>
                    <div class="text-sm text-green-200 mt-1">{{ $lang === 'ar' ? 'موزع مستقل' : 'Independent Distributor' }}</div>
                </div>
            </div>
            <div class="bg-gray-50 rounded-2xl p-6 w-full">
                <h3 class="font-bold text-dxn-darkgreen mb-4 text-lg">{{ $lang === 'ar' ? 'بيانات الاعتماد' : 'Credentials' }}</h3>
                <ul class="space-y-3">
                    @foreach($credentials as $c)
                        <li class="flex items-start gap-3">
                            <div class="w-5 h-5 bg-dxn-green rounded-full flex items-center justify-center shrink-0 mt-0.5">
                                <svg xmlns="http://www.w3.org/2000/svg" width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                            </div>
                            <span class="text-gray-600 text-sm">{{ $c }}</span>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>

        <div style="background: rgba(67, 175, 115, 0.65); backdrop-filter: blur(6px); border-radius: 16px; padding: 32px;">
            <span class="font-extrabold text-lg uppercase tracking-widest" style="color: #ffffff;">
                {{ $lang === 'ar' ? 'كيف بدأ كل شيء' : 'How It All Started' }}
            </span>
            <h2 class="text-3xl font-bold mt-2 mb-6" style="color: #ffffff;">
                {{ $lang === 'ar' ? 'من تجربة شخصية إلى مهمة مشتركة' : 'From a Personal Experience to a Shared Mission' }}
            </h2>
            <div class="space-y-4">
                @foreach($story as $para)
                    <p class="leading-relaxed text-lg" style="color: rgba(255,255,255,0.9);">{{ $para }}</p>
                @endforeach
            </div>
            <div style="display: flex; flex-direction: row; gap: 12px; margin-top: 2rem; flex-wrap: wrap;">
                <a href="{{ $whatsapp }}" target="_blank" class="btn-gold" style="display: inline-flex; align-items: center; gap: 8px; white-space: nowrap;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="currentColor" style="flex-shrink: 0;"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                    <span>WhatsApp Us</span>
                </a>
                <a href="{{ route('join') }}" class="btn-primary" style="white-space: nowrap;">{{ $lang === 'ar' ? 'انضم كموزع' : 'Join as Distributor' }}</a>
            </div>
        </div>
    </div>
    </div>
</section>

{{-- Values --}}
<section class="py-20" style="background-color: #f0fdf4;">
    <div class="max-w-6xl mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-dxn-darkgreen">{{ $lang === 'ar' ? 'ما الذي يميزنا' : 'What Sets Us Apart' }}</h2>
            <p class="text-gray-500 mt-2">{{ $lang === 'ar' ? 'نؤمن بالصحة والثروة والحرية للجميع.' : 'We believe in health, wealth, and freedom for everyone.' }}</p>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($values as $v)
                <div class="card p-6 text-center hover:shadow-lg transition-shadow">
                    <div class="w-14 h-14 bg-dxn-green/10 rounded-2xl flex items-center justify-center mx-auto mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="#16392d" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg>
                    </div>
                    <h3 class="font-bold text-dxn-darkgreen mb-2">{{ $v['title'] }}</h3>
                    <p class="text-gray-600 text-sm leading-relaxed">{{ $v['desc'] }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- DXN by the Numbers --}}
<section class="py-20" style="background-color: #fef2f2;">
    <div class="max-w-6xl mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold" style="color: #452aa8;">{{ $lang === 'ar' ? 'DXN بالأرقام' : 'DXN by the Numbers' }}</h2>
        </div>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
            @foreach([
                ['value' => '1993', 'label' => $lang === 'ar' ? 'تأسست عام' : 'Founded'],
                ['value' => '180+', 'label' => $lang === 'ar' ? 'دولة' : 'Countries'],
                ['value' => '9M+', 'label' => $lang === 'ar' ? 'عضو' : 'Members'],
                ['value' => '1000+', 'label' => $lang === 'ar' ? 'منتج' : 'Products'],
            ] as $stat)
                <div class="text-center p-6 rounded-2xl" style="background: rgba(191,60,54,0.08);">
                    <div class="text-3xl sm:text-4xl md:text-5xl font-extrabold mb-2" style="color: #43af73;">{{ $stat['value'] }}</div>
                    <div class="text-sm font-semibold uppercase tracking-wide" style="color: #452aa8;">{{ $stat['label'] }}</div>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- CTA --}}
<section class="py-20 relative overflow-hidden">
    <div class="absolute inset-0 bg-fixed bg-center bg-cover" style="background-image: url('/cta-bg.jpeg');"></div>
    <div class="absolute inset-0" style="background: rgba(0,0,0,0.6);"></div>
    <div class="max-w-3xl mx-auto px-4 text-center relative z-10">
        <h2 class="text-3xl font-bold text-white mb-4">
            {{ $lang === 'ar' ? 'هل أنت مستعد للانضمام إلى عائلتنا؟' : 'Ready to Join Our Family?' }}
        </h2>
        <p class="text-white/70 mb-8">
            {{ $lang === 'ar' ? 'سواء كنت تريد منتجات صحية أو فرصة عمل — أنا هنا لمساعدتك في كل خطوة.' : "Whether you want health products or a business opportunity — I'm here to help you every step of the way." }}
        </p>
        <div class="flex flex-wrap gap-4 justify-center">
            <a href="{{ $whatsapp }}" target="_blank" class="btn-gold flex items-center gap-2">WhatsApp Us</a>
            <a href="https://calendly.com/freedom-with-dxn2026/welcome-to-freedom-with-dxn" target="_blank" rel="noopener noreferrer" class="btn-primary">{{ $lang === 'ar' ? 'احضر زووم مجاني' : 'Attend Free Zoom' }}</a>
            <a href="{{ route('join') }}" class="btn-outline-white">{{ $lang === 'ar' ? 'انضم كموزع' : 'Join as Distributor' }}</a>
        </div>
    </div>
</section>
@endsection
