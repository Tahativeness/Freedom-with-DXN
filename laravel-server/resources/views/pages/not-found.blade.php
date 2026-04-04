@extends('layouts.app')
@section('title', '404 - Page Not Found')

@section('content')
<div class="min-h-screen flex flex-col items-center justify-center px-4">
    <div class="text-8xl font-bold text-dxn-gold mb-4">404</div>
    <h1 class="text-2xl font-bold text-dxn-darkgreen mb-2">Page Not Found</h1>
    <p class="text-gray-600 mb-6">The page you're looking for doesn't exist or has been moved.</p>
    <a href="{{ route('home') }}" class="btn-primary">Go Home</a>
</div>
@endsection
