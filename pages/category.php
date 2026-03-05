<?php
$cat_key  = $current_category ?? 'dev';
$cats     = CATEGORIES;
$cat_info = $cats[$cat_key] ?? ['name' => 'Tools', 'icon' => '🛠', 'color' => '#2563EB', 'bg' => '#DBEAFE'];
$cat_tools = array_values(array_filter(TOOLS, fn($t) => $t['cat'] === $cat_key));

$page_title = $cat_info['name'];
$page_desc  = 'Free ' . $cat_info['name'] . ' — browse ' . count($cat_tools) . ' tools including ' . implode(', ', array_slice(array_column($cat_tools, 'name'), 0, 3)) . ' and more.';
require ROOT . '/includes/header.php';
?>

<div class="sub-banner">
    <div class="container">
        <div class="sub-banner-inner">
            <div style="font-size:3rem;margin-bottom:12px"><?= $cat_info['icon'] ?></div>
            <h1><?= e($cat_info['name']) ?></h1>
            <p><?= count($cat_tools) ?> free tools in this category</p>
            <div class="breadcrumb">
                <a href="<?= BASE_URL ?>">Home</a> / <a href="<?= BASE_URL ?>tools">Tools</a> / <?= e($cat_info['name']) ?>
            </div>
        </div>
    </div>
</div>

<section class="section">
    <div class="container">
        <?php if (empty($cat_tools)): ?>
        <div style="text-align:center;padding:80px 0;color:var(--text-2)">
            <div style="font-size:3rem;margin-bottom:16px">🚧</div>
            <h3>Coming Soon</h3>
            <p>We're building tools for this category. Check back soon!</p>
        </div>
        <?php else: ?>
        <div class="tools-grid">
            <?php foreach ($cat_tools as $tool):
                $color = $cat_info['color'];
                $bg    = $cat_info['bg'];
            ?>
            <a href="<?= BASE_URL . e($tool['slug']) ?>" class="tool-card">
                <div class="tool-card-icon" style="background:<?= $bg ?>;color:<?= $color ?>"><?= e($tool['icon']) ?></div>
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
        <?php endif; ?>
    </div>
</section>

<?php require ROOT . '/includes/footer.php'; ?>
