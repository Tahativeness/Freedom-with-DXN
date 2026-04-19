@extends('layouts.app')
@section('title', 'DXN Blog – Health Tips, Product Reviews & Business Insights | Freedom With DXN')
@section('description', 'Read the latest DXN product reviews, health tips, Ganoderma mushroom benefits, and business success stories on the Freedom With DXN blog.')
@section('keywords', 'DXN product review, ganoderma mushroom benefits, DXN blog, health tips')

@php
    $lang = session('lang', 'en');
    $currentCategory = request('category', 'all');
    $blogCategories = ['all', 'health', 'business', 'products', 'success-stories', 'tips'];
    $categoryLabelsAr = [
        'all' => 'الكل',
        'health' => 'صحة',
        'business' => 'أعمال',
        'products' => 'منتجات',
        'success-stories' => 'قصص نجاح',
        'tips' => 'نصائح',
    ];
@endphp

@push('seo')
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "Blog",
    "name": "Freedom with DXN Blog",
    "description": "Health tips, product reviews, and business insights for DXN distributors.",
    "url": "{{ url('/blog') }}",
    "publisher": {
        "@type": "Organization",
        "name": "Freedom with DXN",
        "logo": {
            "@type": "ImageObject",
            "url": "https://freedomwithdxn.com/logo.png"
        }
    }
}
</script>
@endpush

@section('content')
<div class="bg-dxn-darkgreen py-16 px-4">
    <div class="max-w-4xl mx-auto text-center">
        <span class="inline-block bg-dxn-gold/20 text-dxn-gold px-4 py-1 rounded-full text-sm font-medium mb-4">{{ $lang === 'ar' ? 'مدونة ومقالات' : 'Blog & Articles' }}</span>
        <h1 class="text-3xl md:text-4xl font-bold text-white mb-3">{{ $lang === 'ar' ? 'رؤى صحية وتجارية' : 'Health & Business Insights' }}</h1>
        <p class="text-gray-300 max-w-2xl mx-auto">{{ $lang === 'ar' ? 'نصائح وأدلة وقصص لمساعدتك على تطوير صحتك وتنمية أعمالك في DXN' : 'Tips, guides, and stories to help you grow your health and your DXN business' }}</p>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 py-10">
    <div class="flex items-center gap-2 overflow-x-auto pb-2 mb-8">
        @foreach($blogCategories as $cat)
            <a href="{{ route('blog', $cat !== 'all' ? ['category' => $cat] : []) }}"
               class="px-4 py-2 rounded-full text-sm font-medium whitespace-nowrap transition-colors capitalize {{ $currentCategory === $cat ? 'bg-dxn-green text-white' : 'bg-white text-gray-600 hover:bg-gray-100 border' }}">
                {{ $lang === 'ar' ? ($categoryLabelsAr[$cat] ?? str_replace('-', ' ', $cat)) : str_replace('-', ' ', $cat) }}
            </a>
        @endforeach
    </div>

    @if($posts->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($posts as $post)
                <a href="{{ route('blog.show', $post) }}" class="card group overflow-hidden flex flex-col">
                    <div class="bg-gradient-to-br from-dxn-green to-dxn-darkgreen h-48 flex items-center justify-center relative overflow-hidden">
                        @if($post->image)
                            <img src="{{ $post->image }}" alt="{{ $post->title }}" loading="lazy" width="400" height="192" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                        @else
                            <div class="text-center p-6">
                                <div class="text-dxn-gold text-4xl font-bold mb-1">DXN</div>
                                <div class="text-green-200 text-xs uppercase tracking-widest">{{ str_replace('-', ' ', $post->category) }}</div>
                            </div>
                        @endif
                        <span class="absolute top-3 left-3 bg-dxn-gold text-white text-xs px-2 py-1 rounded-full font-medium capitalize">
                            {{ $lang === 'ar' ? ($categoryLabelsAr[$post->category] ?? str_replace('-', ' ', $post->category)) : str_replace('-', ' ', $post->category) }}
                        </span>
                    </div>
                    <div class="p-5 flex flex-col flex-1">
                        <div class="flex items-center gap-3 text-xs text-gray-400 mb-3">
                            <span>{{ $post->created_at->format('M d, Y') }}</span>
                            <span>{{ $post->views ?? 0 }} {{ $lang === 'ar' ? 'مشاهدة' : 'views' }}</span>
                        </div>
                        <h2 class="font-bold text-dxn-darkgreen text-lg mb-2 group-hover:text-dxn-green transition-colors line-clamp-2{{ ($lang === 'ar' && !$post->title_ar) ? ' ar-translate' : '' }}"
                            @if($lang === 'ar' && !$post->title_ar) data-en="{{ $post->title }}" @endif>{{ ($lang === 'ar' && $post->title_ar) ? $post->title_ar : $post->title }}</h2>
                        <p class="text-gray-600 text-sm mb-4 line-clamp-3 flex-1{{ ($lang === 'ar' && !$post->excerpt_ar && $post->excerpt) ? ' ar-translate' : '' }}"
                            @if($lang === 'ar' && !$post->excerpt_ar && $post->excerpt) data-en="{{ $post->excerpt }}" @endif>{{ ($lang === 'ar' && $post->excerpt_ar) ? $post->excerpt_ar : $post->excerpt }}</p>
                        <span class="text-dxn-green text-sm font-semibold">{{ $lang === 'ar' ? '← اقرأ المزيد' : 'Read More →' }}</span>
                    </div>
                </a>
            @endforeach
        </div>
        <div class="mt-10">{{ $posts->links() }}</div>
    @else
        <div class="text-center py-20 text-gray-600">
            <p class="text-xl">{{ $lang === 'ar' ? 'لا توجد مقالات في هذه الفئة' : 'No articles found in this category' }}</p>
        </div>
    @endif
</div>

<section class="py-20 relative overflow-hidden" aria-labelledby="blog-cta-heading">
    <div class="absolute inset-0 bg-fixed bg-center bg-cover" style="background-image: url('/cta-bg.jpeg');" aria-hidden="true"></div>
    <div class="absolute inset-0" style="background: rgba(0,0,0,0.75);" aria-hidden="true"></div>
    <div class="max-w-2xl mx-auto px-4 text-center relative z-10">
        <h2 id="blog-cta-heading" class="text-3xl font-bold text-white mb-4">{{ $lang === 'ar' ? 'هل تريد الكتابة لنا؟' : 'Want to Write for Us?' }}</h2>
        <p class="text-white text-lg mb-8">{{ $lang === 'ar' ? 'شارك قصة نجاحك في DXN أو نصائحك الصحية مع مجتمعنا المتنامي.' : 'Share your DXN success story or health tips with our growing community.' }}</p>
        <a href="{{ route('contact') }}" class="btn-gold">{{ $lang === 'ar' ? 'تواصل معنا' : 'Contact Us' }}</a>
    </div>
</section>
@if($lang === 'ar')
<script>
(function () {
    const CACHE_KEY = 'blog_ar_card_cache_v2';
    let cache = {};
    try { cache = JSON.parse(sessionStorage.getItem(CACHE_KEY) || '{}'); } catch(e) {}

    async function translateText(text) {
        if (cache[text]) return cache[text];
        try {
            const url = 'https://api.mymemory.translated.net/get?q=' + encodeURIComponent(text) + '&langpair=en|ar&de=tahaminabd1339722@gmail.com';
            const res = await fetch(url);
            if (!res.ok) return null;
            const data = await res.json();
            const translated = data.responseData?.translatedText;
            if (translated && !translated.startsWith('MYMEMORY WARNING')) {
                cache[text] = translated;
                try { sessionStorage.setItem(CACHE_KEY, JSON.stringify(cache)); } catch(e) {}
                return translated;
            }
        } catch (e) {}
        return null;
    }

    async function translateCards() {
        const elements = document.querySelectorAll('.ar-translate[data-en]');
        for (const el of elements) {
            const text = el.getAttribute('data-en');
            if (!text) continue;
            const translated = await translateText(text);
            if (translated) el.textContent = translated;
            await new Promise(r => setTimeout(r, 200));
        }
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', translateCards);
    } else {
        translateCards();
    }
})();
</script>
@endif
@endsection
