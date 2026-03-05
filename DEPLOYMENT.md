# Nexora Tools – Deployment (Hostinger / shared hosting)

## Document root = `public`

- **Point your domain’s document root to the `public` folder** of this project (e.g. `public_html` = path to `nexora-tools/public`).
- Do **not** depend on changing the server document root; the app is built so that **`public/index.php` is the only entry point**.

## What runs from `public/`

- `public/index.php` – front controller (loads `../vendor`, `../bootstrap/app.php`).
- `public/.htaccess` – URL rewriting to `index.php`.
- `public/build/` – Vite-built CSS/JS (from `npm run build`).
- `public/images/` – images (placeholders, banners, etc.).
- `public/storage` – symlink to `storage/app/public` (created by `php artisan storage:link`).

## Hostinger setup

1. Upload the **entire project** (including `app/`, `bootstrap/`, `config/`, `vendor/`, etc.) so that the **document root** is set to the **`public`** directory of the project.
2. In Hostinger: Domain → Document root → set to the folder that contains `index.php` and `.htaccess` (i.e. your `public` folder).
3. Ensure `.env` is present (copy from `.env.example`), set `APP_KEY`, `APP_URL` (your domain), and DB/API keys as needed.
4. Run once on the server (SSH or Hostinger’s “Run script”):
   - `composer install --no-dev --optimize-autoloader`
   - `php artisan storage:link`
   - `php artisan config:cache`
   - `php artisan route:cache`
5. Build assets locally and upload `public/build/` and `public/images/`, or on the server:
   - `npm ci && npm run build`
   - Then upload or keep `public/build/` and `public/images/` in place.

## If document root cannot be changed

If you **must** use a document root that is the **project root** (parent of `public`):

- Use the **root `.htaccess`** in this project: it redirects all requests into `public/`, so `public/index.php` still handles everything.
- Ensure the root `.htaccess` is present and that `mod_rewrite` is enabled.

## Post-deployment commands (Hostinger / production)

From the deployed directory (e.g. `public_html` or `/domains/tripathinexora.com/public_html`):

```bash
composer install --no-dev --optimize-autoloader
php artisan key:generate
php artisan config:cache
php artisan route:cache
```

Optional: `php artisan storage:link` and `php artisan migrate --force` if using DB.

See **HOSTINGER_DEPLOYMENT.md** for full Hostinger Git setup and folder structure.

## Local development

```bash
# From project root
composer install
cp .env.example .env
php artisan key:generate
php artisan storage:link
npm install && npm run build

# Serve (serves from public/)
php artisan serve
```

Then open `http://127.0.0.1:8000`. Assets and images load from `public/build/` and `public/images/`.
