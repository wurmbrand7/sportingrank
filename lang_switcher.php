<?php
/**
 * SportingRank.com — Language Switcher Component
 * Location: /home/pqrzcimfem/sportingrank.com/includes/lang_switcher.php
 *
 * Include this inside your header nav bar:
 *   require_once __DIR__ . '/lang_switcher.php';
 *
 * When a flag is clicked it appends ?lang=XX to the current URL,
 * which lang.php intercepts, sets the cookie, and redirects back cleanly.
 */

$_sw_current   = current_lang();
$_sw_meta      = lang_meta();
$_sw_languages = get_languages();
?>

<div class="lang-switcher relative" id="lang-switcher">

    <!-- Trigger button -->
    <button type="button"
            onclick="toggleLangMenu()"
            aria-haspopup="true"
            aria-expanded="false"
            aria-label="Select language"
            id="lang-switcher-btn"
            class="flex items-center gap-2
                   bg-card border border-white/10
                   hover:border-accent hover:bg-accent/10
                   transition-all rounded-full
                   px-3 py-1.5 text-[11px] font-black uppercase tracking-widest
                   text-white/80 hover:text-white
                   select-none cursor-pointer">
        <span class="text-base leading-none"><?php echo $_sw_meta['flag']; ?></span>
        <span class="hidden sm:inline"><?php echo htmlspecialchars($_sw_meta['code'], ENT_QUOTES, 'UTF-8'); ?></span>
        <svg class="w-3 h-3 opacity-50 transition-transform duration-200" id="lang-chevron"
             xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd"
                  d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z"
                  clip-rule="evenodd"/>
        </svg>
    </button>

    <!-- Dropdown -->
    <div id="lang-menu"
         class="hidden absolute <?php echo $_sw_meta['is_rtl'] ? 'left-0' : 'right-0'; ?> top-full mt-2 z-[200]
                bg-[#141428] border border-white/10 rounded-2xl shadow-2xl
                overflow-hidden min-w-[160px]"
         role="menu">

        <?php foreach ($_sw_languages as $lang): ?>
            <?php
                $is_active = ($lang['code'] === $_sw_current);
                // Build switch URL: current page + ?lang=XX
                $switch_url = strtok($_SERVER['REQUEST_URI'], '?');
                $qs = $_GET;
                unset($qs['lang']);
                $qs['lang'] = $lang['code'];
                $switch_url .= '?' . http_build_query($qs);
            ?>
            <a href="<?php echo htmlspecialchars($switch_url, ENT_QUOTES, 'UTF-8'); ?>"
               role="menuitem"
               class="flex items-center gap-3 px-4 py-2.5 text-[12px] font-bold
                      transition-colors duration-150
                      <?php echo $is_active
                          ? 'bg-accent/20 text-accent'
                          : 'text-white/70 hover:bg-white/5 hover:text-white'; ?>">
                <span class="text-base leading-none flex-shrink-0"><?php echo $lang['flag']; ?></span>
                <span class="flex-1"><?php echo htmlspecialchars($lang['name'], ENT_QUOTES, 'UTF-8'); ?></span>
                <?php if ($is_active): ?>
                    <svg class="w-3.5 h-3.5 text-accent flex-shrink-0" xmlns="http://www.w3.org/2000/svg"
                         viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd"
                              d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z"
                              clip-rule="evenodd"/>
                    </svg>
                <?php endif; ?>
            </a>
        <?php endforeach; ?>
    </div>
</div>

<script>
// Scoped to lang switcher — no global pollution
(function () {
    function toggleLangMenu() {
        const menu    = document.getElementById('lang-menu');
        const btn     = document.getElementById('lang-switcher-btn');
        const chevron = document.getElementById('lang-chevron');
        const open    = !menu.classList.contains('hidden');

        menu.classList.toggle('hidden', open);
        btn.setAttribute('aria-expanded', String(!open));
        chevron.style.transform = open ? '' : 'rotate(180deg)';
    }

    // Close on outside click
    document.addEventListener('click', function (e) {
        const switcher = document.getElementById('lang-switcher');
        if (switcher && !switcher.contains(e.target)) {
            const menu    = document.getElementById('lang-menu');
            const btn     = document.getElementById('lang-switcher-btn');
            const chevron = document.getElementById('lang-chevron');
            if (menu) menu.classList.add('hidden');
            if (btn)  btn.setAttribute('aria-expanded', 'false');
            if (chevron) chevron.style.transform = '';
        }
    });

    // Expose to inline onclick
    window.toggleLangMenu = toggleLangMenu;
})();
</script>
