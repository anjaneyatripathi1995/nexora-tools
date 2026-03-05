<?php
$page_title = 'All Tools';
$page_desc  = 'Browse all ' . count(TOOLS) . '+ free online tools — PDF, Developer, Image, SEO, Finance & AI tools.';
$q = htmlspecialchars(trim($_GET['q'] ?? ''), ENT_QUOTES);
require ROOT . '/includes/header.php';
?>

<div class="sub-banner">
    <div class="container">
        <div class="sub-banner-inner">
            <h1>🛠 All Tools</h1>
            <p><?= count(TOOLS) ?>+ free tools — pick what you need</p>
        </div>
    </div>
</div>

<section class="section">
    <div class="container">
        <!-- Inline Search -->
        <div style="max-width:540px;margin:0 auto 36px;display:flex;gap:0;background:var(--bg-card);border:1.5px solid var(--border);border-radius:12px;overflow:hidden;">
            <span style="padding:0 14px 0 18px;display:flex;align-items:center;color:var(--text-3)">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
            </span>
            <input type="text" id="toolsPageSearch" placeholder="Filter tools..." value="<?= $q ?>"
                   style="flex:1;padding:13px 0;font-size:0.95rem;border:none;outline:none;background:transparent;color:var(--text)">
        </div>

        <!-- Category Tabs -->
        <div class="cat-tabs">
            <button class="cat-tab active" data-cat="all">All <span class="cat-count"><?= count(TOOLS) ?></span></button>
            <?php foreach (CATEGORIES as $slug => $cat):
                $count = count(array_filter(TOOLS, fn($t) => $t['cat'] === $slug));
            ?>
            <button class="cat-tab" data-cat="<?= $slug ?>">
                <?= $cat['icon'] ?> <?= $cat['name'] ?> <span class="cat-count"><?= $count ?></span>
            </button>
            <?php endforeach; ?>
        </div>

        <!-- Tools Grid -->
        <div class="tools-grid" id="allToolsGrid">
            <?php foreach (TOOLS as $tool):
                $color = cat_color($tool['cat']);
                $bg    = cat_bg($tool['cat']);
            ?>
            <a href="<?= BASE_URL . e($tool['slug']) ?>" class="tool-card" data-cat="<?= e($tool['cat']) ?>" data-name="<?= strtolower(e($tool['name'])) ?>" data-desc="<?= strtolower(e($tool['desc'])) ?>">
                <div class="tool-card-icon" style="background:<?= $bg ?>;color:<?= $color ?>">
                    <?= e($tool['icon']) ?>
                </div>
                <div class="tool-card-body">
                    <div class="tool-card-name"><?= e($tool['name']) ?></div>
                    <div class="tool-card-desc"><?= e($tool['desc']) ?></div>
                    <div class="tool-card-badges">
                        <?php if (!empty($tool['popular'])): ?><span class="badge badge-popular">⭐ Popular</span><?php endif; ?>
                        <?php if (!empty($tool['new'])): ?><span class="badge badge-new">New</span><?php endif; ?>
                    </div>
                </div>
            </a>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<script>
// Tools page inline search
(function() {
    const input = document.getElementById('toolsPageSearch');
    const cards = document.querySelectorAll('#allToolsGrid .tool-card');
    if (!input) return;
    function filter() {
        const q = input.value.toLowerCase();
        cards.forEach(c => {
            const match = !q || c.dataset.name.includes(q) || c.dataset.desc.includes(q);
            c.classList.toggle('hidden', !match);
        });
    }
    input.addEventListener('input', filter);
    if (input.value) filter();
})();
</script>

<?php require ROOT . '/includes/footer.php'; ?>
