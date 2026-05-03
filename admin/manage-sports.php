<?php
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/functions.php';
require_login();

$sports = $pdo->query("SELECT * FROM sports ORDER BY sort_order ASC")->fetchAll();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    if ($action === 'add' || $action === 'edit') {
        $name = $_POST['name'];
        $slug = $_POST['slug'];
        $icon = $_POST['icon'];
        $governing_body = $_POST['governing_body'];
        $ranking_type = $_POST['ranking_type'];
        $sort_order = (int)$_POST['sort_order'];

        if ($action === 'add') {
            $stmt = $pdo->prepare("INSERT INTO sports (name, slug, icon, governing_body, ranking_type, sort_order) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->execute([$name, $slug, $icon, $governing_body, $ranking_type, $sort_order]);
            $msg = "Added sport: " . $name;
        } else {
            $id = (int)$_POST['id'];
            $stmt = $pdo->prepare("UPDATE sports SET name = ?, slug = ?, icon = ?, governing_body = ?, ranking_type = ?, sort_order = ? WHERE id = ?");
            $stmt->execute([$name, $slug, $icon, $governing_body, $ranking_type, $sort_order, $id]);
            $msg = "Updated sport: " . $name;
        }

        $pdo->prepare("INSERT INTO activity_log (user_id, action) VALUES (?, ?)")->execute([$_SESSION[ADMIN_SESSION_NAME]['id'], $msg]);
        header("Location: manage-sports.php?success=1");
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Sports - Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Barlow:wght@700;900&family=Inter:wght@400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/admin.css">
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
</head>
<body class="bg-[#0a0a1a] text-[#EEEEFF] font-sans flex min-h-screen">

    <!-- Sidebar Placeholder (In real app, include a partial) -->
    <aside class="w-64 bg-[#141428] border-r border-[#1e2a40] hidden md:block">
        <div class="p-6 border-b border-[#1e2a40]">
            <h2 class="text-xl font-black italic uppercase tracking-tighter">Sporting<span class="text-[#F0A500]">Rank</span></h2>
        </div>
        <nav class="mt-6">
            <a href="dashboard.php" class="sidebar-link">📊 Dashboard</a>
            <a href="manage-sports.php" class="sidebar-link active">🏆 Manage Sports</a>
            <a href="manage-teams.php" class="sidebar-link">👥 Manage Teams</a>
            <a href="manage-settings.php" class="sidebar-link">⚙️ Site Settings</a>
        </nav>
    </aside>

    <main class="flex-1 p-8">
        <header class="flex justify-between items-center mb-10">
            <h1 class="text-3xl font-black uppercase italic tracking-tighter">Manage Sports</h1>
            <button onclick="document.getElementById('add-modal').classList.remove('hidden')" class="btn-primary text-xs uppercase">+ Add Sport</button>
        </header>

        <div class="admin-card overflow-hidden">
            <table class="w-full text-left">
                <thead class="bg-[#0a0a1a] text-[10px] font-black uppercase tracking-widest text-[#7A8AAA]">
                    <tr>
                        <th class="py-4 px-6">Order</th>
                        <th class="py-4 px-6">Sport</th>
                        <th class="py-4 px-6">Slug</th>
                        <th class="py-4 px-6">Governing Body</th>
                        <th class="py-4 px-6 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody id="manage-sports-list">
                    <?php foreach ($sports as $s): ?>
                        <tr class="border-b border-[#1e2a40] hover:bg-white/5 transition" data-id="<?php echo $s['id']; ?>">
                            <td class="py-4 px-6"><span class="drag-handle cursor-move opacity-30 hover:opacity-100">☰</span> <?php echo $s['sort_order']; ?></td>
                            <td class="py-4 px-6">
                                <div class="flex items-center space-x-3">
                                    <span><?php echo $s['icon']; ?></span>
                                    <span class="font-bold"><?php echo e($s['name']); ?></span>
                                </div>
                            </td>
                            <td class="py-4 px-6 text-[#7A8AAA] text-sm"><?php echo e($s['slug']); ?></td>
                            <td class="py-4 px-6 font-medium"><?php echo e($s['governing_body']); ?></td>
                            <td class="py-4 px-6 text-right">
                                <button class="text-blue-400 hover:text-blue-300 mr-4 font-bold text-xs">Edit</button>
                                <button class="text-red-400 hover:text-red-300 font-bold text-xs">Delete</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <!-- Simple Add Modal -->
        <div id="add-modal" class="fixed inset-0 bg-black/80 flex items-center justify-center z-50 hidden">
            <div class="admin-card w-full max-w-lg p-8">
                <h3 class="text-xl font-black uppercase italic tracking-tighter mb-6">Add New Sport</h3>
                <form method="POST">
                    <input type="hidden" name="action" value="add">
                    <div class="grid grid-cols-2 gap-4">
                        <div class="mb-4">
                            <label class="block text-[10px] font-black uppercase tracking-widest text-[#7A8AAA] mb-1">Name</label>
                            <input type="text" name="name" class="form-input" required>
                        </div>
                        <div class="mb-4">
                            <label class="block text-[10px] font-black uppercase tracking-widest text-[#7A8AAA] mb-1">Slug</label>
                            <input type="text" name="slug" class="form-input" required placeholder="soccer">
                        </div>
                        <div class="mb-4">
                            <label class="block text-[10px] font-black uppercase tracking-widest text-[#7A8AAA] mb-1">Icon (Emoji)</label>
                            <input type="text" name="icon" class="form-input" value="🏆">
                        </div>
                        <div class="mb-4">
                            <label class="block text-[10px] font-black uppercase tracking-widest text-[#7A8AAA] mb-1">Sort Order</label>
                            <input type="number" name="sort_order" class="form-input" value="0">
                        </div>
                        <div class="mb-4">
                            <label class="block text-[10px] font-black uppercase tracking-widest text-[#7A8AAA] mb-1">Governing Body</label>
                            <input type="text" name="governing_body" class="form-input" placeholder="FIFA">
                        </div>
                        <div class="mb-4">
                            <label class="block text-[10px] font-black uppercase tracking-widest text-[#7A8AAA] mb-1">Ranking Type</label>
                            <input type="text" name="ranking_type" class="form-input" placeholder="Points">
                        </div>
                    </div>
                    <div class="flex justify-end space-x-4 mt-6">
                        <button type="button" onclick="document.getElementById('add-modal').classList.add('hidden')" class="px-6 py-2 text-[#7A8AAA] font-bold uppercase text-xs">Cancel</button>
                        <button type="submit" class="btn-primary text-xs uppercase">Save Sport</button>
                    </div>
                </form>
            </div>
        </div>
    </main>

    <script src="../assets/js/admin.js"></script>
</body>
</html>
