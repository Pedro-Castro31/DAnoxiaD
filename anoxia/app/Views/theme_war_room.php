<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>War Room Components | Anoxia</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Alegreya:wght@400;500;700;800&family=Cinzel:wght@500;700;800&family=Cormorant+Garamond:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('assets/css/app.css') ?>">
</head>
<body class="min-h-screen bg-[#2f1e14] text-[#f4e3c8] font-tavern">
    <div class="absolute inset-0 -z-10 bg-[radial-gradient(circle_at_20%_10%,#70472a_0%,#4b301f_42%,#2a1a12_100%)]"></div>

    <header class="sticky top-0 z-20 border-b border-[#8b633f]/30 bg-[#2b1c13]/85 backdrop-blur-sm">
        <div class="mx-auto flex max-w-7xl items-center justify-between px-6 py-4">
            <div>
                <p class="font-royal text-lg tracking-[0.22em] text-[#e6cca0]">WAR ROOM UI KIT</p>
                <p class="text-xs uppercase tracking-[0.2em] text-[#caa679]">All Components and Variants</p>
            </div>
            <div class="hidden items-center gap-2 sm:flex">
                <span class="rounded-full border border-[#9d7550] bg-[#6d4628] px-3 py-1 text-xs font-semibold uppercase tracking-wide">Dark Theme</span>
                <span class="rounded-full border border-[#9d7550] bg-[#5a3923] px-3 py-1 text-xs font-semibold uppercase tracking-wide">Medieval Palette</span>
            </div>
        </div>
    </header>

    <main class="mx-auto flex max-w-7xl flex-col gap-6 px-6 py-7">
        <section class="rounded-3xl border border-[#8d643d]/35 bg-[#5a3923]/70 p-6 shadow-[0_14px_34px_rgba(10,6,4,0.35)]">
            <h1 class="font-royal text-4xl text-[#f6e8cd]">Component Gallery</h1>
            <p class="mt-2 max-w-3xl text-[#dfc49d]">This page intentionally shows many UI pieces in one place: buttons, tables, form controls, cards, alerts, tabs, badges, pagination, and more.</p>
        </section>

        <section class="grid gap-6 xl:grid-cols-2">
            <article class="rounded-3xl border border-[#8d643d]/35 bg-[#4f321f]/70 p-6">
                <h2 class="font-royal text-2xl text-[#f3e1c3]">Buttons</h2>
                <div class="mt-4 flex flex-wrap gap-3 text-sm">
                    <button class="rounded-lg border border-[#d4b07a] bg-[#c89b60] px-4 py-2 font-semibold text-[#2d1c12] hover:bg-[#dbb780]">Primary</button>
                    <button class="rounded-lg border border-[#8e653f] bg-[#6f4929] px-4 py-2 font-semibold text-[#f3e2c7] hover:bg-[#7e5430]">Secondary</button>
                    <button class="rounded-lg border border-[#a67a4f] bg-transparent px-4 py-2 font-semibold text-[#efddbf] hover:bg-[#6a4327]/40">Outline</button>
                    <button class="rounded-lg border border-[#7a5332] bg-[#533622] px-4 py-2 font-semibold text-[#f0ddbd] opacity-60" disabled>Disabled</button>
                </div>
                <div class="mt-4 flex flex-wrap items-center gap-3 text-sm">
                    <button class="rounded-full border border-[#d4b07a] bg-[#c89b60] px-4 py-1.5 font-semibold text-[#2d1c12]">Pill</button>
                    <button class="rounded-md border border-[#8f6640] bg-[#5a3924] px-3 py-1.5">Small</button>
                    <button class="rounded-xl border border-[#8f6640] bg-[#5a3924] px-5 py-3">Large</button>
                    <button class="inline-flex items-center gap-2 rounded-lg border border-[#d4b07a] bg-[#c89b60] px-4 py-2 font-semibold text-[#2d1c12]">
                        <span>+ </span>Recruit
                    </button>
                </div>
            </article>

            <article class="rounded-3xl border border-[#8d643d]/35 bg-[#4f321f]/70 p-6">
                <h2 class="font-royal text-2xl text-[#f3e1c3]">Badges and Chips</h2>
                <div class="mt-4 flex flex-wrap gap-2 text-xs font-semibold uppercase tracking-wide">
                    <span class="rounded-full bg-[#c5e0b5] px-2.5 py-1 text-[#2a4e1e]">Stable</span>
                    <span class="rounded-full bg-[#d7b377] px-2.5 py-1 text-[#362313]">Alert</span>
                    <span class="rounded-full bg-[#f3c1b6] px-2.5 py-1 text-[#6d221a]">Critical</span>
                    <span class="rounded-full border border-[#a57a4f] bg-[#5d3b24] px-2.5 py-1 text-[#f0ddbf]">Neutral</span>
                </div>
                <div class="mt-4 flex flex-wrap gap-2 text-sm">
                    <span class="rounded-lg border border-[#8e653f] bg-[#5a3923] px-3 py-1.5">Northwatch</span>
                    <span class="rounded-lg border border-[#8e653f] bg-[#5a3923] px-3 py-1.5">Supply Train</span>
                    <span class="rounded-lg border border-[#8e653f] bg-[#5a3923] px-3 py-1.5">Night Patrol</span>
                    <span class="rounded-lg border border-[#8e653f] bg-[#5a3923] px-3 py-1.5">Signal Fires</span>
                </div>
            </article>
        </section>

        <section class="grid gap-6 xl:grid-cols-3">
            <article class="rounded-3xl border border-[#8d643d]/35 bg-[#5a3923]/65 p-6 xl:col-span-2">
                <h2 class="font-royal text-2xl text-[#f3e1c3]">Alerts</h2>
                <div class="mt-4 space-y-3 text-sm" id="alertContainer">
                    <div data-alert class="flex items-start justify-between gap-3 rounded-lg border border-[#6f9b5a] bg-[#d8edce] px-4 py-3 text-[#264a1e]">
                        <span>Success: East gate reinforcement deployed.</span>
                        <button class="alert-close rounded px-2 py-0.5 font-semibold hover:bg-[#bddfae]">x</button>
                    </div>
                    <div data-alert class="flex items-start justify-between gap-3 rounded-lg border border-[#b4895f] bg-[#f3e0b6] px-4 py-3 text-[#5c3a1a]">
                        <span>Warning: Arrow inventory below threshold.</span>
                        <button class="alert-close rounded px-2 py-0.5 font-semibold hover:bg-[#ead096]">x</button>
                    </div>
                    <div data-alert class="flex items-start justify-between gap-3 rounded-lg border border-[#b66b5a] bg-[#f3cbc2] px-4 py-3 text-[#5f1f19]">
                        <span>Danger: Signal loss from River Bastion.</span>
                        <button class="alert-close rounded px-2 py-0.5 font-semibold hover:bg-[#ebb3a8]">x</button>
                    </div>
                    <div data-alert class="flex items-start justify-between gap-3 rounded-lg border border-[#8d643d] bg-[#4b301d] px-4 py-3 text-[#f0ddbf]">
                        <span>Info: Patrol schedule updated at dusk.</span>
                        <button class="alert-close rounded px-2 py-0.5 font-semibold hover:bg-[#6a4328]">x</button>
                    </div>
                </div>
            </article>

            <article class="rounded-3xl border border-[#8d643d]/35 bg-[#5a3923]/65 p-6">
                <h2 class="font-royal text-2xl text-[#f3e1c3]">Avatars</h2>
                <div class="mt-4 flex flex-wrap items-center gap-3">
                    <div class="grid h-9 w-9 place-items-center rounded-full border border-[#a67b51] bg-[#c89b60] font-semibold text-[#2f1d11]">A</div>
                    <div class="grid h-11 w-11 place-items-center rounded-full border border-[#a67b51] bg-[#7a5232] font-semibold">B</div>
                    <div class="grid h-14 w-14 place-items-center rounded-full border border-[#a67b51] bg-[#5f3c24] text-lg font-semibold">C</div>
                    <div class="grid h-11 w-11 place-items-center rounded-xl border border-[#a67b51] bg-[#4a2f1d] font-semibold">D</div>
                </div>
                <div class="mt-4 flex -space-x-2">
                    <div class="grid h-9 w-9 place-items-center rounded-full border-2 border-[#3e2819] bg-[#d4b07a] text-[#2e1c11]">R</div>
                    <div class="grid h-9 w-9 place-items-center rounded-full border-2 border-[#3e2819] bg-[#b58b5a]">K</div>
                    <div class="grid h-9 w-9 place-items-center rounded-full border-2 border-[#3e2819] bg-[#8c633d]">L</div>
                </div>
            </article>
        </section>

        <section class="rounded-3xl border border-[#8d643d]/35 bg-[#5a3923]/65 p-6">
            <div class="flex items-center justify-between">
                <h2 class="font-royal text-2xl text-[#f3e1c3]">Cards</h2>
                <button class="rounded-lg border border-[#8f6640] bg-[#6f4929] px-3 py-1.5 text-sm">View All</button>
            </div>
            <div class="mt-4 grid gap-4 md:grid-cols-3">
                <article class="rounded-2xl border border-[#8f6640]/35 bg-[#4a2f1d]/75 p-4 shadow-sm">
                    <p class="text-xs uppercase tracking-wide text-[#cfae84]">Scouts</p>
                    <p class="mt-2 font-royal text-3xl">26</p>
                    <p class="mt-2 text-sm text-[#e2c8a3]">Rapid riders across north ridge.</p>
                    <button class="mt-4 rounded-md border border-[#8f6640] bg-[#6b4528] px-3 py-1.5 text-sm">Inspect</button>
                </article>
                <article class="rounded-2xl border border-[#8f6640]/35 bg-[#4a2f1d]/75 p-4 shadow-sm">
                    <p class="text-xs uppercase tracking-wide text-[#cfae84]">Granary</p>
                    <p class="mt-2 font-royal text-3xl">84%</p>
                    <p class="mt-2 text-sm text-[#e2c8a3]">Current grain reserve level.</p>
                    <button class="mt-4 rounded-md border border-[#8f6640] bg-[#6b4528] px-3 py-1.5 text-sm">Inspect</button>
                </article>
                <article class="rounded-2xl border border-[#8f6640]/35 bg-[#4a2f1d]/75 p-4 shadow-sm">
                    <p class="text-xs uppercase tracking-wide text-[#cfae84]">Armory</p>
                    <p class="mt-2 font-royal text-3xl">312</p>
                    <p class="mt-2 text-sm text-[#e2c8a3]">Spears ready for deployment.</p>
                    <button class="mt-4 rounded-md border border-[#8f6640] bg-[#6b4528] px-3 py-1.5 text-sm">Inspect</button>
                </article>
            </div>
        </section>

        <section class="grid gap-6 xl:grid-cols-2">
            <article class="rounded-3xl border border-[#8d643d]/35 bg-[#5a3923]/65 p-6">
                <h2 class="font-royal text-2xl text-[#f3e1c3]">Forms</h2>
                <form class="mt-4 space-y-4 text-sm">
                    <div>
                        <label class="mb-1 block text-[#dfc49d]">Text Input</label>
                        <input class="w-full rounded-lg border border-[#a87b4f]/35 bg-[#3e2718] px-3 py-2 text-[#f5e5ca] placeholder:text-[#d0ae80] outline-none focus:ring-2 focus:ring-[#d5b078]" placeholder="Captain Name">
                    </div>
                    <div>
                        <label class="mb-1 block text-[#dfc49d]">Email Input</label>
                        <input type="email" class="w-full rounded-lg border border-[#a87b4f]/35 bg-[#3e2718] px-3 py-2 text-[#f5e5ca] placeholder:text-[#d0ae80] outline-none focus:ring-2 focus:ring-[#d5b078]" placeholder="captain@keep.local">
                    </div>
                    <div>
                        <label class="mb-1 block text-[#dfc49d]">Select</label>
                        <select class="w-full rounded-lg border border-[#a87b4f]/35 bg-[#3e2718] px-3 py-2 text-[#f5e5ca] outline-none focus:ring-2 focus:ring-[#d5b078]">
                            <option>Reinforce Northwatch</option>
                            <option>Escort Supply Caravan</option>
                            <option>Hold Position</option>
                        </select>
                    </div>
                    <div>
                        <label class="mb-1 block text-[#dfc49d]">Textarea</label>
                        <textarea class="h-24 w-full rounded-lg border border-[#a87b4f]/35 bg-[#3e2718] px-3 py-2 text-[#f5e5ca] placeholder:text-[#d0ae80] outline-none focus:ring-2 focus:ring-[#d5b078]" placeholder="Orders..."></textarea>
                    </div>
                    <div class="grid gap-3 sm:grid-cols-2">
                        <label class="flex items-center gap-2 rounded-lg border border-[#8b623d] bg-[#4a2f1d] px-3 py-2">
                            <input type="checkbox" class="h-4 w-4 rounded border-[#a67b50] bg-[#3e2818] text-[#d4b07a]">
                            <span>Send by raven</span>
                        </label>
                        <label class="flex items-center gap-2 rounded-lg border border-[#8b623d] bg-[#4a2f1d] px-3 py-2">
                            <input type="checkbox" checked class="h-4 w-4 rounded border-[#a67b50] bg-[#3e2818] text-[#d4b07a]">
                            <span>Mark urgent</span>
                        </label>
                    </div>
                    <div class="flex gap-4">
                        <label class="inline-flex items-center gap-2">
                            <input type="radio" name="prio" checked class="h-4 w-4 border-[#a67b50] bg-[#3e2818] text-[#d4b07a]">
                            <span>Routine</span>
                        </label>
                        <label class="inline-flex items-center gap-2">
                            <input type="radio" name="prio" class="h-4 w-4 border-[#a67b50] bg-[#3e2818] text-[#d4b07a]">
                            <span>High</span>
                        </label>
                    </div>
                    <div class="flex flex-wrap gap-3">
                        <button type="button" class="rounded-lg border border-[#d4b07a] bg-[#c89b60] px-4 py-2 font-semibold text-[#2d1c12]">Submit</button>
                        <button type="reset" class="rounded-lg border border-[#8e653f] bg-[#6f4929] px-4 py-2 font-semibold text-[#f3e2c7]">Reset</button>
                    </div>
                </form>
            </article>

            <article class="rounded-3xl border border-[#8d643d]/35 bg-[#5a3923]/65 p-6">
                <h2 class="font-royal text-2xl text-[#f3e1c3]">Input States</h2>
                <div class="mt-4 space-y-4 text-sm">
                    <div>
                        <label class="mb-1 block text-[#dfc49d]">Default</label>
                        <input class="w-full rounded-lg border border-[#a87b4f]/35 bg-[#3e2718] px-3 py-2" value="Northwatch Commander">
                    </div>
                    <div>
                        <label class="mb-1 block text-[#dfc49d]">Valid</label>
                        <input class="w-full rounded-lg border border-[#6f9b5a] bg-[#28401d] px-3 py-2 text-[#d7efcb]" value="Signal link active">
                    </div>
                    <div>
                        <label class="mb-1 block text-[#dfc49d]">Error</label>
                        <input class="w-full rounded-lg border border-[#b66b5a] bg-[#51241d] px-3 py-2 text-[#f6ccc3]" value="Route unavailable">
                    </div>
                    <div>
                        <label class="mb-1 block text-[#dfc49d]">Disabled</label>
                        <input disabled class="w-full rounded-lg border border-[#7b5637] bg-[#3c281a] px-3 py-2 opacity-60" value="Locked by council">
                    </div>
                    <div>
                        <label class="mb-1 block text-[#dfc49d]">Range</label>
                        <input type="range" class="w-full accent-[#d4b07a]">
                    </div>
                </div>
            </article>
        </section>

        <section class="grid gap-6 xl:grid-cols-3">
            <article class="rounded-3xl border border-[#8d643d]/35 bg-[#5a3923]/65 p-6">
                <h2 class="font-royal text-2xl text-[#f3e1c3]">Toast Triggers</h2>
                <div class="mt-4 flex flex-wrap gap-2 text-sm">
                    <button data-toast="success" class="rounded-lg border border-[#6f9b5a] bg-[#d8edce] px-3 py-1.5 font-semibold text-[#264a1e]">Success Toast</button>
                    <button data-toast="warning" class="rounded-lg border border-[#b4895f] bg-[#f3e0b6] px-3 py-1.5 font-semibold text-[#5c3a1a]">Warning Toast</button>
                    <button data-toast="danger" class="rounded-lg border border-[#b66b5a] bg-[#f3cbc2] px-3 py-1.5 font-semibold text-[#5f1f19]">Danger Toast</button>
                    <button data-toast="info" class="rounded-lg border border-[#8d643d] bg-[#4b301d] px-3 py-1.5 font-semibold text-[#f0ddbf]">Info Toast</button>
                </div>
            </article>

            <article class="rounded-3xl border border-[#8d643d]/35 bg-[#5a3923]/65 p-6">
                <h2 class="font-royal text-2xl text-[#f3e1c3]">Dropdown</h2>
                <div class="mt-4 relative inline-block text-sm">
                    <button id="dropdownBtn" class="rounded-lg border border-[#8f6640] bg-[#6f4929] px-4 py-2">Order Actions</button>
                    <div id="dropdownMenu" class="invisible absolute left-0 z-10 mt-2 w-52 rounded-lg border border-[#8f6640]/45 bg-[#3f2819] p-1 opacity-0 transition">
                        <button class="block w-full rounded-md px-3 py-2 text-left hover:bg-[#6f4929]">Duplicate order</button>
                        <button class="block w-full rounded-md px-3 py-2 text-left hover:bg-[#6f4929]">Assign captain</button>
                        <button class="block w-full rounded-md px-3 py-2 text-left hover:bg-[#6f4929]">Archive dispatch</button>
                    </div>
                </div>
            </article>

            <article class="rounded-3xl border border-[#8d643d]/35 bg-[#5a3923]/65 p-6">
                <h2 class="font-royal text-2xl text-[#f3e1c3]">Modal</h2>
                <button id="openModalBtn" class="mt-4 rounded-lg border border-[#d4b07a] bg-[#c89b60] px-4 py-2 font-semibold text-[#2d1c12]">Open Modal</button>
            </article>
        </section>

        <section class="grid gap-6 xl:grid-cols-2">
            <article class="rounded-3xl border border-[#8d643d]/35 bg-[#5a3923]/65 p-6">
                <div class="flex items-center justify-between">
                    <h2 class="font-royal text-2xl text-[#f3e1c3]">Tables</h2>
                    <button class="rounded-md border border-[#8e653f] bg-[#6f4929] px-3 py-1.5 text-sm">Export</button>
                </div>
                <div class="mt-4 overflow-x-auto rounded-xl border border-[#8f6640]/35">
                    <table class="min-w-full text-left text-sm">
                        <thead class="bg-[#6f4928] text-[#f8eedc]">
                            <tr>
                                <th class="px-4 py-3">Unit</th>
                                <th class="px-4 py-3">Count</th>
                                <th class="px-4 py-3">Status</th>
                                <th class="px-4 py-3">Commander</th>
                            </tr>
                        </thead>
                        <tbody class="bg-[#3c2618] text-[#f0ddbf]">
                            <tr class="border-t border-[#7f5938]/35">
                                <td class="px-4 py-3">North Guard</td>
                                <td class="px-4 py-3">72</td>
                                <td class="px-4 py-3"><span class="rounded bg-[#c5e0b5] px-2 py-1 text-xs font-semibold text-[#2a4e1e]">Ready</span></td>
                                <td class="px-4 py-3">Alden</td>
                            </tr>
                            <tr class="border-t border-[#7f5938]/35">
                                <td class="px-4 py-3">River Scouts</td>
                                <td class="px-4 py-3">18</td>
                                <td class="px-4 py-3"><span class="rounded bg-[#d7b377] px-2 py-1 text-xs font-semibold text-[#362313]">Alert</span></td>
                                <td class="px-4 py-3">Mira</td>
                            </tr>
                            <tr class="border-t border-[#7f5938]/35">
                                <td class="px-4 py-3">Gate Wardens</td>
                                <td class="px-4 py-3">34</td>
                                <td class="px-4 py-3"><span class="rounded bg-[#f3c1b6] px-2 py-1 text-xs font-semibold text-[#6d221a]">Check</span></td>
                                <td class="px-4 py-3">Bran</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </article>

            <article class="rounded-3xl border border-[#8d643d]/35 bg-[#5a3923]/65 p-6">
                <h2 class="font-royal text-2xl text-[#f3e1c3]">Minimal Table Variant</h2>
                <div class="mt-4 overflow-x-auto rounded-xl border border-[#8f6640]/35">
                    <table class="min-w-full text-left text-sm">
                        <thead class="bg-[#4a2f1d] text-[#f6e9d0]">
                            <tr>
                                <th class="px-4 py-2">Signal Tower</th>
                                <th class="px-4 py-2">Last Beacon</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-[#7f5938]/30 bg-[#3b2618]">
                            <tr><td class="px-4 py-2">Northwatch</td><td class="px-4 py-2">2 min ago</td></tr>
                            <tr><td class="px-4 py-2">Eastwall</td><td class="px-4 py-2">4 min ago</td></tr>
                            <tr><td class="px-4 py-2">Southgate</td><td class="px-4 py-2">1 min ago</td></tr>
                        </tbody>
                    </table>
                </div>
            </article>
        </section>

        <section class="grid gap-6 xl:grid-cols-3">
            <article class="rounded-3xl border border-[#8d643d]/35 bg-[#5a3923]/65 p-6">
                <h2 class="font-royal text-2xl text-[#f3e1c3]">Navigation</h2>
                <div class="mt-4 space-y-3 text-sm">
                    <nav class="flex flex-wrap gap-2">
                        <a href="#" class="rounded-lg border border-[#8f6640] bg-[#6f4929] px-3 py-1.5">Overview</a>
                        <a href="#" class="rounded-lg border border-[#8f6640] bg-[#4a2f1d] px-3 py-1.5 hover:bg-[#6f4929]">Units</a>
                        <a href="#" class="rounded-lg border border-[#8f6640] bg-[#4a2f1d] px-3 py-1.5 hover:bg-[#6f4929]">Orders</a>
                    </nav>
                    <div class="text-[#ddc29b]">
                        <span class="text-[#f3e2c7]">Keep</span> / <span class="text-[#f3e2c7]">War Room</span> / Overview
                    </div>
                </div>
            </article>

            <article class="rounded-3xl border border-[#8d643d]/35 bg-[#5a3923]/65 p-6">
                <h2 class="font-royal text-2xl text-[#f3e1c3]">Progress</h2>
                <div class="mt-4 space-y-3 text-sm">
                    <div>
                        <div class="mb-1 flex justify-between"><span>Wall Repair</span><span>68%</span></div>
                        <div class="h-2 rounded-full bg-[#3a2416]"><div class="h-2 w-[68%] rounded-full bg-[#d4ad74]"></div></div>
                    </div>
                    <div>
                        <div class="mb-1 flex justify-between"><span>Ration Delivery</span><span>84%</span></div>
                        <div class="h-2 rounded-full bg-[#3a2416]"><div class="h-2 w-[84%] rounded-full bg-[#c5e0b5]"></div></div>
                    </div>
                    <div>
                        <div class="mb-1 flex justify-between"><span>Scout Coverage</span><span>45%</span></div>
                        <div class="h-2 rounded-full bg-[#3a2416]"><div class="h-2 w-[45%] rounded-full bg-[#d7b377]"></div></div>
                    </div>
                </div>
            </article>

            <article class="rounded-3xl border border-[#8d643d]/35 bg-[#5a3923]/65 p-6">
                <h2 class="font-royal text-2xl text-[#f3e1c3]">Pagination</h2>
                <div class="mt-4 flex items-center gap-2 text-sm">
                    <button class="rounded-md border border-[#8f6640] bg-[#4a2f1d] px-3 py-1.5">&lt;</button>
                    <button class="rounded-md border border-[#8f6640] bg-[#6f4929] px-3 py-1.5">1</button>
                    <button class="rounded-md border border-[#8f6640] bg-[#4a2f1d] px-3 py-1.5">2</button>
                    <button class="rounded-md border border-[#8f6640] bg-[#4a2f1d] px-3 py-1.5">3</button>
                    <button class="rounded-md border border-[#8f6640] bg-[#4a2f1d] px-3 py-1.5">&gt;</button>
                </div>
            </article>
        </section>

        <section class="grid gap-6 xl:grid-cols-2">
            <article class="rounded-3xl border border-[#8d643d]/35 bg-[#5a3923]/65 p-6">
                <h2 class="font-royal text-2xl text-[#f3e1c3]">Accordions (Interactive)</h2>
                <div class="mt-4 space-y-2 text-sm" id="accordionSet">
                    <div class="rounded-lg border border-[#8f6640]/40 bg-[#452b1b]/70">
                        <button data-accordion-toggle class="flex w-full items-center justify-between px-3 py-2 text-left font-semibold">
                            <span>Northwall Incident Report</span><span>+</span>
                        </button>
                        <div data-accordion-panel class="hidden px-3 pb-3 text-[#dfc49d]">Patrol detected movement near western ridge at second bell.</div>
                    </div>
                    <div class="rounded-lg border border-[#8f6640]/40 bg-[#452b1b]/70">
                        <button data-accordion-toggle class="flex w-full items-center justify-between px-3 py-2 text-left font-semibold">
                            <span>Supply Route Delta</span><span>+</span>
                        </button>
                        <div data-accordion-panel class="hidden px-3 pb-3 text-[#dfc49d]">Alternate bridge crossing opens by dawn.</div>
                    </div>
                </div>
            </article>

            <article class="rounded-3xl border border-[#8d643d]/35 bg-[#5a3923]/65 p-6">
                <h2 class="font-royal text-2xl text-[#f3e1c3]">Tabs (Interactive)</h2>
                <div class="mt-4 text-sm">
                    <div class="flex gap-2" id="tabs">
                        <button data-tab="overview" class="tab-btn rounded-lg border border-[#8f6640] bg-[#6f4929] px-3 py-1.5">Overview</button>
                        <button data-tab="threats" class="tab-btn rounded-lg border border-[#8f6640] bg-[#4a2f1d] px-3 py-1.5">Threats</button>
                        <button data-tab="resources" class="tab-btn rounded-lg border border-[#8f6640] bg-[#4a2f1d] px-3 py-1.5">Resources</button>
                    </div>
                    <div class="mt-3 rounded-lg border border-[#8f6640]/35 bg-[#452b1b]/70 p-3 text-[#dfc49d]">
                        <div data-tab-panel="overview">Overview: patrol readiness at 87% with stable northern defenses.</div>
                        <div data-tab-panel="threats" class="hidden">Threats: increased activity near River Bastion and west ridge.</div>
                        <div data-tab-panel="resources" class="hidden">Resources: oil reserves 63%, arrow stock below threshold.</div>
                    </div>
                </div>
            </article>
        </section>

        <section class="rounded-3xl border border-[#8d643d]/35 bg-[#5a3923]/65 p-6">
            <h2 class="font-royal text-2xl text-[#f3e1c3]">Timeline and Lists</h2>
            <div class="mt-4 grid gap-6 xl:grid-cols-2 text-sm">
                <ol class="space-y-3">
                    <li class="flex gap-3 rounded-lg border border-[#8f6640]/35 bg-[#452b1b]/70 px-3 py-2">
                        <span class="mt-1 h-2.5 w-2.5 rounded-full bg-[#d7b377]"></span>
                        <div><p class="font-semibold">Dawn Bell</p><p class="text-[#dfc49d]">Northwatch beacon lit.</p></div>
                    </li>
                    <li class="flex gap-3 rounded-lg border border-[#8f6640]/35 bg-[#452b1b]/70 px-3 py-2">
                        <span class="mt-1 h-2.5 w-2.5 rounded-full bg-[#c5e0b5]"></span>
                        <div><p class="font-semibold">Second Bell</p><p class="text-[#dfc49d]">Supply convoy arrived.</p></div>
                    </li>
                    <li class="flex gap-3 rounded-lg border border-[#8f6640]/35 bg-[#452b1b]/70 px-3 py-2">
                        <span class="mt-1 h-2.5 w-2.5 rounded-full bg-[#f3c1b6]"></span>
                        <div><p class="font-semibold">Third Bell</p><p class="text-[#dfc49d]">Signal interruption logged.</p></div>
                    </li>
                </ol>
                <ul class="space-y-2">
                    <li class="rounded-lg border border-[#8f6640]/35 bg-[#452b1b]/70 px-3 py-2">Spears restocked at East Armory</li>
                    <li class="rounded-lg border border-[#8f6640]/35 bg-[#452b1b]/70 px-3 py-2">Rider squad reassigned to South Gate</li>
                    <li class="rounded-lg border border-[#8f6640]/35 bg-[#452b1b]/70 px-3 py-2">Night watch roster approved</li>
                    <li class="rounded-lg border border-[#8f6640]/35 bg-[#452b1b]/70 px-3 py-2">Torch oil reserve at 63%</li>
                </ul>
            </div>
        </section>
    </main>

    <div id="toastContainer" class="fixed bottom-4 right-4 z-50 flex w-[320px] max-w-[90vw] flex-col gap-2"></div>

    <div id="modalBackdrop" class="invisible fixed inset-0 z-40 grid place-items-center bg-black/60 opacity-0 transition">
        <div class="w-[92vw] max-w-md rounded-2xl border border-[#9b7450] bg-[#3f2819] p-5 shadow-2xl">
            <div class="flex items-start justify-between gap-3">
                <div>
                    <h3 class="font-royal text-2xl text-[#f3e1c3]">Dispatch Confirmation</h3>
                    <p class="mt-1 text-sm text-[#dfc49d]">Send reinforcement to East Gate at first bell?</p>
                </div>
                <button id="closeModalBtn" class="rounded px-2 py-0.5 hover:bg-[#6a4328]">x</button>
            </div>
            <div class="mt-4 flex justify-end gap-2 text-sm">
                <button id="cancelModalBtn" class="rounded-lg border border-[#8f6640] bg-[#5a3924] px-3 py-1.5">Cancel</button>
                <button id="confirmModalBtn" class="rounded-lg border border-[#d4b07a] bg-[#c89b60] px-3 py-1.5 font-semibold text-[#2d1c12]">Confirm</button>
            </div>
        </div>
    </div>

    <script>
        (() => {
            const toastContainer = document.getElementById('toastContainer');
            const toastStyles = {
                success: 'border-[#6f9b5a] bg-[#d8edce] text-[#264a1e]',
                warning: 'border-[#b4895f] bg-[#f3e0b6] text-[#5c3a1a]',
                danger: 'border-[#b66b5a] bg-[#f3cbc2] text-[#5f1f19]',
                info: 'border-[#8d643d] bg-[#4b301d] text-[#f0ddbf]'
            };
            const toastText = {
                success: 'Reinforcement order dispatched.',
                warning: 'Stock is running low on arrows.',
                danger: 'Signal interruption detected.',
                info: 'Night watch schedule updated.'
            };

            function showToast(type) {
                const toast = document.createElement('div');
                toast.className = `rounded-lg border px-4 py-3 text-sm shadow-lg transition ${toastStyles[type] || toastStyles.info}`;
                toast.innerHTML = `
                    <div class="flex items-start justify-between gap-3">
                        <span>${toastText[type] || toastText.info}</span>
                        <button class="toast-close rounded px-2 py-0.5 font-semibold">x</button>
                    </div>
                `;
                toastContainer.appendChild(toast);

                const remove = () => {
                    toast.classList.add('opacity-0', 'translate-x-2');
                    setTimeout(() => toast.remove(), 180);
                };

                toast.querySelector('.toast-close')?.addEventListener('click', remove);
                setTimeout(remove, 4000);
            }

            document.querySelectorAll('[data-toast]').forEach((btn) => {
                btn.addEventListener('click', () => showToast(btn.dataset.toast));
            });

            document.querySelectorAll('.alert-close').forEach((btn) => {
                btn.addEventListener('click', () => {
                    const alert = btn.closest('[data-alert]');
                    if (!alert) return;
                    alert.classList.add('opacity-0');
                    setTimeout(() => alert.remove(), 180);
                });
            });

            const tabButtons = document.querySelectorAll('.tab-btn');
            const tabPanels = document.querySelectorAll('[data-tab-panel]');
            tabButtons.forEach((btn) => {
                btn.addEventListener('click', () => {
                    const tab = btn.dataset.tab;
                    tabButtons.forEach((b) => b.classList.replace('bg-[#6f4929]', 'bg-[#4a2f1d]'));
                    btn.classList.replace('bg-[#4a2f1d]', 'bg-[#6f4929]');
                    tabPanels.forEach((panel) => {
                        panel.classList.toggle('hidden', panel.dataset.tabPanel !== tab);
                    });
                });
            });

            document.querySelectorAll('#accordionSet [data-accordion-toggle]').forEach((toggle) => {
                toggle.addEventListener('click', () => {
                    const panel = toggle.parentElement.querySelector('[data-accordion-panel]');
                    const icon = toggle.querySelector('span:last-child');
                    const open = panel.classList.contains('hidden');
                    panel.classList.toggle('hidden');
                    icon.textContent = open ? '-' : '+';
                });
            });

            const dropdownBtn = document.getElementById('dropdownBtn');
            const dropdownMenu = document.getElementById('dropdownMenu');
            dropdownBtn?.addEventListener('click', () => {
                dropdownMenu.classList.toggle('invisible');
                dropdownMenu.classList.toggle('opacity-0');
            });
            document.addEventListener('click', (e) => {
                if (!dropdownBtn || !dropdownMenu) return;
                if (!dropdownBtn.contains(e.target) && !dropdownMenu.contains(e.target)) {
                    dropdownMenu.classList.add('invisible', 'opacity-0');
                }
            });

            const modalBackdrop = document.getElementById('modalBackdrop');
            const openModalBtn = document.getElementById('openModalBtn');
            const closeModalBtn = document.getElementById('closeModalBtn');
            const cancelModalBtn = document.getElementById('cancelModalBtn');
            const confirmModalBtn = document.getElementById('confirmModalBtn');

            const openModal = () => {
                modalBackdrop.classList.remove('invisible', 'opacity-0');
            };
            const closeModal = () => {
                modalBackdrop.classList.add('opacity-0');
                setTimeout(() => modalBackdrop.classList.add('invisible'), 150);
            };

            openModalBtn?.addEventListener('click', openModal);
            closeModalBtn?.addEventListener('click', closeModal);
            cancelModalBtn?.addEventListener('click', closeModal);
            modalBackdrop?.addEventListener('click', (e) => {
                if (e.target === modalBackdrop) closeModal();
            });
            confirmModalBtn?.addEventListener('click', () => {
                closeModal();
                showToast('success');
            });
        })();
    </script>
</body>
</html>
