<?php
$page_title = 'Free Online Tools';
$page_desc  = 'Free online tools for PDF, images, developer utilities, SEO, finance & more — all in one place at Nexora Tools.';
require ROOT . '/includes/header.php';

$popular = popular_tools(9);
$categories = CATEGORIES;
$all_tools  = TOOLS;
$total_tools = count($all_tools);
?>

<!-- ─── HERO ───────────────────────────────────────────────────────────── -->
<section class="hero">
    <div class="hero-blob hero-blob-1"></div>
    <div class="hero-blob hero-blob-2"></div>
    <div class="container">
        <div class="hero-content">
            <div class="hero-badge">
                <span class="hero-badge-dot"></span>
                ✨ All-in-One Tech Platform
            </div>
            <h1>Your Complete<br><span class="hero-highlight">Tech Solution</span> Hub</h1>
            <p class="hero-sub">
                <?= $total_tools ?>+ free online tools for PDF, Images, Developer, SEO, Finance &amp; AI — built for everyone.
            </p>

            <!-- Search -->
            <div class="hero-search-wrap">
                <form class="hero-search" id="heroSearchForm">
                    <span class="hero-search-icon">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
                    </span>
                    <input type="text" id="heroSearchInput" placeholder="Search tools... e.g. &ldquo;PDF to Word&rdquo;, &ldquo;Password Generator&rdquo;" autocomplete="off">
                    <button type="submit" class="hero-search-btn">Search</button>
                </form>
            </div>

            <!-- Stats -->
            <div class="hero-stats">
                <div class="hero-stat">
                    <div class="hero-stat-num" data-count="<?= $total_tools ?>" data-suffix="+">0+</div>
                    <div class="hero-stat-label">Free Tools</div>
                </div>
                <div class="hero-stat-divider"></div>
                <div class="hero-stat">
                    <div class="hero-stat-num" data-count="50000" data-suffix="+">0+</div>
                    <div class="hero-stat-label">Monthly Users</div>
                </div>
                <div class="hero-stat-divider"></div>
                <div class="hero-stat">
                    <div class="hero-stat-num" data-count="7">0</div>
                    <div class="hero-stat-label">Categories</div>
                </div>
                <div class="hero-stat-divider"></div>
                <div class="hero-stat">
                    <div class="hero-stat-num">100%</div>
                    <div class="hero-stat-label">Free Forever</div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ─── POPULAR TOOLS ──────────────────────────────────────────────────── -->
<section class="section" style="padding-bottom: 0">
    <div class="container">
        <div class="section-header">
            <span class="section-eyebrow">⚡ Most Used</span>
            <h2>Popular Tools</h2>
            <p>The tools our users reach for every day</p>
        </div>
        <div class="tools-grid">
            <?php foreach ($popular as $tool):
                $color = cat_color($tool['cat']);
                $bg    = cat_bg($tool['cat']);
            ?>
            <a href="<?= BASE_URL . e($tool['slug']) ?>" class="tool-card" data-cat="<?= e($tool['cat']) ?>">
                <div class="tool-card-icon" style="background:<?= $bg ?>;color:<?= $color ?>">
                    <?= e($tool['icon']) ?>
                </div>
                <div class="tool-card-body">
                    <div class="tool-card-name"><?= e($tool['name']) ?></div>
                    <div class="tool-card-desc"><?= e($tool['desc']) ?></div>
                    <div class="tool-card-badges">
                        <?php if (!empty($tool['popular'])): ?>
                        <span class="badge badge-popular">⭐ Popular</span>
                        <?php endif; ?>
                        <?php if (!empty($tool['new'])): ?>
                        <span class="badge badge-new">New</span>
                        <?php endif; ?>
                    </div>
                </div>
            </a>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ─── ALL TOOLS (by category with filter tabs) ──────────────────────── -->
<section class="section" id="all-tools">
    <div class="container">
        <div class="section-header">
            <span class="section-eyebrow">🛠 Tools</span>
            <h2>All <?= $total_tools ?>+ Tools</h2>
            <p>Explore every tool by category</p>
        </div>

        <!-- Category Tabs -->
        <div class="cat-tabs">
            <button class="cat-tab active" data-cat="all">
                All <span class="cat-count"><?= $total_tools ?></span>
            </button>
            <?php foreach ($categories as $slug => $cat):
                $count = count(array_filter($all_tools, fn($t) => $t['cat'] === $slug));
            ?>
            <button class="cat-tab" data-cat="<?= $slug ?>">
                <?= $cat['icon'] ?> <?= $cat['name'] ?>
                <span class="cat-count"><?= $count ?></span>
            </button>
            <?php endforeach; ?>
        </div>

        <!-- Tools Grid -->
        <div class="tools-grid">
            <?php foreach ($all_tools as $tool):
                $color = cat_color($tool['cat']);
                $bg    = cat_bg($tool['cat']);
            ?>
            <a href="<?= BASE_URL . e($tool['slug']) ?>" class="tool-card" data-cat="<?= e($tool['cat']) ?>">
                <div class="tool-card-icon" style="background:<?= $bg ?>;color:<?= $color ?>">
                    <?= e($tool['icon']) ?>
                </div>
                <div class="tool-card-body">
                    <div class="tool-card-name"><?= e($tool['name']) ?></div>
                    <div class="tool-card-desc"><?= e($tool['desc']) ?></div>
                    <div class="tool-card-badges">
                        <?php if (!empty($tool['popular'])): ?>
                        <span class="badge badge-popular">⭐ Popular</span>
                        <?php endif; ?>
                        <?php if (!empty($tool['new'])): ?>
                        <span class="badge badge-new">New</span>
                        <?php endif; ?>
                    </div>
                </div>
            </a>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ─── WHY NEXORA ────────────────────────────────────────────────────── -->
<section class="section" style="background: var(--bg-elevated)">
    <div class="container">
        <div class="section-header">
            <span class="section-eyebrow">💡 Why Choose Us</span>
            <h2>Built for Speed &amp; Simplicity</h2>
            <p>No signup required. No hidden fees. Tools that just work.</p>
        </div>
        <div class="features-grid">
            <div class="feature-card">
                <div class="feature-icon">⚡</div>
                <h3>Lightning Fast</h3>
                <p>All tools run instantly in your browser. No waiting, no server queue.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">🔒</div>
                <h3>100% Private</h3>
                <p>Your files and data are processed locally and never stored on our servers.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">🆓</div>
                <h3>Always Free</h3>
                <p>Every tool is completely free. No premium tier, no credit card required.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">📱</div>
                <h3>Mobile Friendly</h3>
                <p>Works perfectly on all devices — desktop, tablet, and mobile.</p>
            </div>
        </div>
    </div>
</section>

<!-- ─── STATS STRIP ───────────────────────────────────────────────────── -->
<div class="stats-strip">
    <div class="container">
        <div class="stats-row">
            <div class="stat-item">
                <div class="stat-num" data-count="<?= $total_tools ?>" data-suffix="+">0+</div>
                <div class="stat-label">Online Tools</div>
            </div>
            <div class="stat-item">
                <div class="stat-num" data-count="50000" data-suffix="+">0+</div>
                <div class="stat-label">Monthly Users</div>
            </div>
            <div class="stat-item">
                <div class="stat-num" data-count="7">0</div>
                <div class="stat-label">Tool Categories</div>
            </div>
            <div class="stat-item">
                <div class="stat-num" data-count="99" data-suffix="%">0%</div>
                <div class="stat-label">Uptime</div>
            </div>
        </div>
    </div>
</div>

<!-- ─── CTA BANNER ───────────────────────────────────────────────────── -->
<section class="section">
    <div class="container">
        <div class="cta-banner">
            <h2>Build Something Amazing Today</h2>
            <p>Join thousands of developers, designers, and content creators using Nexora Tools every day.</p>
            <div class="flex flex-center gap-16" style="flex-wrap:wrap">
                <a href="<?= BASE_URL ?>tools" class="btn btn-primary btn-lg">Explore All Tools</a>
                <a href="<?= BASE_URL ?>about"  class="btn btn-ghost btn-lg">Learn About Us</a>
            </div>
        </div>
    </div>
</section>

<?php require ROOT . '/includes/footer.php'; ?>
