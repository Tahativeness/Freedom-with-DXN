@extends('layouts.app')
@section('title', 'Manage Blog - Admin')

@section('content')
<style>
    @media (max-width: 768px) {
        .blog-admin-wrap { padding-left: 12px !important; padding-right: 12px !important; }
        .blog-admin-wrap .card { border-radius: 0 !important; }
        .blog-admin-wrap table th,
        .blog-admin-wrap table td { padding: 8px 10px !important; font-size: 13px !important; }
        .blog-admin-wrap .content-toggle { flex-wrap: wrap; gap: 8px !important; }
        .blog-admin-wrap .content-toggle .mode-hint { display: none; }
        .blog-admin-wrap details { border-radius: 0 !important; }
    }
</style>
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 blog-admin-wrap">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-dxn-darkgreen">Blog Posts</h1>
        <a href="{{ route('admin.index') }}" class="text-dxn-green hover:underline text-sm">Back to Admin</a>
    </div>

    @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg mb-6">{{ session('success') }}</div>
    @endif

    <details class="card p-6 mb-8">
        <summary class="font-bold text-dxn-darkgreen cursor-pointer">+ New Blog Post</summary>
        <form method="POST" action="{{ route('admin.blogs.store') }}" class="mt-4 space-y-4">
            @csrf

            {{-- Content Type Toggle --}}
            <div class="flex flex-wrap items-center gap-4 p-3 bg-gray-50 rounded-lg border content-toggle">
                <span class="text-sm font-medium text-gray-700">Content Mode:</span>
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="radio" name="content_type" value="rich_text" checked onchange="toggleContentMode(this.value)" class="text-dxn-green">
                    <span class="text-sm">Rich Text Editor</span>
                </label>
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="radio" name="content_type" value="full_html" onchange="toggleContentMode(this.value)" class="text-dxn-green">
                    <span class="text-sm">Full HTML Page</span>
                </label>
                <span id="mode-hint-rich" class="text-xs text-gray-400 ml-2 mode-hint">Normal blog post with TinyMCE editor</span>
                <span id="mode-hint-html" class="text-xs text-gray-400 ml-2 hidden mode-hint">Paste a complete HTML document with its own styles</span>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div><label class="block text-sm font-medium text-gray-700 mb-1">Title *</label><input type="text" name="title" required class="input-field"></div>
                <div><label class="block text-sm font-medium text-gray-700 mb-1">Category *</label>
                    <select name="category" required class="input-field">
                        @foreach(['health','business','products','success-stories','tips'] as $cat)
                            <option value="{{ $cat }}">{{ ucfirst(str_replace('-', ' ', $cat)) }}</option>
                        @endforeach
                    </select>
                </div>
                <div><label class="block text-sm font-medium text-gray-700 mb-1">Image URL</label><input type="text" name="image" class="input-field"></div>
                <div class="flex items-center pt-6"><label class="flex items-center gap-2"><input type="checkbox" name="published" value="1" checked> Published</label></div>
            </div>
            <div><label class="block text-sm font-medium text-gray-700 mb-1">Excerpt</label><input type="text" name="excerpt" class="input-field"></div>

            {{-- Rich Text Editor (default) --}}
            <div id="editor-rich">
                <label class="block text-sm font-medium text-gray-700 mb-1">Content *</label>
                <textarea id="content" name="content" rows="8" class="input-field"></textarea>
            </div>

            {{-- Full HTML Editor (hidden by default) --}}
            <div id="editor-html" class="hidden">
                <label class="block text-sm font-medium text-gray-700 mb-1">Full HTML *</label>
                <p class="text-xs text-gray-400 mb-2">Paste a complete HTML document (with &lt;html&gt;, &lt;head&gt;, &lt;style&gt;, &lt;body&gt;). It will be rendered as a standalone page.</p>
                <textarea id="content-html" name="content_html" rows="16" class="input-field font-mono text-sm" style="min-height:400px;" placeholder="<!DOCTYPE html>
<html lang=&quot;en&quot;>
<head>...</head>
<body>...</body>
</html>"></textarea>
                <div class="mt-2 flex gap-2">
                    <button type="button" onclick="previewHtml()" class="text-sm text-dxn-green hover:underline">Preview in new tab</button>
                </div>
            </div>

            <button type="submit" class="btn-primary">Publish Post</button>
        </form>
    </details>

    {{-- Desktop table --}}
    <div class="card overflow-x-auto hidden md:block">
        <table class="w-full text-sm whitespace-nowrap">
            <thead class="bg-gray-50"><tr><th class="px-4 py-3 text-left">Title</th><th class="px-4 py-3 text-left">Type</th><th class="px-4 py-3 text-left">Category</th><th class="px-4 py-3 text-left">Views</th><th class="px-4 py-3 text-left">Status</th><th class="px-4 py-3 text-left">Actions</th></tr></thead>
            <tbody>
                @forelse($blogs as $blog)
                    <tr class="border-t">
                        <td class="px-4 py-3 font-medium max-w-xs truncate">{{ Str::limit($blog->title, 40) }}</td>
                        <td class="px-4 py-3">
                            @if($blog->content_type === 'full_html')
                                <span class="badge bg-purple-100 text-purple-700 text-xs">HTML Page</span>
                            @else
                                <span class="badge bg-blue-100 text-blue-700 text-xs">Rich Text</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-gray-500 capitalize">{{ str_replace('-', ' ', $blog->category) }}</td>
                        <td class="px-4 py-3 text-gray-500">{{ $blog->views ?? 0 }}</td>
                        <td class="px-4 py-3"><span class="badge {{ $blog->published ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-700' }}">{{ $blog->published ? 'Published' : 'Draft' }}</span></td>
                        <td class="px-4 py-3">
                            <div class="flex items-center gap-2">
                            <a href="{{ route('admin.blogs.edit', $blog) }}" class="text-blue-600 hover:underline text-sm">Edit</a>
                            <a href="{{ route('blog.show', $blog) }}" target="_blank" class="text-dxn-green hover:underline text-sm">View</a>
                            <form class="inline" method="POST" action="{{ route('admin.blogs.destroy', $blog) }}" onsubmit="return confirm('Delete this post?')">
                                @csrf @method('DELETE')
                                <button class="text-red-500 hover:text-red-700 text-sm">Delete</button>
                            </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="px-4 py-8 text-center text-gray-400">No blog posts yet.</td></tr>
                @endforelse
            </tbody>
        </table>
        <div class="p-4">{{ $blogs->links() }}</div>
    </div>

    {{-- Mobile cards --}}
    <div class="md:hidden space-y-3">
        @forelse($blogs as $blog)
            <div class="card p-4">
                <div class="flex items-start justify-between gap-2 mb-2">
                    <h3 class="font-medium text-sm leading-tight">{{ $blog->title }}</h3>
                    <span class="badge flex-shrink-0 {{ $blog->published ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-700' }} text-xs">{{ $blog->published ? 'Live' : 'Draft' }}</span>
                </div>
                <div class="flex items-center gap-2 mb-3 text-xs text-gray-500">
                    @if($blog->content_type === 'full_html')
                        <span class="badge bg-purple-100 text-purple-700 text-xs">HTML</span>
                    @else
                        <span class="badge bg-blue-100 text-blue-700 text-xs">Rich Text</span>
                    @endif
                    <span class="capitalize">{{ str_replace('-', ' ', $blog->category) }}</span>
                    <span>{{ $blog->views ?? 0 }} views</span>
                </div>
                <div class="flex gap-3 border-t pt-2">
                    <a href="{{ route('admin.blogs.edit', $blog) }}" class="text-blue-600 hover:underline text-sm font-medium">Edit</a>
                    <a href="{{ route('blog.show', $blog) }}" target="_blank" class="text-dxn-green hover:underline text-sm font-medium">View</a>
                    <form method="POST" action="{{ route('admin.blogs.destroy', $blog) }}" onsubmit="return confirm('Delete this post?')">
                        @csrf @method('DELETE')
                        <button class="text-red-500 hover:text-red-700 text-sm font-medium">Delete</button>
                    </form>
                </div>
            </div>
        @empty
            <div class="card p-8 text-center text-gray-400">No blog posts yet.</div>
        @endforelse
        <div class="p-4">{{ $blogs->links() }}</div>
    </div>
</div>

<!-- TinyMCE Rich Text Editor -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/6.8.3/tinymce.min.js"></script>
<script>
    let tinyEditor = null;

    function initTinyMCE() {
        if (tinyEditor) return;
        tinymce.init({
            selector: '#content',
            plugins: 'lists link image',
            toolbar: 'undo redo | h1 h2 h3 | bold italic underline | alignleft aligncenter alignright | bullist numlist | link image | removeformat',
            menubar: false,
            height: 400,
            content_css: false,
            body_class: 'prose',
            setup: function(editor) {
                tinyEditor = editor;
                editor.on('change', function() {
                    tinymce.triggerSave();
                });
            }
        });
    }

    function toggleContentMode(mode) {
        const richEditor = document.getElementById('editor-rich');
        const htmlEditor = document.getElementById('editor-html');
        const hintRich = document.getElementById('mode-hint-rich');
        const hintHtml = document.getElementById('mode-hint-html');
        const contentField = document.getElementById('content');
        const htmlField = document.getElementById('content-html');

        if (mode === 'full_html') {
            richEditor.classList.add('hidden');
            htmlEditor.classList.remove('hidden');
            hintRich.classList.add('hidden');
            hintHtml.classList.remove('hidden');
            // Remove required and set placeholder value so form submits
            contentField.removeAttribute('required');
            contentField.value = 'full_html';
            htmlField.setAttribute('required', 'required');
            // Destroy TinyMCE if active
            if (tinyEditor) {
                tinyEditor.destroy();
                tinyEditor = null;
            }
        } else {
            richEditor.classList.remove('hidden');
            htmlEditor.classList.add('hidden');
            hintRich.classList.remove('hidden');
            hintHtml.classList.add('hidden');
            contentField.setAttribute('required', 'required');
            if (contentField.value === 'full_html') contentField.value = '';
            htmlField.removeAttribute('required');
            // Re-init TinyMCE
            initTinyMCE();
        }
    }

    function previewHtml() {
        const html = document.getElementById('content-html').value;
        if (!html.trim()) { alert('Paste your HTML first.'); return; }
        const win = window.open('', '_blank');
        win.document.write(html);
        win.document.close();
    }

    // Init TinyMCE on page load (default mode)
    initTinyMCE();
</script>
@endsection
