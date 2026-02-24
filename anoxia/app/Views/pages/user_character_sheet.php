<!doctype html>
<html lang="pt-PT">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'Character Sheet | Anoxia') ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="apple-touch-icon" sizes="180x180" href="<?= base_url('apple-touch-icon.png') ?>">
    <link rel="icon" type="image/png" sizes="32x32" href="<?= base_url('favicon-32x32.png') ?>">
    <link rel="icon" type="image/png" sizes="16x16" href="<?= base_url('favicon-16x16.png') ?>">
    <link rel="manifest" href="<?= base_url('site.webmanifest') ?>">
    <link href="https://fonts.googleapis.com/css2?family=Alegreya:wght@400;500;700;800&family=Cinzel:wght@500;700;800&family=Cormorant+Garamond:wght@400;500;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.9.1/fonts/remixicon.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('assets/css/app.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/character-sheet.css') ?>">
</head>
<body class="character-sheet-page bg-[#2f1e14] text-[#f4e3c8] font-tavern">
    <div class="fixed inset-0 -z-10 bg-[radial-gradient(circle_at_20%_10%,#70472a_0%,#4b301f_42%,#2a1a12_100%)] pointer-events-none"></div>

    <?php include(APPPATH . 'Views/partials/navbar.php'); ?>

<main class="character-sheet-main">
    <!-- ── Character info header ────────────────────── -->
    <section class="rounded-2xl border border-[#8d643d]/35 bg-[#5a3923]/65 px-2 py-1 overflow-x-auto">
                    <table class="character-info-table">
                        <thead>
                            <tr>
                                <th class="pb-0.5 pr-1 text-[2px] font-semibold uppercase tracking-wide text-[#c4a060] whitespace-nowrap text-left">Name</th>
                                <th class="pb-0.5 pr-1 text-[2px] font-semibold uppercase tracking-wide text-[#c4a060] whitespace-nowrap text-left">Class/Lvl</th>
                                <th class="pb-0.5 pr-1 text-[2px] font-semibold uppercase tracking-wide text-[#c4a060] whitespace-nowrap text-left">Race</th>
                                <th class="pb-0.5 pr-1 text-[2px] font-semibold uppercase tracking-wide text-[#c4a060] whitespace-nowrap text-left">BG</th>
                                <th class="pb-0.5 text-[2px] font-semibold uppercase tracking-wide text-[#c4a060] whitespace-nowrap text-left">Align.</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="pr-1 pb-1"><input type="text" placeholder="Name" class="sheet-input character-info-input character-info-name font-semibold" aria-label="Character name"></td>
                                <td class="pr-1 pb-1"><input type="text" placeholder="Fighter 1" class="sheet-input character-info-input character-info-class" aria-label="Class and level"></td>
                                <td class="pr-1 pb-1"><input type="text" placeholder="Human" class="sheet-input character-info-input character-info-race" aria-label="Race"></td>
                                <td class="pr-1 pb-1"><input type="text" placeholder="Soldier" class="sheet-input character-info-input character-info-bg" aria-label="Background"></td>
                                <td class="pb-1"><input type="text" placeholder="Neutral" class="sheet-input character-info-input character-info-align" aria-label="Alignment"></td>
                            </tr>
                        </tbody>
                    </table>
    </section>

    <!-- Mobile offcanvas -->
    <div id="mobileBackdrop" class="fixed inset-0 z-40 hidden bg-black/60"></div>
    <div id="mobileOffcanvas"
           class="pointer-events-none fixed right-0 top-0 z-50 h-full w-64 translate-x-full border-l border-[#8b633f]/30 bg-[#2b1c13] p-5 transition-transform duration-200 sm:hidden">
        <div class="flex items-center justify-between">
            <span class="inline-flex h-9 w-9 items-center justify-center rounded-full border border-[#9d7550] bg-[#6d4628] text-sm font-semibold">
                <?= esc(strtoupper(substr((string)(session()->get('user_name') ?? 'U'), 0, 1))) ?>
            </span>
            <button type="button" id="mobileMenuClose"
                    class="inline-flex h-8 w-8 items-center justify-center rounded-md border border-[#8e653f] bg-[#6f4929] text-[#f3e2c7]">
                <i class="ri-close-large-line text-base" aria-hidden="true"></i>
            </button>
        </div>
        <div class="mt-6">
            <a href="<?= base_url('auth/logout') ?>"
               class="inline-flex w-full items-center gap-2 rounded-lg border border-[#8e653f] bg-[#6f4929] px-4 py-2 text-sm font-semibold text-[#f3e2c7] transition hover:bg-[#7e5430]">
                <i class="ri-logout-box-r-line" aria-hidden="true"></i> Terminar sessão
            </a>
        </div>
    </div>

    <!-- ══════════════════════════════════════════════════════════════════
         CHARACTER SHEET   –   TWO-COLUMN LAYOUT
    ══════════════════════════════════════════════════════════════════════ -->
    <section class="sheet-wrapper">

        <!-- ────────────────────────────────────────────────────────────
             LEFT COLUMN – "Coluna dos Atributos"  (always visible)
        ──────────────────────────────────────────────────────────────── -->
        <section class="attr-sidebar relative z-30 flex w-[88px] flex-shrink-0 flex-col gap-1.5 overflow-y-auto sheet-scroll bg-[#2b1c13]/60 border-r border-[#8b633f]/30 px-1.5 py-2">

            <!-- Inspiration button -->
            <button type="button"
                    class="w-full rounded-lg border border-[#d4b07a] bg-[#c89b60] py-1.5 text-[9px] font-semibold uppercase tracking-wide text-[#2d1c12] hover:bg-[#dbb780] transition leading-tight">
                Inspiration
            </button>

            <!-- ── Attribute cards ─────────────────────────────────── -->
            <?php
            $attrs = [
                ['STR', 'Strength'],
                ['DEX', 'Dexterity'],
                ['CON', 'Constitution'],
                ['INT', 'Intelligence'],
                ['WIS', 'Wisdom'],
                ['CHA', 'Charisma'],
            ];
            foreach ($attrs as [$abbr, $full]):
            ?>
            <article class="rounded-xl border border-[#8d643d]/35 bg-[#4a2f1d]/80 p-1.5 flex flex-col items-center gap-1">
                <p class="section-title w-full"><?= $abbr ?></p>
                <input type="number" min="1" max="30" placeholder="10"
                       class="attr-value-input"
                       aria-label="<?= $full ?> value">
                <input type="text" placeholder="+0"
                       class="modifier-input"
                       aria-label="<?= $full ?> modifier">
                <p class="section-title section-title-xs w-full"><?= strtoupper($full) ?></p>
            </article>
            <?php endforeach; ?>

            <!-- ── Slider handle ──────────────────────────────────── -->
            <button type="button" id="sliderHandle" data-action="toggle-prof-slider"
                    title="Abrir Proficiências"
                    class="mt-auto w-full rounded-lg border border-[#8e653f] bg-[#6f4929] py-2 text-[#f3e2c7] transition hover:bg-[#7e5430] flex flex-col items-center gap-0.5">
                <i class="handle-icon ri-menu-unfold-line text-base" aria-hidden="true"></i>
                <span class="text-[8px] uppercase tracking-wide leading-none">Prof.</span>
            </button>

        </section><!-- /attr col -->

        <!-- ────────────────────────────────────────────────────────────
             CONTENT WRAPPER  (main + slider overlay)
        ──────────────────────────────────────────────────────────────── -->
        <div class="sheet-content-wrapper relative flex-1">

            <!-- Backdrop – closes slider when tapping outside -->
            <div id="sliderBackdrop"></div>

            <!-- ════════════════════════════════════════════════════════
                 SLIDER OVERLAY – "Proficiências"
            ════════════════════════════════════════════════════════════ -->
                 <aside id="profSlider"
                   class="absolute inset-0 z-20 overflow-y-auto sheet-scroll bg-[#2b1c13] border-r border-[#8b633f]/40 px-3 py-3">

                <!-- Header row -->
                <div class="flex items-center justify-between mb-3">
                    <p class="font-royal text-lg text-[#f3e1c3]">Proficiências</p>
                    <button type="button" data-action="toggle-prof-slider"
                            class="inline-flex h-8 w-8 items-center justify-center rounded-md border border-[#8e653f] bg-[#6f4929] text-[#f3e2c7] hover:bg-[#7e5430] transition">
                        <i class="ri-close-line text-base" aria-hidden="true"></i>
                    </button>
                </div>

                <!-- ── Proficiency Bonus ─────────────────────────── -->
                <div class="rounded-xl border border-[#8d643d]/35 bg-[#4a2f1d]/75 px-3 py-2">
                    <div class="flex items-center gap-2">
                        <input type="text" placeholder="+2" class="sm-input" aria-label="Proficiency bonus">
                        <span class="text-xs font-semibold tracking-wide text-[#dfc49d]">Proficiency Bonus</span>
                    </div>
                </div>

                <!-- ── Saving Throws ────────────────────────────── -->
                <div class="rounded-xl border border-[#8d643d]/35 bg-[#4a2f1d]/75 px-3 py-2 mb-3">
                    <p class="mb-2 text-[10px] font-semibold uppercase tracking-[0.14em] text-[#c4a060]">Saving Throws</p>
                    <div class="flex flex-col gap-1.5">
                        <?php
                        $saves = ['Strength', 'Dexterity', 'Constitution', 'Intelligence', 'Wisdom', 'Charisma'];
                        foreach ($saves as $save):
                        ?>
                        <div class="flex items-center gap-2">
                            <button type="button" class="toggle-circ" aria-label="<?= $save ?> saving throw proficiency"></button>
                            <input type="text" placeholder="+0" class="sm-input" aria-label="<?= $save ?> saving throw bonus">
                            <span class="text-xs text-[#e2c8a3]"><?= $save ?></span>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- ── Skills ───────────────────────────────────── -->
                <div class="rounded-xl border border-[#8d643d]/35 bg-[#4a2f1d]/75 px-3 py-2 mb-3">
                    <p class="mb-2 text-[10px] font-semibold uppercase tracking-[0.14em] text-[#c4a060]">Skills</p>
                    <div class="flex flex-col gap-1.5">
                        <?php
                        $skills = [
                            ['Acrobatics', 'Dex'],
                            ['Animal Handling', 'Wis'],
                            ['Arcana', 'Int'],
                            ['Athletics', 'Str'],
                            ['Deception', 'Cha'],
                            ['History', 'Int'],
                            ['Insight', 'Wis'],
                            ['Intimidation', 'Cha'],
                            ['Investigation', 'Int'],
                            ['Medicine', 'Wis'],
                            ['Nature', 'Int'],
                            ['Perception', 'Wis'],
                            ['Performance', 'Cha'],
                            ['Persuasion', 'Cha'],
                            ['Religion', 'Int'],
                            ['Sleight of Hand', 'Dex'],
                            ['Stealth', 'Dex'],
                            ['Survival', 'Wis'],
                        ];
                        foreach ($skills as [$skill, $stat]):
                        ?>
                        <div class="flex items-center gap-2">
                            <button type="button" class="toggle-circ" aria-label="<?= $skill ?> proficiency"></button>
                            <input type="text" placeholder="+0" class="sm-input" aria-label="<?= $skill ?> bonus">
                            <span class="text-xs text-[#e2c8a3]"><?= $skill ?> <span class="text-[#9e7c56]">(<?= $stat ?>)</span></span>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- ── Passive Stats ─────────────────────────────── -->
                <div class="rounded-xl border border-[#8d643d]/35 bg-[#4a2f1d]/75 px-3 py-2 mb-3">
                    <p class="mb-2 text-[10px] font-semibold uppercase tracking-[0.14em] text-[#c4a060]">Passive Stats</p>
                    <div class="flex flex-col gap-1.5">
                        <?php
                        $passives = [
                            ['Passive Perception', '10'],
                            ['Passive Investigation', '10'],
                            ['Passive Insight', '10'],
                        ];
                        foreach ($passives as [$label, $default]):
                        ?>
                        <div class="flex items-center gap-2">
                            <input type="number" value="<?= $default ?>" class="sm-input" aria-label="<?= $label ?>">
                            <span class="text-xs text-[#e2c8a3]"><?= $label ?></span>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>

            </aside><!-- /profSlider -->

            <!-- ════════════════════════════════════════════════════════
                 RIGHT SLIDER OVERLAY – "Character Panels"
            ════════════════════════════════════════════════════════════ -->
            <aside id="charSlider"
                   class="absolute inset-0 z-20 overflow-y-auto sheet-scroll bg-[#2b1c13] border-l border-[#8b633f]/40 px-3 py-3">

                <div class="flex items-center justify-between mb-3">
                    <p class="font-royal text-lg text-[#f3e1c3]">Character Panels</p>
                    <button type="button" data-action="toggle-char-slider"
                            class="inline-flex h-8 w-8 items-center justify-center rounded-md border border-[#8e653f] bg-[#6f4929] text-[#f3e2c7] hover:bg-[#7e5430] transition">
                        <i class="ri-close-line text-base" aria-hidden="true"></i>
                    </button>
                </div>

                <section class="flex flex-col gap-2">

                    <section class="md:grid gap-2 md:grid-cols-2">
                        <article class="rounded-2xl border border-[#8d643d]/35 bg-[#4a2f1d]/80 p-2 flex flex-col gap-1">
                            <textarea class="sheet-input character-appearance-fixed"
                                      placeholder="Character appearance..."
                                      aria-label="Character appearance"></textarea>
                            <p class="section-title section-title-xs">Character Appearance</p>
                        </article>

                        <div class="grid gap-2 char-panels-grid">
                            <article class="rounded-2xl border border-[#8d643d]/35 bg-[#4a2f1d]/80 p-2 flex flex-col gap-1">
                                <textarea class="sheet-input sheet-notes-textarea notes-min-300"
                                          placeholder="Allies, contacts, organizations..."
                                          aria-label="Allies and organizations"></textarea>
                                <p class="section-title section-title-xs">Allies &amp; Organizations</p>
                            </article>

                            <article class="rounded-2xl border border-[#8d643d]/35 bg-[#4a2f1d]/80 p-2 flex flex-col gap-1">
                                <input type="text" class="sheet-input" placeholder="Name" aria-label="Symbol name">
                                <textarea class="sheet-input symbol-notes-textarea"
                                          placeholder="Symbol notes..."
                                          aria-label="Character symbol"></textarea>
                                <p class="section-title section-title-xs">Symbol</p>
                            </article>
                        </div>
                    </section>

                    <section class="md:grid gap-2 md:grid-cols-2">
                        <article class="rounded-2xl border border-[#8d643d]/35 bg-[#4a2f1d]/80 p-2 flex flex-col gap-1">
                            <textarea class="sheet-input sheet-notes-textarea notes-min-360"
                                      placeholder="Character backstory..."
                                      aria-label="Character backstory"></textarea>
                            <p class="section-title section-title-xs">Character Backstory</p>
                        </article>

                        <div class="flex flex-col gap-2">
                            <article class="rounded-2xl border border-[#8d643d]/35 bg-[#4a2f1d]/80 p-2 flex flex-col gap-1">
                                <textarea class="sheet-input sheet-notes-textarea notes-min-210"
                                          placeholder="Additional features and traits..."
                                          aria-label="Additional features and traits"></textarea>
                                <p class="section-title section-title-xs">Additional Features &amp; Traits</p>
                            </article>

                            <article class="rounded-2xl border border-[#8d643d]/35 bg-[#4a2f1d]/80 p-2 flex flex-col gap-1">
                                <textarea class="sheet-input sheet-notes-textarea notes-min-140"
                                          placeholder="Treasure, valuables, special items..."
                                          aria-label="Treasure"></textarea>
                                <p class="section-title section-title-xs">Treasure</p>
                            </article>
                        </div>
                    </section>

                    <div class="h-3"></div>
                </section>

            </aside><!-- /charSlider -->

            <!-- ════════════════════════════════════════════════════════
                 MAIN CONTENT AREA
            ════════════════════════════════════════════════════════════ -->
            <section class="sheet-main-scroll sheet-scroll px-2 py-2 flex flex-col gap-2">

                

                <!-- ── Top stats: AC / Initiative / Speed ────────── -->
                <section class="flex flex-row gap-2" aria-label="Top stats">
                    <?php
                    $topStats = [
                        ['AC', 'Armor Class'],
                        ['Initiative', 'Initiative'],
                        ['Speed', 'Speed'],
                    ];
                    foreach ($topStats as [$short, $label]):
                    ?>
                    <article class="flex-1 rounded-2xl border border-[#8d643d]/35 bg-[#4a2f1d]/80 px-2 py-1.5 flex flex-col items-center gap-0.5">
                        <input type="number" placeholder="—"
                               class="w-8 rounded-md border border-[#a87b4f]/35 bg-[#3e2718] text-center text-sm font-bold text-[#f5e5ca] outline-none focus:ring-2 focus:ring-[#d5b078] py-0.5"
                               aria-label="<?= $label ?>">
                        <p class="section-title section-title-top-stat"><?= $short ?></p>
                    </article>
                    <?php endforeach; ?>
                </section>

                <!-- ── HP Section ─────────────────────────────────── -->
                <section class="flex flex-row gap-2" aria-label="Hit points and death saves">

                    <!-- HP atual / max -->
                    <article class="flex-1 rounded-2xl border border-[#8d643d]/35 bg-[#4a2f1d]/80 px-2 py-2 flex flex-col items-center gap-1">
                        <div class="flex items-center gap-0.5 w-full justify-center">
                            <input type="number" placeholder="—"
                                   class="w-9 rounded-md border border-[#a87b4f]/35 bg-[#3e2718] text-center text-sm font-bold text-[#f5e5ca] outline-none focus:ring-2 focus:ring-[#d5b078] py-0.5"
                                   aria-label="HP atual">
                            <span class="text-[#9e7c56] text-[10px]">/</span>
                            <input type="number" placeholder="—"
                                   class="w-9 rounded-md border border-[#a87b4f]/35 bg-[#3e2718] text-center text-sm font-bold text-[#f5e5ca] outline-none focus:ring-2 focus:ring-[#d5b078] py-0.5"
                                   aria-label="HP max">
                        </div>
                        <p class="section-title">HP / Max</p>
                    </article>

                    <!-- Temp HP -->
                    <article class="flex-1 rounded-2xl border border-[#8d643d]/35 bg-[#4a2f1d]/80 px-2 py-2 flex flex-col items-center gap-1">
                        <input type="number" placeholder="—"
                               class="w-9 rounded-lg border border-[#a87b4f]/35 bg-[#3e2718] text-center text-sm font-bold text-[#f5e5ca] outline-none focus:ring-2 focus:ring-[#d5b078] py-0.5"
                               aria-label="HP temporário">
                        <p class="section-title">Temp HP</p>
                    </article>

                    <!-- Death Saves -->
                    <article class="flex-1 rounded-2xl border border-[#8d643d]/35 bg-[#4a2f1d]/80 px-2 py-1.5 flex flex-col gap-1">
                        <p class="section-title">Death Saves</p>
                        <div class="flex items-center justify-between gap-0.5">
                            <span class="text-[8px] text-[#c5e0b5] uppercase leading-none">S</span>
                            <div class="flex gap-0.5">
                                <button type="button" class="toggle-circ toggle-circ-sm" aria-label="Success 1"></button>
                                <button type="button" class="toggle-circ toggle-circ-sm" aria-label="Success 2"></button>
                                <button type="button" class="toggle-circ toggle-circ-sm" aria-label="Success 3"></button>
                            </div>
                        </div>
                        <div class="flex items-center justify-between gap-0.5">
                            <span class="text-[8px] text-[#f3c1b6] uppercase leading-none">F</span>
                            <div class="flex gap-0.5">
                                <button type="button" class="toggle-circ toggle-circ-sm" aria-label="Failure 1"></button>
                                <button type="button" class="toggle-circ toggle-circ-sm" aria-label="Failure 2"></button>
                                <button type="button" class="toggle-circ toggle-circ-sm" aria-label="Failure 3"></button>
                            </div>
                        </div>
                    </article>

                </section><!-- /hp section -->

                <!-- ── Attacks ─────────────────────────────────────── -->
                <section class="rounded-2xl border border-[#8d643d]/35 bg-[#4a2f1d]/80 overflow-hidden">
                    <div class="px-3 py-2 border-b border-[#7f5938]/35 flex items-center justify-between gap-2">
                        <p class="text-[10px] font-semibold uppercase tracking-[0.14em] text-[#c4a060]">Attacks</p>
                    <button type="button" data-add-row="attack"
                                class="text-base leading-none font-semibold text-[#f3e2c7] hover:text-[#ffffff] transition"
                                aria-label="Adicionar ataque">+</button>
                    </div>

                    <!-- Attacks table -->
                    <div class="dyn-table-frame dyn-table-frame-attacks">
                        <table class="dyn-table dyn-table-scroll">
                            <thead>
                                <tr>
                                    <th>Nome</th>
                                    <th>Atk Bonus</th>
                                    <th>Damage/Type</th>
                                    <th class="w-6"></th>
                                </tr>
                            </thead>
                            <tbody id="attacksBody">
                                <!-- dynamic rows -->
                            </tbody>
                        </table>
                    </div>
                </section><!-- /attacks -->

                <!-- ── Spellcasting ───────────────────────────────── -->
                <section class="rounded-2xl border border-[#8d643d]/35 bg-[#4a2f1d]/80 overflow-hidden">
                    <div class="px-3 py-2 border-b border-[#7f5938]/35 flex items-center justify-between gap-2">
                        <p class="text-[10px] font-semibold uppercase tracking-[0.14em] text-[#c4a060]">Spellcasting</p>
                    <button type="button" data-add-row="spell"
                                class="text-base leading-none font-semibold text-[#f3e2c7] hover:text-[#ffffff] transition"
                                aria-label="Adicionar spell">+</button>
                    </div>

                    <!-- Spells table -->
                    <div class="dyn-table-frame dyn-table-frame-spell">
                        <table class="dyn-table dyn-table-scroll">
                            <thead>
                                <tr>
                                    <th>Nome</th>
                                    <th>Spell Lvl</th>
                                    <th class="w-6"></th>
                                </tr>
                            </thead>
                            <tbody id="spellsBody">
                                <!-- dynamic rows -->
                            </tbody>
                        </table>
                    </div>
                </section><!-- /spellcasting -->

                <!-- ── Equipment ─────────────────────────────────── -->
                <section class="rounded-2xl border border-[#8d643d]/35 bg-[#4a2f1d]/80 overflow-hidden equipment-section">
                    <div class="px-3 py-2 border-b border-[#7f5938]/35 flex items-center justify-between gap-2">
                        <p class="text-[10px] font-semibold uppercase tracking-[0.14em] text-[#c4a060]">Equipment</p>
                    <button type="button" data-add-row="equipment"
                                class="text-base leading-none font-semibold text-[#f3e2c7] hover:text-[#ffffff] transition"
                                aria-label="Adicionar equipamento">+</button>
                    </div>

                    <div class="equipment-section-body">
                        <!-- Equipment table -->
                        <div class="dyn-table-frame dyn-table-frame-equip equipment-table-frame">
                            <table class="dyn-table dyn-table-scroll">
                                <thead>
                                    <tr>
                                        <th>Nome</th>
                                        <th>Descrição</th>
                                        <th class="w-6"></th>
                                    </tr>
                                </thead>
                                <tbody id="equipBody">
                                    <!-- dynamic rows -->
                                </tbody>
                            </table>
                        </div>

                        <!-- Coins -->
                        <div class="equipment-coins-bar">
                            <p class="section-title section-title-xs mb-0.5">Coins</p>
                            <div class="flex items-end justify-center gap-1.5">
                            <?php
                            $coins = ['cp', 'sp', 'ep', 'gp', 'pp'];
                            foreach ($coins as $coin):
                            ?>
                            <div class="w-8 flex flex-col items-center gap-0">
                                <input type="number" min="0" placeholder="0"
                                       class="sm-input coin-input"
                                       aria-label="<?= strtoupper($coin) ?>">
                                <span class="text-[6px] uppercase tracking-wide text-[#9e7c56] leading-tight"><?= $coin ?></span>
                            </div>
                            <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </section><!-- /equipment -->

                <!-- ── Features & Traits ─────────────────────────── -->
                <section class="rounded-2xl border border-[#8d643d]/35 bg-[#4a2f1d]/80 overflow-hidden">
                    <div class="px-3 py-2 border-b border-[#7f5938]/35 flex items-center justify-between gap-2">
                        <p class="text-[10px] font-semibold uppercase tracking-[0.14em] text-[#c4a060]">Features &amp; Traits</p>
                    <button type="button" data-add-row="feature-trait"
                                class="text-base leading-none font-semibold text-[#f3e2c7] hover:text-[#ffffff] transition"
                                aria-label="Adicionar feature ou trait">+</button>
                    </div>
                    <div class="dyn-table-frame dyn-table-frame-lg">
                        <table class="dyn-table dyn-table-scroll">
                            <thead>
                                <tr>
                                    <th>Nome</th>
                                    <th>Descrição</th>
                                    <th class="w-6"></th>
                                </tr>
                            </thead>
                            <tbody id="featuresTraitsBody">
                                <!-- dynamic rows -->
                            </tbody>
                        </table>
                    </div>
                </section><!-- /features & traits -->

                <!-- ── Other Proficiencies & Languages ───────────── -->
                <section class="rounded-2xl border border-[#8d643d]/35 bg-[#4a2f1d]/80 overflow-hidden">

                    <div class="px-3 py-2 border-b border-[#7f5938]/35 flex items-center justify-between gap-2">
                        <p class="text-[10px] font-semibold uppercase tracking-[0.14em] text-[#c4a060]">Other Proficiencies &amp; Languages</p>
                        <button type="button" data-add-row="other-proficiency"
                                class="text-base leading-none font-semibold text-[#f3e2c7] hover:text-[#ffffff] transition"
                                aria-label="Adicionar proficiência ou idioma">+</button>
                    </div>
                    <div class="dyn-table-frame dyn-table-frame-xl">
                        <table class="dyn-table dyn-table-scroll">
                            <thead>
                                <tr>
                                    <th>Nome</th>
                                    <th>Descrição</th>
                                    <th class="w-6"></th>
                                </tr>
                            </thead>
                            <tbody id="otherProficienciesBody">
                                <!-- dynamic rows -->
                            </tbody>
                        </table>
                    </div>
                </section><!-- /other proficiencies & languages -->

                <!-- bottom spacer -->
                <div class="h-4"></div>

            </section><!-- /main content scroll -->

        </div><!-- /content wrapper -->

    </section><!-- /sheet-wrapper -->
</main>
    <script src="<?= base_url('js/character-sheet.js') ?>"></script>
</body>
</html>
