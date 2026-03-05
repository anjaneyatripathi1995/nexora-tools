<?php
/**
 * Nexora Tools — XAMPP Development Convenience Entry
 *
 * On local XAMPP at http://localhost/nexora-tools/, this file
 * forwards all requests to public/index.php, which is the real entry point.
 *
 * On Hostinger, this file is NOT used — only public/ contents go to public_html/.
 */
require __DIR__ . '/public/index.php';
