<?= $this->extend('app') ?>

<?= $this->section('content') ?>
<?php
$campaigns = $campaigns ?? [];
$dmOptions = $dm_options ?? [];
$filters = $filters ?? ['q' => '', 'dm' => null, 'status' => 'all'];
$pagination = $pagination ?? ['current_page' => 1, 'per_page' => 8, 'total' => count($campaigns), 'total_pages' => 1];

$searchValue = (string) ($filters['q'] ?? '');
$selectedDm = isset($filters['dm']) ? (int) $filters['dm'] : 0;
$selectedStatus = (string) ($filters['status'] ?? 'all');
$currentPage = (int) ($pagination['current_page'] ?? 1);
$totalPages = max(1, (int) ($pagination['total_pages'] ?? 1));
$totalCampaignRecords = (int) ($pagination['total'] ?? count($campaigns));

$defaultCampaignImage = site_url('assets/images/campaign-default.svg');
$totalCampaigns = $totalCampaignRecords;
$activeCampaigns = 0;
foreach ($campaigns as $campaignCounter) {
	$activeCampaigns += !empty($campaignCounter->is_active) ? 1 : 0;
}
$inactiveCampaigns = max(0, count($campaigns) - $activeCampaigns);
$baseQuery = [
	'q' => $searchValue,
	'dm' => $selectedDm > 0 ? $selectedDm : null,
	'status' => $selectedStatus,
];
?>

<div class="flex flex-col gap-7">
	<section class="relative overflow-hidden rounded-3xl border border-[var(--border-base)]/35 bg-[var(--bg-card)]/70 p-6 shadow-[0_16px_40px_rgba(10,6,4,0.4)]">
		<div class="pointer-events-none absolute -right-12 -top-20 h-48 w-48 rounded-full bg-[var(--bg-accent)]/15 blur-2xl"></div>
		<div class="pointer-events-none absolute -left-14 -bottom-16 h-44 w-44 rounded-full bg-[var(--border-accent)]/10 blur-2xl"></div>
		<div class="relative flex flex-wrap items-start justify-between gap-5">
			<div>
				<p class="text-xs uppercase tracking-[0.3em] text-[var(--text-muted)]">Campanhas</p>
				<h1 class="mt-2 font-royal text-4xl text-[var(--text-primary)]">Gestão de Campanhas</h1>
				<p class="mt-2 max-w-2xl text-[var(--text-secondary)]">Acompanha o estado das campanhas e entra rapidamente na história certa.</p>
				<div class="mt-4 flex flex-wrap gap-2">
					<span class="rounded-full border border-[var(--border-base)] bg-[var(--bg-card-alt)]/70 px-3 py-1 text-xs font-semibold uppercase tracking-wide text-[var(--text-primary)]">
						Total: <?= esc((string) $totalCampaigns) ?>
					</span>
					<span class="rounded-full border border-[var(--badge-active-border)]/60 bg-[var(--badge-active-bg)]/60 px-3 py-1 text-xs font-semibold uppercase tracking-wide text-[var(--badge-active-text)]">
						Ativas (página): <?= esc((string) $activeCampaigns) ?>
					</span>
					<span class="rounded-full border border-[var(--badge-inactive-border)]/60 bg-[var(--badge-inactive-bg)]/60 px-3 py-1 text-xs font-semibold uppercase tracking-wide text-[var(--badge-inactive-text)]">
						Inativas (página): <?= esc((string) $inactiveCampaigns) ?>
					</span>
				</div>
			</div>
			<div class="flex flex-wrap gap-2 text-sm">
				<button id="openCreateCampaignBtn" type="button" class="rounded-xl border border-[var(--border-accent)] bg-[var(--bg-accent)] px-4 py-2 font-semibold text-[var(--text-on-accent)] shadow-[0_10px_20px_rgba(10,6,4,0.25)] transition hover:-translate-y-0.5 hover:bg-[var(--bg-accent-hover)]">
					Criar Campanha
				</button>
			</div>
		</div>
	</section>

	<section class="rounded-2xl border border-[var(--border-base)]/35 bg-[var(--bg-card-alt)]/75 p-4 shadow-[0_8px_20px_rgba(10,6,4,0.2)]">
		<form method="get" action="<?= base_url('campaigntest') ?>" class="grid gap-3 md:grid-cols-[1fr_240px_200px_auto_auto]">
			<div>
				<label for="campaign-search" class="mb-1 block text-xs uppercase tracking-[0.2em] text-[var(--text-muted)]">Pesquisar</label>
				<input id="campaign-search" type="text" name="q" value="<?= esc($searchValue) ?>" placeholder="Nome ou descrição..." class="w-full rounded-lg border border-[var(--border-input)]/35 bg-[var(--bg-input)] px-3 py-2 text-sm text-[var(--text-primary)] placeholder:text-[var(--text-placeholder)] outline-none transition focus:ring-2 focus:ring-[var(--ring-focus)]">
			</div>
			<div>
				<label for="campaign-dm" class="mb-1 block text-xs uppercase tracking-[0.2em] text-[var(--text-muted)]">Filtrar por DM</label>
				<select id="campaign-dm" name="dm" class="w-full rounded-lg border border-[var(--border-input)]/35 bg-[var(--bg-input)] px-3 py-2 text-sm text-[var(--text-primary)] outline-none transition focus:ring-2 focus:ring-[var(--ring-focus)]">
					<option value="">Todos</option>
					<?php foreach ($dmOptions as $dmUser): ?>
						<option value="<?= esc((string) ($dmUser->id ?? '')) ?>" <?= $selectedDm === (int) ($dmUser->id ?? 0) ? 'selected' : '' ?>>
							<?= esc((string) ($dmUser->name ?? 'N/A')) ?>
						</option>
					<?php endforeach; ?>
				</select>
			</div>
			<div>
				<label for="campaign-status" class="mb-1 block text-xs uppercase tracking-[0.2em] text-[var(--text-muted)]">Estado</label>
				<select id="campaign-status" name="status" class="w-full rounded-lg border border-[var(--border-input)]/35 bg-[var(--bg-input)] px-3 py-2 text-sm text-[var(--text-primary)] outline-none transition focus:ring-2 focus:ring-[var(--ring-focus)]">
					<option value="all" <?= $selectedStatus === 'all' ? 'selected' : '' ?>>Todos</option>
					<option value="active" <?= $selectedStatus === 'active' ? 'selected' : '' ?>>Ativa</option>
					<option value="inactive" <?= $selectedStatus === 'inactive' ? 'selected' : '' ?>>Inativa</option>
				</select>
			</div>
			<div class="flex items-end">
				<button type="submit" class="w-full rounded-lg border border-[var(--border-base)] bg-[var(--bg-btn)] px-4 py-2 text-sm font-semibold text-[var(--text-on-btn)] transition hover:bg-[var(--bg-btn-hover)]">
					Aplicar
				</button>
			</div>
			<div class="flex items-end">
				<a href="<?= base_url('campaigntest') ?>" class="w-full rounded-lg border border-[var(--border-base)] bg-[var(--bg-btn-secondary)] px-4 py-2 text-center text-sm font-semibold text-[var(--text-primary)] transition hover:bg-[var(--bg-btn-sec-hover)]">
					Limpar
				</a>
			</div>
		</form>
	</section>

	<section class="grid gap-5 md:grid-cols-2 xl:grid-cols-3 2xl:grid-cols-4">
		<?php if (!empty($campaigns)): ?>
			<?php foreach ($campaigns as $campaign): ?>
				<?php $imgPath = (string) ($campaign->img_path ?? ''); ?>
				<?php $campaignImage = $imgPath !== '' ? site_url('uploads/' . $imgPath) : $defaultCampaignImage; ?>
				<?php $isActive = !empty($campaign->is_active); ?>
				<?php $campaignStatusLabel = $isActive ? 'Ativa' : 'Inativa'; ?>
				<article class="group rounded-2xl border border-[var(--border-base)]/35 bg-[var(--bg-card-alt)]/80 p-4 shadow-[0_8px_20px_rgba(10,6,4,0.24)] transition duration-200 hover:-translate-y-1 hover:border-[var(--border-base)]/60 hover:shadow-[0_16px_28px_rgba(10,6,4,0.32)]">
					<div class="relative w-full overflow-hidden rounded-xl border border-[var(--border-base)]/40 bg-[var(--bg-overlay)]/60" style="aspect-ratio: 16 / 9;">
						<img
							src="<?= esc($campaignImage) ?>"
							alt="<?= esc((string) ($campaign->name ?? 'Campaign')) ?>"
							class="h-full w-full object-cover transition duration-300 group-hover:scale-[1.03]"
							onerror="this.onerror=null;this.src='<?= esc($defaultCampaignImage) ?>';"
						>
						<div class="pointer-events-none absolute inset-x-0 bottom-0 h-16 bg-gradient-to-t from-[var(--bg-overlay)]/70 to-transparent"></div>
						<span class="absolute left-3 top-3 rounded-full border px-2.5 py-1 text-[10px] font-semibold uppercase tracking-wide <?= $isActive ? 'border-[var(--badge-active-border)]/70 bg-[var(--badge-active-bg)]/80 text-[var(--badge-active-text)]' : 'border-[var(--badge-inactive-border)]/70 bg-[var(--badge-inactive-bg)]/80 text-[var(--badge-inactive-text)]' ?>">
							<?= $campaignStatusLabel ?>
						</span>
					</div>
					<div class="mt-3 flex items-center justify-between">
						<p class="text-xs uppercase tracking-[0.2em] text-[var(--text-muted)]">Campanha</p>
						<p class="text-[11px] uppercase tracking-wide text-[var(--text-secondary)]">#<?= esc((string) ($campaign->id ?? '')) ?></p>
					</div>
					<p class="mt-2 line-clamp-1 font-royal text-2xl text-[var(--text-primary)]"><?= esc((string) ($campaign->name ?? 'Campaign')) ?></p>
					<p class="mt-2 min-h-[42px] line-clamp-2 text-sm leading-relaxed text-[var(--text-secondary)]"><?= esc((string) ($campaign->description ?? '')) ?></p>
					<p class="mt-3 text-xs uppercase tracking-[0.2em] text-[var(--text-muted)]">DM: <span class="font-semibold text-[var(--text-primary)]"><?= esc((string) ($campaign->dm_label ?? 'N/A')) ?></span></p>
					<button
						type="button"
						data-campaign-id="<?= esc((string) ($campaign->id ?? '')) ?>"
						data-campaign-name="<?= esc((string) ($campaign->name ?? 'Campaign')) ?>"
						data-campaign-description="<?= esc((string) ($campaign->description ?? '')) ?>"
						data-campaign-image="<?= esc($campaignImage) ?>"
						data-campaign-image-fallback="<?= esc($defaultCampaignImage) ?>"
						data-campaign-dm="<?= esc((string) ($campaign->dm_label ?? '')) ?>"
						data-campaign-status="<?= esc($campaignStatusLabel) ?>"
						data-campaign-img-path="<?= esc($imgPath !== '' ? $imgPath : '-') ?>"
						class="mt-4 inline-flex w-full items-center justify-center rounded-lg border border-[var(--border-base)] bg-[var(--bg-btn)] px-3 py-2 text-sm font-semibold text-[var(--text-on-btn)] transition hover:bg-[var(--bg-btn-hover)]"
						data-show-campaign
					>
						Visualizar
					</button>
				</article>
			<?php endforeach; ?>
		<?php else: ?>
			<article class="rounded-2xl border border-dashed border-[var(--border-base)]/45 bg-[var(--bg-card-alt)]/70 p-8 text-center shadow-[0_8px_20px_rgba(10,6,4,0.2)]">
				<p class="text-sm uppercase tracking-[0.25em] text-[var(--text-muted)]">Sem campanhas</p>
				<p class="mt-3 text-sm text-[var(--text-secondary)]">Não foram encontradas campanhas com os filtros atuais.</p>
				<button id="openCreateCampaignBtnEmpty" type="button" class="mt-5 rounded-xl border border-[var(--border-accent)] bg-[var(--bg-accent)] px-4 py-2 text-sm font-semibold text-[var(--text-on-accent)] transition hover:bg-[var(--bg-accent-hover)]">
					Criar Primeira Campanha
				</button>
			</article>
		<?php endif; ?>
	</section>

	<?php if ($totalPages > 1): ?>
		<section class="flex flex-wrap items-center justify-between gap-3 rounded-2xl border border-[var(--border-base)]/35 bg-[var(--bg-card-alt)]/75 p-4">
			<p class="text-xs uppercase tracking-[0.2em] text-[var(--text-muted)]">
				Página <?= esc((string) $currentPage) ?> de <?= esc((string) $totalPages) ?> (<?= esc((string) $totalCampaignRecords) ?> resultados)
			</p>
			<div class="flex items-center gap-2 text-sm">
				<?php
				$prevPage = max(1, $currentPage - 1);
				$nextPage = min($totalPages, $currentPage + 1);
				$prevQuery = http_build_query(array_filter($baseQuery + ['page' => $prevPage], static fn($v) => $v !== null && $v !== ''));
				$nextQuery = http_build_query(array_filter($baseQuery + ['page' => $nextPage], static fn($v) => $v !== null && $v !== ''));
				?>
				<a href="<?= base_url('campaigntest' . ($prevQuery ? '?' . $prevQuery : '')) ?>" class="rounded-lg border border-[var(--border-base)] bg-[var(--bg-btn-secondary)] px-3 py-1.5 text-[var(--text-primary)] <?= $currentPage <= 1 ? 'pointer-events-none opacity-50' : 'hover:bg-[var(--bg-btn-sec-hover)]' ?>">
					Anterior
				</a>
				<?php
				$startPage = max(1, $currentPage - 2);
				$endPage = min($totalPages, $currentPage + 2);
				?>
				<?php for ($i = $startPage; $i <= $endPage; $i++): ?>
					<?php $pageQuery = http_build_query(array_filter($baseQuery + ['page' => $i], static fn($v) => $v !== null && $v !== '')); ?>
					<a href="<?= base_url('campaigntest' . ($pageQuery ? '?' . $pageQuery : '')) ?>" class="rounded-lg border px-3 py-1.5 <?= $i === $currentPage ? 'border-[var(--border-accent)] bg-[var(--bg-accent)] text-[var(--text-on-accent)] font-semibold' : 'border-[var(--border-base)] bg-[var(--bg-btn-secondary)] text-[var(--text-primary)] hover:bg-[var(--bg-btn-sec-hover)]' ?>">
						<?= esc((string) $i) ?>
					</a>
				<?php endfor; ?>
				<a href="<?= base_url('campaigntest' . ($nextQuery ? '?' . $nextQuery : '')) ?>" class="rounded-lg border border-[var(--border-base)] bg-[var(--bg-btn-secondary)] px-3 py-1.5 text-[var(--text-primary)] <?= $currentPage >= $totalPages ? 'pointer-events-none opacity-50' : 'hover:bg-[var(--bg-btn-sec-hover)]' ?>">
					Próxima
				</a>
			</div>
		</section>
	<?php endif; ?>
</div>

<?php include(APPPATH . 'Views/modals/show_campaign.php'); ?>
<?php include(APPPATH . 'Views/modals/create_campaign.php'); ?>

<script>
	(() => {
		const openBtn = document.getElementById('openCreateCampaignBtn');
		const openBtnEmpty = document.getElementById('openCreateCampaignBtnEmpty');
		if (!openBtn || !openBtnEmpty) return;
		openBtnEmpty.addEventListener('click', () => openBtn.click());
	})();
</script>

<?= $this->endSection() ?>
