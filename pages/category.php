<?php
$slug     = $current_category ?? 'dev';
$cat_info = CATEGORIES[$slug] ?? ['name'=>'Tools','icon'=>'🛠','color'=>'#2563EB','bg'=>'#DBEAFE'];
$cat_tools = array_values(array_filter(TOOLS, fn($t) => $t['cat'] === $slug));
$page_title = $cat_info['name'];
require ROOT . '/includes/header.php';
?>
<div class="sub-banner"><div class="container"><div class="sub-banner-inner">
    <div style="font-size:3rem;margin-bottom:12px"><?= $cat_info['icon'] ?></div>
    <h1><?= e($cat_info['name']) ?></h1>
    <p><?= count($cat_tools) ?> free tools in this category</p>
    <div class="breadcrumb"><a href="<?= BASE_URL ?>">Home</a> / <a href="<?= BASE_URL ?>tools">Tools</a> / <?= e($cat_info['name']) ?></div>
</div></div></div>
<section class="section"><div class="container">
    <?php if (empty($cat_tools)): ?>
    <div style="text-align:center;padding:80px 0;color:var(--text-2)"><div style="font-size:3rem;margin-bottom:16px">🚧</div><h3>Coming Soon</h3><p>Tools for this category are being built.</p></div>
    <?php else: ?>
    <div class="tools-grid">
        <?php foreach ($cat_tools as $t): ?>
        <a href="<?= BASE_URL ?>tools/<?= e($t['slug']) ?>" class="tool-card">
            <div class="tool-card-icon" style="background:<?= $cat_info['bg'] ?>;color:<?= $cat_info['color'] ?>"><?= e($t['icon']) ?></div>
            <div class="tool-card-body">
                <div class="tool-card-name"><?= e($t['name']) ?></div>
                <div class="tool-card-desc"><?= e($t['desc']) ?></div>
                <div class="tool-card-badges"><?php if (!empty($t['popular'])): ?><span class="badge badge-popular">⭐ Popular</span><?php endif; ?><?php if (!empty($t['new'])): ?><span class="badge badge-new">New</span><?php endif; ?></div>
            </div>
        </a>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>
</div></section>
<?php require ROOT . '/includes/footer.php'; ?>
