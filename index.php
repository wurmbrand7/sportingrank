<?php
require_once __DIR__ . '/includes/header.php';
$sports = get_active_sports();
?>

<!-- Dynamic Background Wrapper -->
<div id="main-stadium-bg" class="min-h-screen transition-all duration-700 ease-in-out bg-cover bg-center bg-no-repeat bg-fixed"
     style="background-image: linear-gradient(rgba(10, 10, 26, 0.8), rgba(10, 10, 26, 0.9)), url('https://images.unsplash.com/photo-1540747913346-19e32dc3e97e?q=80&w=2000');">

    <!-- Top Navigation Bar -->
    <div class="bg-[#0a0a1a] border-b border-white/5 sticky top-[72px] z-50">
        <div class="container mx-auto px-4 py-4 flex flex-col md:flex-row justify-between items-center gap-4">
            <!-- Team Type Toggle -->
            <div class="flex items-center space-x-4 bg-card p-1 rounded-full border border-white/10">
                <button onclick="setTeamType('national')" id="type-national" class="type-filter-btn px-4 py-1.5 rounded-full text-[10px] font-black uppercase tracking-widest transition bg-accent text-primary">National</button>
                <button onclick="setTeamType('club')" id="type-club" class="type-filter-btn px-4 py-1.5 rounded-full text-[10px] font-black uppercase tracking-widest transition text-muted hover:text-white">Leagues</button>
            </div>

            <!-- Sport Filters -->
            <div class="flex items-center space-x-3 overflow-x-auto no-scrollbar w-full md:w-auto">
                <button class="sport-nav-btn px-8 py-2 rounded-full font-heading font-black uppercase text-[11px] tracking-widest transition bg-accent text-primary border border-accent" data-target="all">
                    All Sports
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

    <!-- Main Rankings Grid -->
    <section class="py-12">
        <div class="container mx-auto px-4">
            <div id="sports-grid" class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <?php foreach ($sports as $sport): ?>
                    <?php
                        $national_teams = get_top_teams($sport['id'], 10, 'national');
                        $club_teams = get_top_teams($sport['id'], 10, 'club');
                    ?>

                    <div class="sport-ranking-card" id="section-<?php echo e($sport['slug']); ?>" data-sport="<?php echo e($sport['slug']); ?>">
                        <div class="bg-[#141428]/90 rounded-2xl border border-white/5 overflow-hidden shadow-2xl">

                            <div class="p-6 flex justify-between items-center">
                                <div class="flex items-center gap-4">
                                    <div class="flex items-center gap-1">
                                        <span class="text-2xl"><?php echo e($sport['icon']); ?></span>
                                        <span class="text-xl opacity-50">🏆</span>
                                    </div>
                                    <div>
                                        <h3 class="text-2xl font-heading font-black uppercase italic tracking-tighter leading-none text-white">
                                            <?php echo e($sport['name']); ?>
                                        </h3>
                                        <p class="text-[9px] font-bold text-muted uppercase tracking-[0.2em] mt-1">World Rankings</p>
                                    </div>
                                </div>
                                <div class="flex items-center gap-2 bg-success/10 px-3 py-1 rounded-md border border-success/20">
                                    <span class="w-1.5 h-1.5 bg-success rounded-full animate-pulse"></span>
                                    <span class="text-success text-[9px] font-black uppercase tracking-widest">Live</span>
                                </div>
                            </div>

                            <div class="px-8 pb-3 grid grid-cols-12 text-[9px] font-black text-muted uppercase tracking-widest border-b border-white/5">
                                <div class="col-span-1">#</div>
                                <div class="col-span-5">Team</div>
                                <div class="col-span-2 text-center">Points</div>
                                <div class="col-span-2 text-center">Trend</div>
                                <div class="col-span-2 text-right">Vote</div>
                            </div>

                            <div class="p-2">
                                <!-- National Teams Body -->
                                <div class="teams-tbody-national">
                                    <?php foreach ($national_teams as $index => $team): ?>
                                        <div class="team-row grid grid-cols-12 items-center py-3 px-6 hover:bg-white/[0.03] transition rounded-xl">
                                            <div class="col-span-1">
                                                <?php
                                                    $rank = $team['rank_position'];
                                                    $medal = 'bg-[#1e1e38] text-muted';
                                                    if ($rank == 1) $medal = 'bg-[#FFD700] text-primary';
                                                    if ($rank == 2) $medal = 'bg-[#C0C0C0] text-primary';
                                                    if ($rank == 3) $medal = 'bg-[#CD7F32] text-primary';
                                                ?>
                                                <span class="w-7 h-7 flex items-center justify-center rounded-full text-[11px] font-black <?php echo $medal; ?>">
                                                    <?php echo $rank; ?>
                                                </span>
                                            </div>
                                            <div class="col-span-5 flex items-center gap-3">
                                                <img src="https://flagcdn.com/w40/<?php echo strtolower($team['country_code'] ?? 'us'); ?>.png" class="w-6 h-4 object-cover rounded-sm shadow-sm">
                                                <span class="font-bold text-[13px] text-white"><?php echo e($team['team_name']); ?></span>
                                            </div>
                                            <div class="col-span-2 text-center">
                                                <span class="font-black text-accent italic text-[14px]">
                                                    <span class="points-counter" data-target="<?php echo (int)$team['points']; ?>">0</span><span class="text-[9px] lowercase ml-0.5 not-italic">pts</span>
                                                </span>
                                            </div>
                                            <div class="col-span-2 text-center">
                                                <?php echo format_trend($team['trend']); ?>
                                            </div>
                                            <div class="col-span-2 text-right">
                                                <button onclick="voteForTeam(<?php echo $team['id']; ?>, '<?php echo e($team['team_name']); ?>')" class="vote-btn border border-accent/20 hover:bg-accent hover:text-primary transition-all text-[9px] font-black uppercase px-3 py-1.5 rounded">Vote</button>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>

                                <!-- Club Teams Body (Hidden by default) -->
                                <div class="teams-tbody-club hidden">
                                    <?php foreach ($club_teams as $index => $team): ?>
                                        <div class="team-row grid grid-cols-12 items-center py-3 px-6 hover:bg-white/[0.03] transition rounded-xl">
                                            <div class="col-span-1">
                                                <?php
                                                    $rank = $team['rank_position'];
                                                    $medal = 'bg-[#1e1e38] text-muted';
                                                    if ($rank == 1) $medal = 'bg-[#FFD700] text-primary';
                                                    if ($rank == 2) $medal = 'bg-[#C0C0C0] text-primary';
                                                    if ($rank == 3) $medal = 'bg-[#CD7F32] text-primary';
                                                ?>
                                                <span class="w-7 h-7 flex items-center justify-center rounded-full text-[11px] font-black <?php echo $medal; ?>">
                                                    <?php echo $rank; ?>
                                                </span>
                                            </div>
                                            <div class="col-span-5 flex items-center gap-3">
                                                <img src="https://flagcdn.com/w40/<?php echo strtolower($team['country_code'] ?? 'us'); ?>.png" class="w-6 h-4 object-cover rounded-sm shadow-sm">
                                                <span class="font-bold text-[13px] text-white"><?php echo e($team['team_name']); ?></span>
                                            </div>
                                            <div class="col-span-2 text-center">
                                                <span class="font-black text-accent italic text-[14px]">
                                                    <span class="points-counter" data-target="<?php echo (int)$team['points']; ?>">0</span><span class="text-[9px] lowercase ml-0.5 not-italic">pts</span>
                                                </span>
                                            </div>
                                            <div class="col-span-2 text-center">
                                                <?php echo format_trend($team['trend']); ?>
                                            </div>
                                            <div class="col-span-2 text-right">
                                                <button onclick="voteForTeam(<?php echo $team['id']; ?>, '<?php echo e($team['team_name']); ?>')" class="vote-btn border border-accent/20 hover:bg-accent hover:text-primary transition-all text-[9px] font-black uppercase px-3 py-1.5 rounded">Vote</button>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>

                            <div class="p-4 bg-card/80 border-t border-white/5">
                                <a href="<?php echo SITE_URL; ?>/sport/<?php echo e($sport['slug']); ?>" class="flex items-center justify-center space-x-2 text-[10px] font-black uppercase tracking-widest hover:text-accent transition">
                                    <span>Full Standings</span>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
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
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const navButtons = document.querySelectorAll('.sport-nav-btn');
    const cards = document.querySelectorAll('.sport-ranking-card');
    const bgWrapper = document.getElementById('main-stadium-bg');
    const sportsGrid = document.getElementById('sports-grid');

    const stadiumImages = {
        'all': 'https://images.unsplash.com/photo-1540747913346-19e32dc3e97e?q=80&w=2000',
        'cricket': 'https://images.unsplash.com/photo-1531415074968-036ba1b575da?q=80&w=2000',
        'soccer': 'https://images.unsplash.com/photo-1508098682722-e99c43a406b2?q=80&w=2000',
        'basketball': 'https://images.unsplash.com/photo-1504450758481-7338eba7524a?q=80&w=2000'
    };

    navButtons.forEach(btn => {
        btn.addEventListener('click', () => {
            const target = btn.getAttribute('data-target');

            navButtons.forEach(b => {
                b.classList.remove('bg-accent', 'text-primary', 'border-accent');
                b.classList.add('bg-card', 'text-[#EEEEFF]', 'border-white/10');
            });
            btn.classList.add('bg-accent', 'text-primary', 'border-accent');
            btn.classList.remove('bg-card', 'text-[#EEEEFF]', 'border-white/10');

            if (target === 'all') {
                cards.forEach(c => c.style.display = 'block');
                sportsGrid.classList.add('lg:grid-cols-2');
                sportsGrid.classList.remove('max-w-2xl', 'mx-auto');
                bgWrapper.style.backgroundImage = `linear-gradient(rgba(10, 10, 26, 0.8), rgba(10, 10, 26, 0.9)), url('${stadiumImages.all}')`;
            } else {
                cards.forEach(c => {
                    c.style.display = (c.getAttribute('data-sport') === target) ? 'block' : 'none';
                });
                sportsGrid.classList.remove('lg:grid-cols-2');
                sportsGrid.classList.add('max-w-2xl', 'mx-auto');

                const imgUrl = stadiumImages[target] || stadiumImages['all'];
                bgWrapper.style.backgroundImage = `linear-gradient(rgba(10, 10, 26, 0.7), rgba(10, 10, 26, 0.85)), url('${imgUrl}')`;
            }
            // window.scrollTo({ top: 0, behavior: 'smooth' });
        });
    });
});
</script>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
