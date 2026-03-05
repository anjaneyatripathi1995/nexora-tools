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
    .htaccess              ← root rewrite to public/
    .env                   ← create on server (not in Git)
    app/
    bootstrap/
    config/
    database/
    public/
        .htaccess
        index.php
        build/              ← run npm run build or upload
        images/
        storage → ../storage/app/public (symlink)
    resources/
    routes/
    storage/
    vendor/                 ← created by composer install
    artisan
    composer.json
    package.json
    ...
```

- **Document root** stays `public_html`. All requests are rewritten to `public/` by the root `.htaccess`.
- **Assets:** `/build/*` and `/images/*` are served from `public/build/` and `public/images/` via the same rewrite.

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

If you build locally, commit `public/build/` or upload it after deploy so you can skip `npm` on the server.

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

- Root `.htaccess` sends all requests into `public/`. So:
  - `https://tripathinexora.com/` → `public/index.php`
  - `https://tripathinexora.com/build/assets/app-xxx.js` → `public/build/assets/app-xxx.js`
  - `https://tripathinexora.com/images/placeholder.svg` → `public/images/placeholder.svg`
- Set `APP_URL=https://tripathinexora.com` in `.env` so `asset()` and `@vite` use the correct domain. No document root change is required.

---

## 7. Summary

| Item | Value |
|------|--------|
| Repo | https://github.com/anjaneyatripathi1995/nexora-tools.git |
| Branch | main |
| Deploy path | /domains/tripathinexora.com/public_html |
| Document root | public_html (unchanged) |
| Post-deploy | composer install, key:generate, config:cache, route:cache |
