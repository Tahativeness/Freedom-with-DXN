@extends('layouts.app')
@section('title', 'Login - Freedom with DXN')

@section('content')
<div class="min-h-screen bg-gray-50 flex items-center justify-center px-4 py-12">
    <div class="w-full max-w-md">
        <div class="text-center mb-8">
            <div class="w-16 h-16 bg-dxn-green rounded-full flex items-center justify-center text-white font-bold text-xl mx-auto mb-4">DXN</div>
            <h1 class="text-2xl font-bold text-dxn-darkgreen">Welcome Back</h1>
            <p class="text-gray-500 mt-1">Sign in to your Grow with DXN account</p>
        </div>

        <div class="bg-white rounded-2xl shadow-lg p-8">
            <form method="POST" action="{{ route('login') }}" class="space-y-5">
                @csrf
                @if($errors->any())
                    <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg text-sm">
                        {{ $errors->first() }}
                    </div>
                @endif
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                    <input type="email" name="email" required value="{{ old('email') }}" class="input-field" placeholder="you@example.com">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                    <input type="password" name="password" required class="input-field" placeholder="••••••••">
                </div>
                <div class="flex items-center gap-2">
                    <input type="checkbox" name="remember" id="remember" class="rounded">
                    <label for="remember" class="text-sm text-gray-600">Remember me</label>
                </div>
                <button type="submit" class="btn-primary w-full">Sign In</button>
            </form>

            <p class="text-center text-sm text-gray-500 mt-6">
                Don't have an account?
                <a href="{{ route('register') }}" class="text-dxn-green font-semibold hover:underline">Create one free</a>
            </p>
        </div>
    </div>
</div>
@endsection
