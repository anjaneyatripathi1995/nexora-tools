<?php
/**
 * Nexora Tools — Single Entry Point
 * All requests are routed through this file via .htaccess
 */

define('ROOT', __DIR__);
define('APP_VERSION', '2.0.0');

require_once ROOT . '/includes/config.php';
require_once ROOT . '/includes/router.php';
