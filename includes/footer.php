<?php /** Nexora Tools — Global Footer */ ?>

</main><!-- /main-content -->

<!-- ─── FOOTER ──────────────────────────────────────────────────────────────── -->
<footer class="footer">
    <div class="container">
        <div class="footer-grid">

            <!-- Brand -->
            <div class="footer-brand">
                <a href="<?= BASE_URL ?>" class="footer-logo">
                    <span class="nav-logo-icon">N</span>
                    <span class="logo-nexora">Nexora</span>
                    <span class="logo-badge">Tools</span>
                </a>
                <p class="footer-tagline"><?= SITE_TAGLINE ?>. Free online tools for developers, designers, and everyone.</p>
                <div class="footer-social">
                    <a href="#" class="social-link" title="Twitter/X" aria-label="Twitter">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-4.714-6.231-5.401 6.231H2.748l7.73-8.835L1.254 2.25H8.08l4.253 5.622zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                    </a>
                    <a href="#" class="social-link" title="LinkedIn" aria-label="LinkedIn">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-2-2 2 2 0 0 0-2 2v7h-4v-7a6 6 0 0 1 6-6zM2 9h4v12H2z"/><circle cx="4" cy="4" r="2"/></svg>
                    </a>
                    <a href="https://github.com/anjaneyatripathi1995/nexora-tools" class="social-link" title="GitHub" aria-label="GitHub">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M9 19c-5 1.5-5-2.5-7-3m14 6v-3.87a3.37 3.37 0 0 0-.94-2.61c3.14-.35 6.44-1.54 6.44-7A5.44 5.44 0 0 0 20 4.77 5.07 5.07 0 0 0 19.91 1S18.73.65 16 2.48a13.38 13.38 0 0 0-7 0C6.27.65 5.09 1 5.09 1A5.07 5.07 0 0 0 5 4.77a5.44 5.44 0 0 0-1.5 3.78c0 5.42 3.3 6.61 6.44 7A3.37 3.37 0 0 0 9 18.13V22"/></svg>
                    </a>
                </div>
            </div>

            <!-- Tools -->
            <div class="footer-col">
                <h4 class="footer-heading">Popular Tools</h4>
                <ul class="footer-links">
                    <li><a href="<?= BASE_URL ?>json-formatter">JSON Formatter</a></li>
                    <li><a href="<?= BASE_URL ?>password-generator">Password Generator</a></li>
                    <li><a href="<?= BASE_URL ?>pdf-to-word">PDF to Word</a></li>
                    <li><a href="<?= BASE_URL ?>image-resizer">Image Resizer</a></li>
                    <li><a href="<?= BASE_URL ?>emi-calculator">EMI Calculator</a></li>
                    <li><a href="<?= BASE_URL ?>word-counter">Word Counter</a></li>
                </ul>
            </div>

            <!-- Categories -->
            <div class="footer-col">
                <h4 class="footer-heading">Categories</h4>
                <ul class="footer-links">
                    <?php foreach (CATEGORIES as $slug => $cat): ?>
                    <li><a href="<?= BASE_URL . $slug ?>"><?= $cat['icon'] ?> <?= $cat['name'] ?></a></li>
                    <?php endforeach; ?>
                </ul>
            </div>

            <!-- Company -->
            <div class="footer-col">
                <h4 class="footer-heading">Company</h4>
                <ul class="footer-links">
                    <li><a href="<?= BASE_URL ?>about">About Us</a></li>
                    <li><a href="<?= BASE_URL ?>contact">Contact</a></li>
                    <li><a href="<?= BASE_URL ?>privacy">Privacy Policy</a></li>
                    <li><a href="<?= BASE_URL ?>terms">Terms of Service</a></li>
                    <li><a href="mailto:<?= SITE_EMAIL ?>">Support</a></li>
                </ul>
            </div>

        </div>

        <!-- Bottom Bar -->
        <div class="footer-bottom">
            <p>&copy; <?= date('Y') ?> <?= SITE_COMPANY ?>. All rights reserved.</p>
            <p>Made with ❤️ in India &nbsp;·&nbsp; <a href="<?= BASE_URL ?>privacy">Privacy</a> &nbsp;·&nbsp; <a href="<?= BASE_URL ?>terms">Terms</a></p>
        </div>
    </div>
</footer>

<!-- ─── SCRIPTS ──────────────────────────────────────────────────────────────── -->
<!-- Inline tools data for JS search -->
<script>
window.NEXORA_TOOLS = <?= json_encode(array_map(fn($t) => [
    'slug' => $t['slug'],
    'name' => $t['name'],
    'desc' => $t['desc'],
    'cat'  => $t['cat'],
    'icon' => $t['icon'],
], TOOLS)) ?>;
window.BASE_URL = '<?= BASE_URL ?>';
</script>
<script src="<?= BASE_URL ?>assets/js/app.js?v=<?= APP_VERSION ?>"></script>
</body>
</html>
