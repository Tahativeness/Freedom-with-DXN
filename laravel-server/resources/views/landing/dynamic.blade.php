@extends('layouts.app')
@section('title', $page->hero_title . ' | DXN')

@if($page->custom_css)
    @push('styles')
        <style>{!! $page->custom_css !!}</style>
    @endpush
@endif

@section('content')

    {{-- Hero Section --}}
    <section class="min-h-[90vh] flex items-center justify-center text-center text-white relative overflow-hidden"
             style="background: {{ $page->hero_image ? "linear-gradient(rgba(0,0,0,.55), rgba(0,0,0,.55)), url('{$page->hero_image}') center/cover no-repeat" : $page->hero_bg_color }};">
        <div class="max-w-3xl mx-auto px-6 py-20 relative z-10">
            @if($page->product)
                <span class="inline-block bg-white/20 text-white/90 px-4 py-1 rounded-full text-sm font-medium mb-6 backdrop-blur-sm">
                    {{ ucfirst($page->product->category) }}
                </span>
            @endif
            <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold mb-6 leading-tight">{{ $page->hero_title }}</h1>
            @if($page->hero_subtitle)
                <p class="text-lg md:text-xl text-white/85 mb-8 max-w-2xl mx-auto leading-relaxed">{{ $page->hero_subtitle }}</p>
            @endif
            <a href="{{ $page->cta_link }}" target="_blank" rel="noopener noreferrer"
               class="inline-flex items-center gap-3 text-white font-bold px-8 py-4 rounded-full text-lg shadow-lg hover:shadow-xl transition-all hover:scale-105" style="background-color: #bf3c36;">
                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                {{ $page->cta_text }}
            </a>
            <p class="mt-6"><a href="{{ route('products') }}" class="text-white/70 hover:text-white underline text-sm">← Back to all products</a></p>
        </div>
    </section>

    {{-- Features --}}
    @if(!empty($page->features))
        <section class="py-16 bg-white">
            <div class="max-w-4xl mx-auto px-6">
                <h2 class="text-3xl font-bold text-center mb-10" style="color: #452aa8;">Features</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @foreach($page->features as $feature)
                        <div class="flex items-center gap-3 p-4 rounded-xl" style="background: #e8f5ee;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#43af73" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                            <span class="text-gray-700 font-medium">{{ $feature }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    {{-- Benefits --}}
    @if(!empty($page->benefits))
        <section class="py-16 bg-gray-50">
            <div class="max-w-4xl mx-auto px-6">
                <h2 class="text-3xl font-bold text-center mb-10" style="color: #452aa8;">Benefits</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    @foreach($page->benefits as $benefit)
                        <div class="card p-6 text-center" style="border-top: 4px solid #43af73;">
                            <div class="w-12 h-12 rounded-full flex items-center justify-center mx-auto mb-3" style="background: rgba(67,175,115,0.1);">
                                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#43af73" stroke-width="2"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg>
                            </div>
                            <p class="text-gray-700 font-medium">{{ $benefit }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    {{-- Gallery --}}
    @if(!empty($page->gallery))
        <section class="py-16 bg-white">
            <div class="max-w-5xl mx-auto px-6">
                <h2 class="text-3xl font-bold text-center mb-10" style="color: #452aa8;">Gallery</h2>
                <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                    @foreach($page->gallery as $img)
                        <div class="aspect-square rounded-xl overflow-hidden shadow-md">
                            <img src="{{ $img }}" alt="{{ $page->title }}" class="w-full h-full object-cover hover:scale-105 transition-transform duration-300">
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    {{-- Product Info --}}
    @if($page->product)
        <section class="py-16" style="background-color: #452aa8;">
            <div class="max-w-4xl mx-auto px-6 text-center">
                <h2 class="text-3xl font-bold text-white mb-4">{{ $page->product->name }}</h2>
                <p class="text-white/70 mb-2 max-w-2xl mx-auto">{{ $page->product->description }}</p>
                <p class="text-4xl font-bold my-6" style="color: #43af73;">${{ number_format($page->product->price, 2) }}</p>
                <a href="{{ $page->cta_link }}" target="_blank"
                   class="inline-flex items-center gap-2 text-white text-lg px-8 py-4 rounded-xl font-bold transition-all hover:scale-105" style="background-color: #bf3c36;">
                    {{ $page->cta_text }}
                </a>
            </div>
        </section>
    @endif

    {{-- Custom HTML --}}
    @if($page->custom_html)
        <section class="py-16">
            <div class="max-w-5xl mx-auto px-6">
                {!! $page->custom_html !!}
            </div>
        </section>
    @endif

@endsection
