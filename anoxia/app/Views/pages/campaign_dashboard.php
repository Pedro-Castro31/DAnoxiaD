<?= $this->extend('app') ?>

<?= $this->section('content') ?>
<?php
$campaigns = $campaigns ?? [];
?>

<div class="flex flex-col gap-6">
	<section class="rounded-3xl border border-[#8d643d]/35 bg-[#5a3923]/70 p-6 shadow-[0_14px_34px_rgba(10,6,4,0.35)]">
		<div class="flex flex-wrap items-start justify-between gap-4">
			<div>
				<p class="text-xs uppercase tracking-[0.3em] text-[#caa679]">Campaigns</p>
				<h1 class="mt-2 font-royal text-4xl text-[#f6e8cd]">Campaign Management</h1>
				<p class="mt-2 max-w-2xl text-[#dfc49d]">Review active storylines and jump into a campaign with one click.</p>
			</div>
			<div class="flex flex-wrap gap-2 text-sm">
				<button id="openCreateCampaignBtn" type="button" class="rounded-lg border border-[#d4b07a] bg-[#c89b60] px-4 py-2 font-semibold text-[#2d1c12] transition hover:bg-[#dbb780]">Create Campaign</button>
			</div>
		</div>
	</section>

	<section class="grid gap-4 md:grid-cols-2 xl:grid-cols-4">
		<?php if (!empty($campaigns)): ?>
			<?php foreach ($campaigns as $campaign): ?>
				<article class="rounded-2xl border border-[#8f6640]/35 bg-[#4a2f1d]/75 p-4">
					<p class="text-xs uppercase tracking-wide text-[#cfae84]">Campaign</p>
					<p class="mt-2 font-royal text-2xl text-[#f6e8cd]"><?= esc((string) ($campaign->name ?? 'Campaign')) ?></p>
					<p class="mt-2 text-sm text-[#e2c8a3]"><?= esc((string) ($campaign->description ?? '')) ?></p>
					<button
						type="button"
						class="mt-4 w-full rounded-md border border-[#8f6640] bg-[#6b4528] px-3 py-2 text-sm font-semibold text-[#f3e2c7] transition hover:bg-[#7e5430]"
					>
						Visualizar
					</button>
				</article>
			<?php endforeach; ?>
		<?php else: ?>
			<article class="rounded-2xl border border-[#8f6640]/35 bg-[#4a2f1d]/75 p-6 text-center text-sm text-[#e2c8a3]">
				No campaigns found. Create the first one to get started.
			</article>
		<?php endif; ?>
	</section>
</div>

<?php include(APPPATH . 'Views/modals/create_campaign.php'); ?>

<?= $this->endSection() ?>
