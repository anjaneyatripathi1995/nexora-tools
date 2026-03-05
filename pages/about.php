<?php
$page_title = 'About Nexora Tools';
$page_desc  = 'Learn about Nexora Tools — built by Tripathi Nexora Technologies to provide free, fast online tools for everyone.';
require ROOT . '/includes/header.php';
?>

<div class="sub-banner">
    <div class="container">
        <div class="sub-banner-inner">
            <h1>About Nexora Tools</h1>
            <p>Built with ❤️ by Tripathi Nexora Technologies, India</p>
        </div>
    </div>
</div>

<section class="section">
    <div class="container">

        <div style="max-width:720px;margin:0 auto 64px;text-align:center">
            <span class="section-eyebrow">🏢 Who We Are</span>
            <h2 style="margin-bottom:16px">Building Tools for the Digital World</h2>
            <p style="font-size:1.05rem;color:var(--text-2);line-height:1.8">
                Nexora Tools is a free online utility platform developed by <strong>Tripathi Nexora Technologies</strong>.
                We believe everyone should have access to powerful digital tools without any cost, registration, or complexity.
                From developers to designers, students to professionals — Nexora Tools is built for you.
            </p>
        </div>

        <div class="info-grid" style="margin-bottom:64px">
            <div class="info-card">
                <div class="info-card-icon">🎯</div>
                <h3>Our Mission</h3>
                <p>To democratize access to digital tools by making every utility free, fast, and user-friendly — available to anyone, anywhere.</p>
            </div>
            <div class="info-card">
                <div class="info-card-icon">👁</div>
                <h3>Our Vision</h3>
                <p>To become India's most trusted all-in-one tech tool platform, serving millions of users with 100+ specialized tools.</p>
            </div>
            <div class="info-card">
                <div class="info-card-icon">💎</div>
                <h3>Our Values</h3>
                <p>Privacy-first, open access, clean UX, zero bloat. We don't sell your data. We don't show intrusive ads. We just build great tools.</p>
            </div>
        </div>

        <div style="text-align:center;margin-bottom:48px">
            <span class="section-eyebrow">🛠 What We Offer</span>
            <h2 style="margin-bottom:40px">Our Tool Categories</h2>
        </div>
        <div class="features-grid" style="margin-bottom:64px">
            <?php foreach (CATEGORIES as $slug => $cat):
                $count = count(array_filter(TOOLS, fn($t) => $t['cat'] === $slug));
            ?>
            <a href="<?= BASE_URL . $slug ?>" class="feature-card" style="text-decoration:none">
                <div class="feature-icon" style="background:<?= $cat['bg'] ?>;color:<?= $cat['color'] ?>"><?= $cat['icon'] ?></div>
                <h3><?= $cat['name'] ?></h3>
                <p><?= $count ?> tools available in this category. Click to explore all.</p>
            </a>
            <?php endforeach; ?>
        </div>

        <div style="background:var(--bg-elevated);border-radius:20px;padding:48px;text-align:center">
            <h2 style="margin-bottom:12px">📬 Get In Touch</h2>
            <p style="color:var(--text-2);margin-bottom:24px">Have a suggestion, found a bug, or want to collaborate? We'd love to hear from you.</p>
            <a href="<?= BASE_URL ?>contact" class="btn btn-primary btn-lg">Contact Us</a>
            &nbsp;
            <a href="mailto:<?= SITE_EMAIL ?>" class="btn btn-ghost btn-lg"><?= SITE_EMAIL ?></a>
        </div>

    </div>
</section>

<?php require ROOT . '/includes/footer.php'; ?>
