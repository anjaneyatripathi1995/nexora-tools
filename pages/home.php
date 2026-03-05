<?php
$page_title = 'Free Online Tools';
$page_desc  = 'Free online tools for PDF, images, developer utilities, SEO, finance & AI — all in one place at Nexora Tools.';
require ROOT . '/includes/header.php';
$popular    = popular_tools(9);
$total      = count(TOOLS);
?>
<section class="hero">
    <div class="hero-blob hero-blob-1"></div>
    <div class="hero-blob hero-blob-2"></div>
    <div class="container">
        <div class="hero-content">
            <div class="hero-badge"><span class="hero-badge-dot"></span> ✨ All-in-One Tech Platform</div>
            <h1>Your Complete<br><span class="hero-highlight">Tech Solution</span> Hub</h1>
            <p class="hero-sub"><?= $total ?>+ free tools for PDF, Images, Developer, SEO, Finance &amp; AI — built for everyone.</p>
            <div class="hero-search-wrap">
                <form class="hero-search" id="heroSearchForm">
                    <span class="hero-search-icon"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg></span>
                    <input type="text" id="heroSearchInput" placeholder='Search tools… e.g. "PDF to Word", "Password Generator"' autocomplete="off">
                    <button type="submit" class="hero-search-btn">Search</button>
                </form>
            </div>
            <div class="hero-stats">
                <div class="hero-stat"><div class="hero-stat-num" data-count="<?= $total ?>" data-suffix="+">0+</div><div class="hero-stat-label">Free Tools</div></div>
                <div class="hero-stat-divider"></div>
                <div class="hero-stat"><div class="hero-stat-num" data-count="50000" data-suffix="+">0+</div><div class="hero-stat-label">Monthly Users</div></div>
                <div class="hero-stat-divider"></div>
                <div class="hero-stat"><div class="hero-stat-num" data-count="7">0</div><div class="hero-stat-label">Categories</div></div>
                <div class="hero-stat-divider"></div>
                <div class="hero-stat"><div class="hero-stat-num">100%</div><div class="hero-stat-label">Free Forever</div></div>
            </div>
        </div>
    </div>
</section>

<section class="section" style="padding-bottom:0">
    <div class="container">
        <div class="section-header"><span class="section-eyebrow">⚡ Most Used</span><h2>Popular Tools</h2><p>The tools our users reach for every day</p></div>
        <div class="tools-grid">
            <?php foreach ($popular as $t): ?>
            <a href="<?= BASE_URL . e($t['slug']) ?>" class="tool-card" data-cat="<?= e($t['cat']) ?>">
                <div class="tool-card-icon" style="background:<?= cat_bg($t['cat']) ?>;color:<?= cat_color($t['cat']) ?>"><?= e($t['icon']) ?></div>
                <div class="tool-card-body">
                    <div class="tool-card-name"><?= e($t['name']) ?></div>
                    <div class="tool-card-desc"><?= e($t['desc']) ?></div>
                    <div class="tool-card-badges"><?php if (!empty($t['popular'])): ?><span class="badge badge-popular">⭐ Popular</span><?php endif; ?><?php if (!empty($t['new'])): ?><span class="badge badge-new">New</span><?php endif; ?></div>
                </div>
            </a>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="section" id="all-tools">
    <div class="container">
        <div class="section-header"><span class="section-eyebrow">🛠 Tools</span><h2>All <?= $total ?>+ Tools</h2><p>Explore every tool by category</p></div>
        <div class="cat-tabs">
            <button class="cat-tab active" data-cat="all">All <span class="cat-count"><?= $total ?></span></button>
            <?php foreach (CATEGORIES as $slug => $cat): $c = count(tools_by_cat($slug)); ?>
            <button class="cat-tab" data-cat="<?= $slug ?>"><?= $cat['icon'] ?> <?= $cat['name'] ?> <span class="cat-count"><?= $c ?></span></button>
            <?php endforeach; ?>
        </div>
        <div class="tools-grid">
            <?php foreach (TOOLS as $t): ?>
            <a href="<?= BASE_URL . e($t['slug']) ?>" class="tool-card" data-cat="<?= e($t['cat']) ?>">
                <div class="tool-card-icon" style="background:<?= cat_bg($t['cat']) ?>;color:<?= cat_color($t['cat']) ?>"><?= e($t['icon']) ?></div>
                <div class="tool-card-body">
                    <div class="tool-card-name"><?= e($t['name']) ?></div>
                    <div class="tool-card-desc"><?= e($t['desc']) ?></div>
                    <div class="tool-card-badges"><?php if (!empty($t['popular'])): ?><span class="badge badge-popular">⭐ Popular</span><?php endif; ?><?php if (!empty($t['new'])): ?><span class="badge badge-new">New</span><?php endif; ?></div>
                </div>
            </a>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="section" style="background:var(--bg-elevated)">
    <div class="container">
        <div class="section-header"><span class="section-eyebrow">💡 Why Choose Us</span><h2>Built for Speed &amp; Simplicity</h2><p>No signup required. No hidden fees. Tools that just work.</p></div>
        <div class="features-grid">
            <div class="feature-card"><div class="feature-icon">⚡</div><h3>Lightning Fast</h3><p>All tools run instantly in your browser. No waiting, no queues.</p></div>
            <div class="feature-card"><div class="feature-icon">🔒</div><h3>100% Private</h3><p>Files processed locally — never stored on our servers.</p></div>
            <div class="feature-card"><div class="feature-icon">🆓</div><h3>Always Free</h3><p>Every tool is completely free. No premium tier, no card required.</p></div>
            <div class="feature-card"><div class="feature-icon">📱</div><h3>Mobile Friendly</h3><p>Works perfectly on all devices — desktop, tablet, and mobile.</p></div>
        </div>
    </div>
</section>

<div class="stats-strip">
    <div class="container">
        <div class="stats-row">
            <div class="stat-item"><div class="stat-num" data-count="<?= $total ?>" data-suffix="+">0+</div><div class="stat-label">Online Tools</div></div>
            <div class="stat-item"><div class="stat-num" data-count="50000" data-suffix="+">0+</div><div class="stat-label">Monthly Users</div></div>
            <div class="stat-item"><div class="stat-num" data-count="7">0</div><div class="stat-label">Tool Categories</div></div>
            <div class="stat-item"><div class="stat-num" data-count="99" data-suffix="%">0%</div><div class="stat-label">Uptime</div></div>
        </div>
    </div>
</div>

<section class="section">
    <div class="container">
        <div class="cta-banner">
            <h2>Build Something Amazing Today</h2>
            <p>Join thousands using Nexora Tools every day — free, forever.</p>
            <div class="flex flex-center gap-16" style="flex-wrap:wrap">
                <a href="<?= BASE_URL ?>tools" class="btn btn-primary btn-lg">Explore All Tools</a>
                <a href="<?= BASE_URL ?>about"  class="btn btn-ghost btn-lg">About Us</a>
            </div>
        </div>
    </div>
</section>

<?php require ROOT . '/includes/footer.php'; ?>
