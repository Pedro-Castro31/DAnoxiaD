<?= $this->extend('app') ?>

<?= $this->section('content') ?>
<?php
$personagens   = $personagens ?? [];
$campaigns     = $campaigns ?? [];
$abilityScores = $abilityScores ?? [];
?>

<div class="flex flex-col gap-7">

	<!-- Header -->
	<section class="relative overflow-hidden rounded-3xl border border-[var(--border-base)]/35 bg-[var(--bg-card)]/70 p-6 shadow-[0_16px_40px_rgba(10,6,4,0.4)]">
		<div class="pointer-events-none absolute -right-12 -top-20 h-48 w-48 rounded-full bg-[var(--bg-accent)]/15 blur-2xl"></div>
		<div class="pointer-events-none absolute -left-14 -bottom-16 h-44 w-44 rounded-full bg-[var(--border-accent)]/10 blur-2xl"></div>
		<div class="relative flex flex-wrap items-start justify-between gap-5">
			<div>
				<p class="text-xs uppercase tracking-[0.3em] text-[var(--text-muted)]">Personagens</p>
				<h1 class="mt-2 font-royal text-4xl text-[var(--text-primary)]">Fichas de Personagem</h1>
				<p class="mt-2 max-w-2xl text-[var(--text-secondary)]">Cria e consulta as fichas dos teus personagens.</p>
				<div class="mt-4 flex flex-wrap gap-2">
					<span class="rounded-full border border-[var(--border-base)] bg-[var(--bg-card-alt)]/70 px-3 py-1 text-xs font-semibold uppercase tracking-wide text-[var(--text-primary)]">
						Total: <?= esc((string) count($personagens)) ?>
					</span>
				</div>
			</div>
			<button id="openCreatePersonagemBtn" type="button"
				class="rounded-xl border border-[var(--border-accent)] bg-[var(--bg-accent)] px-4 py-2 text-sm font-semibold text-[var(--text-on-accent)] shadow-[0_10px_20px_rgba(10,6,4,0.25)] transition hover:-translate-y-0.5 hover:bg-[var(--bg-accent-hover)]">
				Nova Personagem
			</button>
		</div>
	</section>

	<!-- Character cards grid -->
	<section class="grid gap-5 md:grid-cols-2 xl:grid-cols-3 2xl:grid-cols-4">
		<?php if (!empty($personagens)): ?>
			<?php foreach ($personagens as $p): ?>
				<?php
				$scores = [];
				if (!empty($p->ability_scores)) {
					$decoded = json_decode((string) $p->ability_scores, true);
					$scores = is_array($decoded) ? $decoded : [];
				}
				$hpMax     = (int) ($p->hp_max ?? 0);
				$hpCurrent = (int) ($p->hp_current ?? 0);
				$hpPct     = $hpMax > 0 ? max(0, min(100, (int) round($hpCurrent / $hpMax * 100))) : 0;
				$hpColor   = $hpPct > 50 ? 'var(--badge-active-text)' : ($hpPct > 25 ? '#d97706' : '#ef4444');
				?>
				<article
					class="group flex flex-col rounded-2xl border border-[var(--border-base)]/35 bg-[var(--bg-card-alt)]/80 p-5 shadow-[0_8px_20px_rgba(10,6,4,0.24)] transition duration-200 hover:-translate-y-1 hover:border-[var(--border-base)]/60 hover:shadow-[0_16px_28px_rgba(10,6,4,0.32)]"
					data-personagem-id="<?= esc((string) ($p->id ?? '')) ?>"
					data-personagem-name="<?= esc((string) ($p->character_name ?? '')) ?>"
					data-personagem-player="<?= esc((string) ($p->player_name ?? '')) ?>"
					data-personagem-race="<?= esc((string) ($p->race ?? '')) ?>"
					data-personagem-class="<?= esc((string) ($p->class ?? '')) ?>"
					data-personagem-level="<?= esc((string) ($p->level ?? 1)) ?>"
					data-personagem-background="<?= esc((string) ($p->background ?? '')) ?>"
					data-personagem-hp-current="<?= esc((string) $hpCurrent) ?>"
					data-personagem-hp-max="<?= esc((string) $hpMax) ?>"
					data-personagem-scores="<?= esc(json_encode($scores)) ?>"
					data-personagem-notes="<?= esc((string) ($p->notes ?? '')) ?>"
					data-personagem-campaign="<?= esc((string) ($p->campaign_name ?? '')) ?>"
				>
					<!-- Class badge + level -->
					<div class="flex items-center justify-between">
						<span class="rounded-full border border-[var(--border-accent)]/60 bg-[var(--bg-accent)]/20 px-2.5 py-0.5 text-[10px] font-semibold uppercase tracking-wide text-[var(--text-primary)]">
							<?= esc((string) ($p->class ?? 'Sem Classe')) ?>
						</span>
						<span class="text-xs font-semibold text-[var(--text-muted)]">Nível <?= esc((string) ($p->level ?? 1)) ?></span>
					</div>

					<!-- Name + race -->
					<p class="mt-3 font-royal text-2xl leading-tight text-[var(--text-primary)]"><?= esc((string) ($p->character_name ?? '')) ?></p>
					<p class="mt-0.5 text-xs text-[var(--text-secondary)]">
						<?= esc((string) ($p->race ?? 'Raça desconhecida')) ?>
						<?php if (!empty($p->player_name)): ?>
							· Jogador: <span class="font-semibold"><?= esc((string) $p->player_name) ?></span>
						<?php endif ?>
					</p>

					<!-- HP bar -->
					<div class="mt-4">
						<div class="mb-1 flex items-center justify-between text-[11px] text-[var(--text-muted)]">
							<span>HP</span>
							<span style="color: <?= esc($hpColor) ?>"><?= esc((string) $hpCurrent) ?> / <?= esc((string) $hpMax) ?></span>
						</div>
						<div class="h-2 overflow-hidden rounded-full bg-[var(--bg-overlay)]/50">
							<div class="h-full rounded-full transition-all duration-500"
								style="width: <?= esc((string) $hpPct) ?>%; background-color: <?= esc($hpColor) ?>;"></div>
						</div>
					</div>

					<!-- Ability score mini-badges -->
					<?php if (!empty($abilityScores)): ?>
						<div class="mt-4 flex flex-wrap gap-1.5">
							<?php foreach ($abilityScores as $as): ?>
								<?php
								$val = (int) ($scores[$as['key']] ?? 10);
								$mod = (int) floor(($val - 10) / 2);
								$modStr = ($mod >= 0 ? '+' : '') . $mod;
								?>
								<div class="flex flex-col items-center rounded-lg border border-[var(--border-base)]/40 bg-[var(--bg-overlay)]/40 px-2 py-1 text-center" title="<?= esc($as['label']) ?>">
									<span class="text-[9px] uppercase tracking-wide text-[var(--text-muted)]"><?= esc(substr($as['label'], 0, 3)) ?></span>
									<span class="text-sm font-bold text-[var(--text-primary)]"><?= esc((string) $val) ?></span>
									<span class="text-[10px] text-[var(--text-secondary)]"><?= esc($modStr) ?></span>
								</div>
							<?php endforeach ?>
						</div>
					<?php endif ?>

					<?php if (!empty($p->campaign_name)): ?>
						<p class="mt-3 text-[11px] uppercase tracking-[0.15em] text-[var(--text-muted)]">Campanha: <span class="font-semibold text-[var(--text-primary)]"><?= esc((string) $p->campaign_name) ?></span></p>
					<?php endif ?>

					<button
						type="button"
						class="mt-auto pt-4 inline-flex w-full items-center justify-center rounded-lg border border-[var(--border-base)] bg-[var(--bg-btn)] px-3 py-2 text-sm font-semibold text-[var(--text-on-btn)] transition hover:bg-[var(--bg-btn-hover)]"
						data-open-sheet
					>
						Ver Ficha
					</button>
				</article>
			<?php endforeach ?>
		<?php else: ?>
			<article class="col-span-full rounded-2xl border border-dashed border-[var(--border-base)]/45 bg-[var(--bg-card-alt)]/70 p-10 text-center shadow-[0_8px_20px_rgba(10,6,4,0.2)]">
				<p class="text-sm uppercase tracking-[0.25em] text-[var(--text-muted)]">Sem personagens</p>
				<p class="mt-3 text-sm text-[var(--text-secondary)]">Ainda não existem personagens criados.</p>
				<button id="openCreatePersonagemBtnEmpty" type="button"
					class="mt-5 rounded-xl border border-[var(--border-accent)] bg-[var(--bg-accent)] px-4 py-2 text-sm font-semibold text-[var(--text-on-accent)] transition hover:bg-[var(--bg-accent-hover)]">
					Criar Primeira Personagem
				</button>
			</article>
		<?php endif ?>
	</section>
</div>

<!-- Pass ability score config to JS -->
<script>
	const ABILITY_SCORES_CONFIG = <?= json_encode(array_values($abilityScores), JSON_UNESCAPED_UNICODE) ?>;
</script>

<?php include APPPATH . 'Views/modals/show_personagem.php'; ?>
<?php include APPPATH . 'Views/modals/create_personagem.php'; ?>

<script>
	(() => {
		const emptyBtn = document.getElementById('openCreatePersonagemBtnEmpty');
		const openBtn  = document.getElementById('openCreatePersonagemBtn');
		if (emptyBtn && openBtn) emptyBtn.addEventListener('click', () => openBtn.click());
	})();
</script>

<?= $this->endSection() ?>
