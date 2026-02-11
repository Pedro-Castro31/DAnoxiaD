<header class="sticky top-0 z-20 border-b border-[#8b633f]/30 bg-[#2b1c13]/85 backdrop-blur-sm">
    <div class="mx-auto flex max-w-7xl items-center justify-between px-6 py-4">
        <div>
            <a href="<?= base_url('/') ?>" class="font-royal text-2xl tracking-[0.22em] text-[#e6cca0] hover:text-[#f6e8cd] transition">
                ANOXIA
            </a>
            <p class="text-xs uppercase tracking-[0.2em] text-[#caa679]">Medieval Command Center</p>
        </div>
        <div id="navbarActions" class="flex items-center gap-3">
            <?php if (session()->get('logged_in')): ?>
                <div class="flex items-center gap-3">
                    <span class="rounded-full border border-[#9d7550] bg-[#6d4628] px-4 py-2 text-sm font-semibold uppercase tracking-wide text-[#f3e2c7]">
                        <?= esc(session()->get('user_name')) ?>
                    </span>
                    <a href="<?= base_url('auth/logout') ?>" class="rounded-lg border border-[#8e653f] bg-[#6f4929] px-4 py-2 font-semibold text-[#f3e2c7] hover:bg-[#7e5430] transition">
                        Logout
                    </a>
                </div>
            <?php else: ?>
                <a href="<?= base_url('login') ?>" class="rounded-lg border border-[#d4b07a] bg-[#c89b60] px-4 py-2 font-semibold text-[#2d1c12] hover:bg-[#dbb780] transition">
                    Login
                </a>
            <?php endif; ?>
        </div>
    </div>
</header>
