<?php
require_once __DIR__ . '/includes/header.php';

$sports = get_active_sports();
?>

<!-- Hero Section -->
<section class="relative overflow-hidden pt-20 pb-32">
    <!-- Animated background placeholder -->
    <div class="absolute inset-0 z-0 opacity-20 pointer-events-none">
        <svg width="100%" height="100%" xmlns="http://www.w3.org/2000/svg">
            <defs>
                <pattern id="grid" width="40" height="40" patternUnits="userSpaceOnUse">
                    <path d="M 40 0 L 0 0 0 40" fill="none" stroke="#F0A500" stroke-width="0.5"/>
                </pattern>
            </defs>
            <rect width="100%" height="100%" fill="url(#grid)" />
        </svg>
    </div>

    <div class="container mx-auto px-4 relative z-10 text-center">
        <h1 class="text-5xl md:text-7xl font-heading font-black italic uppercase tracking-tighter mb-4">
            World Sports <span class="text-accent">Rankings</span> 2026
        </h1>
        <p class="text-muted text-xl font-medium mb-12"><?php echo e($settings['site_tagline'] ?? ''); ?></p>

        <div class="flex flex-wrap justify-center gap-6 md:gap-12">
            <div class="text-center">
                <div class="text-3xl md:text-4xl font-heading font-black text-accent stat-counter" data-target="<?php echo count($sports); ?>">0</div>
                <div class="text-xs font-bold uppercase tracking-widest text-muted mt-1">Sports</div>
            </div>
            <div class="text-center border-x border-border px-6 md:px-12">
                <?php $total_teams = $pdo->query("SELECT COUNT(*) FROM teams")->fetchColumn(); ?>
                <div class="text-3xl md:text-4xl font-heading font-black text-accent stat-counter" data-target="<?php echo $total_teams; ?>">0</div>
                <div class="text-xs font-bold uppercase tracking-widest text-muted mt-1">Teams Ranked</div>
            </div>
            <div class="text-center">
                <div class="text-3xl md:text-4xl font-heading font-black text-accent uppercase">Weekly</div>
                <div class="text-xs font-bold uppercase tracking-widest text-muted mt-1">Updates</div>
            </div>
        </div>
    </div>
</section>

<!-- Sports Filter Tabs -->
<div class="sticky top-[73px] z-40 bg-primary/95 backdrop-blur-sm border-y border-border py-4">
    <div class="container mx-auto px-4">
        <div class="flex items-center space-x-2 overflow-x-auto no-scrollbar pb-1">
            <button class="sport-filter-btn flex items-center space-x-2 px-6 py-2 rounded-full font-heading font-black uppercase text-xs tracking-widest transition whitespace-nowrap bg-accent text-primary" data-filter="all">
                <span>🌎</span>
                <span>All Sports</span>
            </button>
            <?php foreach ($sports as $sport): ?>
                <button class="sport-filter-btn flex items-center space-x-2 px-6 py-2 rounded-full font-heading font-black uppercase text-xs tracking-widest transition whitespace-nowrap bg-card text-[#EEEEFF] border border-border hover:border-accent" data-filter="<?php echo e($sport['slug']); ?>">
                    <span><?php echo e($sport['icon'] ?? '🏆'); ?></span>
                    <span><?php echo e($sport['name']); ?></span>
                </button>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<!-- Rankings Grid -->
<section id="rankings" class="py-20">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <?php foreach ($sports as $sport): ?>
                <?php
                    $teams = get_top_teams($sport['id']);
                ?>
                <div class="sport-ranking-card" data-sport="<?php echo e($sport['slug']); ?>">
                    <div class="glass-card rounded-xl overflow-hidden border border-border">
                        <!-- Card Header -->
                        <div class="p-6 border-b border-border flex justify-between items-center bg-card/50">
                            <div class="flex items-center space-x-3">
                                <span class="text-2xl"><?php echo e($sport['icon']); ?></span>
                                <div>
                                    <h3 class="text-xl font-heading font-black uppercase italic tracking-tighter"><?php echo e($sport['name']); ?></h3>
                                    <span class="text-[10px] font-bold uppercase tracking-widest text-muted"><?php echo e($sport['governing_body']); ?> Official</span>
                                </div>
                            </div>
                            <div class="flex items-center space-x-2 bg-success/10 px-2 py-1 rounded border border-success/20">
                                <span class="live-pulse"></span>
                                <span class="text-[10px] font-black uppercase text-success tracking-widest">Live</span>
                            </div>
                        </div>

                        <!-- Teams List -->
                        <div class="p-2">
                            <table class="w-full text-left">
                                <thead>
                                    <tr class="text-[10px] font-black uppercase tracking-widest text-muted border-b border-border/50">
                                        <th class="py-2 px-4">#</th>
                                        <th class="py-2 px-2">Team</th>
                                        <th class="py-2 px-4 text-right">Points</th>
                                        <th class="py-2 px-4 text-center">Trend</th>
                                        <th class="py-2 px-4 text-center">Vote</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($teams as $team): ?>
                                        <?php
                                            $rank_class = '';
                                            if ($team['rank_position'] == 1) $rank_class = 'rank-1';
                                            elseif ($team['rank_position'] == 2) $rank_class = 'rank-2';
                                            elseif ($team['rank_position'] == 3) $rank_class = 'rank-3';
                                        ?>
                                        <tr class="border-b border-border/30 last:border-0 hover:bg-white/5 transition">
                                            <td class="py-3 px-4">
                                                <span class="rank-badge <?php echo $rank_class; ?>"><?php echo $team['rank_position']; ?></span>
                                            </td>
                                            <td class="py-3 px-2">
                                                <div class="flex items-center space-x-3">
                                                    <img src="https://flagcdn.com/24x18/<?php echo strtolower($team['country_code']); ?>.png" alt="" class="rounded-sm">
                                                    <span class="font-bold text-sm"><?php echo e($team['team_name']); ?></span>
                                                </div>
                                            </td>
                                            <td class="py-3 px-4 text-right font-heading font-black text-accent italic">
                                                <span class="points-counter" data-target="<?php echo (int)$team['points']; ?>">0</span> <span class="text-[8px] italic opacity-50"><?php echo e($team['points_label']); ?></span>
                                            </td>
                                            <td class="py-3 px-4 text-center">
                                                <?php echo format_trend($team['trend']); ?>
                                            </td>
                                            <td class="py-3 px-4 text-center">
                                                <button onclick="voteForTeam(<?php echo $team['id']; ?>, '<?php echo e($team['team_name']); ?>')" class="text-[10px] bg-accent/10 hover:bg-accent text-accent hover:text-primary border border-accent/30 px-2 py-1 rounded transition font-black uppercase">Vote</button>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>

                        <!-- Card Footer -->
                        <div class="p-4 bg-card/80 border-t border-border">
                            <a href="<?php echo SITE_URL; ?>/sport/<?php echo e($sport['slug']); ?>" class="flex items-center justify-center space-x-2 text-xs font-black uppercase tracking-widest hover:text-accent transition">
                                <span>View Full Rankings</span>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- "Did You Know?" Banner -->
<section class="py-12 bg-card border-y border-border overflow-hidden">
    <div class="container mx-auto px-4">
        <div class="flex items-center space-x-6 border-l-4 border-accent pl-6 py-2">
            <span class="text-accent font-heading font-black uppercase italic tracking-tighter text-xl shrink-0">Did You Know?</span>
            <div id="rotating-fact" class="text-sm font-medium italic min-h-[1.5em] flex items-center">
                Cricket is the second most popular sport in the world with over 2.5 billion fans globally.
            </div>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
