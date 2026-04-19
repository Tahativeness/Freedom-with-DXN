<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ganozhi Lipstick - Pearly Pink | DXN</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css'])
    <style>
        :root {
            --dark-green: #0f3f2b;
            --deep-green: #064f3a;
            --light-green: #eaf5ef;
            --accent: #e94f1f;
            --accent2: #f48f33;
            --text: #1f2f2a;
            --muted: #556b64;
            --white: #fff;
            --border: #dbe5de;
            --shadow: 0 8px 20px rgba(0,0,0,.15);
        }
        body { margin:0; font-family:'Inter', sans-serif; background:#fff; color:#1b2f29; line-height:1.6; }
        a { color: var(--accent); text-decoration: none; }
        section { padding: 70px 20px; }
        .container { max-width: 1200px; margin: 0 auto; }
        .button { display: inline-flex; align-items: center; justify-content:center; padding: 14px 24px; border-radius: 32px; border:0; cursor:pointer; font-weight:700; background: linear-gradient(120deg, var(--accent), var(--accent2)); color:#fff; box-shadow: 0 8px 20px rgba(0,0,0,.2); }
        .hero {
            min-height: 95vh;
            color: #f8fff9;
            background: linear-gradient(rgba(9,31,20,.72), rgba(0,0,0,.62)), url('https://picsum.photos/id/1032/1600/900') center/cover no-repeat;
            display:flex; align-items:center; justify-content:center; text-align:center; padding: 80px 20px;
        }
        .hero h1 { font-size:clamp(2.2rem, 6vw, 4.2rem); margin:0 0 16px; line-height:1.1; }
        .hero p { font-size:clamp(1.05rem, 2.2vw, 1.6rem); color:#e7f1e9; margin-bottom:24px; }
    </style>
</head>
<body>
    <section class="hero">
        <div class="container">
            <h1>Ganozhi Lipstick — Pearly Pink</h1>
            <p>Infused with Ganoderma extract for natural, moisturised lips with a beautiful pearly finish.</p>
            <a href="https://wa.me/message/EFSQ2IDNVG3YB1" class="button" target="_blank">Order Now via WhatsApp</a>
            <p style="margin-top:16px"><a href="{{ route('products') }}" style="color:#e7f1e9; text-decoration:underline;">← Back to all products</a></p>
        </div>
    </section>
</body>
</html>
