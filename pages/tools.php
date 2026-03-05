<?php
$page_title = 'All Tools';
$q = e(trim($_GET['q'] ?? ''));
require ROOT . '/includes/header.php';
?>
<div class="sub-banner"><div class="container"><div class="sub-banner-inner"><h1>🛠 All Tools</h1><p><?= count(TOOLS) ?>+ free tools — pick what you need</p></div></div></div>
<section class="section"><div class="container">
    <div style="max-width:540px;margin:0 auto 36px;display:flex;background:var(--bg-card);border:1.5px solid var(--border);border-radius:12px;overflow:hidden">
        <span style="padding:0 14px 0 18px;display:flex;align-items:center;color:var(--text-3)"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg></span>
        <input type="text" id="toolsPageSearch" placeholder="Filter tools…" value="<?= $q ?>" style="flex:1;padding:13px 0;font-size:.95rem;border:none;outline:none;background:transparent;color:var(--text)">
    </div>
    <div class="cat-tabs">
        <button class="cat-tab active" data-cat="all">All <span class="cat-count"><?= count(TOOLS) ?></span></button>
        <?php foreach (CATEGORIES as $slug => $cat): $c = count(tools_by_cat($slug)); ?>
        <button class="cat-tab" data-cat="<?= $slug ?>"><?= $cat['icon'] ?> <?= $cat['name'] ?> <span class="cat-count"><?= $c ?></span></button>
        <?php endforeach; ?>
    </div>
    <div class="tools-grid" id="allToolsGrid">
        <?php foreach (TOOLS as $t): ?>
        <a href="<?= BASE_URL . e($t['slug']) ?>" class="tool-card" data-cat="<?= e($t['cat']) ?>" data-name="<?= strtolower(e($t['name'])) ?>" data-desc="<?= strtolower(e($t['desc'])) ?>">
            <div class="tool-card-icon" style="background:<?= cat_bg($t['cat']) ?>;color:<?= cat_color($t['cat']) ?>"><?= e($t['icon']) ?></div>
            <div class="tool-card-body">
                <div class="tool-card-name"><?= e($t['name']) ?></div>
                <div class="tool-card-desc"><?= e($t['desc']) ?></div>
                <div class="tool-card-badges"><?php if (!empty($t['popular'])): ?><span class="badge badge-popular">⭐ Popular</span><?php endif; ?><?php if (!empty($t['new'])): ?><span class="badge badge-new">New</span><?php endif; ?></div>
            </div>
        </a>
        <?php endforeach; ?>
    </div>
</div></section>
<script>
(function(){const i=document.getElementById('toolsPageSearch');const c=document.querySelectorAll('#allToolsGrid .tool-card');if(!i)return;function f(){const q=i.value.toLowerCase();c.forEach(x=>{x.classList.toggle('hidden',!!q&&!x.dataset.name.includes(q)&&!x.dataset.desc.includes(q))})};i.addEventListener('input',f);if(i.value)f()})();
</script>
<?php require ROOT . '/includes/footer.php'; ?>
