<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        $query = Blog::where('published', true)->orderByDesc('created_at');

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        $posts = $query->paginate(9)->appends($request->query());

        return view('pages.blog.index', compact('posts'));
    }

    public function show(Blog $blog)
    {
        $blog->increment('views');

        // Full HTML pages render inside site layout with iframe
        if ($blog->content_type === 'full_html') {
            return view('pages.blog.show-html', compact('blog'));
        }

        $related = Blog::where('published', true)
            ->where('id', '!=', $blog->id)
            ->where('category', $blog->category)
            ->take(3)
            ->get();

        return view('pages.blog.show', compact('blog', 'related'));
    }

    public function showRaw(Blog $blog)
    {
        if ($blog->content_type !== 'full_html') {
            return redirect()->route('blog.show', $blog);
        }

        $lang = session('lang', 'en');
        $isArabic = ($lang === 'ar' && $blog->content_ar);
        $html = $isArabic ? $blog->content_ar : $blog->content;

        // Arabic content: apply hero sizing and image injection
        if ($isArabic) {
            $heroUrl = e($blog->image ?? '');
            // Full-cover hero: image as background, text on right (RTL)
            $heroCSS = '
            .hero { height: 1000px !important; min-height: 0 !important; max-height: 1000px !important; display: flex !important; align-items: flex-end !important; overflow: hidden !important; }
            .hero-img { position: absolute !important; inset: 0 !important; width: 100% !important; height: 100% !important; object-fit: cover !important; display: block !important; opacity: 0.45 !important; filter: saturate(1.1) !important; }
            .hero-placeholder { display: none !important; }
            .sidebar .zoom-card { display: none !important; }
            .bottom-cards { display: none; }
            @media (max-width: 860px) { .bottom-cards { display: block; } }
            .hero-overlay { position: absolute !important; inset: 0 !important; background: linear-gradient(to left, rgba(44,24,120,0.85) 0%, rgba(70,56,123,0.4) 50%, rgba(70,56,123,0.2) 100%) !important; }
            .hero-content { position: relative !important; z-index: 2 !important; margin-left: auto !important; margin-right: 0 !important; text-align: right !important; padding: 0 clamp(24px, 5vw, 80px) 48px !important; max-width: 600px !important; }
            .hero-tag { opacity: 0; animation: fadeRight 0.7s ease 0.2s forwards !important; }
            .hero-title { opacity: 0; animation: fadeRight 0.8s ease 0.4s forwards !important; font-size: clamp(28px, 5vw, 52px) !important; }
            .hero-meta { opacity: 0; animation: fadeRight 0.8s ease 0.6s forwards !important; justify-content: flex-end !important; }
            @keyframes fadeRight { from { opacity: 0; transform: translateX(30px); } to { opacity: 1; transform: translateX(0); } }
            @media (max-width: 1024px) {
                .hero { height: 500px !important; max-height: 500px !important; }
                .hero-img { object-fit: contain !important; object-position: center !important; background: var(--forest) !important; }
                .hero-overlay { background: linear-gradient(to top, rgba(44,24,120,0.92) 0%, rgba(70,56,123,0.5) 50%, rgba(70,56,123,0.2) 100%) !important; }
                .hero-content { max-width: 100% !important; margin-left: 0 !important; margin-right: 0 !important; text-align: right !important; padding: 0 clamp(20px, 4vw, 48px) 40px !important; }
                .hero-meta { justify-content: flex-end !important; }
                .hero-title { font-size: clamp(26px, 5vw, 42px) !important; }
            }
            @media (max-width: 860px) {
                .sidebar { display: none !important; }
                .mobile-inserted { margin-bottom: 28px !important; }
            }
            @media (max-width: 540px) {
                .hero { height: auto !important; max-height: none !important; flex-direction: column !important; align-items: stretch !important; }
                .hero-img { position: relative !important; width: 100% !important; height: 250px !important; object-fit: contain !important; object-position: center !important; background: var(--forest) !important; }
                .hero-overlay { position: relative !important; background: var(--forest) !important; }
                .hero-content { position: relative !important; padding: 24px 20px 32px !important; text-align: center !important; margin: 0 !important; max-width: 100% !important; background: var(--forest) !important; }
                .hero-title { font-size: 28px !important; margin-bottom: 12px !important; }
                .hero-tag { font-size: 10px !important; padding: 5px 12px !important; margin-bottom: 14px !important; }
                .hero-meta { font-size: 12px !important; gap: 12px !important; justify-content: center !important; }
            }
            ';
            $html = str_replace('</style>', $heroCSS . '</style>', $html);

            // Replace hero-placeholder with image if exists
            if ($heroUrl) {
                $start = strpos($html, '<div class="hero-placeholder">');
                if ($start !== false) {
                    $depth = 0; $end = false;
                    for ($i = $start; $i < strlen($html) - 5; $i++) {
                        if (substr($html, $i, 4) === '<div') $depth++;
                        if (substr($html, $i, 6) === '</div>') { $depth--; if ($depth === 0) { $end = $i + 6; break; } }
                    }
                    if ($end) {
                        $html = substr($html, 0, $start) . '<img class="hero-img" src="' . $heroUrl . '" alt="' . e($blog->title) . '">' . substr($html, $end);
                    }
                }
            }

            // Replace img-placeholder blocks: #2 gets sub image, #1 and #3 removed
            $subUrl = e($blog->sub_image ?? '');
            $placeholderCount = 0;
            while (($pos = strpos($html, '<div class="img-placeholder">')) !== false) {
                $depth = 0; $end = false;
                for ($i = $pos; $i < strlen($html) - 5; $i++) {
                    if (substr($html, $i, 4) === '<div') $depth++;
                    if (substr($html, $i, 6) === '</div>') { $depth--; if ($depth === 0) { $end = $i + 6; break; } }
                }
                if (!$end) break;
                $placeholderCount++;
                if ($placeholderCount === 1 && $subUrl) {
                    $replacement = '<div class="blog-img-block"><img src="' . $subUrl . '" alt="' . e($blog->title) . '"></div>';
                } else {
                    $replacement = '';
                }
                $html = substr($html, 0, $pos) . $replacement . substr($html, $end);
            }

            // Inject products card BEFORE CTA banner via PHP
            $productsCard = '
            <div class="bottom-cards">
                <div class="sidebar-card">
                    <h4>' . ($isArabic ? 'ابدأ بهذه المنتجات' : 'Start With These Products') . '</h4>
                    <ul class="fact-list">
                        <li>' . ($isArabic ? 'كبسولات RG/GL غانوديرما' : 'RG/GL Ganoderma capsules') . '</li>
                        <li>' . ($isArabic ? 'قهوة ليندزهي السوداء' : 'Lingzhi Black Coffee') . '</li>
                        <li>' . ($isArabic ? 'عصير مورينزهي' : 'Morinzhi juice') . '</li>
                        <li>' . ($isArabic ? 'معجون أسنان غانوزهي' : 'Ganozhi toothpaste') . '</li>
                        <li>' . ($isArabic ? 'حبوب سبيرولينا' : 'Spirulina cereal') . '</li>
                    </ul>
                </div>
            </div>';

            // Insert BEFORE CTA banner
            $ctaPos = strpos($html, 'class="cta-banner"');
            if ($ctaPos !== false) {
                $divStart = strrpos(substr($html, 0, $ctaPos), '<div');
                if ($divStart !== false) {
                    $html = substr($html, 0, $divStart) . $productsCard . substr($html, $divStart);
                }
            }

            // Inject JS to move TOC after intro on mobile
            $mobileJS = '
            <script>
            document.addEventListener("DOMContentLoaded",function(){
                if(window.innerWidth>860)return;
                var intro=document.querySelector(".article-intro");
                var sidebar=document.querySelector(".sidebar");
                if(!intro||!sidebar)return;
                var toc=sidebar.children[0];
                if(toc){toc.classList.add("mobile-inserted");intro.after(toc);}
                sidebar.style.display="none";
            });
            </script>';
            $html = str_replace('</body>', $mobileJS . '</body>', $html);

            return response($html)->header('Content-Type', 'text/html');
        }

        $heroUrl = e($blog->image ?? '');
        $subUrl = e($blog->sub_image ?? '');
        $alt = e($blog->title);

        // Full-cover hero: image as background, text on right (LTR)
        $heroCSS = '
        .hero { height: 1000px !important; min-height: 0 !important; max-height: 1000px !important; display: flex !important; align-items: flex-end !important; overflow: hidden !important; }
        .hero-img { position: absolute !important; inset: 0 !important; width: 100% !important; height: 100% !important; object-fit: cover !important; display: block !important; opacity: 0.45 !important; filter: saturate(1.1) !important; }
        .hero-placeholder { display: none !important; }
            .sidebar .zoom-card { display: none !important; }
        .hero-overlay { position: absolute !important; inset: 0 !important; background: linear-gradient(to right, rgba(44,24,120,0.85) 0%, rgba(70,56,123,0.4) 50%, rgba(70,56,123,0.2) 100%) !important; }
        .hero-content { position: relative !important; z-index: 2 !important; margin-left: auto !important; margin-right: 0 !important; text-align: right !important; padding: 0 clamp(24px, 5vw, 80px) 48px !important; max-width: 600px !important; }
        .hero-tag { opacity: 0; animation: fadeRight 0.7s ease 0.2s forwards !important; }
        .hero-title { opacity: 0; animation: fadeRight 0.8s ease 0.4s forwards !important; font-size: clamp(28px, 5vw, 52px) !important; }
        .hero-meta { opacity: 0; animation: fadeRight 0.8s ease 0.6s forwards !important; justify-content: flex-end !important; }
        @keyframes fadeRight { from { opacity: 0; transform: translateX(30px); } to { opacity: 1; transform: translateX(0); } }
        @media (max-width: 1024px) {
            .hero { height: 500px !important; max-height: 500px !important; }
            .hero-img { object-fit: contain !important; object-position: center !important; background: var(--forest) !important; }
            .hero-overlay { background: linear-gradient(to top, rgba(44,24,120,0.92) 0%, rgba(70,56,123,0.5) 50%, rgba(70,56,123,0.2) 100%) !important; }
            .hero-content { max-width: 100% !important; margin-left: 0 !important; margin-right: 0 !important; text-align: right !important; padding: 0 clamp(20px, 4vw, 48px) 40px !important; }
            .hero-meta { justify-content: flex-end !important; }
            .hero-title { font-size: clamp(26px, 5vw, 42px) !important; }
        }
        @media (max-width: 860px) {
            .sidebar { display: none !important; }
            .zoom-card { display: none !important; }
            .mobile-inserted { margin-bottom: 28px !important; }
        }
        @media (max-width: 540px) {
            .hero { height: auto !important; max-height: none !important; flex-direction: column !important; align-items: stretch !important; }
            .hero-img { position: relative !important; width: 100% !important; height: 250px !important; object-fit: contain !important; object-position: center !important; background: var(--forest) !important; }
            .hero-overlay { position: relative !important; background: var(--forest) !important; }
            .hero-content { position: relative !important; padding: 24px 20px 32px !important; text-align: center !important; margin: 0 !important; max-width: 100% !important; background: var(--forest) !important; }
            .hero-title { font-size: 28px !important; margin-bottom: 12px !important; }
            .hero-tag { font-size: 10px !important; padding: 5px 12px !important; margin-bottom: 14px !important; }
            .hero-meta { font-size: 12px !important; gap: 12px !important; justify-content: center !important; }
        }
        ';
        $html = str_replace('</style>', $heroCSS . '</style>', $html);

        // Replace hero placeholder with hero image
        if ($heroUrl) {
            // Remove everything between hero-placeholder opening and closing
            $start = strpos($html, '<div class="hero-placeholder">');
            if ($start !== false) {
                // Find the matching closing: count nested divs
                $searchFrom = $start;
                $depth = 0;
                $end = false;
                for ($i = $start; $i < strlen($html) - 5; $i++) {
                    if (substr($html, $i, 4) === '<div') $depth++;
                    if (substr($html, $i, 6) === '</div>') {
                        $depth--;
                        if ($depth === 0) { $end = $i + 6; break; }
                    }
                }
                if ($end) {
                    $html = substr($html, 0, $start)
                        . '<img class="hero-img" src="' . $heroUrl . '" alt="' . $alt . '">'
                        . substr($html, $end);
                }
            }
        }

        // Replace img-placeholder blocks: #2 gets sub image, #1 and #3 removed
        $placeholderCount = 0;
        while (($pos = strpos($html, '<div class="img-placeholder">')) !== false) {
            $depth = 0;
            $end = false;
            for ($i = $pos; $i < strlen($html) - 5; $i++) {
                if (substr($html, $i, 4) === '<div') $depth++;
                if (substr($html, $i, 6) === '</div>') {
                    $depth--;
                    if ($depth === 0) { $end = $i + 6; break; }
                }
            }
            if (!$end) break;

            $placeholderCount++;
            if ($placeholderCount === 1 && $subUrl) {
                $replacement = '<div class="blog-img-block"><img src="' . $subUrl . '" alt="' . $alt . '"></div>';
            } else {
                $replacement = '';
            }
            $html = substr($html, 0, $pos) . $replacement . substr($html, $end);
        }

        // Inject mobile JS to move sidebar cards after intro
        $mobileJS = '
        <script>
        document.addEventListener("DOMContentLoaded",function(){
            if(window.innerWidth>860)return;
            var intro=document.querySelector(".article-intro");
            var sidebar=document.querySelector(".sidebar");
            var article=document.querySelector(".article");
            if(!intro||!sidebar||!article)return;
            var ch=Array.from(sidebar.children);
            var toc=ch[0],zoom=ch[1],products=ch[3];
            if(toc){toc.classList.add("mobile-inserted");intro.after(toc);}
            if(products){products.classList.add("mobile-inserted");article.appendChild(products);}
            if(zoom){zoom.classList.add("mobile-inserted");zoom.style.display="block";article.appendChild(zoom);}
            sidebar.style.display="none";
        });
        </script>';
        $html = str_replace('</body>', $mobileJS . '</body>', $html);

        return response($html)->header('Content-Type', 'text/html');
    }
}
