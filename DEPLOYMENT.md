# Nexora Tools – Deployment (Hostinger / shared hosting)

## Shared hosting (Hostinger) – document root stays `public_html`

This project supports **shared hosting** where **document root cannot be changed** and must remain `public_html`.

In that mode:

- `public_html/index.php` is the entry point (loads `vendor/` + `bootstrap/app.php` from the same folder).
- `public_html/.htaccess` rewrites all non-file/non-dir requests to `index.php` (routes work without `/public`).
- Vite assets live at `public_html/build/*` (manifest + assets).
- Images live at `public_html/images/*`.

## Hostinger setup (Git deploy to `public_html`)

1. Deploy the repo into `/domains/tripathinexora.com/public_html`.
2. Create `.env` in `public_html` and set:
   - `APP_URL=https://tripathinexora.com`
   - `APP_PUBLIC_PATH=/domains/tripathinexora.com/public_html`
   - `DB_*` for your MySQL database
3. Build assets (locally or on server) and ensure they exist in web root:
   - `public/build` → `build`
   - `public/images` → `images`

See **HOSTINGER_DEPLOYMENT.md** for the full checklist.

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
