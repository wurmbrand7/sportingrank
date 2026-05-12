<?php
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/functions.php';
require_login();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!verify_csrf_token($_POST['csrf_token'] ?? '')) { die("CSRF failed"); }

    $action = $_POST['form_action'];
    $title = $_POST['title'];
    $url = $_POST['url'];
    $rel = $_POST['rel'];

    if ($action === 'add') {
        $pdo->prepare("INSERT INTO backlinks (title, url, rel) VALUES (?, ?, ?)")->execute([$title, $url, $rel]);
    } elseif ($action === 'edit') {
        $id = (int)$_POST['id'];
        $pdo->prepare("UPDATE backlinks SET title = ?, url = ?, rel = ? WHERE id = ?")->execute([$title, $url, $rel, $id]);
    }
    header("Location: manage-backlinks.php"); exit;
}

if (isset($_GET['delete'])) {
    $pdo->prepare("DELETE FROM backlinks WHERE id = ?")->execute([(int)$_GET['delete']]);
    header("Location: manage-backlinks.php"); exit;
}

$backlinks = $pdo->query("SELECT * FROM backlinks ORDER BY created_at DESC")->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"><title>Manage Backlinks - Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Barlow:wght@700;900&family=Inter:wght@400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/admin.css">
</head>
<body class="bg-[#0a0a1a] text-[#EEEEFF] font-sans flex min-h-screen">
    <aside class="w-64 bg-[#141428] border-r border-[#1e2a40] hidden md:block">
        <div class="p-6 border-b border-[#1e2a40]"><h2 class="text-xl font-black italic uppercase tracking-tighter">Sporting<span class="text-[#F0A500]">Rank</span></h2></div>
        <nav class="mt-6">
            <a href="dashboard.php" class="sidebar-link">📊 Dashboard</a>
            <a href="manage-sports.php" class="sidebar-link">🏆 Manage Sports</a>
            <a href="manage-teams.php" class="sidebar-link">👥 Manage Teams</a>
            <a href="manage-blogs.php" class="sidebar-link">📝 Manage Blogs</a>
            <a href="manage-backlinks.php" class="sidebar-link active">🔗 Backlinks</a>
            <a href="manage-settings.php" class="sidebar-link">⚙️ Site Settings</a>
        </nav>
    </aside>

    <main class="flex-1 p-8">
        <header class="flex justify-between items-center mb-10">
            <h1 class="text-3xl font-black uppercase italic tracking-tighter">Backlink Manager</h1>
            <button onclick="openModal('add')" class="btn-primary text-xs uppercase">+ Add Backlink</button>
        </header>

        <div class="admin-card">
            <table class="w-full text-left">
                <thead><tr class="bg-[#0a0a1a] text-[10px] font-black uppercase tracking-widest text-[#7A8AAA]"><th class="p-6">Title</th><th>URL</th><th>Rel</th><th class="text-right p-6">Actions</th></tr></thead>
                <tbody>
                    <?php foreach ($backlinks as $bl): ?>
                        <tr class="border-b border-[#1e2a40] hover:bg-white/5 transition">
                            <td class="p-6 font-bold"><?php echo e($bl['title']); ?></td>
                            <td class="text-xs text-blue-400"><?php echo e($bl['url']); ?></td>
                            <td class="text-[10px] uppercase font-black text-muted"><?php echo e($bl['rel']); ?></td>
                            <td class="text-right p-6">
                                <button onclick='openModal("edit", <?php echo json_encode($bl); ?>)' class="text-blue-400 mr-4 text-xs font-bold">Edit</button>
                                <a href="?delete=<?php echo $bl['id']; ?>" class="text-red-400 text-xs font-bold">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <div id="bl-modal" class="fixed inset-0 bg-black/80 flex items-center justify-center z-50 hidden">
            <div class="admin-card w-full max-w-md p-8">
                <h3 id="modal-title" class="text-xl font-black uppercase italic tracking-tighter mb-6">Add Backlink</h3>
                <form method="POST">
                    <input type="hidden" name="csrf_token" value="<?php echo get_csrf_token(); ?>">
                    <input type="hidden" name="form_action" id="form-action" value="add">
                    <input type="hidden" name="id" id="form-id" value="">
                    <div class="space-y-4">
                        <div><label class="text-[10px] font-black uppercase text-[#7A8AAA]">Anchor Title</label><input type="text" name="title" id="form-title" class="form-input" required></div>
                        <div><label class="text-[10px] font-black uppercase text-[#7A8AAA]">URL</label><input type="url" name="url" id="form-url" class="form-input" required></div>
                        <div><label class="text-[10px] font-black uppercase text-[#7A8AAA]">Rel Attribute</label>
                            <select name="rel" id="form-rel" class="form-input">
                                <option value="nofollow">nofollow</option>
                                <option value="dofollow">dofollow</option>
                                <option value="sponsored">sponsored</option>
                            </select>
                        </div>
                    </div>
                    <div class="flex justify-end space-x-4 mt-8">
                        <button type="button" onclick="closeModal()" class="text-xs font-bold uppercase text-muted">Cancel</button>
                        <button type="submit" class="btn-primary text-xs uppercase px-8">Save Link</button>
                    </div>
                </form>
            </div>
        </div>
    </main>
    <script>
        function openModal(mode, data = null) {
            document.getElementById('bl-modal').classList.remove('hidden');
            if(mode==='edit'){
                document.getElementById('modal-title').innerText='Edit Backlink';
                document.getElementById('form-action').value='edit';
                document.getElementById('form-id').value=data.id;
                document.getElementById('form-title').value=data.title;
                document.getElementById('form-url').value=data.url;
                document.getElementById('form-rel').value=data.rel;
            } else {
                document.getElementById('modal-title').innerText='Add Backlink';
                document.getElementById('form-action').value='add';
                document.getElementById('form-title').value='';
                document.getElementById('form-url').value='';
            }
        }
        function closeModal(){document.getElementById('bl-modal').classList.add('hidden');}
    </script>
</body>
</html>
