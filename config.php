<?php
/**
 * SportingRank.com - Config
 *
 * Instructions for User:
 * 1. For local testing/SQLite: Keep DB_TYPE as 'sqlite'.
 * 2. For cPanel/MySQL: Change DB_TYPE to 'mysql' and fill in your credentials below.
 */

// --- DATABASE CONFIGURATION ---
// Change to 'mysql' when deploying to cPanel
define('DB_TYPE', 'sqlite');

// MySQL Credentials (Used if DB_TYPE is 'mysql')
define('DB_HOST', 'localhost');
define('DB_USER', 'your_db_user');
define('DB_PASS', 'your_db_password');
define('DB_NAME', 'your_db_name');

// SQLite Path (Used if DB_TYPE is 'sqlite')
define('DB_PATH', __DIR__ . '/sportingrank.db');


// --- SITE CONFIGURATION ---
// Update this to your live domain (e.g., https://sportingrank.com)
define('SITE_URL', 'http://localhost:8000');

define('ADMIN_SESSION_NAME', 'sr_admin_token');
?>
