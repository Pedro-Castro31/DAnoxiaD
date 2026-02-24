<header class="sticky top-0 z-30 h-[60px] border-b border-[#8b633f]/30 bg-[#2b1c13]/90 backdrop-blur-sm">
    <div class="flex h-full items-center justify-between px-4">
        <a href="<?= base_url('/') ?>" class="inline-flex items-center gap-2">
            <img id="mainLogo" src="<?= base_url('assets/images/logo.png') ?>" alt="Anoxia" class="h-9 w-auto">
            <span id="logoFallback" class="hidden font-royal text-lg tracking-[0.18em] text-[#e6cca0]">ANOXIA</span>
        </a>

        <div class="flex items-center gap-2">
            <span class="rounded-full border border-[#9d7550] bg-[#6d4628] px-3 py-1 text-[10px] font-semibold uppercase tracking-wide">Character Sheet</span>

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

            <button type="button" id="mobileMenuButton"
                    class="inline-flex h-9 w-9 items-center justify-center rounded-md border border-[#8e653f] bg-[#6f4929] text-[#f3e2c7] transition hover:bg-[#7e5430] sm:hidden"
                    aria-label="Abrir menu">
                <i class="ri-menu-line text-lg" aria-hidden="true"></i>
            </button>
        </div>
    </div>
</header>
