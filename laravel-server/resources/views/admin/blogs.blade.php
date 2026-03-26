@extends('layouts.app')
@section('title', 'Manage Blog - Admin')

@section('content')
<div class="max-w-6xl mx-auto px-4 py-8">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-dxn-darkgreen">Blog Posts</h1>
        <a href="{{ route('admin.index') }}" class="text-dxn-green hover:underline text-sm">← Back to Admin</a>
    </div>

    <details class="card p-6 mb-8">
        <summary class="font-bold text-dxn-darkgreen cursor-pointer">+ New Blog Post</summary>
        <form method="POST" action="{{ route('admin.blogs.store') }}" class="mt-4 space-y-4">
            @csrf
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
            <div><label class="block text-sm font-medium text-gray-700 mb-1">Content *</label><textarea id="content" name="content" required rows="8" class="input-field"></textarea></div>
            <button type="submit" class="btn-primary">Publish Post</button>
        </form>
    </details>

    <div class="card overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-50"><tr><th class="px-4 py-3 text-left">Title</th><th class="px-4 py-3 text-left">Category</th><th class="px-4 py-3 text-left">Views</th><th class="px-4 py-3 text-left">Status</th><th class="px-4 py-3 text-left">Actions</th></tr></thead>
            <tbody>
                @forelse($blogs as $blog)
                    <tr class="border-t">
                        <td class="px-4 py-3 font-medium">{{ Str::limit($blog->title, 40) }}</td>
                        <td class="px-4 py-3 text-gray-500 capitalize">{{ str_replace('-', ' ', $blog->category) }}</td>
                        <td class="px-4 py-3 text-gray-500">{{ $blog->views ?? 0 }}</td>
                        <td class="px-4 py-3"><span class="badge {{ $blog->published ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-700' }}">{{ $blog->published ? 'Published' : 'Draft' }}</span></td>
                        <td class="px-4 py-3">
                            <form method="POST" action="{{ route('admin.blogs.destroy', $blog) }}" onsubmit="return confirm('Delete this post?')">
                                @csrf @method('DELETE')
                                <button class="text-red-500 hover:text-red-700 text-sm">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="px-4 py-8 text-center text-gray-400">No blog posts yet.</td></tr>
                @endforelse
            </tbody>
        </table>
        <div class="p-4">{{ $blogs->links() }}</div>
    </div>
</div>

<!-- TinyMCE Rich Text Editor -->
<script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/6/tinymce.min.js"></script>
<script>
    tinymce.init({
        selector: '#content',
        plugins: 'lists link image',
        toolbar: 'undo redo | h1 h2 h3 | bold italic underline | alignleft aligncenter alignright | bullist numlist | link image | removeformat',
        menubar: false,
        height: 400,
        content_css: false,
        body_class: 'prose',
        setup: function(editor) {
            // Optional: ensure content is updated in the textarea before form submit
            editor.on('change', function() {
                tinymce.triggerSave();
            });
        }
    });
</script>
@endsection
