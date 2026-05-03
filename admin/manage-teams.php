<?php
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/functions.php';
require_login();

$sport_id = (int)($_GET['sport_id'] ?? ($pdo->query("SELECT id FROM sports LIMIT 1")->fetchColumn() ?: 0));
$sports = $pdo->query("SELECT id, name FROM sports ORDER BY sort_order ASC")->fetchAll();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!verify_csrf_token($_POST['csrf_token'] ?? '')) {
        die("CSRF token validation failed.");
    }
    $action = $_POST['action'] ?? '';

    if ($action === 'add' || $action === 'edit') {
        $team_name = $_POST['team_name'];
        $rank_position = (int)$_POST['rank_position'];
        $points = (float)$_POST['points'];
        $country_code = $_POST['country_code'];
        $sport_id = (int)$_POST['sport_id'];

        if ($action === 'add') {
            $stmt = $pdo->prepare("INSERT INTO teams (sport_id, rank_position, team_name, country_code, points) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$sport_id, $rank_position, $team_name, $country_code, $points]);
            $msg = "Added team: " . $team_name;
        } else {
            $id = (int)$_POST['id'];
            $stmt = $pdo->prepare("UPDATE teams SET rank_position = ?, team_name = ?, country_code = ?, points = ? WHERE id = ?");
            $stmt->execute([$rank_position, $team_name, $country_code, $points, $id]);
            $msg = "Updated team: " . $team_name;
        }

        $pdo->prepare("INSERT INTO activity_log (user_id, action) VALUES (?, ?)")->execute([$_SESSION[ADMIN_SESSION_NAME]['id'], $msg]);
        header("Location: manage-teams.php?sport_id=$sport_id&success=1");
        exit;
    }

    if ($action === 'delete') {
        $id = (int)$_POST['id'];
        $stmt = $pdo->prepare("DELETE FROM teams WHERE id = ?");
        $stmt->execute([$id]);
        header("Location: manage-teams.php?sport_id=$sport_id&success=1");
        exit;
    }
}

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
            <button onclick="openModal('add')" class="btn-primary text-xs uppercase">+ Add Team</button>
        </header>

        <div class="admin-card overflow-hidden">
            <table class="w-full text-left">
                <thead class="bg-[#0a0a1a] text-[10px] font-black uppercase tracking-widest text-[#7A8AAA]">
                    <tr>
                        <th class="py-4 px-6">Rank</th>
                        <th class="py-4 px-6">Team / Country</th>
                        <th class="py-4 px-6 text-right">Points</th>
                        <th class="py-4 px-6 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($teams as $t): ?>
                        <tr class="border-b border-[#1e2a40] hover:bg-white/5 transition">
                            <td class="py-4 px-6 font-heading font-black italic text-lg text-[#F0A500]">#<?php echo $t['rank_position']; ?></td>
                            <td class="py-4 px-6">
                                <div class="flex items-center space-x-3">
                                    <img src="https://flagcdn.com/24x18/<?php echo strtolower($t['country_code'] ?? 'un'); ?>.png" alt="" class="rounded-sm">
                                    <span class="font-bold"><?php echo e($t['team_name']); ?></span>
                                </div>
                            </td>
                            <td class="py-4 px-6 text-right font-mono font-bold text-sm"><?php echo number_format($t['points']); ?></td>
                            <td class="py-4 px-6 text-right">
                                <button onclick='openModal("edit", <?php echo json_encode($t); ?>)' class="text-blue-400 hover:text-blue-300 mr-4 font-bold text-xs">Edit</button>
                                <form method="POST" class="inline" onsubmit="return confirm('Delete this team?')">
                                    <input type="hidden" name="action" value="delete">
                                    <input type="hidden" name="id" value="<?php echo $t['id']; ?>">
                                    <button type="submit" class="text-red-400 hover:text-red-300 font-bold text-xs">Delete</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <div id="team-modal" class="fixed inset-0 bg-black/80 flex items-center justify-center z-50 hidden">
            <div class="admin-card w-full max-w-lg p-8">
                <h3 id="modal-title" class="text-xl font-black uppercase italic tracking-tighter mb-6">Add Team</h3>
                <form method="POST">
                    <input type="hidden" name="csrf_token" value="<?php echo get_csrf_token(); ?>">
                    <input type="hidden" name="action" id="form-action" value="add">
                    <input type="hidden" name="id" id="form-id" value="">
                    <input type="hidden" name="sport_id" value="<?php echo $sport_id; ?>">
                    <div class="grid grid-cols-2 gap-4">
                        <div class="mb-4">
                            <label class="block text-[10px] font-black uppercase tracking-widest text-[#7A8AAA] mb-1">Team Name</label>
                            <input type="text" name="team_name" id="form-name" class="form-input" required>
                        </div>
                        <div class="mb-4">
                            <label class="block text-[10px] font-black uppercase tracking-widest text-[#7A8AAA] mb-1">Rank Position</label>
                            <input type="number" name="rank_position" id="form-rank" class="form-input" required>
                        </div>
                        <div class="mb-4">
                            <label class="block text-[10px] font-black uppercase tracking-widest text-[#7A8AAA] mb-1">Points</label>
                            <input type="number" step="0.01" name="points" id="form-points" class="form-input" required>
                        </div>
                        <div class="mb-4">
                            <label class="block text-[10px] font-black uppercase tracking-widest text-[#7A8AAA] mb-1">Country Code (e.g. us)</label>
                            <input type="text" name="country_code" id="form-code" class="form-input" maxlength="2">
                        </div>
                    </div>
                    <div class="flex justify-end space-x-4 mt-6">
                        <button type="button" onclick="closeModal()" class="px-6 py-2 text-[#7A8AAA] font-bold uppercase text-xs">Cancel</button>
                        <button type="submit" class="btn-primary text-xs uppercase">Save Team</button>
                    </div>
                </form>
            </div>
        </div>
    </main>

    <script>
        function openModal(mode, data = null) {
            document.getElementById('team-modal').classList.remove('hidden');
            if (mode === 'edit' && data) {
                document.getElementById('modal-title').innerText = 'Edit Team';
                document.getElementById('form-action').value = 'edit';
                document.getElementById('form-id').value = data.id;
                document.getElementById('form-name').value = data.team_name;
                document.getElementById('form-rank').value = data.rank_position;
                document.getElementById('form-points').value = data.points;
                document.getElementById('form-code').value = data.country_code;
            } else {
                document.getElementById('modal-title').innerText = 'Add Team';
                document.getElementById('form-action').value = 'add';
                document.getElementById('form-id').value = '';
                document.getElementById('form-name').value = '';
                document.getElementById('form-rank').value = '';
                document.getElementById('form-points').value = '';
                document.getElementById('form-code').value = '';
            }
        }
        function closeModal() {
            document.getElementById('team-modal').classList.add('hidden');
        }
    </script>
</body>
</html>
