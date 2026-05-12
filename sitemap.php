<?php
require_once __DIR__ . '/includes/functions.php';

header("Content-Type: application/xml; charset=utf-8");

echo '<?xml version="1.0" encoding="UTF-8"?>';
?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <url>
        <loc><?php echo SITE_URL; ?>/</loc>
        <priority>1.0</priority>
        <changefreq>daily</changefreq>
    </url>

    <?php
    $sports = get_active_sports();
    foreach ($sports as $sport):
    ?>
    <url>
        <loc><?php echo SITE_URL; ?>/ranking/<?php echo e($sport['slug']); ?></loc>
        <priority>0.8</priority>
        <changefreq>weekly</changefreq>
    </url>
    <url>
        <loc><?php echo SITE_URL; ?>/ranking/<?php echo e($sport['slug']); ?>?type=club</loc>
        <priority>0.7</priority>
        <changefreq>weekly</changefreq>
    </url>
    <?php endforeach; ?>

    <?php
    $blogs = $pdo->query("SELECT slug FROM blogs WHERE is_published = 1")->fetchAll();
    foreach ($blogs as $blog):
    ?>
    <url>
        <loc><?php echo SITE_URL; ?>/blog-post.php?slug=<?php echo e($blog['slug']); ?></loc>
        <priority>0.6</priority>
        <changefreq>monthly</changefreq>
    </url>
    <?php endforeach; ?>
</urlset>
