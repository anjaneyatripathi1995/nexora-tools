<?php
/**
 * Nexora Tools — Global Header
 * Usage: require ROOT . '/includes/header.php';
 *        Set $page_title, $page_desc, $page_keywords before including.
 */
$page_title    = $page_title    ?? SITE_NAME;
$page_desc     = $page_desc     ?? SITE_DESC;
$page_keywords = $page_keywords ?? 'online tools, free tools, pdf tools, seo tools, developer tools, nexora';
$canonical     = $canonical     ?? BASE_URL . ltrim($route ?? '', '/');
?>
<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($page_title) ?> — <?= SITE_NAME ?></title>
    <meta name="description" content="<?= e($page_desc) ?>">
    <meta name="keywords" content="<?= e($page_keywords) ?>">
    <meta name="author" content="<?= SITE_COMPANY ?>">
    <link rel="canonical" href="<?= e($canonical) ?>">

    <!-- Open Graph -->
    <meta property="og:title"       content="<?= e($page_title) ?> — <?= SITE_NAME ?>">
    <meta property="og:description" content="<?= e($page_desc) ?>">
    <meta property="og:url"         content="<?= e($canonical) ?>">
    <meta property="og:type"        content="website">
    <meta property="og:site_name"   content="<?= SITE_NAME ?>">

    <!-- Twitter Card -->
    <meta name="twitter:card"        content="summary_large_image">
    <meta name="twitter:title"       content="<?= e($page_title) ?> — <?= SITE_NAME ?>">
    <meta name="twitter:description" content="<?= e($page_desc) ?>">

    <!-- Favicon -->
    <link rel="icon" type="image/svg+xml" href="<?= BASE_URL ?>assets/images/favicon.svg">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Main Stylesheet -->
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/style.css?v=<?= APP_VERSION ?>">
</head>
<body>

<!-- ─── NAVBAR ─────────────────────────────────────────────────────────────── -->
<nav class="navbar" id="navbar">
    <div class="nav-inner">

        <!-- Logo -->
        <a href="<?= BASE_URL ?>" class="nav-logo">
            <span class="nav-logo-icon">N</span>
            <span class="nav-logo-text">
                <span class="logo-nexora">Nexora</span>
                <span class="logo-badge">Tools</span>
            </span>
        </a>

        <!-- Desktop Navigation -->
        <ul class="nav-links" id="navLinks">
            <li><a href="<?= BASE_URL ?>tools" class="nav-link <?= ($route ?? '') === 'tools' ? 'active' : '' ?>">All Tools</a></li>
            <?php foreach (CATEGORIES as $slug => $cat): ?>
            <li class="nav-dropdown">
                <a href="<?= BASE_URL ?><?= $slug ?>" class="nav-link">
                    <?= $cat['icon'] ?> <?= $cat['name'] ?>
                    <svg class="chevron" width="12" height="12" viewBox="0 0 12 12"><path d="M2 4l4 4 4-4" stroke="currentColor" stroke-width="1.5" fill="none" stroke-linecap="round"/></svg>
                </a>
                <div class="dropdown-menu">
                    <?php foreach (tools_by_cat($slug) as $t): ?>
                    <a href="<?= BASE_URL . e($t['slug']) ?>" class="dropdown-item">
                        <span class="dd-icon" style="background:<?= cat_bg($t['cat']) ?>;color:<?= cat_color($t['cat']) ?>"><?= e($t['icon']) ?></span>
                        <span><?= e($t['name']) ?></span>
                    </a>
                    <?php endforeach; ?>
                </div>
            </li>
            <?php endforeach; ?>
            <li><a href="<?= BASE_URL ?>about"   class="nav-link <?= ($route ?? '') === 'about'   ? 'active' : '' ?>">About</a></li>
            <li><a href="<?= BASE_URL ?>contact" class="nav-link <?= ($route ?? '') === 'contact' ? 'active' : '' ?>">Contact</a></li>
        </ul>

        <!-- Right Actions -->
        <div class="nav-actions">
            <!-- Search -->
            <button class="nav-icon-btn" id="searchToggle" title="Search tools" aria-label="Search">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
            </button>

            <!-- Theme Toggle -->
            <button class="nav-icon-btn theme-toggle" id="themeToggle" title="Toggle theme" aria-label="Toggle dark mode">
                <svg class="icon-sun" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="5"/><line x1="12" y1="1" x2="12" y2="3"/><line x1="12" y1="21" x2="12" y2="23"/><line x1="4.22" y1="4.22" x2="5.64" y2="5.64"/><line x1="18.36" y1="18.36" x2="19.78" y2="19.78"/><line x1="1" y1="12" x2="3" y2="12"/><line x1="21" y1="12" x2="23" y2="12"/><line x1="4.22" y1="19.78" x2="5.64" y2="18.36"/><line x1="18.36" y1="5.64" x2="19.78" y2="4.22"/></svg>
                <svg class="icon-moon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"/></svg>
            </button>

            <a href="#" class="btn btn-ghost">Login</a>
            <a href="#" class="btn btn-primary">Sign Up</a>

            <!-- Hamburger -->
            <button class="hamburger" id="hamburger" aria-label="Menu">
                <span></span><span></span><span></span>
            </button>
        </div>

    </div>
</nav>

<!-- ─── SEARCH OVERLAY ──────────────────────────────────────────────────────── -->
<div class="search-overlay" id="searchOverlay">
    <div class="search-overlay-inner">
        <div class="search-overlay-box">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
            <input type="text" class="search-overlay-input" id="searchInput" placeholder="Search 40+ tools... (e.g. PDF to Word, Password Generator)" autocomplete="off">
            <button class="search-close" id="searchClose" aria-label="Close">✕</button>
        </div>
        <div class="search-results" id="searchResults"></div>
    </div>
</div>
<div class="search-backdrop" id="searchBackdrop"></div>

<!-- ─── PAGE CONTENT ────────────────────────────────────────────────────────── -->
<main class="main-content">
