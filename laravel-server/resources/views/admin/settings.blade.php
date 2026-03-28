@extends('layouts.app')
@section('title', 'Site Settings - Admin')

@php
    $social = $settings->social ?? [];
    $contact = $settings->contact ?? [];
@endphp

@section('content')
<div class="max-w-4xl mx-auto px-4 py-8">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold" style="color: #452aa8;">Site Settings</h1>
        <a href="{{ route('admin.index') }}" class="text-brand-green hover:underline text-sm">← Back to Admin</a>
    </div>

    <form method="POST" action="{{ route('admin.settings.update') }}" class="space-y-6">
        @csrf
        @method('PUT')

        {{-- Social Media Links --}}
        <div class="card p-6">
            <h2 class="font-bold text-lg mb-4" style="color: #452aa8;">Social Media Links</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Facebook</label>
                    <input type="url" name="social[facebook]" value="{{ $social['facebook'] ?? '' }}" class="input-field" placeholder="https://facebook.com/yourpage">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Instagram</label>
                    <input type="url" name="social[instagram]" value="{{ $social['instagram'] ?? '' }}" class="input-field" placeholder="https://instagram.com/yourpage">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">TikTok</label>
                    <input type="url" name="social[tiktok]" value="{{ $social['tiktok'] ?? '' }}" class="input-field" placeholder="https://tiktok.com/@yourpage">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Threads</label>
                    <input type="url" name="social[threads]" value="{{ $social['threads'] ?? '' }}" class="input-field" placeholder="https://threads.net/@yourpage">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">LinkedIn</label>
                    <input type="url" name="social[linkedin]" value="{{ $social['linkedin'] ?? '' }}" class="input-field" placeholder="https://linkedin.com/in/yourprofile">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Quora</label>
                    <input type="url" name="social[quora]" value="{{ $social['quora'] ?? '' }}" class="input-field" placeholder="https://quora.com/profile/yourprofile">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">YouTube</label>
                    <input type="url" name="social[youtube]" value="{{ $social['youtube'] ?? '' }}" class="input-field" placeholder="https://youtube.com/@yourchannel">
                </div>
            </div>
        </div>

        {{-- Contact Info --}}
        <div class="card p-6">
            <h2 class="font-bold text-lg mb-4" style="color: #452aa8;">Contact Information</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Phone</label>
                    <input type="text" name="contact[phone]" value="{{ $contact['phone'] ?? '' }}" class="input-field" placeholder="+971 50 666 2875">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input type="email" name="contact[email]" value="{{ $contact['email'] ?? '' }}" class="input-field" placeholder="info@freedomwithdxn.com">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">WhatsApp Link</label>
                    <input type="url" name="contact[whatsapp]" value="{{ $contact['whatsapp'] ?? '' }}" class="input-field" placeholder="https://wa.me/message/...">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Location</label>
                    <input type="text" name="contact[location]" value="{{ $contact['location'] ?? '' }}" class="input-field" placeholder="United Arab Emirates">
                </div>
            </div>
        </div>

        {{-- Navbar Links --}}
        <div class="card p-6">
            <h2 class="font-bold text-lg mb-4" style="color: #452aa8;">Navbar Links</h2>
            <p class="text-sm text-gray-500 mb-4">Toggle which links appear in the navigation bar.</p>
            @php $nb = $settings->navbar ?? []; @endphp
            <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                @foreach([
                    ['key' => 'showHome', 'label' => 'Home'],
                    ['key' => 'showAbout', 'label' => 'About'],
                    ['key' => 'showProducts', 'label' => 'Products'],
                    ['key' => 'showJoin', 'label' => 'Join DXN'],
                    ['key' => 'showBlog', 'label' => 'Blog'],
                    ['key' => 'showContact', 'label' => 'Contact'],
                ] as $item)
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="hidden" name="navbar[{{ $item['key'] }}]" value="0">
                        <input type="checkbox" name="navbar[{{ $item['key'] }}]" value="1" {{ ($nb[$item['key']] ?? true) ? 'checked' : '' }} class="rounded">
                        <span class="text-sm font-medium text-gray-700">{{ $item['label'] }}</span>
                    </label>
                @endforeach
            </div>
        </div>

        <button type="submit" class="btn-primary">Save Settings</button>
    </form>
</div>
@endsection
