@extends('layouts.app')
@section('title', $blog->title . ' | Freedom With DXN')
@section('description', Str::limit($blog->excerpt ?: strip_tags($blog->content), 155))
@section('og_type', 'article')
@if($blog->image)
    @section('og_image', url($blog->image))
@endif

@push('seo')
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "Article",
    "headline": "{{ $blog->title }}",
    "description": "{{ Str::limit($blog->excerpt ?: strip_tags($blog->content), 200) }}",
    @if($blog->image)"image": "{{ url($blog->image) }}",@endif
    "datePublished": "{{ $blog->created_at->toIso8601String() }}",
    "dateModified": "{{ $blog->updated_at->toIso8601String() }}",
    "author": {
        "@type": "Organization",
        "name": "Freedom with DXN",
        "url": "https://freedomwithdxn.com"
    },
    "publisher": {
        "@type": "Organization",
        "name": "Freedom with DXN",
        "logo": { "@type": "ImageObject", "url": "{{ url('/logo.png') }}" }
    },
    "mainEntityOfPage": {
        "@type": "WebPage",
        "@id": "{{ url()->current() }}"
    }
}
</script>
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "BreadcrumbList",
    "itemListElement": [
        { "@type": "ListItem", "position": 1, "name": "Home", "item": "https://freedomwithdxn.com" },
        { "@type": "ListItem", "position": 2, "name": "Blog", "item": "https://freedomwithdxn.com/blog" },
        { "@type": "ListItem", "position": 3, "name": "{{ $blog->title }}" }
    ]
}
</script>
@endpush

@php $lang = session('lang', 'en'); @endphp

@section('content')
<article class="max-w-4xl mx-auto px-4 py-12">
    <a href="{{ route('blog') }}" class="inline-flex items-center gap-2 text-dxn-green hover:text-dxn-darkgreen mb-6">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
        Back to Blog
    </a>

    <span class="inline-block bg-dxn-gold text-white text-xs px-3 py-1 rounded-full font-medium capitalize mb-4">
        {{ str_replace('-', ' ', $blog->category) }}
    </span>

    <h1 class="text-3xl md:text-4xl font-bold text-dxn-darkgreen mb-4">{{ ($lang === 'ar' && $blog->title_ar) ? $blog->title_ar : $blog->title }}</h1>

    <div class="flex items-center gap-4 text-sm text-gray-600 mb-8">
        <span>{{ $blog->created_at->format('F d, Y') }}</span>
        <span>{{ $blog->views ?? 0 }} views</span>
    </div>

    @if($blog->image)
        <img src="{{ $blog->image }}" alt="{{ $blog->title }}" loading="lazy" width="800" height="384" class="w-full rounded-2xl mb-8">
    @endif

    <div class="blog-html-content prose max-w-none">
        {!! $blog->content !!}
    </div>

    @if($related->count() > 0)
        <hr class="my-12">
        <h2 class="text-2xl font-bold text-dxn-darkgreen mb-6">Related Articles</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach($related as $post)
                <a href="{{ route('blog.show', $post) }}" class="card p-4 group">
                    <h3 class="font-semibold text-dxn-darkgreen group-hover:text-dxn-green transition-colors">{{ ($lang === 'ar' && $post->title_ar) ? $post->title_ar : $post->title }}</h3>
                    <p class="text-gray-600 text-sm mt-2 line-clamp-2">{{ ($lang === 'ar' && $post->excerpt_ar) ? $post->excerpt_ar : $post->excerpt }}</p>
                </a>
            @endforeach
        </div>
    @endif
</article>
@endsection
