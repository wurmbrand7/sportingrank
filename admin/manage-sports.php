<?php
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/functions.php';
require_login();

$sports = $pdo->query("SELECT * FROM sports ORDER BY sort_order ASC")->fetchAll();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!verify_csrf_token($_POST['csrf_token'] ?? '')) {
        die("CSRF token validation failed.");
    }
    $action = $_POST['action'] ?? '';

    if ($action === 'add' || $action === 'edit') {
        $name = $_POST['name'];
        $slug = $_POST['slug'];
        $icon = $_POST['icon'];
        $governing_body = $_POST['governing_body'];
        $ranking_type = $_POST['ranking_type'];
        $sort_order = (int)$_POST['sort_order'];

        $label_national = $_POST['label_national'] ?? 'National';
        $label_club = $_POST['label_club'] ?? 'Leagues';

        if ($action === 'add') {
            $stmt = $pdo->prepare("INSERT INTO sports (name, slug, icon, governing_body, ranking_type, sort_order, label_national, label_club) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([$name, $slug, $icon, $governing_body, $ranking_type, $sort_order, $label_national, $label_club]);
            $msg = "Added sport: " . $name;
        } else {
            $id = (int)$_POST['id'];
            $stmt = $pdo->prepare("UPDATE sports SET name = ?, slug = ?, icon = ?, governing_body = ?, ranking_type = ?, sort_order = ?, label_national = ?, label_club = ? WHERE id = ?");
            $stmt->execute([$name, $slug, $icon, $governing_body, $ranking_type, $sort_order, $label_national, $label_club, $id]);
            $msg = "Updated sport: " . $name;
        }

        $pdo->prepare("INSERT INTO activity_log (user_id, action) VALUES (?, ?)")->execute([$_SESSION[ADMIN_SESSION_NAME]['id'], $msg]);
        header("Location: manage-sports.php?success=1");
        exit;
    }

    if ($action === 'delete') {
        $id = (int)$_POST['id'];
        $stmt = $pdo->prepare("DELETE FROM sports WHERE id = ?");
        $stmt->execute([$id]);
        $pdo->prepare("INSERT INTO activity_log (user_id, action) VALUES (?, ?)")->execute([$_SESSION[ADMIN_SESSION_NAME]['id'], "Deleted sport ID: " . $id]);
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
    <!-- SortableJS -->
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
</head>
<body class="bg-[#0a0a1a] text-[#EEEEFF] font-sans flex min-h-screen">

    <aside class="w-64 bg-[#141428] border-r border-[#1e2a40] hidden md:block">
        <div class="p-6 border-b border-[#1e2a40]">
            <h2 class="text-xl font-black italic uppercase tracking-tighter">Sporting<span class="text-[#F0A500]">Rank</span></h2>
        </div>
        <nav class="mt-6">
            <a href="dashboard.php" class="sidebar-link">📊 Dashboard</a>
            <a href="manage-sports.php" class="sidebar-link active">🏆 Manage Sports</a>
            <a href="manage-teams.php" class="sidebar-link">👥 Manage Teams</a>
            <a href="manage-blogs.php" class="sidebar-link">📝 Manage Blogs</a>
            <a href="manage-backlinks.php" class="sidebar-link">🔗 Backlinks</a>
            <a href="manage-settings.php" class="sidebar-link">⚙️ Site Settings</a>
        </nav>
    </aside>

    <main class="flex-1 p-8">
        <header class="flex justify-between items-center mb-10">
            <h1 class="text-3xl font-black uppercase italic tracking-tighter">Manage Sports</h1>
            <button onclick="openModal('add')" class="btn-primary text-xs uppercase">+ Add Sport</button>
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
                <tbody>
                    <?php foreach ($sports as $s): ?>
                        <tr class="border-b border-[#1e2a40] hover:bg-white/5 transition">
                            <td class="py-4 px-6"><?php echo $s['sort_order']; ?></td>
                            <td class="py-4 px-6">
                                <div class="flex items-center space-x-3">
                                    <span><?php echo $s['icon']; ?></span>
                                    <span class="font-bold"><?php echo e($s['name']); ?></span>
                                </div>
                            </td>
                            <td class="py-4 px-6 text-[#7A8AAA] text-sm"><?php echo e($s['slug']); ?></td>
                            <td class="py-4 px-6 font-medium"><?php echo e($s['governing_body']); ?></td>
                            <td class="py-4 px-6 text-right">
                                <button onclick='openModal("edit", <?php echo json_encode($s); ?>)' class="text-blue-400 hover:text-blue-300 mr-4 font-bold text-xs">Edit</button>
                                <form method="POST" class="inline" onsubmit="return confirm('Delete this sport and all its teams?')">
                                    <input type="hidden" name="action" value="delete">
                                    <input type="hidden" name="id" value="<?php echo $s['id']; ?>">
                                    <button type="submit" class="text-red-400 hover:text-red-300 font-bold text-xs">Delete</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <!-- Add/Edit Modal -->
        <div id="sport-modal" class="fixed inset-0 bg-black/80 flex items-center justify-center z-50 hidden">
            <div class="admin-card w-full max-w-lg p-8">
                <h3 id="modal-title" class="text-xl font-black uppercase italic tracking-tighter mb-6">Add New Sport</h3>
                <form method="POST">
                    <input type="hidden" name="csrf_token" value="<?php echo get_csrf_token(); ?>">
                    <input type="hidden" name="action" id="form-action" value="add">
                    <input type="hidden" name="id" id="form-id" value="">
                    <div class="grid grid-cols-2 gap-4">
                        <div class="mb-4">
                            <label class="block text-[10px] font-black uppercase tracking-widest text-[#7A8AAA] mb-1">Name</label>
                            <input type="text" name="name" id="form-name" class="form-input" required>
                        </div>
                        <div class="mb-4">
                            <label class="block text-[10px] font-black uppercase tracking-widest text-[#7A8AAA] mb-1">Slug</label>
                            <input type="text" name="slug" id="form-slug" class="form-input" required>
                        </div>
                        <div class="mb-4">
                            <label class="block text-[10px] font-black uppercase tracking-widest text-[#7A8AAA] mb-1">Icon</label>
                            <input type="text" name="icon" id="form-icon" class="form-input">
                        </div>
                        <div class="mb-4">
                            <label class="block text-[10px] font-black uppercase tracking-widest text-[#7A8AAA] mb-1">Sort Order</label>
                            <input type="number" name="sort_order" id="form-order" class="form-input">
                        </div>
                        <div class="mb-4">
                            <label class="block text-[10px] font-black uppercase tracking-widest text-[#7A8AAA] mb-1">Governing Body</label>
                            <input type="text" name="governing_body" id="form-gov" class="form-input">
                        </div>
                        <div class="mb-4">
                            <label class="block text-[10px] font-black uppercase tracking-widest text-[#7A8AAA] mb-1">Ranking Type</label>
                            <input type="text" name="ranking_type" id="form-type" class="form-input">
                        </div>
                        <div class="mb-4">
                            <label class="block text-[10px] font-black uppercase tracking-widest text-[#7A8AAA] mb-1">National Label</label>
                            <input type="text" name="label_national" id="form-label-national" class="form-input" placeholder="National">
                        </div>
                        <div class="mb-4">
                            <label class="block text-[10px] font-black uppercase tracking-widest text-[#7A8AAA] mb-1">Club/League Label</label>
                            <input type="text" name="label_club" id="form-label-club" class="form-input" placeholder="Leagues">
                        </div>
                    </div>
                    <div class="flex justify-end space-x-4 mt-6">
                        <button type="button" onclick="closeModal()" class="px-6 py-2 text-[#7A8AAA] font-bold uppercase text-xs">Cancel</button>
                        <button type="submit" class="btn-primary text-xs uppercase">Save Sport</button>
                    </div>
                </form>
            </div>
        </div>
    </main>

    <script>
        function openModal(mode, data = null) {
            document.getElementById('sport-modal').classList.remove('hidden');
            if (mode === 'edit' && data) {
                document.getElementById('modal-title').innerText = 'Edit Sport';
                document.getElementById('form-action').value = 'edit';
                document.getElementById('form-id').value = data.id;
                document.getElementById('form-name').value = data.name;
                document.getElementById('form-slug').value = data.slug;
                document.getElementById('form-icon').value = data.icon;
                document.getElementById('form-order').value = data.sort_order;
                document.getElementById('form-gov').value = data.governing_body;
                document.getElementById('form-type').value = data.ranking_type;
                document.getElementById('form-label-national').value = data.label_national || 'National';
                document.getElementById('form-label-club').value = data.label_club || 'Leagues';
            } else {
                document.getElementById('modal-title').innerText = 'Add New Sport';
                document.getElementById('form-action').value = 'add';
                document.getElementById('form-id').value = '';
                document.getElementById('form-name').value = '';
                document.getElementById('form-slug').value = '';
                document.getElementById('form-icon').value = '🏆';
                document.getElementById('form-order').value = '0';
                document.getElementById('form-gov').value = '';
                document.getElementById('form-type').value = '';
            }
        }
        function closeModal() {
            document.getElementById('sport-modal').classList.add('hidden');
        }
    </script>
</body>
</html>
