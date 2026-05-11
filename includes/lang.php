<?php
/**
 * SportingRank.com — Language Engine
 * Location: /home/pqrzcimfem/sportingrank.com/includes/lang.php
 *
 * db.php creates $pdo as a global variable (no get_pdo() function).
 * This file uses $pdo directly via the global keyword.
 * config.php is already loaded by db.php before this runs.
 */

// ---------------------------------------------------------------------------
// SUPPORTED LANGUAGES
// ---------------------------------------------------------------------------
const SUPPORTED_LANGS = ['en', 'ar', 'fr', 'es', 'pt', 'de', 'zh', 'hi'];
const DEFAULT_LANG    = 'en';
const LANG_COOKIE     = 'sr_lang';
const LANG_COOKIE_TTL = 60 * 60 * 24 * 365;

// ---------------------------------------------------------------------------
// 1. DETECT LANGUAGE
// ---------------------------------------------------------------------------
function detect_language(): string {

    // A) Explicit ?lang= — set cookie and redirect
    if (!empty($_GET['lang'])) {
        $requested = strtolower(trim($_GET['lang']));
        if (in_array($requested, SUPPORTED_LANGS, true)) {
            setcookie(LANG_COOKIE, $requested, [
                'expires'  => time() + LANG_COOKIE_TTL,
                'path'     => '/',
                'samesite' => 'Lax',
                'secure'   => isset($_SERVER['HTTPS']),
            ]);
            $url = strtok($_SERVER['REQUEST_URI'], '?');
            $qs  = $_GET;
            unset($qs['lang']);
            if (!empty($qs)) $url .= '?' . http_build_query($qs);
            header('Location: ' . $url, true, 302);
            exit;
        }
    }

    // B) Cookie
    if (!empty($_COOKIE[LANG_COOKIE])) {
        $c = strtolower(trim($_COOKIE[LANG_COOKIE]));
        if (in_array($c, SUPPORTED_LANGS, true)) return $c;
    }

    // C) Browser Accept-Language
    $accept = $_SERVER['HTTP_ACCEPT_LANGUAGE'] ?? '';
    if ($accept) {
        foreach (explode(',', $accept) as $part) {
            $tag  = strtolower(trim(explode(';', $part)[0]));
            $base = explode('-', $tag)[0];
            if (in_array($tag,  SUPPORTED_LANGS, true)) return $tag;
            if (in_array($base, SUPPORTED_LANGS, true)) return $base;
        }
    }

    return DEFAULT_LANG;
}

// ---------------------------------------------------------------------------
// 2. HARDCODED FALLBACKS (used when DB tables don't exist yet)
// ---------------------------------------------------------------------------
function _lang_defaults(): array {
    return [
        'en' => ['code'=>'en','name'=>'English',   'flag'=>'🇬🇧','is_rtl'=>false],
        'ar' => ['code'=>'ar','name'=>'العربية',   'flag'=>'🇸🇦','is_rtl'=>true ],
        'fr' => ['code'=>'fr','name'=>'Français',  'flag'=>'🇫🇷','is_rtl'=>false],
        'es' => ['code'=>'es','name'=>'Español',   'flag'=>'🇪🇸','is_rtl'=>false],
        'pt' => ['code'=>'pt','name'=>'Português', 'flag'=>'🇧🇷','is_rtl'=>false],
        'de' => ['code'=>'de','name'=>'Deutsch',   'flag'=>'🇩🇪','is_rtl'=>false],
        'zh' => ['code'=>'zh','name'=>'中文',       'flag'=>'🇨🇳','is_rtl'=>false],
        'hi' => ['code'=>'hi','name'=>'हिन्दी',    'flag'=>'🇮🇳','is_rtl'=>false],
    ];
}

// ---------------------------------------------------------------------------
// 3. LOAD TRANSLATIONS — uses global $pdo directly
// ---------------------------------------------------------------------------
function load_translations(string $lang): array {
    static $cache = [];
    if (isset($cache[$lang])) return $cache[$lang];

    global $pdo;
    $result = [];

    try {
        $codes = ($lang === DEFAULT_LANG) ? [DEFAULT_LANG] : [DEFAULT_LANG, $lang];
        $in    = implode(',', array_fill(0, count($codes), '?'));
        $stmt  = $pdo->prepare(
            "SELECT lang_code, tkey, tvalue FROM translations
              WHERE lang_code IN ({$in}) ORDER BY lang_code ASC"
        );
        $stmt->execute($codes);

        $base = [];
        foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row) {
            if ($row['lang_code'] === DEFAULT_LANG) {
                $base[$row['tkey']] = $row['tvalue'];
            } else {
                $result[$row['tkey']] = $row['tvalue'];
            }
        }
        $cache[$lang] = array_merge($base, $result);
    } catch (Exception $e) {
        // translations table may not exist yet — degrade silently
        error_log('load_translations() error: ' . $e->getMessage());
        $cache[$lang] = [];
    }

    return $cache[$lang];
}

// ---------------------------------------------------------------------------
// 4. LANG META — uses global $pdo directly
// ---------------------------------------------------------------------------
function _load_lang_meta(string $lang): array {
    static $cache = [];
    if (isset($cache[$lang])) return $cache[$lang];

    global $pdo;
    $defaults = _lang_defaults();

    try {
        $stmt = $pdo->prepare(
            'SELECT code, name, flag, is_rtl FROM languages
              WHERE code = ? AND is_active = 1 LIMIT 1'
        );
        $stmt->execute([$lang]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            $cache[$lang] = [
                'code'   => $row['code'],
                'name'   => $row['name'],
                'flag'   => $row['flag'],
                'is_rtl' => (bool)$row['is_rtl'],
            ];
            return $cache[$lang];
        }
    } catch (Exception $e) {
        error_log('_load_lang_meta() error: ' . $e->getMessage());
    }

    $cache[$lang] = $defaults[$lang] ?? $defaults[DEFAULT_LANG];
    return $cache[$lang];
}

// ---------------------------------------------------------------------------
// 5. BOOTSTRAP — runs once per request
// ---------------------------------------------------------------------------
if (!isset($GLOBALS['_sr_lang'])) {
    $GLOBALS['_sr_lang']      = detect_language();
    $GLOBALS['_sr_trans']     = load_translations($GLOBALS['_sr_lang']);
    $GLOBALS['_sr_lang_meta'] = _load_lang_meta($GLOBALS['_sr_lang']);
}

// ---------------------------------------------------------------------------
// 6. PUBLIC API
// ---------------------------------------------------------------------------

function t(string $key, string $fallback = ''): string {
    $val = $GLOBALS['_sr_trans'][$key] ?? $fallback;
    if ($val === '') $val = $key;
    return htmlspecialchars($val, ENT_QUOTES, 'UTF-8');
}

function t_raw(string $key, string $fallback = ''): string {
    return $GLOBALS['_sr_trans'][$key] ?? ($fallback ?: $key);
}

function current_lang(): string {
    return $GLOBALS['_sr_lang'];
}

function lang_meta(): array {
    return $GLOBALS['_sr_lang_meta'];
}

function get_languages(): array {
    static $langs = null;
    if ($langs !== null) return $langs;

    global $pdo;
    $fallback = array_values(_lang_defaults());

    try {
        $stmt = $pdo->query(
            'SELECT code, name, flag, is_rtl FROM languages
              WHERE is_active = 1 ORDER BY sort_order ASC'
        );
        $rows  = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $langs = $rows ?: $fallback;
    } catch (Exception $e) {
        error_log('get_languages() error: ' . $e->getMessage());
        $langs = $fallback;
    }

    return $langs;
}
