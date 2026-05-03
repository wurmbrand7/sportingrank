<?php
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/functions.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    if (!isset($_SESSION['login_attempts'])) $_SESSION['login_attempts'] = 0;

    if ($_SESSION['login_attempts'] >= 5) {
        $error = "Too many failed attempts. Please try again later.";
    } else {
        $stmt = $pdo->prepare("SELECT id, username, password_hash FROM admin_users WHERE username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password_hash'])) {
            login($user['id'], $user['username']);
            $_SESSION['login_attempts'] = 0;
            header("Location: dashboard.php");
            exit;
        } else {
            $_SESSION['login_attempts']++;
            $error = "Invalid username or password.";
        }
    }
}

if (is_logged_in()) {
    header("Location: dashboard.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - SportingRank</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Barlow:wght@700;900&family=Inter:wght@400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/admin.css">
</head>
<body class="bg-[#0a0a1a] flex items-center justify-center min-h-screen">
    <div class="w-full max-w-md p-8">
        <div class="text-center mb-8">
            <h1 class="text-3xl font-black text-white italic uppercase tracking-tighter">
                Sporting<span class="text-[#F0A500]">Rank</span> Admin
            </h1>
        </div>

        <div class="admin-card p-8">
            <form method="POST">
                <div class="mb-6">
                    <label class="block text-xs font-black uppercase tracking-widest text-[#7A8AAA] mb-2">Username</label>
                    <input type="text" name="username" class="form-input" required autofocus>
                </div>
                <div class="mb-6">
                    <label class="block text-xs font-black uppercase tracking-widest text-[#7A8AAA] mb-2">Password</label>
                    <input type="password" name="password" class="form-input" required>
                </div>

                <?php if ($error): ?>
                    <div class="mb-6 text-red-500 text-xs font-bold text-center"><?php echo e($error); ?></div>
                <?php endif; ?>

                <button type="submit" class="w-full btn-primary uppercase italic tracking-tighter">Login to Dashboard</button>
            </form>
        </div>
    </div>
</body>
</html>
