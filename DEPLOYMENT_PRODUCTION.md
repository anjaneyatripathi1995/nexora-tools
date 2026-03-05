# Nexora Tools — Production Deployment (Hostinger)

**Project:** Nexora Tools  
**Company:** Tripathi Nexora Technologies  
**Domain:** tripathinexora.com  
**Deploy path:** `/domains/tripathinexora.com/public_html`

## Constraints

- Document root cannot be changed (public_html).
- Laravel runs from project root; root `index.php` is the front controller.
- Assets are served from `/build` and `/images` at document root (see HOSTINGER_DEPLOYMENT.md).

## Production deployment commands

Run these on the server (SSH or Hostinger terminal) from the project root (e.g. `public_html`):

```bash
cd /domains/tripathinexora.com/public_html

# Install dependencies
composer install --no-dev --optimize-autoloader

# Environment
cp .env.example .env
php artisan key:generate

# Configure .env for production
# APP_ENV=production
# APP_DEBUG=false
# APP_URL=https://tripathinexora.com
# DB_* for your database

# Database
php artisan migrate --force

# Seed categories and tools (optional, for fresh install)
php artisan db:seed --force

# Cache
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Storage link (if using file storage)
php artisan storage:link
```

## Git setup (initial)

```bash
git init
git add .
git commit -m "Nexora Tools Initial SaaS Architecture"
git branch -M main
git remote add origin https://github.com/anjaneyatripathi1995/nexora-tools.git
git push -u origin main
```

## .gitignore (already in repo)

- `/vendor`
- `/node_modules`
- `.env`
- `storage/*.key`

## After code changes

```bash
git pull origin main
composer install --no-dev --optimize-autoloader
php artisan migrate --force
php artisan config:cache
php artisan route:cache
```

For frontend asset changes, run `npm run build` (or `npm run build:hostinger`) and ensure `build/` and `images/` are at document root as per HOSTINGER_DEPLOYMENT.md.
