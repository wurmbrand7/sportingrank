<?php
session_start();
require_once __DIR__ . '/../config.php';

function is_logged_in() {
    return isset($_SESSION[ADMIN_SESSION_NAME]);
}

function require_login() {
    if (!is_logged_in()) {
        header("Location: " . SITE_URL . "/admin/index.php");
        exit;
    }
}

function login($user_id, $username) {
    $_SESSION[ADMIN_SESSION_NAME] = [
        'id' => $user_id,
        'username' => $username,
        'login_time' => time()
    ];
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    session_regenerate_id(true);
}

function logout() {
    unset($_SESSION[ADMIN_SESSION_NAME]);
    unset($_SESSION['csrf_token']);
    session_destroy();
}

function get_csrf_token() {
    if (!isset($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

function verify_csrf_token($token) {
    return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}
?>
