## Nexora Tools Laravel – Migration Notes

This file documents what has been implemented so far in `nexora-tools-laravel` to mirror the old `nexora-tools` project, and how it was done.

---

### 1. Site Layout (`layouts.site`)

- **File**: `resources/views/layouts/site.blade.php`
- **What**:
  - New public layout that provides:
    - Top navbar with logo, category mega-menu, login/sign‑up buttons.
    - Side plugin for search and theme toggle.
    - Unified footer with popular tools, categories, company links.
    - Light/dark theme switch based on `localStorage` and system preference.
  - Page‑level meta variables injected at the top (`$pageTitle`, `$pageDesc`, `$pageKeywords`, `$canonical`, `$baseUrl`).
  - Global JS variables:
    - `window.NEXORA_TOOLS` – JSON‑encoded list of tools from config.
    - `window.BASE_URL` – base URL used by front‑end JS.
- **How**:
  - Uses `config('nexora.site')`, `config('nexora.categories')`, and `config('nexora.tools')` to build nav/mega menus.
  - Injects CSS/JS:
    - `public/assets/css/style.css` for the main marketing design.
    - Font: Google `Inter`.
    - Font Awesome 6.4.
    - `public/assets/js/app.js` for search, theme toggle, news/market widgets, etc.
  - Added Blade stacks:
    - `@stack('styles')` inside `<head>`.
    - `@stack('scripts')` before `</body>`.
    - This allows individual tool pages (e.g. EMI calculator) to push extra styles/scripts.

---

### 2. Tool Catalog Config (`config/nexora.php`)

- **File**: `config/nexora.php`
- **What**:
  - Configuration‑driven definition of:
    - Site metadata (`name`, `tagline`, `desc`, `domain`, `email`, `company`).
    - Categories (`dev`, `pdf`, `text`, `image`, `seo`, `finance`, `ai`) with name, icon, brand color, background color.
    - Flat list of tools (slug, name, description, category, icon, and flags `popular`, `new`).
- **How**:
  - Replaces DB lookup for tools/categories with a static array mirroring the old project’s categories and slugs.
  - Used by:
    - `App\Services\ToolCatalog` (`tools()`, `categories()`, `toolsByCategory()`, `popularTools()`, `findTool()`).
    - `HomeController`, `ToolsController`, `CategoryController`, `ToolPageController`.

---

### 3. Home Page (`/`)

- **File**: `resources/views/pages/home.blade.php`
- **What**:
  - New marketing‑style homepage that:
    - Shows hero section with search, stats, and highlight “Your Complete Tech Solution Hub”.
    - Lists “Popular Tools”.
    - “Browse by Category” cards.
    - “All tools” grid with category tabs (All + each category).
    - Live markets and news skeleton sections.
    - CTA banner at bottom.
- **How**:
  - Data from `ToolCatalog`:
    - `$tools`, `$popular`, `$categories`, `$toolsByCat`.
  - All links resolved to:
    - `/tools/{slug}` for individual tools.
    - `/{categorySlug}` for category pages.
  - Uses only the new static config (`config('nexora.*')`), not the old DB models.

> Note: This design is **not** the same as the original `home.blade.php` from the old project; it is a new “v2” marketing homepage.

---

### 4. Tools Index (`/tools`)

- **File**: `resources/views/pages/tools.blade.php`
- **What**:
  - Lists all tools in a grid, with:
    - Text filter input.
    - Category tabs (All + each category).
  - Each card shows icon, name, description, and badges (`Popular`, `New`).
- **How**:
  - Powered by `Site\ToolsController@index` + `ToolCatalog`.
  - Client‑side filtering via a small inline `<script>` that hides/shows cards based on `data-name` and `data-desc` attributes.

---

### 5. Category Pages (`/{category}`)

- **Routes**: `/{category}` and `/{category}-tools` in `routes/web.php`
- **Controllers/Views**:
  - `Site\CategoryController@show`
  - `resources/views/pages/category.blade.php`
- **What**:
  - Category landing pages that show:
    - Category metadata (icon, colors).
    - List of tools in that category.
    - CTA link back to `/tools`.
- **How**:
  - Categories validated via `whereIn('category', array_keys(config('nexora.categories', [])))`.
  - Legacy `/{category}-tools` URLs 301‑redirect to the canonical `/{category}` route.

---

### 6. Tool Catalog Service (`App\Services\ToolCatalog`)

- **File**: `app/Services/ToolCatalog.php`
- **What**:
  - Thin service wrapper over `config('nexora')` for:
    - Getting all tools.
    - Getting all categories.
    - Filtering tools by category.
    - Selecting popular tools.
    - Finding a tool by slug.
- **How**:
  - Pure PHP array operations (`array_filter`, `array_values`, `array_slice`).
  - Used by:
    - `HomeController`
    - `ToolsController`
    - `CategoryController`
    - `ToolPageController`

---

### 7. Tool Pages Routing (`Site\ToolPageController`)

- **File**: `app/Http/Controllers/Site/ToolPageController.php`
- **What**:
  - Handles `/tools/{slug}` for the **config‑defined** tools only (not DB‑backed like the old project).
  - Current explicit mapping:
    - `json-formatter` → `resources/views/tools/json-formatter.blade.php`
    - `password-generator` → `resources/views/tools/password-generator.blade.php`
    - `emi-calculator` → `resources/views/tools/emi-calculator.blade.php`
- **How**:
  - Looks up tool definition via `ToolCatalog::findTool($slug)`.
  - If tool is not defined in config, responds with 404.
  - For unknown or unimplemented slugs (without a dedicated view), currently aborts 404 rather than falling back to a generic wrapper.

> Important: This is intentionally conservative to avoid breaking pages while porting tools incrementally. Only listed slugs are active in this controller at the moment.

---

### 8. JSON Formatter Tool (new implementation, not legacy)

- **File**: `resources/views/tools/json-formatter.blade.php`
- **What**:
  - Fully client‑side JSON formatter/validator with:
    - Side‑by‑side input/output panels.
    - Buttons: Format, Minify, Clear, Sample, Copy.
    - Status indicator (valid/invalid).
- **How**:
  - Extends `layouts.site`.
  - Uses page‑local `<script>` for JSON parsing/formatting and keybindings (`Ctrl+Enter`).
  - Does **not** use the old `tools.show` + partial system from the original app; it is a standalone Blade page.

---

### 9. Password Generator Tool (placeholder)

- **File**: `resources/views/tools/password-generator.blade.php`
- **What**:
  - Currently a placeholder page describing the intended behavior; real UI is **not** implemented yet.
- **How**:
  - Extends `layouts.site`.
  - Linked via `ToolPageController` for the `password-generator` slug.

---

### 10. EMI Calculator Tool (`/tools/emi-calculator`)

- **Files**:
  - Page wrapper: `resources/views/tools/emi-calculator.blade.php`
  - Partial: `resources/views/tools/partials/emi-calculator.blade.php`
  - Shared calc styles: `resources/views/tools/partials/calculator-shared-styles.blade.php`
- **What**:
  - Port of the old EMI calculator:
    - Sliders for loan amount, rate, tenure.
    - Editable numeric inputs synchronized with sliders.
    - Summary cards: EMI, principal, interest, total, payoff date, interest %.
    - Donut and bar charts (Chart.js) for principal vs interest.
    - Lump‑sum prepayment simulator (with comparison and bar chart).
    - Amortization schedule with year rows and expandable monthly tables.
- **How**:
  - Page:
    - Extends `layouts.site`.
    - Renders a sub‑banner and includes the partial.
  - Partial:
    - Markup copied and adapted from the old EMI partial.
    - Uses Bootstrap‑style classes (`row`, `col-*`, `form-control`, `btn`, etc.) so it visually matches the old app once `app.css` is loaded.
    - Pushes extra styles with `@push('styles')`.
    - Pushes logic via `@push('scripts')`:
      - Loads Chart.js from CDN.
      - Contains a self‑invoking JS function implementing EMI, prepayment, and amortization calculations.
  - Shared styles:
    - Provides generic slider + summary card styles reused by finance calculators.
    - Also pushed through the `styles` stack.

---

### 11. Auth Layout and Login Page (ported look)

- **Files**:
  - Layout: `resources/views/layouts/guest.blade.php`
  - Login view: `resources/views/auth/login.blade.php`
- **What**:
  - Recreated the dark modal login UI from the old project.
  - Still uses standard Laravel authentication routes and logic.
- **How**:
  - `layouts.guest`:
    - Now mirrors the old `auth-page` shell:
      - Full‑screen dark background (`auth-page auth-page--dark`).
      - Centered auth box (`auth-form-box`).
      - Close button top‑left that links back to `/`.
      - Includes Font Awesome and `@vite` for `resources/css/app.css` + `resources/js/app.js`.
  - `auth/login.blade.php`:
    - Extends `layouts.guest` and sets `@section('title', 'Login')`.
    - Markup based on old Livewire login:
      - “Welcome! Please login…” heading and subtitle.
      - Google button (non‑functional placeholder).
      - Divider “or”.
      - Ribbon‑style email/password fields using existing Blade components.
      - Remember‑me checkbox + “Forgot your password?” link.
      - Full‑width “Log in” button using `<x-primary-button>`.
      - Footer links: single sign‑on, reset password, create account + credit line.
    - Form posts to `route('login')` and uses the built‑in Breeze controllers/middleware for actual authentication.

---

### 12. Stacks and Integration Points

- **`@stack('styles')`**:
  - Defined in `layouts.site` `<head>`.
  - Used by:
    - `tools/partials/calculator-shared-styles.blade.php`
    - `tools/partials/emi-calculator.blade.php`
- **`@stack('scripts')`**:
  - Defined before `</body>` in `layouts.site`.
  - Used by:
    - `tools/partials/emi-calculator.blade.php` (Chart.js + EMI logic).

These stacks are the main hook points for tool‑specific CSS/JS so tools can be ported from the old project without modifying the core layout every time.

---

### 13. What Has **Not** Been Ported Yet

- Old project pieces that are **not** present or wired up in `nexora-tools-laravel`:
  - Generic `tools.show` wrapper + DB‑backed `ToolController`, `Tool` model, saved‑items, etc.
  - Other tool partials (PDF tools, text tools, all remaining dev and finance tools).
  - Old home sections for projects, apps, templates, AI videos, and admin dashboards.
  - Old admin layout and login routing logic (role checks, dashboards, etc.).

These will need to be migrated explicitly, one by one, if you want full parity with the original project.

