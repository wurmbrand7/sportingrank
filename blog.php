<?php
require_once __DIR__ . '/includes/header.php';
$blogs = $pdo->query("SELECT * FROM blogs WHERE is_published = 1 ORDER BY created_at DESC")->fetchAll();
?>
<section class="py-24 bg-primary">
    <div class="container mx-auto px-4">
        <h1 class="text-4xl md:text-6xl font-heading font-black italic uppercase tracking-tighter mb-12">Sporting Rank Insights</h1>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <?php foreach ($blogs as $b): ?>
                <div class="glass-card rounded-2xl border border-border overflow-hidden group">
                    <?php if(!empty($b['featured_image'])): ?>
                        <div class="aspect-video overflow-hidden">
                            <img src="<?php echo e($b['featured_image']); ?>" alt="<?php echo e($b['title']); ?>" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                        </div>
                    <?php endif; ?>
                    <div class="p-6">
                        <span class="text-accent text-[10px] font-black uppercase tracking-widest mb-2 block"><?php echo date('M d, Y', strtotime($b['created_at'])); ?></span>
                        <h2 class="text-xl font-bold uppercase tracking-tight mb-4 group-hover:text-accent transition"><?php echo e($b['title']); ?></h2>
                        <p class="text-muted text-sm line-clamp-3 mb-6"><?php echo e($b['excerpt']); ?></p>
                        <a href="blog-post.php?slug=<?php echo $b['slug']; ?>" class="inline-flex items-center text-[10px] font-black uppercase tracking-widest text-white border-b-2 border-accent pb-1 hover:text-accent transition">Read More →</a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
