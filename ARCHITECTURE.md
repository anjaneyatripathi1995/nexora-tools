# Nexora Tools — Scalable SaaS Architecture

**Project:** Nexora Tools  
**Company:** Tripathi Nexora Technologies  
**Domain:** tripathinexora.com  
**Goal:** Multi-tool SaaS platform supporting 100+ tools.  
**Stack:** Laravel, Blade, MySQL, simple CSS/JS.  
**Deployment:** Hostinger Shared Hosting (document root = `public_html`).

---

## 1. Complete folder structure

```
nexora-tools/
├── app/
│   ├── Http/Controllers/
│   │   ├── HomeController.php
│   │   ├── ToolController.php          # Dynamic /tools/{slug} + catalog
│   │   ├── PdfFileController.php
│   │   └── ...
│   ├── Models/
│   │   ├── Tool.php
│   │   ├── Category.php
│   │   ├── ToolUsageStat.php
│   │   └── ...
│   └── Tools/                          # Modular tool architecture
│       ├── BaseToolController.php
│       ├── BaseToolService.php
│       ├── ToolRegistry.php
│       ├── TempMail/
│       │   ├── TempMailController.php
│       │   └── TempMailService.php
│       ├── JsonFormatter/
│       ├── Base64Encoder/
│       ├── PasswordGenerator/
│       ├── WordCounter/
│       ├── ImageCompressor/
│       ├── PdfMerger/
│       ├── UrlEncoder/
│       ├── UuidGenerator/
│       └── MarkdownPreview/
├── bootstrap/
├── config/
├── database/
│   ├── migrations/
│   │   ├── 2026_02_21_140803_create_tools_table.php
│   │   ├── 2026_03_05_100000_create_categories_table.php
│   │   ├── 2026_03_05_100001_add_category_id_to_tools_table.php
│   │   ├── 2026_03_05_100002_create_tool_category_pivot_table.php
│   │   ├── 2026_03_05_100003_create_tool_usage_stats_table.php
│   │   └── 2026_03_06_100000_add_status_to_tools_table.php
│   └── seeders/
│       ├── CategorySeeder.php
│       └── ToolSeeder.php
├── public/
│   ├── assets/
│   │   ├── css/
│   │   ├── js/
│   │   └── images/
│   ├── index.php
│   └── ...
├── resources/
│   ├── views/
│   │   ├── layouts/
│   │   │   ├── app.blade.php
│   │   │   ├── header.blade.php
│   │   │   └── footer.blade.php
│   │   ├── tools/
│   │   │   ├── layout.blade.php
│   │   │   ├── index.blade.php
│   │   │   ├── show.blade.php
│   │   │   ├── show-coming-soon.blade.php
│   │   │   ├── temp_mail/index.blade.php
│   │   │   ├── json_formatter/index.blade.php
│   │   │   ├── base64_encoder/index.blade.php
│   │   │   ├── password_generator/index.blade.php
│   │   │   ├── word_counter/index.blade.php
│   │   │   ├── image_compressor/index.blade.php
│   │   │   ├── pdf_merger/index.blade.php
│   │   │   ├── url_encoder/index.blade.php
│   │   │   ├── uuid_generator/index.blade.php
│   │   │   ├── markdown_preview/index.blade.php
│   │   │   └── partials/              # Legacy tool partials
│   │   ├── home.blade.php
│   │   └── partials/
│   │       ├── navbar.blade.php
│   │       └── footer.blade.php
│   └── css/
├── routes/
│   ├── web.php
│   └── auth.php
├── storage/
├── vendor/
├── .env.example
├── .gitignore
├── index.php                           # Root entry for Hostinger (public_html)
├── HOSTINGER_SETUP.md
└── ARCHITECTURE.md
```

---

## 2. Controllers

### ToolController (`app/Http/Controllers/ToolController.php`)

- **Role:** Single entry for all tools. Loads tool views dynamically for `/tools/{slug}`.
- **Behavior:**
  - Registers `app/Tools/*` via `ToolRegistry::registerDefaultTools()`.
  - `GET /tools` → catalog (tools.index).
  - `GET /tools/{slug}` → if slug is in `ToolRegistry`, delegates to that tool’s controller `index()`; else looks up tool in DB, renders partial or coming-soon.
  - `POST /tools/{slug}/process` → delegates to registered tool’s `process()` when present.
- **Legacy:** Still supports partials in `tools/partials/` and specific POST routes (e.g. grammar-check, pdf-merger) for backward compatibility.

### BaseToolController (`app/Tools/BaseToolController.php`)

- Abstract base for each tool module.
- Defines: `getSlug()`, `getName()`, `getDescription()`, `getViewPath()`, optional `process(Request $request)`.
- `index(Request $request)` renders the tool Blade view and records usage via `ToolUsageStat::record()`.

### ToolRegistry (`app/Tools/ToolRegistry.php`)

- Maps slug → controller class (e.g. `json-formatter` → `JsonFormatterController`).
- `registerDefaultTools()` registers: temp-mail, json-formatter, base64-encoder, password-generator, word-counter, image-compressor, pdf-merger, url-encoder, uuid-generator, markdown-preview.

### HomeController (`app/Http/Controllers/HomeController.php`)

- Serves homepage with: `categories`, `popularTools`, `latestTools` from DB (resilient if tables are missing).

---

## 3. Routes

Relevant tool routes in `routes/web.php`:

```php
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/tools', [ToolController::class, 'index'])->name('tools.index');
Route::get('/tools/{slug}', [ToolController::class, 'show'])->name('tools.show');
Route::post('/tools/{slug}/process', [ToolController::class, 'process'])->name('tools.process');
// Legacy specific POST routes (pdf-merger, grammar-check, etc.) remain as needed.
```

**Examples:**

- `/tools` — Tools catalog.
- `/tools/json-formatter` — JSON Formatter tool (modular).
- `/tools/password-generator` — Password Generator (modular).
- `/tools/base64-encoder` — Base64 Encoder (modular).
- `/tools/temp-mail` — Temp Mail (modular).

---

## 4. Blade templates

### Layouts (`resources/views/layouts/`)

- **app.blade.php** — Main layout: doctype, meta, header, `@yield('content')`, footer, scripts.
- **header.blade.php** — Wraps `@include('partials.navbar')`.
- **footer.blade.php** — Wraps `@include('partials.footer')`.

### Tool pages (`resources/views/tools/`)

- **layout.blade.php** — Base for individual tools (extends `layouts.app`, yields `title`, `meta_description`, `content`).
- **index.blade.php** — Tools listing page.
- **show.blade.php** — Single tool (legacy/DB-driven with partials).
- **show-coming-soon.blade.php** — Placeholder for tools not yet implemented.
- **{tool_slug}/index.blade.php** — One view per modular tool (e.g. `json_formatter/index.blade.php`, `temp_mail/index.blade.php`). Each extends `tools.layout`.

### Homepage (`resources/views/home.blade.php`)

Sections:

1. **Hero** — Full-width banner, CTA.
2. **Search Tools** — Form to `route('tools.index')` with query `q`.
3. **Popular Tools** — Grid of tool cards (and/or DB-driven `$popularTools`).
4. **Categories** — From `$categories` (DB), links to `/tools?category={slug}`.
5. **Latest Tools** — From `$latestTools` (DB).
6. **About Nexora** — SEO/company copy.
7. **Footer** — Via `layouts.footer` / `partials.footer`.

---

## 5. Database structure

### Tables

| Table               | Purpose |
|---------------------|--------|
| **tools**           | id, name, slug, category (legacy), category_id (FK), description, icon, is_active, status, timestamps |
| **categories**      | id, name, slug, description, icon, sort_order, is_active, timestamps |
| **tool_category**   | Pivot: tool_id, category_id, sort_order (many-to-many tools ↔ categories) |
| **tool_usage_stats**| tool_id, date, count (daily usage per tool) |

### Migrations (order)

1. `2026_02_21_140803_create_tools_table.php`
2. `2026_03_05_100000_create_categories_table.php`
3. `2026_03_05_100001_add_category_id_to_tools_table.php`
4. `2026_03_05_100002_create_tool_category_pivot_table.php`
5. `2026_03_05_100003_create_tool_usage_stats_table.php`
6. `2026_03_06_100000_add_status_to_tools_table.php`

### Models

- **Tool** — `category_id`, `status`; relations: `categoryRelation()`, `categories()`, `usageStats()`.
- **Category** — `tools()` BelongsToMany via `tool_category`.
- **ToolUsageStat** — `tool_id`, `date`, `count`; static `record(int $toolId)` for daily increment.

---

## 6. Asset structure

```
public/assets/
├── css/
├── js/
└── images/
```

- Layouts reference assets via `asset('assets/...')` or Vite/build as configured.
- Ensure CSS/JS load correctly; for Hostinger, compiled assets can live at document root (e.g. `build/`, `images/`) as per `HOSTINGER_SETUP.md`.

---

## 7. Git setup

**Repository:** https://github.com/anjaneyatripathi1995/nexora-tools.git

**.gitignore** must include:

- `vendor`
- `node_modules`
- `.env`
- `storage/*.key`
- `public/build`

**Commands (initial):**

```bash
git init
git add .
git commit -m "Nexora Tools — scalable SaaS architecture"
git branch -M main
git remote add origin https://github.com/anjaneyatripathi1995/nexora-tools.git
git push -u origin main
```

---

## 8. Hostinger deployment

**Constraint:** Document root cannot be changed from `public_html`.

**Server path:** `/domains/tripathinexora.com/public_html/`

- Deploy the full Laravel project so that **project root = document root** (i.e. `index.php`, `vendor/`, `app/`, etc. live inside `public_html/`).
- Root `index.php` (in repo) defines `LARAVEL_PUBLIC_PATH_IS_ROOT` and bootstraps Laravel from the project root so routes work without `/public` in the URL.
- Place compiled assets at document root: `public_html/build/`, `public_html/images/` (copy from `public/build` and `public/images` if needed). See **HOSTINGER_SETUP.md** for:
  - Exact server layout
  - Post-deploy commands (`composer install`, `php artisan migrate`, `php artisan db:seed`, cache commands)
  - `.env` production settings
  - Optional asset build/copy steps

**Summary:**

| Item          | Value |
|---------------|--------|
| Document root | `public_html` (unchanged) |
| Entry point   | `public_html/index.php` |
| Asset URLs    | `/build/*`, `/images/*` at document root |
| Repo          | https://github.com/anjaneyatripathi1995/nexora-tools.git |

---

## 9. Adding a new tool

1. **Create module under `app/Tools/{ToolName}/`:**
   - `{ToolName}Controller.php` extends `BaseToolController` (implement `getSlug`, `getName`, `getDescription`; optional `process()`).
   - `{ToolName}Service.php` extends `BaseToolService` (business logic).
2. **Register in `ToolRegistry::registerDefaultTools()`:** add slug → controller class.
3. **Create Blade view:** `resources/views/tools/{slug_with_underscores}/index.blade.php` extending `tools.layout`.
4. **Optional:** Add tool to `ToolSeeder` and run seeders so it appears in catalog and homepage.

This architecture supports scaling to 100+ tools with consistent routing, usage tracking, and categorization.
