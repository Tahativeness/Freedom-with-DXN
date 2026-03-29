@extends('layouts.app')
@section('title', $blog->title . ' - Freedom with DXN')

@section('content')
<div style="width: 100%; background: #faf6ef;">
    <iframe
        src="{{ route('blog.show.raw', $blog) }}"
        style="width: 100%; border: none; min-height: 100vh; max-height: none;"
        id="blog-frame"
        title="{{ $blog->title }}"
        scrolling="no"
    ></iframe>
</div>

<script>
    const frame = document.getElementById('blog-frame');

    function resizeFrame() {
        try {
            const doc = frame.contentWindow.document;
            const h = doc.documentElement.scrollHeight;
            frame.style.height = h + 'px';
        } catch(e) {
            frame.style.height = '200vh';
        }
    }

    frame.addEventListener('load', function() {
        resizeFrame();

        // Re-measure after fonts load and after a short delay for rendering
        try {
            frame.contentWindow.document.fonts.ready.then(resizeFrame);
        } catch(e) {}
        setTimeout(resizeFrame, 500);
        setTimeout(resizeFrame, 1500);

        // Watch for dynamic content changes
        try {
            const obs = new ResizeObserver(resizeFrame);
            obs.observe(frame.contentWindow.document.documentElement);
        } catch(e) {}

        // Intercept anchor clicks: scroll parent page to correct position
        try {
            const doc = frame.contentWindow.document;
            doc.querySelectorAll('a[href^="#"]').forEach(function(link) {
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    const id = this.getAttribute('href').substring(1);
                    const target = doc.getElementById(id);
                    if (target) {
                        const frameTop = frame.getBoundingClientRect().top + window.scrollY;
                        const targetTop = target.getBoundingClientRect().top;
                        window.scrollTo({ top: frameTop + targetTop - 80, behavior: 'smooth' });
                    }
                });
            });
        } catch(e) {}
    });
</script>
@endsection
