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
</head>
<body class="bg-primary text-[#EEEEFF] font-sans">
    <nav class="sticky top-0 z-50 bg-primary/80 backdrop-blur-md border-b border-border">
        <div class="container mx-auto px-4 py-4 flex justify-between items-center">
            <a href="<?php echo SITE_URL; ?>" class="flex items-center space-x-2 text-2xl font-heading font-black italic uppercase tracking-tighter">
                <span class="text-accent">⚽</span>
                <span>Sporting<span class="text-accent">Rank</span></span>
            </a>
            <div class="hidden md:flex items-center space-x-8 font-heading font-bold uppercase text-sm tracking-widest">
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
