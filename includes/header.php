<?php
require_once __DIR__ . '/functions.php';
$settings = get_all_settings();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo e($settings['site_title'] ?? 'SportingRank'); ?></title>
    <meta name="description" content="<?php echo e($settings['meta_description'] ?? ''); ?>">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Barlow:wght@400;500;700;900&family=Inter:wght@400;500;700&display=swap" rel="stylesheet">

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#0a0a1a',
                        card: '#141428',
                        accent: '<?php echo $settings['accent_color'] ?? '#F0A500'; ?>',
                        success: '#2ECC71',
                        danger: '#E74C3C',
                        muted: '#7A8AAA',
                        border: '#1e2a40'
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                        heading: ['Barlow', 'sans-serif']
                    }
                }
            }
        }
    </script>

    <link rel="stylesheet" href="<?php echo SITE_URL; ?>/assets/css/style.css">

    <!-- Schema.org JSON-LD -->
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "SportsOrganization",
      "name": "<?php echo e($settings['site_title'] ?? 'SportingRank'); ?>",
      "url": "<?php echo SITE_URL; ?>",
      "description": "<?php echo e($settings['meta_description'] ?? ''); ?>",
      "logo": "<?php echo SITE_URL; ?>/assets/images/logo.png"
    }
    </script>
</head>
<body class="bg-primary text-[#EEEEFF] font-sans">
    <nav class="sticky top-0 z-50 bg-primary/80 backdrop-blur-md border-b border-border">
        <div class="container mx-auto px-4 py-4 flex justify-between items-center">
            <a href="<?php echo SITE_URL; ?>/" class="flex items-center space-x-2 text-2xl font-heading font-black italic uppercase tracking-tighter">
                <span class="text-accent">⚽</span>
                <span>Sporting<span class="text-accent">Rank</span></span>
            </a>
            <div class="hidden md:flex items-center space-x-6 font-heading font-bold uppercase text-sm tracking-widest">
                <div class="relative">
                    <input type="text" id="site-search" placeholder="Search sports or teams..." class="bg-card border border-border rounded-full py-1 px-4 text-xs focus:outline-none focus:border-accent w-40 transition-all focus:w-56">
                </div>
                <button id="theme-toggle" class="p-2 rounded-full hover:bg-white/10 transition text-accent">
                    <svg id="theme-icon-dark" class="h-4 w-4 hidden" fill="currentColor" viewBox="0 0 20 20"><path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path></svg>
                    <svg id="theme-icon-light" class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20"><path d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z"></path></svg>
                </button>
                <a href="<?php echo SITE_URL; ?>#rankings" class="hover:text-accent transition">Rankings</a>
                <a href="#" class="hover:text-accent transition">History</a>
                <a href="#" class="hover:text-accent transition">About</a>
                <a href="<?php echo SITE_URL; ?>/admin" class="text-muted hover:text-accent transition text-[10px]">Admin</a>
            </div>
            <button class="md:hidden text-white">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
                </svg>
            </button>
        </div>
    </nav>
