<?= $this->extend('app') ?>

<?= $this->section('content') ?>
<?php
$campaigns = $campaigns ?? [];
?>

<div class="flex flex-col gap-6">
	<section class="rounded-3xl border border-[#8d643d]/35 bg-[#5a3923]/70 p-6 shadow-[0_14px_34px_rgba(10,6,4,0.35)]">
		<div class="flex flex-wrap items-start justify-between gap-4">
			<div>
				<p class="text-xs uppercase tracking-[0.3em] text-[#caa679]">Campanhas</p>
				<h1 class="mt-2 font-royal text-4xl text-[#f6e8cd]">Gerenciamento de Campanhas</h1>
				<p class="mt-2 max-w-2xl text-[#dfc49d]">Revise as histórias ativas e entre em uma campanha com um clique.</p>
			</div>
			<div class="flex flex-wrap gap-2 text-sm">
				<button id="openCreateCampaignBtn" type="button" class="rounded-lg border border-[#d4b07a] bg-[#c89b60] px-4 py-2 font-semibold text-[#2d1c12] transition hover:bg-[#dbb780]">Criar Campanha</button>
			</div>
		</div>
	</section>

	<section class="grid gap-4 md:grid-cols-2 xl:grid-cols-4">
		<?php if (!empty($campaigns)): ?>
			<?php foreach ($campaigns as $campaign): ?>
				<?php $imgPath = (string) ($campaign->img_path ?? ''); ?>
				<?php $isActive = !empty($campaign->is_active); ?>
				<article class="rounded-2xl border border-[#8f6640]/35 bg-[#4a2f1d]/75 p-4">
					<div class="h-40 w-full overflow-hidden rounded-xl border border-[#8f6640]/40 bg-[#2f1d12]/60">
						<?php if ($imgPath !== ''): ?>
							<img src="<?= esc(site_url('uploads/' . $imgPath)) ?>" alt="<?= esc((string) ($campaign->name ?? 'Campaign')) ?>" class="h-full w-full object-cover">
						<?php else: ?>
							<div class="flex h-full w-full items-center justify-center text-xs uppercase tracking-[0.2em] text-[#cfae84]">Image Placeholder</div>
						<?php endif; ?>
					</div>
					<div class="mt-3 flex items-center justify-between">
						<p class="text-xs uppercase tracking-wide text-[#cfae84]">Campanha</p>
						<span class="rounded-full border border-[#8f6640] bg-[#4a2f1d] px-2.5 py-1 text-[10px] font-semibold uppercase tracking-wide text-[#f3e2c7]">
							<?= $isActive ? 'Ativa' : 'Inativa' ?>
						</span>
					</div>
					<p class="mt-2 font-royal text-2xl text-[#f6e8cd]"><?= esc((string) ($campaign->name ?? 'Campaign')) ?></p>
					<p class="mt-2 text-sm text-[#e2c8a3]"><?= esc((string) ($campaign->description ?? '')) ?></p>
					<p class="mt-3 text-xs uppercase tracking-[0.2em] text-[#caa679]">Campanha de: <span class="text-[#f3e2c7]"><?= esc((string) ($campaign->dm_label ?? 'N/A')) ?></span></p>
					<button
						type="button"
						data-campaign-id="<?= esc((string) ($campaign->id ?? '')) ?>"
						data-campaign-name="<?= esc((string) ($campaign->name ?? 'Campaign')) ?>"
						data-campaign-description="<?= esc((string) ($campaign->description ?? '')) ?>"
						data-campaign-image="<?= esc(site_url('uploads/' . $imgPath)) ?>"
						data-campaign-dm="<?= esc((string) ($campaign->dm_label ?? '')) ?>"
						class="mt-4 w-full rounded-md border border-[#8f6640] bg-[#6b4528] px-3 py-2 text-sm font-semibold text-[#f3e2c7] transition hover:bg-[#7e5430]"
						data-show-campaign
					>
						Visualizar
					</button>
				</article>
			<?php endforeach; ?>
		<?php else: ?>
			<article class="rounded-2xl border border-[#8f6640]/35 bg-[#4a2f1d]/75 p-6 text-center text-sm text-[#e2c8a3]">
				Nenhuma campanha encontrada. Clique em "Criar Campanha" para começar uma nova aventura!
			</article>
		<?php endif; ?>
	</section>
</div>

<?php include(APPPATH . 'Views/modals/show_campaign.php'); ?>
<?php include(APPPATH . 'Views/modals/create_campaign.php'); ?>

<?= $this->endSection() ?>
