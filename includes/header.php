<?php
/**
 * Nexora Tools — Global Header
 */
$page_title    = $page_title    ?? SITE_NAME;
$page_desc     = $page_desc     ?? SITE_DESC;
$page_keywords = $page_keywords ?? 'online tools, free tools, pdf tools, seo tools, developer tools';
$canonical     = $canonical     ?? BASE_URL . ltrim($route ?? '', '/');
?>
<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($page_title) ?> — <?= SITE_NAME ?></title>
    <meta name="description"  content="<?= e($page_desc) ?>">
    <meta name="keywords"     content="<?= e($page_keywords) ?>">
    <meta name="author"       content="<?= SITE_COMPANY ?>">
    <link rel="canonical"     href="<?= e($canonical) ?>">
    <meta property="og:title"       content="<?= e($page_title) ?> — <?= SITE_NAME ?>">
    <meta property="og:description" content="<?= e($page_desc) ?>">
    <meta property="og:url"         content="<?= e($canonical) ?>">
    <meta property="og:type"        content="website">
    <meta property="og:site_name"   content="<?= SITE_NAME ?>">
    <meta name="twitter:card"       content="summary_large_image">

    <link rel="icon" type="image/svg+xml" href="<?= BASE_URL ?>assets/images/favicon.svg">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/style.css?v=<?= APP_VERSION ?>">

    <!-- Apply saved theme before paint to prevent dark-mode flash -->
    <script>
    (function(){
        var t=localStorage.getItem('nexora-theme');
        if(!t&&window.matchMedia('(prefers-color-scheme:dark)').matches)t='dark';
        if(t)document.documentElement.setAttribute('data-theme',t);
    })();
    </script>
</head>
<body>

<!-- ─── NAVBAR ──────────────────────────────────────────────────────────────── -->
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

        <!-- Desktop Nav -->
        <ul class="nav-links" id="navLinks">

            <!-- ALL TOOLS — mega dropdown showing every category -->
            <li class="nav-dropdown has-mega">
                <a href="<?= BASE_URL ?>tools" class="nav-link <?= ($route ?? '') === 'tools' ? 'active' : '' ?>">
                    🛠 All Tools
                    <svg class="chevron" width="12" height="12" viewBox="0 0 12 12"><path d="M2 4l4 4 4-4" stroke="currentColor" stroke-width="1.5" fill="none" stroke-linecap="round"/></svg>
                </a>
                <div class="mega-menu" id="megaMenu">
                    <div class="mega-grid">
                        <?php foreach (CATEGORIES as $slug => $cat):
                            $cat_tools = array_slice(array_values(tools_by_cat($slug)), 0, 5);
                            $total_cat = count(tools_by_cat($slug));
                        ?>
                        <div class="mega-col">
                            <div class="mega-col-head">
                                <span class="mega-cat-icon" style="background:<?= $cat['bg'] ?>;color:<?= $cat['color'] ?>"><?= $cat['icon'] ?></span>
                                <div>
                                    <a href="<?= BASE_URL . $slug ?>" class="mega-cat-name"><?= $cat['name'] ?></a>
                                    <span class="mega-cat-count" style="color:<?= $cat['color'] ?>"><?= $total_cat ?> tools</span>
                                </div>
                            </div>
                            <ul class="mega-tool-list">
                                <?php foreach ($cat_tools as $t): ?>
                                <li>
                                    <a href="<?= BASE_URL . e($t['slug']) ?>" class="mega-tool-item">
                                        <span class="mega-tool-emoji"><?= e($t['icon']) ?></span>
                                        <span><?= e($t['name']) ?></span>
                                    </a>
                                </li>
                                <?php endforeach; ?>
                            </ul>
                            <a href="<?= BASE_URL . $slug ?>" class="mega-view-all" style="color:<?= $cat['color'] ?>">View All <?= $cat['name'] ?> →</a>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </li>

            <!-- Category dropdowns (text & seo hidden from nav — still accessible via All Tools mega menu) -->
            <?php $nav_hide = ['text', 'seo']; foreach (CATEGORIES as $slug => $cat): if (in_array($slug, $nav_hide)) continue; ?>
            <li class="nav-dropdown">
                <a href="<?= BASE_URL . $slug ?>" class="nav-link <?= ($route ?? '') === $slug ? 'active' : '' ?>">
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
                    <div class="dd-footer">
                        <a href="<?= BASE_URL . $slug ?>" class="dd-view-all" style="color:<?= $cat['color'] ?>">View All <?= $cat['name'] ?> →</a>
                    </div>
                </div>
            </li>
            <?php endforeach; ?>

            <!-- News & Markets -->
            <li class="nav-dropdown">
                <a href="<?= BASE_URL ?>#news-section" class="nav-link <?= ($route ?? '') === 'news' ? 'active' : '' ?>">
                    📰 News
                    <svg class="chevron" width="12" height="12" viewBox="0 0 12 12"><path d="M2 4l4 4 4-4" stroke="currentColor" stroke-width="1.5" fill="none" stroke-linecap="round"/></svg>
                </a>
                <div class="dropdown-menu" style="min-width:200px">
                    <a href="<?= BASE_URL ?>#news-section" class="dropdown-item" onclick="document.querySelector('[data-type=tech]')?.click()">
                        <span class="dd-icon" style="background:#DBEAFE;color:#3B82F6">💻</span>
                        <span>Tech News</span>
                    </a>
                    <a href="<?= BASE_URL ?>#news-section" class="dropdown-item" onclick="document.querySelector('[data-type=finance]')?.click()">
                        <span class="dd-icon" style="background:#D1FAE5;color:#10B981">📊</span>
                        <span>Finance News</span>
                    </a>
                    <a href="<?= BASE_URL ?>#news-section" class="dropdown-item" onclick="document.querySelector('[data-type=stock]')?.click()">
                        <span class="dd-icon" style="background:#FEE2E2;color:#EF4444">📈</span>
                        <span>Market News</span>
                    </a>
                    <div class="dd-footer">
                        <a href="<?= BASE_URL ?>#market-section" class="dd-view-all" style="color:#3B82F6">📈 Stock Market Overview →</a>
                    </div>
                </div>
            </li>

        </ul>

        <!-- Nav Right Actions -->
        <div class="nav-actions">
            <a href="#" class="btn btn-primary btn-sm">Sign Up</a>
            <button class="hamburger" id="hamburger" aria-label="Menu"><span></span><span></span><span></span></button>
        </div>

    </div>
</nav>

<!-- ─── SEARCH OVERLAY ──────────────────────────────────────────────────────── -->
<div class="search-overlay" id="searchOverlay">
    <div class="search-overlay-inner">
        <div class="search-overlay-box">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
            <input type="text" class="search-overlay-input" id="searchInput" placeholder="Search 42+ tools…" autocomplete="off">
            <kbd class="search-kbd">ESC</kbd>
            <button class="search-close" id="searchClose" aria-label="Close">✕</button>
        </div>
        <div class="search-results" id="searchResults"></div>
    </div>
</div>
<div class="search-backdrop" id="searchBackdrop"></div>

<!-- ─── STICKY SIDE PLUGIN ───────────────────────────────────────────────── -->
<div class="side-plugin" id="sidePlugin">
    <button class="side-btn" id="searchToggle" title="Search tools (Ctrl+K)" aria-label="Search">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
        <span class="side-btn-label">Search</span>
    </button>
    <div class="side-divider"></div>
    <button class="side-btn theme-toggle" id="themeToggle" title="Toggle dark / light mode" aria-label="Toggle theme">
        <svg class="icon-sun"  width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="5"/><line x1="12" y1="1" x2="12" y2="3"/><line x1="12" y1="21" x2="12" y2="23"/><line x1="4.22" y1="4.22" x2="5.64" y2="5.64"/><line x1="18.36" y1="18.36" x2="19.78" y2="19.78"/><line x1="1" y1="12" x2="3" y2="12"/><line x1="21" y1="12" x2="23" y2="12"/><line x1="4.22" y1="19.78" x2="5.64" y2="18.36"/><line x1="18.36" y1="5.64" x2="19.78" y2="4.22"/></svg>
        <svg class="icon-moon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"/></svg>
        <span class="side-btn-label">Theme</span>
    </button>
</div>

<!-- ─── MAIN CONTENT ────────────────────────────────────────────────────────── -->
<main class="main-content">
