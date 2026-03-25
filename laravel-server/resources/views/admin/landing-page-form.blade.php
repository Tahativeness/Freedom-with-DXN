@extends('layouts.app')
@section('title', ($page ? 'Edit' : 'Create') . ' Landing Page - Admin')

@php
    $isEdit = $page !== null;
@endphp

@section('content')
<div class="max-w-4xl mx-auto px-4 py-8">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-dxn-darkgreen">{{ $isEdit ? 'Edit' : 'Create' }} Landing Page</h1>
        <a href="{{ route('admin.landing-pages') }}" class="text-dxn-green hover:underline text-sm">← Back to Landing Pages</a>
    </div>

    @if($errors->any())
        <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded mb-4">
            <ul class="list-disc list-inside text-sm">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ $isEdit ? route('admin.landing-pages.update', $page) : route('admin.landing-pages.store') }}" class="space-y-6">
        @csrf
        @if($isEdit) @method('PUT') @endif

        {{-- Basic Info --}}
        <div class="card p-6">
            <h2 class="font-bold text-dxn-darkgreen text-lg mb-4">Basic Info</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Page Title *</label>
                    <input type="text" name="title" required value="{{ old('title', $page->title ?? '') }}" class="input-field" placeholder="e.g. Ganozhi Lipstick - Pearly Pink">
                    <p class="text-xs text-gray-400 mt-1">URL will be auto-generated from title</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Link to Product</label>
                    <select name="product_id" class="input-field">
                        <option value="">— No product —</option>
                        @foreach($products as $product)
                            <option value="{{ $product->id }}" {{ old('product_id', $page->product_id ?? '') == $product->id ? 'selected' : '' }}>
                                {{ $product->name }} (${{ number_format($product->price, 2) }})
                            </option>
                        @endforeach
                    </select>
                    <p class="text-xs text-gray-400 mt-1">Clicking this product on your site will open this landing page</p>
                </div>
            </div>
            <div class="flex items-center gap-2 mt-4">
                <input type="checkbox" name="published" id="published" value="1" {{ old('published', $page->published ?? true) ? 'checked' : '' }}>
                <label for="published" class="text-sm text-gray-700">Published (visible to visitors)</label>
            </div>
        </div>

        {{-- Hero Section --}}
        <div class="card p-6">
            <h2 class="font-bold text-dxn-darkgreen text-lg mb-4">Hero Section</h2>
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Hero Title *</label>
                    <input type="text" name="hero_title" required value="{{ old('hero_title', $page->hero_title ?? '') }}" class="input-field" placeholder="e.g. Ganozhi Lipstick — Pearly Pink">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Hero Subtitle</label>
                    <textarea name="hero_subtitle" rows="2" class="input-field" placeholder="Short description...">{{ old('hero_subtitle', $page->hero_subtitle ?? '') }}</textarea>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Hero Background Image URL</label>
                        <input type="text" name="hero_image" value="{{ old('hero_image', $page->hero_image ?? '') }}" class="input-field" placeholder="https://...">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Hero Background Color</label>
                        <div class="flex items-center gap-2">
                            <input type="color" id="hero_bg_color_picker" name="hero_bg_color" value="{{ old('hero_bg_color', $page->hero_bg_color ?? '#452aa8') }}" class="w-10 h-10 rounded border cursor-pointer" oninput="document.getElementById('hero_bg_color_text').value = this.value">
                            <input type="text" id="hero_bg_color_text" value="{{ old('hero_bg_color', $page->hero_bg_color ?? '#452aa8') }}" class="input-field flex-1" oninput="document.getElementById('hero_bg_color_picker').value = this.value; document.getElementById('hero_bg_color_picker').name = ''; this.name = 'hero_bg_color';">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- CTA --}}
        <div class="card p-6">
            <h2 class="font-bold text-dxn-darkgreen text-lg mb-4">Call to Action</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Button Text</label>
                    <input type="text" name="cta_text" value="{{ old('cta_text', $page->cta_text ?? 'Order Now via WhatsApp') }}" class="input-field">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Button Link</label>
                    <input type="text" name="cta_link" value="{{ old('cta_link', $page->cta_link ?? 'https://wa.me/message/EFSQ2IDNVG3YB1') }}" class="input-field">
                </div>
            </div>
        </div>

        {{-- Features & Benefits --}}
        <div class="card p-6">
            <h2 class="font-bold text-dxn-darkgreen text-lg mb-4">Features & Benefits</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Features (one per line)</label>
                    <textarea name="features_text" rows="5" class="input-field" placeholder="Ganoderma-infused&#10;Long-lasting color&#10;Moisturizing formula">{{ old('features_text', implode("\n", $page->features ?? [])) }}</textarea>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Benefits (one per line)</label>
                    <textarea name="benefits_text" rows="5" class="input-field" placeholder="Natural ingredients&#10;No harmful chemicals&#10;Suitable for all skin types">{{ old('benefits_text', implode("\n", $page->benefits ?? [])) }}</textarea>
                </div>
            </div>
        </div>

        {{-- Gallery --}}
        <div class="card p-6">
            <h2 class="font-bold text-dxn-darkgreen text-lg mb-4">Image Gallery</h2>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Image URLs (one per line)</label>
                <textarea name="gallery_text" rows="4" class="input-field" placeholder="https://example.com/image1.jpg&#10;https://example.com/image2.jpg">{{ old('gallery_text', implode("\n", $page->gallery ?? [])) }}</textarea>
            </div>
        </div>

        {{-- Custom Content --}}
        <div class="card p-6">
            <h2 class="font-bold text-dxn-darkgreen text-lg mb-4">Custom Content (Optional)</h2>
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Extra HTML Content</label>
                    <textarea name="custom_html" rows="6" class="input-field font-mono text-sm" placeholder="<div>Your custom HTML here...</div>">{{ old('custom_html', $page->custom_html ?? '') }}</textarea>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Custom CSS</label>
                    <textarea name="custom_css" rows="4" class="input-field font-mono text-sm" placeholder=".hero { background: linear-gradient(...); }">{{ old('custom_css', $page->custom_css ?? '') }}</textarea>
                </div>
            </div>
        </div>

        {{-- Submit --}}
        <div class="flex items-center gap-4">
            <button type="submit" class="btn-primary">{{ $isEdit ? 'Update Landing Page' : 'Create Landing Page' }}</button>
            <a href="{{ route('admin.landing-pages') }}" class="text-gray-500 hover:text-gray-700">Cancel</a>
        </div>
    </form>
</div>
@endsection
