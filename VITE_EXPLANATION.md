# Why CSS Loads Without `npm run dev` - Laravel Vite Explanation

## How Laravel's `@vite()` Directive Works

When you use `@vite(['resources/css/app.css', 'resources/js/app.js'])` in your Blade templates, Laravel checks for assets in this order:

### 1. **Development Mode** (Vite Dev Server Running)
   - Checks if `public/hot` file exists
   - If yes → Connects to Vite dev server (usually `http://localhost:5173`)
   - Assets are served **hot-reloaded** from the dev server
   - **Requires**: `npm run dev` to be running

### 2. **Production Mode** (Pre-built Assets)
   - Checks if `public/build/manifest.json` exists
   - If yes → Serves **pre-built** assets from `public/build` directory
   - Assets are **static files** (already compiled)
   - **Requires**: `npm run build` to be run first

### 3. **Error State**
   - If neither exists → Laravel throws an error
   - Assets won't load

## Why Your CSS is Loading

Your CSS is loading because you likely have **pre-built assets** in `public/build/` directory from a previous `npm run build` command.

### Check Your Current State:

```bash
# Check if build directory exists
ls -la public/build/

# Check if hot file exists (dev server running)
cat public/hot
```

## Two Ways to Serve Assets

### Option 1: Development Mode (Hot Reload)
```bash
# Terminal 1: Start Laravel server
php artisan serve

# Terminal 2: Start Vite dev server
npm run dev
```

**Benefits:**
- ✅ Hot module replacement (instant CSS/JS updates)
- ✅ No need to rebuild after changes
- ✅ Faster development workflow

**How it works:**
- Vite dev server runs on port 5173
- Laravel detects `public/hot` file
- Assets are proxied through Vite dev server

### Option 2: Production Build (Static Files)
```bash
# Build assets once
npm run build

# Then just run Laravel
php artisan serve
```

**Benefits:**
- ✅ No need to run Vite dev server
- ✅ Faster page loads (optimized assets)
- ✅ Production-ready

**How it works:**
- Assets are compiled and minified
- Stored in `public/build/` directory
- Laravel serves them directly

## Current Situation

Since your CSS is loading without `npm run dev`, you have **Option 2** active:
- ✅ `public/build/manifest.json` exists
- ✅ Pre-built assets are being served
- ❌ No hot reload (need to rebuild after CSS changes)

## Recommendation

### For Development:
Always use `npm run dev` for:
- Instant CSS/JS updates
- Better development experience
- No need to rebuild after every change

### For Production:
Use `npm run build` before deploying:
- Optimized and minified assets
- Better performance
- No dev server needed

## Quick Commands

```bash
# Development (with hot reload)
npm run dev

# Production build
npm run build

# Check what's active
# If public/hot exists → Dev mode
# If public/build/manifest.json exists → Production mode
```

## Troubleshooting

If assets stop loading:
1. Check if `public/build/manifest.json` exists
2. Check if `public/hot` exists (and Vite server is running)
3. Run `npm run build` to create production assets
4. Or run `npm run dev` to start dev server
