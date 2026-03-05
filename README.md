# Nexora Tools (TechHub)

Laravel-based all-in-one tech solution hub: utilities, projects, templates, AI videos, and market updates.

## Stack

- **Laravel 12**
- **Livewire + Volt** (auth, profile)
- **Vite** (CSS/JS build)
- **Bootstrap** (frontend)

## Project structure (standard Laravel)

```
app/
bootstrap/
config/
database/
public/          ← document root (index.php, .htaccess, build/, images/)
resources/
  views/          ← Blade templates
routes/
  web.php         ← web routes (+ auth via auth.php)
storage/
vendor/
```

## Local run

```bash
composer install
cp .env.example .env
php artisan key:generate
php artisan storage:link
npm install && npm run build
php artisan serve
```

Open **http://127.0.0.1:8000**.

## Routes and controllers

- **Home:** `GET /` → `HomeController@index`
- **Tools:** `GET /tools`, `GET /tools/{slug}` → `ToolController`; process routes → `PdfFileController` / `ToolController`
- **Projects, Apps, Templates, AI Videos, News, Market** → respective controllers
- **Auth:** login, register, password reset, verification (Livewire Volt)
- **Dashboard / Admin** → `DashboardController`, `Admin\*` (auth + role middleware)

## Deployment (Hostinger / shared hosting)

See **[DEPLOYMENT.md](DEPLOYMENT.md)**. Summary:

- Set **document root to the `public` folder** so `public/index.php` is the entry point.
- No dependency on changing server document root: deploy `public/` as your web root (e.g. `public_html`).
- Assets: run `npm run build` and deploy `public/build/` and `public/images/`.

## Cleanup (optional)

After confirming the app works, you can remove the backup of the old structure:

- `_old_app/` – previous Laravel app folder (kept for reference during migration).

## License

MIT.
