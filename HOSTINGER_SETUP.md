# Nexora Tools — Hostinger Shared Hosting Setup

**Project:** Nexora Tools  
**Company:** Tripathi Nexora Technologies  
**Domain:** tripathinexora.com  
**Constraint:** Document root cannot be changed from `public_html`.

---

## 1. Final server structure

The Laravel project must run inside the document root:

```
/domains/tripathinexora.com/public_html/   ← document root (cannot be changed)
    .htaccess
    index.php              ← Laravel front controller (root)
    build/                 ← Vite output (or copy from public/build)
    images/                ← copy from public/images
    app/
    bootstrap/
    config/
    database/
    public/                ← Laravel public folder
    resources/
    routes/
    storage/
    vendor/
    artisan
    composer.json
    .env
    ...
```

- All requests hit `public_html`; root `index.php` bootstraps Laravel.
- Routes work without `/public` in the URL (e.g. `https://tripathinexora.com/tools/json-formatter`).
- Assets: ensure `build/` and `images/` exist at **document root** (same level as `index.php`) so `/build/*` and `/images/*` load. See repo root `index.php` and `bootstrap/app.php` (LARAVEL_PUBLIC_PATH_IS_ROOT).

---

## 2. Ensure index.php works from root

The repo includes a root `index.php` that:

- Defines `LARAVEL_PUBLIC_PATH_IS_ROOT` so Laravel uses the document root as the public path.
- Requires `vendor/autoload.php` and `bootstrap/app.php` from the project root.

No server config change is required; deployment path must be `public_html` (the folder that contains this `index.php`).

---

## 3. Deployment steps

On the server (e.g. SSH or Hostinger File Manager), from the project root (`public_html`):

```bash
cd /domains/tripathinexora.com/public_html

# Dependencies
composer install --no-dev --optimize-autoloader

# Environment
cp .env.example .env
php artisan key:generate

# .env production values
# APP_ENV=production
# APP_DEBUG=false
# APP_URL=https://tripathinexora.com
# DB_* = your MySQL credentials

# Database
php artisan migrate --force
php artisan db:seed --force

# Cache
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Optional: storage link
php artisan storage:link
```

If you build frontend assets on the server:

```bash
npm ci
npm run build
# Then copy public/build and public/images to document root (build/ and images/)
cp -r public/build ./
cp -r public/images ./
```

If you build locally, upload `public/build` and `public/images` to `public_html/build` and `public_html/images`.

---

## 4. Git setup (initial)

```bash
git init
git add .
git commit -m "Nexora Tools — scalable SaaS architecture"
git branch -M main
git remote add origin https://github.com/anjaneyatripathi1995/nexora-tools.git
git push -u origin main
```

---

## 5. .gitignore (Laravel)

Ensure these are ignored:

- `vendor/`
- `node_modules/`
- `.env`
- `storage/*.key`
- `public/build`

---

## 6. Summary

| Item        | Value |
|------------|--------|
| Document root | `public_html` (unchanged) |
| Entry point   | `public_html/index.php` |
| Asset URLs    | `/build/*`, `/images/*` from document root |
| Repo          | https://github.com/anjaneyatripathi1995/nexora-tools.git |
