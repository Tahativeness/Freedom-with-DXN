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
            .hero { height: auto !important; min-height: 0 !important; max-height: none !important; display: block !important; position: relative !important; overflow: hidden !important; background: var(--forest) !important; }
            .hero-img { position: relative !important; inset: auto !important; width: 100% !important; height: auto !important; display: block !important; opacity: 0.45 !important; filter: saturate(1.1) !important; }
            .hero-placeholder { display: none !important; }
            .hero-overlay { position: absolute !important; inset: 0 !important; background: linear-gradient(to left, rgba(44,24,120,0.85) 0%, rgba(70,56,123,0.4) 50%, rgba(70,56,123,0.2) 100%) !important; }
            .hero-content { position: absolute !important; bottom: 0 !important; right: 0 !important; left: auto !important; z-index: 2 !important; max-width: 600px !important; text-align: right !important; padding: 0 clamp(24px, 5vw, 80px) 48px !important; }
            .hero-tag { opacity: 0; animation: fadeRight 0.7s ease 0.2s forwards !important; }
            .hero-title { opacity: 0; animation: fadeRight 0.8s ease 0.4s forwards !important; font-size: clamp(28px, 5vw, 52px) !important; }
            .hero-meta { opacity: 0; animation: fadeRight 0.8s ease 0.6s forwards !important; justify-content: flex-end !important; }
            @keyframes fadeRight { from { opacity: 0; transform: translateX(30px); } to { opacity: 1; transform: translateX(0); } }
            .sidebar .zoom-card { display: none !important; }
            .bottom-cards { display: none; }
            @media (max-width: 860px) { .bottom-cards { display: block; } .sidebar { display: none !important; } .mobile-inserted { margin-bottom: 28px !important; } }
            @media (max-width: 540px) { .hero-content { right: 0 !important; left: 0 !important; max-width: none !important; text-align: center !important; padding: 0 20px 32px !important; } .hero-meta { justify-content: center !important; } .hero-title { font-size: 28px !important; margin-bottom: 12px !important; } .hero-tag { font-size: 10px !important; padding: 5px 12px !important; margin-bottom: 14px !important; } .hero-meta { font-size: 12px !important; gap: 12px !important; } }
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
        .hero { height: auto !important; min-height: 0 !important; max-height: none !important; display: block !important; position: relative !important; overflow: hidden !important; background: var(--forest) !important; }
        .hero-img { position: relative !important; inset: auto !important; width: 100% !important; height: auto !important; display: block !important; opacity: 0.45 !important; filter: saturate(1.1) !important; }
        .hero-placeholder { display: none !important; }
        .hero-overlay { position: absolute !important; inset: 0 !important; background: linear-gradient(to top, rgba(44,24,120,0.95) 0%, rgba(70,56,123,0.3) 55%, transparent 100%) !important; }
        .hero-content { position: absolute !important; bottom: 0 !important; right: 0 !important; left: auto !important; z-index: 2 !important; max-width: 600px !important; text-align: right !important; padding: 0 clamp(24px, 5vw, 80px) 48px !important; }
        .hero-tag { opacity: 0; animation: fadeRight 0.7s ease 0.2s forwards !important; }
        .hero-title { opacity: 0; animation: fadeRight 0.8s ease 0.4s forwards !important; font-size: clamp(28px, 5vw, 52px) !important; }
        .hero-meta { opacity: 0; animation: fadeRight 0.8s ease 0.6s forwards !important; }
        @keyframes fadeRight { from { opacity: 0; transform: translateX(30px); } to { opacity: 1; transform: translateX(0); } }
        .sidebar .zoom-card { display: none !important; }
        .bottom-cards { display: none; }
        @media (max-width: 860px) { .bottom-cards { display: block; } .sidebar { display: none !important; } .zoom-card { display: none !important; } .mobile-inserted { margin-bottom: 28px !important; } }
        @media (max-width: 540px) { .hero-content { right: 0 !important; left: 0 !important; max-width: none !important; text-align: center !important; padding: 0 20px 36px !important; } .hero-title { font-size: 28px !important; margin-bottom: 12px !important; } .hero-tag { font-size: 10px !important; padding: 5px 12px !important; margin-bottom: 14px !important; } .hero-meta { font-size: 12px !important; gap: 12px !important; } }
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

        // Inject products card BEFORE CTA banner via PHP
        $productsCard = '
        <div class="bottom-cards">
            <div class="sidebar-card">
                <h4>Start With These Products</h4>
                <ul class="fact-list">
                    <li>RG/GL Ganoderma capsules</li>
                    <li>Lingzhi Black Coffee</li>
                    <li>Morinzhi juice</li>
                    <li>Ganozhi toothpaste</li>
                    <li>Spirulina cereal</li>
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

        // Inject mobile JS to move TOC after intro
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
}
