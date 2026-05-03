<?php
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/functions.php';
require_login();

$stats = [
    'sports' => $pdo->query("SELECT COUNT(*) FROM sports")->fetchColumn(),
    'teams' => $pdo->query("SELECT COUNT(*) FROM teams")->fetchColumn(),
    'last_updated' => get_setting('last_updated', '2026-05-01')
];

$recent_activity = $pdo->query("SELECT * FROM activity_log ORDER BY created_at DESC LIMIT 5")->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - SportingRank</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Barlow:wght@700;900&family=Inter:wght@400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/admin.css">
</head>
<body class="bg-[#0a0a1a] text-[#EEEEFF] font-sans flex min-h-screen">

    <!-- Sidebar -->
    <aside id="admin-sidebar" class="w-64 bg-[#141428] border-r border-[#1e2a40] flex-shrink-0 transition-transform md:translate-x-0 -translate-x-full fixed md:relative h-full z-50">
        <div class="p-6 border-b border-[#1e2a40]">
            <h2 class="text-xl font-black italic uppercase tracking-tighter">
                Sporting<span class="text-[#F0A500]">Rank</span>
            </h2>
        </div>
        <nav class="mt-6">
            <a href="dashboard.php" class="sidebar-link active">
                <span class="mr-3">📊</span> Dashboard
            </a>
            <a href="manage-sports.php" class="sidebar-link">
                <span class="mr-3">🏆</span> Manage Sports
            </a>
            <a href="manage-teams.php" class="sidebar-link">
                <span class="mr-3">👥</span> Manage Teams
            </a>
            <a href="manage-settings.php" class="sidebar-link">
                <span class="mr-3">⚙️</span> Site Settings
            </a>
            <div class="mt-auto pt-10">
                <a href="logout.php" class="sidebar-link text-red-400 hover:text-red-300">
                    <span class="mr-3">🚪</span> Logout
                </a>
            </div>
        </nav>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 p-8 md:p-12 overflow-y-auto">
        <header class="flex justify-between items-center mb-10">
            <div>
                <h1 class="text-3xl font-black uppercase italic tracking-tighter">Admin Dashboard</h1>
                <p class="text-[#7A8AAA] font-medium text-sm">Welcome back, <?php echo e($_SESSION[ADMIN_SESSION_NAME]['username']); ?></p>
            </div>
            <a href="../index.php" target="_blank" class="text-xs font-bold uppercase tracking-widest text-[#F0A500] hover:underline">View Live Site →</a>
        </header>

        <!-- Stats Grid -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
            <div class="admin-card p-6 flex flex-col justify-center items-center text-center">
                <span class="text-4xl mb-2">🏆</span>
                <div class="text-2xl font-black"><?php echo $stats['sports']; ?></div>
                <div class="text-[10px] font-black uppercase tracking-widest text-[#7A8AAA]">Total Sports</div>
            </div>
            <div class="admin-card p-6 flex flex-col justify-center items-center text-center">
                <span class="text-4xl mb-2">👥</span>
                <div class="text-2xl font-black"><?php echo $stats['teams']; ?></div>
                <div class="text-[10px] font-black uppercase tracking-widest text-[#7A8AAA]">Teams Ranked</div>
            </div>
            <div class="admin-card p-6 flex flex-col justify-center items-center text-center">
                <span class="text-4xl mb-2">📅</span>
                <div class="text-2xl font-black"><?php echo e($stats['last_updated']); ?></div>
                <div class="text-[10px] font-black uppercase tracking-widest text-[#7A8AAA]">Last Updated</div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Recent Activity -->
            <div class="admin-card">
                <div class="p-6 border-b border-[#1e2a40]">
                    <h3 class="font-black uppercase italic tracking-tighter">Recent Activity</h3>
                </div>
                <div class="p-6">
                    <?php if (empty($recent_activity)): ?>
                        <p class="text-[#7A8AAA] text-sm italic">No recent activity found.</p>
                    <?php else: ?>
                        <div class="space-y-4">
                            <?php foreach ($recent_activity as $act): ?>
                                <div class="flex items-start space-x-3 border-b border-[#1e2a40]/50 pb-3 last:border-0">
                                    <div class="w-2 h-2 rounded-full bg-[#F0A500] mt-1.5"></div>
                                    <div>
                                        <p class="text-sm font-medium"><?php echo e($act['action']); ?></p>
                                        <span class="text-[10px] text-[#7A8AAA]"><?php echo e($act['created_at']); ?></span>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="space-y-6">
                <div class="admin-card p-6">
                    <h3 class="font-black uppercase italic tracking-tighter mb-4">Quick Actions</h3>
                    <div class="grid grid-cols-2 gap-4">
                        <a href="manage-teams.php" class="bg-blue-600/10 text-blue-400 p-4 rounded text-center font-bold text-xs hover:bg-blue-600/20 transition">Update Rankings</a>
                        <a href="manage-sports.php" class="bg-green-600/10 text-green-400 p-4 rounded text-center font-bold text-xs hover:bg-green-600/20 transition">Add New Sport</a>
                        <a href="manage-settings.php" class="bg-purple-600/10 text-purple-400 p-4 rounded text-center font-bold text-xs hover:bg-purple-600/20 transition">Site Settings</a>
                        <a href="#" class="bg-orange-600/10 text-orange-400 p-4 rounded text-center font-bold text-xs hover:bg-orange-600/20 transition">System Logs</a>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script src="../assets/js/admin.js"></script>
</body>
</html>
