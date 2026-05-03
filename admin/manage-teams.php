<?php
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/functions.php';
require_login();

$sport_id = (int)($_GET['sport_id'] ?? ($pdo->query("SELECT id FROM sports LIMIT 1")->fetchColumn() ?: 0));
$sports = $pdo->query("SELECT id, name FROM sports ORDER BY sort_order ASC")->fetchAll();
$teams = $pdo->prepare("SELECT * FROM teams WHERE sport_id = ? ORDER BY rank_position ASC");
$teams->execute([$sport_id]);
$teams = $teams->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Teams - Admin</title>
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
            <a href="manage-teams.php" class="sidebar-link active">👥 Manage Teams</a>
            <a href="manage-settings.php" class="sidebar-link">⚙️ Site Settings</a>
        </nav>
    </aside>

    <main class="flex-1 p-8">
        <header class="flex flex-col md:flex-row justify-between items-start md:items-center mb-10 gap-4">
            <div>
                <h1 class="text-3xl font-black uppercase italic tracking-tighter">Manage Rankings</h1>
                <div class="mt-2">
                    <select onchange="window.location.href='?sport_id=' + this.value" class="form-input !w-auto text-xs font-bold uppercase">
                        <?php foreach ($sports as $s): ?>
                            <option value="<?php echo $s['id']; ?>" <?php echo $s['id'] == $sport_id ? 'selected' : ''; ?>><?php echo e($s['name']); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <button class="btn-primary text-xs uppercase">+ Add Team</button>
        </header>

        <div class="admin-card overflow-hidden">
            <table class="w-full text-left">
                <thead class="bg-[#0a0a1a] text-[10px] font-black uppercase tracking-widest text-[#7A8AAA]">
                    <tr>
                        <th class="py-4 px-6">Rank</th>
                        <th class="py-4 px-6">Team / Country</th>
                        <th class="py-4 px-6 text-right">Points</th>
                        <th class="py-4 px-6 text-center">Trend</th>
                        <th class="py-4 px-6 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody id="manage-teams-list">
                    <?php foreach ($teams as $t): ?>
                        <tr class="border-b border-[#1e2a40] hover:bg-white/5 transition">
                            <td class="py-4 px-6 font-heading font-black italic text-lg text-[#F0A500]">#<?php echo $t['rank_position']; ?></td>
                            <td class="py-4 px-6">
                                <div class="flex items-center space-x-3">
                                    <img src="https://flagcdn.com/24x18/<?php echo strtolower($t['country_code']); ?>.png" alt="" class="rounded-sm">
                                    <span class="font-bold"><?php echo e($t['team_name']); ?></span>
                                </div>
                            </td>
                            <td class="py-4 px-6 text-right font-mono font-bold text-sm"><?php echo number_format($t['points']); ?></td>
                            <td class="py-4 px-6 text-center uppercase text-[10px] font-black"><?php echo e($t['trend']); ?></td>
                            <td class="py-4 px-6 text-right">
                                <button class="text-blue-400 hover:text-blue-300 mr-4 font-bold text-xs">Edit</button>
                                <button class="text-red-400 hover:text-red-300 font-bold text-xs">Delete</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
    <script src="../assets/js/admin.js"></script>
</body>
</html>
