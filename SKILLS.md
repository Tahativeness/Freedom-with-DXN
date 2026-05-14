# Freedom with DXN Project Skills

This file keeps the practical skills for this git clone in one place. Use it when creating or updating SEO pages, blogs, landing pages, product content, and images.

## SEO

- Target one primary keyword per page and support it with related phrases.
- Keep titles under 60 characters when practical.
- Keep meta descriptions under 155 characters when practical.
- Preserve canonical, Open Graph, Twitter Card, and JSON-LD data.
- Use one H1, then clear H2/H3 sections.
- Add internal links to relevant products, blogs, landing pages, `/join`, `/business`, and `/contact`.
- Use careful wellness language and avoid unsupported medical claims.

## Content Creation

- Write for UAE DXN buyers, wellness shoppers, and new distributors.
- Structure content around the reader's problem, helpful education, product or business fit, proof, FAQ, and CTA.
- Create full English and Arabic versions when bilingual content is requested.
- Reuse project CTA links:
  - WhatsApp: `https://wa.me/971555574958`
  - Calendly: `https://calendly.com/freedom-with-dxn2026/welcome-to-freedom-with-dxn`
- Match the reference blog HTML files in `_reference/` for new standalone blog content.

## Image Optimization

- Prefer existing assets in `laravel-server/public/images/products/`.
- Use descriptive filenames for new images.
- Add useful alt text for product, blog, landing, and CTA images.
- Compress large files before production use.
- Preserve aspect ratios to prevent layout shift.
- Use clear product images rather than dark, blurred, or decorative-only visuals.

## Conversion Copy

- Make the first screen immediately clear: offer, audience, and next action.
- Use trust signals such as UAE availability, DXN distributor guidance, reviews, WhatsApp ordering, and free Zoom calls.
- Place CTAs near benefits, order details, FAQs, and page endings.
- Prefer direct button labels such as "Order on WhatsApp", "Join the Team", "Book a Free Zoom", and "View Products".

## Product Research

- Research each DXN product by category, ingredients, target audience, buyer questions, and practical use cases.
- Compare similar products so pages can explain why someone should choose one product over another.
- Identify buyer search terms such as product name, benefit-led phrases, UAE availability, price/order intent, and Arabic equivalents.
- Turn research into content angles for product pages, blogs, FAQs, landing pages, and WhatsApp sales messages.
- Avoid cure claims or guaranteed treatment language.
- Track missing assets or data such as images, ingredients, usage guidance, reviews, pricing, Arabic copy, or landing page opportunities.

## Lead Generation

- Build lead paths around buyer or distributor intent: order, join, book a Zoom call, WhatsApp question, or request guidance.
- Add lead prompts to product pages, landing pages, blogs, `/join`, `/business`, and `/contact`.
- Use lead magnets when helpful: product guide, starter checklist, free DXN business call, WhatsApp consultation, or UAE ordering help.
- Segment leads by interest: product buyer, repeat buyer, business opportunity, Arabic speaker, English speaker, or new distributor.
- Keep forms short and collect only what is needed for follow-up.
- Write clear follow-up copy so every lead has a next step.

## Technical Content

- The active production app is `laravel-server/` Laravel with Blade templates.
- Legacy Node/React files are reference only unless explicitly requested.
- Check `laravel-server/routes/web.php` before adding links.
- Keep content compatible with the admin panel when possible.
- Verify changed pages locally with `cd laravel-server && php artisan serve` when practical.
