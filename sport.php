<?php
/**
 * SportingRank.com - Sport Detail Page
 * Location: /home/pqrzcimfem/sportingrank.com/sport.php
 * Route:    /sport/{slug}  →  sport.php?slug={slug}  (via .htaccess)
 *
 * __DIR__ = /home/pqrzcimfem/sportingrank.com
 * Uses global $pdo — NOT get_pdo() which doesn't exist in this codebase.
 */
require_once __DIR__ . '/includes/functions.php';

// ---------------------------------------------------------------------------
// 1. ROUTING & INPUT VALIDATION
// ---------------------------------------------------------------------------

$slug = strtolower(trim($_GET['slug'] ?? '', '/'));

if (!preg_match('/^[a-z0-9_-]+$/', $slug)) {
    $slug = '';
}

$type = (isset($_GET['type']) && $_GET['type'] === 'club') ? 'club' : 'national';

// ---------------------------------------------------------------------------
// 2. DATA FETCHING — global $pdo (no get_pdo())
// ---------------------------------------------------------------------------

$sport = null;

if ($slug !== '') {
    try {
        global $pdo;
        $stmt = $pdo->prepare(
            'SELECT * FROM sports WHERE LOWER(slug) = ? AND is_active = 1 LIMIT 1'
        );
        $stmt->execute([$slug]);
        $sport = $stmt->fetch();
    } catch (PDOException $e) {
        error_log('sport.php DB error: ' . $e->getMessage());
    }
}

// ---------------------------------------------------------------------------
// 3. 404 HANDLING
// ---------------------------------------------------------------------------

if (!$sport) {
    header('HTTP/1.1 404 Not Found');
    if (file_exists(__DIR__ . '/404.php')) {
        include __DIR__ . '/404.php';
    } else {
        echo "<div style='padding:100px;text-align:center;background:#050505;color:#fff;'>
                <h1>404</h1><p>Sport not found.</p><a href='/'>Return Home</a>
              </div>";
    }
    exit;
}

// ---------------------------------------------------------------------------
// 4. PAGE METADATA — unique per-sport titles for SEO
// ---------------------------------------------------------------------------

$sport_name    = $sport['name'] ?? 'Sport';
$type_label    = $type === 'club' ? 'Leagues & Clubs' : 'National Team Rankings';
$canonical_url = SITE_URL . '/ranking/' . rawurlencode($slug) . '?type=' . $type;

// Override site_title and meta_description for this page
// header.php reads these from $settings — we inject before including it
$_sport_page_title = $sport_name . ' Sport Ranking | Sporting Rank 2026 — ' . $type_label . ' | Sport Rank';
$_sport_page_desc  = 'Latest ' . $sport_name . ' Sport Ranking and Sporting Rank data for ' . strtolower($type_label)
                   . '. Updated daily for the 2025–2026 season. SportingRank.com';

$raw_hero = $sport['hero_image'] ?? '';
$hero_img = filter_var($raw_hero, FILTER_VALIDATE_URL)
    ? e($raw_hero)
    : '/assets/img/default-sport.jpg';

// ---------------------------------------------------------------------------
// 5. FETCH TEAMS
// ---------------------------------------------------------------------------

$teams      = get_top_teams($sport['id'], 50, $type);
$all_sports = get_active_sports();

// ---------------------------------------------------------------------------
// 6. OUTPUT — header.php is included here
// ---------------------------------------------------------------------------

require_once __DIR__ . '/includes/header.php';

// Inject sport-specific structured data after <head> opens
echo '<script type="application/ld+json">' . json_encode([
    '@context' => 'https://schema.org',
    '@type'    => 'SportsOrganization',
    'name'     => $sport_name . ' SportingRank | Global Sports Ranking & Sport Rank 2026',
    'url'      => $canonical_url,
    'sport'    => $sport_name,
    'description' => $_sport_page_desc,
], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . '</script>';
?>

<!-- HERO -->
<section class="relative py-24 overflow-hidden border-b border-border bg-primary">
    <div class="absolute inset-0 z-0">
        <div class="absolute inset-0 bg-gradient-to-t from-primary via-primary/80 to-transparent"></div>
        <img src="<?php echo $hero_img; ?>"
             alt="<?php echo e($sport_name); ?> Rankings 2026"
             class="w-full h-full object-cover opacity-30">
    </div>

    <div class="container mx-auto px-4 relative z-10 text-center">

        <!-- National / Club / Men / Women switcher -->
        <div class="flex justify-center mb-8">
            <div class="flex items-center space-x-4 bg-card p-1 rounded-full border border-border">
                <a href="/ranking/<?php echo e($slug); ?>?type=national"
                   class="px-4 py-1.5 rounded-full text-[10px] font-black uppercase tracking-widest transition
                          <?php echo $type === 'national' ? 'bg-accent text-primary' : 'text-muted hover:text-white'; ?>">
                    <?php echo e($sport['label_national'] ?: 'National'); ?>
                </a>
                <a href="/ranking/<?php echo e($slug); ?>?type=club"
                   class="px-4 py-1.5 rounded-full text-[10px] font-black uppercase tracking-widest transition
                          <?php echo $type === 'club' ? 'bg-accent text-primary' : 'text-muted hover:text-white'; ?>">
                    <?php echo e($sport['label_club'] ?: 'Leagues'); ?>
                </a>
            </div>
        </div>

        <div class="inline-flex items-center space-x-2 bg-accent/20 text-accent px-4 py-1 rounded-full border border-accent/30 text-xs font-black uppercase tracking-widest mb-6">
            <span>
                <?php echo e($sport_name); ?> Sport Ranking
                <?php echo t('label.SportingRank_2026', '2026'); ?>
            </span>
        </div>

        <h1 class="text-5xl md:text-8xl font-heading font-black italic uppercase tracking-tighter mb-4">
            <?php echo e($sport_name); ?>
        </h1>
        <p class="max-w-2xl mx-auto text-muted font-medium text-lg italic">
            <?php echo e($sport['description'] ?? t_raw('meta.description', 'Global performance analytics and SportingRank | Global Sports Ranking & Sport Rank for the 2025–2026 season.')); ?>
        </p>
    </div>
</section>

<!-- RANKINGS TABLE -->
<section class="py-20 bg-[#080808]">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">

            <!-- Main rankings list -->
            <div class="lg:col-span-2">
                <div class="glass-card rounded-2xl border border-border overflow-hidden bg-card/20">

                    <div class="p-4 md:p-6 border-b border-border flex justify-between items-center bg-white/5">
                        <h2 class="text-xl md:text-2xl font-heading font-black uppercase italic tracking-tighter">
                            <?php
                                echo $type === 'club'
                                    ? ($sport['label_club'] ?: 'Club Standings')
                                    : ($sport['label_national'] ?: 'National Standings');
                            ?>
                        </h2>
                        <div class="text-[10px] font-bold uppercase tracking-widest text-accent">
                            <?php echo t('label.real_time', 'Real-Time Data'); ?>
                        </div>
                    </div>

                    <?php if (!empty($teams)): ?>

                        <!-- Desktop column headers (lg+) -->
                        <div class="hidden lg:grid grid-cols-[50px_1fr_50px_50px_50px_50px_90px_110px]
                                    px-6 py-3 text-[10px] font-black text-muted uppercase tracking-widest
                                    border-b border-border/40 bg-primary/30">
                            <div class="text-center"><?php echo t('label.rank', 'Rank'); ?></div>
                            <div class="pl-12"><?php echo t('label.team', 'Team / Entity'); ?></div>
                            <div class="text-center"><?php echo t('label.gp', 'GP'); ?></div>
                            <div class="text-center"><?php echo t('label.wins', 'W'); ?></div>
                            <div class="text-center"><?php echo t('label.losses', 'L'); ?></div>
                            <div class="text-center"><?php echo t('label.draws', 'D'); ?></div>
                            <div class="text-center"><?php echo t('label.points', 'Points'); ?></div>
                            <div class="text-right"><?php echo t('label.action', 'Action'); ?></div>
                        </div>

                        <!-- Mobile column headers (<lg) -->
                        <div class="grid lg:hidden grid-cols-[40px_1fr_auto]
                                    px-3 py-2 text-[9px] font-black text-muted uppercase tracking-widest
                                    border-b border-border/40 bg-primary/30">
                            <div class="text-center"><?php echo t('label.rank', '#'); ?></div>
                            <div class="pl-2"><?php echo t('label.team', 'Team'); ?></div>
                            <div class="text-right pr-1"><?php echo t('label.points', 'Pts'); ?></div>
                        </div>

                        <?php
                        foreach ($teams as $team) {
                            echo render_team_row($team);
                        }
                        ?>

                    <?php else: ?>
                        <div class="py-20 text-center text-muted italic">
                            <div class="flex flex-col items-center gap-3">
                                <span class="text-4xl"><?php echo e($sport['icon'] ?? '🏆'); ?></span>
                                <p><?php echo $type === 'club'
                                    ? t('empty.no_club',     'No club rankings available yet.')
                                    : t('empty.no_national', 'No national rankings available yet.'); ?></p>
                            </div>
                        </div>
                    <?php endif; ?>

                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-8">
                <div class="glass-card rounded-2xl border border-border p-6 bg-card/20 shadow-xl">
                    <h3 class="text-lg font-heading font-black uppercase italic tracking-tighter mb-6 flex items-center">
                        <span class="w-8 h-[2px] bg-accent mr-3"></span>
                        <?php echo t('label.explore_sports', 'Explore Sports'); ?>
                    </h3>
                    <div class="space-y-3">
                        <?php foreach ($all_sports as $os): ?>
                            <?php if ($os['slug'] === $slug) continue; ?>
                            <a href="/ranking/<?php echo e($os['slug']); ?>"
                               class="block p-4 rounded-xl border border-border/50 bg-white/5
                                      hover:bg-accent/10 hover:border-accent transition group">
                                <div class="flex items-center justify-between">
                                    <span class="font-bold uppercase tracking-tight text-white/70
                                                 group-hover:text-accent transition">
                                        <?php echo e($os['name']); ?>
                                    </span>
                                    <span class="text-muted group-hover:translate-x-1 transition-transform">→</span>
                                </div>
                            </a>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
