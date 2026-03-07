# Nexora Tools — Project Progress

**Company:** Tripathi Nexora Technologies | **Domain:** tripathinexora.com
**Stack:** Laravel 12 · Breeze Auth · Livewire 4 · Tailwind CSS 3 · Alpine.js · Vite 7
**Last Updated:** 2026-03-08

---

## Table of Contents

1. [Project Overview](#1-project-overview)
2. [Tech Stack & Dependencies](#2-tech-stack--dependencies)
3. [Database & Models](#3-database--models)
4. [Authentication System](#4-authentication-system)
5. [Tool Catalog (Config-Driven)](#5-tool-catalog-config-driven)
6. [Implemented Tool Pages](#6-implemented-tool-pages)
7. [Server-Side Tool Processing](#7-server-side-tool-processing)
8. [Services Layer](#8-services-layer)
9. [Live Data Widgets](#9-live-data-widgets)
10. [User Dashboard & Saved Items](#10-user-dashboard--saved-items)
11. [Programmatic SEO Pages](#11-programmatic-seo-pages)
12. [Sitemap & Robots.txt](#12-sitemap--robotstxt)
13. [PDF Utilities (Internal)](#13-pdf-utilities-internal)
14. [Layouts & Frontend](#14-layouts--frontend)
15. [Routes Summary](#15-routes-summary)
16. [Pending / Coming Soon](#16-pending--coming-soon)
17. [Changelog](#17-changelog)

---

## 1. Project Overview

Nexora Tools is a **multi-tool SaaS hub** providing 40+ free, browser-based utilities organized into 7 categories. The application is config-driven — the entire tool catalog is defined in `config/nexora.php`, making it trivial to add new tools without touching any controller or route code.

**Core principle:** Every tool page is served by a single `ToolPageController@show` method that reads the catalog, finds the matching tool, and includes its Blade partial. Tools without a partial automatically fall back to a "Coming Soon" page.

---

## 2. Tech Stack & Dependencies

### PHP / Laravel (composer.json)

| Package | Version | Purpose |
|---------|---------|---------|
| `laravel/framework` | ^12.0 | Core framework |
| `laravel/breeze` | latest (dev) | Authentication scaffolding |
| `livewire/livewire` | ^4.2 | Reactive server-rendered components |
| `livewire/volt` | ^1.10 | Functional Livewire syntax |
| `barryvdh/laravel-dompdf` | ^3.1 | PDF generation from Blade views |
| `phpoffice/phpword` | ^1.1 | DOCX generation (PDF→Word fallback) |
| `smalot/pdfparser` | ^2.12 | PDF text extraction |
| `setasign/fpdf` | ^1.8 | Base PDF library |
| `setasign/fpdi` | 2.6.4 | PDF import & merge |

### JS / Frontend (package.json)

| Package | Version | Purpose |
|---------|---------|---------|
| `vite` | ^7.0.7 | Build tool & dev server |
| `laravel-vite-plugin` | ^2.0.0 | Laravel/Vite integration |
| `tailwindcss` | ^3.1.0 | Utility-first CSS framework |
| `@tailwindcss/vite` | ^4.0.0 | Tailwind Vite plugin |
| `@tailwindcss/forms` | ^0.5.2 | Form reset/style plugin |
| `alpinejs` | ^3.4.2 | Lightweight JS reactivity |
| `axios` | ^1.11.0 | HTTP client |
| `autoprefixer` | ^10.4.2 | CSS vendor prefixing |
| `postcss` | ^8.4.31 | CSS processing |
| `concurrently` | ^9.0.1 | Parallel dev servers |

### Third-Party APIs (config/services.php)

| API | Env Key | Used By |
|-----|---------|---------|
| remove.bg | `REMOVEBG_API_KEY` | Background Remover tool |
| CloudConvert | `PDF2WORD_API_KEY` + `PDF2WORD_ENDPOINT` | PDF to Word (tier 2 fallback) |
| LanguageTool | (public, no key) | Grammar Checker tool |
| mail.tm | (public, no key) | Temp Mail tool |
| Yahoo Finance | (public, no key) | Stock Market widget |
| Google News RSS | (public, no key) | News ticker widget |

---

## 3. Database & Models

### Migrations

| Migration File | Tables Created |
|----------------|----------------|
| `0001_01_01_000000_create_users_table` | `users`, `password_reset_tokens`, `sessions` |
| `0001_01_01_000001_create_cache_table` | `cache`, `cache_locks` |
| `0001_01_01_000002_create_jobs_table` | `jobs`, `job_batches`, `failed_jobs` |
| `2026_03_06_100000_create_saved_items_table` | `saved_items` |
| `2026_03_06_100001_create_tool_histories_table` | `tool_histories` |

### Schema Details

**`users`**
- `id`, `name`, `email` (unique), `email_verified_at`, `password` (hashed), `remember_token`, `timestamps`

**`saved_items`**
- `id`, `user_id` (FK → users, cascade delete), `item_type` (varchar 50), `item_slug` (varchar 255), `timestamps`
- Unique constraint: `(user_id, item_type, item_slug)`

**`tool_histories`**
- `id`, `user_id` (FK → users, cascade delete), `tool_id` (nullable), `tool_slug` (varchar 255), `metadata` (JSON, nullable), `created_at`

### Models

| Model | Table | Key Relationships |
|-------|-------|-------------------|
| `User` | `users` | hasMany SavedItem, hasMany ToolHistory |
| `SavedItem` | `saved_items` | belongsTo User |
| `ToolHistory` | `tool_histories` | belongsTo User |

---

## 4. Authentication System

**Implementation:** Laravel Breeze (session-based)

### Features Implemented

- [x] User Registration (name, email, password)
- [x] User Login
- [x] Email Verification (signed URL, throttled resend)
- [x] Forgot Password / Reset Password (mail link)
- [x] Confirm Password (re-auth before sensitive actions)
- [x] Logout
- [x] Profile Management
  - [x] Update name & email (resets verification if email changes)
  - [x] Update password
  - [x] Delete account (password confirmation required)

### Auth Routes (from `routes/auth.php`)

| Method | URI | Middleware |
|--------|-----|------------|
| GET/POST | `/register` | guest |
| GET/POST | `/login` | guest |
| GET/POST | `/forgot-password` | guest |
| GET/POST | `/reset-password/{token}` | guest |
| GET | `/verify-email` | auth |
| GET | `/verify-email/{id}/{hash}` | auth, signed, throttle:6,1 |
| POST | `/email/verification-notification` | auth, throttle:6,1 |
| GET/POST | `/confirm-password` | auth |
| PUT | `/password` | auth |
| POST | `/logout` | auth |

---

## 5. Tool Catalog (Config-Driven)

All tools are defined in `config/nexora.php`. The `ToolCatalog` service (`app/Services/ToolCatalog.php`) provides the repository layer.

### Categories (7)

| Slug | Name | Icon | Color |
|------|------|------|-------|
| `dev` | Developer Tools | 🛠️ | #6366f1 |
| `pdf` | PDF & File Tools | 📄 | #ef4444 |
| `text` | Text & Content Tools | 📝 | #10b981 |
| `image` | Image Tools | 🖼️ | #f59e0b |
| `seo` | SEO Tools | 🔍 | #3b82f6 |
| `finance` | Finance Tools | 💰 | #8b5cf6 |
| `ai` | AI Tools | 🤖 | #ec4899 |

### Tool Catalog (40+ Tools)

#### Finance Tools (6)
| Slug | Name | Status |
|------|------|--------|
| `emi-calculator` | EMI Calculator | ✅ Implemented |
| `sip-calculator` | SIP Calculator | ✅ Implemented |
| `fd-rd-calculator` | FD/RD Calculator | ✅ Implemented |
| `gst-calculator` | GST Calculator | ✅ Implemented |
| `age-calculator` | Age Calculator | ✅ Implemented |
| `month-to-date-converter` | Month to Date Converter | ✅ Implemented |

#### PDF & File Tools (10)
| Slug | Name | Status |
|------|------|--------|
| `pdf-to-word` | PDF to Word | ✅ Implemented |
| `pdf-to-excel` | PDF to Excel | ✅ Implemented |
| `pdf-to-image` | PDF to Image | ✅ Implemented |
| `pdf-merger` | PDF Merger | ✅ Implemented |
| `split-pdf` | Split PDF | ✅ Implemented |
| `compress-pdf` | Compress PDF | ✅ Implemented |
| `lock-unlock-pdf` | Lock/Unlock PDF | ✅ Implemented |
| `image-ocr` | OCR Tool | ✅ Implemented |
| `zip-compressor` | ZIP Compressor | ✅ Implemented (server-side) |
| `image-compressor` | Image Compressor | ✅ Implemented |

#### Text & Content Tools (7)
| Slug | Name | Status |
|------|------|--------|
| `word-counter` | Word Counter | ✅ Implemented |
| `case-converter` | Case Converter | ✅ Implemented |
| `paraphraser` | Paraphraser | ✅ Implemented |
| `grammar-checker` | Grammar Checker | ✅ Implemented (LanguageTool API) |
| `plagiarism-checker` | Plagiarism Checker | ✅ Implemented |
| `resume-builder` | Resume Builder | ✅ Implemented |
| `essay-letter-generator` | Essay/Letter Generator | ✅ Implemented |

#### Developer Tools (10)
| Slug | Name | Status |
|------|------|--------|
| `json-formatter` | JSON Formatter | ✅ Implemented |
| `base64-encoder` | Base64 Encoder/Decoder | ✅ Implemented |
| `password-generator` | Password Generator | ✅ Implemented |
| `url-encoder` | URL Encoder/Decoder | ✅ Implemented |
| `uuid-generator` | UUID Generator | ✅ Implemented |
| `markdown-editor` | Markdown Editor | ✅ Implemented |
| `qr-code-generator` | QR Code Generator | ✅ Implemented |
| `regex-tester` | Regex Tester | ✅ Implemented |
| `minifier` | Code Minifier | ✅ Implemented |
| `temp-mail` | Temp Mail | ✅ Implemented (mail.tm API) |

#### Image Tools (3)
| Slug | Name | Status |
|------|------|--------|
| `image-resizer` | Image Resizer | ✅ Implemented |
| `background-remover` | Background Remover | ✅ Implemented (remove.bg API) |
| `image-ocr` | Image OCR | ✅ Implemented |

#### SEO Tools (3)
| Slug | Name | Status |
|------|------|--------|
| `meta-tag-generator` | Meta Tag Generator | ⏳ Coming Soon |
| `keyword-density` | Keyword Density | ⏳ Coming Soon |
| `sitemap-generator` | Sitemap Generator | ⏳ Coming Soon |

#### AI Tools (3)
| Slug | Name | Status |
|------|------|--------|
| `ai-text-humanizer` | AI Text Humanizer | ⏳ Coming Soon |
| `ai-content-writer` | AI Content Writer | ⏳ Coming Soon |
| `ai-summarizer` | AI Summarizer | ⏳ Coming Soon |

---

## 6. Implemented Tool Pages

Tool pages are served by `app/Http/Controllers/Site/ToolPageController.php`. Each tool's UI lives in `resources/views/tools/partials/`.

### ToolPageController Logic

- Reads tool metadata from `ToolCatalog` service
- Records usage in `tool_histories` for authenticated users
- Checks `saved_items` to set bookmark state
- Routes to `tools.show` (with partial) or `tools.show-coming-soon`
- Legacy redirect support: `/{slug}` → `/tools/{slug}`

### Partial View Map (35 partials)

| Partial File | Handles Slugs |
|--------------|---------------|
| `emi-calculator.blade.php` | `emi-calculator` |
| `sip-calculator.blade.php` | `sip-calculator` |
| `fd-rd-calculator.blade.php` | `fd-rd-calculator` |
| `gst-calculator.blade.php` | `gst-calculator` |
| `age-calculator.blade.php` | `age-calculator` |
| `month-to-date-converter.blade.php` | `month-to-date-converter` |
| `pdf-to-word.blade.php` | `pdf-to-word` |
| `pdf-to-excel.blade.php` | `pdf-to-excel` |
| `pdf-to-image.blade.php` | `pdf-to-image` |
| `pdf-merger.blade.php` | `pdf-merger` |
| `split-pdf.blade.php` | `split-pdf` |
| `compress-pdf.blade.php` | `compress-pdf` |
| `lock-unlock-pdf.blade.php` | `lock-unlock-pdf` |
| `ocr.blade.php` | `image-ocr` |
| `zip-compressor.blade.php` | `zip-compressor` |
| `image-compressor.blade.php` | `image-compressor` |
| `word-counter.blade.php` | `word-counter` |
| `case-converter.blade.php` | `case-converter` |
| `paraphraser.blade.php` | `paraphraser` |
| `grammar-checker.blade.php` | `grammar-checker` |
| `plagiarism-checker.blade.php` | `plagiarism-checker` |
| `resume-builder.blade.php` | `resume-builder` |
| `essay-letter-generator.blade.php` | `essay-letter-generator` |
| `json-formatter.blade.php` | `json-formatter` |
| `base64-encoder.blade.php` | `base64-encoder` |
| `password-generator.blade.php` | `password-generator` |
| `url-encoder.blade.php` | `url-encoder` |
| `uuid-generator.blade.php` | `uuid-generator` |
| `markdown-editor.blade.php` | `markdown-editor` |
| `qr-code-generator.blade.php` | `qr-code-generator` |
| `regex-tester.blade.php` | `regex-tester` |
| `minifier.blade.php` | `minifier` |
| `temp-mail.blade.php` | `temp-mail` |
| `image-resizer.blade.php` | `image-resizer` |
| `background-remover.blade.php` | `background-remover` |

---

## 7. Server-Side Tool Processing

Some tools require server-side computation or API proxying to avoid CORS issues. These are handled by dedicated controllers under `app/Http/Controllers/Api/` and `app/Http/Controllers/Site/`.

### Implemented Processing Endpoints

| POST Route | Controller | What It Does |
|------------|-----------|-------------|
| `/tools/process/zip-compressor` | `PdfFileController@zipCompressor` | Accepts multiple files, creates a ZIP via PHP `ZipArchive`, streams `download.zip` |
| `/tools/process/grammar-check` | `ToolProcessController@grammarCheck` | Proxies request to LanguageTool API; avoids browser CORS. Max 20,000 chars. |
| `/tools/process/background-remover` | `ToolProcessController@backgroundRemover` | Uploads image to remove.bg API using `REMOVEBG_API_KEY`; returns background-removed PNG |
| `/tools/process/pdf-to-word` | `ToolProcessController@pdfToWord` | 3-tier conversion: (1) LibreOffice `soffice --headless` → (2) CloudConvert API → (3) smalot/pdfparser + phpoffice/phpword fallback |
| `GET /tools/temp-mail/inbox` | `TempMailController@inbox` | Proxies inbox fetch from mail.tm using Bearer JWT |
| `GET /tools/temp-mail/message/{id}` | `TempMailController@message` | Proxies single message fetch from mail.tm |
| `POST /tools/temp-mail/generate` | `TempMailController@generate` | Generates a new disposable email address via mail.tm API |

---

## 8. Services Layer

### `ToolCatalog` (`app/Services/ToolCatalog.php`)

Repository over `config/nexora.php`. Provides:
- `categories()` — All 7 category definitions
- `tools()` — All 40+ tool definitions
- `toolsByCategory(string $slug)` — Filter by category
- `popularTools(int $limit = 9)` — Tools marked `popular: true`
- `findTool(string $slug)` — Find a single tool by slug

### `TempMailService` (`app/Services/TempMailService.php`) ✅ New

Server-side proxy wrapper for the `mail.tm` public API.

| Method | Description |
|--------|-------------|
| `generateEmail()` | Full flow: fetch domains → register account → login → return `{address, password, token}` |
| `getMessages(string $token)` | Fetches inbox messages (authenticated with JWT) |
| `getMessage(string $id, string $token)` | Fetches full body of a single message |
| `getDomains()` | Lists available mail.tm domains |
| `createAccount(string $address, string $password)` | Registers throwaway account |
| `login(string $address, string $password)` | Authenticates and returns JWT token |
| `extractList(mixed $body)` | Normalises Hydra format (`hydra:member`) and plain array response |

---

## 9. Live Data Widgets

### Stock Market Widget

- **Controller:** `App\Http\Controllers\Api\StocksProxyController` (invokable)
- **Route:** `GET /api/stocks.php`
- **Source:** Yahoo Finance (public, no API key)
- **Data:** NIFTY 50, SENSEX, NASDAQ, Dow Jones, Gold (XAU/USD), USD/INR
- **Fields per ticker:** price, change, change%, direction (up/down), market state
- **Cache:** 60-second response cache header

### News Ticker Widget

- **Controller:** `App\Http\Controllers\Api\NewsProxyController` (invokable)
- **Route:** `GET /api/news.php`
- **Source:** Google News RSS feed
- **Feed types:** `tech`, `finance`, `stock`
- **Returns:** Up to 20 items as JSON
- **Cache:** 5-minute response cache header
- **CORS:** CORS headers added (widget fetched client-side)

---

## 10. User Dashboard & Saved Items

### Dashboard (`DashboardController`)

| Route | View | Description |
|-------|------|-------------|
| `GET /dashboard` | `dashboard/dashboard.blade.php` | Overview: saved count, tools used, total usages, latest 6 saved tools, 4 saved projects, 10 recent activities |
| `GET /dashboard/usages` | `dashboard/usages.blade.php` | Paginated tool usage history (20/page) |
| `GET /dashboard/analytics` | `dashboard/analytics.blade.php` | Usage analytics grouped by tool slug, sorted by count |

### Saved Items (`SavedItemController`)

- **Route:** `POST /saved-items/toggle` (auth-protected)
- Toggles save/unsave for any `item_type` + `item_slug` combination
- Returns `{saved: bool, message}` as JSON
- Types supported: `tool`, `project`, `template`

---

## 11. Programmatic SEO Pages

Configurable landing pages defined in `config/seo.php`. These pages serve dual purposes: SEO discoverability and marketing.

### Services Pages

| Route | Config Key | Description |
|-------|-----------|-------------|
| `GET /services` | — | Services listing (`seo/services-index.blade.php`) |
| `GET /services/{service}` | `seo.services` | Service detail with benefits, FAQs, related tools |

**Implemented services:** `pdf-workflows`, `document-security`

### Industry Pages

| Route | Config Key | Description |
|-------|-----------|-------------|
| `GET /industry` | — | Industry listing (`seo/list-index.blade.php`) |
| `GET /industry/{industry}` | `seo.industries` | Industry detail page (`seo/industry.blade.php`) |

**Implemented industries:** `legal`, `education`

### Solution Pages

| Route | Config Key | Description |
|-------|-----------|-------------|
| `GET /solutions` | — | Solutions listing (`seo/list-index.blade.php`) |
| `GET /solutions/{solution}` | `seo.solutions` | Solution detail page (`seo/solution.blade.php`) |

**Implemented solutions:** `remote-teams`, `immigration`

### SEO Infrastructure

- `components/seo.blade.php` — Dynamic meta tags and Open Graph tags
- `partials/schema.blade.php` — JSON-LD structured data
- `partials/progress-bar.blade.php` — NProgress page load bar

---

## 12. Sitemap & Robots.txt

**Controller:** `SitemapController`

| Route | Description |
|-------|-------------|
| `GET /sitemap.xml` | Full XML sitemap. Includes: home, tools index, all 7 categories, all service/industry/solution pages, all tool pages |
| `GET /robots.txt` | Auto-generated robots.txt. `Allow: /` in production; `Disallow: /` in other environments |

---

## 13. PDF Utilities (Internal)

**Controller:** `PdfManagementController` (internal, not directly exposed via route)

| Method | Description |
|--------|-------------|
| `generateFromView(array $data, string $view)` | Renders a Blade view to PDF using DomPDF; streams for download |
| `mergePDFs(array $filePaths)` | Merges multiple PDFs using FPDI; saves result to `storage/app/tmp` |

**Blade templates:** `pdf/template.blade.php`, `pdf/sample.blade.php`

---

## 14. Layouts & Frontend

### Blade Layouts

| Layout | Used By |
|--------|---------|
| `layouts/site.blade.php` | All public-facing pages |
| `layouts/app.blade.php` | Authenticated pages |
| `layouts/user.blade.php` | Dashboard & profile |
| `layouts/guest.blade.php` | Login/Register/Reset pages |

### Site Layout Features (`layouts/site.blade.php`)

- Full responsive navbar with **mega-menu** (all tool categories with icons)
- Category dropdowns
- News & stock market dropdown
- **Dark/Light theme toggle** (CSS custom properties + `localStorage` persistence)
- Sidebar search plugin
- Footer with social links, category links, and legal links
- `window.NEXORA_TOOLS` JSON injected for JavaScript tools

### Frontend Architecture

- **Tailwind CSS** — All styling via utility classes
- **Alpine.js** — Reactive tool UIs (calculators, formatters, toggles)
- **Axios** — AJAX calls to processing endpoints
- **Vite** — Asset compilation and hot module reload

### Static Pages

| Route | View | Description |
|-------|------|-------------|
| `GET /` | `pages/home.blade.php` | Hero, popular tools grid, category sections, news ticker, stock widget |
| `GET /tools` | `pages/tools.blade.php` | All tools browse + search (`?q=`) + category filter |
| `GET /{category}` | `pages/category.blade.php` | Category-filtered tool listing |
| `GET /about` | `pages/about.blade.php` | About page |
| `GET/POST /contact` | `pages/contact.blade.php` | Contact form (PHP `mail()`) |
| `GET /privacy` | `pages/privacy.blade.php` | Privacy policy |
| `GET /terms` | `pages/terms.blade.php` | Terms of service |

---

## 15. Routes Summary

### Public Routes

| Method | URI | Controller |
|--------|-----|-----------|
| GET | `/` | `HomeController` |
| GET | `/tools` | `ToolsController@index` |
| GET | `/tools/{slug}` | `ToolPageController@show` |
| GET | `/about` | `StaticPageController@about` |
| GET/POST | `/contact` | `StaticPageController@contact` |
| GET | `/privacy` | `StaticPageController@privacy` |
| GET | `/terms` | `StaticPageController@terms` |
| GET | `/{category}` | `CategoryController@show` |
| GET | `/services` | closure → `seo.services-index` |
| GET | `/services/{service}` | `ServicePageController` |
| GET | `/industry` | closure → `seo.list-index` |
| GET | `/industry/{industry}` | `IndustryPageController` |
| GET | `/solutions` | closure → `seo.list-index` |
| GET | `/solutions/{solution}` | `SolutionPageController` |
| GET | `/sitemap.xml` | `SitemapController@index` |
| GET | `/robots.txt` | `SitemapController@robots` |
| GET | `/favicon.ico` | Streams `favicon.svg` |

### API / Tool Processing Routes (No Auth)

| Method | URI | Controller |
|--------|-----|-----------|
| GET | `/api/news.php` | `NewsProxyController` |
| GET | `/api/stocks.php` | `StocksProxyController` |
| POST | `/tools/process/zip-compressor` | `PdfFileController@zipCompressor` |
| POST | `/tools/process/grammar-check` | `ToolProcessController@grammarCheck` |
| POST | `/tools/process/background-remover` | `ToolProcessController@backgroundRemover` |
| POST | `/tools/process/pdf-to-word` | `ToolProcessController@pdfToWord` |
| POST | `/tools/temp-mail/generate` | `TempMailController@generate` |
| GET | `/tools/temp-mail/inbox` | `TempMailController@inbox` |
| GET | `/tools/temp-mail/message/{id}` | `TempMailController@message` |

### Legacy Redirects

| URI | Redirects To |
|-----|-------------|
| `/json-formatter` | `/tools/json-formatter` |
| `/password-generator` | `/tools/password-generator` |

### Auth-Protected Routes

| Method | URI | Middleware | Controller |
|--------|-----|------------|-----------|
| POST | `/saved-items/toggle` | `auth` | `SavedItemController@toggle` |
| GET | `/dashboard` | `auth, verified` | `DashboardController` |
| GET | `/dashboard/usages` | `auth, verified` | `DashboardController@usages` |
| GET | `/dashboard/analytics` | `auth, verified` | `DashboardController@analytics` |
| GET | `/profile` | `auth` | `ProfileController@edit` |
| PATCH | `/profile` | `auth` | `ProfileController@update` |
| DELETE | `/profile` | `auth` | `ProfileController@destroy` |

---

## 16. Pending / Coming Soon

### SEO Tools (3)
- [ ] Meta Tag Generator
- [ ] Keyword Density Checker
- [ ] Sitemap Generator

### AI Tools (3)
- [ ] AI Text Humanizer
- [ ] AI Content Writer
- [ ] AI Summarizer

### Programmatic SEO Expansion
- [ ] Add more service entries to `config/seo.php`
- [ ] Add more industry entries (healthcare, finance, real estate, etc.)
- [ ] Add more solution entries

### Infrastructure
- [ ] Rate limiting on tool processing endpoints
- [ ] File upload size validation per tool
- [ ] Job queuing for heavy processing (PDF conversions)
- [ ] Redis caching for API proxy responses
- [ ] Admin dashboard / analytics panel
- [ ] Blog section

---

## 17. Changelog

### 2026-03-08
- **Added:** `TempMailService` (`app/Services/TempMailService.php`)
  - Full server-side proxy for the `mail.tm` public API
  - Methods: `generateEmail`, `getMessages`, `getMessage`, `getDomains`, `createAccount`, `login`, `extractList`
  - Handles both Hydra (`hydra:member`) and plain array response formats
- **Added:** `TempMailController` (`app/Http/Controllers/Site/TempMailController.php`)
  - `POST /tools/temp-mail/generate` — Full disposable email generation
  - `GET /tools/temp-mail/inbox` — JWT-authenticated inbox proxy
  - `GET /tools/temp-mail/message/{id}` — Single message proxy
- **Updated:** `temp-mail.blade.php` partial — Wired up to new server-side endpoints
- **Updated:** `routes/web.php` — Added three temp mail routes (`tmail.generate`, `tmail.inbox`, `tmail.message`)

### 2026-03-06
- **Added:** `saved_items` migration and `SavedItem` model
- **Added:** `tool_histories` migration and `ToolHistory` model
- **Added:** `SavedItemController` with toggle endpoint
- **Added:** `DashboardController` with main dashboard, usages, and analytics views

### Project Inception
- Laravel 12 project scaffolded with Breeze authentication
- `config/nexora.php` tool catalog created (40+ tools, 7 categories)
- `config/seo.php` SEO content config created
- `ToolCatalog` service implemented
- All 35 tool partials implemented
- Full site layout with mega-menu, dark/light theme, stock widget, news ticker
- `ToolPageController` single-route tool dispatch
- Server-side processing: ZIP compressor, Grammar Check, Background Remover, PDF to Word
- API proxies: News (Google RSS), Stocks (Yahoo Finance)
- Programmatic SEO: services, industries, solutions landing pages
- XML sitemap and robots.txt generation
- PDF utilities: DomPDF view-to-PDF, FPDI PDF merging
- Legacy URL redirects
