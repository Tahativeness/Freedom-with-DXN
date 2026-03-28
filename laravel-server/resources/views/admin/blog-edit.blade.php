@extends('layouts.app')
@section('title', 'Edit Blog Post - Admin')

@section('content')
<div class="max-w-6xl mx-auto px-4 py-8">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-dxn-darkgreen">Edit: {{ $blog->title }}</h1>
        <div class="flex gap-3">
            <a href="{{ route('blog.show', $blog) }}" target="_blank" class="text-dxn-green hover:underline text-sm">View Live</a>
            <a href="{{ route('admin.blogs') }}" class="text-dxn-green hover:underline text-sm">← Back to Blog List</a>
        </div>
    </div>

    @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg mb-6">{{ session('success') }}</div>
    @endif

    <form method="POST" action="{{ route('admin.blogs.update', $blog) }}" class="card p-6 space-y-4">
        @csrf
        @method('PUT')

        {{-- Content Type Toggle --}}
        <div class="flex items-center gap-4 p-3 bg-gray-50 rounded-lg border">
            <span class="text-sm font-medium text-gray-700">Content Mode:</span>
            <label class="flex items-center gap-2 cursor-pointer">
                <input type="radio" name="content_type" value="rich_text" {{ ($blog->content_type ?? 'rich_text') !== 'full_html' ? 'checked' : '' }} onchange="toggleContentMode(this.value)">
                <span class="text-sm">Rich Text Editor</span>
            </label>
            <label class="flex items-center gap-2 cursor-pointer">
                <input type="radio" name="content_type" value="full_html" {{ ($blog->content_type ?? '') === 'full_html' ? 'checked' : '' }} onchange="toggleContentMode(this.value)">
                <span class="text-sm">Full HTML Page</span>
            </label>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div><label class="block text-sm font-medium text-gray-700 mb-1">Title *</label><input type="text" name="title" value="{{ $blog->title }}" required class="input-field"></div>
            <div><label class="block text-sm font-medium text-gray-700 mb-1">Category *</label>
                <select name="category" required class="input-field">
                    @foreach(['health','business','products','success-stories','tips'] as $cat)
                        <option value="{{ $cat }}" {{ $blog->category === $cat ? 'selected' : '' }}>{{ ucfirst(str_replace('-', ' ', $cat)) }}</option>
                    @endforeach
                </select>
            </div>
            <div><label class="block text-sm font-medium text-gray-700 mb-1">Image URL</label><input type="text" name="image" value="{{ $blog->image }}" class="input-field"></div>
            <div class="flex items-center pt-6"><label class="flex items-center gap-2"><input type="checkbox" name="published" value="1" {{ $blog->published ? 'checked' : '' }}> Published</label></div>
        </div>
        <div><label class="block text-sm font-medium text-gray-700 mb-1">Excerpt</label><input type="text" name="excerpt" value="{{ $blog->excerpt }}" class="input-field"></div>

        {{-- Rich Text Editor --}}
        <div id="editor-rich" class="{{ ($blog->content_type ?? 'rich_text') === 'full_html' ? 'hidden' : '' }}">
            <label class="block text-sm font-medium text-gray-700 mb-1">Content *</label>
            <textarea id="content" name="content" rows="8" class="input-field">{{ ($blog->content_type ?? 'rich_text') !== 'full_html' ? $blog->content : '' }}</textarea>
        </div>

        {{-- Full HTML Editor --}}
        <div id="editor-html" class="{{ ($blog->content_type ?? 'rich_text') !== 'full_html' ? 'hidden' : '' }}">
            <label class="block text-sm font-medium text-gray-700 mb-1">Full HTML *</label>
            <p class="text-xs text-gray-400 mb-2">Edit the complete HTML document. Use "Preview" to check your changes before saving.</p>
            <textarea id="content-html" name="content_html" rows="20" class="input-field font-mono text-sm" style="min-height:500px;">{{ ($blog->content_type ?? '') === 'full_html' ? $blog->content : '' }}</textarea>
            <div class="mt-2 flex gap-4">
                <button type="button" onclick="previewHtml()" class="text-sm text-dxn-green hover:underline">Preview in new tab</button>
                <button type="button" onclick="findAndReplace()" class="text-sm text-blue-600 hover:underline">Find & Replace</button>
            </div>
        </div>

        <div class="flex gap-3 pt-2">
            <button type="submit" class="btn-primary">Save Changes</button>
            <a href="{{ route('admin.blogs') }}" class="btn-primary" style="background: #6b7280;">Cancel</a>
        </div>
    </form>
</div>

{{-- Find & Replace Modal --}}
<div id="fr-modal" class="hidden fixed inset-0 bg-black/50 z-50 flex items-center justify-center">
    <div class="bg-white rounded-xl p-6 w-full max-w-md shadow-2xl">
        <h3 class="font-bold text-dxn-darkgreen mb-4">Find & Replace in HTML</h3>
        <div class="space-y-3">
            <div><label class="block text-sm font-medium text-gray-700 mb-1">Find</label><input id="fr-find" type="text" class="input-field" placeholder="Text or URL to find..."></div>
            <div><label class="block text-sm font-medium text-gray-700 mb-1">Replace with</label><input id="fr-replace" type="text" class="input-field" placeholder="New text or image URL..."></div>
        </div>
        <div class="flex gap-3 mt-4">
            <button onclick="doReplace()" class="btn-primary text-sm">Replace All</button>
            <button onclick="closeFR()" class="text-sm text-gray-500 hover:text-gray-700">Cancel</button>
        </div>
        <p id="fr-result" class="text-xs text-green-600 mt-2 hidden"></p>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/6.8.3/tinymce.min.js"></script>
<script>
    let tinyEditor = null;
    const isFullHtml = {{ ($blog->content_type ?? 'rich_text') === 'full_html' ? 'true' : 'false' }};

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
                editor.on('change', function() { tinymce.triggerSave(); });
            }
        });
    }

    function toggleContentMode(mode) {
        const richEditor = document.getElementById('editor-rich');
        const htmlEditor = document.getElementById('editor-html');
        const contentField = document.getElementById('content');
        const htmlField = document.getElementById('content-html');

        if (mode === 'full_html') {
            richEditor.classList.add('hidden');
            htmlEditor.classList.remove('hidden');
            contentField.removeAttribute('required');
            if (tinyEditor) { tinyEditor.destroy(); tinyEditor = null; }
        } else {
            richEditor.classList.remove('hidden');
            htmlEditor.classList.add('hidden');
            initTinyMCE();
        }
    }

    function previewHtml() {
        const html = document.getElementById('content-html').value;
        if (!html.trim()) { alert('No HTML to preview.'); return; }
        const win = window.open('', '_blank');
        win.document.write(html);
        win.document.close();
    }

    function findAndReplace() {
        document.getElementById('fr-modal').classList.remove('hidden');
        document.getElementById('fr-find').value = '';
        document.getElementById('fr-replace').value = '';
        document.getElementById('fr-result').classList.add('hidden');
        document.getElementById('fr-find').focus();
    }

    function closeFR() {
        document.getElementById('fr-modal').classList.add('hidden');
    }

    function doReplace() {
        const find = document.getElementById('fr-find').value;
        const replace = document.getElementById('fr-replace').value;
        if (!find) return;
        const textarea = document.getElementById('content-html');
        const before = textarea.value;
        const count = (before.split(find).length - 1);
        textarea.value = before.split(find).join(replace);
        const result = document.getElementById('fr-result');
        result.textContent = count + ' occurrence(s) replaced.';
        result.classList.remove('hidden');
    }

    // Init on load
    if (!isFullHtml) initTinyMCE();
</script>
@endsection
