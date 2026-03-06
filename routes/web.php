<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Site\HomeController;
use App\Http\Controllers\Site\ToolsController;
use App\Http\Controllers\Site\CategoryController;
use App\Http\Controllers\Site\StaticPageController;
use App\Http\Controllers\Site\ToolPageController;
use App\Http\Controllers\Api\NewsProxyController;
use App\Http\Controllers\Api\StocksProxyController;
use App\Http\Controllers\Api\ToolProcessController;
use App\Http\Controllers\Api\PdfFileController as ApiPdfFileController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Site\SitemapController;

Route::get('/favicon.ico', function () {
    return response()->file(public_path('assets/images/favicon.svg'), ['Content-Type' => 'image/svg+xml']);
})->name('favicon');

Route::get('/robots.txt', [SitemapController::class, 'robots'])->name('robots');
Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('sitemap');

// API proxies (legacy endpoints used by front-end JS)
Route::get('/api/news.php', NewsProxyController::class)->name('api.news');
Route::get('/api/stocks.php', StocksProxyController::class)->name('api.stocks');

// Static / company pages
Route::get('/', HomeController::class)->name('home');
Route::get('/tools', [ToolsController::class, 'index'])->name('tools.index');

Route::get('/about', [StaticPageController::class, 'about'])->name('about');
Route::match(['get', 'post'], '/contact', [StaticPageController::class, 'contact'])->name('contact');
Route::get('/privacy', [StaticPageController::class, 'privacy'])->name('privacy');
Route::get('/terms', [StaticPageController::class, 'terms'])->name('terms');

// Categories (legacy supports both /{cat} and /{cat}-tools)
Route::get('/{category}', [CategoryController::class, 'show'])
    ->whereIn('category', array_keys(config('nexora.categories', [])))
    ->name('categories.show');

Route::get('/{category}-tools', function (string $category) {
    return redirect()->route('categories.show', ['category' => $category]);
})->whereIn('category', array_keys(config('nexora.categories', [])));

// Tool process endpoints (used by tool partials)
Route::post('/tools/process/zip-compressor', [ApiPdfFileController::class, 'zipCompressor'])->name('tools.process.zip-compressor');
Route::post('/tools/process/grammar-check', [ToolProcessController::class, 'grammarCheck'])->name('tools.process.grammar-check');
Route::post('/tools/process/background-remover', [ToolProcessController::class, 'backgroundRemover'])->name('tools.process.background-remover');

// Saved items (auth)
Route::post('/saved-items/toggle', [\App\Http\Controllers\SavedItemController::class, 'toggle'])
    ->middleware('auth')
    ->name('saved-items.toggle');

// Tool pages
Route::get('/tools/{slug}', [ToolPageController::class, 'show'])->name('tools.show');

// Legacy root tool URLs (redirect to /tools/{slug})
Route::get('/json-formatter', fn () => redirect()->route('tools.show', ['slug' => 'json-formatter']));
Route::get('/password-generator', fn () => redirect()->route('tools.show', ['slug' => 'password-generator']));

// Dashboard (auth + verified)
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', DashboardController::class)->name('dashboard');
    Route::get('/dashboard/usages', [DashboardController::class, 'usages'])->name('dashboard.usages');
    Route::get('/dashboard/analytics', [DashboardController::class, 'analytics'])->name('dashboard.analytics');
});

// Profile (auth)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
