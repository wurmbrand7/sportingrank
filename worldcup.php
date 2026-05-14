<?php
/**
 * SportingRank.com - Football World Cup 2026 Page
 */
require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/worldcup2026.php';
?>

<div class="min-h-screen"
     style="background-image: linear-gradient(rgba(10,10,26,0.85), rgba(10,10,26,0.95)), url('https://images.unsplash.com/photo-1508098682722-e99c643e7f0b?q=80&w=2000');
            background-size: cover; background-position: center; background-attachment: fixed;">

    <!-- HERO BANNER -->
    <div class="border-b border-white/5 py-14">
        <div class="container mx-auto px-4 text-center">
            <p class="text-[10px] font-black uppercase tracking-[0.4em] text-accent mb-3">
                ⚽ <?php echo $worldcup_2026['dates']; ?>
            </p>
            <h1 class="text-5xl md:text-7xl font-heading font-black uppercase italic tracking-tighter text-white leading-none mb-4">
                Football<br>World Cup 2026
            </h1>
            <p class="text-muted text-sm font-bold uppercase tracking-widest mb-6">
                <?php echo implode(' &nbsp;·&nbsp; ', $worldcup_2026['host_nations']); ?>
            </p>
            <!-- Key stats bar -->
            <div class="inline-flex flex-wrap justify-center gap-6 mt-4">
                <?php
                $stats = [
                    ['label' => 'Teams',   'value' => $worldcup_2026['total_teams']],
                    ['label' => 'Matches', 'value' => $worldcup_2026['total_matches']],
                    ['label' => 'Groups',  'value' => $worldcup_2026['total_groups']],
                    ['label' => 'Venues',  'value' => count($stadiums)],
                    ['label' => 'Days',    'value' => 39],
                ];
                foreach ($stats as $stat): ?>
                    <div class="bg-[#141428]/80 border border-white/10 rounded-xl px-6 py-3 text-center">
                        <div class="text-3xl font-black text-accent"><?php echo $stat['value']; ?></div>
                        <div class="text-[9px] font-black uppercase tracking-widest text-muted mt-1"><?php echo $stat['label']; ?></div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <!-- TAB NAVIGATION -->
    <div class="bg-[#0a0a1a] border-b border-white/5 sticky top-[72px] z-50">
        <div class="container mx-auto px-4">
            <div class="flex items-center space-x-1 overflow-x-auto no-scrollbar py-3">
                <?php
                $tabs = [
                    ['id' => 'groups',   'label' => '🏆 Groups'],
                    ['id' => 'stadiums', 'label' => '🏟️ Stadiums'],
                    ['id' => 'teams',    'label' => '🌍 All Teams'],
                    ['id' => 'history',  'label' => '📜 Past Winners'],
                    ['id' => 'facts',    'label' => '⚡ Key Facts'],
                    ['id' => 'poll',     'label' => '🗳️ Fan Poll'],
                ];
                foreach ($tabs as $i => $tab): ?>
                    <button onclick="showTab('<?php echo $tab['id']; ?>')"
                            id="tab-btn-<?php echo $tab['id']; ?>"
                            class="wc-tab-btn px-5 py-2 rounded-full font-heading font-black uppercase text-[10px] tracking-widest transition whitespace-nowrap
                                   <?php echo $i === 0 ? 'bg-accent text-primary border border-accent' : 'bg-[#141428] text-muted border border-white/10 hover:border-accent'; ?>">
                        <?php echo $tab['label']; ?>
                    </button>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <!-- CONTENT SECTIONS -->
    <div class="container mx-auto px-4 py-10">

        <!-- GROUPS TAB -->
        <div id="tab-groups" class="wc-tab-content">
            <h2 class="text-2xl font-heading font-black uppercase italic tracking-tighter text-white mb-6">
                All 12 Groups
            </h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
                <?php foreach ($groups as $letter => $group_teams): ?>
                    <div class="bg-[#141428]/90 rounded-2xl border border-white/5 overflow-hidden shadow-xl">
                        <div class="px-5 py-3 border-b border-white/5 flex items-center justify-between">
                            <span class="text-xl font-black text-accent uppercase italic">Group <?php echo $letter; ?></span>
                        </div>
                        <table class="w-full text-xs text-left">
                            <thead class="text-[9px] font-black uppercase text-muted tracking-widest border-b border-white/5">
                                <tr>
                                    <th class="p-3">Team</th>
                                    <th class="p-3 text-center">P</th>
                                    <th class="p-3 text-center">Pts</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($group_teams as $t): ?>
                                    <li class="border-b border-white/5 last:border-0">
                                        <tr class="border-b border-white/5 last:border-0 hover:bg-white/5 transition">
                                            <td class="p-3 font-bold text-white"><?php echo htmlspecialchars($t['name']); ?></td>
                                            <td class="p-3 text-center text-muted"><?php echo $t['matches_played']; ?></td>
                                            <td class="p-3 text-center font-black text-accent"><?php echo $t['points']; ?></td>
                                        </tr>
                                    </li>
                                <?php endforeach; ?>
                                <?php if (empty($group_teams)): ?>
                                    <tr><td colspan="3" class="p-4 text-center text-muted italic">Teams TBA</td></tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- Opening & Final info -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-8">
                <div class="bg-[#141428]/90 rounded-2xl border border-accent/30 p-6">
                    <p class="text-[9px] font-black uppercase tracking-widest text-accent mb-2">Opening Match</p>
                    <p class="text-lg font-black text-white"><?php echo htmlspecialchars($worldcup_2026['opening_match']); ?></p>
                </div>
                <div class="bg-[#141428]/90 rounded-2xl border border-white/10 p-6">
                    <p class="text-[9px] font-black uppercase tracking-widest text-accent mb-2">The Final</p>
                    <p class="text-lg font-black text-white"><?php echo htmlspecialchars($worldcup_2026['final']); ?></p>
                </div>
            </div>
        </div>

        <!-- STADIUMS TAB -->
        <div id="tab-stadiums" class="wc-tab-content hidden">
            <h2 class="text-2xl font-heading font-black uppercase italic tracking-tighter text-white mb-6">
                16 Host Stadiums
            </h2>

            <?php
            $host_countries = ['USA', 'Mexico', 'Canada'];
            $country_flags = ['USA' => '🇺🇸', 'Mexico' => '🇲🇽', 'Canada' => '🇨🇦'];
            foreach ($host_countries as $country):
                $country_stadiums = getStadiumsByCountry($country);
            ?>
                <h3 class="text-[10px] font-black uppercase tracking-widest text-muted mb-3 mt-6 flex items-center gap-2">
                    <span><?php echo $country_flags[$country] ?? '🌐'; ?></span>
                    <span><?php echo $country; ?> — <?php echo count($country_stadiums); ?> Venue<?php echo count($country_stadiums) > 1 ? 's' : ''; ?></span>
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4 mb-4">
                    <?php foreach ($country_stadiums as $s): ?>
                        <div class="bg-[#141428]/90 rounded-2xl border border-white/5 p-5 hover:border-accent/30 transition shadow-xl">
                            <div class="flex items-start justify-between gap-2 mb-3">
                                <h4 class="text-base font-black text-white leading-tight"><?php echo htmlspecialchars($s['name']); ?></h4>
                                <span class="text-[9px] font-black text-accent bg-accent/10 border border-accent/20 px-2 py-1 rounded-md whitespace-nowrap">
                                    <?php echo number_format($s['capacity']); ?>
                                </span>
                            </div>
                            <p class="text-[10px] font-bold text-muted uppercase tracking-wider mb-2">
                                📍 <?php echo htmlspecialchars($s['city']); ?>
                            </p>
                            <p class="text-xs text-white/60"><?php echo htmlspecialchars($s['note']); ?></p>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- TEAMS TAB -->
        <div id="tab-teams" class="wc-tab-content hidden">
            <h2 class="text-2xl font-heading font-black uppercase italic tracking-tighter text-white mb-6">
                All Qualified Teams
            </h2>
            <?php if (empty($qualified_teams)): ?>
                <div class="admin-card p-12 text-center">
                    <div class="text-4xl mb-4">🌍</div>
                    <p class="text-muted italic">Qualifiers are currently in progress. Check back soon for the final list of 48 teams.</p>
                </div>
            <?php else: ?>
                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-5">
                    <?php foreach ($qualified_teams as $conf => $q_teams): ?>
                        <div class="bg-[#141428]/90 rounded-2xl border border-white/5 overflow-hidden shadow-xl">
                            <div class="px-5 py-3 border-b border-white/5 flex items-center justify-between">
                                <span class="text-[11px] font-black uppercase tracking-wider text-white"><?php echo htmlspecialchars($conf); ?></span>
                                <span class="text-[9px] font-black text-accent"><?php echo count($q_teams); ?> teams</span>
                            </div>
                            <div class="p-4 flex flex-wrap gap-2">
                                <?php foreach ($q_teams as $t_name): ?>
                                    <span class="text-[10px] font-bold text-white/80 bg-white/5 border border-white/10 px-3 py-1.5 rounded-full hover:border-accent/40 transition">
                                        <?php echo htmlspecialchars($t_name); ?>
                                    </span>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>

        <!-- HISTORY TAB -->
        <div id="tab-history" class="wc-tab-content hidden">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <div class="lg:col-span-2">
                    <h2 class="text-2xl font-heading font-black uppercase italic tracking-tighter text-white mb-6">
                        Past Winners (1930 – 2022)
                    </h2>
                    <div class="bg-[#141428]/90 rounded-2xl border border-white/5 overflow-hidden shadow-xl">
                        <div class="grid grid-cols-[60px_1fr_1fr_1fr] px-5 py-3 border-b border-white/5
                                    text-[9px] font-black text-muted uppercase tracking-widest">
                            <div>Year</div>
                            <div>Winner</div>
                            <div>Runner-Up</div>
                            <div>Host</div>
                        </div>
                        <?php foreach ($past_winners as $i => $w): ?>
                            <div class="grid grid-cols-[60px_1fr_1fr_1fr] px-5 py-3 border-b border-white/5
                                        hover:bg-white/5 transition
                                        <?php echo $i === 0 ? 'bg-accent/5 border-accent/20' : ''; ?>">
                                <div class="text-sm font-black <?php echo $i === 0 ? 'text-accent' : 'text-white/60'; ?>">
                                    <?php echo $w['year']; ?>
                                </div>
                                <div class="text-sm font-bold text-white"><?php echo htmlspecialchars($w['winner']); ?></div>
                                <div class="text-sm text-white/60"><?php echo htmlspecialchars($w['runner_up']); ?></div>
                                <div class="text-sm text-white/40"><?php echo htmlspecialchars($w['host']); ?></div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <div>
                    <h2 class="text-2xl font-heading font-black uppercase italic tracking-tighter text-white mb-6">
                        All-Time Titles
                    </h2>
                    <div class="bg-[#141428]/90 rounded-2xl border border-white/5 overflow-hidden shadow-xl">
                        <?php arsort($all_time_titles); foreach ($all_time_titles as $nation => $titles): ?>
                            <div class="flex items-center justify-between px-5 py-4 border-b border-white/5 hover:bg-white/5 transition">
                                <span class="text-sm font-bold text-white"><?php echo htmlspecialchars($nation); ?></span>
                                <div class="flex items-center gap-1">
                                    <span class="text-accent font-black text-sm"><?php echo $titles; ?> 🏆</span>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- FACTS TAB -->
        <div id="tab-facts" class="wc-tab-content hidden">
            <h2 class="text-2xl font-heading font-black uppercase italic tracking-tighter text-white mb-6">
                Key Facts — World Cup 2026
            </h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <?php foreach ($key_facts as $i => $fact): ?>
                    <div class="bg-[#141428]/90 rounded-2xl border border-white/5 p-5 flex items-start gap-4 hover:border-accent/30 transition">
                        <span class="text-accent font-black text-lg leading-none mt-0.5"><?php echo str_pad($i + 1, 2, '0', STR_PAD_LEFT); ?></span>
                        <p class="text-sm text-white/80 font-medium leading-relaxed"><?php echo htmlspecialchars($fact); ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- POLL TAB -->
        <div id="tab-poll" class="wc-tab-content hidden">
            <h2 class="text-2xl font-heading font-black uppercase italic tracking-tighter text-white mb-6">
                Fan Opinion
            </h2>
            <?php if ($poll): ?>
                <div class="admin-card p-8 max-w-xl mx-auto text-center">
                    <h3 class="text-2xl font-black italic uppercase mb-6"><?php echo htmlspecialchars($poll['question']); ?></h3>
                    <div class="space-y-3">
                        <?php foreach ($poll_options as $opt): ?>
                            <button onclick="voteWC(<?php echo $opt['id']; ?>)" class="w-full bg-[#0a0a1a] hover:bg-accent hover:text-primary border border-white/10 rounded-xl p-4 font-bold transition flex justify-between items-center group">
                                <span><?php echo htmlspecialchars($opt['option_text']); ?></span>
                                <span class="text-accent group-hover:text-primary"><?php echo $opt['votes']; ?> votes</span>
                            </button>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php else: ?>
                <p class="text-center text-muted italic">No active polls at the moment.</p>
            <?php endif; ?>
        </div>

    </div>
</div>

<script>
function showTab(id) {
    document.querySelectorAll('.wc-tab-content').forEach(el => el.classList.add('hidden'));
    document.querySelectorAll('.wc-tab-btn').forEach(btn => {
        btn.classList.remove('bg-accent', 'text-primary', 'border-accent');
        btn.classList.add('bg-[#141428]', 'text-muted', 'border-white/10');
    });
    document.getElementById('tab-' + id).classList.remove('hidden');
    const activeBtn = document.getElementById('tab-btn-' + id);
    activeBtn.classList.add('bg-accent', 'text-primary', 'border-accent');
    activeBtn.classList.remove('bg-[#141428]', 'text-muted', 'border-white/10');
}

function voteWC(optionId) {
    // Simple alert for now as AJAX endpoint for WC poll isn't built yet
    alert("Thanks for your vote! (Voting system for WC poll is coming soon)");
}
</script>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
