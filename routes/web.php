<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ToolController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\AppController;
use App\Http\Controllers\TemplateController;
use App\Http\Controllers\AIVideoController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\MarketController;
use App\Http\Controllers\PdfFileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\ToolController as AdminToolController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\SavedItemController;
use App\Http\Controllers\HomeController;

// Homepage
Route::get('/', [HomeController::class, 'index'])->name('home');

// Tools
Route::get('/tools', [ToolController::class, 'index'])->name('tools.index');
Route::post('/tools/process/zip-compressor', [PdfFileController::class, 'zipCompressor'])->name('tools.process.zip-compressor');
Route::post('/tools/process/pdf-merger', [PdfFileController::class, 'pdfMerger'])->name('tools.process.pdf-merger');
Route::post('/tools/process/split-pdf', [PdfFileController::class, 'splitPdf'])->name('tools.process.split-pdf');
Route::post('/tools/process/grammar-check', [ToolController::class, 'grammarCheck'])->name('tools.process.grammar-check');
Route::post('/tools/process/background-remover', [ToolController::class, 'backgroundRemover'])->name('tools.process.background-remover');
Route::get('/tools/{slug}', [ToolController::class, 'show'])->name('tools.show');

// Projects
Route::get('/projects', [ProjectController::class, 'index'])->name('projects.index');
Route::get('/projects/{slug}', [ProjectController::class, 'show'])->name('projects.show');

// Apps
Route::get('/apps', [AppController::class, 'index'])->name('apps.index');
Route::get('/apps/{slug}', [AppController::class, 'show'])->name('apps.show');

// Templates
Route::get('/templates', [TemplateController::class, 'index'])->name('templates.index');
Route::get('/templates/{slug}', [TemplateController::class, 'show'])->name('templates.show');

// AI Videos
Route::get('/ai-videos', [AIVideoController::class, 'index'])->name('ai-videos.index');
Route::get('/ai-videos/generator', [AIVideoController::class, 'generator'])->name('ai-videos.generator');
Route::get('/ai-videos/meme-generator', [AIVideoController::class, 'memeGenerator'])->name('ai-videos.meme-generator');
Route::get('/ai-videos/love-calculator', [AIVideoController::class, 'loveCalculator'])->name('ai-videos.love-calculator');
Route::get('/ai-videos/caption-generator', [AIVideoController::class, 'captionGenerator'])->name('ai-videos.caption-generator');

// News & Market
Route::get('/news', [NewsController::class, 'index'])->name('news.index');
Route::get('/market', [MarketController::class, 'index'])->name('market.index');

// Save / Bookmark (auth)
Route::post('saved-items/toggle', [SavedItemController::class, 'toggle'])
    ->middleware(['auth'])
    ->name('saved-items.toggle');

// User portal (auth)
Route::get('dashboard', DashboardController::class)
    ->middleware(['auth', 'verified'])
    ->name('dashboard');
Route::get('dashboard/usages', [DashboardController::class, 'usages'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard.usages');
Route::get('dashboard/analytics', [DashboardController::class, 'analytics'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard.analytics');

// Admin portal (auth + role admin; section access via access_rules)
Route::prefix('admin')->name('admin.')->middleware(['auth', 'role.admin'])->group(function () {
    Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::middleware('admin.section:tools')->resource('tools', AdminToolController::class)->except('show');
    Route::get('projects', function () { return view('admin.coming-soon', ['section' => 'Projects']); })->name('projects.index')->middleware('admin.section:projects');
    Route::get('apps', function () { return view('admin.coming-soon', ['section' => 'Apps']); })->name('apps.index')->middleware('admin.section:apps');
    Route::get('templates', function () { return view('admin.coming-soon', ['section' => 'Templates']); })->name('templates.index')->middleware('admin.section:templates');
    Route::middleware('admin.master')->group(function () {
        Route::get('admins', [AdminUserController::class, 'index'])->name('admins.index');
        Route::get('admins/create', [AdminUserController::class, 'create'])->name('admins.create');
        Route::post('admins', [AdminUserController::class, 'store'])->name('admins.store');
    });
});

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__.'/auth.php';
