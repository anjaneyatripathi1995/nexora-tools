<?php
$page_title = 'Terms of Service';
require ROOT . '/includes/header.php';
?>
<div class="sub-banner">
    <div class="container">
        <div class="sub-banner-inner">
            <h1>Terms of Service</h1>
            <p>Last updated: <?= date('F Y') ?></p>
        </div>
    </div>
</div>
<section class="section">
    <div class="container" style="max-width:760px;margin:0 auto">
        <div class="tool-wrap" style="line-height:1.8;color:var(--text-2)">
            <?php
            $sections = [
                ['Acceptance of Terms', 'By accessing and using Nexora Tools ("the Service"), you agree to be bound by these Terms of Service. If you do not agree, please discontinue use of the Service.'],
                ['Use of the Service', 'Nexora Tools provides free online utilities for personal and professional use. You may use these tools for lawful purposes only. You must not use the Service to process or distribute illegal, harmful, or copyrighted content without permission.'],
                ['Intellectual Property', 'All content, design, code, and branding on Nexora Tools is owned by Tripathi Nexora Technologies. You may not copy, reproduce, or distribute any part of the Service without written permission.'],
                ['Disclaimer of Warranties', 'The Service is provided "as is" without any warranties, express or implied. We do not guarantee uninterrupted, error-free operation. Tool results are provided for informational purposes and accuracy is not guaranteed.'],
                ['Limitation of Liability', 'Tripathi Nexora Technologies shall not be liable for any indirect, incidental, or consequential damages arising from your use of the Service. Our total liability shall not exceed the amount you paid us (which is zero for free tools).'],
                ['Privacy', 'Your use of the Service is also governed by our Privacy Policy, which is incorporated into these Terms.'],
                ['Modifications', 'We reserve the right to modify or discontinue any part of the Service at any time. We may update these Terms; continued use after changes constitutes acceptance.'],
                ['Governing Law', 'These Terms are governed by the laws of India. Any disputes shall be resolved in the courts of jurisdiction of Tripathi Nexora Technologies.'],
                ['Contact', 'For questions about these Terms, contact: ' . SITE_EMAIL],
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
