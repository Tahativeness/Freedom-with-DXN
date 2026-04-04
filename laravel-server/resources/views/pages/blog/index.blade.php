@extends('layouts.app')
@section('title', 'DXN Blog – Health Tips, Product Reviews & Business Insights | Freedom With DXN')
@section('description', 'Read the latest DXN product reviews, health tips, Ganoderma mushroom benefits, and business success stories on the Freedom With DXN blog.')
@section('keywords', 'DXN product review, ganoderma mushroom benefits, DXN blog, health tips')

@php
    $lang = session('lang', 'en');
    $currentCategory = request('category', 'all');
    $blogCategories = ['all', 'health', 'business', 'products', 'success-stories', 'tips'];
@endphp

@section('content')
<div class="bg-dxn-darkgreen py-16 px-4">
    <div class="max-w-4xl mx-auto text-center">
        <span class="inline-block bg-dxn-gold/20 text-dxn-gold px-4 py-1 rounded-full text-sm font-medium mb-4">Blog & Articles</span>
        <h1 class="text-3xl md:text-4xl font-bold text-white mb-3">Health & Business Insights</h1>
        <p class="text-gray-300 max-w-2xl mx-auto">Tips, guides, and stories to help you grow your health and your DXN business</p>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 py-10">
    <div class="flex items-center gap-2 overflow-x-auto pb-2 mb-8">
        @foreach($blogCategories as $cat)
            <a href="{{ route('blog', $cat !== 'all' ? ['category' => $cat] : []) }}"
               class="px-4 py-2 rounded-full text-sm font-medium whitespace-nowrap transition-colors capitalize {{ $currentCategory === $cat ? 'bg-dxn-green text-white' : 'bg-white text-gray-600 hover:bg-gray-100 border' }}">
                {{ str_replace('-', ' ', $cat) }}
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
                            {{ str_replace('-', ' ', $post->category) }}
                        </span>
                    </div>
                    <div class="p-5 flex flex-col flex-1">
                        <div class="flex items-center gap-3 text-xs text-gray-400 mb-3">
                            <span>{{ $post->created_at->format('M d, Y') }}</span>
                            <span>{{ $post->views ?? 0 }} views</span>
                        </div>
                        <h2 class="font-bold text-dxn-darkgreen text-lg mb-2 group-hover:text-dxn-green transition-colors line-clamp-2">{{ $post->title }}</h2>
                        <p class="text-gray-600 text-sm mb-4 line-clamp-3 flex-1">{{ $post->excerpt }}</p>
                        <span class="text-dxn-green text-sm font-semibold">Read More →</span>
                    </div>
                </a>
            @endforeach
        </div>
        <div class="mt-10">{{ $posts->links() }}</div>
    @else
        <div class="text-center py-20 text-gray-500">
            <p class="text-xl">No articles found in this category</p>
        </div>
    @endif
</div>

<section class="py-20 relative overflow-hidden">
    <div class="absolute inset-0 bg-fixed bg-center bg-cover" style="background-image: url('/cta-bg.jpeg');"></div>
    <div class="absolute inset-0" style="background: rgba(0,0,0,0.6);"></div>
    <div class="max-w-2xl mx-auto px-4 text-center relative z-10">
        <h2 class="text-3xl font-bold text-white mb-4">Want to Write for Us?</h2>
        <p class="text-white/70 text-lg mb-8">Share your DXN success story or health tips with our growing community.</p>
        <a href="{{ route('contact') }}" class="btn-gold">Contact Us</a>
    </div>
</section>
@endsection
