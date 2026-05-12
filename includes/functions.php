<?php
/**
 * SportingRank.com - Core Functions
 * Location: /home/pqrzcimfem/sportingrank.com/includes/functions.php
 *
 * __DIR__ = /home/pqrzcimfem/sportingrank.com/includes
 *
 * db.php   = __DIR__ . '/db.php'           → includes/db.php  ✓
 *   db.php does: require_once __DIR__ . '/../config.php'
 *              → sportingrank.com/config.php  ✓
 *   db.php creates global $pdo (no get_pdo() function)
 *
 * lang.php = __DIR__ . '/lang.php'         → includes/lang.php ✓
 *   lang.php uses global $pdo directly
 *
 * lang_switcher.php is at ROOT, so header.php references it as:
 *   __DIR__ . '/../lang_switcher.php'
 */

require_once __DIR__ . '/db.php';    // creates global $pdo
require_once __DIR__ . '/lang.php';  // uses global $pdo

// SITE_URL is already defined in config.php — don't redefine
if (!defined('SITE_URL')) {
    define('SITE_URL', 'https://www.sportingrank.com');
}

// ---------------------------------------------------------------------------
// SECURITY HELPERS
// ---------------------------------------------------------------------------

function e(?string $string): string {
    return htmlspecialchars($string ?? '', ENT_QUOTES, 'UTF-8');
}

// ---------------------------------------------------------------------------
// SITE SETTINGS  — uses global $pdo
// ---------------------------------------------------------------------------

function get_all_settings(): array {
    global $pdo;
    try {
        $stmt = $pdo->query('SELECT setting_key, setting_value FROM site_settings');
        $rows = $stmt->fetchAll();
        return array_column($rows, 'setting_value', 'setting_key');
    } catch (PDOException $e) {
        error_log('get_all_settings() error: ' . $e->getMessage());
        return [];
    }
}

function get_setting(string $key, string $default = ''): string {
    global $pdo;
    try {
        $stmt = $pdo->prepare(
            'SELECT setting_value FROM site_settings WHERE setting_key = ? LIMIT 1'
        );
        $stmt->execute([$key]);
        $row = $stmt->fetch();
        return $row ? (string)$row['setting_value'] : $default;
    } catch (PDOException $e) {
        error_log('get_setting() error: ' . $e->getMessage());
        return $default;
    }
}

// ---------------------------------------------------------------------------
// SPORTS
// ---------------------------------------------------------------------------

function get_active_sports(): array {
    global $pdo;
    static $cache = null;
    if ($cache !== null) return $cache;
    try {
        $stmt  = $pdo->query('SELECT * FROM sports WHERE is_active = 1 ORDER BY sort_order ASC');
        $cache = $stmt->fetchAll();
    } catch (PDOException $e) {
        error_log('get_active_sports() error: ' . $e->getMessage());
        $cache = [];
    }
    return $cache;
}

// ---------------------------------------------------------------------------
// TEAMS
// ---------------------------------------------------------------------------

function get_top_teams(int $sport_id, int $limit = 10, string $type = 'national'): array {
    global $pdo;
    $allowed_types = ['national', 'club'];
    if (!in_array($type, $allowed_types, true)) {
        error_log("get_top_teams(): invalid type '{$type}'");
        return [];
    }
    $limit = max(1, min(100, (int)$limit));
    try {
        $sql  = "SELECT * FROM teams
                  WHERE sport_id  = :sport_id
                    AND team_type = :type
                    AND is_active = 1
                  ORDER BY points DESC, wins DESC
                  LIMIT {$limit}";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':sport_id', $sport_id, PDO::PARAM_INT);
        $stmt->bindValue(':type',     $type,     PDO::PARAM_STR);
        $stmt->execute();
        $teams = $stmt->fetchAll();
        foreach ($teams as $i => &$team) {
            $team['rank_position'] = $i + 1;
        }
        return $teams;
    } catch (PDOException $e) {
        error_log("get_top_teams(sport={$sport_id}, type={$type}) error: " . $e->getMessage());
        return [];
    }
}

// ---------------------------------------------------------------------------
// VISUAL HELPERS
// ---------------------------------------------------------------------------

function format_trend(string $trend): string {
    switch (strtolower(trim($trend))) {
        case 'up':
            return '<span style="color:#22c55e;font-size:14px;font-weight:900;" aria-label="Trending up">▲</span>';
        case 'down':
            return '<span style="color:#ef4444;font-size:14px;font-weight:900;" aria-label="Trending down">▼</span>';
        default:
            return '<span style="color:#6b7280;font-size:14px;" aria-label="Stable">—</span>';
    }
}

function medal_classes(int $rank): string {
    return match($rank) {
        1       => 'bg-[#FFD700] text-primary',
        2       => 'bg-[#C0C0C0] text-primary',
        3       => 'bg-[#CD7F32] text-primary',
        default => 'bg-[#1e1e38] text-muted',
    };
}

// ---------------------------------------------------------------------------
// TEAM ROW RENDERING
// ---------------------------------------------------------------------------

function render_team_row(array $team): string {

    $rank        = (int)($team['rank_position'] ?? 0);
    $medal       = medal_classes($rank);
    $safe_name   = e($team['team_name']         ?? 'Unknown');
    $flag        = e(strtolower($team['country_code'] ?? 'un'));
    $team_id     = (int)($team['id']            ?? 0);
    $matches_played = (int)($team['matches_played'] ?? 0);
    $wins        = (int)($team['wins']          ?? 0);
    $losses      = (int)($team['losses']        ?? 0);
    $draws       = (int)($team['draws']         ?? 0);
    $pts         = (float)($team['points']      ?? 0);
    $pts_fmt     = number_format($pts, 0);
    $achievement = trim((string)($team['notable_achievement'] ?? ''));
    $js_name     = json_encode($team['team_name'] ?? '');
    $trend_html  = format_trend($team['trend']  ?? 'stable');

    $lbl_pts  = t('label.pts',    'pts');
    $lbl_vote = t('label.vote',   'Vote');
    $lbl_w    = t('label.wins',   'W');
    $lbl_l    = t('label.losses', 'L');
    $lbl_d    = t('label.draws',  'D');

    $achievement_html = !empty($achievement)
        ? '<span class="text-[8px] text-accent font-bold uppercase tracking-wider opacity-80 truncate hidden sm:block">'
          . e($achievement) . '</span>'
        : '';

    $lbl_gp   = t('label.gp',     'GP');

    return "
    <div class=\"team-row border-b border-white/5 hover:bg-white/[0.03] transition-all duration-200 px-3 py-2 lg:px-6 lg:py-3 rounded-xl\">

        <!-- DESKTOP ROW (lg+) -->
        <div class=\"hidden lg:grid grid-cols-[50px_1fr_50px_50px_50px_50px_90px_110px] items-center\">
            <div class=\"flex justify-center\">
                <span class=\"w-7 h-7 flex items-center justify-center rounded-full text-[11px] font-black {$medal}\">{$rank}</span>
            </div>
            <div class=\"flex items-center gap-3 min-w-0 pr-4\">
                <img src=\"https://flagcdn.com/w40/{$flag}.png\" alt=\"{$safe_name} flag\"
                     onerror=\"this.src='/assets/img/default-flag.png'\"
                     loading=\"lazy\"
                     class=\"w-7 h-5 object-cover rounded-sm shadow-sm flex-shrink-0\">
                <div class=\"flex flex-col min-w-0\">
                    <span class=\"font-bold text-[14px] text-white leading-tight truncate\">{$safe_name}</span>
                    {$achievement_html}
                </div>
            </div>
            <div class=\"text-center\">
                <p class=\"text-[7px] text-muted font-bold uppercase mb-0.5\">{$lbl_gp}</p>
                <p class=\"text-[12px] font-black text-muted\">{$matches_played}</p>
            </div>
            <div class=\"text-center\">
                <p class=\"text-[7px] text-muted font-bold uppercase mb-0.5\">{$lbl_w}</p>
                <p class=\"text-[12px] font-black text-green-400\">{$wins}</p>
            </div>
            <div class=\"text-center\">
                <p class=\"text-[7px] text-muted font-bold uppercase mb-0.5\">{$lbl_l}</p>
                <p class=\"text-[12px] font-black text-red-400\">{$losses}</p>
            </div>
            <div class=\"text-center\">
                <p class=\"text-[7px] text-muted font-bold uppercase mb-0.5\">{$lbl_d}</p>
                <p class=\"text-[12px] font-black text-white\">{$draws}</p>
            </div>
            <div class=\"text-center\">
                <span class=\"font-black text-accent italic text-[14px]\">
                    <span class=\"points-counter\" data-target=\"{$pts}\">{$pts_fmt}</span>
                    <span class=\"text-[8px] lowercase ml-0.5 not-italic opacity-70\">{$lbl_pts}</span>
                </span>
            </div>
            <div class=\"flex items-center justify-end gap-2\">
                {$trend_html}
                <button onclick=\"voteForTeam({$team_id}, {$js_name})\"
                        class=\"vote-btn border border-white/10 hover:bg-accent hover:text-primary
                               transition-all text-[8px] font-black uppercase px-3 py-1.5 rounded-lg\">
                    {$lbl_vote}
                </button>
            </div>
        </div>

        <!-- MOBILE ROW (<lg) -->
        <div class=\"grid lg:hidden grid-cols-[40px_1fr_auto] items-center gap-x-2\">
            <div class=\"flex justify-center flex-shrink-0\">
                <span class=\"w-7 h-7 flex items-center justify-center rounded-full text-[11px] font-black {$medal}\">{$rank}</span>
            </div>
            <div class=\"flex flex-col min-w-0\">
                <div class=\"flex items-center gap-2 min-w-0\">
                    <img src=\"https://flagcdn.com/w40/{$flag}.png\" alt=\"{$safe_name} flag\"
                         onerror=\"this.src='/assets/img/default-flag.png'\"
                         loading=\"lazy\"
                         class=\"w-6 h-4 object-cover rounded-sm shadow-sm flex-shrink-0\">
                    <span class=\"font-bold text-[13px] text-white leading-tight truncate\">{$safe_name}</span>
                </div>
                <div class=\"flex items-center gap-2 mt-1\">
                    <span class=\"text-[10px] font-black text-green-400\">{$lbl_w}<span class=\"ml-0.5\">{$wins}</span></span>
                    <span class=\"text-white/20 text-[8px]\">·</span>
                    <span class=\"text-[10px] font-black text-red-400\">{$lbl_l}<span class=\"ml-0.5\">{$losses}</span></span>
                    <span class=\"text-white/20 text-[8px]\">·</span>
                    <span class=\"text-[10px] font-black text-white/70\">{$lbl_d}<span class=\"ml-0.5\">{$draws}</span></span>
                </div>
            </div>
            <div class=\"flex flex-col items-end gap-1 flex-shrink-0\">
                <span class=\"font-black text-accent italic text-[13px] leading-none\">
                    <span class=\"points-counter\" data-target=\"{$pts}\">{$pts_fmt}</span>
                    <span class=\"text-[8px] lowercase ml-0.5 not-italic opacity-70\">{$lbl_pts}</span>
                </span>
                <div class=\"flex items-center gap-1.5\">
                    {$trend_html}
                    <button onclick=\"voteForTeam({$team_id}, {$js_name})\"
                            class=\"vote-btn border border-white/10 hover:bg-accent hover:text-primary
                                   transition-all text-[8px] font-black uppercase px-2 py-1 rounded-lg\">
                        {$lbl_vote}
                    </button>
                </div>
            </div>
        </div>

    </div>";
}
?>
