<!DOCTYPE html>
@php
  $lang = session('lang', 'en');
  $lang = in_array($lang, ['en', 'ar'], true) ? $lang : 'en';
  $isAr = $lang === 'ar';
  $dir = $isAr ? 'rtl' : 'ltr';
@endphp
<html lang="{{ $lang }}" dir="{{ $dir }}">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
  <meta name="theme-color" content="#04342C">

  <title>{{ $isAr ? 'صحة أفضل ودخل إضافي في الإمارات | FreedomWithDXN' : 'Build Better Health & Side Income in UAE | FreedomWithDXN' }}</title>
  <meta name="description" content="{{ $isAr ? 'انضم إلى فرصة عافية موثوقة عالميًا في الإمارات. تدريب مجاني، بداية مرنة بدوام جزئي، ومنتجات حلال. احصل على العرض المجاني الآن.' : 'Join a globally trusted wellness opportunity in the UAE. Free training, flexible part-time start, Halal-certified products. Get your free overview now.' }}">
  <meta name="robots" content="index, follow, max-image-preview:large">
  <link rel="canonical" href="https://freedomwithdxn.com/">
  <link rel="alternate" hreflang="en-AE" href="https://freedomwithdxn.com/">
  <link rel="alternate" hreflang="ar-AE" href="https://freedomwithdxn.com/ar/">
  <link rel="alternate" hreflang="x-default" href="https://freedomwithdxn.com/">

  <meta property="og:type" content="website">
  <meta property="og:url" content="https://freedomwithdxn.com/">
  <meta property="og:title" content="{{ $isAr ? 'ابنِ صحة أفضل ودخلًا إضافيًا في الإمارات' : 'Build better health and a second income in the UAE' }}">
  <meta property="og:description" content="{{ $isAr ? 'تدريب مجاني، بداية مرنة بدوام جزئي، منتجات حلال، وعرض بسيط للمقيمين في الإمارات.' : 'Free training, flexible part-time start, Halal-certified products, and a simple overview for UAE residents.' }}">
  <meta property="og:image" content="https://freedomwithdxn.com/images/og-business-opportunity.webp">
  <meta property="og:locale" content="{{ $isAr ? 'ar_AE' : 'en_AE' }}">

  <meta name="twitter:card" content="summary_large_image">
  <meta name="twitter:title" content="{{ $isAr ? 'ابنِ صحة أفضل ودخلًا إضافيًا في الإمارات' : 'Build better health and a second income in the UAE' }}">
  <meta name="twitter:description" content="{{ $isAr ? 'انضم إلى فرصة عافية موثوقة عالميًا في الإمارات. احصل على العرض المجاني الآن.' : 'Join a globally trusted wellness opportunity in the UAE. Get your free overview now.' }}">
  <meta name="twitter:image" content="https://freedomwithdxn.com/images/og-business-opportunity.webp">

  <link rel="icon" type="image/png" href="/favicon.png" sizes="96x96">
  <link rel="apple-touch-icon" href="/favicon.png">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link rel="preload" as="style" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500&display=swap">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500&display=swap" rel="stylesheet">
  <link rel="preload" as="style" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">

  <script type="application/ld+json">
  {
    "@context": "https://schema.org",
    "@type": "Organization",
    "name": "FreedomWithDXN",
    "url": "https://freedomwithdxn.com",
    "logo": "https://freedomwithdxn.com/logo.png",
    "sameAs": [
      "https://facebook.com/your-page",
      "https://instagram.com/your-page",
      "https://youtube.com/your-channel"
    ],
    "contactPoint": {
      "@type": "ContactPoint",
      "telephone": "+971-50-666-2875",
      "contactType": "customer support",
      "areaServed": "AE",
      "availableLanguage": ["English", "Arabic"]
    }
  }
  </script>

  <script type="application/ld+json">
  {
    "@context": "https://schema.org",
    "@type": "FAQPage",
    "mainEntity": [
      {
        "@type": "Question",
        "name": "Do I need any experience?",
        "acceptedAnswer": {"@type": "Answer", "text": "Not at all. Full step-by-step training is provided through the member portal, plus a personal mentor to guide you in your first 30 days."}
      },
      {
        "@type": "Question",
        "name": "Can I do this part-time?",
        "acceptedAnswer": {"@type": "Answer", "text": "Yes, and most people do. The majority of our members keep their full-time job and dedicate evenings or weekends to building this."}
      },
      {
        "@type": "Question",
        "name": "Is this available in the UAE?",
        "acceptedAnswer": {"@type": "Answer", "text": "Yes, fully active across Dubai, Abu Dhabi, Sharjah, Ajman, and the wider UAE, with local Arabic and English support."}
      },
      {
        "@type": "Question",
        "name": "How much does it cost to start?",
        "acceptedAnswer": {"@type": "Answer", "text": "There is a small one-time starter pack. You will see the exact number on the overview. No monthly fees, no hidden costs, no minimum purchase requirements."}
      },
      {
        "@type": "Question",
        "name": "Is this a pyramid scheme?",
        "acceptedAnswer": {"@type": "Answer", "text": "No. DXN is a 35+ year old network marketing company built on real wellness products, including Ganoderma supplements, coffee, and personal care, sold in 180+ countries. Income depends on selling and recommending products, not on recruitment alone."}
      },
      {
        "@type": "Question",
        "name": "What if I change my mind?",
        "acceptedAnswer": {"@type": "Answer", "text": "You can stop at any time. There is no contract, no lock-in, and no cancellation fees. The starter pack products are yours to keep."}
      }
    ]
  }
  </script>

  <script type="application/ld+json">
  {
    "@context": "https://schema.org",
    "@type": "LocalBusiness",
    "name": "FreedomWithDXN",
    "url": "https://freedomwithdxn.com",
    "image": "https://freedomwithdxn.com/logo.png",
    "telephone": "+971-50-666-2875",
    "priceRange": "$$",
    "areaServed": "AE",
    "address": {
      "@type": "PostalAddress",
      "addressCountry": "AE"
    }
  }
  </script>

  <style>
    :root{
      --green-900:#04342C;
      --green-700:#0F6E56;
      --green-100:#E7F4EC;
      --gold:#EF9F27;
      --gold-text:#412402;
      --cream:#F8F7F2;
      --surface:#FAFAF7;
      --white:#FFFFFF;
      --text:#1a1a1a;
      --muted:#5F5E5A;
      --border:#E5E3DA;
      --coral:#D9624B;
      --amber-bg:#FAEEDA;
      --amber-text:#854F0B;
      --red-bg:#FCEBEB;
      --red-text:#791F1F;
      --blue-bg:#E6F1FB;
      --blue-text:#0C447C;
      --container:1140px;
      --pad:clamp(20px,5vw,48px);
      --radius:14px;
    }

    *{box-sizing:border-box}
    html{scroll-behavior:smooth;-webkit-text-size-adjust:100%}
    body{margin:0;font-family:Inter,system-ui,-apple-system,BlinkMacSystemFont,"Segoe UI",sans-serif;font-weight:400;color:var(--text);background:var(--cream);line-height:1.6;text-rendering:optimizeLegibility;-webkit-font-smoothing:antialiased}
    body.menu-open{overflow:hidden}
    body.rtl{text-align:right}
    body.rtl .hero-grid,body.rtl .hero-copy,body.rtl .overview-card,body.rtl .qualifier-card{direction:rtl}
    body.rtl .ti-arrow-right,body.rtl .ti-arrow-left{transform:scaleX(-1)}
    img{max-width:100%;height:auto;display:block}
    a{color:inherit;text-decoration:none}
    button,input{font:inherit}
    button{cursor:pointer}
    :focus-visible{outline:3px solid rgba(239,159,39,.75);outline-offset:3px}

    .skip-link{position:absolute;left:12px;top:-80px;z-index:200;background:var(--gold);color:var(--gold-text);padding:10px 14px;border-radius:8px;font-weight:500}
    .skip-link:focus{top:12px}
    .container{width:min(100%,var(--container));margin:0 auto;padding:0 var(--pad)}
    .section{padding:clamp(68px,9vw,112px) 0}
    .eyebrow{display:inline-flex;align-items:center;gap:8px;margin:0 0 14px;color:var(--green-700);font-size:.76rem;font-weight:500;letter-spacing:.14em;text-transform:uppercase}
    .section-head{max-width:720px;margin:0 auto 34px;text-align:center}
    h1,h2,h3,p{margin-top:0}
    h1,h2,h3{font-weight:500;letter-spacing:0;line-height:1.08}
    h1{font-size:clamp(1.75rem,3.2vw,2.25rem);margin-bottom:18px;color:var(--white)}
    h2{font-size:clamp(2rem,3.3vw,2.75rem);margin-bottom:14px}
    h3{font-size:1.1rem;margin-bottom:8px}
    p{margin-bottom:0}
    .lead{color:var(--muted);font-size:clamp(1rem,1.6vw,1.16rem)}
    .dark{background:var(--green-900);color:var(--white)}
    .hero.dark,#qualifier.section.dark,.final-cta.section.dark{background:#E5F2EC}
    .hero.dark,.hero.dark h1,.hero.dark .trust-pill,.hero.dark .hero-sub,.hero.dark .chip,.hero.dark .reassurance,#qualifier.section.dark .section-head .eyebrow,#qualifier.section.dark .section-head h2,#qualifier.section.dark .section-head .lead,.final-cta.section.dark .urgency,.final-cta.section.dark h2,.final-cta.section.dark .lead,.final-cta.section.dark .trust-line{color:#000!important}
    .dark .lead,.dark .muted{color:rgba(255,255,255,.76)}
    .cream{background:var(--cream)}
    .light{background:var(--white)}

    .btn{min-height:44px;display:inline-flex;align-items:center;justify-content:center;gap:8px;border-radius:999px;border:.5px solid transparent;padding:12px 18px;font-weight:700;transition:background .18s ease,border-color .18s ease,color .18s ease,transform .18s ease}
    .btn:active{transform:translateY(1px)}
    .btn-gold{background:#198d45;color:#fff}
    .btn-gold:hover{background:#126b35;color:#fff;border-color:#126b35}
    .btn-dark{position:relative;overflow:hidden;background:#198d45;color:#fff;font-weight:700}
    .btn-dark::after{content:"";position:absolute;inset:-80% auto -80% -45%;width:38%;background:rgba(255,255,255,.24);transform:rotate(18deg);animation:ctaFlow 2.8s ease-in-out infinite;pointer-events:none}
    .btn-dark:hover{background:#126b35;color:#fff;border-color:#126b35}
    .nav-links .btn-dark:hover{background:#126b35;color:#fff;border-color:#126b35}
    .btn-outline{background:transparent;color:var(--white);border-color:rgba(255,255,255,.25)}

    .site-header{position:fixed;top:0;left:0;right:0;z-index:100;background:#fff;border-bottom:.5px solid var(--border);transition:background .2s ease,border-color .2s ease}
    .site-header.is-scrolled,.site-header.menu-active{background:#fff;border-bottom:.5px solid var(--border);backdrop-filter:saturate(160%) blur(10px)}
    .nav{display:flex;align-items:center;justify-content:space-between;gap:24px;min-height:76px}
    .brand{display:flex;align-items:center;min-width:0;color:#000}
    .site-header.is-scrolled .brand,.site-header.menu-active .brand{color:#000}
    .brand-logo{height:62px;width:auto;object-fit:contain;flex:0 0 auto}
    .nav-links{display:flex;align-items:center;gap:22px;color:#000;font-size:.94rem;font-weight:700}
    .site-header.is-scrolled .nav-links{color:#000}
    .nav-links a:hover{color:var(--green-700)}
    .language-switch{display:flex;align-items:center;gap:4px;border:.5px solid var(--border);border-radius:999px;padding:3px;background:var(--surface)}
    .language-switch a{min-width:34px;min-height:30px;display:inline-flex;align-items:center;justify-content:center;border-radius:999px;padding:4px 8px;font-size:.78rem;font-weight:700;color:#000}
    .language-switch a.is-active{background:#198d45;color:#fff}
    .menu-toggle{display:none;width:44px;height:44px;border-radius:10px;border:.5px solid var(--border);background:transparent;color:#000}
    .menu-lines{width:22px;display:grid;gap:5px}
    .menu-lines span{display:block;height:2px;background:#000;border-radius:999px}
    .site-header.is-scrolled .menu-toggle,.site-header.menu-active .menu-toggle{color:#000;border-color:var(--border)}

    .hero{min-height:760px;padding:132px 0 86px;display:grid;align-items:center}
    .hero-grid{display:grid;grid-template-columns:minmax(0,1.05fr) minmax(320px,.82fr);gap:clamp(34px,6vw,74px);align-items:center}
    .trust-pill{display:inline-flex;align-items:center;gap:10px;border:.5px solid rgba(255,255,255,.18);border-radius:999px;padding:8px 12px;color:rgba(255,255,255,.88);font-size:.9rem;margin-bottom:24px}
    .pulse{width:9px;height:9px;border-radius:50%;background:#42C883;box-shadow:0 0 0 0 rgba(66,200,131,.7);animation:pulse 1.9s infinite}
    .hero-copy{max-width:660px}
    .hero-sub{font-size:clamp(1.05rem,1.8vw,1.24rem);color:rgba(255,255,255,.78);margin-bottom:28px}
    .chips{display:grid;grid-template-columns:repeat(2,max-content);align-items:start;gap:12px 20px;max-width:650px;margin-bottom:28px}
    .chip{display:flex;align-items:center;justify-content:center;gap:9px;width:max-content;min-width:198px;min-height:58px;padding:14px 22px;border:.5px solid var(--border);border-radius:12px;background:rgba(250,250,247,.62);color:#000;box-shadow:inset 0 1px 0 rgba(255,255,255,.82);white-space:nowrap}
    .chip i{display:none}
    .hero-actions{display:flex;flex-wrap:wrap;align-items:center;gap:14px;margin-bottom:16px}
    .reassurance{display:flex;align-items:center;gap:8px;color:rgba(255,255,255,.72);font-size:.92rem}
    .reassurance i{color:#42C883}
    .overview-card{background:var(--surface);color:var(--text);border:.5px solid rgba(255,255,255,.16);border-radius:18px;padding:24px}
    .video-panel{border:.5px solid var(--border);border-radius:14px;overflow:hidden;background:var(--white)}
    .video-media{aspect-ratio:1447/1087;background:var(--white);display:grid;place-items:center;position:relative}
    .video-media picture,.video-media img{position:absolute;inset:0;width:100%;height:100%;object-fit:contain;opacity:1}
    .play{position:relative;z-index:1;width:64px;height:64px;border-radius:50%;background:var(--gold);color:var(--gold-text);display:grid;place-items:center;font-size:1.65rem}
    .video-body{padding:18px}
    .stats{display:grid;grid-template-columns:repeat(3,1fr);gap:8px;margin:18px 0}
    .stat{border:.5px solid var(--border);border-radius:10px;padding:11px 8px;text-align:center;background:var(--surface)}
    .stat strong{display:block;font-weight:500;color:var(--green-900);font-size:1.05rem}
    .stat span{display:block;color:var(--muted);font-size:.76rem;margin-top:3px}
    .cert{display:flex;align-items:center;gap:8px;color:var(--green-700);font-size:.9rem}

    .overview-video{background:#F8F7F2;color:#000;padding:clamp(72px,9vw,108px) 0}
    .overview-video .eyebrow{color:#000;margin-bottom:18px}
    .overview-video .section-head{margin-bottom:44px}
    .overview-video h2{color:#000;font-size:clamp(2rem,4vw,3rem)}
    .overview-video .lead{color:#000}
    .video-shell{width:min(100%,980px);margin:0 auto;transition:max-width .22s ease}
    .video-shell[data-zoom="large"]{max-width:1160px}
    .video-shell[data-zoom="small"]{max-width:820px}
    .video-frame{position:relative;aspect-ratio:16/9;border-radius:18px;padding:3px;background:linear-gradient(135deg,#198d45,#6248a8,#ef9f27,#d94b3f);box-shadow:0 28px 70px rgba(0,0,0,.34);overflow:hidden}
    .video-frame iframe,.video-frame video{width:100%;height:100%;display:block;border:0;border-radius:15px;background:#000}
    .video-frame video{object-fit:cover}
    .gift-offer{width:min(100%,980px);margin:28px auto 0;background:#fff;border:.5px solid rgba(25,141,69,.28);border-top:4px solid var(--gold);border-radius:14px;padding:22px;box-shadow:0 18px 48px rgba(25,141,69,.12)}
    .gift-offer-head{display:flex;align-items:center;justify-content:space-between;gap:18px;margin-bottom:18px}
    .gift-offer-kicker{display:inline-flex;align-items:center;gap:8px;margin-bottom:7px;color:var(--green-700);font-size:.78rem;font-weight:700;letter-spacing:.12em;text-transform:uppercase}
    .gift-offer h3{font-size:clamp(1.22rem,2.2vw,1.58rem);color:#000;margin-bottom:0}
    .gift-badge{width:54px;height:54px;border-radius:14px;background:var(--amber-bg);display:grid;place-items:center;font-size:1.7rem;flex:0 0 auto}
    .gift-list{display:grid;grid-template-columns:repeat(5,minmax(0,1fr));gap:10px;margin:0 0 18px;padding:0;list-style:none}
    .gift-list li{display:flex;align-items:center;gap:8px;min-height:54px;border:.5px solid var(--border);border-radius:10px;background:var(--surface);padding:10px 12px;color:#000;font-size:.92rem;font-weight:500;line-height:1.25}
    .gift-list i{color:#198d45;font-size:1.08rem;flex:0 0 auto}
    .gift-offer-foot{display:flex;align-items:center;justify-content:space-between;gap:16px;border-top:.5px solid var(--border);padding-top:16px}
    .gift-offer-foot p{color:var(--muted);font-size:.95rem}
    .video-toolbar{display:flex;justify-content:flex-end;gap:10px;margin-top:14px}
    .video-tool{min-width:44px;min-height:44px;display:inline-grid;place-items:center;border:.5px solid rgba(255,255,255,.18);border-radius:999px;background:rgba(255,255,255,.08);color:#fff;font-weight:700}
    .video-tool:hover{background:#198d45;color:#fff}

    .why-dxn{background:#fff;color:#000}
    .why-layout{display:grid;grid-template-columns:minmax(260px,.82fr) minmax(0,1.18fr);gap:clamp(26px,5vw,54px);align-items:start}
    .why-copy{position:sticky;top:108px}
    .why-copy .eyebrow{color:var(--green-700)}
    .why-copy h2{max-width:460px;color:#000}
    .why-copy .lead{max-width:510px;color:var(--muted)}
    .why-grid{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:16px}
    .why-card{position:relative;overflow:hidden;background:var(--surface);border:.5px solid var(--border);border-top:3px solid var(--green-700);border-radius:14px;padding:22px;min-height:210px}
    .why-card::after{content:"";position:absolute;left:0;right:0;bottom:0;height:4px;background:linear-gradient(90deg,var(--green-700),var(--gold),var(--coral));opacity:.78}
    .why-icon{width:46px;height:46px;border-radius:12px;background:var(--green-100);color:#000;display:grid;place-items:center;margin-bottom:18px}
    .why-icon svg{width:25px;height:25px;display:block;stroke:currentColor;stroke-width:2;stroke-linecap:round;stroke-linejoin:round;fill:none}
    .why-card h3{color:#000;margin-bottom:10px}
    .why-card p{color:var(--muted)}
    .why-note{grid-column:1/-1;display:flex;align-items:center;gap:10px;background:var(--green-100);border:.5px solid #CFE9D8;border-radius:14px;padding:18px 20px;color:var(--green-900);font-weight:500}
    .why-note svg{width:22px;height:22px;flex:0 0 auto;color:var(--green-700);stroke:currentColor;stroke-width:2;stroke-linecap:round;stroke-linejoin:round;fill:none}

    .trust-strip{padding:24px 0;background:var(--surface);border-bottom:.5px solid var(--border);overflow:hidden}
    .trust-marquee{width:min(100%,var(--container));margin:0 auto;padding:0 var(--pad)}
    .trust-row{display:grid;grid-template-columns:repeat(auto-fit,minmax(150px,1fr));gap:14px}
    .trust-row-copy{display:none}
    .trust-item{display:flex;align-items:center;justify-content:center;gap:9px;color:var(--green-900);font-weight:500}
    .trust-item i{color:var(--green-700);font-size:1.2rem}

    .problem-grid,.step-grid,.story-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(220px,1fr));gap:16px}
    .problem-card{background:var(--surface);border:.5px solid var(--border);border-left:4px solid var(--coral);border-radius:12px;padding:20px}
    .problem-card i{color:var(--coral);font-size:1.45rem;margin-bottom:14px;display:inline-block}
    .problem-card p,.step-card p,.story p,.journey-card p{color:var(--muted)}
    .bridge-box{margin-top:20px;background:var(--green-100);border:.5px solid #CFE9D8;border-radius:14px;padding:22px;text-align:center;color:var(--green-900);font-size:1.12rem}

    .step-card{position:relative;background:var(--surface);border:.5px solid var(--border);border-radius:14px;padding:52px 22px 24px}
    .step-badge{position:absolute;top:16px;left:16px;background:var(--green-900);color:var(--white);border-radius:999px;padding:5px 10px;font-size:.72rem;letter-spacing:.1em;text-transform:uppercase}
    .step-icon{width:46px;height:46px;border-radius:12px;background:var(--green-100);color:#000;display:grid;place-items:center;font-size:1.55rem;margin-bottom:16px}
    .step-icon i{display:block;line-height:1}
    .step-icon svg{width:25px;height:25px;display:block;stroke:currentColor;stroke-width:2;stroke-linecap:round;stroke-linejoin:round;fill:none}

    .story{background:var(--surface);border:.5px solid var(--border);border-radius:14px;padding:22px}
    .stars{color:var(--gold);letter-spacing:1px;margin-bottom:12px}
    .story blockquote{margin:0 0 18px;color:var(--text);font-style:italic}
    .person{display:flex;align-items:center;gap:12px}
    .avatar{width:44px;height:44px;border-radius:50%;background:var(--green-900);color:var(--white);display:grid;place-items:center;font-weight:500}
    .person small{display:block;color:var(--muted);margin-top:2px}
    .proof-note{text-align:center;color:var(--muted);font-style:italic;margin-top:18px}

    .journey-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(190px,1fr));gap:16px}
    .journey-card{background:var(--surface);border:.5px solid var(--border);border-radius:14px;padding:20px;text-align:center}
    .journey-num{width:42px;height:42px;border-radius:50%;background:var(--green-900);color:var(--white);display:grid;place-items:center;margin:0 auto 14px;font-weight:500}

    .qualifier-wrap{max-width:480px;margin:0 auto}
    .qualifier-card{background:var(--white);color:var(--text);border:.5px solid rgba(255,255,255,.35);border-radius:18px;padding:clamp(22px,5vw,32px);box-shadow:0 18px 40px rgba(0,0,0,.16)}
    .qualifier-nav{display:flex;align-items:center;margin-bottom:14px;min-height:36px}
    .back-btn{display:inline-flex;align-items:center;gap:7px;min-height:36px;border:0;background:transparent;color:var(--green-700);font-weight:500;padding:0}
    .back-btn:hover{color:var(--green-900)}
    .back-btn[hidden]{display:none}
    .progress-top{display:flex;align-items:center;justify-content:space-between;color:var(--muted);font-size:.88rem;margin-bottom:10px}
    .progress-track{height:8px;border-radius:999px;background:#EEF0EA;overflow:hidden;margin-bottom:24px}
    .progress-fill{height:100%;width:20%;background:var(--green-700);border-radius:inherit;transition:width .25s ease}
    .q-step[hidden]{display:none}
    .q-step h2{font-size:1.48rem;margin-bottom:8px}
    .q-sub{color:var(--muted);margin-bottom:18px}
    .options{display:grid;gap:10px}
    .option-btn{min-height:52px;width:100%;border:1px solid var(--border);border-radius:8px;background:var(--white);padding:14px 16px;text-align:left;color:var(--text);transition:border-color .18s ease,background .18s ease}
    .option-btn:hover{border-color:var(--green-700);background:var(--surface)}
    .lead-form{display:grid;gap:14px}
    .field label{display:block;font-size:.9rem;color:var(--green-900);margin-bottom:6px}
    .field input{width:100%;min-height:50px;border:1px solid var(--border);border-radius:8px;padding:12px 13px;background:var(--white);color:var(--text)}
    .field input:focus{border-color:var(--green-700);outline:3px solid rgba(15,110,86,.16)}
    .phone-input-group{position:relative;display:flex;align-items:stretch;width:100%}
    .country-select{position:relative;flex:0 0 176px}
    .country-toggle{width:100%;min-height:50px;display:flex;align-items:center;justify-content:space-between;gap:10px;border:1px solid var(--border);border-right:0;border-radius:8px 0 0 8px;background:var(--surface);color:var(--text);padding:0 12px;font-weight:500}
    .country-toggle:hover{background:var(--green-100);border-color:#cfe9d8}
    .country-toggle[aria-expanded="true"]{border-color:var(--green-700);box-shadow:0 0 0 3px rgba(15,110,86,.12)}
    .country-toggle-label{display:flex;align-items:center;gap:8px;min-width:0}
    .country-toggle-label span:last-child{overflow:hidden;text-overflow:ellipsis;white-space:nowrap}
    .country-flag{width:22px;height:16px;flex:0 0 22px;border-radius:2px;object-fit:cover;box-shadow:0 0 0 1px rgba(0,0,0,.08)}
    .country-menu{position:absolute;left:0;top:calc(100% + 8px);z-index:80;width:min(360px,calc(100vw - 40px));background:var(--white);border:1px solid var(--border);border-radius:12px;box-shadow:0 18px 42px rgba(0,0,0,.16);padding:10px;display:none}
    .country-menu.is-open{display:block}
    .country-search{width:100%;min-height:42px;border:1px solid var(--border);border-radius:8px;padding:9px 11px;margin-bottom:8px;background:var(--white);color:var(--text)}
    .country-search:focus{border-color:var(--green-700);outline:3px solid rgba(15,110,86,.16)}
    .country-list{max-height:238px;overflow-y:auto;display:grid;gap:3px;padding-right:2px}
    .country-option{width:100%;min-height:42px;display:flex;align-items:center;gap:9px;border:0;border-radius:8px;background:transparent;color:var(--text);padding:8px 10px;text-align:left}
    .country-option:hover,.country-option.is-active{background:var(--green-100)}
    .country-option-meta{min-width:0;display:grid;line-height:1.18}
    .country-option-name{overflow:hidden;text-overflow:ellipsis;white-space:nowrap;font-weight:500}
    .country-option-code{color:var(--muted);font-size:.82rem}
    .country-empty{display:none;color:var(--muted);font-size:.9rem;padding:10px}
    .country-empty.is-visible{display:block}
    .phone-input-group .phone-number-input{border-radius:0 8px 8px 0}
    .phone-help{margin-top:8px;color:var(--muted);font-size:.84rem;line-height:1.45}
    .privacy{display:flex;align-items:center;gap:8px;color:var(--muted);font-size:.88rem}
    .privacy i{color:var(--green-700)}
    .form-error{display:none;color:#9F2D20;background:#FFF1EE;border:.5px solid #FFD4CB;border-radius:8px;padding:10px 12px;font-size:.9rem}
    .form-error.show{display:block}
    .success{text-align:center}
    .success-icon{width:74px;height:74px;border-radius:50%;background:var(--green-100);color:var(--green-700);display:grid;place-items:center;margin:0 auto 18px;font-size:2.2rem}
    .score-pill{display:inline-flex;align-items:center;justify-content:center;margin-top:18px;border-radius:999px;padding:9px 13px;font-size:.9rem;font-weight:500}
    .score-hot{background:var(--red-bg);color:var(--red-text)}
    .score-warm{background:var(--amber-bg);color:var(--amber-text)}
    .score-cold{background:var(--blue-bg);color:var(--blue-text)}

    .faq-list{max-width:820px;margin:0 auto;display:grid;gap:10px}
    .faq-item{background:var(--surface);border:.5px solid var(--border);border-radius:12px;overflow:hidden}
    .faq-question{width:100%;min-height:58px;display:flex;align-items:center;justify-content:space-between;gap:18px;border:0;background:transparent;padding:16px 18px;text-align:left;font-weight:500;color:var(--green-900)}
    body.rtl .faq-question{text-align:right}
    .faq-question i{flex:0 0 auto;transition:transform .2s ease;color:var(--green-700)}
    .faq-item.is-open .faq-question i{transform:rotate(180deg)}
    .faq-answer{display:grid;grid-template-rows:0fr;transition:grid-template-rows .24s ease}
    .faq-item.is-open .faq-answer{grid-template-rows:1fr}
    .faq-answer-inner{overflow:hidden}
    .faq-answer p{padding:0 18px 18px;color:var(--muted)}

    .final-cta{text-align:center}
    .urgency{display:inline-flex;align-items:center;gap:8px;border:.5px solid rgba(255,255,255,.22);border-radius:999px;padding:8px 12px;color:rgba(255,255,255,.82);margin-bottom:18px}
    .trust-line{margin-top:18px;color:rgba(255,255,255,.72)}

    .mobile-sticky{position:fixed;left:0;right:0;bottom:0;z-index:90;padding:12px var(--pad) calc(12px + env(safe-area-inset-bottom));background:rgba(255,255,255,.96);border-top:.5px solid var(--border);display:none}
    .mobile-sticky .btn{width:100%}
    .mobile-sticky.is-hidden{display:none}
    .whatsapp-float{position:fixed;right:22px;bottom:22px;z-index:95;width:58px;height:58px;border-radius:50%;display:grid;place-items:center;background:#198d45;color:#fff;border:2px solid rgba(255,255,255,.9);box-shadow:0 14px 30px rgba(0,0,0,.22);transition:transform .18s ease,background .18s ease}
    .whatsapp-float:hover{background:#126b35;color:#fff;transform:translateY(-2px)}
    .whatsapp-float svg{width:30px;height:30px;fill:currentColor}
    .footer{background:#fff;color:#000;padding:34px 0;font-size:.95rem;text-align:center;font-weight:700;border-top:.5px solid var(--border)}
    .footer-grid{display:grid;gap:8px;justify-items:center}
    .footer strong{color:#000;font-weight:700}

    .visually-hidden{position:absolute!important;width:1px;height:1px;padding:0;margin:-1px;overflow:hidden;clip:rect(0,0,0,0);white-space:nowrap;border:0}

    @keyframes pulse{70%{box-shadow:0 0 0 10px rgba(66,200,131,0)}100%{box-shadow:0 0 0 0 rgba(66,200,131,0)}}
    @keyframes ctaFlow{0%{left:-45%}55%,100%{left:120%}}
    @keyframes trustMarquee{from{transform:translateX(0)}to{transform:translateX(-50%)}}

    @media (max-width:900px){
      .hero{min-height:auto;padding-top:118px}
      .hero-grid{grid-template-columns:1fr}
      .overview-card{max-width:560px}
      .why-layout{grid-template-columns:1fr}
      .why-copy{position:static}
      .video-shell[data-zoom="large"],.video-shell[data-zoom="small"]{max-width:100%}
      .gift-list{grid-template-columns:repeat(2,minmax(0,1fr))}
      .gift-offer-foot{align-items:flex-start;flex-direction:column}
    }

    @media (max-width:767px){
      .nav{min-height:68px}
      .brand-logo{height:56px}
      .nav-links{position:absolute;top:100%;left:0;right:0;width:100%;background:#fff;color:#000;border-top:.5px solid var(--border);border-bottom:.5px solid var(--border);padding:22px var(--pad) 26px;display:flex;align-items:stretch;flex-direction:column;gap:8px;opacity:0;visibility:hidden;transform:translateY(-10px);transition:opacity .2s ease,transform .2s ease,visibility .2s ease;font-weight:700;box-shadow:0 16px 30px rgba(0,0,0,.08)}
      .nav-links.is-open{opacity:1;visibility:visible;transform:translateY(0)}
      .nav-links a{min-height:44px;display:flex;align-items:center;justify-content:center;color:#000;font-weight:700;text-align:center}
      .nav-links .btn{margin-top:8px;background:#198d45;color:#fff;justify-content:center;font-weight:700;width:100%}
      .nav-links .btn:hover{background:#126b35;color:#fff}
      .menu-toggle{display:grid;place-items:center}
      .site-header:not(.is-scrolled):not(.menu-active) .brand{color:#000}
      .chips{grid-template-columns:1fr;max-width:none;gap:10px}
      .chip{width:100%;min-width:0;white-space:normal}
      .why-grid{grid-template-columns:1fr}
      .why-card{min-height:auto}
      .why-note{align-items:flex-start}
      .gift-offer{padding:18px}
      .gift-offer-head{align-items:flex-start}
      .gift-list{grid-template-columns:1fr}
      .stats{grid-template-columns:1fr}
      .phone-input-group{display:grid;grid-template-columns:1fr}
      .country-select{width:100%;flex-basis:auto}
      .country-toggle{border-right:1px solid var(--border);border-radius:8px 8px 0 0}
      .phone-input-group .phone-number-input{border-top:0;border-radius:0 0 8px 8px}
      .country-menu{width:100%;max-width:100%;top:calc(100% + 8px)}
      .trust-strip{padding:18px 0}
      .trust-marquee{display:flex;width:max-content;margin:0;padding:0;animation:trustMarquee 22s linear infinite}
      .trust-row{display:flex;align-items:center;grid-template-columns:none;gap:34px;min-width:max-content;padding-right:34px}
      .trust-row-copy{display:flex}
      .trust-item{flex:0 0 auto;white-space:nowrap}
      .mobile-sticky{display:block}
      .whatsapp-float{right:18px;bottom:88px;width:54px;height:54px}
      body{padding-bottom:76px}
    }

    @media (prefers-reduced-motion:reduce){
      *,*::before,*::after{animation-duration:.01ms!important;animation-iteration-count:1!important;scroll-behavior:auto!important;transition-duration:.01ms!important}
    }
  </style>
</head>
<body class="{{ $isAr ? 'rtl' : '' }}">
  <a class="skip-link" href="#main">Skip to content</a>

  <header class="site-header" id="site-header">
    <div class="container nav" aria-label="Primary navigation">
      <a class="brand" href="/" aria-label="FreedomWithDXN home">
        <img class="brand-logo" src="/footer-lg.png" alt="FreedomWithDXN" width="200" height="56">
      </a>
      <nav class="nav-links" id="nav-links" aria-label="Main menu">
        <a href="#how-it-works">How it works</a>
        <a href="#why-dxn">Why DXN?</a>
        <a href="#products">Products</a>
        <a href="#stories">Stories</a>
        <a href="#faq">FAQ</a>
        <div class="language-switch" aria-label="Language switch">
          <a href="{{ route('lang.switch', 'en') }}" class="{{ $lang === 'en' ? 'is-active' : '' }}" lang="en">EN</a>
          <a href="{{ route('lang.switch', 'ar') }}" class="{{ $lang === 'ar' ? 'is-active' : '' }}" lang="ar">AR</a>
        </div>
        <a class="btn btn-dark" href="#qualifier" data-scroll>Start free <i class="ti ti-arrow-right" aria-hidden="true"></i></a>
      </nav>
      <button class="menu-toggle" id="menu-toggle" type="button" aria-label="Open menu" aria-controls="nav-links" aria-expanded="false">
        <span class="menu-lines" aria-hidden="true"><span></span><span></span><span></span></span>
      </button>
    </div>
  </header>

  <main id="main">
    <section class="hero dark">
      <div class="container hero-grid">
        <div class="hero-copy">
          <div class="trust-pill"><span class="pulse" aria-hidden="true"></span>Trusted by 6+ million members in 180+ countries</div>
          <h1>Build better health and a DXN Business Opportunity in UAE</h1>
          <p class="hero-sub">Join a globally trusted wellness brand. Get a step-by-step training system, a personal mentor, and a flexible side opportunity built for people in the UAE.</p>
          <div class="chips" aria-label="Key benefits">
            <div class="chip"><i class="ti ti-circle-check" aria-hidden="true"></i>Start part-time</div>
            <div class="chip"><i class="ti ti-circle-check" aria-hidden="true"></i>No experience needed</div>
            <div class="chip"><i class="ti ti-circle-check" aria-hidden="true"></i>Free training included</div>
            <div class="chip"><i class="ti ti-circle-check" aria-hidden="true"></i>Work from anywhere</div>
          </div>
          <div class="hero-actions">
            <a class="btn btn-gold" href="#overview-video" data-scroll aria-label="Watch the free overview video">Watch free overview <i class="ti ti-arrow-right" aria-hidden="true"></i></a>
          </div>
          <p class="reassurance"><i class="ti ti-shield-check" aria-hidden="true"></i>2-minute qualifier · No spam · Free to start</p>
        </div>

        <aside class="overview-card" aria-label="Free overview summary">
          <div class="video-panel">
            <div class="video-media">
              <picture>
                <img src="{{ asset('images/landing-page-image.png') }}" alt="Freedom with DXN business opportunity overview" width="1447" height="1087">
              </picture>
            </div>
            <div class="video-body">
              <h2 style="font-size:1.28rem;margin-bottom:6px">Free 15-minute overview</h2>
              <p class="lead" style="font-size:.98rem">See the products, the business model, and the training path before you decide.</p>
              <div class="stats" aria-label="DXN global statistics">
                <div class="stat"><strong>35+</strong><span>years</span></div>
                <div class="stat"><strong>180+</strong><span>countries</span></div>
                <div class="stat"><strong>6M+</strong><span>members</span></div>
              </div>
              <p class="cert"><i class="ti ti-certificate" aria-hidden="true"></i>Halal certified · GMP · ISO 9001</p>
            </div>
          </div>
        </aside>
      </div>
    </section>

    <section class="trust-strip" aria-label="Trust indicators">
      <div class="trust-marquee">
        <div class="trust-row">
          <div class="trust-item"><i class="ti ti-world" aria-hidden="true"></i>Global brand</div>
          <div class="trust-item"><i class="ti ti-certificate" aria-hidden="true"></i>Halal certified</div>
          <div class="trust-item"><i class="ti ti-users" aria-hidden="true"></i>6M+ members</div>
          <div class="trust-item"><i class="ti ti-leaf" aria-hidden="true"></i>Wellness leader</div>
          <div class="trust-item"><i class="ti ti-award" aria-hidden="true"></i>Award winning</div>
        </div>
        <div class="trust-row trust-row-copy" aria-hidden="true">
          <div class="trust-item"><i class="ti ti-world" aria-hidden="true"></i>Global brand</div>
          <div class="trust-item"><i class="ti ti-certificate" aria-hidden="true"></i>Halal certified</div>
          <div class="trust-item"><i class="ti ti-users" aria-hidden="true"></i>6M+ members</div>
          <div class="trust-item"><i class="ti ti-leaf" aria-hidden="true"></i>Wellness leader</div>
          <div class="trust-item"><i class="ti ti-award" aria-hidden="true"></i>Award winning</div>
        </div>
      </div>
    </section>

    <section class="overview-video" id="overview-video">
      <div class="container">
        <div class="section-head">
          <p class="eyebrow">Watch this first</p>
          <h2>Your journey to freedom begins now</h2>
          <p class="lead">A short overview that shows what DXN is, how the opportunity works, and how you can start without pressure.</p>
        </div>

        <div class="video-shell" id="overview-video-shell" data-zoom="normal">
          <div class="video-frame" id="overview-video-frame">
            <video
              id="overview-video-player"
              title="Freedom with DXN business overview video"
              controls
              controlsList="nodownload"
              disablePictureInPicture
              oncontextmenu="return false"
              preload="metadata"
              playsinline>
              <source src="{{ asset('Video/watch-free-overview.mp4') }}" type="video/mp4">
              Your browser does not support the video tag.
            </video>
          </div>
        </div>

        <div class="gift-offer" aria-label="Special free offer after watching the video">
          <div class="gift-offer-head">
            <div>
              <p class="gift-offer-kicker">Your special gift box</p>
              <h3>What is the offer you can’t reject after watching this video?</h3>
            </div>
            <div class="gift-badge" aria-hidden="true">🎁</div>
          </div>
          <ul class="gift-list">
            <li><i class="ti ti-check" aria-hidden="true"></i>Registration Free</li>
            <li><i class="ti ti-check" aria-hidden="true"></i>Consulting Free</li>
            <li><i class="ti ti-check" aria-hidden="true"></i>Business Guidance Free</li>
            <li><i class="ti ti-check" aria-hidden="true"></i>Health & Product Education Free</li>
            <li><i class="ti ti-check" aria-hidden="true"></i>Personal Success Support</li>
          </ul>
          <div class="gift-offer-foot">
            <p>Everything is prepared to help you understand the opportunity clearly before you decide.</p>
            <a class="btn btn-gold" href="#qualifier" data-scroll>Claim free support <i class="ti ti-arrow-right" aria-hidden="true"></i></a>
          </div>
        </div>
      </div>
    </section>

    <section class="section why-dxn" id="why-dxn">
      <div class="container why-layout">
        <div class="why-copy">
          <p class="eyebrow">Why DXN?</p>
          <h2>A global wellness company built on real products</h2>
          <p class="lead">DXN combines daily-use wellness products with a flexible business opportunity, so people can improve their lifestyle while sharing products they actually use.</p>
        </div>
        <div class="why-grid">
          <article class="why-card">
            <div class="why-icon">
              <svg viewBox="0 0 24 24" aria-hidden="true">
                <path d="M12 3v18"></path>
                <path d="M6 7h12"></path>
                <path d="M8 7c0 5 1.5 9 4 11"></path>
                <path d="M16 7c0 5-1.5 9-4 11"></path>
                <circle cx="12" cy="12" r="9"></circle>
              </svg>
            </div>
            <h3>35+ years of global experience</h3>
            <p>DXN has been operating for more than three decades with a presence in many countries.</p>
          </article>
          <article class="why-card">
            <div class="why-icon">
              <svg viewBox="0 0 24 24" aria-hidden="true">
                <path d="M4 7h16"></path>
                <path d="M6 7v12h12V7"></path>
                <path d="M9 7a3 3 0 0 1 6 0"></path>
                <path d="M9 12h6"></path>
                <path d="M9 16h4"></path>
              </svg>
            </div>
            <h3>Products people use daily</h3>
            <p>Coffee, supplements, personal care, food and beverages, and wellness products make it easier to share naturally.</p>
          </article>
          <article class="why-card">
            <div class="why-icon">
              <svg viewBox="0 0 24 24" aria-hidden="true">
                <path d="M5 21c7-1 12-6 14-14"></path>
                <path d="M9 17c-3-3-3-8 0-11 4 1 7 4 8 8"></path>
                <path d="M4 10c3 0 6 2 8 5"></path>
              </svg>
            </div>
            <h3>From farm to finished product</h3>
            <p>DXN is known for cultivating, manufacturing, and distributing many of its own Ganoderma-based products.</p>
          </article>
          <article class="why-card">
            <div class="why-icon">
              <svg viewBox="0 0 24 24" aria-hidden="true">
                <path d="M4 19V5"></path>
                <path d="M4 19h16"></path>
                <path d="m7 15 4-4 3 3 5-7"></path>
                <path d="M15 7h4v4"></path>
              </svg>
            </div>
            <h3>Flexible for beginners</h3>
            <p>You can start part-time, learn step by step, and grow at your own pace without needing previous business experience.</p>
          </article>
          <p class="why-note">
            <svg viewBox="0 0 24 24" aria-hidden="true">
              <path d="M12 3 5 6v5c0 4.5 2.8 8.6 7 10 4.2-1.4 7-5.5 7-10V6l-7-3z"></path>
              <path d="m9 12 2 2 4-5"></path>
            </svg>
            No pressure. No experience needed. Just learn, use, and share responsibly.
          </p>
        </div>
      </div>
    </section>

    <section class="section light">
      <div class="container">
        <div class="section-head">
          <p class="eyebrow">The reality in the UAE</p>
          <h2>If any of this sounds familiar, you're not alone</h2>
        </div>
        <div class="problem-grid">
          <article class="problem-card"><i class="ti ti-wallet-off" aria-hidden="true"></i><h3>Salary isn't enough</h3><p>Rent, school fees, and family back home keep climbing.</p></article>
          <article class="problem-card"><i class="ti ti-clock-pause" aria-hidden="true"></i><h3>No time freedom</h3><p>Long shifts and fixed hours leaving little room for life.</p></article>
          <article class="problem-card"><i class="ti ti-battery-2" aria-hidden="true"></i><h3>Energy crashes daily</h3><p>Stress, poor sleep, and that 3pm slump every afternoon.</p></article>
          <article class="problem-card"><i class="ti ti-receipt-off" aria-hidden="true"></i><h3>One paycheck only</h3><p>If one income stops, everything stops with it.</p></article>
        </div>
        <div class="bridge-box">What if you could improve both your health and your income at the same time without quitting your job?</div>
      </div>
    </section>

    <section class="section cream" id="products">
      <div class="container">
        <div class="section-head">
          <p class="eyebrow">The opportunity</p>
          <h2>A smarter way to build health and income</h2>
          <p class="lead">Three simple steps. A proven 35-year-old system. Yours to follow.</p>
        </div>
        <div class="step-grid">
          <article class="step-card">
            <span class="step-badge">Step 1</span>
            <div class="step-icon">
              <svg viewBox="0 0 24 24" aria-hidden="true">
                <path d="M6 7h11v5a5 5 0 0 1-5 5H9a3 3 0 0 1-3-3V7z"></path>
                <path d="M17 9h1.5a2.5 2.5 0 0 1 0 5H17"></path>
                <path d="M5 21h14"></path>
                <path d="M9 3v2"></path>
                <path d="M13 3v2"></path>
              </svg>
            </div>
            <h3>Use the products</h3>
            <p>Swap your daily coffee, tea, and supplements for Ganoderma-based wellness alternatives.</p>
          </article>
          <article class="step-card">
            <span class="step-badge">Step 2</span>
            <div class="step-icon">
              <svg viewBox="0 0 24 24" aria-hidden="true">
                <circle cx="18" cy="5" r="3"></circle>
                <circle cx="6" cy="12" r="3"></circle>
                <circle cx="18" cy="19" r="3"></circle>
                <path d="M8.6 10.6 15.4 6.4"></path>
                <path d="M8.6 13.4 15.4 17.6"></path>
              </svg>
            </div>
            <h3>Share with others</h3>
            <p>Recommend what's actually working for you with no cold calls and no pressure.</p>
          </article>
          <article class="step-card">
            <span class="step-badge">Step 3</span>
            <div class="step-icon">
              <svg viewBox="0 0 24 24" aria-hidden="true">
                <path d="M4 19V5"></path>
                <path d="M4 19h16"></path>
                <path d="m7 15 4-4 3 3 5-7"></path>
                <path d="M15 7h4v4"></path>
              </svg>
            </div>
            <h3>Build long-term income</h3>
            <p>Compound your effort through a structured global compensation system.</p>
          </article>
        </div>
      </div>
    </section>

    <section class="section light" id="stories">
      <div class="container">
        <div class="section-head">
          <p class="eyebrow">Real stories from the UAE</p>
          <h2>People building lives they love</h2>
        </div>
        <div class="story-grid">
          <article class="story">
            <div class="stars" aria-hidden="true">★★★★★</div>
            <blockquote>"I started while keeping my job in Dubai. After 8 months I had a real side income, and my morning energy was completely different."</blockquote>
            <div class="person"><div class="avatar">AH</div><div><strong>Ahmed H.</strong><small>Dubai · Distributor since 2023</small></div></div>
          </article>
          <article class="story">
            <div class="stars" aria-hidden="true">★★★★★</div>
            <blockquote>"As a mum I needed flexibility. The training was clear and I never felt pushed. It just made sense."</blockquote>
            <div class="person"><div class="avatar">SM</div><div><strong>Sara M.</strong><small>Abu Dhabi · 1 year in</small></div></div>
          </article>
          <article class="story">
            <div class="stars" aria-hidden="true">★★★★★</div>
            <blockquote>"No cold-calling, no awkward pitches. Just sharing what I genuinely use every day."</blockquote>
            <div class="person"><div class="avatar">RK</div><div><strong>Rashid K.</strong><small>Sharjah · 6 months in</small></div></div>
          </article>
        </div>
        <p class="proof-note">Individual experiences. Not a guarantee of income or health outcomes.</p>
      </div>
    </section>

    <section class="section cream" id="how-it-works">
      <div class="container">
        <div class="section-head">
          <p class="eyebrow">Your journey</p>
          <h2>How to get started in 4 simple steps</h2>
        </div>
        <div class="journey-grid">
          <article class="journey-card"><div class="journey-num">1</div><h3>Fill the form</h3><p>2 minutes</p></article>
          <article class="journey-card"><div class="journey-num">2</div><h3>Watch overview</h3><p>15 minutes</p></article>
          <article class="journey-card"><div class="journey-num">3</div><h3>Get trained</h3><p>Self-paced</p></article>
          <article class="journey-card"><div class="journey-num">4</div><h3>Start building</h3><p>At your pace</p></article>
        </div>
      </div>
    </section>

    <section class="section dark" id="qualifier">
      <div class="container">
        <div class="section-head">
          <p class="eyebrow" style="color:#7DD9B7">Free qualifier</p>
          <h2 style="color:#fff">Find your best next step</h2>
          <p class="lead">Answer 5 quick questions and get matched with the right overview and follow-up.</p>
        </div>

        <div class="qualifier-wrap">
          <div class="qualifier-card">
            <div class="qualifier-nav">
              <button class="back-btn" id="qualifier-back" type="button" hidden aria-label="Go back to the previous question">
                <i class="ti ti-arrow-left" aria-hidden="true"></i>Back
              </button>
            </div>
            <div class="progress-top"><span id="step-label">Step 1 of 5</span><span id="step-percent">20%</span></div>
            <div class="progress-track" aria-hidden="true"><div class="progress-fill" id="progress-fill"></div></div>

            <section class="q-step" data-step="1">
              <h2>What interests you most?</h2>
              <p class="q-sub">Pick the one that matches you best.</p>
              <div class="options">
                <button class="option-btn" type="button" data-key="interest" data-value="Health">Better health</button>
                <button class="option-btn" type="button" data-key="interest" data-value="Income">Extra income</button>
                <button class="option-btn" type="button" data-key="interest" data-value="Both">Both — health and income</button>
              </div>
            </section>

            <section class="q-step" data-step="2" hidden>
              <h2 id="step-two-question">What health goal interests you most?</h2>
              <p class="q-sub">Pick the one that matches you best.</p>
              <div class="options" id="step-two-options"></div>
            </section>

            <section class="q-step" data-step="3" hidden>
              <h2 id="step-three-question">What affects your daily energy the most?</h2>
              <p class="q-sub">This helps us send the most relevant overview.</p>
              <div class="options" id="step-three-options"></div>
            </section>

            <section class="q-step" data-step="4" hidden>
              <h2>How soon would you like to take the next step?</h2>
              <p class="q-sub">This helps us follow up at the right time.</p>
              <div class="options">
                <button class="option-btn" type="button" data-key="learn" data-value="Yes">I want guidance today</button>
                <button class="option-btn" type="button" data-key="learn" data-value="Maybe">This week is good for me</button>
                <button class="option-btn" type="button" data-key="learn" data-value="No">I'm just exploring for now</button>
              </div>
            </section>

            <section class="q-step" data-step="5" hidden>
              <h2>Get free access</h2>
              <p class="q-sub">Overview video + WhatsApp welcome in 60 seconds.</p>
              <form class="lead-form needs-validation" id="lead-form" novalidate>
                <div class="field mb-3">
                  <label class="form-label" for="full-name">Full name</label>
                  <input class="form-control" id="full-name" name="name" type="text" autocomplete="name" placeholder="Your full name" required>
                </div>
                <div class="field mb-3">
                  <label class="form-label" for="email">Email</label>
                  <input class="form-control" id="email" name="email" type="email" autocomplete="email" placeholder="you@example.com" required>
                </div>
                <div class="field mb-3">
                  <label class="form-label" for="whatsapp-phone">WhatsApp Number</label>
                  <div class="phone-input-group input-group">
                    <div class="country-select" data-country-select>
                      <button class="country-toggle" id="country-toggle" type="button" aria-haspopup="listbox" aria-expanded="false" aria-controls="country-list">
                        <span class="country-toggle-label">
                          <img class="country-flag" id="selected-country-flag" src="https://flagcdn.com/w40/ae.png" alt="" width="22" height="16" loading="lazy">
                          <span id="selected-country-label">UAE +971</span>
                        </span>
                        <i class="ti ti-chevron-down" aria-hidden="true"></i>
                      </button>
                      <div class="country-menu" id="country-menu">
                        <input class="country-search" id="country-search" type="search" autocomplete="off" placeholder="Search country or code" aria-label="Search country code">
                        <div class="country-list" id="country-list" role="listbox" aria-label="Country codes"></div>
                        <div class="country-empty" id="country-empty">No countries found.</div>
                      </div>
                    </div>
                    <input class="phone-number-input form-control" id="whatsapp-phone" name="whatsapp_phone" type="tel" inputmode="tel" autocomplete="tel-national" placeholder="Phone number" required>
                  </div>
                  <input id="country-code" name="country_code" type="hidden" value="+971">
                  <input id="country-name" name="country_name" type="hidden" value="United Arab Emirates">
                  <input id="whatsapp" name="whatsapp" type="hidden" value="">
                  <p class="phone-help">Choose your country code, then enter your WhatsApp number.</p>
                </div>
                <p class="form-error" id="form-error">Please complete your name, email, and WhatsApp number.</p>
                <button class="btn btn-gold" type="submit">Get free access <i class="ti ti-arrow-right" aria-hidden="true"></i></button>
                <p class="privacy"><i class="ti ti-lock" aria-hidden="true"></i>Your information is private. Unsubscribe anytime.</p>
              </form>
            </section>

            <section class="q-step success" data-step="6" hidden>
              <div class="success-icon"><i class="ti ti-check" aria-hidden="true"></i></div>
              <h2>Thank you.</h2>
              <p class="q-sub">Your submission has been received. We will send your free overview shortly.</p>
              <div class="score-pill" id="score-pill">Nurture sequence started</div>
            </section>
          </div>
        </div>
      </div>
    </section>

    <section class="section light" id="faq">
      <div class="container">
        <div class="section-head">
          <p class="eyebrow">Common questions</p>
          <h2>Before you ask</h2>
        </div>
        <div class="faq-list" data-faq-accordion>
          <div class="faq-item">
            <button class="faq-question" type="button" aria-expanded="false" aria-controls="faq-answer-1" id="faq-question-1">Do I need any experience?<i class="ti ti-chevron-down" aria-hidden="true"></i></button>
            <div class="faq-answer" id="faq-answer-1" role="region" aria-labelledby="faq-question-1" hidden><div class="faq-answer-inner"><p>Not at all. Full step-by-step training is provided through the member portal, plus a personal mentor to guide you in your first 30 days.</p></div></div>
          </div>
          <div class="faq-item">
            <button class="faq-question" type="button" aria-expanded="false" aria-controls="faq-answer-2" id="faq-question-2">Can I do this part-time?<i class="ti ti-chevron-down" aria-hidden="true"></i></button>
            <div class="faq-answer" id="faq-answer-2" role="region" aria-labelledby="faq-question-2" hidden><div class="faq-answer-inner"><p>Yes, and most people do. The majority of our members keep their full-time job and dedicate evenings or weekends to building this.</p></div></div>
          </div>
          <div class="faq-item">
            <button class="faq-question" type="button" aria-expanded="false" aria-controls="faq-answer-3" id="faq-question-3">Is this available in the UAE?<i class="ti ti-chevron-down" aria-hidden="true"></i></button>
            <div class="faq-answer" id="faq-answer-3" role="region" aria-labelledby="faq-question-3" hidden><div class="faq-answer-inner"><p>Yes, fully active across Dubai, Abu Dhabi, Sharjah, Ajman, and the wider UAE, with local Arabic and English support.</p></div></div>
          </div>
          <div class="faq-item">
            <button class="faq-question" type="button" aria-expanded="false" aria-controls="faq-answer-4" id="faq-question-4">How much does it cost to start?<i class="ti ti-chevron-down" aria-hidden="true"></i></button>
            <div class="faq-answer" id="faq-answer-4" role="region" aria-labelledby="faq-question-4" hidden><div class="faq-answer-inner"><p>There's a small one-time starter pack. You'll see the exact number on the overview. No monthly fees, no hidden costs, no minimum purchase requirements.</p></div></div>
          </div>
          <div class="faq-item">
            <button class="faq-question" type="button" aria-expanded="false" aria-controls="faq-answer-5" id="faq-question-5">Is this a pyramid scheme?<i class="ti ti-chevron-down" aria-hidden="true"></i></button>
            <div class="faq-answer" id="faq-answer-5" role="region" aria-labelledby="faq-question-5" hidden><div class="faq-answer-inner"><p>No. DXN is a 35+ year old network marketing company built on real wellness products, including Ganoderma supplements, coffee, and personal care, sold in 180+ countries. Income depends on selling and recommending products, not on recruitment alone.</p></div></div>
          </div>
          <div class="faq-item">
            <button class="faq-question" type="button" aria-expanded="false" aria-controls="faq-answer-6" id="faq-question-6">What if I change my mind?<i class="ti ti-chevron-down" aria-hidden="true"></i></button>
            <div class="faq-answer" id="faq-answer-6" role="region" aria-labelledby="faq-question-6" hidden><div class="faq-answer-inner"><p>You can stop at any time. There's no contract, no lock-in, and no cancellation fees. The starter pack products are yours to keep.</p></div></div>
          </div>
        </div>
      </div>
    </section>

    <section class="section dark final-cta">
      <div class="container">
        <div class="urgency"><i class="ti ti-clock" aria-hidden="true"></i>Limited new-member spots this month</div>
        <h2 style="color:#fff">Your health and financial future starts with one click</h2>
        <p class="lead">Join thousands of UAE residents already building a better lifestyle. Free to start. No pressure. Your pace.</p>
        <div style="margin-top:24px">
          <a class="btn btn-gold" href="#qualifier" data-scroll>Get free information <i class="ti ti-arrow-right" aria-hidden="true"></i></a>
        </div>
        <p class="trust-line">Private & secure · 2-minute signup · Unsubscribe anytime</p>
      </div>
    </section>
  </main>

  <div class="mobile-sticky" id="mobile-sticky">
    <a class="btn btn-gold" href="#qualifier" data-scroll>Start free qualifier <i class="ti ti-arrow-right" aria-hidden="true"></i></a>
  </div>

  <a href="https://wa.me/971555574958?text=Hi%21%20I%27m%20interested%20in%20the%20DXN%20Business%20Oppertunity." class="whatsapp-float" target="_blank" rel="noopener" aria-label="Chat on WhatsApp">
    <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M20.52 3.48A11.85 11.85 0 0 0 12.05 0C5.5 0 .2 5.3.2 11.84c0 2.09.55 4.12 1.6 5.92L0 24l6.42-1.69a11.83 11.83 0 0 0 5.63 1.43h.01c6.54 0 11.85-5.3 11.85-11.84 0-3.16-1.23-6.13-3.39-8.42zM12.06 21.5h-.01a9.6 9.6 0 0 1-4.9-1.34l-.35-.21-3.81 1 1.02-3.71-.23-.38a9.62 9.62 0 0 1-1.46-5.02C2.32 6.6 6.69 2.23 12.06 2.23a9.62 9.62 0 0 1 6.84 2.84 9.6 9.6 0 0 1 2.84 6.83c0 5.36-4.37 9.6-9.68 9.6zm5.46-7.18c-.3-.15-1.78-.88-2.06-.98-.28-.1-.48-.15-.68.15-.2.3-.78.98-.96 1.18-.18.2-.35.22-.65.07-.3-.15-1.27-.47-2.42-1.5-.9-.8-1.5-1.78-1.67-2.08-.18-.3-.02-.46.13-.6.13-.13.3-.35.45-.53.15-.18.2-.3.3-.5.1-.2.05-.38-.02-.53-.07-.15-.68-1.63-.93-2.23-.25-.6-.5-.51-.68-.52l-.58-.01c-.2 0-.53.07-.8.38-.28.3-1.05 1.03-1.05 2.5 0 1.48 1.07 2.9 1.22 3.1.15.2 2.1 3.2 5.08 4.49.71.3 1.27.49 1.7.62.71.23 1.36.2 1.87.12.57-.08 1.78-.73 2.03-1.43.25-.7.25-1.3.18-1.43-.07-.13-.27-.2-.57-.35z"/></svg>
  </a>

  <footer class="footer">
    <div class="container footer-grid">
      <p>© 2026 Freedom with DXN. All rights reserved.</p>
      <p>Independent DXN Distributor. DXN is a registered trademark of DXN Holdings Berhad.</p>
    </div>
  </footer>

  <script>
    (function(){
      var header = document.getElementById('site-header');
      var menu = document.getElementById('nav-links');
      var menuBtn = document.getElementById('menu-toggle');
      var sticky = document.getElementById('mobile-sticky');
      var qualifier = document.getElementById('qualifier');
      var backBtn = document.getElementById('qualifier-back');
      var leadData = {};
      var utm = {};
      var currentStep = 1;
      var params = new URLSearchParams(window.location.search);
      ['utm_source','utm_medium','utm_campaign'].forEach(function(key){utm[key] = params.get(key) || '';});
      var isArabic = document.documentElement.lang === 'ar';
      var arabicText = {
        'Skip to content': 'تخطي إلى المحتوى',
        'Main menu': 'القائمة الرئيسية',
        'Open menu': 'فتح القائمة',
        'Close menu': 'إغلاق القائمة',
        'How it works': 'كيف يعمل',
        'Why DXN?': 'لماذا DXN؟',
        'Products': 'المنتجات',
        'Stories': 'قصص النجاح',
        'FAQ': 'الأسئلة',
        'Start free': 'ابدأ مجانًا',
        'Trusted by 6+ million members in 180+ countries': 'موثوق به من أكثر من 6 ملايين عضو في أكثر من 180 دولة',
        'Build better health and a DXN Business Opportunity in UAE': 'ابنِ صحة أفضل وفرصة عمل DXN في الإمارات',
        'Join a globally trusted wellness brand. Get a step-by-step training system, a personal mentor, and a flexible side opportunity built for people in the UAE.': 'انضم إلى علامة عافية موثوقة عالميًا. احصل على نظام تدريب خطوة بخطوة، ومرشد شخصي، وفرصة دخل جانبي مرنة تناسب المقيمين في الإمارات.',
        'Start part-time': 'ابدأ بدوام جزئي',
        'No experience needed': 'لا تحتاج إلى خبرة',
        'Free training included': 'التدريب المجاني مشمول',
        'Work from anywhere': 'اعمل من أي مكان',
        'Watch free overview': 'شاهد العرض المجاني',
        '2-minute qualifier · No spam · Free to start': 'تأهيل خلال دقيقتين · بدون إزعاج · بداية مجانية',
        'Free 15-minute overview': 'عرض مجاني لمدة 15 دقيقة',
        'See the products, the business model, and the training path before you decide.': 'شاهد المنتجات ونموذج العمل ومسار التدريب قبل أن تقرر.',
        'years': 'سنة',
        'countries': 'دولة',
        'members': 'عضو',
        'Halal certified · GMP · ISO 9001': 'حلال · GMP · ISO 9001',
        'Global brand': 'علامة عالمية',
        'Halal certified': 'معتمد حلال',
        '6M+ members': 'أكثر من 6M عضو',
        'Wellness leader': 'رائدة في العافية',
        'Award winning': 'حائزة على جوائز',
        'Watch this first': 'شاهد هذا أولًا',
        'Your journey to freedom begins now': 'رحلتك نحو الحرية تبدأ الآن',
        'A short overview that shows what DXN is, how the opportunity works, and how you can start without pressure.': 'عرض قصير يوضح ما هي DXN، وكيف تعمل الفرصة، وكيف يمكنك البدء بدون ضغط.',
        'Your special gift box': 'صندوق هديتك الخاصة',
        'What is the offer you can’t reject after watching this video?': 'ما العرض الذي لا يمكنك رفضه بعد مشاهدة هذا الفيديو؟',
        'Registration Free': 'التسجيل مجاني',
        'Consulting Free': 'الاستشارة مجانية',
        'Business Guidance Free': 'إرشاد العمل مجاني',
        'Health & Product Education Free': 'تعليم الصحة والمنتجات مجاني',
        'Personal Success Support': 'دعم شخصي للنجاح',
        'Everything is prepared to help you understand the opportunity clearly before you decide.': 'كل شيء جاهز لمساعدتك على فهم الفرصة بوضوح قبل أن تقرر.',
        'Claim free support': 'احصل على الدعم المجاني',
        'A global wellness company built on real products': 'شركة عافية عالمية مبنية على منتجات حقيقية',
        'DXN combines daily-use wellness products with a flexible business opportunity, so people can improve their lifestyle while sharing products they actually use.': 'تجمع DXN بين منتجات عافية للاستخدام اليومي وفرصة عمل مرنة، حتى يتمكن الناس من تحسين نمط حياتهم ومشاركة منتجات يستخدمونها فعلًا.',
        '35+ years of global experience': 'أكثر من 35 سنة من الخبرة العالمية',
        'DXN has been operating for more than three decades with a presence in many countries.': 'تعمل DXN منذ أكثر من ثلاثة عقود ولها حضور في العديد من الدول.',
        'Products people use daily': 'منتجات يستخدمها الناس يوميًا',
        'Coffee, supplements, personal care, food and beverages, and wellness products make it easier to share naturally.': 'القهوة والمكملات والعناية الشخصية والأطعمة والمشروبات ومنتجات العافية تجعل المشاركة طبيعية وأسهل.',
        'From farm to finished product': 'من المزرعة إلى المنتج النهائي',
        'DXN is known for cultivating, manufacturing, and distributing many of its own Ganoderma-based products.': 'تُعرف DXN بزراعة وتصنيع وتوزيع العديد من منتجاتها المبنية على الجانوديرما.',
        'Flexible for beginners': 'مرنة للمبتدئين',
        'You can start part-time, learn step by step, and grow at your own pace without needing previous business experience.': 'يمكنك البدء بدوام جزئي، والتعلم خطوة بخطوة، والنمو حسب وقتك دون الحاجة إلى خبرة تجارية سابقة.',
        'No pressure. No experience needed. Just learn, use, and share responsibly.': 'بدون ضغط. لا تحتاج إلى خبرة. فقط تعلّم واستخدم وشارك بمسؤولية.',
        'The reality in the UAE': 'الواقع في الإمارات',
        "If any of this sounds familiar, you're not alone": 'إذا كان هذا يشبه وضعك، فأنت لست وحدك',
        "Salary isn't enough": 'الراتب لا يكفي',
        'Rent, school fees, and family back home keep climbing.': 'الإيجار ورسوم المدارس ودعم العائلة في الوطن تزداد باستمرار.',
        'No time freedom': 'لا توجد حرية وقت',
        'Long shifts and fixed hours leaving little room for life.': 'ساعات العمل الطويلة والثابتة تترك مساحة قليلة للحياة.',
        'Energy crashes daily': 'انخفاض الطاقة يوميًا',
        'Stress, poor sleep, and that 3pm slump every afternoon.': 'الضغط وقلة النوم والتعب بعد الظهر تتكرر كل يوم.',
        'One paycheck only': 'دخل واحد فقط',
        'If one income stops, everything stops with it.': 'إذا توقف مصدر دخل واحد، تتوقف معه أشياء كثيرة.',
        'What if you could improve both your health and your income at the same time without quitting your job?': 'ماذا لو استطعت تحسين صحتك ودخلك في نفس الوقت بدون ترك وظيفتك؟',
        'The opportunity': 'الفرصة',
        'A smarter way to build health and income': 'طريقة أذكى لبناء الصحة والدخل',
        'Three simple steps. A proven 35-year-old system. Yours to follow.': 'ثلاث خطوات بسيطة. نظام مثبت منذ أكثر من 35 سنة. يمكنك اتباعه.',
        'Step 1': 'الخطوة 1',
        'Step 2': 'الخطوة 2',
        'Step 3': 'الخطوة 3',
        'Step 1 of 5': 'الخطوة 1 من 5',
        'Step 2 of 5': 'الخطوة 2 من 5',
        'Step 3 of 5': 'الخطوة 3 من 5',
        'Step 4 of 5': 'الخطوة 4 من 5',
        'Step 5 of 5': 'الخطوة 5 من 5',
        'Use the products': 'استخدم المنتجات',
        'Swap your daily coffee, tea, and supplements for Ganoderma-based wellness alternatives.': 'استبدل قهوتك وشايك ومكملاتك اليومية ببدائل عافية مبنية على الجانوديرما.',
        'Share with others': 'شارك مع الآخرين',
        "Recommend what's actually working for you with no cold calls and no pressure.": 'رشح ما يفيدك فعلًا بدون مكالمات مزعجة وبدون ضغط.',
        'Build long-term income': 'ابنِ دخلًا طويل المدى',
        'Compound your effort through a structured global compensation system.': 'راكم جهدك من خلال نظام تعويض عالمي منظم.',
        'Real stories from the UAE': 'قصص حقيقية من الإمارات',
        'People building lives they love': 'أشخاص يبنون حياة يحبونها',
        '"I started while keeping my job in Dubai. After 8 months I had a real side income, and my morning energy was completely different."': '"بدأت وأنا محتفظ بعملي في دبي. بعد 8 أشهر أصبح لدي دخل جانبي حقيقي، وتغيرت طاقتي الصباحية تمامًا."',
        '"As a mum I needed flexibility. The training was clear and I never felt pushed. It just made sense."': '"كأم كنت أحتاج إلى المرونة. كان التدريب واضحًا ولم أشعر بأي ضغط. الأمر كان منطقيًا جدًا."',
        '"No cold-calling, no awkward pitches. Just sharing what I genuinely use every day."': '"بدون مكالمات باردة وبدون عروض محرجة. فقط أشارك ما أستخدمه فعلًا كل يوم."',
        'Ahmed H.': 'أحمد ح.',
        'Sara M.': 'سارة م.',
        'Rashid K.': 'راشد ك.',
        'Dubai · Distributor since 2023': 'دبي · موزع منذ 2023',
        'Abu Dhabi · 1 year in': 'أبوظبي · منذ سنة',
        'Sharjah · 6 months in': 'الشارقة · منذ 6 أشهر',
        'Individual experiences. Not a guarantee of income or health outcomes.': 'تجارب فردية. ليست ضمانًا للدخل أو النتائج الصحية.',
        'Your journey': 'رحلتك',
        'How to get started in 4 simple steps': 'كيف تبدأ في 4 خطوات بسيطة',
        'Fill the form': 'املأ النموذج',
        '2 minutes': 'دقيقتان',
        'Watch overview': 'شاهد العرض',
        '15 minutes': '15 دقيقة',
        'Get trained': 'احصل على التدريب',
        'Self-paced': 'حسب وقتك',
        'Start building': 'ابدأ البناء',
        'At your pace': 'بالسرعة المناسبة لك',
        'Free qualifier': 'تأهيل مجاني',
        'Find your best next step': 'اعرف خطوتك التالية الأنسب',
        'Answer 5 quick questions and get matched with the right overview and follow-up.': 'أجب عن 5 أسئلة سريعة لتحصل على العرض والمتابعة المناسبة لك.',
        'Back': 'رجوع',
        'Complete': 'مكتمل',
        'What interests you most?': 'ما الذي يهمك أكثر؟',
        'Pick the one that matches you best.': 'اختر الإجابة الأقرب لك.',
        'Better health': 'صحة أفضل',
        'Extra income': 'دخل إضافي',
        'Both — health and income': 'كلاهما — الصحة والدخل',
        'What health goal interests you most?': 'ما الهدف الصحي الذي يهمك أكثر؟',
        'More energy & better daily wellness': 'طاقة أكثر وعافية يومية أفضل',
        'Weight management & fitness': 'إدارة الوزن واللياقة',
        'Better immunity & overall health': 'مناعة أفضل وصحة عامة',
        'What are you looking for financially?': 'ما الذي تبحث عنه ماليًا؟',
        'Extra side income': 'دخل جانبي إضافي',
        'Work from home opportunity': 'فرصة عمل من المنزل',
        'Financial freedom': 'حرية مالية',
        'Which matters more to you right now?': 'ما الأهم لك الآن؟',
        'Better health & more energy': 'صحة أفضل وطاقة أكثر',
        'Extra monthly income': 'دخل شهري إضافي',
        'Health and income together': 'الصحة والدخل معًا',
        'This helps us send the most relevant overview.': 'هذا يساعدنا على إرسال العرض الأنسب لك.',
        'What affects your daily energy the most?': 'ما أكثر شيء يؤثر على طاقتك اليومية؟',
        'Low energy in the morning': 'طاقة منخفضة في الصباح',
        'Afternoon tiredness': 'تعب بعد الظهر',
        'Stress and busy lifestyle': 'ضغط ونمط حياة مزدحم',
        'What is your biggest challenge with weight or fitness?': 'ما أكبر تحدي لديك في الوزن أو اللياقة؟',
        'Controlling food cravings': 'السيطرة على الرغبة في الأكل',
        'Staying consistent': 'الاستمرار بانتظام',
        'Low energy for exercise': 'طاقة قليلة للتمرين',
        'What kind of wellness support are you looking for?': 'ما نوع دعم العافية الذي تبحث عنه؟',
        'Daily immune support': 'دعم يومي للمناعة',
        'Natural wellness products': 'منتجات عافية طبيعية',
        'Better long-term health habits': 'عادات صحية أفضل على المدى الطويل',
        'How much extra income would help you right now?': 'كم دخل إضافي سيساعدك الآن؟',
        'Small monthly support': 'دعم شهري بسيط',
        'A serious second income': 'دخل ثانٍ جاد',
        'I want to grow step by step': 'أريد النمو خطوة بخطوة',
        'Why does working from home interest you?': 'لماذا تهمك فرصة العمل من المنزل؟',
        'More time freedom': 'حرية وقت أكثر',
        'Flexible part-time work': 'عمل مرن بدوام جزئي',
        'Build income around my schedule': 'بناء دخل حول جدولي',
        'What does financial freedom mean to you?': 'ماذا تعني لك الحرية المالية؟',
        'Less monthly pressure': 'ضغط شهري أقل',
        'More savings': 'مدخرات أكثر',
        'Build long-term passive income': 'بناء دخل طويل المدى',
        'Why do you want better health right now?': 'لماذا تريد صحة أفضل الآن؟',
        'Feel more active daily': 'الشعور بنشاط يومي أكثر',
        'Improve wellness naturally': 'تحسين العافية بشكل طبيعي',
        'Support my family better': 'دعم عائلتي بشكل أفضل',
        'What would extra income help you with most?': 'ما الذي سيساعدك فيه الدخل الإضافي أكثر؟',
        'Monthly expenses': 'المصاريف الشهرية',
        'Family support': 'دعم العائلة',
        'Savings and future goals': 'الادخار وأهداف المستقبل',
        'Which result would make the biggest difference first?': 'أي نتيجة ستصنع الفرق الأكبر أولًا؟',
        'Better personal wellness': 'عافية شخصية أفضل',
        'Build both step by step': 'بناء الاثنين خطوة بخطوة',
        'How soon would you like to take the next step?': 'متى تريد اتخاذ الخطوة التالية؟',
        'This helps us follow up at the right time.': 'هذا يساعدنا على المتابعة في الوقت المناسب.',
        'I want guidance today': 'أريد إرشادًا اليوم',
        'This week is good for me': 'هذا الأسبوع مناسب لي',
        "I'm just exploring for now": 'أنا أستكشف فقط الآن',
        'Get free access': 'احصل على الدخول المجاني',
        'Overview video + WhatsApp welcome in 60 seconds.': 'فيديو العرض + رسالة ترحيب واتساب خلال 60 ثانية.',
        'Full name': 'الاسم الكامل',
        'Email': 'البريد الإلكتروني',
        'WhatsApp Number': 'رقم واتساب',
        'No countries found.': 'لم يتم العثور على دول.',
        'Choose your country code, then enter your WhatsApp number.': 'اختر رمز الدولة ثم أدخل رقم واتساب.',
        'Please complete your name, email, and WhatsApp number.': 'يرجى إكمال الاسم والبريد الإلكتروني ورقم واتساب.',
        'Please complete your name, a valid email, and a valid WhatsApp number.': 'يرجى إدخال الاسم وبريد إلكتروني صحيح ورقم واتساب صحيح.',
        'We could not submit your details right now. Please try again in a moment.': 'لم نتمكن من إرسال بياناتك الآن. يرجى المحاولة بعد قليل.',
        'Your information is private. Unsubscribe anytime.': 'معلوماتك خاصة. يمكنك إلغاء الاشتراك في أي وقت.',
        'Thank you.': 'شكرًا لك.',
        'Your submission has been received. We will send your free overview shortly.': 'تم استلام طلبك. سنرسل لك العرض المجاني قريبًا.',
        'Hot lead — priority call within 1 hour': 'عميل مهتم جدًا — اتصال أولوية خلال ساعة',
        'Warm lead — follow-up within 24 hours': 'عميل مهتم — متابعة خلال 24 ساعة',
        'Nurture sequence started': 'بدأت سلسلة المتابعة',
        'Common questions': 'أسئلة شائعة',
        'Before you ask': 'قبل أن تسأل',
        'Do I need any experience?': 'هل أحتاج إلى خبرة؟',
        'Not at all. Full step-by-step training is provided through the member portal, plus a personal mentor to guide you in your first 30 days.': 'لا أبدًا. يتم توفير تدريب خطوة بخطوة من خلال بوابة الأعضاء، بالإضافة إلى مرشد شخصي يساعدك في أول 30 يومًا.',
        'Can I do this part-time?': 'هل يمكنني القيام بهذا بدوام جزئي؟',
        'Yes, and most people do. The majority of our members keep their full-time job and dedicate evenings or weekends to building this.': 'نعم، ومعظم الناس يفعلون ذلك. كثير من الأعضاء يحتفظون بوظائفهم ويخصصون الأمسيات أو عطلات نهاية الأسبوع للبناء.',
        'Is this available in the UAE?': 'هل هذا متاح في الإمارات؟',
        'Yes, fully active across Dubai, Abu Dhabi, Sharjah, Ajman, and the wider UAE, with local Arabic and English support.': 'نعم، متاح في دبي وأبوظبي والشارقة وعجمان وباقي الإمارات، مع دعم باللغتين العربية والإنجليزية.',
        'How much does it cost to start?': 'كم تكلفة البداية؟',
        "There's a small one-time starter pack. You'll see the exact number on the overview. No monthly fees, no hidden costs, no minimum purchase requirements.": 'هناك باقة بداية صغيرة لمرة واحدة. سترى الرقم الدقيق في العرض. لا توجد رسوم شهرية أو تكاليف مخفية أو حد أدنى للشراء.',
        'Is this a pyramid scheme?': 'هل هذا نظام هرمي؟',
        'No. DXN is a 35+ year old network marketing company built on real wellness products, including Ganoderma supplements, coffee, and personal care, sold in 180+ countries. Income depends on selling and recommending products, not on recruitment alone.': 'لا. DXN شركة تسويق شبكي عمرها أكثر من 35 سنة مبنية على منتجات عافية حقيقية، مثل مكملات الجانوديرما والقهوة والعناية الشخصية، وتباع في أكثر من 180 دولة. الدخل يعتمد على بيع وترشيح المنتجات، وليس على التسجيل فقط.',
        'What if I change my mind?': 'ماذا لو غيرت رأيي؟',
        "You can stop at any time. There's no contract, no lock-in, and no cancellation fees. The starter pack products are yours to keep.": 'يمكنك التوقف في أي وقت. لا يوجد عقد أو التزام أو رسوم إلغاء. منتجات باقة البداية تبقى لك.',
        'Limited new-member spots this month': 'أماكن الأعضاء الجدد محدودة هذا الشهر',
        'Your health and financial future starts with one click': 'مستقبل صحتك ودخلك يبدأ بنقرة واحدة',
        'Join thousands of UAE residents already building a better lifestyle. Free to start. No pressure. Your pace.': 'انضم إلى آلاف المقيمين في الإمارات الذين يبنون أسلوب حياة أفضل. بداية مجانية. بدون ضغط. حسب وقتك.',
        'Get free information': 'احصل على معلومات مجانية',
        'Private & secure · 2-minute signup · Unsubscribe anytime': 'خاص وآمن · تسجيل خلال دقيقتين · إلغاء الاشتراك في أي وقت',
        'Start free qualifier': 'ابدأ التأهيل المجاني',
        '© 2026 Freedom with DXN. All rights reserved.': '© 2026 Freedom with DXN. جميع الحقوق محفوظة.',
        'Independent DXN Distributor. DXN is a registered trademark of DXN Holdings Berhad.': 'موزع DXN مستقل. DXN علامة تجارية مسجلة لشركة DXN Holdings Berhad.'
      };
      var arabicAttributes = {
        'FreedomWithDXN home': 'الصفحة الرئيسية FreedomWithDXN',
        'Key benefits': 'الفوائد الرئيسية',
        'Watch the free overview video': 'شاهد العرض المجاني',
        'Free overview summary': 'ملخص العرض المجاني',
        'Freedom with DXN business opportunity overview': 'عرض فرصة عمل Freedom with DXN',
        'DXN global statistics': 'إحصاءات DXN العالمية',
        'Trust indicators': 'مؤشرات الثقة',
        'Freedom with DXN business overview video': 'فيديو عرض فرصة Freedom with DXN',
        'Special free offer after watching the video': 'عرض مجاني خاص بعد مشاهدة الفيديو',
        'Go back to the previous question': 'الرجوع إلى السؤال السابق',
        'Search country code': 'البحث عن رمز الدولة',
        'Country codes': 'رموز الدول',
        'Chat on WhatsApp': 'تواصل عبر واتساب'
      };

      function translateText(text){
        return isArabic && arabicText[text] ? arabicText[text] : text;
      }

      function translatePage(){
        if(!isArabic) return;
        document.title = 'صحة أفضل ودخل إضافي في الإمارات | FreedomWithDXN';
        var metaDescription = document.querySelector('meta[name="description"]');
        if(metaDescription) metaDescription.setAttribute('content', 'انضم إلى فرصة عافية موثوقة عالميًا في الإمارات. تدريب مجاني، بداية مرنة بدوام جزئي، ومنتجات حلال. احصل على العرض المجاني الآن.');
        var walker = document.createTreeWalker(document.body, NodeFilter.SHOW_TEXT, {
          acceptNode: function(node){
            if(!node.nodeValue.trim()) return NodeFilter.FILTER_REJECT;
            if(node.parentElement && ['SCRIPT','STYLE'].indexOf(node.parentElement.tagName) !== -1) return NodeFilter.FILTER_REJECT;
            return NodeFilter.FILTER_ACCEPT;
          }
        });
        var textNodes = [];
        while(walker.nextNode()) textNodes.push(walker.currentNode);
        textNodes.forEach(function(node){
          var original = node.nodeValue.trim();
          if(arabicText[original]){
            node.nodeValue = node.nodeValue.replace(original, arabicText[original]);
          }
        });
        document.querySelectorAll('[aria-label], [title], [alt], [placeholder]').forEach(function(el){
          ['aria-label', 'title', 'alt', 'placeholder'].forEach(function(attr){
            var value = el.getAttribute(attr);
            if(!value) return;
            if(arabicAttributes[value]){
              el.setAttribute(attr, arabicAttributes[value]);
            } else if(arabicText[value]){
              el.setAttribute(attr, arabicText[value]);
            } else if(attr === 'placeholder' && value === 'Your full name'){
              el.setAttribute(attr, 'اسمك الكامل');
            } else if(attr === 'placeholder' && value === 'Search country or code'){
              el.setAttribute(attr, 'ابحث عن الدولة أو الرمز');
            } else if(attr === 'placeholder' && value === 'Phone number'){
              el.setAttribute(attr, 'رقم الهاتف');
            }
          });
        });
        var whatsappLink = document.querySelector('.whatsapp-float');
        if(whatsappLink){
          whatsappLink.href = 'https://wa.me/971555574958?text=' + encodeURIComponent('مرحبًا! أنا مهتم بفرصة عمل DXN.');
        }
      }
      var countries = [
        {name:'Afghanistan', code:'+93', flag:'🇦🇫', iso:'AF'},
        {name:'Albania', code:'+355', flag:'🇦🇱', iso:'AL'},
        {name:'Algeria', code:'+213', flag:'🇩🇿', iso:'DZ'},
        {name:'American Samoa', code:'+1-684', flag:'🇦🇸', iso:'AS'},
        {name:'Andorra', code:'+376', flag:'🇦🇩', iso:'AD'},
        {name:'Angola', code:'+244', flag:'🇦🇴', iso:'AO'},
        {name:'Anguilla', code:'+1-264', flag:'🇦🇮', iso:'AI'},
        {name:'Antigua and Barbuda', code:'+1-268', flag:'🇦🇬', iso:'AG'},
        {name:'Argentina', code:'+54', flag:'🇦🇷', iso:'AR'},
        {name:'Armenia', code:'+374', flag:'🇦🇲', iso:'AM'},
        {name:'Aruba', code:'+297', flag:'🇦🇼', iso:'AW'},
        {name:'Australia', code:'+61', flag:'🇦🇺', iso:'AU'},
        {name:'Austria', code:'+43', flag:'🇦🇹', iso:'AT'},
        {name:'Azerbaijan', code:'+994', flag:'🇦🇿', iso:'AZ'},
        {name:'Bahamas', code:'+1-242', flag:'🇧🇸', iso:'BS'},
        {name:'Bahrain', code:'+973', flag:'🇧🇭', iso:'BH'},
        {name:'Bangladesh', code:'+880', flag:'🇧🇩', iso:'BD'},
        {name:'Barbados', code:'+1-246', flag:'🇧🇧', iso:'BB'},
        {name:'Belarus', code:'+375', flag:'🇧🇾', iso:'BY'},
        {name:'Belgium', code:'+32', flag:'🇧🇪', iso:'BE'},
        {name:'Belize', code:'+501', flag:'🇧🇿', iso:'BZ'},
        {name:'Benin', code:'+229', flag:'🇧🇯', iso:'BJ'},
        {name:'Bermuda', code:'+1-441', flag:'🇧🇲', iso:'BM'},
        {name:'Bhutan', code:'+975', flag:'🇧🇹', iso:'BT'},
        {name:'Bolivia', code:'+591', flag:'🇧🇴', iso:'BO'},
        {name:'Bosnia and Herzegovina', code:'+387', flag:'🇧🇦', iso:'BA'},
        {name:'Botswana', code:'+267', flag:'🇧🇼', iso:'BW'},
        {name:'Brazil', code:'+55', flag:'🇧🇷', iso:'BR'},
        {name:'British Indian Ocean Territory', code:'+246', flag:'🇮🇴', iso:'IO'},
        {name:'British Virgin Islands', code:'+1-284', flag:'🇻🇬', iso:'VG'},
        {name:'Brunei', code:'+673', flag:'🇧🇳', iso:'BN'},
        {name:'Bulgaria', code:'+359', flag:'🇧🇬', iso:'BG'},
        {name:'Burkina Faso', code:'+226', flag:'🇧🇫', iso:'BF'},
        {name:'Burundi', code:'+257', flag:'🇧🇮', iso:'BI'},
        {name:'Cambodia', code:'+855', flag:'🇰🇭', iso:'KH'},
        {name:'Cameroon', code:'+237', flag:'🇨🇲', iso:'CM'},
        {name:'Canada', code:'+1', flag:'🇨🇦', iso:'CA'},
        {name:'Cape Verde', code:'+238', flag:'🇨🇻', iso:'CV'},
        {name:'Caribbean Netherlands', code:'+599', flag:'🇧🇶', iso:'BQ'},
        {name:'Cayman Islands', code:'+1-345', flag:'🇰🇾', iso:'KY'},
        {name:'Central African Republic', code:'+236', flag:'🇨🇫', iso:'CF'},
        {name:'Chad', code:'+235', flag:'🇹🇩', iso:'TD'},
        {name:'Chile', code:'+56', flag:'🇨🇱', iso:'CL'},
        {name:'China', code:'+86', flag:'🇨🇳', iso:'CN'},
        {name:'Christmas Island', code:'+61', flag:'🇨🇽', iso:'CX'},
        {name:'Cocos Islands', code:'+61', flag:'🇨🇨', iso:'CC'},
        {name:'Colombia', code:'+57', flag:'🇨🇴', iso:'CO'},
        {name:'Comoros', code:'+269', flag:'🇰🇲', iso:'KM'},
        {name:'Congo', code:'+242', flag:'🇨🇬', iso:'CG'},
        {name:'Cook Islands', code:'+682', flag:'🇨🇰', iso:'CK'},
        {name:'Costa Rica', code:'+506', flag:'🇨🇷', iso:'CR'},
        {name:'Croatia', code:'+385', flag:'🇭🇷', iso:'HR'},
        {name:'Cuba', code:'+53', flag:'🇨🇺', iso:'CU'},
        {name:'Curacao', code:'+599', flag:'🇨🇼', iso:'CW'},
        {name:'Cyprus', code:'+357', flag:'🇨🇾', iso:'CY'},
        {name:'Czech Republic', code:'+420', flag:'🇨🇿', iso:'CZ'},
        {name:'Democratic Republic of the Congo', code:'+243', flag:'🇨🇩', iso:'CD'},
        {name:'Denmark', code:'+45', flag:'🇩🇰', iso:'DK'},
        {name:'Djibouti', code:'+253', flag:'🇩🇯', iso:'DJ'},
        {name:'Dominica', code:'+1-767', flag:'🇩🇲', iso:'DM'},
        {name:'Dominican Republic', code:'+1-809', flag:'🇩🇴', iso:'DO'},
        {name:'Ecuador', code:'+593', flag:'🇪🇨', iso:'EC'},
        {name:'Egypt', code:'+20', flag:'🇪🇬', iso:'EG'},
        {name:'El Salvador', code:'+503', flag:'🇸🇻', iso:'SV'},
        {name:'Equatorial Guinea', code:'+240', flag:'🇬🇶', iso:'GQ'},
        {name:'Eritrea', code:'+291', flag:'🇪🇷', iso:'ER'},
        {name:'Estonia', code:'+372', flag:'🇪🇪', iso:'EE'},
        {name:'Eswatini', code:'+268', flag:'🇸🇿', iso:'SZ'},
        {name:'Ethiopia', code:'+251', flag:'🇪🇹', iso:'ET'},
        {name:'Falkland Islands', code:'+500', flag:'🇫🇰', iso:'FK'},
        {name:'Faroe Islands', code:'+298', flag:'🇫🇴', iso:'FO'},
        {name:'Fiji', code:'+679', flag:'🇫🇯', iso:'FJ'},
        {name:'Finland', code:'+358', flag:'🇫🇮', iso:'FI'},
        {name:'France', code:'+33', flag:'🇫🇷', iso:'FR'},
        {name:'French Guiana', code:'+594', flag:'🇬🇫', iso:'GF'},
        {name:'French Polynesia', code:'+689', flag:'🇵🇫', iso:'PF'},
        {name:'Gabon', code:'+241', flag:'🇬🇦', iso:'GA'},
        {name:'Gambia', code:'+220', flag:'🇬🇲', iso:'GM'},
        {name:'Georgia', code:'+995', flag:'🇬🇪', iso:'GE'},
        {name:'Germany', code:'+49', flag:'🇩🇪', iso:'DE'},
        {name:'Ghana', code:'+233', flag:'🇬🇭', iso:'GH'},
        {name:'Gibraltar', code:'+350', flag:'🇬🇮', iso:'GI'},
        {name:'Greece', code:'+30', flag:'🇬🇷', iso:'GR'},
        {name:'Greenland', code:'+299', flag:'🇬🇱', iso:'GL'},
        {name:'Grenada', code:'+1-473', flag:'🇬🇩', iso:'GD'},
        {name:'Guadeloupe', code:'+590', flag:'🇬🇵', iso:'GP'},
        {name:'Guam', code:'+1-671', flag:'🇬🇺', iso:'GU'},
        {name:'Guatemala', code:'+502', flag:'🇬🇹', iso:'GT'},
        {name:'Guernsey', code:'+44-1481', flag:'🇬🇬', iso:'GG'},
        {name:'Guinea', code:'+224', flag:'🇬🇳', iso:'GN'},
        {name:'Guinea-Bissau', code:'+245', flag:'🇬🇼', iso:'GW'},
        {name:'Guyana', code:'+592', flag:'🇬🇾', iso:'GY'},
        {name:'Haiti', code:'+509', flag:'🇭🇹', iso:'HT'},
        {name:'Honduras', code:'+504', flag:'🇭🇳', iso:'HN'},
        {name:'Hong Kong', code:'+852', flag:'🇭🇰', iso:'HK'},
        {name:'Hungary', code:'+36', flag:'🇭🇺', iso:'HU'},
        {name:'Iceland', code:'+354', flag:'🇮🇸', iso:'IS'},
        {name:'India', code:'+91', flag:'🇮🇳', iso:'IN'},
        {name:'Indonesia', code:'+62', flag:'🇮🇩', iso:'ID'},
        {name:'Iran', code:'+98', flag:'🇮🇷', iso:'IR'},
        {name:'Iraq', code:'+964', flag:'🇮🇶', iso:'IQ'},
        {name:'Ireland', code:'+353', flag:'🇮🇪', iso:'IE'},
        {name:'Isle of Man', code:'+44-1624', flag:'🇮🇲', iso:'IM'},
        {name:'Israel', code:'+972', flag:'🇮🇱', iso:'IL'},
        {name:'Italy', code:'+39', flag:'🇮🇹', iso:'IT'},
        {name:'Ivory Coast', code:'+225', flag:'🇨🇮', iso:'CI'},
        {name:'Jamaica', code:'+1-876', flag:'🇯🇲', iso:'JM'},
        {name:'Japan', code:'+81', flag:'🇯🇵', iso:'JP'},
        {name:'Jersey', code:'+44-1534', flag:'🇯🇪', iso:'JE'},
        {name:'Jordan', code:'+962', flag:'🇯🇴', iso:'JO'},
        {name:'Kazakhstan', code:'+7', flag:'🇰🇿', iso:'KZ'},
        {name:'Kenya', code:'+254', flag:'🇰🇪', iso:'KE'},
        {name:'Kiribati', code:'+686', flag:'🇰🇮', iso:'KI'},
        {name:'Kosovo', code:'+383', flag:'🇽🇰', iso:'XK'},
        {name:'Kuwait', code:'+965', flag:'🇰🇼', iso:'KW'},
        {name:'Kyrgyzstan', code:'+996', flag:'🇰🇬', iso:'KG'},
        {name:'Laos', code:'+856', flag:'🇱🇦', iso:'LA'},
        {name:'Latvia', code:'+371', flag:'🇱🇻', iso:'LV'},
        {name:'Lebanon', code:'+961', flag:'🇱🇧', iso:'LB'},
        {name:'Lesotho', code:'+266', flag:'🇱🇸', iso:'LS'},
        {name:'Liberia', code:'+231', flag:'🇱🇷', iso:'LR'},
        {name:'Libya', code:'+218', flag:'🇱🇾', iso:'LY'},
        {name:'Liechtenstein', code:'+423', flag:'🇱🇮', iso:'LI'},
        {name:'Lithuania', code:'+370', flag:'🇱🇹', iso:'LT'},
        {name:'Luxembourg', code:'+352', flag:'🇱🇺', iso:'LU'},
        {name:'Macau', code:'+853', flag:'🇲🇴', iso:'MO'},
        {name:'Madagascar', code:'+261', flag:'🇲🇬', iso:'MG'},
        {name:'Malawi', code:'+265', flag:'🇲🇼', iso:'MW'},
        {name:'Malaysia', code:'+60', flag:'🇲🇾', iso:'MY'},
        {name:'Maldives', code:'+960', flag:'🇲🇻', iso:'MV'},
        {name:'Mali', code:'+223', flag:'🇲🇱', iso:'ML'},
        {name:'Malta', code:'+356', flag:'🇲🇹', iso:'MT'},
        {name:'Marshall Islands', code:'+692', flag:'🇲🇭', iso:'MH'},
        {name:'Martinique', code:'+596', flag:'🇲🇶', iso:'MQ'},
        {name:'Mauritania', code:'+222', flag:'🇲🇷', iso:'MR'},
        {name:'Mauritius', code:'+230', flag:'🇲🇺', iso:'MU'},
        {name:'Mayotte', code:'+262', flag:'🇾🇹', iso:'YT'},
        {name:'Mexico', code:'+52', flag:'🇲🇽', iso:'MX'},
        {name:'Micronesia', code:'+691', flag:'🇫🇲', iso:'FM'},
        {name:'Moldova', code:'+373', flag:'🇲🇩', iso:'MD'},
        {name:'Monaco', code:'+377', flag:'🇲🇨', iso:'MC'},
        {name:'Mongolia', code:'+976', flag:'🇲🇳', iso:'MN'},
        {name:'Montenegro', code:'+382', flag:'🇲🇪', iso:'ME'},
        {name:'Montserrat', code:'+1-664', flag:'🇲🇸', iso:'MS'},
        {name:'Morocco', code:'+212', flag:'🇲🇦', iso:'MA'},
        {name:'Mozambique', code:'+258', flag:'🇲🇿', iso:'MZ'},
        {name:'Myanmar', code:'+95', flag:'🇲🇲', iso:'MM'},
        {name:'Namibia', code:'+264', flag:'🇳🇦', iso:'NA'},
        {name:'Nauru', code:'+674', flag:'🇳🇷', iso:'NR'},
        {name:'Nepal', code:'+977', flag:'🇳🇵', iso:'NP'},
        {name:'Netherlands', code:'+31', flag:'🇳🇱', iso:'NL'},
        {name:'New Caledonia', code:'+687', flag:'🇳🇨', iso:'NC'},
        {name:'New Zealand', code:'+64', flag:'🇳🇿', iso:'NZ'},
        {name:'Nicaragua', code:'+505', flag:'🇳🇮', iso:'NI'},
        {name:'Niger', code:'+227', flag:'🇳🇪', iso:'NE'},
        {name:'Nigeria', code:'+234', flag:'🇳🇬', iso:'NG'},
        {name:'Niue', code:'+683', flag:'🇳🇺', iso:'NU'},
        {name:'Norfolk Island', code:'+672', flag:'🇳🇫', iso:'NF'},
        {name:'North Korea', code:'+850', flag:'🇰🇵', iso:'KP'},
        {name:'North Macedonia', code:'+389', flag:'🇲🇰', iso:'MK'},
        {name:'Northern Mariana Islands', code:'+1-670', flag:'🇲🇵', iso:'MP'},
        {name:'Norway', code:'+47', flag:'🇳🇴', iso:'NO'},
        {name:'Oman', code:'+968', flag:'🇴🇲', iso:'OM'},
        {name:'Pakistan', code:'+92', flag:'🇵🇰', iso:'PK'},
        {name:'Palau', code:'+680', flag:'🇵🇼', iso:'PW'},
        {name:'Palestine', code:'+970', flag:'🇵🇸', iso:'PS'},
        {name:'Panama', code:'+507', flag:'🇵🇦', iso:'PA'},
        {name:'Papua New Guinea', code:'+675', flag:'🇵🇬', iso:'PG'},
        {name:'Paraguay', code:'+595', flag:'🇵🇾', iso:'PY'},
        {name:'Peru', code:'+51', flag:'🇵🇪', iso:'PE'},
        {name:'Philippines', code:'+63', flag:'🇵🇭', iso:'PH'},
        {name:'Pitcairn Islands', code:'+64', flag:'🇵🇳', iso:'PN'},
        {name:'Poland', code:'+48', flag:'🇵🇱', iso:'PL'},
        {name:'Portugal', code:'+351', flag:'🇵🇹', iso:'PT'},
        {name:'Puerto Rico', code:'+1-787', flag:'🇵🇷', iso:'PR'},
        {name:'Qatar', code:'+974', flag:'🇶🇦', iso:'QA'},
        {name:'Reunion', code:'+262', flag:'🇷🇪', iso:'RE'},
        {name:'Romania', code:'+40', flag:'🇷🇴', iso:'RO'},
        {name:'Russia', code:'+7', flag:'🇷🇺', iso:'RU'},
        {name:'Rwanda', code:'+250', flag:'🇷🇼', iso:'RW'},
        {name:'Saint Barthelemy', code:'+590', flag:'🇧🇱', iso:'BL'},
        {name:'Saint Helena', code:'+290', flag:'🇸🇭', iso:'SH'},
        {name:'Saint Kitts and Nevis', code:'+1-869', flag:'🇰🇳', iso:'KN'},
        {name:'Saint Lucia', code:'+1-758', flag:'🇱🇨', iso:'LC'},
        {name:'Saint Martin', code:'+590', flag:'🇲🇫', iso:'MF'},
        {name:'Saint Pierre and Miquelon', code:'+508', flag:'🇵🇲', iso:'PM'},
        {name:'Saint Vincent and the Grenadines', code:'+1-784', flag:'🇻🇨', iso:'VC'},
        {name:'Samoa', code:'+685', flag:'🇼🇸', iso:'WS'},
        {name:'San Marino', code:'+378', flag:'🇸🇲', iso:'SM'},
        {name:'Sao Tome and Principe', code:'+239', flag:'🇸🇹', iso:'ST'},
        {name:'Saudi Arabia', code:'+966', flag:'🇸🇦', iso:'SA'},
        {name:'Senegal', code:'+221', flag:'🇸🇳', iso:'SN'},
        {name:'Serbia', code:'+381', flag:'🇷🇸', iso:'RS'},
        {name:'Seychelles', code:'+248', flag:'🇸🇨', iso:'SC'},
        {name:'Sierra Leone', code:'+232', flag:'🇸🇱', iso:'SL'},
        {name:'Singapore', code:'+65', flag:'🇸🇬', iso:'SG'},
        {name:'Sint Maarten', code:'+1-721', flag:'🇸🇽', iso:'SX'},
        {name:'Slovakia', code:'+421', flag:'🇸🇰', iso:'SK'},
        {name:'Slovenia', code:'+386', flag:'🇸🇮', iso:'SI'},
        {name:'Solomon Islands', code:'+677', flag:'🇸🇧', iso:'SB'},
        {name:'Somalia', code:'+252', flag:'🇸🇴', iso:'SO'},
        {name:'South Africa', code:'+27', flag:'🇿🇦', iso:'ZA'},
        {name:'South Korea', code:'+82', flag:'🇰🇷', iso:'KR'},
        {name:'South Sudan', code:'+211', flag:'🇸🇸', iso:'SS'},
        {name:'Spain', code:'+34', flag:'🇪🇸', iso:'ES'},
        {name:'Sri Lanka', code:'+94', flag:'🇱🇰', iso:'LK'},
        {name:'Sudan', code:'+249', flag:'🇸🇩', iso:'SD'},
        {name:'Suriname', code:'+597', flag:'🇸🇷', iso:'SR'},
        {name:'Svalbard and Jan Mayen', code:'+47', flag:'🇸🇯', iso:'SJ'},
        {name:'Sweden', code:'+46', flag:'🇸🇪', iso:'SE'},
        {name:'Switzerland', code:'+41', flag:'🇨🇭', iso:'CH'},
        {name:'Syria', code:'+963', flag:'🇸🇾', iso:'SY'},
        {name:'Taiwan', code:'+886', flag:'🇹🇼', iso:'TW'},
        {name:'Tajikistan', code:'+992', flag:'🇹🇯', iso:'TJ'},
        {name:'Tanzania', code:'+255', flag:'🇹🇿', iso:'TZ'},
        {name:'Thailand', code:'+66', flag:'🇹🇭', iso:'TH'},
        {name:'Timor-Leste', code:'+670', flag:'🇹🇱', iso:'TL'},
        {name:'Togo', code:'+228', flag:'🇹🇬', iso:'TG'},
        {name:'Tokelau', code:'+690', flag:'🇹🇰', iso:'TK'},
        {name:'Tonga', code:'+676', flag:'🇹🇴', iso:'TO'},
        {name:'Trinidad and Tobago', code:'+1-868', flag:'🇹🇹', iso:'TT'},
        {name:'Tunisia', code:'+216', flag:'🇹🇳', iso:'TN'},
        {name:'Turkey', code:'+90', flag:'🇹🇷', iso:'TR'},
        {name:'Turkmenistan', code:'+993', flag:'🇹🇲', iso:'TM'},
        {name:'Turks and Caicos Islands', code:'+1-649', flag:'🇹🇨', iso:'TC'},
        {name:'Tuvalu', code:'+688', flag:'🇹🇻', iso:'TV'},
        {name:'U.S. Virgin Islands', code:'+1-340', flag:'🇻🇮', iso:'VI'},
        {name:'Uganda', code:'+256', flag:'🇺🇬', iso:'UG'},
        {name:'Ukraine', code:'+380', flag:'🇺🇦', iso:'UA'},
        {name:'United Arab Emirates', code:'+971', flag:'🇦🇪', iso:'AE', aliases:'uae emirates dubai abu dhabi sharjah'},
        {name:'United Kingdom', code:'+44', flag:'🇬🇧', iso:'GB', aliases:'uk britain england scotland wales'},
        {name:'United States', code:'+1', flag:'🇺🇸', iso:'US', aliases:'usa america united states'},
        {name:'Uruguay', code:'+598', flag:'🇺🇾', iso:'UY'},
        {name:'Uzbekistan', code:'+998', flag:'🇺🇿', iso:'UZ'},
        {name:'Vanuatu', code:'+678', flag:'🇻🇺', iso:'VU'},
        {name:'Vatican City', code:'+379', flag:'🇻🇦', iso:'VA'},
        {name:'Venezuela', code:'+58', flag:'🇻🇪', iso:'VE'},
        {name:'Vietnam', code:'+84', flag:'🇻🇳', iso:'VN'},
        {name:'Wallis and Futuna', code:'+681', flag:'🇼🇫', iso:'WF'},
        {name:'Western Sahara', code:'+212', flag:'🇪🇭', iso:'EH'},
        {name:'Yemen', code:'+967', flag:'🇾🇪', iso:'YE'},
        {name:'Zambia', code:'+260', flag:'🇿🇲', iso:'ZM'},
        {name:'Zimbabwe', code:'+263', flag:'🇿🇼', iso:'ZW'}
      ];

      function updateHeader(){
        if(!header) return;
        header.classList.toggle('is-scrolled', window.scrollY > 20);
      }
      window.addEventListener('scroll', updateHeader, {passive:true});
      updateHeader();

      if(menuBtn && menu){
        menuBtn.addEventListener('click', function(){
          var open = menu.classList.toggle('is-open');
          document.body.classList.toggle('menu-open', open);
          header.classList.toggle('menu-active', open);
          menuBtn.setAttribute('aria-expanded', open ? 'true' : 'false');
          menuBtn.setAttribute('aria-label', open ? translateText('Close menu') : translateText('Open menu'));
        });
        menu.querySelectorAll('a').forEach(function(link){
          link.addEventListener('click', function(){
            menu.classList.remove('is-open');
            document.body.classList.remove('menu-open');
            header.classList.remove('menu-active');
            menuBtn.setAttribute('aria-expanded','false');
            menuBtn.setAttribute('aria-label', translateText('Open menu'));
          });
        });
      }

      document.querySelectorAll('[data-scroll]').forEach(function(link){
        link.addEventListener('click', function(event){
          var target = document.querySelector(link.getAttribute('href'));
          if(target){
            event.preventDefault();
            target.scrollIntoView({behavior:'smooth', block:'start'});
          }
        });
      });

      document.querySelectorAll('[data-faq-accordion]').forEach(function(accordion){
        var items = Array.prototype.slice.call(accordion.querySelectorAll('.faq-item'));

        function setFaqItem(item, open){
          var button = item.querySelector('.faq-question');
          var answer = item.querySelector('.faq-answer');
          if(!button || !answer) return;

          button.setAttribute('aria-expanded', open ? 'true' : 'false');

          if(open){
            answer.hidden = false;
            window.requestAnimationFrame(function(){
              item.classList.add('is-open');
            });
            return;
          }

          item.classList.remove('is-open');
          window.setTimeout(function(){
            if(!item.classList.contains('is-open')){
              answer.hidden = true;
            }
          }, 240);
        }

        items.forEach(function(item){
          setFaqItem(item, false);
          var button = item.querySelector('.faq-question');
          if(!button) return;

          button.addEventListener('click', function(){
            var shouldOpen = !item.classList.contains('is-open');
            items.forEach(function(otherItem){
              setFaqItem(otherItem, otherItem === item && shouldOpen);
            });
          });
        });
      });

      var videoShell = document.getElementById('overview-video-shell');
      var videoFrame = document.getElementById('overview-video-frame');
      document.querySelectorAll('[data-video-zoom]').forEach(function(button){
        button.addEventListener('click', function(){
          if(videoShell){
            videoShell.setAttribute('data-zoom', button.getAttribute('data-video-zoom'));
          }
        });
      });
      var videoFullscreen = document.getElementById('video-fullscreen');
      if(videoFullscreen && videoFrame){
        videoFullscreen.addEventListener('click', function(){
          if(videoFrame.requestFullscreen){
            videoFrame.requestFullscreen();
          } else if(videoFrame.webkitRequestFullscreen){
            videoFrame.webkitRequestFullscreen();
          }
        });
      }

      if('IntersectionObserver' in window && sticky && qualifier){
        var observer = new IntersectionObserver(function(entries){
          entries.forEach(function(entry){
            sticky.classList.toggle('is-hidden', entry.isIntersecting);
          });
        }, {threshold:.18});
        observer.observe(qualifier);
      }

      var stepTwoContent = {
        Health: {
          question: 'What health goal interests you most?',
          options: [
            {label: 'More energy & better daily wellness', value: 'Exploring', stepThree: 'health-energy'},
            {label: 'Weight management & fitness', value: 'SideIncome', stepThree: 'health-weight'},
            {label: 'Better immunity & overall health', value: 'Ready', stepThree: 'health-immunity'}
          ]
        },
        Income: {
          question: 'What are you looking for financially?',
          options: [
            {label: 'Extra side income', value: 'SideIncome', stepThree: 'income-side'},
            {label: 'Work from home opportunity', value: 'Exploring', stepThree: 'income-home'},
            {label: 'Financial freedom', value: 'Ready', stepThree: 'income-freedom'}
          ]
        },
        Both: {
          question: 'Which matters more to you right now?',
          options: [
            {label: 'Better health & more energy', value: 'Exploring', stepThree: 'both-health'},
            {label: 'Extra monthly income', value: 'SideIncome', stepThree: 'both-income'},
            {label: 'Health and income together', value: 'Ready', stepThree: 'both-together'}
          ]
        }
      };

      var stepThreeContent = {
        'health-energy': {
          question: 'What affects your daily energy the most?',
          options: ['Low energy in the morning', 'Afternoon tiredness', 'Stress and busy lifestyle']
        },
        'health-weight': {
          question: 'What is your biggest challenge with weight or fitness?',
          options: ['Controlling food cravings', 'Staying consistent', 'Low energy for exercise']
        },
        'health-immunity': {
          question: 'What kind of wellness support are you looking for?',
          options: ['Daily immune support', 'Natural wellness products', 'Better long-term health habits']
        },
        'income-side': {
          question: 'How much extra income would help you right now?',
          options: ['Small monthly support', 'A serious second income', 'I want to grow step by step']
        },
        'income-home': {
          question: 'Why does working from home interest you?',
          options: ['More time freedom', 'Flexible part-time work', 'Build income around my schedule']
        },
        'income-freedom': {
          question: 'What does financial freedom mean to you?',
          options: ['Less monthly pressure', 'More savings', 'Build long-term passive income']
        },
        'both-health': {
          question: 'Why do you want better health right now?',
          options: ['Feel more active daily', 'Improve wellness naturally', 'Support my family better']
        },
        'both-income': {
          question: 'What would extra income help you with most?',
          options: ['Monthly expenses', 'Family support', 'Savings and future goals']
        },
        'both-together': {
          question: 'Which result would make the biggest difference first?',
          options: ['Better personal wellness', 'Extra monthly income', 'Build both step by step']
        }
      };

      function renderStepTwo(interest){
        var content = stepTwoContent[interest] || stepTwoContent.Health;
        var question = document.getElementById('step-two-question');
        var options = document.getElementById('step-two-options');
        if(question) question.textContent = translateText(content.question);
        if(!options) return;
        options.innerHTML = '';
        content.options.forEach(function(option){
          var button = document.createElement('button');
          button.className = 'option-btn';
          button.type = 'button';
          button.dataset.key = 'seriousness';
          button.dataset.value = option.value;
          button.dataset.label = option.label;
          button.dataset.stepThree = option.stepThree;
          button.textContent = translateText(option.label);
          options.appendChild(button);
        });
      }

      function renderStepThree(stepThreeKey){
        var content = stepThreeContent[stepThreeKey] || stepThreeContent['health-energy'];
        var question = document.getElementById('step-three-question');
        var options = document.getElementById('step-three-options');
        if(question) question.textContent = translateText(content.question);
        if(!options) return;
        options.innerHTML = '';
        content.options.forEach(function(label, index){
          var button = document.createElement('button');
          button.className = 'option-btn';
          button.type = 'button';
          button.dataset.key = 'goal';
          button.dataset.value = label;
          button.dataset.scoreValue = index === 2 ? 'High' : index === 1 ? 'Medium' : 'Low';
          button.textContent = translateText(label);
          options.appendChild(button);
        });
      }

      function showStep(step){
        currentStep = step;
        document.querySelectorAll('.q-step').forEach(function(el){
          el.hidden = Number(el.getAttribute('data-step')) !== step;
        });
        var label = document.getElementById('step-label');
        var percent = document.getElementById('step-percent');
        var fill = document.getElementById('progress-fill');
        var progress = step >= 6 ? 100 : Math.round((step / 5) * 100);
        if(label) label.textContent = step >= 6 ? translateText('Complete') : (isArabic ? 'الخطوة ' + step + ' من 5' : 'Step ' + step + ' of 5');
        if(percent) percent.textContent = progress + '%';
        if(fill) fill.style.width = progress + '%';
        if(backBtn) backBtn.hidden = step <= 1 || step >= 6;
      }

      if(qualifier){
        qualifier.addEventListener('click', function(event){
          var btn = event.target.closest ? event.target.closest('.option-btn') : null;
          if(!btn || !qualifier.contains(btn)) return;
          leadData[btn.dataset.key] = btn.dataset.value;
          if(btn.dataset.label){
            leadData.stepTwoAnswer = btn.dataset.label;
          }
          if(btn.dataset.scoreValue){
            leadData.goalScore = btn.dataset.scoreValue;
          }
          if(btn.dataset.key === 'interest'){
            delete leadData.seriousness;
            delete leadData.stepTwoAnswer;
            delete leadData.goal;
            delete leadData.goalScore;
            renderStepTwo(btn.dataset.value);
          }
          if(btn.dataset.key === 'seriousness'){
            delete leadData.goal;
            delete leadData.goalScore;
            renderStepThree(btn.dataset.stepThree);
          }
          showStep(Math.min(currentStep + 1, 5));
        });
      }

      if(backBtn){
        backBtn.addEventListener('click', function(){
          showStep(Math.max(currentStep - 1, 1));
        });
      }

      function getScore(){
        var score = 'Cold';
        if (leadData.interest === 'Both' && leadData.seriousness === 'Ready' &&
          (leadData.goalScore === 'High' || leadData.goalScore === 'Medium') && leadData.learn === 'Yes') {
          score = 'Hot';
        } else if (leadData.interest !== 'Health' && leadData.seriousness !== 'Exploring' && leadData.learn !== 'No') {
          score = 'Warm';
        }
        return score;
      }

      function setScorePill(score){
        var pill = document.getElementById('score-pill');
        if(!pill) return;
        var messages = {
          Hot: 'Hot lead — priority call within 1 hour',
          Warm: 'Warm lead — follow-up within 24 hours',
          Cold: 'Nurture sequence started'
        };
        pill.className = 'score-pill score-' + score.toLowerCase();
        pill.textContent = translateText(messages[score]);
      }

      var selectedCountry = countries.find(function(country){ return country.iso === 'AE'; }) || countries[0];
      var countryToggle = document.getElementById('country-toggle');
      var countryMenu = document.getElementById('country-menu');
      var countrySearch = document.getElementById('country-search');
      var countryList = document.getElementById('country-list');
      var countryEmpty = document.getElementById('country-empty');
      var selectedFlag = document.getElementById('selected-country-flag');
      var selectedLabel = document.getElementById('selected-country-label');
      var countryCodeInput = document.getElementById('country-code');
      var countryNameInput = document.getElementById('country-name');
      var whatsappPhoneInput = document.getElementById('whatsapp-phone');
      var whatsappCombinedInput = document.getElementById('whatsapp');
      var activeCountryIndex = 0;

      function countryLabel(country){
        return country.iso === 'AE' ? 'UAE ' + country.code : country.iso + ' ' + country.code;
      }

      function countryFlagUrl(country){
        return 'https://flagcdn.com/w40/' + country.iso.toLowerCase() + '.png';
      }

      function setSelectedCountry(country){
        selectedCountry = country;
        if(selectedFlag) selectedFlag.src = countryFlagUrl(country);
        if(selectedLabel) selectedLabel.textContent = countryLabel(country);
        if(countryCodeInput) countryCodeInput.value = country.code;
        if(countryNameInput) countryNameInput.value = country.name;
        updateCombinedWhatsApp();
      }

      function normalizeDialCode(code){
        return code.replace(/[^\d+]/g, '');
      }

      function normalizePhoneDigits(value){
        return value.replace(/\D/g, '');
      }

      function buildWhatsAppNumber(){
        var rawPhone = whatsappPhoneInput ? whatsappPhoneInput.value.trim() : '';
        var normalizedCode = normalizeDialCode(selectedCountry.code);
        var localDigits = normalizePhoneDigits(rawPhone).replace(/^0+/, '');
        if(rawPhone.indexOf('+') === 0){
          return '+' + normalizePhoneDigits(rawPhone);
        }
        return normalizedCode + localDigits;
      }

      function updateCombinedWhatsApp(){
        if(whatsappCombinedInput) whatsappCombinedInput.value = buildWhatsAppNumber();
      }

      function phoneIsValid(){
        if(!whatsappPhoneInput) return false;
        var rawPhone = whatsappPhoneInput.value.trim();
        var localDigits = normalizePhoneDigits(rawPhone);
        if(rawPhone.indexOf('+') === 0){
          return localDigits.length >= 8 && localDigits.length <= 15;
        }
        return localDigits.length >= 6 && localDigits.length <= 15;
      }

      function filteredCountries(query){
        var needle = query.trim().toLowerCase();
        if(!needle) return countries;
        return countries.filter(function(country){
          var haystack = [country.name, country.code, country.iso, country.aliases || ''].join(' ').toLowerCase();
          return haystack.indexOf(needle) !== -1;
        });
      }

      function renderCountries(query){
        if(!countryList) return;
        var matches = filteredCountries(query || '');
        activeCountryIndex = 0;
        countryList.innerHTML = '';
        matches.forEach(function(country, index){
          var option = document.createElement('button');
          option.type = 'button';
          option.className = 'country-option' + (index === 0 ? ' is-active' : '');
          option.setAttribute('role', 'option');
          option.setAttribute('aria-selected', country.iso === selectedCountry.iso ? 'true' : 'false');
          option.dataset.index = String(index);
          option.innerHTML = '<img class="country-flag" src="' + countryFlagUrl(country) + '" alt="" width="22" height="16" loading="lazy">' +
            '<span class="country-option-meta"><span class="country-option-name">' + country.name + '</span>' +
            '<span class="country-option-code">' + country.code + '</span></span>';
          option.addEventListener('click', function(){
            setSelectedCountry(country);
            closeCountryMenu();
            if(whatsappPhoneInput) whatsappPhoneInput.focus();
          });
          countryList.appendChild(option);
        });
        if(countryEmpty) countryEmpty.classList.toggle('is-visible', matches.length === 0);
      }

      function openCountryMenu(){
        if(!countryMenu || !countryToggle || !countrySearch) return;
        countryMenu.classList.add('is-open');
        countryToggle.setAttribute('aria-expanded', 'true');
        countrySearch.value = '';
        renderCountries('');
        setTimeout(function(){ countrySearch.focus(); }, 0);
      }

      function closeCountryMenu(){
        if(!countryMenu || !countryToggle) return;
        countryMenu.classList.remove('is-open');
        countryToggle.setAttribute('aria-expanded', 'false');
      }

      function moveActiveCountry(direction){
        if(!countryList) return;
        var options = Array.prototype.slice.call(countryList.querySelectorAll('.country-option'));
        if(!options.length) return;
        activeCountryIndex = Math.max(0, Math.min(options.length - 1, activeCountryIndex + direction));
        options.forEach(function(option, index){
          option.classList.toggle('is-active', index === activeCountryIndex);
        });
        options[activeCountryIndex].scrollIntoView({block:'nearest'});
      }

      function chooseActiveCountry(){
        if(!countryList) return;
        var option = countryList.querySelectorAll('.country-option')[activeCountryIndex];
        if(option) option.click();
      }

      setSelectedCountry(selectedCountry);
      renderCountries('');

      if(countryToggle){
        countryToggle.addEventListener('click', function(){
          if(countryMenu && countryMenu.classList.contains('is-open')){
            closeCountryMenu();
          } else {
            openCountryMenu();
          }
        });
      }

      if(countrySearch){
        countrySearch.addEventListener('input', function(){
          renderCountries(countrySearch.value);
        });
        countrySearch.addEventListener('keydown', function(event){
          if(event.key === 'ArrowDown'){
            event.preventDefault();
            moveActiveCountry(1);
          } else if(event.key === 'ArrowUp'){
            event.preventDefault();
            moveActiveCountry(-1);
          } else if(event.key === 'Enter'){
            event.preventDefault();
            chooseActiveCountry();
          } else if(event.key === 'Escape'){
            closeCountryMenu();
            if(countryToggle) countryToggle.focus();
          }
        });
      }

      if(whatsappPhoneInput){
        whatsappPhoneInput.addEventListener('input', updateCombinedWhatsApp);
      }

      document.addEventListener('click', function(event){
        var clickTarget = event.target;
        if(countryMenu && countryMenu.classList.contains('is-open') && !(clickTarget.closest && clickTarget.closest('[data-country-select]'))){
          closeCountryMenu();
        }
      });

      var form = document.getElementById('lead-form');
      if(form){
        form.addEventListener('submit', function(event){
          event.preventDefault();
          var error = document.getElementById('form-error');
          var nameInput = form.querySelector('[name="name"]');
          var emailInput = form.querySelector('[name="email"]');
          var name = nameInput ? nameInput.value.trim() : '';
          var email = emailInput ? emailInput.value.trim() : '';
          var whatsapp = buildWhatsAppNumber();
          updateCombinedWhatsApp();
          if(!name || !email || !emailInput || !emailInput.checkValidity() || !phoneIsValid()){
            if(error) error.textContent = translateText('Please complete your name, a valid email, and a valid WhatsApp number.');
            if(error) error.classList.add('show');
            return;
          }
          if(error) error.classList.remove('show');
          var score = getScore();
          var payload = {
            name: name,
            email: email,
            whatsapp: whatsapp,
            country_code: selectedCountry.code,
            country_name: selectedCountry.name,
            interest: leadData.interest || '',
            seriousness: leadData.seriousness || '',
            goal: leadData.goal || '',
            learn: leadData.learn || '',
            score: score,
            source: 'freedomwithdxn.com',
            timestamp: new Date().toISOString(),
            utm_source: utm.utm_source,
            utm_medium: utm.utm_medium,
            utm_campaign: utm.utm_campaign
          };

          fetch('/api/dxn-lead', {
            method: 'POST',
            headers: {
              'Accept': 'application/json',
              'Content-Type': 'application/json'
            },
            body: JSON.stringify(payload),
            keepalive: true
          }).then(function(response){
            if(!response.ok){
              return response.json().catch(function(){
                return {};
              }).then(function(data){
                throw new Error(data.message || 'Lead sync failed');
              });
            }

            if(window.gtag){
              window.gtag('event', 'lead_submitted', {score: score});
            }
            if(window.fbq){
              var scoreValue = score === 'Hot' ? 3 : score === 'Warm' ? 2 : 1;
              window.fbq('track', 'Lead', {value: scoreValue});
            }

            setScorePill(score);
            showStep(6);
          }).catch(function(submitError){
            if(error){
              error.textContent = submitError.message || translateText('We could not submit your details right now. Please try again in a moment.');
              error.classList.add('show');
            }
          });
        });
      }
      translatePage();
    })();
  </script>
</body>
</html>
