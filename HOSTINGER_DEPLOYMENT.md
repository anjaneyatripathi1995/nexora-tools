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

The repo is deployed **inside** `public_html`, so you get:

```
public_html/
    .htaccess              ← rewrites to index.php + /build|/images → public/build, public/images
    .env                   ← create on server (not in Git)
    index.php              ← root Laravel front controller
    app/
    bootstrap/
    config/
    database/
    public/                ← Laravel public folder (Vite build + images live here)
        build/             ← manifest.json + assets (app-*.js, app-*.css)
        images/
    resources/
    routes/
    storage/
    vendor/                 ← created by composer install
    artisan
    composer.json
    package.json
    ...
```

- **Document root** stays `public_html`. The root `.htaccess` sends all requests to **root `index.php`** (routes work without `/public`).
- **Assets:** Requests to `/build/*` and `/images/*` are rewritten to **`public/build/*`** and **`public/images/*`** so CSS/JS and images load without 404s. No copy step and no `APP_PUBLIC_PATH` needed.

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

**Optional (if you build assets on the server):**

```bash
npm ci
npm run build
```

Built assets stay in `public/build/` and `public/images/`. The root `.htaccess` serves them at `/build/*` and `/images/*` via rewrite, so no copy step is required.

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

The root `.htaccess` rewrites asset URLs so files in `public/` are served correctly:

- `https://tripathinexora.com/` → `public_html/index.php`
- `https://tripathinexora.com/build/assets/app-xxx.js` → rewritten to `public_html/public/build/assets/app-xxx.js`
- `https://tripathinexora.com/images/...` → rewritten to `public_html/public/images/...`

**In `.env` set only:**

- `APP_URL=https://tripathinexora.com`

Do **not** set `APP_PUBLIC_PATH`; Laravel’s default public path (`public/`) is used, and the rewrite rules above make assets load correctly.

---

## 7. Summary

| Item | Value |
|------|--------|
| Repo | https://github.com/anjaneyatripathi1995/nexora-tools.git |
| Branch | main |
| Deploy path | /domains/tripathinexora.com/public_html |
| Document root | public_html (unchanged) |
| Post-deploy | composer install, key:generate, config:cache, route:cache |
