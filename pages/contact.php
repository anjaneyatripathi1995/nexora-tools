<?php
$page_title = 'Contact Us';
$page_desc  = 'Get in touch with the Nexora Tools team. We\'d love to hear your feedback, bug reports, or collaboration ideas.';
$success = $error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name    = trim($_POST['name']    ?? '');
    $email   = trim($_POST['email']   ?? '');
    $subject = trim($_POST['subject'] ?? '');
    $message = trim($_POST['message'] ?? '');

    if (!$name || !$email || !$message) {
        $error = 'Please fill in all required fields.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Please enter a valid email address.';
    } else {
        // Send email (configure your SMTP in production)
        $to      = SITE_EMAIL;
        $headers = "From: $name <$email>\r\nReply-To: $email\r\nContent-Type: text/plain; charset=UTF-8";
        $body    = "Name: $name\nEmail: $email\nSubject: $subject\n\n$message";
        @mail($to, '[Nexora Tools] ' . $subject, $body, $headers);
        $success = 'Message sent! We\'ll get back to you within 1-2 business days.';
    }
}

require ROOT . '/includes/header.php';
?>

<div class="sub-banner">
    <div class="container">
        <div class="sub-banner-inner">
            <h1>Contact Us</h1>
            <p>We read every message. Don't hesitate to reach out!</p>
        </div>
    </div>
</div>

<section class="section">
    <div class="container">
        <div style="display:grid;grid-template-columns:1fr 1.6fr;gap:48px;align-items:start;max-width:960px;margin:0 auto">

            <!-- Contact Info -->
            <div>
                <h3 style="margin-bottom:24px">Get in touch</h3>
                <div style="display:flex;flex-direction:column;gap:20px">
                    <div style="display:flex;gap:14px;align-items:flex-start">
                        <span style="font-size:1.4rem">📧</span>
                        <div>
                            <div style="font-weight:600;margin-bottom:2px">Email</div>
                            <a href="mailto:<?= SITE_EMAIL ?>" style="color:var(--text-2);font-size:0.9rem"><?= SITE_EMAIL ?></a>
                        </div>
                    </div>
                    <div style="display:flex;gap:14px;align-items:flex-start">
                        <span style="font-size:1.4rem">🌐</span>
                        <div>
                            <div style="font-weight:600;margin-bottom:2px">Website</div>
                            <span style="color:var(--text-2);font-size:0.9rem"><?= SITE_DOMAIN ?></span>
                        </div>
                    </div>
                    <div style="display:flex;gap:14px;align-items:flex-start">
                        <span style="font-size:1.4rem">🏢</span>
                        <div>
                            <div style="font-weight:600;margin-bottom:2px">Company</div>
                            <span style="color:var(--text-2);font-size:0.9rem"><?= SITE_COMPANY ?></span>
                        </div>
                    </div>
                    <div style="display:flex;gap:14px;align-items:flex-start">
                        <span style="font-size:1.4rem">⏱️</span>
                        <div>
                            <div style="font-weight:600;margin-bottom:2px">Response Time</div>
                            <span style="color:var(--text-2);font-size:0.9rem">Within 1–2 business days</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Contact Form -->
            <div class="tool-wrap">
                <?php if ($success): ?><div class="alert alert-success"><?= e($success) ?></div><?php endif; ?>
                <?php if ($error):   ?><div class="alert alert-error"><?= e($error) ?></div><?php endif; ?>

                <form method="POST" action="">
                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px">
                        <div class="form-group">
                            <label class="form-label">Name *</label>
                            <input type="text" name="name" class="form-input" required placeholder="Your name" value="<?= e($_POST['name'] ?? '') ?>">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Email *</label>
                            <input type="email" name="email" class="form-input" required placeholder="you@example.com" value="<?= e($_POST['email'] ?? '') ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Subject</label>
                        <input type="text" name="subject" class="form-input" placeholder="What's this about?" value="<?= e($_POST['subject'] ?? '') ?>">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Message *</label>
                        <textarea name="message" class="form-textarea" required placeholder="Tell us what you think, report a bug, or ask a question..."><?= e($_POST['message'] ?? '') ?></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary w-full btn-lg">Send Message →</button>
                </form>
            </div>

        </div>
    </div>
</section>

<style>
@media (max-width: 720px) {
    .contact-grid { grid-template-columns: 1fr !important; }
}
</style>

<?php require ROOT . '/includes/footer.php'; ?>
