<?php
$page_title = 'Free Online Tools';
$page_desc  = 'Free online tools for PDF, images, developer utilities, SEO, finance & AI — all in one place at Nexora Tools.';
require ROOT . '/includes/header.php';
$popular = popular_tools(8);
$total   = count(TOOLS);
?>

<!-- ─── HERO ──────────────────────────────────────────────────────────────── -->
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
                    <span class="hero-search-icon"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg></span>
                    <input type="text" id="heroSearchInput" placeholder='Search 42+ tools… e.g. "JSON Formatter", "PDF to Word"' autocomplete="off">
                    <span class="hero-search-sep"></span>
                    <button type="submit" class="hero-search-btn">🔍 Search</button>
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

<!-- ─── POPULAR TOOLS ─────────────────────────────────────────────────────── -->
<section class="section" style="padding-bottom:0">
    <div class="container">
        <div class="section-header">
            <span class="section-eyebrow">⚡ Most Used</span>
            <h2>Popular Tools</h2>
            <p>The tools our users reach for every day</p>
        </div>
        <div class="tools-grid">
            <?php foreach ($popular as $t): ?>
            <a href="<?= BASE_URL . e($t['slug']) ?>" class="tool-card" data-cat="<?= e($t['cat']) ?>">
                <div class="tool-card-icon" style="background:<?= cat_bg($t['cat']) ?>;color:<?= cat_color($t['cat']) ?>"><?= e($t['icon']) ?></div>
                <div class="tool-card-body">
                    <div class="tool-card-name"><?= e($t['name']) ?></div>
                    <div class="tool-card-desc"><?= e($t['desc']) ?></div>
                    <div class="tool-card-badges">
                        <?php if (!empty($t['popular'])): ?><span class="badge badge-popular">⭐ Popular</span><?php endif; ?>
                        <?php if (!empty($t['new'])): ?><span class="badge badge-new">New</span><?php endif; ?>
                    </div>
                </div>
            </a>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ─── CATEGORY OVERVIEW CARDS ───────────────────────────────────────────── -->
<section class="section">
    <div class="container">
        <div class="section-header">
            <span class="section-eyebrow">📁 Browse by Category</span>
            <h2>Explore All Categories</h2>
            <p>Jump straight to the tools you need</p>
        </div>
        <div class="cat-cards-grid">
            <?php foreach (CATEGORIES as $slug => $cat):
                $cat_tools = array_slice(array_values(tools_by_cat($slug)), 0, 6);
                $count     = count(tools_by_cat($slug));
            ?>
            <div class="cat-card" style="--cc:<?= $cat['color'] ?>">
                <div class="cat-card-header">
                    <div class="cat-card-icon" style="background:<?= $cat['bg'] ?>;color:<?= $cat['color'] ?>"><?= $cat['icon'] ?></div>
                    <div>
                        <h3 class="cat-card-name"><?= $cat['name'] ?></h3>
                        <span class="cat-card-count" style="color:<?= $cat['color'] ?>"><?= $count ?> Tools</span>
                    </div>
                </div>
                <ul class="cat-card-tools">
                    <?php foreach ($cat_tools as $t): ?>
                    <li>
                        <a href="<?= BASE_URL . e($t['slug']) ?>" class="cat-card-tool-link">
                            <span class="cat-tool-icon"><?= e($t['icon']) ?></span>
                            <?= e($t['name']) ?>
                        </a>
                    </li>
                    <?php endforeach; ?>
                </ul>
                <a href="<?= BASE_URL . $slug ?>" class="cat-card-btn">View All →</a>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ─── ALL TOOLS ─────────────────────────────────────────────────────────── -->
<section class="section" id="all-tools" style="background:var(--bg-elevated)">
    <div class="container">
        <div class="section-header">
            <span class="section-eyebrow">🛠 Tools</span>
            <h2>All <?= $total ?>+ Tools</h2>
            <p>Explore every tool — filter by category</p>
        </div>
        <div class="cat-tabs">
            <button class="cat-tab active" data-cat="all">All <span class="cat-count"><?= $total ?></span></button>
            <?php foreach (CATEGORIES as $slug => $cat): $c = count(tools_by_cat($slug)); ?>
            <button class="cat-tab" data-cat="<?= $slug ?>"><?= $cat['icon'] ?> <?= $cat['name'] ?> <span class="cat-count"><?= $c ?></span></button>
            <?php endforeach; ?>
        </div>
        <div class="tools-grid" id="allToolsGrid">
            <?php foreach (TOOLS as $t): ?>
            <a href="<?= BASE_URL . e($t['slug']) ?>" class="tool-card" data-cat="<?= e($t['cat']) ?>">
                <div class="tool-card-icon" style="background:<?= cat_bg($t['cat']) ?>;color:<?= cat_color($t['cat']) ?>"><?= e($t['icon']) ?></div>
                <div class="tool-card-body">
                    <div class="tool-card-name"><?= e($t['name']) ?></div>
                    <div class="tool-card-desc"><?= e($t['desc']) ?></div>
                    <div class="tool-card-badges">
                        <?php if (!empty($t['popular'])): ?><span class="badge badge-popular">⭐ Popular</span><?php endif; ?>
                        <?php if (!empty($t['new'])): ?><span class="badge badge-new">New</span><?php endif; ?>
                    </div>
                </div>
            </a>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ─── WHY CHOOSE US ─────────────────────────────────────────────────────── -->
<section class="section">
    <div class="container">
        <div class="section-header">
            <span class="section-eyebrow">💡 Why Nexora Tools</span>
            <h2>Built for Speed &amp; Simplicity</h2>
            <p>No signup required. No hidden fees. Tools that just work.</p>
        </div>
        <div class="features-grid">
            <div class="feature-card">
                <div class="feature-icon">⚡</div>
                <h3>Lightning Fast</h3>
                <p>All tools run instantly in your browser. No waiting, no queues.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">🔒</div>
                <h3>100% Private</h3>
                <p>Files processed locally — never stored on our servers.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">🆓</div>
                <h3>Always Free</h3>
                <p>Every tool is completely free. No premium tier, no card required.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">📱</div>
                <h3>Mobile Friendly</h3>
                <p>Works perfectly on all devices — desktop, tablet, and mobile.</p>
            </div>
        </div>
    </div>
</section>

<!-- ─── STATS ─────────────────────────────────────────────────────────────── -->
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

<!-- ─── STOCK MARKET OVERVIEW ─────────────────────────────────────────────── -->
<section class="section market-section" id="market-section" style="padding-bottom:0">
    <div class="container">
        <div class="section-header">
            <span class="section-eyebrow">📈 Live Markets</span>
            <h2>Stock Market Overview</h2>
            <p>Real-time indices — NIFTY, SENSEX, NASDAQ &amp; more</p>
        </div>
        <div class="market-ticker-wrap">
            <div class="market-grid" id="marketGrid">
                <!-- skeleton placeholders -->
                <?php for ($i = 0; $i < 6; $i++): ?>
                <div class="market-card skeleton">
                    <div class="sk-line sk-w60"></div>
                    <div class="sk-line sk-w40 sk-lg"></div>
                    <div class="sk-line sk-w50"></div>
                </div>
                <?php endfor; ?>
            </div>
            <div class="market-footer">
                <span id="marketTime" class="market-time"></span>
                <button class="market-refresh" id="marketRefresh" title="Refresh">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M23 4v6h-6"/><path d="M1 20v-6h6"/><path d="M3.51 9a9 9 0 0 1 14.85-3.36L23 10M1 14l4.64 4.36A9 9 0 0 0 20.49 15"/></svg>
                    Refresh
                </button>
            </div>
        </div>
    </div>
</section>

<!-- ─── NEWS SECTION ──────────────────────────────────────────────────────── -->
<section class="section news-section" id="news-section">
    <div class="container">
        <div class="news-header-row">
            <div>
                <span class="section-eyebrow">📰 Latest News</span>
                <h2>Tech &amp; Market News</h2>
            </div>
            <div class="news-tabs" id="newsTabs">
                <button class="news-tab active" data-type="tech">💻 Tech</button>
                <button class="news-tab" data-type="finance">📊 Finance</button>
                <button class="news-tab" data-type="stock">📈 Markets</button>
            </div>
        </div>
        <div class="news-grid" id="newsGrid">
            <!-- skeleton -->
            <?php for ($i = 0; $i < 6; $i++): ?>
            <div class="news-card skeleton">
                <div class="sk-line sk-w30"></div>
                <div class="sk-line sk-w100 sk-md"></div>
                <div class="sk-line sk-w80"></div>
                <div class="sk-line sk-w50 sk-sm"></div>
            </div>
            <?php endfor; ?>
        </div>
        <p class="news-note">Powered by Google News RSS · Data for informational purposes only</p>
    </div>
</section>

<!-- ─── CTA BANNER ───────────────────────────────────────────────────────── -->
<section class="section">
    <div class="container">
        <div class="cta-banner">
            <h2>Build Something Amazing Today</h2>
            <p>Join thousands using Nexora Tools every day — free, forever.</p>
            <div class="flex flex-center gap-16" style="flex-wrap:wrap">
                <a href="<?= BASE_URL ?>tools" class="btn btn-primary btn-lg">Explore All Tools</a>
                <a href="<?= BASE_URL ?>about"  class="btn btn-ghost  btn-lg">About Us</a>
            </div>
        </div>
    </div>
</section>

<?php require ROOT . '/includes/footer.php'; ?>
