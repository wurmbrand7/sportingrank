<?php
require_once __DIR__ . '/includes/header.php';

$slug = $_GET['slug'] ?? '';
$stmt = $pdo->prepare("SELECT * FROM sports WHERE slug = ? AND is_active = 1");
$stmt->execute([$slug]);
$sport = $stmt->fetch();

if (!$sport) {
    header("Location: index.php");
    exit;
}

$type = $_GET['type'] ?? 'national';
$teams = get_top_teams($sport['id'], 50, $type);
?>

<!-- Sport Hero -->
<section class="relative py-24 overflow-hidden border-b border-border">
    <div class="absolute inset-0 z-0">
        <div class="absolute inset-0 bg-gradient-to-t from-primary via-primary/80 to-transparent"></div>
        <img src="<?php echo e($sport['hero_image'] ?? 'https://images.unsplash.com/photo-1504450758481-7338eba7524a?auto=format&fit=crop&q=80&w=1920'); ?>" alt="" class="w-full h-full object-cover opacity-30">
    </div>

    <div class="container mx-auto px-4 relative z-10 text-center">
        <div class="flex justify-center mb-8">
            <div class="flex items-center space-x-4 bg-card p-1 rounded-full border border-border">
                <a href="?slug=<?php echo $slug; ?>&type=national" class="px-4 py-1.5 rounded-full text-[10px] font-black uppercase tracking-widest transition <?php echo $type === 'national' ? 'bg-accent text-primary' : 'text-muted hover:text-white'; ?>">National</a>
                <a href="?slug=<?php echo $slug; ?>&type=club" class="px-4 py-1.5 rounded-full text-[10px] font-black uppercase tracking-widest transition <?php echo $type === 'club' ? 'bg-accent text-primary' : 'text-muted hover:text-white'; ?>">Leagues</a>
            </div>
        </div>
        <div class="inline-flex items-center space-x-2 bg-accent/20 text-accent px-4 py-1 rounded-full border border-accent/30 text-xs font-black uppercase tracking-widest mb-6">
            <span><?php echo e($sport['governing_body']); ?> Official Ranking</span>
        </div>
        <h1 class="text-5xl md:text-8xl font-heading font-black italic uppercase tracking-tighter mb-4">
            <?php echo e($sport['name']); ?>
        </h1>
        <p class="max-w-2xl mx-auto text-muted font-medium text-lg italic">
            <?php echo e($sport['description'] ?? 'Comprehensive global rankings for ' . $sport['name'] . ', updated based on official data.'); ?>
        </p>
    </div>
</section>

<section class="py-20">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
            <!-- Rankings Table -->
            <div class="lg:col-span-2">
                <div class="glass-card rounded-2xl border border-border overflow-hidden">
                    <div class="p-6 border-b border-border bg-card/50 flex justify-between items-center">
                        <h2 class="text-2xl font-heading font-black uppercase italic tracking-tighter">Official Standings</h2>
                        <div class="text-[10px] font-bold uppercase tracking-widest text-muted">Total: <?php echo count($teams); ?> Teams</div>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left">
                            <thead class="bg-primary/50 text-[10px] font-black uppercase tracking-widest text-muted border-b border-border">
                                <tr>
                                    <th class="py-4 px-6 text-center">Pos</th>
                                    <th class="py-4 px-6">Team / Country</th>
                                    <th class="py-4 px-6 text-center">Played</th>
                                    <th class="py-4 px-6 text-center">W/L/D</th>
                                    <th class="py-4 px-6 text-right">Points</th>
                                    <th class="py-4 px-6 text-center">Trend</th>
                                    <th class="py-4 px-6 text-center">Vote</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($teams as $team): ?>
                                    <tr class="border-b border-border/20 hover:bg-white/5 transition">
                                        <td class="py-4 px-6 text-center">
                                            <span class="font-heading font-black text-lg italic <?php echo $team['rank_position'] <= 3 ? 'text-accent' : ''; ?>">
                                                #<?php echo $team['rank_position']; ?>
                                            </span>
                                        </td>
                                        <td class="py-4 px-6">
                                            <div class="flex items-center space-x-4">
                                                <img src="https://flagcdn.com/32x24/<?php echo strtolower($team['country_code']); ?>.png" alt="" class="rounded shadow-sm">
                                                <div>
                                                    <div class="font-black uppercase tracking-tight text-[#EEEEFF]"><?php echo e($team['team_name']); ?></div>
                                                    <div class="text-[9px] font-bold text-muted uppercase tracking-widest"><?php echo e($team['notable_achievement'] ?? 'International Member'); ?></div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="py-4 px-6 text-center font-bold text-muted"><?php echo $team['matches_played']; ?></td>
                                        <td class="py-4 px-6 text-center">
                                            <div class="flex justify-center space-x-1 text-[10px] font-black uppercase">
                                                <span class="text-success"><?php echo $team['wins']; ?>W</span>
                                                <span class="text-danger"><?php echo $team['losses']; ?>L</span>
                                                <span class="text-muted"><?php echo $team['draws']; ?>D</span>
                                            </div>
                                        </td>
                                        <td class="py-4 px-6 text-right">
                                            <div class="font-heading font-black text-xl text-accent"><?php echo number_format($team['points']); ?></div>
                                            <div class="text-[8px] font-bold uppercase tracking-widest text-muted"><?php echo e($team['points_label']); ?></div>
                                        </td>
                                        <td class="py-4 px-6 text-center">
                                            <div class="scale-125">
                                                <?php echo format_trend($team['trend']); ?>
                                            </div>
                                        </td>
                                        <td class="py-4 px-6 text-center">
                                            <button onclick="voteForTeam(<?php echo $team['id']; ?>, '<?php echo e($team['team_name']); ?>')" class="bg-accent text-primary px-4 py-2 rounded font-black uppercase text-[10px] hover:bg-white transition">Vote</button>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-8">
                <!-- Rank History Chart -->
                <div class="glass-card rounded-2xl border border-border p-6">
                    <h3 class="text-lg font-heading font-black uppercase italic tracking-tighter mb-6">Rank History</h3>
                    <canvas id="rankChart" height="250"></canvas>
                </div>

                <!-- Social Share -->
                <div class="glass-card rounded-2xl border border-border p-6 text-center">
                    <h3 class="text-xs font-black uppercase tracking-widest mb-4">Share Rankings</h3>
                    <div class="flex justify-center space-x-4">
                        <a href="#" class="w-10 h-10 rounded-full bg-blue-500/20 flex items-center justify-center text-blue-500 hover:bg-blue-500 hover:text-white transition">X</a>
                        <a href="#" class="w-10 h-10 rounded-full bg-blue-700/20 flex items-center justify-center text-blue-700 hover:bg-blue-700 hover:text-white transition">F</a>
                        <a href="#" class="w-10 h-10 rounded-full bg-green-500/20 flex items-center justify-center text-green-500 hover:bg-green-500 hover:text-white transition">W</a>
                    </div>
                </div>

                <!-- Other Sports -->
                <div class="space-y-4">
                    <h3 class="text-xs font-black uppercase tracking-widest ml-2">Other Sports</h3>
                    <?php
                    $other_sports = array_filter(get_active_sports(), function($s) use ($slug) { return $s['slug'] !== $slug; });
                    foreach (array_slice($other_sports, 0, 5) as $os):
                    ?>
                        <a href="<?php echo SITE_URL; ?>/sport/<?php echo e($os['slug']); ?>" class="block glass-card p-4 rounded-xl border border-border flex items-center justify-between group">
                            <div class="flex items-center space-x-3">
                                <span class="text-xl"><?php echo $os['icon']; ?></span>
                                <span class="font-bold uppercase tracking-tight group-hover:text-accent transition"><?php echo $os['name']; ?></span>
                            </div>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-muted group-hover:text-accent transition" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const ctx = document.getElementById('rankChart');
    if (ctx) {
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May'],
                datasets: [{
                    label: '<?php echo $teams[0]['team_name']; ?>',
                    data: [2, 1, 1, 2, 1],
                    borderColor: '#F0A500',
                    backgroundColor: 'rgba(240, 165, 0, 0.1)',
                    fill: true,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        reverse: true,
                        ticks: { stepSize: 1 },
                        grid: { color: 'rgba(255,255,255,0.05)' }
                    },
                    x: {
                        grid: { display: false }
                    }
                },
                plugins: {
                    legend: { display: false }
                }
            }
        });
    }
});
</script>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
