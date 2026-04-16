@extends('layouts.app')
@section('title', 'Join DXN - Say Yes to Your Financial Freedom | Freedom With DXN')
@section('description', 'Join the DXN team and say yes to financial freedom. 6M+ members worldwide, 180+ countries, 30+ years established. Use referral code 141019805 to start.')
@section('keywords', 'join DXN team, DXN business opportunity, DXN distributor UAE, referral code 141019805')

@php
    $lang = session('lang', 'en');
    $whatsapp = $settings->contact['whatsapp'] ?? 'https://wa.me/message/EFSQ2IDNVG3YB1';
    $calendly = 'https://calendly.com/freedom-with-dxn2026/welcome-to-freedom-with-dxn';
    $referralCode = '141019805';
    $videoId = 'ltrQYyUNgU0';

    $trustStats = $lang === 'ar' ? [
        ['num' => '+22 مليون', 'label' => 'عضو حول العالم'],
        ['num' => '+180', 'label' => 'دولة'],
        ['num' => '+30', 'label' => 'عامًا من التأسيس'],
        ['num' => 'الإمارات', 'label' => 'نشطون محليًا'],
    ] : [
        ['num' => '22M+', 'label' => 'Members Worldwide'],
        ['num' => '180+', 'label' => 'Countries'],
        ['num' => '30+', 'label' => 'Years Established'],
        ['num' => 'UAE', 'label' => 'Based & Active'],
    ];

    $benefits = $lang === 'ar' ? [
        ['icon' => '✦', 'title' => 'منتجات عالمية المستوى', 'desc' => 'مكملات الجانوديرما وقهوة لينجي ومنتجات صحية معتمدة من GMP ومصنوعة في مزارع DXN الخاصة.'],
        ['icon' => '◈', 'title' => 'دخل سلبي حقيقي', 'desc' => 'اكسب عمولات على مبيعاتك ومبيعات فريقك. الدخل يتراكم مع نمو شبكتك.'],
        ['icon' => '◉', 'title' => 'شبكة عالمية', 'desc' => 'انضم إلى مجتمع من أكثر من 6 ملايين عضو نشط حول العالم. تواصل وتعلم وانمُ.'],
        ['icon' => '◎', 'title' => 'اعمل من أي مكان', 'desc' => 'لا مكتب. لا مواعيد. ابنِ عملك من المنزل أو المقهى أو أثناء السفر.'],
        ['icon' => '✧', 'title' => 'تدريب أسبوعي مجاني', 'desc' => 'جلسات زووم أسبوعية بالعربية والإنجليزية تغطي المنتجات والعمل والنمو الشخصي.'],
        ['icon' => '✪', 'title' => 'إرشاد شخصي', 'desc' => 'ستحصل على دعم شخصي مباشر مني لتتقدم أسرع وتتجنب الأخطاء الشائعة.'],
    ] : [
        ['icon' => '✦', 'title' => 'World-Class Products', 'desc' => 'Ganoderma supplements, Lingzhi coffee, and wellness products — GMP certified and cultivated on DXN farms.'],
        ['icon' => '◈', 'title' => 'Real Passive Income', 'desc' => 'Earn commissions on your sales and your team\'s. Income compounds as your network grows.'],
        ['icon' => '◉', 'title' => 'Global Network', 'desc' => 'Join a community of 6+ million active members worldwide. Connect, learn, grow together.'],
        ['icon' => '◎', 'title' => 'Work From Anywhere', 'desc' => 'No office. No fixed hours. Build your business from home, a cafe, or while traveling.'],
        ['icon' => '✧', 'title' => 'Free Weekly Training', 'desc' => 'Weekly Zoom sessions in Arabic and English covering products, business, and personal growth.'],
        ['icon' => '✪', 'title' => 'Personal Mentorship', 'desc' => 'Get direct 1-on-1 mentorship from me to move faster and avoid common mistakes.'],
    ];

    $steps = $lang === 'ar' ? [
        ['num' => '01', 'title' => 'تواصل عبر واتساب', 'desc' => 'أرسل لي رسالة واتساب. أخبرني باسمك ودولتك. يستغرق ذلك دقيقتين فقط.'],
        ['num' => '02', 'title' => 'سجّل بالكود ' . $referralCode, 'desc' => 'سأرسل لك رابط التسجيل. استخدم كود الإحالة الخاص بي للانضمام رسميًا.'],
        ['num' => '03', 'title' => 'جرّب المنتجات', 'desc' => 'ابدأ بقهوة لينجي أو كبسولات RG/GL. استخدمها يوميًا لمدة 30 يومًا على الأقل.'],
        ['num' => '04', 'title' => 'احضر زووم', 'desc' => 'انضم إلى جلسات التدريب الأسبوعية المجانية لتتعلم المنتجات وخطة العمل.'],
        ['num' => '05', 'title' => 'شارك واكسب', 'desc' => 'شارك تجربتك مع عائلتك وأصدقائك. اكسب عمولات على كل عملية شراء أو تسجيل.'],
        ['num' => '06', 'title' => 'ابنِ فريقك', 'desc' => 'ادعُ آخرين للانضمام تحتك. كلما نما فريقك، زاد دخلك السلبي.'],
    ] : [
        ['num' => '01', 'title' => 'Contact via WhatsApp', 'desc' => 'Send me a WhatsApp message. Tell me your name and country. Takes 2 minutes.'],
        ['num' => '02', 'title' => 'Register (code ' . $referralCode . ')', 'desc' => 'I\'ll send you the registration link. Use my referral code to join officially.'],
        ['num' => '03', 'title' => 'Try the Products', 'desc' => 'Start with Lingzhi Coffee or RG/GL capsules. Use them daily for at least 30 days.'],
        ['num' => '04', 'title' => 'Attend Zoom', 'desc' => 'Join our free weekly training sessions to learn products and the business plan.'],
        ['num' => '05', 'title' => 'Share & Earn', 'desc' => 'Share your experience with friends and family. Earn commissions on every purchase or signup.'],
        ['num' => '06', 'title' => 'Build Your Team', 'desc' => 'Invite others to join under you. As your team grows, so does your passive income.'],
    ];

    $zoomSessions = [
        ['day' => 'Sunday', 'time' => '3pm-5pm', 'lang_label' => 'Arabic', 'accent' => '#43af73'],
    ];

    $faqs = $lang === 'ar' ? [
        ['q' => 'هل DXN شرعية؟', 'a' => 'نعم. تأسست DXN عام 1993 في ماليزيا وتعمل في أكثر من 180 دولة مع 6 ملايين عضو نشط. إنها شركة بيع مباشر معروفة وموثوقة.'],
        ['q' => 'كم يكلف البدء؟', 'a' => 'رسوم التسجيل منخفضة جدًا (عادةً 10-25 دولارًا فقط). لا يوجد حصة شراء شهرية ولا رسوم تجديد سنوية.'],
        ['q' => 'هل منتجات DXN حلال؟', 'a' => 'نعم. جميع منتجات DXN حاصلة على شهادة حلال. فطر الجانوديرما مكون نباتي بالكامل.'],
        ['q' => 'هل أحتاج إلى خبرة؟', 'a' => 'لا. توفر DXN تدريبًا مجانيًا كاملًا من خلال جلسات زووم الأسبوعية. سأرشدك شخصيًا في كل خطوة.'],
        ['q' => 'كيف أكسب المال؟', 'a' => 'تكسب من ربح التجزئة (الفرق بين سعر العضو وسعر التجزئة)، ومكافآت المجموعة، ومكافآت القيادة مع نمو فريقك.'],
        ['q' => 'هل يمكنني العمل بدوام جزئي؟', 'a' => 'بالتأكيد. لا توجد جداول ثابتة ولا حصص. يعمل معظم الأعضاء بدوام جزئي في البداية وينتقلون للدوام الكامل لاحقًا.'],
    ] : [
        ['q' => 'Is DXN legit?', 'a' => 'Yes. DXN was founded in 1993 in Malaysia and operates in 180+ countries with 6M+ active members. It\'s a well-established, trusted direct-selling company.'],
        ['q' => 'How much does it cost to start?', 'a' => 'The registration fee is very low (typically $10–$25 one-time). There is NO monthly purchase quota and NO annual renewal fees.'],
        ['q' => 'Are DXN products halal?', 'a' => 'Yes. All DXN products are halal-certified. The Ganoderma mushroom is a 100% plant-based ingredient.'],
        ['q' => 'Do I need experience?', 'a' => 'No. DXN provides complete free training through weekly Zoom sessions. I\'ll personally mentor you every step of the way.'],
        ['q' => 'How do I earn money?', 'a' => 'You earn from retail profit (member vs retail price), group bonuses, and leadership bonuses as your team grows.'],
        ['q' => 'Can I do it part-time?', 'a' => 'Absolutely. No fixed schedule, no quota. Most members start part-time and transition to full-time later when they\'re ready.'],
    ];
@endphp

@push('seo')
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "FAQPage",
    "mainEntity": [
        @foreach($faqs as $faq)
        {
            "@type": "Question",
            "name": "{{ $faq['q'] }}",
            "acceptedAnswer": { "@type": "Answer", "text": "{{ $faq['a'] }}" }
        }@if(!$loop->last),@endif
        @endforeach
    ]
}
</script>
@endpush

@push('styles')
<style>
    :root {
        --dxn-violet: #46387b;
        --dxn-violet-dark: #2c1c5f;
        --dxn-green: #43af73;
        --dxn-red: #bf3c36;
        --dxn-gold: #c9a84c;
    }
    .join-page { font-family: 'DM Sans', 'DM Sans Fallback', 'Inter', system-ui, sans-serif; color: #1c1c1c; }
    .join-page h1, .join-page h2, .join-page h3 { font-family: 'DM Sans', 'DM Sans Fallback', 'Inter', system-ui, sans-serif; font-weight: 700; letter-spacing: -0.02em; }

    /* HERO */
    .join-hero { position: relative; background: var(--dxn-violet-dark); overflow: hidden; padding: clamp(80px, 12vw, 140px) 20px; }
    .join-hero::before, .join-hero::after {
        content: ''; position: absolute; border-radius: 50%; filter: blur(80px); pointer-events: none;
    }
    .join-hero::before {
        width: 520px; height: 520px; top: -160px; left: -120px;
        background: radial-gradient(circle, rgba(70,56,123,0.85), rgba(70,56,123,0) 70%);
        animation: orb-drift-a 14s ease-in-out infinite;
    }
    .join-hero::after {
        width: 640px; height: 640px; bottom: -220px; right: -180px;
        background: radial-gradient(circle, rgba(201,168,76,0.45), rgba(201,168,76,0) 70%);
        animation: orb-drift-b 18s ease-in-out infinite;
    }
    .join-hero-orb-3 {
        position: absolute; width: 380px; height: 380px; top: 30%; right: 20%;
        border-radius: 50%; filter: blur(100px); pointer-events: none;
        background: radial-gradient(circle, rgba(67,175,115,0.35), rgba(67,175,115,0) 70%);
        animation: orb-drift-a 20s ease-in-out infinite reverse;
    }
    @keyframes orb-drift-a {
        0%,100% { transform: translate(0,0) scale(1); }
        50% { transform: translate(40px,-30px) scale(1.08); }
    }
    @keyframes orb-drift-b {
        0%,100% { transform: translate(0,0) scale(1); }
        50% { transform: translate(-60px,40px) scale(1.12); }
    }

    .hero-inner { position: relative; max-width: 960px; margin: 0 auto; text-align: center; z-index: 2; }
    .hero-tag { display: inline-flex; align-items: center; gap: 12px; background: var(--dxn-red); border: 2px solid rgba(255,255,255,0.25); color: #fff; padding: 14px 32px; border-radius: 100px; font-size: 16px; font-weight: 800; letter-spacing: 2.5px; text-transform: uppercase; margin-bottom: 28px; text-decoration: none; box-shadow: 0 8px 28px rgba(191,60,54,0.5); transition: transform 0.2s, box-shadow 0.2s, background 0.2s; }
    .hero-tag:hover { transform: translateY(-3px) scale(1.04); box-shadow: 0 14px 36px rgba(191,60,54,0.65); background: #d9443d; }
    .hero-tag-dot { width: 10px; height: 10px; border-radius: 50%; background: #fff; box-shadow: 0 0 14px rgba(255,255,255,0.8); animation: pulse 2s ease-in-out infinite; }
    @keyframes pulse { 0%,100% { opacity: 1; } 50% { opacity: 0.4; } }

    .hero-headline { font-size: clamp(40px, 7vw, 82px); line-height: 1.05; color: #fff; margin-bottom: 24px; }
    .hero-headline .yes { font-style: italic; color: var(--dxn-gold); position: relative; }
    .hero-headline .yes::after {
        content: ''; position: absolute; left: 0; right: 0; bottom: -4px; height: 3px;
        background: linear-gradient(90deg, transparent, var(--dxn-gold), transparent);
        transform: scaleX(0); transform-origin: center;
        animation: line-grow 1.2s ease 0.8s forwards;
    }
    @keyframes line-grow { to { transform: scaleX(1); } }
    .hero-subline { font-size: clamp(16px, 2vw, 20px); color: rgba(255,255,255,0.7); max-width: 560px; margin: 0 auto 32px; line-height: 1.6; }

    .hero-referral { display: inline-flex; align-items: center; gap: 12px; background: rgba(255,255,255,0.06); border: 1px solid rgba(255,255,255,0.15); backdrop-filter: blur(8px); padding: 12px 22px; border-radius: 100px; margin-bottom: 40px; }
    .hero-referral-label { font-size: 11px; letter-spacing: 2px; text-transform: uppercase; color: rgba(255,255,255,0.55); font-weight: 500; }
    .hero-referral-code { font-family: 'DM Sans', monospace; font-size: 18px; font-weight: 600; color: var(--dxn-gold); letter-spacing: 1px; }

    .hero-ctas { display: flex; flex-wrap: wrap; gap: 14px; justify-content: center; }
    .btn-hero { display: inline-flex; align-items: center; justify-content: center; gap: 10px; padding: 16px 34px; border-radius: 100px; font-size: 15px; font-weight: 600; letter-spacing: 0.3px; text-decoration: none; transition: all 0.25s ease; }
    .btn-hero-primary { background: var(--dxn-green); color: #fff; box-shadow: 0 10px 30px rgba(67,175,115,0.35); }
    .btn-hero-primary:hover { transform: translateY(-2px); box-shadow: 0 14px 36px rgba(67,175,115,0.5); background: #38a868; }
    .btn-hero-outline { border: 2px solid rgba(255,255,255,0.3); color: #fff; background: transparent; }
    .btn-hero-outline:hover { background: #fff; color: var(--dxn-violet-dark); border-color: #fff; transform: translateY(-2px); }

    /* TRUST BAR */
    .trust-bar { background: #fff; border-bottom: 1px solid #eee; padding: 36px 20px; }
    .trust-grid { max-width: 1120px; margin: 0 auto; display: grid; grid-template-columns: repeat(4, 1fr); gap: 24px; text-align: center; }
    .trust-stat .num { font-family: 'DM Sans', 'DM Sans Fallback', 'Inter', system-ui, sans-serif; font-size: clamp(28px, 3.5vw, 42px); font-weight: 700; color: var(--dxn-violet); line-height: 1; }
    .trust-stat .label { font-size: 12px; color: #6b7280; letter-spacing: 1.5px; text-transform: uppercase; margin-top: 8px; font-weight: 500; }

    /* VIDEO SECTION */
    .video-section { background: #111; padding: clamp(70px, 10vw, 120px) 20px; position: relative; }
    .video-section::before { content: ''; position: absolute; inset: 0; background: radial-gradient(ellipse at center top, rgba(70,56,123,0.25), transparent 60%); pointer-events: none; }
    .video-inner { max-width: 960px; margin: 0 auto; position: relative; }
    .video-title { text-align: center; font-size: clamp(18px, 4vw, 44px); color: #fff; margin-bottom: 14px; white-space: nowrap; }
    .video-subtitle { text-align: center; color: rgba(255,255,255,0.55); font-size: 16px; margin-bottom: 48px; max-width: 540px; margin-left: auto; margin-right: auto; }
    .video-wrapper { position: relative; padding: 4px; border-radius: 20px; background: linear-gradient(135deg, var(--dxn-violet), var(--dxn-green) 40%, var(--dxn-gold) 70%, var(--dxn-red)); box-shadow: 0 30px 80px rgba(0,0,0,0.5); }
    .video-frame { position: relative; border-radius: 16px; overflow: hidden; aspect-ratio: 16 / 9; background: #000; }
    .video-frame iframe { position: absolute; inset: 0; width: 100%; height: 100%; border: 0; }

    /* BENEFITS */
    .benefits-section { background: #f7f5fc; padding: clamp(70px, 10vw, 120px) 20px; }
    .section-inner { max-width: 1160px; margin: 0 auto; }
    .section-head { text-align: center; margin-bottom: 56px; }
    .section-eyebrow { font-size: 12px; letter-spacing: 2.5px; text-transform: uppercase; color: var(--dxn-green); font-weight: 600; margin-bottom: 14px; }
    .section-title { font-size: clamp(32px, 5vw, 56px); color: var(--dxn-violet); line-height: 1.1; }
    .section-sub { color: #6b7280; font-size: 17px; margin-top: 14px; max-width: 560px; margin-left: auto; margin-right: auto; line-height: 1.6; }

    .benefits-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 22px; }
    .benefit-card { position: relative; background: #fff; border-radius: 16px; padding: 36px 28px; border: 1px solid #ececf5; overflow: hidden; transition: transform 0.35s ease, box-shadow 0.35s ease; }
    .benefit-card::before {
        content: ''; position: absolute; top: 0; left: 0; right: 0; height: 3px;
        background: linear-gradient(90deg, var(--dxn-green), var(--dxn-gold), var(--dxn-red));
        transform: scaleX(0); transform-origin: left; transition: transform 0.5s ease;
    }
    .benefit-card:hover { transform: translateY(-6px); box-shadow: 0 20px 50px rgba(70,56,123,0.15); }
    .benefit-card:hover::before { transform: scaleX(1); }
    .benefit-icon { font-size: 32px; color: var(--dxn-gold); margin-bottom: 20px; display: block; line-height: 1; }
    .benefit-title { font-size: 22px; color: var(--dxn-violet); margin-bottom: 12px; }
    .benefit-desc { color: #6b7280; font-size: 14px; line-height: 1.7; }

    /* STEPS */
    .steps-section { background: var(--dxn-violet-dark); padding: clamp(70px, 10vw, 120px) 20px; position: relative; overflow: hidden; }
    .steps-section::before { content: ''; position: absolute; inset: 0; background: radial-gradient(ellipse at 20% 30%, rgba(67,175,115,0.12), transparent 50%), radial-gradient(ellipse at 80% 70%, rgba(201,168,76,0.1), transparent 50%); pointer-events: none; }
    .steps-section .section-title { color: #fff; }
    .steps-section .section-sub { color: rgba(255,255,255,0.6); }
    .steps-section .section-eyebrow { color: var(--dxn-gold); }
    .steps-inner { max-width: 760px; margin: 0 auto; position: relative; }
    .steps-line { position: absolute; left: 39px; top: 0; bottom: 0; width: 2px; background: linear-gradient(to bottom, transparent, rgba(201,168,76,0.4) 10%, rgba(201,168,76,0.4) 90%, transparent); }
    .step-item { position: relative; display: flex; gap: 28px; padding: 18px 0 40px; }
    .step-item:last-child { padding-bottom: 0; }
    .step-num { flex-shrink: 0; width: 80px; height: 80px; border-radius: 50%; background: var(--dxn-violet); border: 2px solid rgba(201,168,76,0.5); display: flex; align-items: center; justify-content: center; font-family: 'DM Sans', 'DM Sans Fallback', 'Inter', system-ui, sans-serif; font-size: 28px; font-weight: 700; color: var(--dxn-gold); position: relative; z-index: 2; box-shadow: 0 8px 20px rgba(0,0,0,0.3); }
    .step-content { padding-top: 14px; }
    .step-title { font-size: 24px; color: #fff; margin-bottom: 8px; font-family: 'DM Sans', 'DM Sans Fallback', 'Inter', system-ui, sans-serif; font-weight: 700; }
    .step-desc { color: rgba(255,255,255,0.65); font-size: 15px; line-height: 1.7; }

    /* REFERRAL SPOTLIGHT */
    .referral-section { background: #f7f5fc; padding: clamp(70px, 10vw, 120px) 20px; }
    .referral-card { max-width: 640px; margin: 0 auto; background: #fff; border-radius: 24px; padding: 56px 40px; text-align: center; position: relative; overflow: hidden; box-shadow: 0 30px 70px rgba(70,56,123,0.12); }
    .referral-card::before { content: ''; position: absolute; top: 0; left: 0; right: 0; height: 5px; background: linear-gradient(90deg, var(--dxn-violet), var(--dxn-green), var(--dxn-gold), var(--dxn-red)); }
    .referral-eyebrow { font-size: 12px; letter-spacing: 2.5px; text-transform: uppercase; color: var(--dxn-green); font-weight: 600; margin-bottom: 14px; }
    .referral-title { font-size: clamp(26px, 4vw, 36px); color: var(--dxn-violet); margin-bottom: 28px; }
    .referral-code-box { display: inline-block; padding: 20px 44px; background: linear-gradient(135deg, #f7f5fc, #eceaf7); border: 2px dashed var(--dxn-violet); border-radius: 14px; margin-bottom: 28px; }
    .referral-code-label { font-size: 11px; letter-spacing: 2px; text-transform: uppercase; color: #6b7280; margin-bottom: 6px; display: block; font-weight: 500; }
    .referral-code-value { font-size: clamp(32px, 5vw, 48px); font-weight: 700; color: var(--dxn-violet); font-family: 'DM Sans', 'DM Sans Fallback', 'Inter', system-ui, sans-serif; letter-spacing: 3px; line-height: 1; }
    .referral-hint { color: #6b7280; font-size: 14px; margin-bottom: 28px; line-height: 1.6; }
    .btn-referral { display: inline-flex; align-items: center; justify-content: center; gap: 10px; background: var(--dxn-green); color: #fff; padding: 16px 36px; border-radius: 100px; font-weight: 600; text-decoration: none; font-size: 15px; transition: all 0.25s ease; box-shadow: 0 10px 28px rgba(67,175,115,0.3); }
    .btn-referral:hover { transform: translateY(-2px); background: #38a868; box-shadow: 0 14px 34px rgba(67,175,115,0.45); }

    /* ZOOM SCHEDULE */
    .zoom-section { background: #fff; padding: clamp(70px, 10vw, 120px) 20px; }
    .zoom-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px; max-width: 1120px; margin: 0 auto; }
    .zoom-card { display: block; position: relative; background: #fff; border: 1px solid #ececf5; border-radius: 16px; padding: 32px 24px; text-decoration: none; color: inherit; overflow: hidden; text-align: center; transition: transform 0.35s ease, box-shadow 0.35s ease; }
    .zoom-card::before {
        content: ''; position: absolute; top: 0; left: 0; right: 0; height: 3px;
        background: linear-gradient(90deg, var(--dxn-green), var(--dxn-gold), var(--dxn-red));
        transform: scaleX(0); transform-origin: left; transition: transform 0.5s ease;
    }
    .zoom-card:hover { transform: translateY(-6px); box-shadow: 0 20px 50px rgba(70,56,123,0.15); }
    .zoom-card:hover::before { transform: scaleX(1); }
    .zoom-day { font-family: 'DM Sans', 'DM Sans Fallback', 'Inter', system-ui, sans-serif; font-size: 26px; font-weight: 700; color: var(--dxn-violet); margin-bottom: 6px; }
    .zoom-time { font-size: 14px; color: #6b7280; margin-bottom: 16px; }
    .zoom-lang { display: inline-block; background: #f7f5fc; color: var(--dxn-violet); padding: 6px 14px; border-radius: 100px; font-size: 12px; font-weight: 600; letter-spacing: 0.5px; }

    /* FAQ */
    .faq-section { background: #f7f5fc; padding: clamp(70px, 10vw, 120px) 20px; }
    .faq-list { max-width: 780px; margin: 0 auto; }
    .faq-item { background: #fff; border: 1px solid #ececf5; border-radius: 14px; margin-bottom: 14px; overflow: hidden; transition: box-shadow 0.25s ease; }
    .faq-item.open { box-shadow: 0 14px 40px rgba(70,56,123,0.12); }
    .faq-question { display: flex; align-items: center; justify-content: space-between; gap: 16px; width: 100%; padding: 22px 26px; background: transparent; border: 0; cursor: pointer; text-align: start; font-family: 'DM Sans', 'DM Sans Fallback', 'Inter', system-ui, sans-serif; font-size: 20px; font-weight: 700; color: var(--dxn-violet); }
    .faq-toggle { flex-shrink: 0; width: 28px; height: 28px; border-radius: 50%; background: var(--dxn-green); color: #fff; display: flex; align-items: center; justify-content: center; font-size: 18px; transition: transform 0.3s ease; }
    .faq-item.open .faq-toggle { transform: rotate(45deg); background: var(--dxn-red); }
    .faq-answer { max-height: 0; overflow: hidden; transition: max-height 0.4s ease, padding 0.4s ease; color: #6b7280; font-size: 15px; line-height: 1.7; padding: 0 26px; }
    .faq-item.open .faq-answer { max-height: 400px; padding: 0 26px 24px; }

    /* FINAL CTA */
    .final-cta { background: var(--dxn-violet-dark); padding: clamp(80px, 12vw, 140px) 20px; position: relative; overflow: hidden; text-align: center; }
    .final-cta::before, .final-cta::after { content: ''; position: absolute; border-radius: 50%; filter: blur(90px); pointer-events: none; }
    .final-cta::before { width: 500px; height: 500px; top: -180px; right: -120px; background: radial-gradient(circle, rgba(201,168,76,0.35), transparent 70%); }
    .final-cta::after { width: 500px; height: 500px; bottom: -180px; left: -120px; background: radial-gradient(circle, rgba(67,175,115,0.3), transparent 70%); }
    .final-cta-inner { max-width: 720px; margin: 0 auto; position: relative; z-index: 2; }
    .final-cta h2 { font-size: clamp(36px, 6vw, 64px); color: #fff; line-height: 1.1; margin-bottom: 20px; }
    .final-cta p { color: rgba(255,255,255,0.7); font-size: 17px; margin-bottom: 36px; line-height: 1.6; }

    /* REVEAL ANIMATION */
    .reveal { opacity: 0; transform: translateY(28px); transition: opacity 0.8s ease, transform 0.8s ease; }
    .reveal.in-view { opacity: 1; transform: translateY(0); }

    /* RESPONSIVE */
    @media (max-width: 900px) {
        .benefits-grid { grid-template-columns: repeat(2, 1fr); }
        .zoom-grid { grid-template-columns: repeat(2, 1fr); }
        .trust-grid { grid-template-columns: repeat(2, 1fr); gap: 32px; }
        .step-num { width: 64px; height: 64px; font-size: 22px; }
        .steps-line { left: 31px; }
    }
    @media (max-width: 560px) {
        .benefits-grid { grid-template-columns: 1fr; }
        .zoom-grid { grid-template-columns: 1fr; }
        .hero-ctas { flex-direction: column; align-items: stretch; }
        .btn-hero { width: 100%; }
        .step-item { gap: 18px; }
        .step-num { width: 56px; height: 56px; font-size: 20px; }
        .steps-line { left: 27px; }
        .referral-card { padding: 40px 24px; }
        .faq-question { font-size: 17px; padding: 18px 20px; }
        .faq-item.open .faq-answer { padding: 0 20px 20px; }
    }
    [dir="rtl"] .steps-line { left: auto; right: 39px; }
    @media (max-width: 900px) { [dir="rtl"] .steps-line { right: 31px; } }
    @media (max-width: 560px) { [dir="rtl"] .steps-line { right: 27px; } }
</style>
@endpush

@section('content')
<div class="join-page">

    {{-- HERO --}}
    <section class="join-hero">
        <div class="join-hero-orb-3"></div>
        <div class="hero-inner">
            <a href="https://eworld.dxn2u.com/s/accreg/en/141019805" target="_blank" rel="noopener noreferrer" class="hero-tag reveal">
                <span class="hero-tag-dot"></span>
                {{ $lang === 'ar' ? 'انضم إلى DXN اليوم' : 'Join DXN Today' }}
            </a>
            <h1 class="hero-headline reveal">
                {{ $lang === 'ar' ? 'قل ' : 'Say ' }}<span class="yes">{{ $lang === 'ar' ? 'نعم' : 'Yes' }}</span>{{ $lang === 'ar' ? ' لحريتك المالية' : ' to Your Financial Freedom' }}
            </h1>
            <p class="hero-subline reveal">
                {{ $lang === 'ar' ? 'القرار الذي يغيّر كل شيء يبدأ من هنا.' : 'The decision that changes everything starts here.' }}
            </p>
            <div class="hero-referral reveal">
                <span class="hero-referral-label">{{ $lang === 'ar' ? 'كود الإحالة' : 'Referral Code' }}</span>
                <span class="hero-referral-code">{{ $referralCode }}</span>
            </div>
            <div class="hero-ctas reveal">
                <a href="{{ $whatsapp }}" target="_blank" rel="noopener noreferrer" class="btn-hero btn-hero-primary">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487 2.981 1.287 2.981.859 3.518.805.537-.054 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347M12.05 21.785h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                    {{ $lang === 'ar' ? 'ابدأ عبر واتساب' : 'Start on WhatsApp' }}
                </a>
                <a href="{{ $calendly }}" target="_blank" rel="noopener noreferrer" class="btn-hero btn-hero-outline">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                    {{ $lang === 'ar' ? 'احضر زووم مجاني' : 'Attend Free Zoom' }}
                </a>
            </div>
        </div>
    </section>

    {{-- TRUST BAR --}}
    <section class="trust-bar">
        <div class="trust-grid">
            @foreach($trustStats as $stat)
                <div class="trust-stat reveal">
                    <div class="num">{{ $stat['num'] }}</div>
                    <div class="label">{{ $stat['label'] }}</div>
                </div>
            @endforeach
        </div>
    </section>

    {{-- VIDEO --}}
    <section class="video-section">
        <div class="video-inner">
            <div class="section-eyebrow reveal" style="color: var(--dxn-gold); text-align: center; margin-bottom: 14px;">
                {{ $lang === 'ar' ? 'شاهد هذا أولًا' : 'Watch This First' }}
            </div>
            <h2 class="video-title reveal">
                {{ $lang === 'ar' ? 'رحلتك نحو الحرية تبدأ الآن' : 'Your Journey to Freedom Begins Now' }}
            </h2>
            <p class="video-subtitle reveal">
                {{ $lang === 'ar' ? '3 دقائق توضح لك كل ما تحتاج معرفته عن DXN وكيف يمكنك البدء اليوم.' : '3 minutes that show you everything you need to know about DXN and how to start today.' }}
            </p>
            <div class="video-wrapper reveal">
                <div class="video-frame">
                    <iframe src="https://www.youtube.com/embed/{{ $videoId }}" title="DXN Opportunity" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen loading="lazy"></iframe>
                </div>
            </div>
        </div>
    </section>

    {{-- BENEFITS --}}
    <section class="benefits-section">
        <div class="section-inner">
            <div class="section-head reveal">
                <div class="section-eyebrow">{{ $lang === 'ar' ? 'لماذا DXN' : 'Why DXN' }}</div>
                <h2 class="section-title">{{ $lang === 'ar' ? 'أكثر من مجرد عمل' : 'More Than Just a Business' }}</h2>
                <p class="section-sub">{{ $lang === 'ar' ? 'كل ما تحتاجه للنجاح مُقدَّم لك مجانًا من اليوم الأول.' : 'Everything you need to succeed, given to you free from day one.' }}</p>
            </div>
            <div class="benefits-grid">
                @foreach($benefits as $benefit)
                    <div class="benefit-card reveal">
                        <span class="benefit-icon">{{ $benefit['icon'] }}</span>
                        <h3 class="benefit-title">{{ $benefit['title'] }}</h3>
                        <p class="benefit-desc">{{ $benefit['desc'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- STEPS --}}
    <section class="steps-section">
        <div class="section-inner">
            <div class="section-head reveal">
                <div class="section-eyebrow">{{ $lang === 'ar' ? 'الطريق أمامك' : 'The Path Forward' }}</div>
                <h2 class="section-title">{{ $lang === 'ar' ? 'كيف تبدأ — 6 خطوات فقط' : 'How to Start — Just 6 Steps' }}</h2>
                <p class="section-sub">{{ $lang === 'ar' ? 'من أول رسالة واتساب إلى بناء فريقك الخاص.' : 'From your first WhatsApp message to building your own team.' }}</p>
            </div>
            <div class="steps-inner">
                <div class="steps-line"></div>
                @foreach($steps as $step)
                    <div class="step-item reveal">
                        <div class="step-num">{{ $step['num'] }}</div>
                        <div class="step-content">
                            <h3 class="step-title">{{ $step['title'] }}</h3>
                            <p class="step-desc">{{ $step['desc'] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- REFERRAL SPOTLIGHT --}}
    <section class="referral-section">
        <div class="referral-card reveal">
            <div class="referral-eyebrow">{{ $lang === 'ar' ? 'كودك المميز' : 'Your Personal Code' }}</div>
            <h2 class="referral-title">{{ $lang === 'ar' ? 'استخدم هذا الكود عند التسجيل' : 'Use This Code When You Register' }}</h2>
            <div class="referral-code-box">
                <span class="referral-code-label">{{ $lang === 'ar' ? 'كود الإحالة' : 'Referral Code' }}</span>
                <span class="referral-code-value">{{ $referralCode }}</span>
            </div>
            <p class="referral-hint">{{ $lang === 'ar' ? 'انسخ الكود أو احفظه. ستحتاجه خلال عملية التسجيل على موقع DXN الرسمي.' : 'Copy or save this code. You\'ll need it during the official DXN registration process.' }}</p>
            <a href="{{ $whatsapp }}" target="_blank" rel="noopener noreferrer" class="btn-referral">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487 2.981 1.287 2.981.859 3.518.805.537-.054 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347M12.05 21.785h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                {{ $lang === 'ar' ? 'راسلني للبدء' : 'Message Me to Begin' }}
            </a>
        </div>
    </section>

    {{-- ZOOM SCHEDULE --}}
    <section class="zoom-section" id="zoom">
        <div class="section-inner">
            <div class="section-head reveal">
                <div class="section-eyebrow">{{ $lang === 'ar' ? 'تدريب مجاني' : 'Free Training' }}</div>
                <h2 class="section-title">{{ $lang === 'ar' ? 'الجدول الأسبوعي لجلسات زووم' : 'Weekly Zoom Schedule' }}</h2>
                <p class="section-sub">{{ $lang === 'ar' ? 'اختر اليوم واللغة التي تناسبك. احضر بدون التزام.' : 'Pick the day and language that works for you. Attend with no commitment.' }}</p>
            </div>
            <div class="zoom-grid">
                @foreach($zoomSessions as $session)
                    <a href="{{ $calendly }}" target="_blank" rel="noopener noreferrer" class="zoom-card reveal">
                        <div class="zoom-day">{{ $session['day'] }}</div>
                        <div class="zoom-time">{{ $session['time'] }}</div>
                        <span class="zoom-lang">{{ $session['lang_label'] }}</span>
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    {{-- FAQ --}}
    <section class="faq-section">
        <div class="section-inner">
            <div class="section-head reveal">
                <div class="section-eyebrow">{{ $lang === 'ar' ? 'الأسئلة الشائعة' : 'Common Questions' }}</div>
                <h2 class="section-title">{{ $lang === 'ar' ? 'كل ما تريد معرفته' : 'Everything You Want to Know' }}</h2>
            </div>
            <div class="faq-list">
                @foreach($faqs as $faq)
                    <div class="faq-item reveal">
                        <button type="button" class="faq-question" aria-expanded="false">
                            <span>{{ $faq['q'] }}</span>
                            <span class="faq-toggle" aria-hidden="true">+</span>
                        </button>
                        <div class="faq-answer">{{ $faq['a'] }}</div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- FINAL CTA --}}
    <section class="final-cta">
        <div class="final-cta-inner">
            <h2 class="reveal">{{ $lang === 'ar' ? 'خطوتك الأولى تبدأ اليوم' : 'Your First Step Starts Today' }}</h2>
            <p class="reveal">{{ $lang === 'ar' ? 'لا تنتظر اللحظة المثالية. اللحظة المثالية هي الآن.' : 'Don\'t wait for the perfect moment. The perfect moment is now.' }}</p>
            <div class="hero-ctas reveal">
                <a href="{{ $whatsapp }}" target="_blank" rel="noopener noreferrer" class="btn-hero btn-hero-primary">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487 2.981 1.287 2.981.859 3.518.805.537-.054 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347M12.05 21.785h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                    {{ $lang === 'ar' ? 'ابدأ عبر واتساب' : 'Start on WhatsApp' }}
                </a>
                <a href="{{ $calendly }}" target="_blank" rel="noopener noreferrer" class="btn-hero btn-hero-outline">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                    {{ $lang === 'ar' ? 'احضر زووم مجاني' : 'Attend Free Zoom' }}
                </a>
            </div>
        </div>
    </section>

</div>

@push('scripts')
<script>
(function() {
    // FAQ accordion toggle
    document.querySelectorAll('.faq-question').forEach(function(btn) {
        btn.addEventListener('click', function() {
            var item = btn.closest('.faq-item');
            var isOpen = item.classList.contains('open');
            document.querySelectorAll('.faq-item.open').forEach(function(el) {
                el.classList.remove('open');
                el.querySelector('.faq-question').setAttribute('aria-expanded', 'false');
            });
            if (!isOpen) {
                item.classList.add('open');
                btn.setAttribute('aria-expanded', 'true');
            }
        });
    });

    // Scroll reveal via IntersectionObserver
    if ('IntersectionObserver' in window) {
        var observer = new IntersectionObserver(function(entries) {
            entries.forEach(function(entry) {
                if (entry.isIntersecting) {
                    entry.target.classList.add('in-view');
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.12, rootMargin: '0px 0px -60px 0px' });
        document.querySelectorAll('.reveal').forEach(function(el) { observer.observe(el); });
    } else {
        document.querySelectorAll('.reveal').forEach(function(el) { el.classList.add('in-view'); });
    }
})();
</script>
@endpush
@endsection
