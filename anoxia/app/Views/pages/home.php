<?= $this->extend('app') ?>

<?= $this->section('content') ?>
<?php
$isAdmin         = (bool) session()->get('is_admin');
$userName        = (string) (session()->get('user_name') ?? 'Adventurer');
$totalUsers      = $totalUsers ?? 0;
$activeUsers     = $activeUsers ?? 0;
$totalCampaigns  = $totalCampaigns ?? 0;
$recentCampaigns = $recentCampaigns ?? [];
$defaultImage    = site_url('assets/images/campaign-default.svg');
?>

<div class="flex flex-col gap-6">

    {{-- Hero --}}
    <section class="relative overflow-hidden rounded-3xl border border-[var(--border-base)]/35 bg-[var(--bg-card)]/70 p-8 shadow-[0_14px_34px_rgba(10,6,4,0.35)]">
        <div class="pointer-events-none absolute -right-16 -top-16 h-56 w-56 rounded-full bg-[var(--bg-accent)]/10 blur-3xl"></div>
        <div class="pointer-events-none absolute -left-16 -bottom-16 h-48 w-48 rounded-full bg-[var(--border-accent)]/8 blur-3xl"></div>
        <div class="relative">
            <p class="text-xs uppercase tracking-[0.3em] text-[var(--text-muted)]">Painel Principal</p>
            <h1 class="mt-2 font-royal text-4xl text-[var(--text-primary)]">
                Bem-vindo, <?= esc($userName) ?>
            </h1>
            <p class="mt-2 max-w-2xl text-[var(--text-secondary)]">
                Escolhe o teu destino — gere campanhas, consulta utilizadores ou entra numa aventura.
            </p>
        </div>
    </section>

    {{-- Quick stats --}}
    <section class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
        <article class="rounded-2xl border border-[var(--border-base)]/35 bg-[var(--bg-card-alt)]/75 p-4">
            <div class="flex items-center gap-3">
                <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-[var(--bg-btn)] text-[var(--text-muted)]">
                    <i class="ri-book-2-line text-xl" aria-hidden="true"></i>
                </span>
                <div>
                    <p class="text-xs uppercase tracking-wide text-[var(--text-muted)]">Campanhas</p>
                    <p class="font-royal text-2xl text-[var(--text-primary)]"><?= esc((string) $totalCampaigns) ?></p>
                </div>
            </div>
        </article>
        <article class="rounded-2xl border border-[var(--border-base)]/35 bg-[var(--bg-card-alt)]/75 p-4">
            <div class="flex items-center gap-3">
                <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-[var(--bg-btn)] text-[var(--text-muted)]">
                    <i class="ri-group-line text-xl" aria-hidden="true"></i>
                </span>
                <div>
                    <p class="text-xs uppercase tracking-wide text-[var(--text-muted)]">Utilizadores</p>
                    <p class="font-royal text-2xl text-[var(--text-primary)]"><?= esc((string) $totalUsers) ?></p>
                </div>
            </div>
        </article>
        <article class="rounded-2xl border border-[var(--border-base)]/35 bg-[var(--bg-card-alt)]/75 p-4">
            <div class="flex items-center gap-3">
                <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-[var(--badge-active-bg)] text-[var(--badge-active-text)]">
                    <i class="ri-shield-check-line text-xl" aria-hidden="true"></i>
                </span>
                <div>
                    <p class="text-xs uppercase tracking-wide text-[var(--text-muted)]">Ativos</p>
                    <p class="font-royal text-2xl text-[var(--text-primary)]"><?= esc((string) $activeUsers) ?></p>
                </div>
            </div>
        </article>
        <article class="rounded-2xl border border-[var(--border-base)]/35 bg-[var(--bg-card-alt)]/75 p-4">
            <div class="flex items-center gap-3">
                <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-[var(--bg-btn)] text-[var(--text-muted)]">
                    <i class="ri-sword-line text-xl" aria-hidden="true"></i>
                </span>
                <div>
                    <p class="text-xs uppercase tracking-wide text-[var(--text-muted)]">Personagens</p>
                    <p class="font-royal text-2xl text-[var(--text-primary)]">—</p>
                </div>
            </div>
        </article>
    </section>

    {{-- Navigation cards --}}
    <section class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">

        <a href="<?= base_url('campaigntest') ?>" class="group flex flex-col justify-between rounded-2xl border border-[var(--border-base)]/35 bg-[var(--bg-card-alt)]/80 p-5 shadow-[0_8px_20px_rgba(10,6,4,0.2)] transition duration-200 hover:-translate-y-1 hover:border-[var(--border-accent)]/50 hover:shadow-[0_16px_28px_rgba(10,6,4,0.32)]">
            <div>
                <span class="inline-flex h-11 w-11 items-center justify-center rounded-xl border border-[var(--border-base)]/40 bg-[var(--bg-btn)] text-[var(--text-muted)] transition group-hover:bg-[var(--bg-accent)] group-hover:text-[var(--text-on-accent)]">
                    <i class="ri-book-2-line text-2xl" aria-hidden="true"></i>
                </span>
                <h2 class="mt-4 font-royal text-xl text-[var(--text-primary)]">Campanhas</h2>
                <p class="mt-1 text-sm text-[var(--text-secondary)]">Consulta e gere todas as campanhas activas e inactivas.</p>
            </div>
            <div class="mt-5 flex items-center gap-1 text-xs font-semibold uppercase tracking-wide text-[var(--text-muted)] transition group-hover:text-[var(--text-accent,var(--border-accent))]">
                Abrir <i class="ri-arrow-right-line text-sm" aria-hidden="true"></i>
            </div>
        </a>

        <?php if ($isAdmin): ?>
        <a href="<?= base_url('dashboardtest') ?>" class="group flex flex-col justify-between rounded-2xl border border-[var(--border-base)]/35 bg-[var(--bg-card-alt)]/80 p-5 shadow-[0_8px_20px_rgba(10,6,4,0.2)] transition duration-200 hover:-translate-y-1 hover:border-[var(--border-accent)]/50 hover:shadow-[0_16px_28px_rgba(10,6,4,0.32)]">
            <div>
                <span class="inline-flex h-11 w-11 items-center justify-center rounded-xl border border-[var(--border-base)]/40 bg-[var(--bg-btn)] text-[var(--text-muted)] transition group-hover:bg-[var(--bg-accent)] group-hover:text-[var(--text-on-accent)]">
                    <i class="ri-shield-user-line text-2xl" aria-hidden="true"></i>
                </span>
                <h2 class="mt-4 font-royal text-xl text-[var(--text-primary)]">Utilizadores</h2>
                <p class="mt-1 text-sm text-[var(--text-secondary)]">Cria, edita e gere todas as contas de utilizador.</p>
            </div>
            <div class="mt-5 flex items-center gap-1 text-xs font-semibold uppercase tracking-wide text-[var(--text-muted)] transition group-hover:text-[var(--text-accent,var(--border-accent))]">
                Abrir <i class="ri-arrow-right-line text-sm" aria-hidden="true"></i>
            </div>
        </a>
        <?php endif; ?>

        <a href="<?= base_url('personagens') ?>" class="group flex flex-col justify-between rounded-2xl border border-[var(--border-base)]/35 bg-[var(--bg-card-alt)]/80 p-5 shadow-[0_8px_20px_rgba(10,6,4,0.2)] transition duration-200 hover:-translate-y-1 hover:border-[var(--border-accent)]/50 hover:shadow-[0_16px_28px_rgba(10,6,4,0.32)]">
            <div>
                <span class="inline-flex h-11 w-11 items-center justify-center rounded-xl border border-[var(--border-base)]/40 bg-[var(--bg-btn)] text-[var(--text-muted)] transition group-hover:bg-[var(--bg-accent)] group-hover:text-[var(--text-on-accent)]">
                    <i class="ri-user-star-line text-2xl" aria-hidden="true"></i>
                </span>
                <h2 class="mt-4 font-royal text-xl text-[var(--text-primary)]">Personagens</h2>
                <p class="mt-1 text-sm text-[var(--text-secondary)]">Gere as fichas dos teus personagens.</p>
            </div>
            <div class="mt-5 flex items-center gap-1 text-xs font-semibold uppercase tracking-wide text-[var(--text-muted)] transition group-hover:text-[var(--text-accent,var(--border-accent))]">
                Abrir <i class="ri-arrow-right-line text-sm" aria-hidden="true"></i>
            </div>
        </a>

        <div class="flex flex-col justify-between rounded-2xl border border-dashed border-[var(--border-base)]/30 bg-[var(--bg-card-alt)]/40 p-5">
            <div>
                <span class="inline-flex h-11 w-11 items-center justify-center rounded-xl border border-[var(--border-base)]/30 bg-[var(--bg-input)] text-[var(--text-muted)]/50">
                    <i class="ri-dice-line text-2xl" aria-hidden="true"></i>
                </span>
                <h2 class="mt-4 font-royal text-xl text-[var(--text-primary)]/50">Jogar</h2>
                <p class="mt-1 text-sm text-[var(--text-secondary)]/50">Entra numa sessão activa.</p>
            </div>
            <div class="mt-5 text-xs font-semibold uppercase tracking-wide text-[var(--text-muted)]/40">
                Em breve
            </div>
        </div>

        <div class="flex flex-col justify-between rounded-2xl border border-dashed border-[var(--border-base)]/30 bg-[var(--bg-card-alt)]/40 p-5">
            <div>
                <span class="inline-flex h-11 w-11 items-center justify-center rounded-xl border border-[var(--border-base)]/30 bg-[var(--bg-input)] text-[var(--text-muted)]/50">
                    <i class="ri-map-2-line text-2xl" aria-hidden="true"></i>
                </span>
                <h2 class="mt-4 font-royal text-xl text-[var(--text-primary)]/50">Mapas</h2>
                <p class="mt-1 text-sm text-[var(--text-secondary)]/50">Explora mapas das campanhas.</p>
            </div>
            <div class="mt-5 text-xs font-semibold uppercase tracking-wide text-[var(--text-muted)]/40">
                Em breve
            </div>
        </div>

    </section>

    {{-- Recent campaigns --}}
    <?php if (!empty($recentCampaigns)): ?>
    <section class="rounded-3xl border border-[var(--border-base)]/35 bg-[var(--bg-card)]/70 p-6 shadow-[0_14px_34px_rgba(10,6,4,0.35)]">
        <div class="mb-5 flex items-center justify-between gap-4">
            <h2 class="font-royal text-2xl text-[var(--text-primary)]">Campanhas Recentes</h2>
            <a href="<?= base_url('campaigntest') ?>" class="text-xs font-semibold uppercase tracking-wide text-[var(--text-muted)] transition hover:text-[var(--text-primary)]">
                Ver todas <i class="ri-arrow-right-line" aria-hidden="true"></i>
            </a>
        </div>
        <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
            <?php foreach ($recentCampaigns as $campaign): ?>
                <?php $imgPath = (string) ($campaign->img_path ?? ''); ?>
                <?php $campaignImage = $imgPath !== '' ? site_url('uploads/' . $imgPath) : $defaultImage; ?>
                <?php $isActive = !empty($campaign->is_active); ?>
                <a href="<?= base_url('campaigntest') ?>" class="group block overflow-hidden rounded-xl border border-[var(--border-base)]/35 bg-[var(--bg-card-alt)]/80 transition hover:-translate-y-0.5">
                    <div class="relative w-full overflow-hidden" style="aspect-ratio: 16 / 9;">
                        <img
                            src="<?= esc($campaignImage) ?>"
                            alt="<?= esc((string) ($campaign->name ?? '')) ?>"
                            class="h-full w-full object-cover transition duration-300 group-hover:scale-[1.04]"
                            onerror="this.onerror=null;this.src='<?= esc($defaultImage) ?>';"
                        >
                        <span class="absolute left-2 top-2 rounded-full border px-2 py-0.5 text-[10px] font-semibold uppercase tracking-wide <?= $isActive ? 'border-[var(--badge-active-border)]/70 bg-[var(--badge-active-bg)]/80 text-[var(--badge-active-text)]' : 'border-[var(--badge-inactive-border)]/70 bg-[var(--badge-inactive-bg)]/80 text-[var(--badge-inactive-text)]' ?>">
                            <?= $isActive ? 'Ativa' : 'Inativa' ?>
                        </span>
                    </div>
                    <div class="p-3">
                        <p class="line-clamp-1 font-royal text-base text-[var(--text-primary)]"><?= esc((string) ($campaign->name ?? '')) ?></p>
                        <p class="mt-0.5 text-xs text-[var(--text-muted)]">DM: <?= esc((string) ($campaign->dm_label ?? 'N/A')) ?></p>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>
    </section>
    <?php endif; ?>

</div>
<?= $this->endSection() ?>
