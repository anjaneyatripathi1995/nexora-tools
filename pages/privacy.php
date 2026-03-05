<?php
$page_title = 'Privacy Policy';
require ROOT . '/includes/header.php';
?>
<div class="sub-banner">
    <div class="container">
        <div class="sub-banner-inner">
            <h1>Privacy Policy</h1>
            <p>Last updated: <?= date('F Y') ?></p>
        </div>
    </div>
</div>
<section class="section">
    <div class="container" style="max-width:760px;margin:0 auto">
        <div class="tool-wrap" style="line-height:1.8;color:var(--text-2)">
            <?php
            $sections = [
                ['Information We Collect', 'We collect minimal data to operate our services. This includes: usage analytics (page views, tool usage counts — fully anonymized), contact form submissions when you write to us, and browser local storage for your theme preference (stored on your device only).'],
                ['How We Use Information', 'We use collected data solely to improve Nexora Tools. We do NOT sell, rent, or share your personal information with any third parties.'],
                ['Files & Privacy', 'Any files you process with our tools are handled locally in your browser whenever possible. Files are never permanently stored on our servers. Temporary uploads are deleted immediately after processing.'],
                ['Cookies', 'We use only essential cookies required for the site to function. We do not use tracking cookies or advertising cookies.'],
                ['Third-Party Services', 'We may use Google Fonts (for typography) and Google Analytics (anonymized, if enabled). These services have their own privacy policies.'],
                ['Data Security', 'We implement industry-standard security measures. However, no internet transmission is 100% secure. We encourage using strong passwords for any accounts you create.'],
                ['Children\'s Privacy', 'Nexora Tools is not directed at children under 13. We do not knowingly collect personal data from children.'],
                ['Changes to This Policy', 'We may update this policy periodically. Changes will be posted here with an updated date. Continued use of Nexora Tools constitutes acceptance of the updated policy.'],
                ['Contact', 'For privacy-related questions, contact us at: ' . SITE_EMAIL],
            ];
            foreach ($sections as $i => [$title, $body]):
            ?>
            <h3 style="color:var(--text);margin:32px 0 10px"><?= ($i+1) ?>. <?= e($title) ?></h3>
            <p><?= e($body) ?></p>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php require ROOT . '/includes/footer.php'; ?>
