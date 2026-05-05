<?php
require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/includes/db.php';

$stmt = $pdo->prepare("SELECT id, username FROM admin_users WHERE username = 'admin' LIMIT 1");
$stmt->execute();
$user = $stmt->fetch();

if ($user) {
    login($user['id'], $user['username']);
    echo "Logged in as admin";
} else {
    echo "Admin user not found";
}
?>
