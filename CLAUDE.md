# Grow with DXN — Freedom with DXN

DXN product e-commerce website with admin panel, blog, and distributor network features.

## Tech Stack

- **Backend (active):** Laravel / PHP / MySQL — `laravel-server/`
- **Frontend:** Blade templates with Tailwind CSS (served by Laravel)
- **Auth:** Laravel built-in auth with JWT
- **Database:** MySQL on cPanel
- **Legacy (not used):** `client/` (React) and `server/` (Node.js/Express) — kept for reference only

## Project Structure

```
laravel-server/       # Active Laravel backend + frontend
  app/                # Models, Controllers, Middleware
  resources/views/    # Blade templates (layouts, pages, components, partials)
  routes/web.php      # All web routes
  routes/api.php      # API routes
  public/             # Public assets, .htaccess
server/               # Legacy Node.js backend (not active)
client/               # Legacy React frontend (not active)
```

## Production

- **URL:** https://freedomwithdxn.com
- **Hosting:** cPanel (shared hosting)
- **App path on server:** `/home/freedomw/public_html`
- **PHP version:** Managed via cPanel
- **Database:** MySQL on cPanel
- **Deploy:**
  ```bash
  # In cPanel Terminal:
  cd ~/public_html && git pull origin main
  ```
  PHP/Blade changes take effect immediately after `git pull` — no restart needed.

## Routes

Public routes (defined in `routes/web.php`):
- `/` — Homepage
- `/products` — Product catalog
- `/products/{product}` — Product detail page
- `/blog` — Blog index
- `/blog/{blog}` — Blog post
- `/about` — About DXN
- `/business` — Business opportunity
- `/join` — Join DXN team
- `/contact` — Contact page
- `/landing/{slug}` — Dynamic landing pages
- `/admin` — Admin panel (auth required)

## Key Product Fields

Products have `landing_image` and `landingPage` fields. When `landingPage` is set on a product, clicking the ProductCard links to that landing page URL instead of the default product detail page.

## Admin Access

- Admin route: `/admin`
- Login: `/login`

## Commands

```bash
# Local development
cd laravel-server && php artisan serve    # Backend on :8000

# Production deploy (in cPanel Terminal)
cd ~/public_html && git pull origin main
# No restart needed — PHP changes are instant
```

## /new-blog Command

When the user types `/new-blog`:
1. Ask: "Do you have a topic in mind, or should I choose one?"
2. Wait for their answer before proceeding
3. If they give a topic → use it (title, keyword, excerpt they provide, or derive from the topic)
4. If they want me to choose → pick the next category in rotation (Health → Business → Products → Success Stories → Tips → repeat) and propose a specific title + keyword + excerpt for their approval
5. Once topic is confirmed → generate two full standalone HTML files:
   - `_reference/blog-english-{N}.html` — English version (~1200 words)
   - `_reference/blog-ar-{N}.html` — Arabic RTL version (same content fully translated)
6. After generating, output a summary card:
   - Blog number, category emoji + name, title, keyword, excerpt
   - Admin instructions: category slug, paste each file into the Full HTML Page field

**Blog HTML design rules:**
- Copy exact CSS variables, hero structure, and component styles from the most recent reference file
- Hero height: fixed px only — NEVER use vh units (iframe constraint)
- English grid: `grid-template-columns: 1fr 320px`
- Arabic grid: `grid-template-columns: 320px 1fr` + `.sidebar { order: -1; }` in base CSS
- WhatsApp link: `https://wa.me/971555574958`
- Calendly link: `https://calendly.com/freedom-with-dxn2026/welcome-to-freedom-with-dxn`
- Arabic: `lang="ar" dir="rtl"`, border-right not border-left, `faq-q::before: 'س'`, TOC arrow `←`

## Notes

- The site supports English and Arabic (language toggle in navbar)
- Product categories: coffee, ganoderma, supplements, skincare, beverages, personal-care, other
- WhatsApp ordering via `https://wa.me/971555574958`
- Landing pages (e.g., `index-ganozhi-lipstick.html`) are standalone HTML pages for specific products
- SEO: Open Graph, Twitter Cards, canonical URLs, and JSON-LD structured data are implemented in the layout

## Project Skills

Use these project skills when creating or editing pages, products, landing pages, and blogs for this clone.

### SEO Skill

- Write every page around one clear primary keyword and 2-5 related support keywords.
- Keep titles specific, benefit-led, and under 60 characters when possible.
- Keep meta descriptions useful, click-focused, and under 155 characters when possible.
- Add or preserve canonical URLs, Open Graph tags, Twitter Card tags, and JSON-LD structured data.
- Use one clear H1 per page, then logical H2/H3 sections that match search intent.
- Add internal links between products, blogs, landing pages, `/join`, `/business`, and `/contact`.
- For English/Arabic pages, preserve language attributes and direction: English `lang="en"`, Arabic `lang="ar" dir="rtl"`.
- Avoid unsupported medical claims. Use careful wellness language and encourage users to verify product suitability.

### Content Creation Skill

- Match the audience: UAE-based DXN buyers, new distributors, wellness shoppers, and people exploring part-time income.
- Use a practical structure: problem, helpful context, product or business fit, trust signals, FAQ, and CTA.
- Create bilingual content when requested: English first, Arabic as a full translation, not a short summary.
- Keep CTAs natural and conversion-focused: WhatsApp, Calendly, product page, join page, or contact page.
- Reuse project links:
  - WhatsApp: `https://wa.me/971555574958`
  - Calendly: `https://calendly.com/freedom-with-dxn2026/welcome-to-freedom-with-dxn`
- For blog content, follow the existing reference HTML style in `_reference/blog-english-{N}.html` and `_reference/blog-ar-{N}.html`.
- Include FAQs that answer real buyer or distributor objections.

### Image Optimization Skill

- Prefer existing product images from `laravel-server/public/images/products/` before adding new assets.
- Use descriptive filenames when adding new images: product name, page purpose, and language if relevant.
- Add meaningful `alt` text for all product, blog, landing, and CTA images.
- Keep images visually inspectable: avoid dark, blurred, cropped, or overly decorative product media.
- Compress large images before production use and prefer modern formats when browser support is safe.
- Preserve aspect ratios in Blade/CSS so product cards, blog images, and landing sections do not shift layout.
- Use poster images for videos and avoid loading heavy media above the fold unless it is essential.

### Conversion Copy Skill

- Make the first screen answer what the page is about, who it is for, and what action to take.
- Use trust-building details: UAE availability, DXN distributor guidance, WhatsApp ordering, reviews, and clear next steps.
- Put primary CTAs near product benefits, pricing/order context, FAQs, and page endings.
- Keep buttons action-oriented: "Order on WhatsApp", "Join the Team", "Book a Free Zoom", "View Products".

### Product Research Skill

- Research each DXN product by category, ingredients, target audience, common buyer questions, and practical use cases.
- Compare similar products on the site so pages explain why a buyer might choose one product over another.
- Identify search terms buyers may use: product name, benefit-led phrase, UAE availability, price/order intent, and Arabic equivalents.
- Capture content angles for product pages, blogs, FAQs, landing pages, and WhatsApp sales messages.
- Keep claims careful and evidence-aware. Do not present wellness products as cures or guaranteed treatments.
- Note missing assets or data: images, ingredients, usage guidance, reviews, pricing, Arabic copy, or landing page opportunities.

### Lead Generation Skill

- Build lead paths around clear intent: buy a product, join the DXN business, book a Zoom call, ask on WhatsApp, or request guidance.
- Place lead capture prompts on high-intent pages such as product details, landing pages, blogs, `/join`, `/business`, and `/contact`.
- Create lead magnets when useful: product guide, starter checklist, free DXN business call, WhatsApp consultation, or UAE ordering help.
- Segment leads by interest: product buyer, repeat buyer, business opportunity, Arabic speaker, English speaker, or new distributor.
- Keep forms short and action-focused; collect only what is needed for follow-up.
- Use clear follow-up copy for WhatsApp, email, and admin notes so each lead has an obvious next step.

### Technical Content Skill

- Active app is Laravel in `laravel-server/`; do not treat legacy Node/React as production unless explicitly asked.
- Prefer Blade templates and existing Tailwind/CSS patterns for frontend changes.
- Check routes in `laravel-server/routes/web.php` before adding links.
- Keep public content editable through existing admin flows when possible.
- Verify changed pages locally with `cd laravel-server && php artisan serve` when practical.
