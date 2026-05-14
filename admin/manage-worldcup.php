<?php
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/functions.php';
require_login();

$msg = '';
$action = $_GET['action'] ?? 'settings';

// Handle POST requests for updates
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!verify_csrf_token($_POST['csrf_token'] ?? '')) {
        die("CSRF token validation failed.");
    }

    $post_action = $_POST['action'] ?? '';

    if ($post_action === 'update_settings') {
        foreach ($_POST['settings'] as $key => $value) {
            $stmt = $pdo->prepare("UPDATE wc_settings SET setting_value = ? WHERE setting_key = ?");
            $stmt->execute([$value, $key]);
        }
        $msg = "Settings updated successfully.";
    }

    if ($post_action === 'add_stadium') {
        $stmt = $pdo->prepare("INSERT INTO wc_stadiums (name, capacity, city, country, note) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$_POST['name'], $_POST['capacity'], $_POST['city'], $_POST['country'], $_POST['note']]);
        $msg = "Stadium added.";
    }

    if ($post_action === 'edit_stadium') {
        $stmt = $pdo->prepare("UPDATE wc_stadiums SET name = ?, capacity = ?, city = ?, country = ?, note = ? WHERE id = ?");
        $stmt->execute([$_POST['name'], $_POST['capacity'], $_POST['city'], $_POST['country'], $_POST['note'], $_POST['id']]);
        $msg = "Stadium updated.";
    }

    if ($post_action === 'delete_stadium') {
        $pdo->prepare("DELETE FROM wc_stadiums WHERE id = ?")->execute([$_POST['id']]);
        $msg = "Stadium deleted.";
    }

    if ($post_action === 'add_team') {
        $stmt = $pdo->prepare("INSERT INTO wc_teams (name, group_id, confederation) VALUES (?, ?, ?)");
        $stmt->execute([$_POST['name'], $_POST['group_id'], $_POST['confederation']]);
        $msg = "Team added.";
    }

    if ($post_action === 'edit_team') {
        $stmt = $pdo->prepare("UPDATE wc_teams SET name = ?, group_id = ?, confederation = ? WHERE id = ?");
        $stmt->execute([$_POST['name'], $_POST['group_id'], $_POST['confederation'], $_POST['id']]);
        $msg = "Team updated.";
    }

    if ($post_action === 'delete_team') {
        $pdo->prepare("DELETE FROM wc_teams WHERE id = ?")->execute([$_POST['id']]);
        $msg = "Team deleted.";
    }

    if ($post_action === 'save_match') {
        if (!empty($_POST['id'])) {
            $stmt = $pdo->prepare("UPDATE wc_matches SET home_team_id = ?, away_team_id = ?, home_score = ?, away_score = ?, match_date = ?, group_id = ?, stadium_id = ?, status = ? WHERE id = ?");
            $stmt->execute([$_POST['home_team_id'], $_POST['away_team_id'], $_POST['home_score'], $_POST['away_score'], $_POST['match_date'], $_POST['group_id'], $_POST['stadium_id'], $_POST['status'], $_POST['id']]);
        } else {
            $stmt = $pdo->prepare("INSERT INTO wc_matches (home_team_id, away_team_id, home_score, away_score, match_date, group_id, stadium_id, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([$_POST['home_team_id'], $_POST['away_team_id'], $_POST['home_score'], $_POST['away_score'], $_POST['match_date'], $_POST['group_id'], $_POST['stadium_id'], $_POST['status']]);
        }
        update_group_standings();
        $msg = "Match saved and standings updated.";
    }
}

function update_group_standings() {
    global $pdo;
    // Reset all team stats
    $pdo->exec("UPDATE wc_teams SET matches_played = 0, wins = 0, draws = 0, losses = 0, goals_for = 0, goals_against = 0, points = 0");

    $matches = $pdo->query("SELECT * FROM wc_matches WHERE status = 'finished'")->fetchAll();
    foreach ($matches as $m) {
        $h_id = $m['home_team_id'];
        $a_id = $m['away_team_id'];
        $h_score = (int)$m['home_score'];
        $a_score = (int)$m['away_score'];

        $h_win = $h_score > $a_score ? 1 : 0;
        $a_win = $a_score > $h_score ? 1 : 0;
        $draw = $h_score === $a_score ? 1 : 0;

        $h_pts = $h_win * 3 + $draw;
        $a_pts = $a_win * 3 + $draw;

        $stmt = $pdo->prepare("UPDATE wc_teams SET
            matches_played = matches_played + 1,
            wins = wins + ?,
            draws = draws + ?,
            losses = losses + ?,
            goals_for = goals_for + ?,
            goals_against = goals_against + ?,
            points = points + ?
            WHERE id = ?");

        $stmt->execute([$h_win, $draw, $a_win, $h_score, $a_score, $h_pts, $h_id]);
        $stmt->execute([$a_win, $draw, $h_win, $a_score, $h_score, $a_pts, $a_id]);
    }
}

// Fetch data for display
$settings = $pdo->query("SELECT setting_key, setting_value FROM wc_settings")->fetchAll(PDO::FETCH_KEY_PAIR);
$stadiums = $pdo->query("SELECT * FROM wc_stadiums ORDER BY country, city")->fetchAll();
$groups = $pdo->query("SELECT * FROM wc_groups ORDER BY group_letter")->fetchAll();
$teams = $pdo->query("SELECT t.*, g.group_letter FROM wc_teams t JOIN wc_groups g ON t.group_id = g.id ORDER BY g.group_letter, t.points DESC, (t.goals_for - t.goals_against) DESC")->fetchAll();
$matches = $pdo->query("SELECT m.*, th.name as home_team, ta.name as away_team FROM wc_matches m JOIN wc_teams th ON m.home_team_id = th.id JOIN wc_teams ta ON m.away_team_id = ta.id ORDER BY match_date")->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage World Cup 2026 - Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="../assets/css/admin.css">
</head>
<body class="bg-[#0a0a1a] text-[#EEEEFF] flex min-h-screen">
    <aside class="w-64 bg-[#141428] border-r border-[#1e2a40]">
        <div class="p-6 border-b border-[#1e2a40]">
            <h2 class="text-xl font-black italic uppercase tracking-tighter">WC2026<span class="text-[#F0A500]">Admin</span></h2>
        </div>
        <nav class="mt-6">
            <a href="dashboard.php" class="sidebar-link">📊 Back to Dashboard</a>
            <a href="?action=settings" class="sidebar-link <?php echo $action === 'settings' ? 'active' : ''; ?>">⚙️ Settings</a>
            <a href="?action=stadiums" class="sidebar-link <?php echo $action === 'stadiums' ? 'active' : ''; ?>">🏟️ Stadiums</a>
            <a href="?action=teams" class="sidebar-link <?php echo $action === 'teams' ? 'active' : ''; ?>">🌍 Teams</a>
            <a href="?action=matches" class="sidebar-link <?php echo $action === 'matches' ? 'active' : ''; ?>">⚽ Matches</a>
        </nav>
    </aside>

    <main class="flex-1 p-8">
        <?php if ($msg): ?>
            <div class="bg-green-500/20 border border-green-500 text-green-500 p-4 rounded-xl mb-6 font-bold"><?php echo $msg; ?></div>
        <?php endif; ?>

        <?php if ($action === 'settings'): ?>
            <h1 class="text-3xl font-black uppercase italic tracking-tighter mb-8">General Settings</h1>
            <div class="admin-card p-8 max-w-2xl">
                <form method="POST">
                    <input type="hidden" name="csrf_token" value="<?php echo get_csrf_token(); ?>">
                    <input type="hidden" name="action" value="update_settings">
                    <?php if ($settings): foreach ($settings as $key => $val): ?>
                        <div class="mb-4">
                            <label class="block text-xs font-black uppercase tracking-widest text-[#7A8AAA] mb-1"><?php echo str_replace('wc_', '', $key); ?></label>
                            <input type="text" name="settings[<?php echo $key; ?>]" value="<?php echo e($val); ?>" class="form-input">
                        </div>
                    <?php endforeach; endif; ?>
                    <button type="submit" class="btn-primary mt-4">Save Settings</button>
                </form>
            </div>

        <?php elseif ($action === 'stadiums'): ?>
            <div class="flex justify-between items-center mb-8">
                <h1 class="text-3xl font-black uppercase italic tracking-tighter">Host Stadiums</h1>
                <button onclick="document.getElementById('stadium-modal').classList.remove('hidden')" class="btn-primary text-xs">+ Add Stadium</button>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <?php foreach ($stadiums as $s): ?>
                    <div class="admin-card p-6">
                        <h3 class="text-xl font-bold mb-1"><?php echo e($s['name']); ?></h3>
                        <p class="text-[#7A8AAA] text-sm mb-4"><?php echo e($s['city']); ?>, <?php echo e($s['country']); ?> (Cap: <?php echo number_format($s['capacity']); ?>)</p>
                        <div class="flex space-x-4">
                            <button onclick='editStadium(<?php echo json_encode($s); ?>)' class="text-blue-400 font-bold text-xs">Edit</button>
                            <form method="POST" onsubmit="return confirm('Delete stadium?')">
                                <input type="hidden" name="csrf_token" value="<?php echo get_csrf_token(); ?>">
                                <input type="hidden" name="action" value="delete_stadium">
                                <input type="hidden" name="id" value="<?php echo $s['id']; ?>">
                                <button type="submit" class="text-red-400 font-bold text-xs">Delete</button>
                            </form>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- Stadium Modal -->
            <div id="stadium-modal" class="fixed inset-0 bg-black/80 hidden flex items-center justify-center p-4">
                <div class="admin-card p-8 w-full max-w-lg">
                    <h2 id="stadium-title" class="text-2xl font-black uppercase italic mb-6">Add Stadium</h2>
                    <form method="POST">
                        <input type="hidden" name="csrf_token" value="<?php echo get_csrf_token(); ?>">
                        <input type="hidden" name="action" id="stadium-action" value="add_stadium">
                        <input type="hidden" name="id" id="stadium-id">
                        <div class="grid grid-cols-2 gap-4">
                            <div class="col-span-2"><label class="text-xs uppercase font-black text-[#7A8AAA]">Name</label><input type="text" name="name" id="s-name" class="form-input" required></div>
                            <div><label class="text-xs uppercase font-black text-[#7A8AAA]">Capacity</label><input type="number" name="capacity" id="s-cap" class="form-input" required></div>
                            <div><label class="text-xs uppercase font-black text-[#7A8AAA]">City</label><input type="text" name="city" id="s-city" class="form-input" required></div>
                            <div><label class="text-xs uppercase font-black text-[#7A8AAA]">Country</label><input type="text" name="country" id="s-country" class="form-input" required></div>
                            <div class="col-span-2"><label class="text-xs uppercase font-black text-[#7A8AAA]">Note</label><textarea name="note" id="s-note" class="form-input"></textarea></div>
                        </div>
                        <div class="flex justify-end space-x-4 mt-6">
                            <button type="button" onclick="document.getElementById('stadium-modal').classList.add('hidden')" class="text-muted">Cancel</button>
                            <button type="submit" class="btn-primary">Save Stadium</button>
                        </div>
                    </form>
                </div>
            </div>

        <?php elseif ($action === 'teams'): ?>
            <div class="flex justify-between items-center mb-8">
                <h1 class="text-3xl font-black uppercase italic tracking-tighter">Teams & Groups</h1>
                <button onclick="document.getElementById('team-modal').classList.remove('hidden')" class="btn-primary text-xs">+ Add Team</button>
            </div>
            <div class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-8">
                <?php foreach ($groups as $g): ?>
                    <div class="admin-card overflow-hidden">
                        <div class="bg-[#0a0a1a] px-6 py-4 border-b border-[#1e2a40] font-black italic text-accent uppercase">Group <?php echo $g['group_letter']; ?></div>
                        <table class="w-full text-xs text-left">
                            <thead>
                                <tr class="text-[#7A8AAA] border-b border-[#1e2a40]">
                                    <th class="p-3">Team</th>
                                    <th class="p-3 text-center">P</th>
                                    <th class="p-3 text-center">GD</th>
                                    <th class="p-3 text-center text-accent">Pts</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($teams as $t): if ($t['group_id'] != $g['id']) continue; ?>
                                    <tr class="border-b border-[#1e2a40]">
                                        <td class="p-3 font-bold"><?php echo e($t['name']); ?></td>
                                        <td class="p-3 text-center"><?php echo $t['matches_played']; ?></td>
                                        <td class="p-3 text-center"><?php echo $t['goals_for'] - $t['goals_against']; ?></td>
                                        <td class="p-3 text-center font-black text-accent"><?php echo $t['points']; ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- Team Modal -->
            <div id="team-modal" class="fixed inset-0 bg-black/80 hidden flex items-center justify-center p-4 z-50">
                <div class="admin-card p-8 w-full max-w-lg">
                    <h2 class="text-2xl font-black uppercase italic mb-6">Add/Edit Team</h2>
                    <form method="POST">
                        <input type="hidden" name="csrf_token" value="<?php echo get_csrf_token(); ?>">
                        <input type="hidden" name="action" value="add_team">
                        <div class="space-y-4">
                            <div><label class="text-xs uppercase font-black text-[#7A8AAA]">Name</label><input type="text" name="name" class="form-input" required></div>
                            <div>
                                <label class="text-xs uppercase font-black text-[#7A8AAA]">Group</label>
                                <select name="group_id" class="form-input">
                                    <?php foreach ($groups as $g): ?><option value="<?php echo $g['id']; ?>">Group <?php echo $g['group_letter']; ?></option><?php endforeach; ?>
                                </select>
                            </div>
                            <div><label class="text-xs uppercase font-black text-[#7A8AAA]">Confederation</label><input type="text" name="confederation" class="form-input" placeholder="e.g. Europe, South America"></div>
                        </div>
                        <div class="flex justify-end space-x-4 mt-6">
                            <button type="button" onclick="document.getElementById('team-modal').classList.add('hidden')" class="text-muted">Cancel</button>
                            <button type="submit" class="btn-primary">Save Team</button>
                        </div>
                    </form>
                </div>
            </div>

        <?php elseif ($action === 'matches'): ?>
            <div class="flex justify-between items-center mb-8">
                <h1 class="text-3xl font-black uppercase italic tracking-tighter">Matches & Results</h1>
                <button onclick="document.getElementById('match-modal').classList.remove('hidden')" class="btn-primary text-xs">+ Record Match</button>
            </div>
            <div class="admin-card overflow-hidden">
                <table class="w-full text-left">
                    <thead class="bg-[#0a0a1a] text-[10px] font-black uppercase tracking-widest text-[#7A8AAA]">
                        <tr>
                            <th class="p-4">Date</th>
                            <th class="p-4">Match</th>
                            <th class="p-4 text-center">Score</th>
                            <th class="p-4 text-center">Status</th>
                            <th class="p-4 text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($matches as $m): ?>
                            <tr class="border-b border-[#1e2a40] hover:bg-white/5 transition">
                                <td class="p-4 text-xs text-[#7A8AAA]"><?php echo date('M d, H:i', strtotime($m['match_date'])); ?></td>
                                <td class="p-4 font-bold"><?php echo e($m['home_team']); ?> vs <?php echo e($m['away_team']); ?></td>
                                <td class="p-4 text-center font-black text-accent italic text-lg"><?php echo $m['home_score']; ?> - <?php echo $m['away_score']; ?></td>
                                <td class="p-4 text-center">
                                    <span class="text-[9px] font-black uppercase px-2 py-1 rounded <?php echo $m['status'] === 'finished' ? 'bg-green-500/20 text-green-500' : 'bg-blue-500/20 text-blue-500'; ?>">
                                        <?php echo $m['status']; ?>
                                    </span>
                                </td>
                                <td class="p-4 text-right">
                                    <button onclick='editMatch(<?php echo json_encode($m); ?>)' class="text-blue-400 font-bold text-xs">Edit</button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        <?php if (empty($matches)): ?>
                            <tr><td colspan="5" class="p-12 text-center text-muted italic">No matches recorded yet.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <!-- Match Modal -->
            <div id="match-modal" class="fixed inset-0 bg-black/80 hidden flex items-center justify-center p-4 z-50">
                <div class="admin-card p-8 w-full max-w-lg">
                    <h2 id="match-title" class="text-2xl font-black uppercase italic mb-6">Record Match</h2>
                    <form method="POST">
                        <input type="hidden" name="csrf_token" value="<?php echo get_csrf_token(); ?>">
                        <input type="hidden" name="action" value="save_match">
                        <input type="hidden" name="id" id="m-id">
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="text-xs uppercase font-black text-[#7A8AAA]">Home Team</label>
                                <select name="home_team_id" id="m-home" class="form-input">
                                    <?php foreach ($teams as $t): ?><option value="<?php echo $t['id']; ?>"><?php echo e($t['name']); ?></option><?php endforeach; ?>
                                </select>
                            </div>
                            <div>
                                <label class="text-xs uppercase font-black text-[#7A8AAA]">Away Team</label>
                                <select name="away_team_id" id="m-away" class="form-input">
                                    <?php foreach ($teams as $t): ?><option value="<?php echo $t['id']; ?>"><?php echo e($t['name']); ?></option><?php endforeach; ?>
                                </select>
                            </div>
                            <div><label class="text-xs uppercase font-black text-[#7A8AAA]">Home Score</label><input type="number" name="home_score" id="m-h-score" class="form-input" value="0"></div>
                            <div><label class="text-xs uppercase font-black text-[#7A8AAA]">Away Score</label><input type="number" name="away_score" id="m-a-score" class="form-input" value="0"></div>
                            <div class="col-span-2">
                                <label class="text-xs uppercase font-black text-[#7A8AAA]">Stadium</label>
                                <select name="stadium_id" id="m-stadium" class="form-input">
                                    <?php foreach ($stadiums as $s): ?><option value="<?php echo $s['id']; ?>"><?php echo e($s['name']); ?> (<?php echo e($s['city']); ?>)</option><?php endforeach; ?>
                                </select>
                            </div>
                            <div><label class="text-xs uppercase font-black text-[#7A8AAA]">Date</label><input type="datetime-local" name="match_date" id="m-date" class="form-input"></div>
                            <div>
                                <label class="text-xs uppercase font-black text-[#7A8AAA]">Status</label>
                                <select name="status" id="m-status" class="form-input">
                                    <option value="scheduled">Scheduled</option>
                                    <option value="finished">Finished</option>
                                </select>
                            </div>
                        </div>
                        <div class="flex justify-end space-x-4 mt-6">
                            <button type="button" onclick="document.getElementById('match-modal').classList.add('hidden')" class="text-muted">Cancel</button>
                            <button type="submit" class="btn-primary">Save Match</button>
                        </div>
                    </form>
                </div>
            </div>
        <?php endif; ?>
    </main>

    <script>
        function editStadium(s) {
            document.getElementById('stadium-title').innerText = 'Edit Stadium';
            document.getElementById('stadium-action').value = 'edit_stadium';
            document.getElementById('stadium-id').value = s.id;
            document.getElementById('s-name').value = s.name;
            document.getElementById('s-cap').value = s.capacity;
            document.getElementById('s-city').value = s.city;
            document.getElementById('s-country').value = s.country;
            document.getElementById('s-note').value = s.note;
            document.getElementById('stadium-modal').classList.remove('hidden');
        }
        function editMatch(m) {
            document.getElementById('match-title').innerText = 'Edit Match';
            document.getElementById('m-id').value = m.id;
            document.getElementById('m-home').value = m.home_team_id;
            document.getElementById('m-away').value = m.away_team_id;
            document.getElementById('m-h-score').value = m.home_score;
            document.getElementById('m-a-score').value = m.away_score;
            document.getElementById('m-stadium').value = m.stadium_id;
            document.getElementById('m-status').value = m.status;
            // DateTime-local needs specific format
            if (m.match_date) {
                document.getElementById('m-date').value = m.match_date.replace(' ', 'T').substring(0, 16);
            }
            document.getElementById('match-modal').classList.remove('hidden');
        }
    </script>
</body>
</html>
