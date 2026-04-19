@extends('layouts.app')
@section('title', 'Edit Blog Post - Admin')

@section('content')
<style>
    @media (max-width: 768px) {
        .blog-edit-wrap { padding-left: 0 !important; padding-right: 0 !important; }
        .blog-edit-wrap .card { border-radius: 0 !important; }
        .blog-edit-wrap .edit-header { flex-direction: column; align-items: flex-start !important; gap: 8px; padding: 0 16px; }
        .blog-edit-wrap .edit-header h1 { font-size: 1.2rem; }
        .blog-edit-wrap .form-grid { grid-template-columns: 1fr !important; }
        .blog-edit-wrap .content-toggle { flex-wrap: wrap; gap: 8px !important; }
        .blog-edit-wrap .img-gallery { grid-template-columns: 1fr !important; }
        .blog-edit-wrap .img-actions { flex-wrap: wrap; }
        .blog-edit-wrap textarea { min-height: 250px !important; font-size: 13px !important; }
        .blog-edit-wrap #content-html { min-height: 350px !important; }
        .blog-edit-wrap #content-html-ar { min-height: 250px !important; }
    }
</style>
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 blog-edit-wrap">
    <div class="flex items-center justify-between mb-6 edit-header">
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
        <div class="flex flex-wrap items-center gap-4 p-3 bg-gray-50 rounded-lg border content-toggle">
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

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 form-grid">
            <div><label class="block text-sm font-medium text-gray-700 mb-1">Title *</label><input type="text" name="title" value="{{ $blog->title }}" required class="input-field"></div>
            <div><label class="block text-sm font-medium text-gray-700 mb-1">العنوان بالعربي (Arabic Title)</label><input type="text" name="title_ar" value="{{ $blog->title_ar ?? '' }}" class="input-field" dir="rtl" placeholder="اختياري"></div>
            <div><label class="block text-sm font-medium text-gray-700 mb-1">Category *</label>
                <select name="category" required class="input-field">
                    @foreach(['health','business','products','success-stories','tips'] as $cat)
                        <option value="{{ $cat }}" {{ $blog->category === $cat ? 'selected' : '' }}>{{ ucfirst(str_replace('-', ' ', $cat)) }}</option>
                    @endforeach
                </select>
            </div>
            <div><label class="block text-sm font-medium text-gray-700 mb-1">Hero Image</label><input type="text" id="hero-image" name="image" value="{{ $blog->image }}" class="input-field" placeholder="Main blog thumbnail"></div>
            <div><label class="block text-sm font-medium text-gray-700 mb-1">Sub Image</label><input type="text" id="sub-image" name="sub_image" value="{{ $blog->sub_image ?? '' }}" class="input-field" placeholder="Secondary image"></div>
            <div class="flex items-center pt-6"><label class="flex items-center gap-2"><input type="checkbox" name="published" value="1" {{ $blog->published ? 'checked' : '' }}> Published</label></div>
        </div>
        <div><label class="block text-sm font-medium text-gray-700 mb-1">Excerpt</label><input type="text" name="excerpt" value="{{ $blog->excerpt }}" class="input-field"></div>
        <div><label class="block text-sm font-medium text-gray-700 mb-1">المقتطف بالعربي (Arabic Excerpt)</label><input type="text" name="excerpt_ar" value="{{ $blog->excerpt_ar ?? '' }}" class="input-field" dir="rtl" placeholder="اختياري"></div>

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

        {{-- Arabic HTML Editor --}}
        <div id="editor-html-ar" class="{{ ($blog->content_type ?? 'rich_text') !== 'full_html' ? 'hidden' : '' }}">
            <label class="block text-sm font-medium text-gray-700 mb-1">Arabic HTML (optional)</label>
            <p class="text-xs text-gray-400 mb-2">Paste the Arabic version of the HTML. Shown when the site language is switched to Arabic.</p>
            <textarea id="content-html-ar" name="content_ar" rows="12" class="input-field font-mono text-sm" style="min-height:300px;">{{ $blog->content_ar ?? '' }}</textarea>
            <div class="mt-2">
                <button type="button" onclick="previewHtmlAr()" class="text-sm text-dxn-green hover:underline">Preview Arabic in new tab</button>
            </div>
        </div>

        <div class="flex gap-3 pt-2">
            <button type="submit" class="btn-primary">Save Changes</button>
            <a href="{{ route('admin.blogs') }}" class="btn-primary" style="background: #6b7280;">Cancel</a>
        </div>
    </form>

    {{-- Image Uploader --}}
    <div class="card p-6 mt-6">
        <h3 class="font-bold text-dxn-darkgreen mb-4">Upload Images for This Blog</h3>
        <p class="text-xs text-gray-400 mb-4">Select multiple images at once. Click an uploaded image to copy its URL or insert it into your HTML.</p>

        <form id="upload-form" enctype="multipart/form-data" class="mb-6">
            @csrf
            <label class="block border-2 border-dashed border-gray-300 rounded-xl p-8 text-center cursor-pointer hover:border-dxn-green hover:bg-green-50/30 transition-colors" id="drop-zone">
                <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="#9ca3af" stroke-width="1.5" class="mx-auto mb-3"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
                <p class="text-gray-500 text-sm font-medium">Click to select images or drag & drop</p>
                <p class="text-gray-400 text-xs mt-1">Select multiple files at once (JPG, PNG, WebP)</p>
                <input type="file" id="image-files" name="images" accept="image/*" multiple class="hidden">
            </label>
        </form>

        <div id="upload-status" class="hidden mb-4 p-3 rounded-lg text-sm"></div>
        <div id="upload-progress" class="hidden mb-4">
            <div class="flex items-center gap-3">
                <div class="flex-1 bg-gray-200 rounded-full h-2">
                    <div id="progress-bar" class="bg-dxn-green h-2 rounded-full transition-all" style="width: 0%"></div>
                </div>
                <span id="progress-text" class="text-xs text-gray-500">0/0</span>
            </div>
        </div>

        {{-- Uploaded images gallery --}}
        <div id="uploaded-images" class="grid grid-cols-2 md:grid-cols-3 gap-4 img-gallery">
            @if(file_exists(public_path('images/blog/' . $blog->id)))
                @foreach(glob(public_path('images/blog/' . $blog->id . '/*')) as $file)
                    @php $url = '/images/blog/' . $blog->id . '/' . basename($file); @endphp
                    <div class="group relative bg-gray-50 rounded-xl border overflow-hidden" data-url="{{ $url }}">
                        <button onclick="deleteImage(this.closest('.group'))" class="absolute top-2 right-2 bg-red-500 text-white rounded-full w-7 h-7 flex items-center justify-center text-sm hover:bg-red-600 shadow-lg z-10" title="Delete">&times;</button>
                        <img src="{{ $url }}" class="w-full h-40 object-cover">
                        <div class="p-2">
                            <input type="text" value="{{ $url }}" readonly class="w-full text-xs font-mono bg-white border rounded px-2 py-1 text-gray-600" onclick="this.select()">
                            <div class="flex gap-2 mt-2">
                                <button onclick="setAsHero(this.closest('.group').dataset.url)" class="flex-1 text-xs bg-dxn-gold text-white py-1.5 rounded font-medium hover:opacity-90">Hero</button>
                                <button onclick="setAsSub(this.closest('.group').dataset.url)" class="flex-1 text-xs bg-purple-600 text-white py-1.5 rounded font-medium hover:opacity-90">Sub</button>
                                <button onclick="copyUrl(this.closest('.group').querySelector('input'))" class="flex-1 text-xs bg-dxn-green text-white py-1.5 rounded font-medium hover:opacity-90">Copy</button>
                                <button onclick="insertIntoHtml(this.closest('.group').dataset.url)" class="flex-1 text-xs bg-blue-600 text-white py-1.5 rounded font-medium hover:opacity-90">Insert</button>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
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

        const arEditor = document.getElementById('editor-html-ar');
        if (mode === 'full_html') {
            richEditor.classList.add('hidden');
            htmlEditor.classList.remove('hidden');
            arEditor.classList.remove('hidden');
            contentField.removeAttribute('required');
            if (tinyEditor) { tinyEditor.destroy(); tinyEditor = null; }
        } else {
            richEditor.classList.remove('hidden');
            htmlEditor.classList.add('hidden');
            arEditor.classList.add('hidden');
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

    function previewHtmlAr() {
        const html = document.getElementById('content-html-ar').value;
        if (!html.trim()) { alert('No Arabic HTML to preview.'); return; }
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

    // Image upload - multiple files
    const fileInput = document.getElementById('image-files');
    const dropZone = document.getElementById('drop-zone');

    fileInput.addEventListener('change', () => uploadFiles(fileInput.files));

    // Drag & drop
    dropZone.addEventListener('dragover', (e) => { e.preventDefault(); dropZone.classList.add('border-dxn-green', 'bg-green-50'); });
    dropZone.addEventListener('dragleave', () => { dropZone.classList.remove('border-dxn-green', 'bg-green-50'); });
    dropZone.addEventListener('drop', (e) => {
        e.preventDefault();
        dropZone.classList.remove('border-dxn-green', 'bg-green-50');
        uploadFiles(e.dataTransfer.files);
    });

    async function uploadFiles(files) {
        if (!files.length) return;
        const status = document.getElementById('upload-status');
        const progress = document.getElementById('upload-progress');
        const progressBar = document.getElementById('progress-bar');
        const progressText = document.getElementById('progress-text');
        const total = files.length;
        let done = 0;

        progress.classList.remove('hidden');
        status.className = 'mb-4 p-3 rounded-lg text-sm bg-blue-50 text-blue-700';
        status.textContent = `Uploading ${total} image(s)...`;
        status.classList.remove('hidden');

        for (const file of files) {
            const formData = new FormData();
            formData.append('image', file);
            formData.append('_token', '{{ csrf_token() }}');

            try {
                const res = await fetch('{{ route("admin.blogs.upload-image", $blog) }}', {
                    method: 'POST',
                    body: formData,
                });
                const data = await res.json();
                if (data.url) {
                    addImageCard(data.url);
                }
            } catch (err) {}

            done++;
            progressBar.style.width = (done / total * 100) + '%';
            progressText.textContent = done + '/' + total;
        }

        status.className = 'mb-4 p-3 rounded-lg text-sm bg-green-50 text-green-700';
        status.textContent = `${done} image(s) uploaded successfully!`;
        fileInput.value = '';
        setTimeout(() => { progress.classList.add('hidden'); }, 2000);
    }

    function addImageCard(url) {
        const container = document.getElementById('uploaded-images');
        const div = document.createElement('div');
        div.className = 'group relative bg-gray-50 rounded-xl border overflow-hidden';
        div.dataset.url = url;
        div.innerHTML = `
            <button onclick="deleteImage(this.closest('.group'))" class="absolute top-2 right-2 bg-red-500 text-white rounded-full w-7 h-7 flex items-center justify-center text-sm hover:bg-red-600 shadow-lg z-10" title="Delete">&times;</button>
            <img src="${url}" class="w-full h-40 object-cover">
            <div class="p-2">
                <input type="text" value="${url}" readonly class="w-full text-xs font-mono bg-white border rounded px-2 py-1 text-gray-600" onclick="this.select()">
                <div class="flex gap-2 mt-2">
                    <button onclick="setAsHero(this.closest('.group').dataset.url)" class="flex-1 text-xs bg-dxn-gold text-white py-1.5 rounded font-medium hover:opacity-90">Hero</button>
                    <button onclick="setAsSub(this.closest('.group').dataset.url)" class="flex-1 text-xs bg-purple-600 text-white py-1.5 rounded font-medium hover:opacity-90">Sub</button>
                    <button onclick="copyUrl(this.closest('.group').querySelector('input'))" class="flex-1 text-xs bg-dxn-green text-white py-1.5 rounded font-medium hover:opacity-90">Copy</button>
                    <button onclick="insertIntoHtml(this.closest('.group').dataset.url)" class="flex-1 text-xs bg-blue-600 text-white py-1.5 rounded font-medium hover:opacity-90">Insert</button>
                </div>
            </div>
        `;
        container.prepend(div);
    }

    function setAsHero(url) {
        document.getElementById('hero-image').value = url;
        showStatus('Hero image set! Remember to click "Save Changes" above.');
    }

    function setAsSub(url) {
        document.getElementById('sub-image').value = url;
        showStatus('Sub image set! Remember to click "Save Changes" above.');
    }

    function showStatus(msg) {
        const status = document.getElementById('upload-status');
        status.className = 'mb-4 p-3 rounded-lg text-sm bg-green-50 text-green-700';
        status.textContent = msg;
        status.classList.remove('hidden');
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }

    async function deleteImage(card) {
        const url = card.dataset.url;
        if (!confirm('Delete this image permanently?')) return;
        try {
            const res = await fetch('{{ route("admin.blogs.upload-image", $blog) }}', {
                method: 'DELETE',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                body: JSON.stringify({ url: url }),
            });
            const data = await res.json();
            if (data.success) {
                card.remove();
                // Clear hero/sub fields if they referenced this image
                if (document.getElementById('hero-image').value === url) document.getElementById('hero-image').value = '';
                if (document.getElementById('sub-image').value === url) document.getElementById('sub-image').value = '';
            }
        } catch (err) {
            alert('Failed to delete: ' + err.message);
        }
    }

    function copyUrl(input) {
        input.select();
        navigator.clipboard.writeText(input.value);
        const btn = input.nextElementSibling;
        btn.textContent = 'Copied!';
        setTimeout(() => btn.textContent = 'Copy URL', 1500);
    }

    function insertIntoHtml(url) {
        const textarea = document.getElementById('content-html');
        if (!textarea) return;
        const imgTag = `<img src="${url}" alt="" style="width:100%; max-height:400px; object-fit:cover; border-radius:6px;">`;
        const pos = textarea.selectionStart;
        textarea.value = textarea.value.slice(0, pos) + imgTag + textarea.value.slice(pos);
        textarea.focus();
    }

    // Init on load
    if (!isFullHtml) initTinyMCE();
</script>
@endsection
