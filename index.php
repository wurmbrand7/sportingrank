<?php
/**
 * SportingRank.com - Homepage
 * Location: /home/pqrzcimfem/sportingrank.com/index.php
 */
require_once __DIR__ . '/includes/header.php';
// header.php already includes functions.php which includes lang.php

$sports = get_active_sports();

// Performance Optimization: Fetch all top teams in a single query
$sport_ids = array_column($sports, 'id');
$all_teams = [];
if (!empty($sport_ids)) {
    $placeholders = implode(',', array_fill(0, count($sport_ids), '?'));
    $stmt = $pdo->prepare("SELECT * FROM teams WHERE sport_id IN ($placeholders) AND is_active = 1 ORDER BY points DESC, wins DESC");
    $stmt->execute($sport_ids);
    $raw_teams = $stmt->fetchAll();

    foreach ($raw_teams as $team) {
        $all_teams[$team['sport_id']][$team['team_type']][] = $team;
    }
}

$default_bg     = 'https://images.unsplash.com/photo-1540747913346-19e32dc3e97e?q=80&w=2000';
$stadium_images = ['all' => $default_bg];
foreach ($sports as $s) {
    $stadium_images[$s['slug']] = !empty($s['hero_image'])
        ? $s['hero_image']
        : $default_bg;
}
?>

<div id="main-stadium-bg"
     class="min-h-screen transition-all duration-700 ease-in-out bg-cover bg-center bg-no-repeat bg-fixed"
     style="background-image: linear-gradient(rgba(10,10,26,0.8), rgba(10,10,26,0.9)), url('<?php echo e($default_bg); ?>');">

    <!-- Top Navigation Bar -->
    <div class="bg-[#0a0a1a] border-b border-white/5 sticky top-[72px] z-50">
        <div class="container mx-auto px-4 py-4 flex flex-col md:flex-row justify-between items-center gap-4">

            <!-- National / Club / Men / Women toggle -->
            <div class="flex items-center space-x-4 bg-card p-1 rounded-full border border-white/10">
                <button onclick="setTeamType('national')" id="type-national"
                        class="type-filter-btn px-4 py-1.5 rounded-full text-[10px] font-black uppercase tracking-widest transition bg-accent text-primary">
                    <span class="standard-label"><?php echo t('nav.national', 'National'); ?></span>
                    <span class="combat-label hidden"><?php echo t('label.men', 'Men'); ?></span>
                </button>
                <button onclick="setTeamType('club')" id="type-club"
                        class="type-filter-btn px-4 py-1.5 rounded-full text-[10px] font-black uppercase tracking-widest transition text-muted hover:text-white">
                    <span class="standard-label"><?php echo t('nav.leagues', 'Leagues'); ?></span>
                    <span class="combat-label hidden"><?php echo t('label.women', 'Women'); ?></span>
                </button>
            </div>

            <!-- Sport filter pills -->
            <div class="flex items-center space-x-3 overflow-x-auto no-scrollbar w-full md:w-auto">
                <button class="sport-nav-btn px-8 py-2 rounded-full font-heading font-black uppercase text-[11px] tracking-widest transition bg-accent text-primary border border-accent"
                        data-target="all">
                    <?php echo t('nav.all_sports', 'All Sports'); ?>
                </button>
                <?php foreach ($sports as $sport): ?>
                    <button class="sport-nav-btn px-6 py-2 rounded-full font-heading font-black uppercase text-[11px] tracking-widest transition bg-card text-[#EEEEFF] border border-white/10 hover:border-accent whitespace-nowrap flex items-center gap-2"
                            data-target="<?php echo e($sport['slug']); ?>">
                        <span><?php echo e($sport['icon']); ?></span>
                        <span><?php echo e($sport['name']); ?></span>
                    </button>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <!-- Rankings Grid -->
    <section class="py-12">
        <div class="container mx-auto px-4">
            <div id="sports-grid" class="grid grid-cols-1 lg:grid-cols-2 gap-8">

                <?php foreach ($sports as $sport): ?>
                    <?php
                        // Optimized: Get from pre-fetched array
                        $national_teams = array_slice($all_teams[$sport['id']]['national'] ?? [], 0, 10);
                        $club_teams     = array_slice($all_teams[$sport['id']]['club'] ?? [], 0, 10);

                        // Add rank position
                        foreach($national_teams as $i => &$t) $t['rank_position'] = $i + 1;
                        foreach($club_teams as $i => &$t) $t['rank_position'] = $i + 1;
                    ?>

                    <div class="sport-ranking-card"
                         id="section-<?php echo e($sport['slug']); ?>"
                         data-sport="<?php echo e($sport['slug']); ?>">

                        <div class="bg-[#141428]/90 rounded-2xl border border-white/5 overflow-hidden shadow-2xl">

                            <!-- Card Header -->
                            <div class="p-6 flex justify-between items-center">
                                <div class="flex items-center gap-4">
                                    <div class="flex items-center gap-1">
                                        <span class="text-2xl"><?php echo e($sport['icon']); ?></span>
                                        <span class="text-xl opacity-50">🏆</span>
                                    </div>
                                    <div>
                                        <h3 class="text-2xl font-heading font-black uppercase italic tracking-tighter leading-none text-white">
                                            <?php echo e($sport['name']); ?> Sport Ranking
                                        </h3>
                                        <p class="text-[9px] font-bold text-muted uppercase tracking-[0.2em] mt-1">
                                            <?php echo t('label.SportingRank', 'Sporting Rank | Sports Ranking'); ?>
                                        </p>
                                    </div>
                                </div>
                                <div class="flex items-center gap-2 bg-success/10 px-3 py-1 rounded-md border border-success/20">
                                    <span class="w-1.5 h-1.5 bg-success rounded-full animate-pulse"></span>
                                    <span class="text-success text-[9px] font-black uppercase tracking-widest">
                                        <?php echo t('label.live', 'Live'); ?>
                                    </span>
                                </div>
                            </div>

                            <!-- Desktop column headers (lg+) -->
                            <div class="hidden lg:grid
                                        px-6 pb-3
                                        grid-cols-[50px_1fr_50px_50px_50px_50px_90px_110px]
                                        text-[9px] font-black text-muted uppercase tracking-widest
                                        border-b border-white/5">
                                <div class="text-center"><?php echo t('label.rank', '#'); ?></div>
                                <div class="pl-10"><?php echo t('label.team', 'Team'); ?></div>
                                <div class="text-center"><?php echo t('label.gp', 'GP'); ?></div>
                                <div class="text-center"><?php echo t('label.wins', 'W'); ?></div>
                                <div class="text-center"><?php echo t('label.losses', 'L'); ?></div>
                                <div class="text-center"><?php echo t('label.draws', 'D'); ?></div>
                                <div class="text-center"><?php echo t('label.points', 'Points'); ?></div>
                                <div class="text-right pr-2"><?php echo t('label.trend_vote', 'Trend / Vote'); ?></div>
                            </div>

                            <!-- Mobile column headers (<lg) -->
                            <div class="grid lg:hidden
                                        px-3 pb-2
                                        grid-cols-[40px_1fr_auto]
                                        text-[9px] font-black text-muted uppercase tracking-widest
                                        border-b border-white/5">
                                <div class="text-center"><?php echo t('label.rank', '#'); ?></div>
                                <div class="pl-8"><?php echo t('label.team', 'Team'); ?></div>
                                <div class="text-right pr-1">
                                    <?php echo t('label.points', 'Pts'); ?> / <?php echo t('label.vote', 'Vote'); ?>
                                </div>
                            </div>

                            <!-- Rows -->
                            <div class="py-1">

                                <!-- National rows -->
                                <div class="teams-tbody-national">
                                    <?php if (empty($national_teams)): ?>
                                        <div class="py-12 text-center text-muted/20 font-black uppercase italic tracking-widest text-[10px]">
                                            <?php echo t('empty.national', 'No national rankings found'); ?>
                                        </div>
                                    <?php else: ?>
                                        <?php foreach ($national_teams as $team): ?>
                                            <?php echo render_team_row($team); ?>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </div>

                                <!-- Club rows (hidden by default) -->
                                <div class="teams-tbody-club hidden">
                                    <?php if (empty($club_teams)): ?>
                                        <div class="py-12 text-center text-muted/20 font-black uppercase italic tracking-widest text-[10px]">
                                            <?php echo t('empty.club', 'No league rankings found'); ?>
                                        </div>
                                    <?php else: ?>
                                        <?php foreach ($club_teams as $team): ?>
                                            <?php echo render_team_row($team); ?>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </div>

                            </div>

                            <!-- Card Footer -->
                            <div class="p-4 bg-card/80 border-t border-white/5 text-center">
                                <a href="<?php echo SITE_URL; ?>/ranking/<?php echo e($sport['slug']); ?>"
                                   class="inline-flex items-center space-x-2 text-[9px] font-black uppercase tracking-[0.2em] hover:text-accent transition">
                                    <span><?php echo t('nav.full_standings', 'Full Standings'); ?></span>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                                    </svg>
                                </a>
                            </div>

                        </div>
                    </div>

                <?php endforeach; ?>

            </div>
        </div>
    </section>
</div>

<script>
const stadiumImages = <?php echo json_encode($stadium_images, JSON_UNESCAPED_SLASHES); ?>;

// ---------------------------------------------------------------------------
// National / Club toggle
// ---------------------------------------------------------------------------
function setTeamType(type) {
    const nationalBtn = document.getElementById('type-national');
    const clubBtn     = document.getElementById('type-club');

    if (type === 'national') {
        nationalBtn.classList.add('bg-accent', 'text-primary');
        nationalBtn.classList.remove('text-muted');
        clubBtn.classList.remove('bg-accent', 'text-primary');
        clubBtn.classList.add('text-muted');
    } else {
        clubBtn.classList.add('bg-accent', 'text-primary');
        clubBtn.classList.remove('text-muted');
        nationalBtn.classList.remove('bg-accent', 'text-primary');
        nationalBtn.classList.add('text-muted');
    }

    document.querySelectorAll('.teams-tbody-national').forEach(el => {
        el.classList.toggle('hidden', type !== 'national');
    });
    document.querySelectorAll('.teams-tbody-club').forEach(el => {
        el.classList.toggle('hidden', type !== 'club');
    });

    document.querySelectorAll(`.teams-tbody-${type} .points-counter`).forEach(c => {
        if (c.innerText === '0') counterObserver.observe(c);
    });
}

// ---------------------------------------------------------------------------
// Vote handler
// ---------------------------------------------------------------------------
function voteForTeam(teamId, teamName) {
    fetch('/ajax/vote.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ team_id: teamId })
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            alert('<?php echo t_raw('label.vote', 'Vote'); ?>: ' + teamName);
        } else {
            alert(data.message || 'Could not cast vote. Please try again.');
        }
    })
    .catch(() => alert('Network error. Please try again.'));
}

// ---------------------------------------------------------------------------
// Sport filter + background swap
// ---------------------------------------------------------------------------
document.addEventListener('DOMContentLoaded', function () {
    const navButtons = document.querySelectorAll('.sport-nav-btn');
    const cards      = document.querySelectorAll('.sport-ranking-card');
    const bgWrapper  = document.getElementById('main-stadium-bg');
    const sportsGrid = document.getElementById('sports-grid');

    navButtons.forEach(btn => {
        btn.addEventListener('click', () => {
            const target = btn.getAttribute('data-target');

            // Toggle Men/Women labels for Combat Sports
            const isCombat = (target === 'boxing' || target === 'ufc');
            document.querySelectorAll('.combat-label').forEach(el => el.classList.toggle('hidden', !isCombat));
            document.querySelectorAll('.standard-label').forEach(el => el.classList.toggle('hidden', isCombat));

            navButtons.forEach(b => {
                b.classList.remove('bg-accent', 'text-primary', 'border-accent');
                b.classList.add('bg-card', 'text-[#EEEEFF]', 'border-white/10');
            });
            btn.classList.add('bg-accent', 'text-primary', 'border-accent');
            btn.classList.remove('bg-card', 'text-[#EEEEFF]', 'border-white/10');

            if (target === 'all') {
                cards.forEach(c => c.style.display = 'block');
                sportsGrid.classList.add('lg:grid-cols-2');
            } else {
                cards.forEach(c => {
                    c.style.display = c.getAttribute('data-sport') === target ? 'block' : 'none';
                });
                sportsGrid.classList.remove('lg:grid-cols-2');
            }

            const imgUrl  = stadiumImages[target] || stadiumImages['all'];
            const overlay = target === 'all'
                ? 'rgba(10,10,26,0.8), rgba(10,10,26,0.9)'
                : 'rgba(10,10,26,0.7), rgba(10,10,26,0.85)';
            bgWrapper.style.backgroundImage = `linear-gradient(${overlay}), url('${imgUrl}')`;
        });
    });

    // ---------------------------------------------------------------------------
    // Points counter animation
    // ---------------------------------------------------------------------------
    window.counterObserver = new IntersectionObserver(entries => {
        entries.forEach(entry => {
            if (!entry.isIntersecting) return;
            const counter   = entry.target;
            const target    = parseInt(counter.getAttribute('data-target'), 10);
            let count       = 0;
            const duration  = 1500;
            const increment = target / (duration / 16);

            const tick = () => {
                if (count < target) {
                    count += increment;
                    counter.innerText = Math.floor(count);
                    requestAnimationFrame(tick);
                } else {
                    counter.innerText = target.toLocaleString();
                }
            };
            tick();
            counterObserver.unobserve(counter);
        });
    }, { threshold: 0.1 });

    document.querySelectorAll('.points-counter').forEach(c => counterObserver.observe(c));
});
</script>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
