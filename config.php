<?php
// Default to SQLite for local development and verification
define('DB_TYPE', 'sqlite');
define('DB_PATH', __DIR__ . '/sportingrank.db');

// MySQL Template (uncomment and fill for cPanel deployment)
/*
define('DB_TYPE', 'mysql');
define('DB_HOST', 'localhost');
define('DB_USER', 'your_db_user');
define('DB_PASS', 'your_db_password');
define('DB_NAME', 'your_db_name');
*/

// Update this to your production URL
define('SITE_URL', 'http://localhost:8080');

define('ADMIN_SESSION_NAME', 'sr_admin_token');
?>
