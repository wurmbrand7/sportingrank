    <footer class="bg-card border-t border-border mt-20 py-12">
        <div class="container mx-auto px-4">
            <div class="flex flex-col md:flex-row justify-between items-center mb-8">
                <div class="mb-4 md:mb-0">
                    <a href="<?php echo SITE_URL; ?>" class="flex items-center space-x-2 text-xl font-heading font-black italic uppercase tracking-tighter">
                        <span class="text-accent">⚽</span>
                        <span>Sporting<span class="text-accent">Rank</span></span>
                    </a>
                    <p class="text-muted text-sm mt-2 font-medium"><?php echo e($settings['site_tagline'] ?? ''); ?></p>
                </div>
                <div class="flex space-x-6 text-sm font-bold uppercase tracking-widest">
                    <a href="#" class="hover:text-accent transition">About</a>
                    <a href="#" class="hover:text-accent transition">Contact</a>
                    <a href="<?php echo SITE_URL; ?>/admin" class="hover:text-accent transition">Admin Login</a>
                </div>
            </div>
            <div class="flex flex-col md:flex-row justify-between items-center pt-8 border-t border-border text-muted text-xs font-bold uppercase tracking-widest">
                <p><?php echo e($settings['footer_text'] ?? ''); ?></p>
                <p>Last updated: <?php echo e($settings['last_updated'] ?? ''); ?></p>
            </div>
        </div>
    </footer>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- CountUp.js -->
    <script src="https://cdn.jsdelivr.net/npm/countup.js@2.8.0/dist/countUp.umd.js"></script>
    <!-- Main JS -->
    <script src="<?php echo SITE_URL; ?>/assets/js/main.js"></script>
</body>
</html>
