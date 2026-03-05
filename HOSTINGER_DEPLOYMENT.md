# Hostinger Git Deployment – Nexora Tools (Laravel)

## Server assumptions

- **Domain:** tripathinexora.com  
- **Deploy path:** `/domains/tripathinexora.com/public_html`  
- **Document root:** `public_html` (no change – Laravel runs with project root = `public_html`)

---

## 1. GitHub repository

- **URL:** https://github.com/anjaneyatripathi1995/nexora-tools.git  
- **Default branch:** `main`

---

## 2. Folder structure on Hostinger (after Git deploy)

The repo is deployed **inside** `public_html`. Document root stays `public_html`. Root `index.php` sets `LARAVEL_PUBLIC_PATH_IS_ROOT` so Laravel uses the document root as the public path — no `.htaccess` rewrite needed for assets.

```
public_html/                  ← document root (unchanged)
    .htaccess                 ← sends all requests to index.php (no /public in URL)
    .env                      ← create on server (not in Git)
    index.php                 ← root Laravel front controller (sets public path = here)
    build/                    ← Vite output: manifest.json + assets/ (app-*.js, app-*.css)
    images/                   ← images for asset('images/...')
    app/
    bootstrap/
    config/
    database/
    public/                   ← used only when running via public/index.php (local dev)
    resources/
    routes/
    storage/
    vendor/                   ← created by composer install
    artisan
    composer.json
    package.json
    ...
```

- **Routes:** All requests go to root `index.php`, so URLs work without `/public`.
- **Assets:** `https://tripathinexora.com/build/assets/...` and `https://tripathinexora.com/images/...` are served directly from `public_html/build/` and `public_html/images/` (same level as `index.php`). No copy step and no `APP_PUBLIC_PATH` — root `build/` and `images/` are in the repo.

---

## 3. Hostinger Git Auto Deployment

1. In **Hostinger hPanel:** Domain → **Advanced** → **Git** (or **Git Deployment**).
2. **Connect repository:**
   - Repository URL: `https://github.com/anjaneyatripathi1995/nexora-tools.git`
   - Branch: `main`
   - Deploy path: `/domains/tripathinexora.com/public_html`
3. Enable **Auto Deployment** so each push to `main` deploys to `public_html`.
4. First time: use **Deploy** to pull the repo into `public_html`.

---

## 4. Post-deployment commands (run once per deploy)

Run these **on the server** (SSH or Hostinger’s “Run script” / terminal) from the deploy path (e.g. `public_html` or `/domains/tripathinexora.com/public_html`):

```bash
cd /domains/tripathinexora.com/public_html

composer install --no-dev --optimize-autoloader
php artisan key:generate
php artisan config:cache
php artisan route:cache
```

**If you build assets on the server**, copy them to the document root so `/build` and `/images` work:

```bash
npm ci
npm run build
cp -r public/build ./build
cp -r public/images ./images
```

Normally the repo already includes root `build/` and `images/`. After changing frontend assets locally, run `npm run build:hostinger` to build and sync `public/build` and `public/images` to root, then commit and push so Hostinger gets the updated assets.

---

## 5. First-time server setup

1. **Create `.env`** (copy from `.env.example` and edit):
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```
2. Set in `.env`:
   - `APP_ENV=production`
   - `APP_DEBUG=false`
   - `APP_URL=https://tripathinexora.com`
   - `DB_*` for your database
3. **Storage link:**
   ```bash
   php artisan storage:link
   ```
4. **Migrations** (if using DB):
   ```bash
   php artisan migrate --force
   ```
5. **Cache:**
   ```bash
   php artisan config:cache
   php artisan route:cache
   ```

---

## 6. Assets without changing document root

Root `index.php` defines `LARAVEL_PUBLIC_PATH_IS_ROOT`, so Laravel uses the document root as the public path. Assets are under that root:

- `https://tripathinexora.com/` → `public_html/index.php`
- `https://tripathinexora.com/build/assets/app-xxx.js` → `public_html/build/assets/app-xxx.js`
- `https://tripathinexora.com/images/...` → `public_html/images/...`

**In `.env` set:**

- `APP_URL=https://tripathinexora.com`

Do **not** set `APP_PUBLIC_PATH`. The root entry point sets the public path automatically.

---

## 7. Summary

| Item | Value |
|------|--------|
| Repo | https://github.com/anjaneyatripathi1995/nexora-tools.git |
| Branch | main |
| Deploy path | /domains/tripathinexora.com/public_html |
| Document root | public_html (unchanged) |
| Post-deploy | composer install, key:generate, config:cache, route:cache |
