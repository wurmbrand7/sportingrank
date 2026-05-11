    <footer class="bg-card border-t border-border mt-20 py-12">
        <div class="container mx-auto px-4">
            <div class="flex flex-col md:flex-row justify-between items-start mb-8">
                <div class="mb-8 md:mb-0 max-w-md">
                    <a href="<?php echo SITE_URL; ?>" class="flex items-center space-x-2 text-xl font-heading font-black italic uppercase tracking-tighter mb-4">
                        <span class="text-accent text-3xl">⚽</span>
                        <span>Sporting<span class="text-accent">Rank</span></span>
                    </a>
                    <p class="text-muted text-xs font-medium leading-relaxed">
                        All product names, logos, and brands are property of their respective owners. All company, product and service names used in this website are for identification purposes only. Use of these names, logos, and brands does not imply endorsement.
                    </p>
                </div>

                <div class="grid grid-cols-2 sm:grid-cols-3 gap-12 text-sm font-bold uppercase tracking-widest">
                    <div class="flex flex-col space-y-3">
                        <span class="text-accent text-[10px]">Company</span>
                        <a href="#" class="hover:text-accent transition">About Us</a>
                        <a href="#" class="hover:text-accent transition">Contact</a>
                    </div>
                    <div class="flex flex-col space-y-3">
                        <span class="text-accent text-[10px]">Portal</span>
                        <a href="<?php echo SITE_URL; ?>/blog.php" class="hover:text-accent transition">Sports Insights</a>
                        <a href="<?php echo SITE_URL; ?>/admin" class="hover:text-accent transition">Admin Login</a>
                        <a href="<?php echo SITE_URL; ?>/sitemap.php" class="hover:text-accent transition">Sitemap</a>
                    </div>
                    <?php
                    $bls = $pdo->query("SELECT * FROM backlinks WHERE is_active = 1 LIMIT 5")->fetchAll();
                    if (!empty($bls)): ?>
                    <div class="flex flex-col space-y-3">
                        <span class="text-accent text-[10px]">Resources</span>
                        <?php foreach($bls as $bl): ?>
                            <a href="<?php echo e($bl['url']); ?>" rel="<?php echo e($bl['rel']); ?>" class="hover:text-accent transition"><?php echo e($bl['title']); ?></a>
                        <?php endforeach; ?>
                    </div>
                    <?php endif; ?>
                </div>
            </div>

            <div class="flex flex-col md:flex-row justify-between items-center pt-8 border-t border-white/5 text-muted text-[10px] font-black uppercase tracking-widest">
                <p><?php echo e($settings['footer_text'] ?? '© 2026 Sporting Rank. All rights reserved.'); ?></p>
                <div class="flex items-center space-x-4 mt-4 md:mt-0">
                    <span>Sporting Rank</span>
                    <span class="w-1 h-1 bg-muted rounded-full"></span>
                    <span>National Team Rankings</span>
                </div>
            </div>
        </div>
    </footer>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/countup.js@2.8.0/dist/countUp.umd.js"></script>
    <script src="<?php echo SITE_URL; ?>/assets/js/main.js"></script>
</body>
</html>
