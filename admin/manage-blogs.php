<?php
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/functions.php';
require_login();

$action = $_GET['action'] ?? 'list';
$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!verify_csrf_token($_POST['csrf_token'] ?? '')) {
        die("CSRF token validation failed.");
    }

    $title = $_POST['title'];
    $slug = $_POST['slug'];
    $content = $_POST['content'];
    $excerpt = $_POST['excerpt'];
    $featured_image = $_POST['featured_image'];
    $is_published = isset($_POST['is_published']) ? 1 : 0;

    if ($_POST['form_action'] === 'add') {
        $stmt = $pdo->prepare("INSERT INTO blogs (title, slug, content, excerpt, featured_image, is_published) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([$title, $slug, $content, $excerpt, $featured_image, $is_published]);
        header("Location: manage-blogs.php?success=added");
        exit;
    } elseif ($_POST['form_action'] === 'edit') {
        $id = (int)$_POST['id'];
        $stmt = $pdo->prepare("UPDATE blogs SET title = ?, slug = ?, content = ?, excerpt = ?, featured_image = ?, is_published = ? WHERE id = ?");
        $stmt->execute([$title, $slug, $content, $excerpt, $featured_image, $is_published, $id]);
        header("Location: manage-blogs.php?success=updated");
        exit;
    }
}

if ($action === 'delete') {
    $id = (int)$_GET['id'];
    $pdo->prepare("DELETE FROM blogs WHERE id = ?")->execute([$id]);
    header("Location: manage-blogs.php?success=deleted");
    exit;
}

$blogs = $pdo->query("SELECT * FROM blogs ORDER BY created_at DESC")->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Blogs - SportingRank Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Barlow:wght@700;900&family=Inter:wght@400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/admin.css">
</head>
<body class="bg-[#0a0a1a] text-[#EEEEFF] font-sans flex min-h-screen">
    <aside class="w-64 bg-[#141428] border-r border-[#1e2a40] hidden md:block">
        <div class="p-6 border-b border-[#1e2a40]">
            <h2 class="text-xl font-black italic uppercase tracking-tighter">Sporting<span class="text-[#F0A500]">Rank</span></h2>
        </div>
        <nav class="mt-6">
            <a href="dashboard.php" class="sidebar-link">📊 Dashboard</a>
            <a href="manage-sports.php" class="sidebar-link">🏆 Manage Sports</a>
            <a href="manage-teams.php" class="sidebar-link">👥 Manage Teams</a>
            <a href="manage-blogs.php" class="sidebar-link active">📝 Manage Blogs</a>
            <a href="manage-backlinks.php" class="sidebar-link">🔗 Backlinks</a>
            <a href="manage-settings.php" class="sidebar-link">⚙️ Site Settings</a>
        </nav>
    </aside>

    <main class="flex-1 p-8 overflow-y-auto">
        <header class="flex justify-between items-center mb-10">
            <h1 class="text-3xl font-black uppercase italic tracking-tighter">Manage Blogs</h1>
            <button onclick="openModal('add')" class="btn-primary text-xs uppercase">+ New Post</button>
        </header>

        <div class="admin-card overflow-hidden">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-[#0a0a1a] text-[10px] font-black uppercase tracking-widest text-[#7A8AAA]">
                        <th class="py-4 px-6">Title</th>
                        <th class="py-4 px-6">Status</th>
                        <th class="py-4 px-6">Date</th>
                        <th class="py-4 px-6 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($blogs as $b): ?>
                        <tr class="border-b border-[#1e2a40] hover:bg-white/5 transition">
                            <td class="py-4 px-6 font-bold"><?php echo e($b['title']); ?></td>
                            <td class="py-4 px-6">
                                <span class="px-2 py-1 rounded text-[9px] font-black uppercase <?php echo $b['is_published'] ? 'bg-success/20 text-success' : 'bg-orange-500/20 text-orange-500'; ?>">
                                    <?php echo $b['is_published'] ? 'Published' : 'Draft'; ?>
                                </span>
                            </td>
                            <td class="py-4 px-6 text-xs text-muted"><?php echo date('M d, Y', strtotime($b['created_at'])); ?></td>
                            <td class="py-4 px-6 text-right">
                                <button onclick='openModal("edit", <?php echo json_encode($b); ?>)' class="text-blue-400 hover:text-blue-300 mr-4 font-bold text-xs">Edit</button>
                                <a href="?action=delete&id=<?php echo $b['id']; ?>" onclick="return confirm('Delete?')" class="text-red-400 hover:text-red-300 font-bold text-xs">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <div id="blog-modal" class="fixed inset-0 bg-black/80 flex items-center justify-center z-50 hidden">
            <div class="admin-card w-full max-w-4xl p-8 max-h-[90vh] overflow-y-auto">
                <h3 id="modal-title" class="text-xl font-black uppercase italic tracking-tighter mb-6">Add Post</h3>
                <form method="POST">
                    <input type="hidden" name="csrf_token" value="<?php echo get_csrf_token(); ?>">
                    <input type="hidden" name="form_action" id="form-action" value="add">
                    <input type="hidden" name="id" id="form-id" value="">

                    <div class="grid grid-cols-2 gap-6">
                        <div class="col-span-2">
                            <label class="block text-[10px] font-black uppercase tracking-widest text-[#7A8AAA] mb-1">Title</label>
                            <input type="text" name="title" id="form-title" class="form-input" required onkeyup="generateSlug(this.value)">
                        </div>
                        <div class="col-span-2">
                            <label class="block text-[10px] font-black uppercase tracking-widest text-[#7A8AAA] mb-1">Featured Image URL</label>
                            <input type="text" name="featured_image" id="form-image" class="form-input" placeholder="https://example.com/image.jpg">
                        </div>
                        <div>
                            <label class="block text-[10px] font-black uppercase tracking-widest text-[#7A8AAA] mb-1">Slug</label>
                            <input type="text" name="slug" id="form-slug" class="form-input" required>
                        </div>
                        <div class="flex items-center mt-6">
                            <input type="checkbox" name="is_published" id="form-published" class="w-4 h-4 rounded border-white/10 bg-white/5">
                            <label class="ml-2 text-xs font-bold uppercase tracking-widest text-[#EEEEFF]">Published</label>
                        </div>
                        <div class="col-span-2">
                            <label class="block text-[10px] font-black uppercase tracking-widest text-[#7A8AAA] mb-1">Excerpt</label>
                            <textarea name="excerpt" id="form-excerpt" class="form-input h-20"></textarea>
                        </div>
                        <div class="col-span-2">
                            <label class="block text-[10px] font-black uppercase tracking-widest text-[#7A8AAA] mb-1">Content (HTML allowed)</label>
                            <textarea name="content" id="form-content" class="form-input h-64 font-mono text-xs"></textarea>
                        </div>
                    </div>
                    <div class="flex justify-end space-x-4 mt-6">
                        <button type="button" onclick="closeModal()" class="px-6 py-2 text-[#7A8AAA] font-bold uppercase text-xs">Cancel</button>
                        <button type="submit" class="btn-primary text-xs uppercase">Save Post</button>
                    </div>
                </form>
            </div>
        </div>
    </main>

    <script>
        function openModal(mode, data = null) {
            document.getElementById('blog-modal').classList.remove('hidden');
            if (mode === 'edit' && data) {
                document.getElementById('modal-title').innerText = 'Edit Post';
                document.getElementById('form-action').value = 'edit';
                document.getElementById('form-id').value = data.id;
                document.getElementById('form-title').value = data.title;
                document.getElementById('form-slug').value = data.slug;
                document.getElementById('form-image').value = data.featured_image || '';
                document.getElementById('form-excerpt').value = data.excerpt;
                document.getElementById('form-content').value = data.content;
                document.getElementById('form-published').checked = data.is_published == 1;
            } else {
                document.getElementById('modal-title').innerText = 'Add Post';
                document.getElementById('form-action').value = 'add';
                document.getElementById('form-id').value = '';
                document.getElementById('form-title').value = '';
                document.getElementById('form-slug').value = '';
                document.getElementById('form-image').value = '';
                document.getElementById('form-excerpt').value = '';
                document.getElementById('form-content').value = '';
                document.getElementById('form-published').checked = false;
            }
        }
        function closeModal() { document.getElementById('blog-modal').classList.add('hidden'); }
        function generateSlug(text) {
            document.getElementById('form-slug').value = text.toLowerCase().replace(/[^\w ]+/g, '').replace(/ +/g, '-');
        }
    </script>
</body>
</html>
