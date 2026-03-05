<?php
/**
 * Nexora Tools — Web Entry Point
 *
 * On XAMPP    : http://localhost/nexora-tools/  (via root index.php → this file)
 * On Hostinger: https://tripathinexora.com/     (public/ contents uploaded to public_html/)
 *
 * ROOT        = project root (parent of public/)
 * PUBLIC_PATH = this directory (public/)
 */
define('ROOT',        dirname(__DIR__));
define('PUBLIC_PATH', __DIR__);
define('APP_VERSION', '2.0.0');

require ROOT . '/includes/config.php';
require ROOT . '/includes/router.php';
