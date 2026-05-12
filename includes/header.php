<?php
/**
 * SportingRank.com - Header
 * Location: /home/pqrzcimfem/sportingrank.com/includes/header.php
 *
 * __DIR__ = /home/pqrzcimfem/sportingrank.com/includes
 *
 * functions.php → __DIR__/functions.php           = includes/functions.php ✓
 *   └─ db.php   → __DIR__/db.php                  = includes/db.php        ✓
 *      └─ config → __DIR__/../config.php           = root/config.php        ✓
 *   └─ lang.php → __DIR__/lang.php                = includes/lang.php      ✓
 *
 * lang_switcher.php is at ROOT → __DIR__/../lang_switcher.php              ✓
 */
require_once __DIR__ . '/functions.php';

$settings  = get_all_settings();
$_lang     = lang_meta();
$_dir      = $_lang['is_rtl'] ? 'rtl' : 'ltr';
$_langcode = $_lang['code'];
?>
<!DOCTYPE html>
<html lang="<?php echo $_langcode; ?>" dir="<?php echo $_dir; ?>">
<head>
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
    new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
    j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
    'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
    })(window,document,'script','dataLayer','GTM-KHV4WRSQ');</script>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($_sport_page_title) ? e($_sport_page_title) : 'Sporting Rank | Sport Rank | Sports Ranking | Sport Rankings'; ?></title>
    <meta name="description" content="<?php echo isset($_sport_page_desc) ? e($_sport_page_desc) : 'Sporting Rank provides comprehensive sports rankings, sport rank data, and national team rankings for soccer, basketball, cricket and more. Check the latest sport ranking updates.'; ?>">

    <!-- Keywords SEO -->
    <meta name="keywords" content="Sporting Rank, Sport Rank, Sports Rank, Sports Ranking, Sport Ranking, Sport Rankings, National Team Rankings, World Sport Rank">

    <!-- Google Search Console Verification -->
    <meta name="google-site-verification" content="GSC_VERIFICATION_TOKEN_HERE">

    <!-- hreflang SEO -->
    <?php foreach (get_languages() as $_hl): ?>
    <link rel="alternate" hreflang="<?php echo $_hl['code']; ?>"
          href="<?php echo SITE_URL . strtok($_SERVER['REQUEST_URI'], '?') . '?lang=' . $_hl['code']; ?>">
    <?php endforeach; ?>
    <link rel="alternate" hreflang="x-default"
          href="<?php echo SITE_URL . strtok($_SERVER['REQUEST_URI'], '?'); ?>">

    <?php if (isset($canonical_url)): ?>
    <link rel="canonical" href="<?php echo e($canonical_url); ?>">
    <?php endif; ?>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <?php if ($_langcode === 'ar'): ?>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;700;900&family=Barlow:wght@400;500;700;900&family=Inter:wght@400;500;700&display=swap" rel="stylesheet">
    <?php elseif ($_langcode === 'zh'): ?>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+SC:wght@400;700;900&family=Barlow:wght@400;500;700;900&family=Inter:wght@400;500;700&display=swap" rel="stylesheet">
    <?php elseif ($_langcode === 'hi'): ?>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Devanagari:wght@400;700;900&family=Barlow:wght@400;500;700;900&family=Inter:wght@400;500;700&display=swap" rel="stylesheet">
    <?php else: ?>
    <link href="https://fonts.googleapis.com/css2?family=Barlow:wght@400;500;700;900&family=Inter:wght@400;500;700&display=swap" rel="stylesheet">
    <?php endif; ?>

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#0a0a1a',
                        card:    '#141428',
                        accent:  '<?php echo $settings['accent_color'] ?? '#F0A500'; ?>',
                        success: '#2ECC71',
                        danger:  '#E74C3C',
                        muted:   '#7A8AAA',
                        border:  '#1e2a40'
                    },
                    fontFamily: {
                        sans: [
                            <?php if ($_langcode === 'ar'): ?>'Cairo',
                            <?php elseif ($_langcode === 'zh'): ?>'Noto Sans SC',
                            <?php elseif ($_langcode === 'hi'): ?>'Noto Sans Devanagari',
                            <?php endif; ?>
                            'Inter', 'sans-serif'
                        ],
                        heading: [
                            <?php if ($_langcode === 'ar'): ?>'Cairo',
                            <?php elseif ($_langcode === 'zh'): ?>'Noto Sans SC',
                            <?php elseif ($_langcode === 'hi'): ?>'Noto Sans Devanagari',
                            <?php endif; ?>
                            'Barlow', 'sans-serif'
                        ]
                    }
                }
            }
        }
    </script>

    <?php if ($_lang['is_rtl']): ?>
    <style>
        [dir="rtl"] .space-x-2>*+* { margin-right:.5rem;  margin-left:0 }
        [dir="rtl"] .space-x-3>*+* { margin-right:.75rem; margin-left:0 }
        [dir="rtl"] .space-x-4>*+* { margin-right:1rem;   margin-left:0 }
        [dir="rtl"] .space-x-6>*+* { margin-right:1.5rem; margin-left:0 }
        [dir="rtl"] .mr-3   { margin-right:0;  margin-left:.75rem }
        [dir="rtl"] .pl-4   { padding-left:0;  padding-right:1rem }
        [dir="rtl"] .pl-8   { padding-left:0;  padding-right:2rem }
        [dir="rtl"] .pl-10  { padding-left:0;  padding-right:2.5rem }
        [dir="rtl"] .pl-12  { padding-left:0;  padding-right:3rem }
        [dir="rtl"] .pr-1   { padding-right:0; padding-left:.25rem }
        [dir="rtl"] .pr-2   { padding-right:0; padding-left:.5rem }
        [dir="rtl"] .pr-4   { padding-right:0; padding-left:1rem }
        [dir="rtl"] .pr-10  { padding-right:0; padding-left:2.5rem }
        [dir="rtl"] .text-right { text-align:left }
        [dir="rtl"] .text-left  { text-align:right }
        [dir="rtl"] #site-search { padding-left:2.5rem; padding-right:1rem }
        [dir="rtl"] .search-icon-wrapper { right:auto; left:.75rem }
        [dir="rtl"] .team-row .flex.justify-end { justify-content:flex-start }
        [dir="rtl"] .group-hover\:translate-x-1:hover { transform:translateX(-.25rem) }
    </style>
    <?php endif; ?>

    <link rel="stylesheet" href="<?php echo SITE_URL; ?>/assets/css/style.css">
</head>
<body class="bg-primary text-[#EEEEFF] font-sans">
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-KHV4WRSQ"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>

<nav class="sticky top-0 z-50 bg-primary/80 backdrop-blur-md border-b border-border">
    <div class="container mx-auto px-4 flex justify-between items-center min-h-[100px]">

        <!-- Logo -->
        <a href="<?php echo SITE_URL; ?>/" class="flex items-center group py-2 flex-shrink-0" title="Sporting Rank - Sport Rankings">
            <img src="<?php echo SITE_URL; ?>/assets/images/logo.png"
                 alt="Sporting Rank | Sport Rank | Sports Ranking"
                 class="h-24 w-auto md:h-32 flex-shrink-0 object-contain
                        transform group-hover:scale-105 transition-transform duration-300">
        </a>

        <!-- Desktop nav -->
        <div class="hidden md:flex items-center <?php echo $_lang['is_rtl'] ? 'flex-row-reverse' : ''; ?> gap-6
                    font-heading font-bold uppercase text-sm tracking-widest">
            <div class="relative flex items-center">
                <input type="text" id="site-search"
                       placeholder="<?php echo t('nav.search', 'Search sports or teams...'); ?>"
                       class="bg-card border border-border rounded-full py-2 pl-4 pr-10 text-xs
                              focus:outline-none focus:border-accent w-48 transition-all
                              focus:w-64 text-[#EEEEFF]">
                <div class="search-icon-wrapper absolute right-3 pointer-events-none text-muted">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                         viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>
            </div>
            <a href="<?php echo SITE_URL; ?>#rankings" class="hover:text-accent transition">
                <?php echo t('nav.rankings', 'Rankings'); ?>
            </a>
            <a href="<?php echo SITE_URL; ?>/blog.php" class="hover:text-accent transition">
                <?php echo t('nav.blog', 'Insights'); ?>
            </a>
            <a href="<?php echo SITE_URL; ?>/admin" class="text-muted hover:text-accent transition text-[10px]">
                Admin
            </a>
            <!-- lang_switcher.php lives at ROOT, not inside includes/ -->
            <?php require_once __DIR__ . '/../lang_switcher.php'; ?>
        </div>

        <!-- Mobile: switcher + hamburger -->
        <div class="md:hidden flex items-center gap-3">
            <?php require_once __DIR__ . '/../lang_switcher.php'; ?>
            <button id="mobile-menu-btn" class="text-white" aria-label="Open menu">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                     viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M4 6h16M4 12h16m-7 6h7"/>
                </svg>
            </button>
        </div>
    </div>

    <!-- Mobile dropdown -->
    <div id="mobile-menu"
         class="hidden md:hidden bg-[#0d0d20] border-t border-border px-4 py-4 space-y-3">
        <a href="<?php echo SITE_URL; ?>#rankings"
           class="block font-heading font-bold uppercase text-sm tracking-widest
                  hover:text-accent transition py-2 border-b border-white/5">
            <?php echo t('nav.rankings', 'Rankings'); ?>
        </a>
        <a href="<?php echo SITE_URL; ?>/blog.php"
           class="block font-heading font-bold uppercase text-sm tracking-widest
                  hover:text-accent transition py-2 border-b border-white/5">
            <?php echo t('nav.blog', 'Insights'); ?>
        </a>
        <div class="relative flex items-center pt-1">
            <input type="text" id="site-search-mobile"
                   placeholder="<?php echo t('nav.search', 'Search sports or teams...'); ?>"
                   class="bg-card border border-border rounded-full py-2 pl-4 pr-10 text-xs
                          focus:outline-none focus:border-accent w-full text-[#EEEEFF]">
            <div class="absolute right-3 pointer-events-none text-muted">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                     viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
            </div>
        </div>
    </div>
</nav>

<script>
document.getElementById('mobile-menu-btn')?.addEventListener('click', function () {
    document.getElementById('mobile-menu').classList.toggle('hidden');
});
</script>
