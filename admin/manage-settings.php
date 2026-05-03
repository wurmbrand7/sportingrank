<?php
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/functions.php';
require_login();

$settings = get_all_settings();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    foreach ($_POST as $key => $value) {
        $stmt = $pdo->prepare("INSERT INTO site_settings (setting_key, setting_value) VALUES (?, ?) ON CONFLICT(setting_key) DO UPDATE SET setting_value = excluded.setting_value");
        $stmt->execute([$key, $value]);
    }
    header("Location: manage-settings.php?success=1");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Site Settings - Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Barlow:wght@700;900&family=Inter:wght@400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/admin.css">
</head>
<body class="bg-[#0a0a1a] text-[#EEEEFF] font-sans flex min-h-screen">

    <!-- Sidebar Placeholder -->
    <aside class="w-64 bg-[#141428] border-r border-[#1e2a40] hidden md:block">
        <div class="p-6 border-b border-[#1e2a40]">
            <h2 class="text-xl font-black italic uppercase tracking-tighter">Sporting<span class="text-[#F0A500]">Rank</span></h2>
        </div>
        <nav class="mt-6">
            <a href="dashboard.php" class="sidebar-link">📊 Dashboard</a>
            <a href="manage-sports.php" class="sidebar-link">🏆 Manage Sports</a>
            <a href="manage-teams.php" class="sidebar-link">👥 Manage Teams</a>
            <a href="manage-settings.php" class="sidebar-link active">⚙️ Site Settings</a>
        </nav>
    </aside>

    <main class="flex-1 p-8">
        <header class="mb-10">
            <h1 class="text-3xl font-black uppercase italic tracking-tighter">Site Settings</h1>
        </header>

        <form method="POST" class="max-w-4xl">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- General -->
                <div class="admin-card p-6">
                    <h3 class="font-black uppercase tracking-widest text-[#F0A500] text-xs mb-6">General Information</h3>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-[10px] font-black uppercase tracking-widest text-[#7A8AAA] mb-1">Site Title</label>
                            <input type="text" name="site_title" class="form-input" value="<?php echo e($settings['site_title'] ?? ''); ?>">
                        </div>
                        <div>
                            <label class="block text-[10px] font-black uppercase tracking-widest text-[#7A8AAA] mb-1">Tagline</label>
                            <input type="text" name="site_tagline" class="form-input" value="<?php echo e($settings['site_tagline'] ?? ''); ?>">
                        </div>
                        <div>
                            <label class="block text-[10px] font-black uppercase tracking-widest text-[#7A8AAA] mb-1">Footer Text</label>
                            <input type="text" name="footer_text" class="form-input" value="<?php echo e($settings['footer_text'] ?? ''); ?>">
                        </div>
                    </div>
                </div>

                <!-- Design -->
                <div class="admin-card p-6">
                    <h3 class="font-black uppercase tracking-widest text-[#F0A500] text-xs mb-6">Design & SEO</h3>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-[10px] font-black uppercase tracking-widest text-[#7A8AAA] mb-1">Accent Color</label>
                            <div class="flex space-x-2">
                                <input type="color" name="accent_color" class="h-10 w-10 bg-transparent border-0" value="<?php echo e($settings['accent_color'] ?? '#F0A500'); ?>">
                                <input type="text" class="form-input" value="<?php echo e($settings['accent_color'] ?? '#F0A500'); ?>" readonly>
                            </div>
                        </div>
                        <div>
                            <label class="block text-[10px] font-black uppercase tracking-widest text-[#7A8AAA] mb-1">Meta Description</label>
                            <textarea name="meta_description" class="form-input h-24"><?php echo e($settings['meta_description'] ?? ''); ?></textarea>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-8 flex justify-end">
                <button type="submit" class="btn-primary uppercase italic tracking-tighter px-12">Save All Settings</button>
            </div>
        </form>
    </main>

    <script src="../assets/js/admin.js"></script>
</body>
</html>
