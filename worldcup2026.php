<?php
/**
 * SportingRank.com - World Cup 2026 Logic & Data
 */
require_once __DIR__ . '/includes/db.php';

// Fetch WC Settings
$wc_settings_raw = $pdo->query("SELECT setting_key, setting_value FROM wc_settings")->fetchAll(PDO::FETCH_KEY_PAIR);
$worldcup_2026 = [
    'dates'          => $wc_settings_raw['wc_dates'] ?? 'June 11 – July 19, 2026',
    'host_nations'   => explode(', ', $wc_settings_raw['wc_hosts'] ?? 'USA, Mexico, Canada'),
    'total_teams'    => $wc_settings_raw['wc_total_teams'] ?? '48',
    'total_matches'  => $wc_settings_raw['wc_total_matches'] ?? '104',
    'total_groups'   => $wc_settings_raw['wc_total_groups'] ?? '12',
    'opening_match'  => $wc_settings_raw['wc_opening_match'] ?? 'Mexico City',
    'final'          => $wc_settings_raw['wc_final'] ?? 'New Jersey',
];

// Fetch Stadiums
$stadiums = $pdo->query("SELECT * FROM wc_stadiums ORDER BY country, city")->fetchAll();

function getStadiumsByCountry($country) {
    global $stadiums;
    return array_filter($stadiums, function($s) use ($country) {
        return strtolower($s['country']) === strtolower($country);
    });
}

// Fetch Groups & Teams
$groups_raw = $pdo->query("SELECT g.group_letter, t.name, t.matches_played, t.wins, t.draws, t.losses, t.goals_for, t.goals_against, t.points
                           FROM wc_groups g
                           LEFT JOIN wc_teams t ON g.id = t.group_id
                           ORDER BY g.group_letter, t.points DESC, (t.goals_for - t.goals_against) DESC")->fetchAll();

$groups = [];
foreach ($groups_raw as $row) {
    if (!isset($groups[$row['group_letter']])) $groups[$row['group_letter']] = [];
    if ($row['name']) $groups[$row['group_letter']][] = $row;
}

// Group teams by confederation for "All Teams" tab
$qualified_teams = [];
$teams_raw = $pdo->query("SELECT name, confederation FROM wc_teams ORDER BY confederation, name")->fetchAll();
foreach ($teams_raw as $t) {
    $qualified_teams[$t['confederation']][] = $t['name'];
}

// History & Facts
$past_winners = $pdo->query("SELECT * FROM wc_history ORDER BY year DESC")->fetchAll();
$all_time_titles = [];
if (!empty($past_winners)) {
    foreach ($past_winners as $w) {
        if (!isset($all_time_titles[$w['winner']])) $all_time_titles[$w['winner']] = 0;
        $all_time_titles[$w['winner']]++;
    }
}

$key_facts = $pdo->query("SELECT fact_text FROM wc_facts")->fetchAll(PDO::FETCH_COLUMN);

// Polls
$poll = $pdo->query("SELECT * FROM wc_polls WHERE is_active = 1 LIMIT 1")->fetch();
$poll_options = [];
if ($poll) {
    $poll_options = $pdo->prepare("SELECT * FROM wc_poll_options WHERE poll_id = ?");
    $poll_options->execute([$poll['id']]);
    $poll_options = $poll_options->fetchAll();
}
?>
