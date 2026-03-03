# TechHub – All-in-One Tech Solution Hub

## 📌 Project Overview

TechHub is a Laravel-based All-in-One Tech Solution Hub that provides utility tools, project solutions, templates, AI videos, news, market updates, and user features. Positioned as an all-in-one digital hub for calculators and utility tools (in line with platforms like ToolboxNest and Toolora). The stack follows modern best practices:

| Layer | Technology |
|-------|------------|
| **Backend** | Laravel (PHP) |
| **Frontend** | Blade, Bootstrap 5, HTML, CSS, JavaScript |
| **Asset Bundler** | Vite |
| **Database** | SQLite (development) |
| **Auth** | Laravel Breeze (optional login) |

---

## 📅 Changelog

### Feb 27, 2026

#### Calculator Redesigns
- **EMI Calculator**: Redesigned with interactive sliders synchronized to input fields + Chart.js horizontal bar chart showing principal vs. interest vs. total.
- **SIP Calculator**: Applied shared calculator style pattern (sliders + Chart.js).
- **FD/RD Calculator**: Completely rebuilt with separate **FD** / **RD** tabs, interactive sliders for principal/rate/tenure, real-time calculation, formatted currency output, and Chart.js visualization.
- **Shared styles partial** (`calculator-shared-styles.blade.php`): Unified slider, card, and chart CSS applied across all Finance calculators.

#### Async PDF Job Architecture
- Created `tool_jobs` database table (migration `2026_02_27_000000_create_tool_jobs_table.php`) with fields: slug, status, progress, input_paths (JSON), result_path, error_message.
- Created `App\Models\ToolJob` model with JSON casts.
- Created `App\Jobs\ProcessToolJob` with handlers: `doMerge()` (qpdf), `doSplit()` (qpdf), `doCompress()` (Ghostscript), `doPdfToImage()` (pdftoppm → ZIP).
- Updated **PDF Merger**, **Split PDF**, **Compress PDF**, **PDF to Image** partials: forms now submit via AJAX (Fetch API + CSRF), poll job status every second, show progress and download link on completion.

#### API Endpoints (new)
- `POST /api/tools/{slug}` → `ToolJobController@store` — accepts file uploads, creates ToolJob, dispatches queue job.
- `GET /api/jobs/{id}` → `ToolJobController@show` — returns job status, progress, result download URL.

#### Master Admin & Admin User Management (new)
- Added `is_master` boolean column to `users` table (migration `2026_02_21_170001_add_is_master_to_users_table.php`).
- Created `EnsureMasterAdmin` middleware (`admin.master`).
- Created `Admin\AdminUserController` with `index()`, `create()`, `store()` methods.
- Added admin views: `admin/admins/index.blade.php` (list admins), `admin/admins/create.blade.php` (create admin form).
- Routes: `GET/POST /admin/admins` and `GET /admin/admins/create` protected by `admin.master` middleware.
- Added `AdminSeeder` to seed the default admin user.

#### New Tool Partials
- `background-remover.blade.php`: Upload image → POST to `ToolController::backgroundRemover()` → remove.bg API → download.
- `image-resizer.blade.php`: Upload image → set width/height, aspect ratio, format → client-side canvas → download.

#### Other
- Created `layouts/user.blade.php` — dedicated user portal layout.
- `IMPLEMENTATION_STATUS.md` added as internal documentation reference.
- `AdminSeeder` added to `DatabaseSeeder`.

#### Homepage & UI Redesign (Feb 27)
- **Hero**: Stronger overlay gradient; animated glassmorphism badge (“All-in-One Tech Platform”); gradient headline (“Tech Solution”); Ken Burns effect on banner images; inline stats bar (32+ Tools, 7 Projects, 21 Apps, 4 Templates); scroll indicator; staggered fade-up animations.
- **Stats strip**: New section below hero with animated counters (32+ Tools, 7 Projects, 21+ Apps, 4 Templates) on blue gradient background.
- **Sections**: Numbered tags (01–07), gradient accent underline on section titles; new card styles (home-card, proj-card, app-pill, tpl-card, ai-card, nm-card, cta-card) with hover lift + shadow; scroll-reveal animations on scroll.
- **Navbar**: Transparent over hero, solid white with shadow on scroll (`navbar-transparent` / `navbar-scrolled`).
- **Layout**: `page-main` (standard pages, margin-top for fixed navbar) vs `page-main-hero` (homepage, no top margin so hero is full-viewport).
- **Footer**: `.site-footer` dark navy (#0f172a); link hover styles.

#### Shared Sub-Page Banners (Feb 27)
- **Partial**: `resources/views/partials/page-banner.blade.php` — single reusable banner for all section pages.
- **Props**: `image`, `tag`, `title`, `subtitle`, `icon`, `accentColor`, `breadcrumb`, `links` (quick-nav pills).
- **Design**: Deep directional overlay (92% → 72% → 45%); glassmorphism tag badge with pulsing dot; breadcrumb (Home → Section); decorative animated blobs; right-side icon with orbit rings + float animation; staggered entrance animations; per-page accent color.
- **Pages updated**: Tools, Projects, Apps, Templates, AI Videos, News, Market — all now use `@include('partials.page-banner', [...])` with section-specific content.
- **CSS**: `.sub-banner`, `.sub-banner__overlay`, `.sub-banner__tag`, `.sub-banner__title`, `.sub-banner__sub`, `.sub-banner__pill`, `.sub-banner__icon-wrap`, `.sub-banner__anim` in `app.css`.

### Mar 1, 2026

#### JSON Formatter → JSON Studio (redesign)
- **JSON Formatter** rebuilt as **JSON Studio**: dedicated two-panel layout (Input | Output) with full toolbar and view modes.
- **Toolbar**: Sample, Copy, Paste, Upload (file), Beautify, Clear, Download; indent selector (2/4/8 spaces, Tab).
- **Output views**: **Pretty** (formatted JSON), **Tree** (expandable key/value tree with syntax-colored types), **Raw** (minified).
- **Flow actions**: Center panel with circle buttons — Beautify (input → output), Send back (output → input).
- **Behavior**: Parse/validate on Beautify; copy input/output; paste from clipboard; upload `.json`/`.txt`; download result; load sample JSON; editable output in Pretty/Raw.
- **Partial**: `resources/views/tools/partials/json-formatter.blade.php` — `.json-lab` layout, `.json-panels` grid, `.json-tree` for tree view; all logic in inline script (no external deps).

#### Tool page wide layout for JSON Formatter
- **Tool detail** (`tools/show.blade.php`): When slug is `json-formatter`, use **wide layout** — `container-fluid px-lg-5 json-formatter-wrap`, main column full-width, **sidebar hidden** so JSON Studio has maximum space.
- **CSS** (`app.css`): New styles for JSON Studio — `.json-lab`, `.json-lab__header`, `.json-pill-tray`, `.json-toolbar`, `.json-panels`, `.json-panel`, `.json-panel-actions`, `.json-circle-btn`, `.json-editor`, `.json-output`, `.json-tree`, `.json-formatter-card`, `.json-formatter-wrap`; tree view keys/values (`.json-tree__key`, `.json-tree__value--string|number|boolean|object`).

#### Research alignment (Mar 1, 2026)
- **Positioning**: Documented market context as all-in-one digital hub (ToolboxNest/Toolora style).
- **Roadmap**: Project ideas — **AI Mental Health Companion** (mood support, empathetic chat, guided exercises, journaling); **Virtual Study Group** (collaborative study materials, discussions, exam prep).
- **AI Video/Meme/Caption**: Target behavior — prompt-to-video (comedy/motivational), synchronized audio; meme templates + AI captions; prompt-based story generator (when APIs integrated).
- **News/Market**: Integration options — NewsAPI (or similar) for tech/startup headlines; TradingView (or similar) widgets for Nifty/Sensex, top gainers/losers, live indices.
- **User roadmap**: **AI Content Center** (generate and save AI outputs — videos, resumes, essays — under account); manage downloaded code/projects and preferences.

---

## 🗺️ Site Map & Routes

| Route | Controller | Description |
|-------|-------------|-------------|
| `GET /` | Closure | Homepage |
| `GET /tools` | ToolController@index | Utility tools listing |
| `GET /tools/{slug}` | ToolController@show | Tool detail or coming-soon |
| `POST /tools/process/zip-compressor` | PdfFileController@zipCompressor | Create ZIP from uploads |
| `POST /tools/process/pdf-merger` | PdfFileController@pdfMerger | Merge PDFs |
| `POST /tools/process/split-pdf` | PdfFileController@splitPdf | Split PDF to ZIP |
| `POST /tools/process/grammar-check` | ToolController@grammarCheck | Grammar check proxy (LanguageTool) |
| `POST /tools/process/background-remover` | ToolController@backgroundRemover | Remove image background (remove.bg when REMOVEBG_API_KEY set) |
| `GET /projects` | ProjectController@index | Project solutions listing |
| `GET /projects/{slug}` | ProjectController@show | Project detail |
| `GET /apps` | AppController@index | Mobile/Web app suite listing |
| `GET /apps/{slug}` | AppController@show | App detail |
| `GET /templates` | TemplateController@index | HTML templates listing |
| `GET /templates/{slug}` | TemplateController@show | Template detail |
| `GET /ai-videos` | AIVideoController@index | AI video & fun tools |
| `GET /ai-videos/generator` | AIVideoController@generator | AI video generator |
| `GET /ai-videos/meme-generator` | AIVideoController@memeGenerator | Meme generator |
| `GET /ai-videos/love-calculator` | AIVideoController@loveCalculator | Love calculator |
| `GET /ai-videos/caption-generator` | AIVideoController@captionGenerator | AI caption/story generator |
| `GET /news` | NewsController@index | Trending & tech news |
| `GET /market` | MarketController@index | Stock market (Nifty/Sensex) |
| `GET /dashboard` | DashboardController | User portal – stats, saved items, recent activity (auth) |
| `GET /dashboard/usages` | DashboardController@usages | User tool usage history (auth) |
| `GET /dashboard/analytics` | DashboardController@analytics | User analytics – most used tools (auth) |
| `GET /profile` | View | User profile (auth) |
| `GET /admin` | Admin\DashboardController@index | Admin dashboard (auth + role admin) |
| `GET/POST/PUT/DELETE /admin/tools` | Admin\ToolController | Admin tools CRUD (auth + role admin + section access) |
| `GET /admin/projects` | Closure | Admin projects – coming soon (auth + role admin) |
| `GET /admin/apps` | Closure | Admin apps – coming soon (auth + role admin) |
| `GET /admin/templates` | Closure | Admin templates – coming soon (auth + role admin) |
| `GET /admin/admins` | Admin\AdminUserController@index | List admin users (auth + master admin) |
| `GET /admin/admins/create` | Admin\AdminUserController@create | Create admin user form (auth + master admin) |
| `POST /admin/admins` | Admin\AdminUserController@store | Store new admin user (auth + master admin) |
| `POST /api/tools/{slug}` | Api\ToolJobController@store | Create async tool job (PDF operations) |
| `GET /api/jobs/{id}` | Api\ToolJobController@show | Poll async job status |
| Auth routes | auth.php | Login, Register, Forgot/Reset password, etc. |

---

## 🔧 1. Utility Tools Section

### Implemented

- **Full catalog** defined in `ToolController::fullCatalog()` with 5 categories and 35+ tools.
- **Tools index** (`/tools`): **Banner image** (utility-banner-2.png) with overlay; category sections (Finance, PDF, Text, Developer, Image), cards with icon, name, description, “Open Tool” / “Coming Soon”, link to tool page.
- **Tool detail** (`/tools/{slug}`): If tool exists in DB and has an implemented partial → `tools/show` with working UI; else if in DB → “under construction”; else if in catalog → `tools/show-coming-soon`.
- **Backend logic**: `ToolController::implementedSlugs()` lists all slugs with a partial; `show()` passes `tool_partial` to view; each tool has `resources/views/tools/partials/{slug}.blade.php`. **JSON Formatter** uses a **wide layout** (no sidebar) when slug is `json-formatter`. File-upload tools use `PdfFileController` (ZIP, PDF merge, PDF split), `ToolController::grammarCheck()` (LanguageTool proxy), and `ToolController::backgroundRemover()` (remove.bg API).
- **Async PDF job architecture** *(new – Feb 27)*: PDF-heavy tools (Merge, Split, Compress, PDF-to-Image) now use a **job queue**. Frontend submits files via AJAX (Fetch API with CSRF token) → backend creates `ToolJob` record → queue worker processes → frontend polls `GET /api/jobs/{id}` → download link shown on completion.
- **Shared calculator styles** *(new – Feb 27)*: `calculator-shared-styles.blade.php` partial with interactive sliders synced to input fields, Chart.js horizontal bar charts, formatted currency display — applied across all Finance calculators.

### Working tools (implemented partials + seeded in DB)

**Finance & Date**

| Slug | Name | Logic |
|------|------|--------|
| emi-calculator | EMI Calculator | Loan amount, rate, tenure → monthly EMI (JS); **redesigned** with interactive sliders + Chart.js bar chart |
| sip-calculator | SIP Calculator | Monthly investment, return %, years → maturity (JS); **redesigned** with shared slider/chart styles |
| fd-rd-calculator | FD/RD Calculator | **Completely redesigned** (Feb 27): separate FD / RD tabs; interactive sliders for principal, rate, tenure; real-time calc + Chart.js visualization; formatted currency output |
| gst-calculator | GST Calculator | Amount, rate, inclusive/exclusive → GST & total (JS) |
| age-calculator | Age Calculator | DOB, as-on date → age in years/months/days (JS) |
| month-to-date-converter | Month-to-Date Converter | Date string → DD/MM/YYYY, YYYY-MM-DD, full (JS) |

**PDF & File**

| Slug | Name | Logic |
|------|------|--------|
| pdf-merger | Merge PDF | Upload 2+ PDFs → **async job** (AJAX → ToolJob → queue worker → status poll → download) |
| split-pdf | Split PDF | Upload 1 PDF → **async job** → per-page extraction → ZIP download |
| compress-pdf | Compress PDF | Upload PDF → **async job** → Ghostscript compression → download |
| pdf-to-image | PDF to Image | Upload PDF → **async job** → pdftoppm PNG pages → ZIP download |
| zip-compressor | ZIP Compressor | Upload files → server creates ZIP → download |
| image-compressor | Image Compressor | Upload image → client-side resize/quality → download |
| ocr | OCR (Image to Text) | Upload image → Tesseract.js in browser → extracted text |
| pdf-to-word, pdf-to-excel | PDF to Word/Excel | Upload UI + “server service when configured” message |
| lock-unlock-pdf | Lock / Unlock PDF | Upload + password field + message |

**Text & Content**

| Slug | Name | Logic |
|------|------|--------|
| word-counter | Word & Character Counter | Live word, character, sentence, paragraph count (JS) |
| case-converter | Case Converter | UPPER, lower, Title Case, Sentence case (JS) |
| paraphraser | Paraphraser / Rewriter | Synonym-based rephrase (JS) |
| grammar-checker | Grammar Checker | Paste text → POST to app → LanguageTool API → issues list |
| plagiarism-checker | Plagiarism Checker | Two texts → word-overlap similarity % (JS) |
| resume-builder | Resume Builder | Form (personal, experience, education, skills) → HTML resume preview, Print, Copy HTML |
| essay-letter-generator | Essay / Letter Generator | Type (Formal/Informal Letter, Essay) → template output (JS) |

**Developer**

| Slug | Name | Logic |
|------|------|--------|
| json-formatter | JSON Formatter (JSON Studio) | Input/Output panels; Pretty / Tree / Raw views; Sample, Copy, Paste, Upload, Beautify, Download; indent options (JS) |
| base64-encoder | Base64 Encoder | Encode / Decode tabs (JS) |
| url-encoder | URL Encoder | Encode / Decode tabs (JS) |
| regex-tester | Regex Tester | Pattern + test string → matches (JS) |
| qr-code-generator | QR Code Generator | Text/URL → QR image (Google Charts API) |
| minifier | HTML/CSS/JS Minifier | JS, CSS, HTML tabs → minified output (JS) |

**Image**

| Slug | Name | Logic |
|------|------|--------|
| image-resizer | Image Resizer | Upload image → set width/height, aspect ratio, format (JPEG/PNG/WebP) → client-side canvas → download |
| background-remover | Background Remover | Upload image → POST to app → remove.bg API (when REMOVEBG_API_KEY set) → download no-bg PNG |
| image-ocr | OCR Tool | Same as `ocr` partial – extract text from images (Tesseract.js in browser) |

### Tool Categories & Items

| Category | Tools |
|----------|--------|
| **Finance & Date** | EMI, SIP, FD/RD, GST, Age Calculator, Month-to-Date Converter |
| **PDF & File** | PDF to Word/Excel/Image, Merge, Split, Compress, Lock/Unlock, OCR, ZIP Compressor, Image Compressor |
| **Text & Content** | Word & Character Counter, Case Converter, Paraphraser, Grammar Checker, Plagiarism Checker, Resume Builder, Essay/Letter Generator |
| **Developer** | JSON Formatter (JSON Studio), QR Code, Regex Tester, Base64/URL Encoder, Minifier |
| **Image** | Image Resizer, Background Remover, OCR Tool |

### Key Files

- `app/Http/Controllers/ToolController.php` – fullCatalog(), implementedSlugs(), partialForSlug(), index(), show(), grammarCheck(), backgroundRemover()
- `app/Http/Controllers/PdfFileController.php` – zipCompressor(), pdfMerger(), splitPdf()
- `app/Http/Controllers/Api/ToolJobController.php` – store() create job, show() poll status *(new)*
- `app/Jobs/ProcessToolJob.php` – doMerge(), doSplit(), doCompress(), doPdfToImage() *(new)*
- `app/Models/ToolJob.php` – status tracking model with JSON casts *(new)*
- `database/migrations/2026_02_27_000000_create_tool_jobs_table.php` – tool_jobs schema *(new)*
- `resources/views/tools/index.blade.php`, `show.blade.php`, `show-coming-soon.blade.php`
- `resources/views/tools/partials/calculator-shared-styles.blade.php` – shared slider/chart styles *(new)*
- `resources/views/tools/partials/*.blade.php` – all tool partials; EMI & SIP redesigned; FD/RD fully rebuilt; **json-formatter** redesigned as JSON Studio (Mar 1); PDF merge/split/compress/pdf-to-image now async AJAX; background-remover, image-resizer added
- `database/seeders/ToolSeeder.php` – seeds all implemented tools from catalog (updateOrCreate by slug)
- `resources/css/app.css` – .tool-page-card, .tool-form-wrap + extensive new styles
- `routes/web.php` – POST routes for tools/process/*; `routes/api.php` – tool jobs + EMI API
- Composer: `setasign/fpdf`, `setasign/fpdi` for PDF merge/split

---

## 💼 2. Web & Mobile Project Solutions Section

### Implemented

- **Listing** (`/projects`): **Banner image** (projects-banner.png) with overlay + 7 project cards with icon, name, description, features preview, “View Project” link. Fully functional listing and detail.
- **Detail** (`/projects/{slug}`): Project name, description, features list, tech stack badges. Action buttons show **“Coming Soon”** (Live Demo, Source Code, Download) – pages and layout unchanged, only button text for non-wired actions.
- **Roadmap/ideas**: Future project concepts include **AI Mental Health Companion** (mood support, empathetic chat, guided exercises, journaling; cost-effective, private, accessible) and **Virtual Study Group** (collaborative study materials, discussions, exam prep).

### Vision (research-aligned use cases)

- **Restaurant booking**: Real-time table availability, special requests, order management.
- **Expense/Finance**: Categorize spending, set budgets, generate reports, personalized budgets.
- **E-Learning**: Video courses and quizzes, expert-led content, track progress.
- **Fitness & Health**: Track workouts, vital signs (weight, sugar, heart rate), personalized nutrition/exercise plans.
- **Parking finder**: Real-time car parking locator with GPS to free spots.
- **Container tracking**: Logistics app for real-time shipment/container status and location.

### Projects

| Slug | Name |
|------|------|
| tax-invoicing | Tax/Invoicing App |
| restaurant-booking | Restaurant Booking App (Web + Mobile) |
| expense-tracker | Expense Tracker App |
| todo-list | To-Do List App |
| online-teaching | Online Teaching Platform |
| ceo-dashboard | CEO Dashboard |
| employee-orientation | Employee Orientation App |

### Key Files

- `app/Http/Controllers/ProjectController.php`
- `resources/views/projects/index.blade.php`
- `resources/views/projects/show.blade.php`

---

## 📱 3. Mobile + Web Application Suite

### Implemented

- **Listing** (`/apps`): **Banner image** (utility-banner-1.png) with overlay + grid of app cards (icon + name). Flip-card hover effect. Fully functional.
- **Detail** (`/apps/{slug}`): App name, description, features, tech stack. Action buttons show **“Coming Soon”** (Live Demo, Download APK, Source Code) – pages unchanged.

### Apps Listed (21)

Fitness App, Language Learning, Car Parking, Chatbots, Docket Management, Mental Health, Payments App, Reservation Platform, YouTube Radio, Book Review App, CEO Dashboard, Employee Orientation, EV Charging Finder, Exam Study, Grocery Delivery, Health Inspector, Online Teaching, Cooking Suggestions, Container Tracking, Ebooks App, Freelancer Finance App.

### Key Files

- `app/Http/Controllers/AppController.php`
- `resources/views/apps/index.blade.php`
- `resources/views/apps/show.blade.php`

---

## 🖼️ 4. HTML Templates Section

### Implemented

- **Listing** (`/templates`): **Banner image** (utility-banner-3.png) with overlay + 4 template cards with preview placeholder, name, description, “Preview & Download”. Fully functional.
- **Detail** (`/templates/{slug}`): Template name, description, features, large preview area. Action buttons show **“Coming Soon”** (Live Preview, Download Template) – pages unchanged.

### Templates

| Slug | Name |
|------|------|
| business | Business Landing Pages |
| admin | Admin Dashboards |
| bootstrap | Bootstrap UI Kits |
| responsive | Responsive Web Pages |

### Key Files

- `app/Http/Controllers/TemplateController.php`
- `resources/views/templates/index.blade.php`
- `resources/views/templates/show.blade.php`

---

## 🎉 5. Fun & AI Video Section

### Implemented

- **Index** (`/ai-videos`): **Banner image** (utility-banner-2.png) with overlay + 4 cards. Card buttons: **“Coming Soon”** for AI Video Generator, Meme Generator, AI Caption/Story; **“Calculate”** for Love Calculator (working).
- **AI Video Generator** (`/ai-videos/generator`): Form (prompt, video type); submit button text **“Coming Soon”**; page and form unchanged.
- **Meme Generator** (`/ai-videos/meme-generator`): Form (top text, bottom text, template); submit button **“Coming Soon”**; page unchanged.
- **Love Calculator** (`/ai-videos/love-calculator`): Two names; JavaScript computes “love %” and message – **fully working**.
- **AI Caption/Story Generator** (`/ai-videos/caption-generator`): Form (topic, type); submit button **“Coming Soon”**; page unchanged.

### Target behavior (when APIs integrated)

- **AI Video Generator**: Short AI-generated videos (comedy, motivational) from text prompts; synchronized audio; prompt-to-video.
- **Meme Generator**: Pair templates with AI-generated or user captions; shareable output.
- **Caption/Story**: Prompt-based story/caption generator; instant content from user prompts.

### Key Files

- `app/Http/Controllers/AIVideoController.php`
- `resources/views/ai-videos/index.blade.php`
- `resources/views/ai-videos/generator.blade.php`
- `resources/views/ai-videos/meme-generator.blade.php`
- `resources/views/ai-videos/love-calculator.blade.php`
- `resources/views/ai-videos/caption-generator.blade.php`

---

## 📰 6. News & Market Updates Section

### Implemented

- **News** (`/news`): **Banner image** (utility-banner-1.png) with overlay + placeholder news cards (title, excerpt, category, date). Ready for API/embed feed — e.g. **NewsAPI** (or similar) for tech/startup headlines from many sources.
- **Market** (`/market`): **Banner image** (utility-banner-3.png) with overlay + Nifty 50 and Sensex cards with placeholder value/change. Ready for live API — e.g. embed **TradingView** (or similar) widgets for Nifty/Sensex, top gainers/losers, and live indices.

### Key Files

- `app/Http/Controllers/NewsController.php`
- `app/Http/Controllers/MarketController.php`
- `resources/views/news/index.blade.php`
- `resources/views/market/index.blade.php`

---

## 🧑‍💻 7. User Features & Role-Based Access

### Role-based auth

- **Users table**: `role` (default `user`), `access_rules` (nullable JSON). New registrations get `role = 'user'`.
- **Login redirect**: Admins → `/admin`; users → `/dashboard`.
- **User model**: `isAdmin()`, `canManage($section)` for admins; `access_rules === null` = full access, else only listed sections (tools, projects, apps, templates).
- **Middleware**: `role.admin` (EnsureRoleIsAdmin), `admin.section:tools` (EnsureAdminCanManageSection) – used on admin routes.

### User portal (full functional)

- **Dashboard** (`/dashboard`): Auth-only. Real data: stats (saved items count, distinct tools used, total tool usages), saved tools & bookmarked projects from DB, recent activity from `tool_histories`. Links to Usages and Analytics.
- **Usages** (`/dashboard/usages`): Paginated list of tool usage history (tool name, date, link to tool).
- **Analytics** (`/dashboard/analytics`): Total tool runs, distinct tools count, “most used tools” list with counts.
- **Tool usage logging**: When a logged-in user opens a tool page (`/tools/{slug}`), a row is added to `tool_histories` (user_id, tool_id, tool_slug).
- **Profile** (`/profile`): Auth-only profile view.
- **Roadmap**: **AI Content Center** — let users generate and save AI outputs (videos, resumes, essays) under their account; manage downloaded code/projects and preferences.

### Admin portal (full functional for Tools)

- **Admin dashboard** (`/admin`): Stats (tools count, users count, usages count); cards for each section the admin can manage (Tools, Projects, Apps, Templates) based on `access_rules`. Navbar shows “Admin” for admin users.
- **Tools CRUD** (`/admin/tools`): List, Create, Edit, Delete tools (name, slug, category, description, icon, is_active). Access only if admin has `tools` in `access_rules` or full access.
- **Projects / Apps / Templates** (`/admin/projects`, `/admin/apps`, `/admin/templates`): “Coming soon” placeholder pages; ready for future DB-backed CRUD.
- **Master Admin – Admin User Management** *(new – Feb 27)*: `is_master` flag on `users` table. Master admins access `/admin/admins` to list and create admin users (`AdminUserController`). Protected by `admin.master` middleware (`EnsureMasterAdmin`).

### Key Files

- `app/Http/Controllers/DashboardController.php` – dashboard, usages, analytics
- `app/Http/Controllers/Admin/DashboardController.php`, `Admin/ToolController.php`
- `app/Http/Controllers/Admin/AdminUserController.php` – index(), create(), store() *(new)*
- `app/Http/Middleware/EnsureRoleIsAdmin.php`, `EnsureAdminCanManageSection.php`, `EnsureMasterAdmin.php` *(new)*
- `app/Models/ToolHistory.php`, `SavedItem.php`; `User` (role, access_rules, is_master, isAdmin(), canManage())
- `database/migrations/*_add_is_master_to_users_table.php` – is_master column *(new)*
- `database/seeders/AdminSeeder.php` – seeds a default admin user *(new)*
- `resources/views/dashboard.blade.php`, `dashboard/usages.blade.php`, `dashboard/analytics.blade.php`
- `resources/views/layouts/admin.blade.php`, `layouts/user.blade.php` *(new)*, `admin/dashboard.blade.php`, `admin/tools/*.blade.php`
- `resources/views/admin/admins/index.blade.php`, `admin/admins/create.blade.php` *(new)*
- `resources/views/partials/navbar.blade.php` – Admin link when `auth()->user()->isAdmin()`
- `routes/web.php` – dashboard, usages, analytics, admin group with middleware, master-admin admins routes

---

## 🎨 8. UI/UX & Design

### Implemented

- **Layout**: Single main layout `layouts/app.blade.php` with navbar, main content, footer; viewport meta; Vite + Font Awesome. Main content uses `page-main` (standard pages, margin-top 76px for fixed navbar) or `page-main-hero` (homepage, full-viewport hero).
- **Navbar**: White, clean; links to Tools, Projects, Apps, Templates, AI Videos, News, Market; Login / Sign Up or Dashboard / Profile when auth. **Transparent on homepage hero** (`navbar-transparent`), **solid white with shadow on scroll** (`navbar-scrolled`) for better contrast.
- **Homepage**: **Full-screen hero** (3-image slider, utility-banner-1/2/3) with **deep gradient overlay**; **animated glassmorphism badge**; **gradient headline** (“Your Complete Tech Solution Hub”); **Ken Burns** effect on active slide; **inline stats bar** (32+ Tools, 7 Projects, 21 Apps, 4 Templates); CTA buttons (Explore Tools, Get Started Free); **stats strip** below hero with **animated counters**; sections with **numbered tags** (01–07), **gradient accent** on titles, **scroll-reveal** animations; new card styles (home-card, proj-card, app-pill, tpl-card, ai-card, nm-card, cta-card) with hover lift; **CTA section** with spinning rings visual and gradient highlight text.
- **Footer**: `.site-footer` — dark navy (#0f172a); TechHub blurb, Quick Links, Features, Connect (social); copyright; link hover to white.
- **Global style**: Light theme (white/light gray); primary blue (#2563eb); clean cards, spacing, rounded corners; responsive (mobile/tablet); enhanced card hover (translateY + shadow).
- **Sub-page banners**: **Shared partial** `partials/page-banner.blade.php` used on **Tools, Projects, Apps, Templates, AI Videos, News, Market**. Each banner: **deep directional overlay** (92% → 72% → 45%); **tag badge** with pulsing dot; **breadcrumb** (Home → Section); **title + subtitle** with strong text-shadow; **quick-nav pills** (section-specific links); **decorative icon** with orbit rings + float animation; **animated blobs**; **staggered entrance** animations; **per-page accent color** (e.g. blue Tools, green Projects, purple Templates, pink AI Videos).

### Banner Images (public/images)

| Image | Used on |
|-------|--------|
| utility-banner-1.png | Home slider, Apps, News |
| utility-banner-2.png | Home slider, Tools, AI Videos |
| utility-banner-3.png | Home slider, Templates, Market |
| projects-banner.png | Projects |

### Auth Pages (Login / Register)

- **Layout**: `layouts/guest.blade.php` — single centered form on white; top-right “X” back to home.
- **Design**: “Continue with Google” button, “or” divider with lines, EMAIL/PASSWORD inputs (light gray bg, black/transparent border), black “Log in” / “Create account” button, blue links (Use single sign-on, Reset password, No account? Create one).

### Key Files

- `resources/views/layouts/app.blade.php`
- `resources/views/layouts/guest.blade.php`
- `resources/views/partials/navbar.blade.php`
- `resources/views/partials/footer.blade.php`
- `resources/views/partials/page-banner.blade.php` — shared sub-page banner (Tools, Projects, Apps, Templates, AI Videos, News, Market)
- `resources/views/home.blade.php`
- `resources/views/livewire/pages/auth/login.blade.php`
- `resources/views/livewire/pages/auth/register.blade.php`
- `resources/css/app.css` — hero, sub-banner, navbar transparent/scrolled, section cards, footer, animations

---

## 🗄️ 9. Database & Migrations

### Migrations Present

- **users**: id, name, email, password, **role** (default `user`), **access_rules** (JSON nullable), **is_master** (bool, default false) *(new)*, email_verified_at, remember_token, timestamps
- cache, jobs, sessions (Laravel default)
- **tools**: id, name, slug, category, description, icon, is_active, timestamps
- **tool_histories**: id, **user_id**, **tool_slug**, **tool_id**, **metadata** (JSON nullable), timestamps
- **saved_items**: id, **user_id**, **item_type**, **item_slug**, timestamps
- **tool_jobs** *(new – Feb 27)*: id, slug (tool identifier), status (pending/running/done/failed), progress (int), input_paths (JSON), result_path, error_message, timestamps
- projects, templates (minimal schema as per migrations)

### Seeding

- **ToolSeeder**: Seeds **all implemented tools** from `ToolController::fullCatalog()` whose slug is in `implementedSlugs()` (updateOrCreate by slug). Covers Finance & Date (6), PDF & File (10), Text & Content (7), Developer (6), Image (3).
- **AdminSeeder** *(new)*: Seeds a default admin user.

```bash
php artisan db:seed --class=ToolSeeder
php artisan db:seed --class=AdminSeeder
```

---

## 📂 10. File Structure (Key Areas)

```
app/Http/Controllers/
├── ToolController.php              # fullCatalog(), implementedSlugs(), partialForSlug(), index(), show(), grammarCheck(), backgroundRemover()
├── PdfFileController.php           # zipCompressor(), pdfMerger(), splitPdf()
├── DashboardController.php         # __invoke (user dashboard), usages(), analytics()
├── Admin/DashboardController.php   # index() – admin dashboard, section cards
├── Admin/ToolController.php        # index(), create(), store(), edit(), update(), destroy()
├── Admin/AdminUserController.php   # index(), create(), store() – master admin manages admins [NEW]
├── Api/ToolJobController.php       # store() create job, show() poll status [NEW]
├── Api/EmiController.php           # calculate() EMI API
├── ProjectController.php           # index(), show(), getProjectBySlug()
├── AppController.php               # index(), show(), getAppBySlug()
├── TemplateController.php          # index(), show(), getTemplateBySlug()
├── AIVideoController.php           # index(), generator(), memeGenerator(), loveCalculator(), captionGenerator()
├── NewsController.php              # index()
└── MarketController.php            # index()

app/Http/Middleware/
├── EnsureRoleIsAdmin.php           # role.admin
├── EnsureAdminCanManageSection.php # admin.section:{section}
└── EnsureMasterAdmin.php           # admin.master [NEW]

app/Jobs/
└── ProcessToolJob.php              # doMerge(), doSplit(), doCompress(), doPdfToImage() [NEW]

app/Models/
└── ToolJob.php                     # status tracking with JSON casts [NEW]

resources/views/
├── layouts/app.blade.php
├── layouts/admin.blade.php              # Admin portal layout
├── layouts/user.blade.php               # User portal layout [NEW]
├── layouts/guest.blade.php              # Auth (login/register)
├── partials/navbar.blade.php            # + Admin link when isAdmin(); transparent on hero, solid on scroll
├── partials/footer.blade.php            # .site-footer dark navy
├── partials/page-banner.blade.php       # Shared sub-page banner (all 7 section pages)
├── home.blade.php                       # Full-screen hero + stats strip + section cards + scroll-reveal
├── dashboard.blade.php                  # User dashboard (real stats, saved, activity)
├── dashboard/usages.blade.php           # User tool usage history
├── dashboard/analytics.blade.php        # User analytics – most used tools
├── admin/dashboard.blade.php            # Admin dashboard + section cards
├── admin/tools/index, create, edit      # Admin tools CRUD
├── admin/admins/index.blade.php         # List admin users [NEW]
├── admin/admins/create.blade.php        # Create admin user form [NEW]
├── admin/coming-soon.blade.php          # Placeholder for Projects/Apps/Templates admin
├── tools/index.blade.php                # Shared page-banner; Open Tool / Coming Soon
├── tools/partials/calculator-shared-styles.blade.php  # Shared slider/chart styles [NEW]
├── projects/index.blade.php             # Shared page-banner
├── apps/index.blade.php                 # Shared page-banner
├── templates/index.blade.php            # Shared page-banner
├── ai-videos/index.blade.php            # Shared page-banner
├── news/index.blade.php                 # Shared page-banner
├── market/index.blade.php               # Shared page-banner
├── livewire/pages/auth/login.blade.php, register.blade.php
└── (tools/show, projects/show, apps/show, templates/show, ai-videos/*.blade.php)

resources/css/app.css       # Full site styles (layout, sections, cards, footer, responsive)
routes/web.php              # All web routes
routes/api.php              # API routes: /api/emi, /api/tools/{slug}, /api/jobs/{id}
```

---

## 📊 Current Status Summary

| Area | Status |
|------|--------|
| Homepage | ✅ Full-screen hero (strong overlay, badge, gradient title, Ken Burns, stats bar, scroll-reveal, stats strip with counters); navbar transparent → solid on scroll |
| **Sub-page banners** | ✅ Shared `partials/page-banner.blade.php` on all 7 section pages — deep overlay, tag badge, breadcrumb, pills, animated icon, per-page accent |
| Utility Tools | ✅ Improved banner; full catalog; **33 tools implemented** (Finance, PDF & File, Text & Content, Developer, Image); **JSON Formatter** = JSON Studio (wide layout, Pretty/Tree/Raw); “Open Tool” / “Coming Soon” by DB |
| **Finance Calculators** | ✅ EMI & SIP redesigned with shared styles + sliders + Chart.js; **FD/RD fully rebuilt** (Feb 27) with FD/RD tabs, interactive sliders, Chart.js |
| **PDF Tools (async)** | ✅ PDF Merge, Split, Compress, PDF-to-Image now use **async job queue** (AJAX → ToolJob → queue worker → status poll → download) |
| Projects | ✅ Shared banner; 7 projects, list + detail; action buttons “Coming Soon” |
| Apps | ✅ Shared banner; 21 apps, list + detail; action buttons “Coming Soon” |
| Templates | ✅ Shared banner; 4 templates, list + detail; action buttons “Coming Soon” |
| AI Videos | ✅ Shared banner; 4 tools; Love Calculator working; others “Coming Soon” button text |
| News & Market | ✅ Shared banner; placeholder content; ready for API/embed |
| **User portal** | ✅ Dashboard (real stats, saved items, recent activity), Usages, Analytics; tool usage logged when auth |
| **Admin portal** | ✅ Role-based; dashboard + Tools CRUD; **Master Admin** can manage admin users (`/admin/admins`); Projects/Apps/Templates admin “coming soon” |
| **Auth** | ✅ Role-based (user/admin/master); login redirect by role; access_rules for admin sections; Register = user |
| **API** | ✅ `POST /api/tools/{slug}` create job; `GET /api/jobs/{id}` poll status; `POST /api/emi` EMI calc |
| UI/UX | ✅ Light theme, responsive; hero + shared sub-page banners; navbar transparent/solid; scroll-reveal; footer dark navy |

---

## 🚀 Suggested Next Enhancements

- **Tools**: Lock/Unlock PDF (qpdf wrapper); PDF to Word/Excel (LibreOffice or cloud API).
- Add search/filter on `/tools` (e.g. by category or name).
- **News**: Integrate NewsAPI (or similar) for tech/startup news feed.
- **Market**: Embed TradingView (or similar) widgets for Nifty/Sensex, top gainers/losers, live indices.
- **Save/Bookmark UI**: Add “Save” / “Bookmark” buttons on tool and project pages that create/delete `saved_items` (backend and DB ready).
- **AI Content Center**: Let users generate and save AI outputs (videos, resumes, essays) under their account.
- **Project ideas**: AI Mental Health Companion; Virtual Study Group (collaborative study, exam prep).
- **Admin**: DB-backed CRUD for Projects, Apps, Templates (migrations + admin views).
- AI Video / Meme / Caption: integrate external APIs (prompt-to-video, synchronized audio; meme templates + captions; prompt-based story generator).
- **Queue worker**: Set up `php artisan queue:work` as a supervised daemon in production (Supervisor / systemd).
- Optional: Paid tools or subscriptions; manage downloaded code/projects and user preferences.

---

## 🏁 Summary

TechHub is a **full-featured Laravel application** with:

- **7 main sections** (Tools, Projects, Apps, Templates, AI Videos, News, Market); **each section uses the shared sub-page banner** (`partials/page-banner.blade.php`) with deep overlay, tag badge, breadcrumb, quick-nav pills, and per-page accent. Listings and detail pages are fully functional; unwired actions show “Coming Soon”.
- **Homepage**: Full-screen hero (3-image slider, Ken Burns), glassmorphism badge, gradient headline, stats bar, stats strip with animated counters, scroll-reveal sections, CTA with spinning rings. Navbar is transparent over hero and solid on scroll.
- **Utility tools**: **35+ in catalog**, **33 implemented** and seeded (Finance, PDF & File, Text & Content, Developer, Image). **JSON Formatter** is a full “JSON Studio” (input/output panels, Pretty/Tree/Raw, toolbar, wide layout). Tools index shows “Open Tool” or “Coming Soon” per tool.
- **Finance Calculators** *(updated Feb 27)*: EMI and SIP redesigned with shared slider styles and Chart.js visualization. FD/RD Calculator **completely rebuilt** with separate FD/RD tabs, interactive sliders, real-time Chart.js bar chart.
- **PDF Tools** *(updated Feb 27)*: Merge, Split, Compress PDF, PDF-to-Image converted to **async job queue architecture** (AJAX upload → ToolJob model → Laravel queue worker → status polling → download link).
- **Projects** (7), **Apps** (21), **Templates** (4): List + detail pages; Demo/Download/Source buttons show “Coming Soon”.
- **AI Videos**: Love Calculator working; AI Video Generator, Meme Generator, Caption Generator show “Coming Soon” on cards/buttons; pages unchanged.
- **Role-based auth**: Users have `role` (user/admin) and `is_master` flag. Register creates `user`; login redirects admins to `/admin`, users to `/dashboard`.
- **User portal**: Dashboard with **real data** (saved count, tools used, total usages, saved tools/projects, recent activity); **Usages** (paginated tool history); **Analytics** (most used tools).
- **Admin portal**: Dashboard (stats + section cards by access); **Tools CRUD** (list, create, edit, delete); **Master Admin** can manage admin users (`/admin/admins`); Projects/Apps/Templates admin “coming soon”.
- **REST API** *(new Feb 27)*: `POST /api/tools/{slug}` (create job), `GET /api/jobs/{id}` (poll status), `POST /api/emi` (EMI calc).
- **Auth UI**: Login/Register (centered form, “Continue with Google”, “or” divider, black button, blue links).
- **Clean, responsive UI** (light theme, shared banners, hero + scroll-reveal, footer). **Documented** in this file.

Suitable for portfolio, interviews, MVP, or extending into a full product.

---

*Last updated: Mar 1, 2026*
