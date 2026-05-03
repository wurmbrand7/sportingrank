<?php
require_once __DIR__ . '/db.php';

function get_setting($key, $default = '') {
    global $pdo;
    $stmt = $pdo->prepare("SELECT setting_value FROM site_settings WHERE setting_key = ?");
    $stmt->execute([$key]);
    $result = $stmt->fetch();
    return $result ? $result['setting_value'] : $default;
}

function get_all_settings() {
    global $pdo;
    $stmt = $pdo->query("SELECT setting_key, setting_value FROM site_settings");
    $settings = [];
    while ($row = $stmt->fetch()) {
        $settings[$row['setting_key']] = $row['setting_value'];
    }
    return $settings;
}

function get_active_sports() {
    global $pdo;
    $stmt = $pdo->query("SELECT * FROM sports WHERE is_active = 1 ORDER BY sort_order ASC");
    return $stmt->fetchAll();
}

function get_top_teams($sport_id, $limit = 10) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM teams WHERE sport_id = :sport_id AND is_active = 1 ORDER BY rank_position ASC LIMIT :limit");
    $stmt->bindValue(':sport_id', $sport_id, PDO::PARAM_INT);
    $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll();
}

function format_trend($trend) {
    switch ($trend) {
        case 'up': return '<span class="text-success">▲</span>';
        case 'down': return '<span class="text-danger">▼</span>';
        default: return '<span class="text-muted">—</span>';
    }
}

function e($string) {
    return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
}
?>
