<?php
// Since we don't have MySQL in this environment, I'll use SQLite for development/demo purposes
// In a real cPanel environment, you would use the MySQL credentials provided by the user.

define('DB_TYPE', 'sqlite'); // Custom addition to handle sqlite in this environment
define('DB_PATH', __DIR__ . '/sportingrank.sqlite');

define('DB_HOST', 'localhost');
define('DB_USER', 'jules_admin');
define('DB_PASS', 'Admin@1234');
define('DB_NAME', 'sportingrank_db');
define('SITE_URL', 'http://localhost:8000');
define('ADMIN_SESSION_NAME', 'sr_admin_token');
?>
