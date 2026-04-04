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

## Notes

- The site supports English and Arabic (language toggle in navbar)
- Product categories: coffee, ganoderma, supplements, skincare, beverages, personal-care, other
- WhatsApp ordering via `https://wa.me/message/EFSQ2IDNVG3YB1`
- Landing pages (e.g., `index-ganozhi-lipstick.html`) are standalone HTML pages for specific products
- SEO: Open Graph, Twitter Cards, canonical URLs, and JSON-LD structured data are implemented in the layout
