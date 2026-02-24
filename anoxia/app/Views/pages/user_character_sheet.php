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
    <link rel="stylesheet" href="<?= base_url('assets/css/character-sheet-mobile.css') ?>">
    <style>
        /* ─── Slider panel ─────────────────────────────────────────────── */
        #profSlider {
            transform: translateX(-100%);
            transition: transform 260ms cubic-bezier(.4, 0, .2, 1);
        }
        #profSlider.slider-open {
            transform: translateX(0);
        }

        /* ─── Slider handle arrow ──────────────────────────────────────── */
        #sliderHandle .handle-icon {
            transition: transform 260ms cubic-bezier(.4, 0, .2, 1);
        }
        #sliderHandle.slider-open .handle-icon {
            transform: rotate(180deg);
        }

        /* ─── Toggle circle ────────────────────────────────────────────── */
        .toggle-circ {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 18px;
            height: 18px;
            border-radius: 50%;
            border: 2px solid #a87b4f;
            background: transparent;
            cursor: pointer;
            flex-shrink: 0;
            transition: background 150ms, border-color 150ms;
            padding: 0;
        }
        .toggle-circ.is-active {
            background: #c89b60;
            border-color: #d4b07a;
        }
        .toggle-circ:focus-visible {
            outline: 2px solid #d4b07a;
            outline-offset: 2px;
        }

        /* ─── Death save circles (larger) ─────────────────────────────── */
        .toggle-circ-sm {
            width: 16px;
            height: 16px;
        }

        /* ─── Modifier oval ────────────────────────────────────────────── */
        .modifier-input {
            width: 44px;
            height: 26px;
            border-radius: 9999px;
            border: 1px solid rgba(168, 123, 79, 0.45);
            background: #3e2718;
            color: #f5e5ca;
            font-size: 0.75rem;
            text-align: center;
            outline: none;
        }
        .modifier-input:focus {
            box-shadow: 0 0 0 2px #d5b078;
        }

        /* ─── Compact attribute input ──────────────────────────────────── */
        .attr-value-input {
            width: 48px;
            height: 40px;
            border-radius: 0.5rem;
            border: 1px solid rgba(168, 123, 79, 0.45);
            background: #3e2718;
            color: #f5e5ca;
            font-size: 1.25rem;
            font-weight: 700;
            text-align: center;
            outline: none;
        }
        .attr-value-input:focus {
            box-shadow: 0 0 0 2px #d5b078;
        }

        /* ─── Small inline input ───────────────────────────────────────── */
        .sm-input {
            width: 40px;
            border-radius: 0.375rem;
            border: 1px solid rgba(168, 123, 79, 0.35);
            background: #3e2718;
            color: #f5e5ca;
            font-size: 0.75rem;
            text-align: center;
            padding: 2px 4px;
            outline: none;
        }
        .sm-input:focus {
            box-shadow: 0 0 0 2px #d5b078;
        }

        /* ─── Sheet input (regular full-width) ─────────────────────────── */
        .sheet-input {
            border-radius: 0.5rem;
            border: 1px solid rgba(168, 123, 79, 0.35);
            background: #3e2718;
            color: #f5e5ca;
            font-size: 0.8125rem;
            padding: 4px 8px;
            outline: none;
            width: 100%;
        }
        .sheet-input:focus {
            box-shadow: 0 0 0 2px #d5b078;
        }
        .sheet-input::placeholder {
            color: #9e7c56;
        }

        /* ─── Rolling textarea (expand to content) ─────────────────────── */
        .auto-textarea {
            resize: none;
            overflow: hidden;
            min-height: 28px;
        }

        /* ─── Table row styles ─────────────────────────────────────────── */
        .dyn-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.75rem;
        }
        .dyn-table thead th {
            background: #6f4928;
            color: #f8eedc;
            padding: 5px 8px;
            text-align: left;
            font-weight: 600;
            white-space: nowrap;
        }
        .dyn-table tbody td {
            background: #3c2618;
            color: #f0ddbf;
            padding: 4px 6px;
            border-top: 1px solid rgba(127, 89, 56, 0.3);
            vertical-align: top;
        }
        .dyn-table tbody tr:hover td {
            background: #452b1b;
        }

        /* ─── Section title bar ──────────────────────────────────────────  */
        .section-title {
            font-size: 0.6rem;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            color: #c4a060;
            text-align: center;
            margin-top: 2px;
        }

        /* ─── Sheet scrollbar ────────────────────────────────────────────  */
        .sheet-scroll::-webkit-scrollbar {
            width: 4px;
        }
        .sheet-scroll::-webkit-scrollbar-track {
            background: #2b1c13;
        }
        .sheet-scroll::-webkit-scrollbar-thumb {
            background: #6f4929;
            border-radius: 2px;
        }

        /* ─── Page sizing & safe scrolling ──────────────────────────────  */
        html, body {
            min-height: 100%;
            overflow-x: hidden;
            overflow-y: auto;
        }

        /* ─── Sheet wrapper below navbar ────────────────────────────────  */
        .sheet-wrapper {
            display: flex;
            min-height: calc(100dvh - 60px);
            overflow: hidden;
        }

        /* ─── iOS momentum scroll on all scroll areas ────────────────────  */
        .sheet-scroll {
            -webkit-overflow-scrolling: touch;
        }

        /* ─── Dynamic table consistency ─────────────────────────────────  */
        .dyn-table-scroll {
            table-layout: fixed;
        }
        .dyn-table th:last-child,
        .dyn-table td:last-child {
            width: 2.25rem;
            text-align: center;
        }
        .dyn-table td .sheet-input,
        .dyn-table td .sm-input,
        .dyn-table td .auto-textarea {
            width: 100%;
        }

        /* ─── Slider backdrop (closes on outside click) ──────────────────  */
        #sliderBackdrop {
            display: none;
            position: absolute;
            inset: 0;
            z-index: 15;
            background: rgba(0, 0, 0, 0);
        }
        #sliderBackdrop.active {
            display: block;
        }
    </style>
</head>
<body class="character-sheet-page bg-[#2f1e14] text-[#f4e3c8] font-tavern">
    <div class="fixed inset-0 -z-10 bg-[radial-gradient(circle_at_20%_10%,#70472a_0%,#4b301f_42%,#2a1a12_100%)] pointer-events-none"></div>

    <!-- ══════════════════════════════════════════════════════════════════
         NAVBAR
    ══════════════════════════════════════════════════════════════════════ -->
    <header class="sticky top-0 z-30 border-b border-[#8b633f]/30 bg-[#2b1c13]/90 backdrop-blur-sm" style="height:60px">
        <div class="flex h-full items-center justify-between px-4">
            <a href="<?= base_url('/') ?>" class="inline-flex items-center gap-2">
                <img src="<?= base_url('assets/images/logo.png') ?>" alt="Anoxia" class="h-9 w-auto"
                     onerror="this.style.display='none';this.nextElementSibling.style.display='flex'">
                <span style="display:none" class="font-royal text-lg tracking-[0.18em] text-[#e6cca0]">ANOXIA</span>
            </a>

            <div class="flex items-center gap-2">
                <!-- Character sheet label -->
                <span class="rounded-full border border-[#9d7550] bg-[#6d4628] px-3 py-1 text-[10px] font-semibold uppercase tracking-wide">Character Sheet</span>

                <!-- Avatar / user menu (desktop) -->
                <div class="relative hidden sm:block">
                    <button type="button" id="avatarMenuButton"
                            class="inline-flex items-center gap-2 rounded-full border border-[#9d7550] bg-[#6d4628] px-2 py-1 text-sm font-semibold text-[#f3e2c7] transition hover:bg-[#7a5232]"
                            aria-expanded="false" aria-label="Abrir menu do utilizador">
                        <span class="inline-flex h-7 w-7 items-center justify-center rounded-full border border-[#b4895f] bg-[#5a3923]">
                            <?= esc(strtoupper(substr((string)(session()->get('user_name') ?? 'U'), 0, 1))) ?>
                        </span>
                        <i class="ri-arrow-down-s-line text-base" aria-hidden="true"></i>
                    </button>
                    <div id="avatarDropdown"
                         class="absolute right-0 top-12 z-40 hidden w-48 rounded-xl border border-[#8b633f]/30 bg-[#2b1c13]/95 p-2 shadow-lg backdrop-blur-sm">
                        <div class="mb-2 px-3 py-2">
                            <p class="text-[10px] uppercase tracking-wide text-[#caa679]">Utilizador</p>
                            <p class="mt-0.5 truncate text-sm font-semibold text-[#f3e2c7]">
                                <?= esc((string)(session()->get('user_name') ?? 'Utilizador')) ?>
                            </p>
                        </div>
                        <a href="<?= base_url('auth/logout') ?>"
                           class="inline-flex w-full items-center gap-2 rounded-lg border border-[#8e653f] bg-[#6f4929] px-3 py-2 text-sm font-semibold text-[#f3e2c7] transition hover:bg-[#7e5430]">
                            <i class="ri-logout-box-r-line text-base" aria-hidden="true"></i>
                            <span>Terminar sessão</span>
                        </a>
                    </div>
                </div>

                <!-- Mobile menu trigger -->
                <button type="button" id="mobileMenuButton"
                        class="inline-flex h-9 w-9 items-center justify-center rounded-md border border-[#8e653f] bg-[#6f4929] text-[#f3e2c7] transition hover:bg-[#7e5430] sm:hidden"
                        aria-label="Abrir menu">
                    <i class="ri-menu-line text-lg" aria-hidden="true"></i>
                </button>
            </div>
        </div>
    </header>

<!-- ── Character info header ────────────────────── -->
                <div class="rounded-2xl border border-[#8d643d]/35 bg-[#5a3923]/65 px-2 py-1 overflow-x-auto">
                    <table style="border-collapse:collapse;width:100%">
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
                                <td class="pr-1 pb-1"><input type="text" placeholder="Name" style="min-width:60px;font-size:0.7rem" class="sheet-input font-semibold" aria-label="Character name"></td>
                                <td class="pr-1 pb-1"><input type="text" placeholder="Fighter 1" style="min-width:52px;font-size:0.7rem" class="sheet-input" aria-label="Class and level"></td>
                                <td class="pr-1 pb-1"><input type="text" placeholder="Human" style="min-width:44px;font-size:0.7rem" class="sheet-input" aria-label="Race"></td>
                                <td class="pr-1 pb-1"><input type="text" placeholder="Soldier" style="min-width:44px;font-size:0.7rem" class="sheet-input" aria-label="Background"></td>
                                <td class="pb-1"><input type="text" placeholder="Neutral" style="min-width:52px;font-size:0.7rem" class="sheet-input" aria-label="Alignment"></td>
                            </tr>
                        </tbody>
                    </table>
                </div>

    <!-- Mobile offcanvas -->
    <div id="mobileBackdrop" class="fixed inset-0 z-40 hidden bg-black/60"></div>
    <aside id="mobileOffcanvas"
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
    </aside>

    <!-- ══════════════════════════════════════════════════════════════════
         CHARACTER SHEET   –   TWO-COLUMN LAYOUT
    ══════════════════════════════════════════════════════════════════════ -->
    <div class="sheet-wrapper">

        <!-- ────────────────────────────────────────────────────────────
             LEFT COLUMN – "Coluna dos Atributos"  (always visible)
        ──────────────────────────────────────────────────────────────── -->
        <aside class="relative z-10 flex w-[88px] flex-shrink-0 flex-col gap-1.5 overflow-y-auto sheet-scroll bg-[#2b1c13]/60 border-r border-[#8b633f]/30 px-1.5 py-2">

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
            <div class="rounded-xl border border-[#8d643d]/35 bg-[#4a2f1d]/80 p-1.5 flex flex-col items-center gap-1">
                <p class="section-title w-full"><?= $abbr ?></p>
                <input type="number" min="1" max="30" placeholder="10"
                       class="attr-value-input"
                       aria-label="<?= $full ?> value">
                <input type="text" placeholder="+0"
                       class="modifier-input"
                       aria-label="<?= $full ?> modifier">
                <p class="section-title w-full" style="font-size:0.5rem"><?= strtoupper($full) ?></p>
            </div>
            <?php endforeach; ?>

            <!-- ── Slider handle ──────────────────────────────────── -->
            <button type="button" id="sliderHandle"
                    onclick="toggleSlider()"
                    title="Abrir Proficiências"
                    class="mt-auto w-full rounded-lg border border-[#8e653f] bg-[#6f4929] py-2 text-[#f3e2c7] transition hover:bg-[#7e5430] flex flex-col items-center gap-0.5">
                <i class="handle-icon ri-menu-unfold-line text-base" aria-hidden="true"></i>
                <span class="text-[8px] uppercase tracking-wide leading-none">Prof.</span>
            </button>

        </aside><!-- /attr col -->

        <!-- ────────────────────────────────────────────────────────────
             CONTENT WRAPPER  (main + slider overlay)
        ──────────────────────────────────────────────────────────────── -->
        <div class="relative h-full flex-1 overflow-hidden">

            <!-- Backdrop – closes slider when tapping outside -->
            <div id="sliderBackdrop" onclick="toggleSlider()"></div>

            <!-- ════════════════════════════════════════════════════════
                 SLIDER OVERLAY – "Proficiências"
            ════════════════════════════════════════════════════════════ -->
                 <aside id="profSlider"
                   class="absolute inset-0 z-20 overflow-y-auto sheet-scroll bg-[#2b1c13] border-r border-[#8b633f]/40 px-3 py-3">

                <!-- Header row -->
                <div class="flex items-center justify-between mb-3">
                    <p class="font-royal text-lg text-[#f3e1c3]">Proficiências</p>
                    <button type="button" onclick="toggleSlider()"
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
                 MAIN CONTENT AREA
            ════════════════════════════════════════════════════════════ -->
            <div class="sheet-main-scroll h-full overflow-y-auto sheet-scroll px-2 py-2 flex flex-col gap-2">

                

                <!-- ── Top stats: AC / Initiative / Speed ────────── -->
                <div class="flex flex-row gap-2">
                    <?php
                    $topStats = [
                        ['AC', 'Armor Class'],
                        ['Initiative', 'Initiative'],
                        ['Speed', 'Speed'],
                    ];
                    foreach ($topStats as [$short, $label]):
                    ?>
                    <div class="flex-1 rounded-2xl border border-[#8d643d]/35 bg-[#4a2f1d]/80 px-2 py-1.5 flex flex-col items-center gap-0.5">
                        <input type="number" placeholder="—"
                               class="w-8 rounded-md border border-[#a87b4f]/35 bg-[#3e2718] text-center text-sm font-bold text-[#f5e5ca] outline-none focus:ring-2 focus:ring-[#d5b078] py-0.5"
                               aria-label="<?= $label ?>">
                        <p class="section-title" style="font-size:0.55rem"><?= $short ?></p>
                    </div>
                    <?php endforeach; ?>
                </div>

                <!-- ── HP Section ─────────────────────────────────── -->
                <div class="flex flex-row gap-2">

                    <!-- HP atual / max -->
                    <div class="flex-1 rounded-2xl border border-[#8d643d]/35 bg-[#4a2f1d]/80 px-2 py-2 flex flex-col items-center gap-1">
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
                    </div>

                    <!-- Temp HP -->
                    <div class="flex-1 rounded-2xl border border-[#8d643d]/35 bg-[#4a2f1d]/80 px-2 py-2 flex flex-col items-center gap-1">
                        <input type="number" placeholder="—"
                               class="w-9 rounded-lg border border-[#a87b4f]/35 bg-[#3e2718] text-center text-sm font-bold text-[#f5e5ca] outline-none focus:ring-2 focus:ring-[#d5b078] py-0.5"
                               aria-label="HP temporário">
                        <p class="section-title">Temp HP</p>
                    </div>

                    <!-- Death Saves -->
                    <div class="flex-1 rounded-2xl border border-[#8d643d]/35 bg-[#4a2f1d]/80 px-2 py-1.5 flex flex-col gap-1">
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
                    </div>

                </div><!-- /hp section -->

                <!-- ── Attacks & Spellcasting ─────────────────────── -->
                <div class="rounded-2xl border border-[#8d643d]/35 bg-[#4a2f1d]/80 overflow-hidden">
                    <div class="px-3 py-2 border-b border-[#7f5938]/35">
                        <p class="text-[10px] font-semibold uppercase tracking-[0.14em] text-[#c4a060]">Attacks &amp; Spellcasting</p>
                    </div>

                    <!-- Attacks table -->
                    <div class="overflow-x-auto">
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
                    <div class="px-3 py-2 border-b border-[#7f5938]/30">
                        <button type="button" onclick="addAttackRow()"
                                class="rounded-md border border-[#8e653f] bg-[#6f4929] px-3 py-1 text-[11px] font-semibold text-[#f3e2c7] hover:bg-[#7e5430] transition">
                            + Adicionar Ataque
                        </button>
                    </div>

                    <!-- Spells table -->
                    <div class="overflow-x-auto">
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
                    <div class="px-3 py-2">
                        <button type="button" onclick="addSpellRow()"
                                class="rounded-md border border-[#8e653f] bg-[#6f4929] px-3 py-1 text-[11px] font-semibold text-[#f3e2c7] hover:bg-[#7e5430] transition">
                            + Adicionar Spell
                        </button>
                    </div>
                </div><!-- /attacks -->

                <!-- ── Equipment ─────────────────────────────────── -->
                <div class="rounded-2xl border border-[#8d643d]/35 bg-[#4a2f1d]/80 overflow-hidden">
                    <div class="px-3 py-2 border-b border-[#7f5938]/35">
                        <p class="text-[10px] font-semibold uppercase tracking-[0.14em] text-[#c4a060]">Equipment</p>
                    </div>

                    <div class="flex gap-0">
                        <!-- Coins -->
                        <div class="w-12 flex-shrink-0 px-1.5 py-2 flex flex-col gap-1">
                            <p class="section-title mb-0.5" style="font-size:0.5rem">Coins</p>
                            <?php
                            $coins = ['cp', 'sp', 'ep', 'gp', 'pp'];
                            foreach ($coins as $coin):
                            ?>
                            <div class="flex flex-col items-center gap-0">
                                <input type="number" min="0" placeholder="0"
                                       class="sm-input w-full" style="font-size:0.65rem;padding:1px 2px"
                                       aria-label="<?= strtoupper($coin) ?>">
                                <span class="text-[7px] uppercase tracking-wide text-[#9e7c56] leading-tight"><?= $coin ?></span>
                            </div>
                            <?php endforeach; ?>
                        </div>
                        <!-- Equipment table -->
                        <div class="flex-1 overflow-x-auto border-r border-[#7f5938]/30">
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
                            <div class="px-3 py-2">
                                <button type="button" onclick="addEquipRow()"
                                        class="rounded-md border border-[#8e653f] bg-[#6f4929] px-3 py-1 text-[11px] font-semibold text-[#f3e2c7] hover:bg-[#7e5430] transition">
                                    + Adicionar Equipamento
                                </button>
                            </div>
                        </div>
                    </div>
                </div><!-- /equipment -->

                <!-- bottom spacer -->
                <div class="h-4"></div>

            </div><!-- /main content scroll -->

        </div><!-- /content wrapper -->

    </div><!-- /sheet-wrapper -->

    <!-- ══════════════════════════════════════════════════════════════════
         SCRIPTS
    ══════════════════════════════════════════════════════════════════════ -->
    <script>
    (() => {
        'use strict';

        // ── Navbar mobile offcanvas ──────────────────────────────────────
        const openBtn      = document.getElementById('mobileMenuButton');
        const closeBtn     = document.getElementById('mobileMenuClose');
        const offcanvas    = document.getElementById('mobileOffcanvas');
        const backdrop     = document.getElementById('mobileBackdrop');

        if (openBtn && closeBtn && offcanvas && backdrop) {
            const openNav = () => {
                offcanvas.classList.remove('translate-x-full', 'pointer-events-none');
                backdrop.classList.remove('hidden');
                document.body.classList.add('overflow-hidden');
            };
            const closeNav = () => {
                offcanvas.classList.add('translate-x-full', 'pointer-events-none');
                backdrop.classList.add('hidden');
                document.body.classList.remove('overflow-hidden');
            };
            openBtn.addEventListener('click', openNav);
            closeBtn.addEventListener('click', closeNav);
            backdrop.addEventListener('click', closeNav);
            document.addEventListener('keydown', (e) => { if (e.key === 'Escape') closeNav(); });
        }

        // ── Avatar dropdown ──────────────────────────────────────────────
        const avatarBtn  = document.getElementById('avatarMenuButton');
        const avatarMenu = document.getElementById('avatarDropdown');
        if (avatarBtn && avatarMenu) {
            avatarBtn.addEventListener('click', (e) => {
                e.stopPropagation();
                const hidden = avatarMenu.classList.contains('hidden');
                avatarMenu.classList.toggle('hidden', !hidden);
                avatarBtn.setAttribute('aria-expanded', String(hidden));
            });
            document.addEventListener('click', (e) => {
                if (!avatarMenu.contains(e.target) && !avatarBtn.contains(e.target)) {
                    avatarMenu.classList.add('hidden');
                    avatarBtn.setAttribute('aria-expanded', 'false');
                }
            });
        }

        // ── Toggle circles ───────────────────────────────────────────────
        function initToggles(context) {
            (context || document).querySelectorAll('.toggle-circ').forEach((btn) => {
                if (btn.dataset.initDone) return;
                btn.dataset.initDone = '1';
                btn.addEventListener('click', () => btn.classList.toggle('is-active'));
            });
        }
        initToggles();

        // ── Slider ───────────────────────────────────────────────────────
        const profSlider    = document.getElementById('profSlider');
        const sliderHandle  = document.getElementById('sliderHandle');
        const sliderBackdrop = document.getElementById('sliderBackdrop');
        let sliderOpen = false;

        window.toggleSlider = function () {
            sliderOpen = !sliderOpen;
            profSlider.classList.toggle('slider-open', sliderOpen);
            sliderHandle.classList.toggle('slider-open', sliderOpen);
            sliderBackdrop.classList.toggle('active', sliderOpen);
        };

        // Touch swipe on main content – swipe right to open, left to close
        let touchStartX = 0;
        const contentWrapper = profSlider.parentElement;
        contentWrapper.addEventListener('touchstart', (e) => {
            touchStartX = e.changedTouches[0].clientX;
        }, { passive: true });
        contentWrapper.addEventListener('touchend', (e) => {
            const dx = e.changedTouches[0].clientX - touchStartX;
            if (!sliderOpen && dx > 50) toggleSlider();
            if (sliderOpen && dx < -50) toggleSlider();
        }, { passive: true });

        // ── Dynamic table helpers ────────────────────────────────────────
        function makeDeleteBtn(row, onDelete) {
            const td = document.createElement('td');
            td.className = 'text-center';
            const btn = document.createElement('button');
            btn.type = 'button';
            btn.title = 'Remover linha';
            btn.className = 'inline-flex h-5 w-5 items-center justify-center rounded-full border border-[#b66b5a] bg-[#51241d] text-[#f6ccc3] text-[10px] hover:bg-[#6b2e26] transition';
            btn.innerHTML = '<i class="ri-close-line" aria-hidden="true"></i>';
            btn.addEventListener('click', () => {
                if (typeof onDelete === 'function') {
                    onDelete();
                    return;
                }
                row.remove();
            });
            td.appendChild(btn);
            return td;
        }

        function autoResize(textarea) {
            textarea.style.height = 'auto';
            textarea.style.height = textarea.scrollHeight + 'px';
        }

        // ── Attacks table ────────────────────────────────────────────────
        window.addAttackRow = function () {
            const tbody = document.getElementById('attacksBody');
            const tr = document.createElement('tr');

            const fields = [
                { ph: 'Sword', label: 'Nome do ataque' },
                { ph: '+5', label: 'Attack bonus' },
                { ph: '1d8+3 slash.', label: 'Damage and type' },
            ];

            fields.forEach(({ ph, label }) => {
                const td = document.createElement('td');
                const inp = document.createElement('input');
                inp.type = 'text';
                inp.placeholder = ph;
                inp.className = 'sheet-input';
                inp.setAttribute('aria-label', label);
                td.appendChild(inp);
                tr.appendChild(td);
            });

            tr.appendChild(makeDeleteBtn(tr));
            tbody.appendChild(tr);
        };

        // ── Spells table ─────────────────────────────────────────────────
        window.addSpellRow = function () {
            const tbody = document.getElementById('spellsBody');
            const tr = document.createElement('tr');
            tr.style.display = 'table-row';

            const descTr = document.createElement('tr');
            const descTd = document.createElement('td');
            descTd.colSpan = 3;
            const ta = document.createElement('textarea');
            ta.placeholder = 'Descrição…';
            ta.rows = 1;
            ta.className = 'sheet-input auto-textarea';
            ta.setAttribute('aria-label', 'Spell description');
            ta.addEventListener('input', () => autoResize(ta));
            descTd.appendChild(ta);
            descTr.appendChild(descTd);

            // Name cell
            const tdName = document.createElement('td');
            const nameInp = document.createElement('input');
            nameInp.type = 'text';
            nameInp.placeholder = 'Fireball';
            nameInp.className = 'sheet-input';
            nameInp.setAttribute('aria-label', 'Spell name');
            tdName.appendChild(nameInp);
            tr.appendChild(tdName);

            // Level cell
            const tdLvl = document.createElement('td');
            const lvlInp = document.createElement('input');
            lvlInp.type = 'number';
            lvlInp.min = '0';
            lvlInp.max = '9';
            lvlInp.placeholder = '3';
            lvlInp.className = 'sm-input';
            lvlInp.setAttribute('aria-label', 'Spell level');
            tdLvl.appendChild(lvlInp);
            tr.appendChild(tdLvl);

            tr.appendChild(makeDeleteBtn(tr, () => {
                descTr.remove();
                tr.remove();
            }));
            tbody.appendChild(tr);
            tbody.appendChild(descTr);
        };

        // ── Equipment table ──────────────────────────────────────────────
        window.addEquipRow = function () {
            const tbody = document.getElementById('equipBody');
            const tr = document.createElement('tr');

            // Name cell
            const tdName = document.createElement('td');
            const nameInp = document.createElement('input');
            nameInp.type = 'text';
            nameInp.placeholder = 'Longsword';
            nameInp.className = 'sheet-input';
            nameInp.setAttribute('aria-label', 'Item name');
            tdName.appendChild(nameInp);
            tr.appendChild(tdName);

            // Description cell
            const tdDesc = document.createElement('td');
            const ta = document.createElement('textarea');
            ta.placeholder = 'Descrição ou notas…';
            ta.rows = 1;
            ta.className = 'sheet-input auto-textarea';
            ta.setAttribute('aria-label', 'Item description');
            ta.addEventListener('input', () => autoResize(ta));
            tdDesc.appendChild(ta);
            tr.appendChild(tdDesc);

            tr.appendChild(makeDeleteBtn(tr));
            tbody.appendChild(tr);
        };

    })();
    </script>
</body>
</html>
