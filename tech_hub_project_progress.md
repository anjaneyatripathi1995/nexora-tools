# Nexora Tools – Project Progress & Feature Tracker

Use this file to keep track of project progress, changelog, and future implementations.  
**Related:** Database schema reference → [`techhub_database.sql`](techhub_database.sql)

---

## 📌 Project Overview

**Nexora Tools** is an All-in-One Tech Solution Hub: 42+ free utility tools, projects, templates, AI features, news, and market updates — with a full user/admin portal.

| Layer | Technology |
|-------|------------|
| **Public UI** | Flat PHP (custom router) — the `pages/` design |
| **Auth / Tools / Admin** | Laravel 11 + Blade + Livewire Volt |
| **Asset Bundler** | Vite (`public/build/`) |
| **Database** | MySQL/MariaDB (`techhub`) |
| **Auth system** | Laravel Breeze + Livewire Volt |
| **Hosting** | Shared Hostinger (`tripathinexora.com`) |

---

## 🏗️ Architecture — Hybrid Router

The project uses a **hybrid entry point** (`public/index.php`) that routes:

| URL Pattern | Handler | What renders |
|---|---|---|
| `/`, `/dev`, `/pdf`, `/finance`, `/ai`… | Flat PHP (`pages/`) | Beautiful category pages (tripathinexora.com design) |
| `/tools` | Flat PHP (`pages/tools.php`) | All-tools listing with search & filter tabs |
| `/about`, `/contact`, `/privacy`, `/terms` | Flat PHP | Static info pages |
| `/tools/{slug}` | Laravel `ToolController@show` | Advanced Laravel Blade tool pages |
| `/login`, `/register`, `/logout` | Laravel Volt | Auth pages |
| `/forgot-password`, `/reset-password`… | Laravel Volt | Full password flow |
| `/dashboard` | Laravel `DashboardController` | User portal |
| `/admin/*` | Laravel Admin controllers | Admin panel |
| `/livewire/*` | Laravel Livewire | Livewire AJAX |

**Why hybrid?** The flat PHP design (tripathinexora.com) is the production site's visual identity. Laravel powers all functionality (auth, tools, dashboard, admin) without replacing the front-end.

---

## 📅 Changelog

### Mar 6, 2026 — Hybrid Architecture & Full Compatibility

#### Hybrid Entry Point
- **`public/index.php` rebuilt** as a smart hybrid router:
  - PHP built-in server (`cli-server` / `artisan serve`): no base-path stripping needed.
  - Apache XAMPP: strips `/nexora-tools` base from `SCRIPT_NAME` → correct clean path.
  - Hostinger production: no base path → correct clean path.
- Auth / dashboard / admin / Laravel tool pages dispatched to Laravel.
- Home / category / tools-list pages dispatched to the flat PHP router.

#### Flat PHP Integration
- **`includes/header.php`**: Login and Sign Up buttons now link to real `/login` and `/register` pages.
- **`includes/header.php`** (mega menu + category dropdowns): all tool links changed from `/{slug}` to `/tools/{slug}` → uses Laravel's advanced tool pages.
- **`pages/category.php`**: tool card links updated to `/tools/{slug}`.
- **`pages/tools.php`**: tool card links updated to `/tools/{slug}`.
- **`includes/config.php`**: tool slugs aligned with Laravel DB slugs:
  - `merge-pdf` → `pdf-merger`
  - `ocr-image-to-text` → `ocr`
  - `essay-generator` → `essay-letter-generator`
  - `html-minifier` → `minifier`
  - `ocr-tool` → `image-ocr`
  - `month-to-date` → `month-to-date-converter`

#### Sessions Migration
- Created `database/migrations/2026_03_06_200000_create_sessions_table.php`.
- Has `Schema::hasTable()` guard — safe to run even if the table already exists (XAMPP SQL dump).
- Required for `SESSION_DRIVER=database` on a **fresh Hostinger database**.

#### `bootstrap/app.php` — Cleaned & Smarter
- **Removed** all agent debug logging code (`__agent_ndjson_log`, `AgentDebugMiddleware`).
- **Auto-detect public path**: reads the `PUBLIC_PATH` constant defined in `public/index.php` at boot.
  - XAMPP: `PUBLIC_PATH = .../nexora-tools/public` → Laravel serves assets correctly.
  - Hostinger: `PUBLIC_PATH = /home/user/public_html` → Laravel finds `build/manifest.json` correctly.
  - Explicit `APP_PUBLIC_PATH` in `.env` still takes priority if set.

#### `.htaccess` Updates
- **Root `.htaccess`** (XAMPP only): wrapped in `<IfModule mod_rewrite.c>`, added `tools/{slug}/assets/` passthrough rule.
- **`public/.htaccess`** (Hostinger production): unchanged — standard Laravel rules, correct.

#### `.env` Cleanup
- Removed unused `APP_AGENT_DEBUG` and `APP_PUBLIC_PATH` vars.
- `APP_URL=http://localhost/nexora-tools` (no `/public` — root .htaccess routes to public/index.php).

#### `.env.hostinger.example`
- Created deployment reference file with full step-by-step instructions.
- `APP_PUBLIC_PATH` no longer needed (auto-detected).

---

### Mar 5, 2026 — Auth & Entry Point Fixes

#### `public/index.php`
- **Was**: a custom flat PHP router that bypassed Laravel entirely → all `/login`, `/register`, `/dashboard` returned 404.
- **Fixed**: replaced with standard Laravel entry point (from `old_techhub`).

#### Vite Manifest Fix
- **Was**: `vite.config.js` without `laravel-vite-plugin` → manifest generated at `public/build/.vite/manifest.json`.
- **Fixed**: Updated `vite.config.js` to use `laravel-vite-plugin`; ran `npm run build` → manifest at `public/build/manifest.json`.

#### `public/.htaccess`
- Replaced minimal `.htaccess` with full standard Laravel version (Authorization header, X-XSRF-Token, trailing slash redirect, front controller).

---

### Mar 4, 2026 — Bug Fixes

#### ToolRegistry Interception Fix
- Removed 6 tools from `ToolRegistry` that had working Blade partials (`word-counter`, `pdf-merger`, `image-compressor`, `json-formatter`, `base64-encoder`, `url-encoder`).
- They were showing stub views instead of real implementations.

#### Missing `.env`
- Created `.env` with correct MySQL settings (`DB_DATABASE=techhub`).
- All 20 migrations confirmed run. Admin user `admin@gmail.com` (master admin) ready.

#### Navbar — Login/Sign Up not visible
- Removed `overflow-x: hidden` from `html` element; added `flex-shrink: 0` to nav auth area; removed extra "About" link from main nav.

---

### Feb 27, 2026 — Calculator Redesigns & Async PDF

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

---

### Mar 1, 2026 — JSON Studio & Research

- **JSON Formatter → JSON Studio**: Two-panel layout, Pretty/Tree/Raw, toolbar (Sample, Copy, Paste, Upload, Beautify, Download).
- Tool page wide layout for JSON Formatter (no sidebar).
- Research alignment: roadmap notes for AI Mental Health, Virtual Study Group, News/Market APIs.

---

## 🗺️ Laravel Routes (Full)

| Route | Controller | Auth |
|-------|------------|------|
| `GET /` | HomeController@index | — |
| `GET /tools` | ToolController@index | — |
| `GET /tools/{slug}` | ToolController@show | — |
| `POST /tools/process/zip-compressor` | PdfFileController | — |
| `POST /tools/process/pdf-merger` | PdfFileController | — |
| `POST /tools/process/split-pdf` | PdfFileController | — |
| `POST /tools/process/grammar-check` | ToolController | — |
| `POST /tools/process/background-remover` | ToolController | — |
| `GET /projects`, `/projects/{slug}` | ProjectController | — |
| `GET /apps`, `/apps/{slug}` | AppController | — |
| `GET /templates`, `/templates/{slug}` | TemplateController | — |
| `GET /ai-videos/*` | AIVideoController | — |
| `GET /news` | NewsController@index | — |
| `GET /market` | MarketController@index | — |
| `POST /saved-items/toggle` | SavedItemController | auth |
| `GET /dashboard/*` | DashboardController | auth + verified |
| `GET /profile` | View | auth |
| `GET /admin/*` | Admin\* controllers | auth + role.admin |
| Auth routes | Volt (login, register, forgot, reset, verify, logout) | — |

---

## 🔧 Tool Status

**42+ tools across 7 categories. All route to `/tools/{slug}` via Laravel.**

| Category | Tools |
|----------|-------|
| **Finance & Date** | EMI Calculator ✅, SIP Calculator ✅, FD/RD Calculator ✅, GST Calculator ✅, Age Calculator ✅, Month-to-Date Converter ✅ |
| **PDF & File** | PDF to Word ⏳, PDF to Excel ⏳, PDF to Image ✅, Merge PDF ✅, Split PDF ✅, Compress PDF ✅, Lock/Unlock PDF ⏳, OCR ✅, ZIP Compressor ✅, Image Compressor ✅ |
| **Text & Content** | Word Counter ✅, Case Converter ✅, Paraphraser ⏳, Grammar Checker ✅, Plagiarism Checker ⏳, Resume Builder ✅, Essay/Letter Generator ✅ |
| **Developer** | JSON Formatter ✅, Base64 Encoder ✅, Password Generator ✅, URL Encoder ✅, UUID Generator ✅, Markdown Preview ✅, QR Code Generator ✅, Regex Tester ✅, HTML/CSS/JS Minifier ✅, Temp Mail ⏳ |
| **Image Tools** | Image Resizer ✅, Background Remover ✅, OCR Tool ✅ |
| **SEO Tools** | Meta Tag Generator ✅, Keyword Density Checker ✅, Sitemap Generator ✅ |
| **AI Tools** | AI Text Humanizer ⏳, AI Content Writer ⏳, AI Summarizer ⏳ |

✅ = Implemented with full UI  |  ⏳ = Partial / placeholder / API-dependent

---

## 💼 Projects / Apps / Templates

- **Projects**: 7 items; list + detail; action buttons "Coming Soon".
- **Apps**: 21 items; list + detail; "Coming Soon".
- **Templates**: 4 items; list + detail; "Coming Soon".

---

## 🎉 AI Videos / News / Market

- **AI Videos**: Love Calculator working; Generator, Meme, Caption "Coming Soon".
- **News / Market**: Placeholder UI; ready for NewsAPI / TradingView (or similar).

---

## 🧑‍💻 User & Admin Portal

- **Roles**: `user`, `admin`; `is_master` for master admin; `access_rules` (JSON) per admin section.
- **User portal**: Dashboard (stats, saved items, recent activity), Usages, Analytics; tool usage logged in `tool_histories`.
- **Admin**: Dashboard, Tools CRUD, Admins list (master only); Projects/Apps/Templates admin coming soon.
- **Default admin**: `admin@gmail.com` (master admin) — password in `techhub_database.sql`.

---

## 🗄️ Database

- **Schema dump**: [`techhub_database.sql`](techhub_database.sql) — full MariaDB/MySQL dump.
- **Migrations**: `database/migrations/` — run `php artisan migrate` on fresh install.
- **Key tables**: `users`, `tools`, `tool_histories`, `saved_items`, `sessions`, `cache`, `jobs`, `tool_jobs`, `categories`, `tool_categories`.

---

## 🚀 Hostinger Deployment

See **`.env.hostinger.example`** for full instructions. Quick summary:

```
/home/<user>/
  nexora-tools/       ← all project files (app, bootstrap, vendor, includes, pages…)
    .env              ← copy .env.hostinger.example, fill DB creds
  public_html/        ← contents of local public/ (index.php, .htaccess, assets/, build/, images/)
```

```bash
# On Hostinger SSH after upload:
php artisan key:generate
php artisan migrate
php artisan config:clear && php artisan view:clear
```

---

## 🔜 Suggested Next Steps

- [ ] Lock/Unlock PDF (qpdf CLI or API).
- [ ] PDF to Word / Excel (LibreOffice or API).
- [ ] Temp Mail (disposable mailbox API).
- [ ] AI Text Humanizer / Content Writer / Summarizer (OpenAI or similar API).
- [ ] News section: NewsAPI integration.
- [ ] Market section: TradingView widget or Twelve Data API.
- [ ] Save/Bookmark UI on tool and project pages.
- [ ] Admin CRUD for Projects, Apps, Templates (DB-backed).
- [ ] AI Video / Meme / Caption generator APIs.
- [ ] Queue worker in production (Supervisor / systemd on Hostinger Business plan).
- [ ] Unit & feature tests for tool controllers.

---

*Last updated: Mar 6, 2026*
