<?php
$page_title = 'Contact Us';
$success = $error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? ''); $email = trim($_POST['email'] ?? ''); $message = trim($_POST['message'] ?? '');
    if (!$name || !$email || !$message) $error = 'Please fill in all required fields.';
    elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) $error = 'Please enter a valid email address.';
    else { @mail(SITE_EMAIL, '[Nexora] ' . trim($_POST['subject'] ?? 'Enquiry'), "From: $name <$email>\n\n$message", "From: $name <$email>\r\nReply-To: $email"); $success = 'Message sent! We\'ll reply within 1–2 business days.'; }
}
require ROOT . '/includes/header.php';
?>
<div class="sub-banner"><div class="container"><div class="sub-banner-inner"><h1>Contact Us</h1><p>We read every message — don't hesitate to reach out!</p></div></div></div>
<section class="section"><div class="container">
<div style="display:grid;grid-template-columns:1fr 1.6fr;gap:48px;align-items:start;max-width:960px;margin:0 auto">
    <div>
        <h3 style="margin-bottom:24px">Get in touch</h3>
        <?php foreach ([['📧','Email',SITE_EMAIL],['🌐','Website',SITE_DOMAIN],['🏢','Company',SITE_COMPANY],['⏱️','Response','Within 1–2 business days']] as [$ic,$label,$val]): ?>
        <div style="display:flex;gap:14px;align-items:flex-start;margin-bottom:20px"><span style="font-size:1.4rem"><?= $ic ?></span><div><div style="font-weight:600;margin-bottom:2px"><?= $label ?></div><span style="color:var(--text-2);font-size:.9rem"><?= e($val) ?></span></div></div>
        <?php endforeach; ?>
    </div>
    <div class="tool-wrap">
        <?php if ($success): ?><div class="alert alert-success"><?= e($success) ?></div><?php endif; ?>
        <?php if ($error): ?><div class="alert alert-error"><?= e($error) ?></div><?php endif; ?>
        <form method="POST">
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px">
                <div class="form-group"><label class="form-label">Name *</label><input type="text" name="name" class="form-input" required placeholder="Your name" value="<?= e($_POST['name'] ?? '') ?>"></div>
                <div class="form-group"><label class="form-label">Email *</label><input type="email" name="email" class="form-input" required placeholder="you@example.com" value="<?= e($_POST['email'] ?? '') ?>"></div>
            </div>
            <div class="form-group"><label class="form-label">Subject</label><input type="text" name="subject" class="form-input" placeholder="What's this about?" value="<?= e($_POST['subject'] ?? '') ?>"></div>
            <div class="form-group"><label class="form-label">Message *</label><textarea name="message" class="form-textarea" required placeholder="Your message…"><?= e($_POST['message'] ?? '') ?></textarea></div>
            <button type="submit" class="btn btn-primary w-full btn-lg">Send Message →</button>
        </form>
    </div>
</div>
</div></section>
<?php require ROOT . '/includes/footer.php'; ?>
