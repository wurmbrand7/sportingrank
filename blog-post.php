<?php
require_once __DIR__ . '/includes/header.php';
$slug = $_GET['slug'] ?? '';
$stmt = $pdo->prepare("SELECT * FROM blogs WHERE slug = ? AND is_published = 1");
$stmt->execute([$slug]);
$post = $stmt->fetch();
if (!$post) { header("Location: blog.php"); exit; }
?>
<section class="py-24 bg-primary">
    <div class="container mx-auto px-4 max-w-4xl">
        <a href="blog.php" class="text-accent text-[10px] font-black uppercase tracking-widest mb-6 inline-block hover:underline">← Back to Blog</a>
        <h1 class="text-4xl md:text-7xl font-heading font-black italic uppercase tracking-tighter mb-8 leading-tight"><?php echo e($post['title']); ?></h1>
        <div class="flex items-center space-x-4 mb-12 pb-8 border-b border-white/5">
            <div class="w-10 h-10 rounded-full bg-accent flex items-center justify-center text-primary font-black">SR</div>
            <div>
                <p class="text-xs font-bold uppercase text-white">Sporting Rank Editorial</p>
                <p class="text-[10px] text-muted font-bold uppercase"><?php echo date('F d, Y', strtotime($post['created_at'])); ?></p>
            </div>
        </div>
        <div class="prose prose-invert prose-accent max-w-none text-muted leading-relaxed text-lg">
            <?php echo $post['content']; ?>
        </div>
    </div>
</section>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
