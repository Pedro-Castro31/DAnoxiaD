<header class="sticky top-0 z-20 border-b border-[var(--border-base)]/30 bg-[var(--bg-surface)]/85 backdrop-blur-sm">
    <div class="mx-auto flex max-w-7xl items-center justify-between px-6 py-4">
        <div>
            <a href="<?= base_url('/') ?>" class="font-royal text-2xl tracking-[0.22em] text-[var(--text-secondary)] hover:text-[var(--text-primary)] transition">
                ANOXIA
            </a>
            <p class="text-xs uppercase tracking-[0.2em] text-[var(--text-muted)]">Medieval Command Center</p>
        </div>
        <div id="navbarActions" class="flex items-center gap-3">
            <?php if (session()->get('logged_in')): ?>
                <div class="flex items-center gap-3">
                    <span class="rounded-full border border-[var(--border-base)] bg-[var(--bg-btn)] px-4 py-2 text-sm font-semibold uppercase tracking-wide text-[var(--text-on-btn)]">
                        <?= esc(session()->get('user_name')) ?>
                    </span>
                    <a href="<?= base_url('auth/logout') ?>" class="rounded-lg border border-[var(--border-base)] bg-[var(--bg-btn)] px-4 py-2 font-semibold text-[var(--text-on-btn)] hover:bg-[var(--bg-btn-hover)] transition">
                        Logout
                    </a>
                </div>
            <?php else: ?>
                <a href="<?= base_url('login') ?>" class="rounded-lg border border-[var(--border-accent)] bg-[var(--bg-accent)] px-4 py-2 font-semibold text-[var(--text-on-accent)] hover:bg-[var(--bg-accent-hover)] transition">
                    Login
                </a>
            <?php endif; ?>
        </div>
    </div>
</header>
