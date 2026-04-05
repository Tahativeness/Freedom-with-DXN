@extends('layouts.app')

@section('title', 'Freedom With DXN – Buy DXN Health Products Online | Ganoderma Coffee & Supplements')
@section('description', 'Freedom With DXN offers premium DXN health products including Lingzhi Coffee, Cocozhi, and Spirulina. Join our community and start your wellness journey today.')
@section('keywords', 'DXN health products, buy DXN products online, DXN distributor, freedom with DXN, ganoderma coffee, DXN supplements')

@section('preload')
<link rel="preload" as="image" href="{{ asset('Video/hero-poster.png') }}" fetchpriority="high">
@endsection

@push('seo')
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "Organization",
    "name": "Freedom with DXN",
    "url": "https://freedomwithdxn.com",
    "logo": "https://freedomwithdxn.com/logo.png",
    "description": "Premium DXN health products including Lingzhi Coffee, Cocozhi, and Spirulina.",
    "sameAs": []
}
</script>
@endpush

@php
    $lang = session('lang', 'en');
    $hero = $settings->hero ?? [];
    $whatsapp = $settings->contact['whatsapp'] ?? 'https://wa.me/message/EFSQ2IDNVG3YB1';

    $why = $lang === 'ar'
        ? ['تكلفة بداية منخفضة', 'منتجات غانودرما عالمية', 'عمل عالمي واحد', 'دخل سلبي عبر الشبكة', 'تدريب مجاني', 'لا حصة شهرية']
        : ['Low startup cost', 'World-class Ganoderma products', 'One-world one-market', 'Passive income via downline', 'Free training', 'No monthly quota'];

    $testi = $lang === 'ar' ? [
        ['name' => 'سارة م.', 'role' => 'موزعة ماسية', 'text' => 'غيّرت DXN حياتي. حسّنت صحتي وأصبحت أكسب دخلاً كاملاً.', 'avatar' => 'س', 'img' => '/images/avatars/sarah.jpg'],
        ['name' => 'جيمس ك.', 'role' => 'موزع ذهبي', 'text' => 'بنيت فريقاً من أكثر من 50 موزعاً. أفضل قرار!', 'avatar' => 'ج', 'img' => '/images/avatars/james.jpg'],
        ['name' => 'ماريا ل.', 'role' => 'عضوة نجمة ياقوتية', 'text' => 'القهوة رائعة وفريقي يتنامى كل شهر!', 'avatar' => 'م', 'img' => '/images/avatars/maria.jpg'],
    ] : [
        ['name' => 'Sarah M.', 'role' => 'Diamond Distributor', 'text' => 'DXN changed my life. Ganoderma improved my health and I earn full-time income.', 'avatar' => 'S', 'img' => '/images/avatars/sarah.jpg'],
        ['name' => 'James K.', 'role' => 'Gold Distributor', 'text' => 'Built a team of 50+ distributors. Best decision ever!', 'avatar' => 'J', 'img' => '/images/avatars/james.jpg'],
        ['name' => 'Maria L.', 'role' => 'Star Ruby', 'text' => 'The coffee is amazing and my downline keeps growing!', 'avatar' => 'M', 'img' => '/images/avatars/maria.jpg'],
    ];
@endphp

@section('content')
{{-- Hero --}}
<section class="bg-hero flex items-center relative overflow-hidden" style="min-height: 100vh; min-height: 100dvh;" aria-label="{{ $lang === 'ar' ? 'القسم الرئيسي' : 'Hero section' }}">
    {{-- Poster shown instantly for fast LCP --}}
    <img id="heroPoster" src="{{ asset('Video/hero-poster.png') }}" alt="" role="presentation" width="800" height="600" class="absolute inset-0 w-full h-full object-cover" fetchpriority="high">
    {{-- Video loads lazily after page load, replaces poster --}}
    <video id="heroVideo" loop muted playsinline preload="none" class="absolute inset-0 w-full h-full object-cover" style="opacity:0; transition: opacity 0.5s;" aria-hidden="true">
    </video>
    <div class="absolute inset-0 bg-black/65" aria-hidden="true"></div>
    <div class="absolute inset-0 opacity-10 pointer-events-none" style="background-image: radial-gradient(circle at 30% 50%, #43af73 0%, transparent 50%)" aria-hidden="true"></div>
    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
        <div>
            <span class="inline-block backdrop-blur-sm text-white px-4 py-1.5 rounded-full text-sm font-medium mb-4 border border-white/30" style="background: rgba(0,0,0,0.45);">
                {{ $lang === 'ar' ? 'موزع مستقل معتمد من DXN' : ($hero['badge'] ?? 'Independent DXN Distributor') }}
            </span>
            <h1 class="text-3xl sm:text-5xl md:text-7xl font-bold text-white leading-tight mb-6">
                {{ $lang === 'ar' ? 'نمّ صحتك وثروتك مع DXN' : ($hero['title'] ?? 'Grow Your Health & Wealth with DXN') }}
            </h1>
            <p class="text-white text-lg mb-8 max-w-lg">
                {{ $lang === 'ar' ? 'اكتشف منتجات الغانودرما المتميزة التي تحوّل صحتك، وفرصة عمل يمكن أن تحوّل حياتك.' : ($hero['subtitle'] ?? 'Discover premium Ganoderma products that transform your health, and a business opportunity that can transform your life.') }}
            </p>
            <div class="flex flex-col sm:flex-row gap-4">
                <a href="{{ $hero['btn1Link'] ?? route('products') }}" class="btn-primary px-8 py-3.5 shadow-lg">
                    {{ $lang === 'ar' ? 'تسوق المنتجات' : ($hero['btn1Text'] ?? 'Shop Now') }}
                </a>
                <a href="{{ $hero['btn2Link'] ?? route('join') }}" class="inline-flex items-center justify-center border-2 border-white text-white hover:bg-brand-violet hover:border-brand-violet px-8 py-3.5 rounded-xl font-semibold transition-all">
                    {{ $lang === 'ar' ? 'ابدأ رحلتي' : ($hero['btn2Text'] ?? 'Start My Journey') }}
                </a>
            </div>
        </div>
        <div class="hidden lg:flex justify-center" aria-hidden="true">
            <div class="w-80 h-80 rounded-full flex items-center justify-center backdrop-blur-sm" style="background: rgba(67,175,115,0.2);">
                <div class="w-64 h-64 rounded-full flex items-center justify-center" style="background: rgba(67,175,115,0.3);">
                    <div class="text-center text-white">
                        <div class="text-6xl font-bold" style="color: #43af73;">DXN</div>
                        <div class="text-xl mt-2">Ganoderma</div>
                        <div class="text-sm text-white mt-1">{{ $lang === 'ar' ? 'منذ 1993' : 'Since 1993' }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Stats --}}
<section class="py-12" style="background-color: #452aa8;" aria-label="{{ $lang === 'ar' ? 'إحصائيات DXN' : 'DXN Statistics' }}">
    <div class="max-w-7xl mx-auto px-4 grid grid-cols-2 md:grid-cols-4 gap-6">
        @foreach([
            ['v' => '180+', 'l' => $lang === 'ar' ? 'دولة' : 'Countries'],
            ['v' => '9M+', 'l' => $lang === 'ar' ? 'عضو' : 'Members'],
            ['v' => '35+', 'l' => $lang === 'ar' ? 'عاماً' : 'Years'],
            ['v' => '1000+', 'l' => $lang === 'ar' ? 'منتج' : 'Products'],
        ] as $stat)
            <div class="text-center text-white">
                <div class="text-3xl font-bold" style="color: #5ddf8e;">{{ $stat['v'] }}</div>
                <div class="text-white text-sm">{{ $stat['l'] }}</div>
            </div>
        @endforeach
    </div>
</section>

{{-- Featured Products + Bestsellers with background image --}}
<div class="relative">
    {{-- Fixed background image --}}
    <div class="absolute inset-0 bg-center bg-cover md:bg-fixed" style="background-image: url('/products-bg.jpeg');" aria-hidden="true"></div>
    <div class="absolute inset-0" style="background: rgba(255,255,255,0.2);" aria-hidden="true"></div>

    {{-- Featured Products --}}
    <section class="py-20 relative z-10" aria-labelledby="featured-heading">
        <div class="max-w-7xl mx-auto px-4">
            <div class="text-center mb-8">
                <h2 id="featured-heading" class="inline-block px-6 py-3 rounded-2xl text-3xl md:text-4xl font-extrabold" style="background-color: #452aa8; color: #ffffff;">{{ $lang === 'ar' ? 'المنتجات المميزة' : 'Featured Products' }}</h2>
                <br><span class="inline-block px-5 py-2 rounded-xl mt-3 text-sm font-medium" style="background-color: #236b43; color: #ffffff;">{{ $lang === 'ar' ? 'منتجات صحية عالية الجودة مدعومة بالغانودرما' : 'Premium health products powered by Ganoderma Lucidum' }}</span>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($featured as $product)
                    @include('components.product-card', ['product' => $product])
                @endforeach
            </div>
            <div class="text-center mt-10">
                <a href="{{ route('products') }}" class="btn-secondary">{{ $lang === 'ar' ? 'عرض الكل' : 'View All Products' }}</a>
            </div>
        </div>
    </section>

    {{-- Divider --}}
    <div class="relative z-10 flex items-center justify-center py-6" aria-hidden="true">
        <div style="height: 3px; width: 35%; background: linear-gradient(to right, transparent, #ffffff, #452aa8);"></div>
        <div style="width: 20px; height: 20px; border-radius: 50%; background-color: #452aa8; margin: 0 20px; box-shadow: 0 0 15px rgba(69,42,168,0.6), 0 0 30px rgba(69,42,168,0.3);"></div>
        <div style="height: 3px; width: 35%; background: linear-gradient(to left, transparent, #ffffff, #452aa8);"></div>
    </div>

    {{-- Bestsellers --}}
    @if($bestsellers->count() > 0)
    <section class="py-20 relative z-10" aria-labelledby="bestsellers-heading">
        <div class="max-w-7xl mx-auto px-4">
            <div class="text-center mb-8">
                <h2 id="bestsellers-heading" class="inline-block px-6 py-3 rounded-2xl text-3xl md:text-4xl font-extrabold" style="background-color: #452aa8; color: #ffffff;">{{ $lang === 'ar' ? 'الأكثر مبيعاً' : 'Bestsellers' }}</h2>
                <br><span class="inline-block px-5 py-2 rounded-xl mt-3 text-sm font-medium" style="background-color: #236b43; color: #ffffff;">{{ $lang === 'ar' ? 'الخيارات الأكثر شعبية بين عملائنا' : 'Most popular choices among our customers' }}</span>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($bestsellers as $product)
                    @include('components.product-card', ['product' => $product])
                @endforeach
            </div>
        </div>
    </section>
    @endif
</div>

{{-- Zoom Banner --}}
<section class="py-16 border-y" style="background-color: #eeeaf8; border-color: rgba(55,28,155,0.1);" aria-labelledby="zoom-heading">
    <div class="max-w-5xl mx-auto px-4 grid grid-cols-1 md:grid-cols-2 gap-8 items-center">
        <div>
            <div class="inline-flex items-center gap-2 px-4 py-1 rounded-full text-sm font-semibold mb-3" style="background: rgba(55,28,155,0.1); color: #452aa8;">
                {{ $lang === 'ar' ? 'مجاني 100%' : '100% Free' }}
            </div>
            <h2 id="zoom-heading" class="text-2xl md:text-3xl font-bold mb-3" style="color: #452aa8;">
                {{ $lang === 'ar' ? 'احضر جلسة زووم مجانية' : 'Attend a Free Zoom Session' }}
            </h2>
            <p class="text-gray-600 mb-4">
                {{ $lang === 'ar' ? 'تعرف على منتجات DXN وفرصة العمل. جلسات أسبوعية بالعربية والإنجليزية.' : 'Learn about DXN products and the business opportunity. Weekly sessions in Arabic and English.' }}
            </p>
            <div class="flex flex-wrap gap-3">
                <a href="https://calendly.com/freedom-with-dxn2026/welcome-to-freedom-with-dxn" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-2 text-white font-semibold px-6 py-3 rounded-xl hover-violet">
                    {{ $lang === 'ar' ? 'عرض الجدول' : 'View Schedule' }}
                </a>
                <a href="{{ $whatsapp }}" target="_blank" rel="noopener noreferrer" class="btn-gold">{{ $lang === 'ar' ? 'احصل على الرابط' : 'Get the Link' }}</a>
            </div>
        </div>
        <div class="grid grid-cols-2 gap-4">
            @foreach([
                ['d' => $lang === 'ar' ? 'الاثنين' : 'Monday', 'b' => $lang === 'ar' ? 'عربي' : 'Arabic'],
                ['d' => $lang === 'ar' ? 'الأربعاء' : 'Wednesday', 'b' => 'English'],
                ['d' => $lang === 'ar' ? 'الجمعة' : 'Friday', 'b' => 'AR/EN'],
                ['d' => $lang === 'ar' ? 'السبت' : 'Saturday', 'b' => 'English'],
            ] as $s)
                <div class="bg-white rounded-xl p-4 shadow-sm" style="border: 1px solid rgba(55,28,155,0.1);">
                    <p class="font-bold" style="color: #452aa8;">{{ $s['d'] }}</p>
                    <span class="inline-block text-xs px-2 py-0.5 rounded-full mt-1 font-medium" style="background: rgba(49,140,90,0.1); color: #1e6b42;">{{ $s['b'] }}</span>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- Why Join --}}
<section class="py-20 bg-white" aria-labelledby="whyjoin-heading">
    <div class="max-w-7xl mx-auto px-4 grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
        <div>
            <span class="font-semibold text-sm uppercase tracking-widest" style="color: #236b43;">{{ $lang === 'ar' ? 'فرصة العمل' : 'Business Opportunity' }}</span>
            <h2 id="whyjoin-heading" class="text-3xl md:text-4xl font-bold mt-2 mb-6" style="color: #452aa8;">{{ $lang === 'ar' ? 'لماذا تنضم إلى DXN؟' : 'Why Join DXN?' }}</h2>
            <ul class="space-y-3 mb-8">
                @foreach($why as $item)
                    <li class="flex items-start gap-3">
                        <div class="w-5 h-5 rounded-full flex items-center justify-center shrink-0 mt-0.5" style="background-color: #236b43;" aria-hidden="true">
                            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="3" aria-hidden="true"><polyline points="20 6 9 17 4 12"/></svg>
                        </div>
                        <span class="text-gray-600">{{ $item }}</span>
                    </li>
                @endforeach
            </ul>
            <div class="flex flex-wrap gap-3">
                <a href="{{ route('join') }}" class="btn-primary">{{ $lang === 'ar' ? 'ابدأ رحلتي' : 'Start My Journey' }}</a>
                <a href="{{ $whatsapp }}" target="_blank" rel="noopener noreferrer" class="btn-secondary">{{ $lang === 'ar' ? 'اسألني الآن' : 'Ask Me Now' }}</a>
            </div>
        </div>
        <div class="grid grid-cols-2 gap-4">
            @foreach([
                ['t' => $lang === 'ar' ? 'الصحة' : 'Health', 'd' => $lang === 'ar' ? 'حوّل صحتك بالغانودرما' : 'Transform health with Ganoderma', 'c' => 'background: #e8f5ee; border-color: rgba(67,175,115,0.2);'],
                ['t' => $lang === 'ar' ? 'الثروة' : 'Wealth', 'd' => $lang === 'ar' ? 'ابنِ دخلاً سلبياً' : 'Build passive income', 'c' => 'background: #eeeaf8; border-color: rgba(55,28,155,0.2);'],
                ['t' => $lang === 'ar' ? 'الشبكة' : 'Network', 'd' => $lang === 'ar' ? 'مجتمع موزعين عالمي' : 'Global distributor community', 'c' => 'background: #e8f5ee; border-color: rgba(67,175,115,0.2);'],
                ['t' => $lang === 'ar' ? 'الحرية' : 'Freedom', 'd' => $lang === 'ar' ? 'اعمل وفق جدولك' : 'Work on your schedule', 'c' => 'background: #eeeaf8; border-color: rgba(55,28,155,0.2);'],
            ] as $card)
                <div class="p-6 rounded-xl border-2" style="{{ $card['c'] }}">
                    <h3 class="font-bold text-xl mb-2" style="color: #452aa8;">{{ $card['t'] }}</h3>
                    <p class="text-gray-600 text-sm">{{ $card['d'] }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- Testimonials --}}
<section class="py-20 bg-gray-50" aria-labelledby="testimonials-heading">
    <div class="max-w-7xl mx-auto px-4">
        <h2 id="testimonials-heading" class="section-title">{{ $lang === 'ar' ? 'قصص النجاح' : 'Success Stories' }}</h2>
        <p class="section-subtitle">{{ $lang === 'ar' ? 'أشخاص حقيقيون. نتائج حقيقية.' : 'Real people. Real results.' }}</p>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach($testi as $t)
                <article class="card p-6" style="border-top: 4px solid #43af73;">
                    <div class="flex items-center gap-1 mb-4" aria-label="{{ $lang === 'ar' ? '5 من 5 نجوم' : '5 out of 5 stars' }}">
                        @for($i = 0; $i < 5; $i++)
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="#bf3c36" stroke="#bf3c36" stroke-width="2" aria-hidden="true"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                        @endfor
                    </div>
                    <blockquote class="text-gray-600 italic mb-6">"{{ $t['text'] }}"</blockquote>
                    <div class="flex items-center gap-3">
                        @if(file_exists(public_path($t['img'])))
                            <img src="{{ $t['img'] }}" alt="{{ $t['name'] }}" loading="lazy" decoding="async" width="40" height="40" class="w-10 h-10 rounded-full object-cover">
                        @else
                            <div class="w-10 h-10 rounded-full flex items-center justify-center text-white font-bold" style="background-color: #452aa8;" aria-hidden="true">{{ $t['avatar'] }}</div>
                        @endif
                        <div>
                            <p class="font-semibold text-gray-800">{{ $t['name'] }}</p>
                            <p class="text-sm" style="color: #452aa8;">{{ $t['role'] }}</p>
                        </div>
                    </div>
                </article>
            @endforeach
        </div>
    </div>
</section>

{{-- CTA Banner --}}
<section class="py-20 relative overflow-hidden" aria-labelledby="cta-heading">
    <div class="absolute inset-0 bg-fixed bg-center bg-cover" style="background-image: url('/cta-bg.jpeg');" aria-hidden="true"></div>
    <div class="absolute inset-0" style="background: rgba(0,0,0,0.75);" aria-hidden="true"></div>
    <div class="max-w-4xl mx-auto px-4 text-center relative z-10">
        <h2 id="cta-heading" class="text-3xl md:text-4xl font-bold text-white mb-4">{{ $lang === 'ar' ? 'هل أنت مستعد للبدء؟' : 'Ready to Get Started?' }}</h2>
        <p class="text-white text-lg mb-8">{{ $lang === 'ar' ? 'انضم لآلاف الأشخاص الذين حوّلوا صحتهم وحياتهم مع DXN' : 'Join thousands who have transformed their health and lives with DXN' }}</p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="{{ route('join') }}" class="btn-primary px-8 py-3.5 shadow-lg">
                {{ $lang === 'ar' ? 'انضم مجاناً' : 'Join For Free' }}
            </a>
            <a href="{{ $whatsapp }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center justify-center gap-2 text-white px-6 py-3 rounded-xl font-semibold transition-all hover-whatsapp">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/></svg>
                {{ $lang === 'ar' ? 'واتساب' : 'WhatsApp Us' }}
            </a>
            <a href="https://calendly.com/freedom-with-dxn2026/welcome-to-freedom-with-dxn" target="_blank" rel="noopener noreferrer" class="inline-flex items-center justify-center gap-2 border-2 border-white text-white hover:bg-white hover:text-brand-violet px-6 py-3 rounded-xl font-semibold transition-all">
                {{ $lang === 'ar' ? 'احضر زووم' : 'Free Zoom' }}
            </a>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
    window.addEventListener('load', function() {
        var v = document.getElementById('heroVideo');
        var p = document.getElementById('heroPoster');
        var s = document.createElement('source');
        s.src = '{{ asset("Video/hero.mp4") }}';
        s.type = 'video/mp4';
        v.appendChild(s);
        v.load();
        v.play().then(function() {
            v.style.opacity = '1';
            if (p) p.style.display = 'none';
        }).catch(function() {});
        document.addEventListener('visibilitychange', function() {
            if (!document.hidden) v.play().catch(function() {});
        });
    });
</script>
@endpush
