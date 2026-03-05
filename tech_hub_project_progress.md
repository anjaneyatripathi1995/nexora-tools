# TechHub – Project Progress & Feature Implementation Tracker

Use this file to keep track of project progress, changelog, and future implementations.  
**Related:** Database schema reference → [`techhub_database.sql`](techhub_database.sql)

---

## 📌 Project Overview

TechHub (Nexora Tools) is a Laravel-based All-in-One Tech Solution Hub: utility tools, project solutions, templates, AI videos, news, and market updates.

| Layer | Technology |
|-------|------------|
| **Backend** | Laravel (PHP) |
| **Frontend** | Blade, Bootstrap 5, HTML, CSS, JavaScript |
| **Asset Bundler** | Vite |
| **Database** | MySQL/MariaDB (production), SQLite (dev) |
| **Auth** | Laravel Breeze + Livewire Volt |

---

## 📅 Changelog

### Mar 4–5, 2026 — Laravel Rebuild (Standard Structure)

- **Standard Laravel structure** at project root: `app/`, `bootstrap/`, `config/`, `database/`, `public/`, `resources/`, `routes/`, `storage/`, `vendor/`.
- **Document root = `public/`**: `public/index.php` is the only entry point (Hostinger: point document root to `public` or upload `public/*` to `public_html`).
- **Homepage route**: `GET /` → `HomeController@index` (Blade `home`).
- **Assets**: CSS/JS built with Vite → `public/build/`; images in `public/images/`.
- **Deployment**: See `DEPLOYMENT.md` for Hostinger/shared hosting.
- **Local run**: `php artisan serve` (serves from `public/`).

### Feb 27, 2026

#### Calculator Redesigns
- **EMI Calculator**: Interactive sliders + Chart.js horizontal bar chart.
- **SIP Calculator**: Shared calculator style (sliders + Chart.js).
- **FD/RD Calculator**: Rebuilt with FD/RD tabs, sliders, Chart.js, formatted currency.
- **Shared styles**: `calculator-shared-styles.blade.php` for Finance calculators.

#### Async PDF Job Architecture
- `tool_jobs` table; `ToolJob` model; `ProcessToolJob` job (merge, split, compress, pdf-to-image).
- PDF Merger, Split PDF, Compress PDF, PDF to Image: AJAX submit → job → poll → download.

#### API
- `POST /api/tools/{slug}` — create tool job.
- `GET /api/jobs/{id}` — poll job status.

#### Master Admin
- `is_master` on `users`; `EnsureMasterAdmin` middleware; `Admin\AdminUserController` (list/create admins).

#### New Tool Partials
- `background-remover.blade.php` (remove.bg API).
- `image-resizer.blade.php` (client-side canvas).

#### Homepage & UI
- Hero with overlay, glassmorphism badge, Ken Burns, stats bar, scroll-reveal, shared sub-page banners.

### Mar 1, 2026

- **JSON Formatter → JSON Studio**: Two-panel layout, Pretty/Tree/Raw, toolbar (Sample, Copy, Paste, Upload, Beautify, Download).
- Tool page wide layout for JSON Formatter (no sidebar).
- Research alignment: roadmap notes for AI Mental Health, Virtual Study Group, News/Market APIs.

---

## 🗺️ Site Map & Routes

| Route | Controller | Description |
|-------|-------------|-------------|
| `GET /` | HomeController@index | Homepage |
| `GET /tools` | ToolController@index | Tools listing |
| `GET /tools/{slug}` | ToolController@show | Tool detail |
| `POST /tools/process/*` | PdfFileController / ToolController | ZIP, PDF merge/split, grammar, background-remover |
| `GET /projects`, `/projects/{slug}` | ProjectController | Projects list & detail |
| `GET /apps`, `/apps/{slug}` | AppController | Apps list & detail |
| `GET /templates`, `/templates/{slug}` | TemplateController | Templates list & detail |
| `GET /ai-videos/*` | AIVideoController | AI Videos index, generator, meme, love calc, caption |
| `GET /news` | NewsController@index | News |
| `GET /market` | MarketController@index | Market |
| `GET /dashboard`, `/dashboard/usages`, `/dashboard/analytics` | DashboardController | User portal (auth) |
| `GET /profile` | View | Profile (auth) |
| `GET/POST/PUT/DELETE /admin/*` | Admin\* | Admin dashboard, tools CRUD, admins (master) |
| Auth | auth.php (Volt) | Login, Register, Forgot/Reset, Verify, Logout |

---

## 🔧 Utility Tools — Status

- **Catalog**: `ToolController::fullCatalog()` — 5 categories, 35+ tools.
- **Implemented partials**: `ToolController::implementedSlugs()`; each has `resources/views/tools/partials/{slug}.blade.php`.
- **Working**: Finance (EMI, SIP, FD/RD, GST, Age, Month-to-Date), PDF/File (merge, split, compress, pdf-to-image, zip, image compressor, OCR), Text (word counter, case, paraphraser, grammar, plagiarism, resume, essay), Developer (JSON Studio, QR, regex, base64, URL, minifier), Image (resizer, background-remover, image-ocr).

---

## 💼 Projects / Apps / Templates

- **Projects**: 7 items; list + detail; action buttons “Coming Soon”.
- **Apps**: 21 items; list + detail; “Coming Soon”.
- **Templates**: 4 items; list + detail; “Coming Soon”.

---

## 🎉 AI Videos / News / Market

- **AI Videos**: Love Calculator working; Generator, Meme, Caption “Coming Soon”.
- **News / Market**: Placeholder UI; ready for NewsAPI / TradingView (or similar).

---

## 🧑‍💻 User & Admin

- **Roles**: `user`, `admin`; `is_master` for master admin; `access_rules` (JSON) for admin section access.
- **User portal**: Dashboard (stats, saved, recent activity), Usages, Analytics; tool usage logged in `tool_histories`.
- **Admin**: Dashboard, Tools CRUD, Admins (master only); Projects/Apps/Templates admin “coming soon”.

---

## 🗄️ Database Reference

- **Schema dump**: [`techhub_database.sql`](techhub_database.sql) — full MariaDB/MySQL dump (create DB, tables, seed data for tools + default admin).
- **Laravel migrations**: `database/migrations/` — run `php artisan migrate` for a fresh install; use the SQL file for reference or manual import.

---

## 🚀 Suggested Next Steps

- [ ] Lock/Unlock PDF (qpdf); PDF to Word/Excel (LibreOffice or API).
- [ ] Search/filter on `/tools`.
- [ ] News: NewsAPI (or similar) integration.
- [ ] Market: TradingView (or similar) widgets.
- [ ] Save/Bookmark UI on tool and project pages.
- [ ] AI Content Center (save AI outputs per user).
- [ ] Admin CRUD for Projects, Apps, Templates (DB-backed).
- [ ] AI Video / Meme / Caption APIs.
- [ ] Queue worker in production (Supervisor/systemd).

---

*Last updated: Mar 5, 2026*
