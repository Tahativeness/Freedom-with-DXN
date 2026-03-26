@extends('layouts.app')
@section('title', 'Landing Pages - Admin')

@section('content')
<div class="max-w-6xl mx-auto px-4 py-8">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-dxn-darkgreen">Landing Pages</h1>
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.index') }}" class="text-dxn-green hover:underline text-sm">← Back to Admin</a>
            <a href="{{ route('admin.landing-pages.create') }}" class="btn-primary text-sm">+ Create Landing Page</a>
        </div>
    </div>

    <div class="card overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-3 text-left w-12">#</th>
                    <th class="px-4 py-3 text-left">Title</th>
                    <th class="px-4 py-3 text-left">Product</th>
                    <th class="px-4 py-3 text-left">URL</th>
                    <th class="px-4 py-3 text-left">Status</th>
                    <th class="px-4 py-3 text-left">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pages as $page)
                    <tr class="border-t">
                        <td class="px-4 py-3 text-gray-400 text-xs">{{ $pages->firstItem() + $loop->index }}</td>
                        <td class="px-4 py-3 font-medium">{{ $page->title }}</td>
                        <td class="px-4 py-3 text-gray-500">{{ $page->product->name ?? '—' }}</td>
                        <td class="px-4 py-3">
                            <a href="{{ route('landing', $page->slug) }}" target="_blank" class="text-dxn-green hover:underline text-xs">/landing/{{ $page->slug }}</a>
                        </td>
                        <td class="px-4 py-3">
                            @if($page->published)
                                <a href="{{ route('landing', $page->slug) }}" target="_blank" class="inline-block bg-brand-green text-white text-xs font-semibold px-3 py-1.5 rounded-full hover:bg-brand-green-dark transition-colors">Live ↗</a>
                            @else
                                <span class="badge bg-gray-100 text-gray-700">Draft</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 flex items-center gap-3">
                            <a href="{{ route('admin.landing-pages.edit', $page) }}" class="text-dxn-green hover:underline text-sm">Edit</a>
                            <form method="POST" action="{{ route('admin.landing-pages.destroy', $page) }}" onsubmit="return confirm('Delete this landing page?')">
                                @csrf @method('DELETE')
                                <button class="text-red-500 hover:text-red-700 text-sm">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="px-4 py-8 text-center text-gray-400">No landing pages yet. Create one!</td></tr>
                @endforelse
            </tbody>
        </table>
        <div class="p-4">{{ $pages->links() }}</div>
    </div>
</div>
@endsection
