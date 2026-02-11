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
	<section class="relative overflow-hidden rounded-3xl border border-[#8d643d]/35 bg-[#5a3923]/70 p-6 shadow-[0_16px_40px_rgba(10,6,4,0.4)]">
		<div class="pointer-events-none absolute -right-12 -top-20 h-48 w-48 rounded-full bg-[#c89b60]/15 blur-2xl"></div>
		<div class="pointer-events-none absolute -left-14 -bottom-16 h-44 w-44 rounded-full bg-[#d4b07a]/10 blur-2xl"></div>
		<div class="relative flex flex-wrap items-start justify-between gap-5">
			<div>
				<p class="text-xs uppercase tracking-[0.3em] text-[#caa679]">Campanhas</p>
				<h1 class="mt-2 font-royal text-4xl text-[#f6e8cd]">Gestão de Campanhas</h1>
				<p class="mt-2 max-w-2xl text-[#dfc49d]">Acompanha o estado das campanhas e entra rapidamente na história certa.</p>
				<div class="mt-4 flex flex-wrap gap-2">
					<span class="rounded-full border border-[#8f6640] bg-[#4a2f1d]/70 px-3 py-1 text-xs font-semibold uppercase tracking-wide text-[#f3e2c7]">
						Total: <?= esc((string) $totalCampaigns) ?>
					</span>
					<span class="rounded-full border border-[#6f9b5a]/60 bg-[#2d3d24]/60 px-3 py-1 text-xs font-semibold uppercase tracking-wide text-[#cfe3b0]">
						Ativas (página): <?= esc((string) $activeCampaigns) ?>
					</span>
					<span class="rounded-full border border-[#a36b4f]/60 bg-[#442b1d]/60 px-3 py-1 text-xs font-semibold uppercase tracking-wide text-[#e1bca8]">
						Inativas (página): <?= esc((string) $inactiveCampaigns) ?>
					</span>
				</div>
			</div>
			<div class="flex flex-wrap gap-2 text-sm">
				<button id="openCreateCampaignBtn" type="button" class="rounded-xl border border-[#d4b07a] bg-[#c89b60] px-4 py-2 font-semibold text-[#2d1c12] shadow-[0_10px_20px_rgba(10,6,4,0.25)] transition hover:-translate-y-0.5 hover:bg-[#dbb780]">
					Criar Campanha
				</button>
			</div>
		</div>
	</section>

	<section class="rounded-2xl border border-[#8f6640]/35 bg-[#4a2f1d]/75 p-4 shadow-[0_8px_20px_rgba(10,6,4,0.2)]">
		<form method="get" action="<?= base_url('campaigntest') ?>" class="grid gap-3 md:grid-cols-[1fr_240px_200px_auto_auto]">
			<div>
				<label for="campaign-search" class="mb-1 block text-xs uppercase tracking-[0.2em] text-[#caa679]">Pesquisar</label>
				<input id="campaign-search" type="text" name="q" value="<?= esc($searchValue) ?>" placeholder="Nome ou descrição..." class="w-full rounded-lg border border-[#a87b4f]/35 bg-[#3e2718] px-3 py-2 text-sm text-[#f5e5ca] placeholder:text-[#d0ae80] outline-none transition focus:ring-2 focus:ring-[#d5b078]">
			</div>
			<div>
				<label for="campaign-dm" class="mb-1 block text-xs uppercase tracking-[0.2em] text-[#caa679]">Filtrar por DM</label>
				<select id="campaign-dm" name="dm" class="w-full rounded-lg border border-[#a87b4f]/35 bg-[#3e2718] px-3 py-2 text-sm text-[#f5e5ca] outline-none transition focus:ring-2 focus:ring-[#d5b078]">
					<option value="">Todos</option>
					<?php foreach ($dmOptions as $dmUser): ?>
						<option value="<?= esc((string) ($dmUser->id ?? '')) ?>" <?= $selectedDm === (int) ($dmUser->id ?? 0) ? 'selected' : '' ?>>
							<?= esc((string) ($dmUser->name ?? 'N/A')) ?>
						</option>
					<?php endforeach; ?>
				</select>
			</div>
			<div>
				<label for="campaign-status" class="mb-1 block text-xs uppercase tracking-[0.2em] text-[#caa679]">Estado</label>
				<select id="campaign-status" name="status" class="w-full rounded-lg border border-[#a87b4f]/35 bg-[#3e2718] px-3 py-2 text-sm text-[#f5e5ca] outline-none transition focus:ring-2 focus:ring-[#d5b078]">
					<option value="all" <?= $selectedStatus === 'all' ? 'selected' : '' ?>>Todos</option>
					<option value="active" <?= $selectedStatus === 'active' ? 'selected' : '' ?>>Ativa</option>
					<option value="inactive" <?= $selectedStatus === 'inactive' ? 'selected' : '' ?>>Inativa</option>
				</select>
			</div>
			<div class="flex items-end">
				<button type="submit" class="w-full rounded-lg border border-[#8f6640] bg-[#6b4528] px-4 py-2 text-sm font-semibold text-[#f3e2c7] transition hover:bg-[#7e5430]">
					Aplicar
				</button>
			</div>
			<div class="flex items-end">
				<a href="<?= base_url('campaigntest') ?>" class="w-full rounded-lg border border-[#8f6640] bg-[#5a3924] px-4 py-2 text-center text-sm font-semibold text-[#f3e2c7] transition hover:bg-[#6a432a]">
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
				<article class="group rounded-2xl border border-[#8f6640]/35 bg-[#4a2f1d]/80 p-4 shadow-[0_8px_20px_rgba(10,6,4,0.24)] transition duration-200 hover:-translate-y-1 hover:border-[#b17f53]/60 hover:shadow-[0_16px_28px_rgba(10,6,4,0.32)]">
					<div class="relative w-full overflow-hidden rounded-xl border border-[#8f6640]/40 bg-[#2f1d12]/60" style="aspect-ratio: 16 / 9;">
						<img
							src="<?= esc($campaignImage) ?>"
							alt="<?= esc((string) ($campaign->name ?? 'Campaign')) ?>"
							class="h-full w-full object-cover transition duration-300 group-hover:scale-[1.03]"
							onerror="this.onerror=null;this.src='<?= esc($defaultCampaignImage) ?>';"
						>
						<div class="pointer-events-none absolute inset-x-0 bottom-0 h-16 bg-gradient-to-t from-[#1f120b]/70 to-transparent"></div>
						<span class="absolute left-3 top-3 rounded-full border px-2.5 py-1 text-[10px] font-semibold uppercase tracking-wide <?= $isActive ? 'border-[#6f9b5a]/70 bg-[#2d3d24]/80 text-[#d6e9bc]' : 'border-[#a36b4f]/70 bg-[#442b1d]/80 text-[#e6bda8]' ?>">
							<?= $campaignStatusLabel ?>
						</span>
					</div>
					<div class="mt-3 flex items-center justify-between">
						<p class="text-xs uppercase tracking-[0.2em] text-[#cfae84]">Campanha</p>
						<p class="text-[11px] uppercase tracking-wide text-[#d7b183]">#<?= esc((string) ($campaign->id ?? '')) ?></p>
					</div>
					<p class="mt-2 line-clamp-1 font-royal text-2xl text-[#f6e8cd]"><?= esc((string) ($campaign->name ?? 'Campaign')) ?></p>
					<p class="mt-2 min-h-[42px] line-clamp-2 text-sm leading-relaxed text-[#e2c8a3]"><?= esc((string) ($campaign->description ?? '')) ?></p>
					<p class="mt-3 text-xs uppercase tracking-[0.2em] text-[#caa679]">DM: <span class="font-semibold text-[#f3e2c7]"><?= esc((string) ($campaign->dm_label ?? 'N/A')) ?></span></p>
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
						class="mt-4 inline-flex w-full items-center justify-center rounded-lg border border-[#8f6640] bg-[#6b4528] px-3 py-2 text-sm font-semibold text-[#f3e2c7] transition hover:bg-[#7e5430]"
						data-show-campaign
					>
						Visualizar
					</button>
				</article>
			<?php endforeach; ?>
		<?php else: ?>
			<article class="rounded-2xl border border-dashed border-[#8f6640]/45 bg-[#4a2f1d]/70 p-8 text-center shadow-[0_8px_20px_rgba(10,6,4,0.2)]">
				<p class="text-sm uppercase tracking-[0.25em] text-[#caa679]">Sem campanhas</p>
				<p class="mt-3 text-sm text-[#e2c8a3]">Não foram encontradas campanhas com os filtros atuais.</p>
				<button id="openCreateCampaignBtnEmpty" type="button" class="mt-5 rounded-xl border border-[#d4b07a] bg-[#c89b60] px-4 py-2 text-sm font-semibold text-[#2d1c12] transition hover:bg-[#dbb780]">
					Criar Primeira Campanha
				</button>
			</article>
		<?php endif; ?>
	</section>

	<?php if ($totalPages > 1): ?>
		<section class="flex flex-wrap items-center justify-between gap-3 rounded-2xl border border-[#8f6640]/35 bg-[#4a2f1d]/75 p-4">
			<p class="text-xs uppercase tracking-[0.2em] text-[#caa679]">
				Página <?= esc((string) $currentPage) ?> de <?= esc((string) $totalPages) ?> (<?= esc((string) $totalCampaignRecords) ?> resultados)
			</p>
			<div class="flex items-center gap-2 text-sm">
				<?php
				$prevPage = max(1, $currentPage - 1);
				$nextPage = min($totalPages, $currentPage + 1);
				$prevQuery = http_build_query(array_filter($baseQuery + ['page' => $prevPage], static fn($v) => $v !== null && $v !== ''));
				$nextQuery = http_build_query(array_filter($baseQuery + ['page' => $nextPage], static fn($v) => $v !== null && $v !== ''));
				?>
				<a href="<?= base_url('campaigntest' . ($prevQuery ? '?' . $prevQuery : '')) ?>" class="rounded-lg border border-[#8f6640] bg-[#5a3924] px-3 py-1.5 text-[#f3e2c7] <?= $currentPage <= 1 ? 'pointer-events-none opacity-50' : 'hover:bg-[#6a432a]' ?>">
					Anterior
				</a>
				<?php
				$startPage = max(1, $currentPage - 2);
				$endPage = min($totalPages, $currentPage + 2);
				?>
				<?php for ($i = $startPage; $i <= $endPage; $i++): ?>
					<?php $pageQuery = http_build_query(array_filter($baseQuery + ['page' => $i], static fn($v) => $v !== null && $v !== '')); ?>
					<a href="<?= base_url('campaigntest' . ($pageQuery ? '?' . $pageQuery : '')) ?>" class="rounded-lg border px-3 py-1.5 <?= $i === $currentPage ? 'border-[#d4b07a] bg-[#c89b60] text-[#2d1c12] font-semibold' : 'border-[#8f6640] bg-[#5a3924] text-[#f3e2c7] hover:bg-[#6a432a]' ?>">
						<?= esc((string) $i) ?>
					</a>
				<?php endfor; ?>
				<a href="<?= base_url('campaigntest' . ($nextQuery ? '?' . $nextQuery : '')) ?>" class="rounded-lg border border-[#8f6640] bg-[#5a3924] px-3 py-1.5 text-[#f3e2c7] <?= $currentPage >= $totalPages ? 'pointer-events-none opacity-50' : 'hover:bg-[#6a432a]' ?>">
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
