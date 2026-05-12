<?php
/**
 * SportingRank.com Configuration
 * Update these settings with your cPanel MySQL details.
 */

// --- Database Connection Settings ---
// For MySQL (Default for cPanel/Production)
define('DB_HOST', 'localhost');
define('DB_USER', 'your_db_user');     // Replace with your database username
define('DB_PASS', 'your_db_password'); // Replace with your database password
define('DB_NAME', 'your_db_name');     // Replace with your database name

// --- Site Settings ---
define('SITE_URL', 'https://sportingrank.com'); // Your domain name
define('ADMIN_SESSION_NAME', 'sr_admin_token');

/**
 * DEVELOPMENT NOTE:
 * To use SQLite for local development, uncomment the lines below.
 */
// define('DB_TYPE', 'sqlite');
// define('DB_PATH', __DIR__ . '/sportingrank.sqlite');
?>
