<?= $this->extend('app') ?>

<?= $this->section('content') ?>
<?php
$abilityScores = $abilityScores ?? [];
$errorMsg = session()->getFlashdata('settings_error');
$infoMsg  = session()->getFlashdata('settings_info');
?>

<div class="mx-auto flex max-w-4xl flex-col gap-6">

	<!-- Header -->
	<section class="relative overflow-hidden rounded-3xl border border-[var(--border-base)]/35 bg-[var(--bg-card)]/70 p-6 shadow-[0_16px_40px_rgba(10,6,4,0.4)]">
		<div class="pointer-events-none absolute -right-12 -top-20 h-48 w-48 rounded-full bg-[var(--bg-accent)]/15 blur-2xl"></div>
		<div class="pointer-events-none absolute -left-14 -bottom-16 h-44 w-44 rounded-full bg-[var(--border-accent)]/10 blur-2xl"></div>
		<div class="relative flex flex-wrap items-start justify-between gap-5">
			<div>
				<p class="text-xs uppercase tracking-[0.3em] text-[var(--text-muted)]">Configurações</p>
				<h1 class="mt-2 font-royal text-4xl text-[var(--text-primary)]">Atributos do Personagem</h1>
				<p class="mt-2 max-w-2xl text-[var(--text-secondary)]">
					Define os atributos (<em>ability scores</em>) usados pelas fichas. Podes adicionar,
					remover, reordenar ou renomear livremente — as fichas adaptam-se automaticamente.
				</p>
			</div>
			<a href="<?= base_url('personagens') ?>"
				class="inline-flex items-center gap-2 rounded-xl border border-[var(--border-base)] bg-[var(--bg-btn-secondary)] px-4 py-2 text-sm font-semibold text-[var(--text-primary)] transition hover:bg-[var(--bg-btn-sec-hover)]">
				<i class="ri-arrow-left-line"></i> Voltar
			</a>
		</div>
	</section>

	<?php if ($errorMsg): ?>
		<div class="toast-danger rounded-xl border px-4 py-3 text-sm"><?= esc((string) $errorMsg) ?></div>
	<?php endif; ?>
	<?php if ($infoMsg): ?>
		<div class="toast-success rounded-xl border px-4 py-3 text-sm"><?= esc((string) $infoMsg) ?></div>
	<?php endif; ?>

	<!-- Editor card -->
	<form method="post" action="<?= base_url('settings/character-sheet') ?>"
		class="rounded-2xl border border-[var(--border-base)]/35 bg-[var(--bg-card-alt)]/80 p-6 shadow-[0_8px_20px_rgba(10,6,4,0.24)]">
		<?= csrf_field() ?>

		<div class="mb-4 flex items-center justify-between">
			<div>
				<h2 class="font-royal text-xl text-[var(--text-primary)]">Atributos Actuais</h2>
				<p class="text-xs text-[var(--text-muted)]">Usa as setas para reordenar. O "Código" é o identificador interno — deixa vazio para auto-gerar.</p>
			</div>
			<span id="scoreCount" class="rounded-full border border-[var(--border-base)] bg-[var(--bg-overlay)]/30 px-3 py-1 text-xs font-semibold uppercase tracking-wide text-[var(--text-primary)]">
				<?= count($abilityScores) ?> atributos
			</span>
		</div>

		<!-- Column headers -->
		<div class="mb-2 hidden gap-2 px-1 text-[10px] font-semibold uppercase tracking-[0.15em] text-[var(--text-muted)] md:grid md:grid-cols-[auto_1fr_1.2fr_auto_auto]">
			<span class="w-8 text-center">#</span>
			<span>Código (chave)</span>
			<span>Nome / Label</span>
			<span class="w-16 text-center">Abr.</span>
			<span class="w-24 text-center">Acções</span>
		</div>

		<!-- Dynamic rows container -->
		<div id="scoresContainer" class="flex flex-col gap-2"></div>

		<!-- Empty state -->
		<div id="scoresEmpty" class="hidden rounded-xl border border-dashed border-[var(--border-base)]/40 bg-[var(--bg-overlay)]/30 p-6 text-center text-sm text-[var(--text-muted)]">
			Sem atributos definidos. Clica em "Adicionar" para começar.
		</div>

		<!-- Actions -->
		<div class="mt-5 flex flex-wrap items-center justify-between gap-3 border-t border-[var(--border-base)]/25 pt-4">
			<button type="button" id="addScoreBtn"
				class="inline-flex items-center gap-2 rounded-lg border border-[var(--border-base)] bg-[var(--bg-btn-secondary)] px-4 py-2 text-sm font-semibold text-[var(--text-primary)] transition hover:bg-[var(--bg-btn-sec-hover)]">
				<i class="ri-add-line"></i> Adicionar Atributo
			</button>
			<div class="flex items-center gap-2">
				<button type="button" id="resetDefaultsBtn"
					class="rounded-lg border border-[var(--border-base)] bg-[var(--bg-btn-secondary)] px-3 py-2 text-xs font-semibold text-[var(--text-primary)] transition hover:bg-[var(--bg-btn-sec-hover)]">
					Repor D&D 5e
				</button>
				<button type="submit"
					class="rounded-lg border border-[var(--border-accent)] bg-[var(--bg-accent)] px-5 py-2 text-sm font-semibold text-[var(--text-on-accent)] shadow-[0_6px_16px_rgba(10,6,4,0.25)] transition hover:bg-[var(--bg-accent-hover)]">
					Guardar Alterações
				</button>
			</div>
		</div>

		<p class="mt-4 rounded-lg border border-[var(--border-base)]/25 bg-[var(--bg-overlay)]/30 p-3 text-[11px] leading-relaxed text-[var(--text-muted)]">
			<i class="ri-information-line"></i>
			Remover um atributo não apaga os valores gravados nas fichas — fica apenas oculto.
			Se o voltares a adicionar com o mesmo código, os valores reaparecem.
		</p>
	</form>
</div>

<!-- Row template -->
<template id="scoreRowTemplate">
	<div class="score-row grid grid-cols-1 items-center gap-2 rounded-xl border border-[var(--border-base)]/35 bg-[var(--bg-overlay)]/25 p-3 md:grid-cols-[auto_1fr_1.2fr_auto_auto]">
		<div class="flex items-center gap-1 md:flex-col md:gap-0">
			<span class="row-index inline-flex h-7 w-7 items-center justify-center rounded-full border border-[var(--border-accent)]/50 bg-[var(--bg-accent)]/15 text-xs font-bold text-[var(--text-primary)]">1</span>
			<div class="ml-auto flex gap-0.5 md:ml-0 md:mt-1">
				<button type="button" data-move="up" title="Mover para cima"
					class="rounded border border-[var(--border-base)]/40 bg-[var(--bg-btn-secondary)] px-1.5 py-0.5 text-xs text-[var(--text-primary)] hover:bg-[var(--bg-btn-sec-hover)]">
					<i class="ri-arrow-up-s-line"></i>
				</button>
				<button type="button" data-move="down" title="Mover para baixo"
					class="rounded border border-[var(--border-base)]/40 bg-[var(--bg-btn-secondary)] px-1.5 py-0.5 text-xs text-[var(--text-primary)] hover:bg-[var(--bg-btn-sec-hover)]">
					<i class="ri-arrow-down-s-line"></i>
				</button>
			</div>
		</div>

		<div>
			<label class="mb-0.5 block text-[10px] uppercase tracking-wide text-[var(--text-muted)] md:hidden">Código</label>
			<input type="text" data-field="key" placeholder="auto-gerado"
				class="w-full rounded-lg border border-[var(--border-input)]/40 bg-[var(--bg-input)] px-3 py-2 text-sm text-[var(--text-primary)] placeholder:text-[var(--text-placeholder)] outline-none transition focus:ring-2 focus:ring-[var(--ring-focus)]">
		</div>

		<div>
			<label class="mb-0.5 block text-[10px] uppercase tracking-wide text-[var(--text-muted)] md:hidden">Nome</label>
			<input type="text" data-field="label" required placeholder="ex: Força"
				class="w-full rounded-lg border border-[var(--border-input)]/40 bg-[var(--bg-input)] px-3 py-2 text-sm text-[var(--text-primary)] placeholder:text-[var(--text-placeholder)] outline-none transition focus:ring-2 focus:ring-[var(--ring-focus)]">
		</div>

		<div>
			<label class="mb-0.5 block text-[10px] uppercase tracking-wide text-[var(--text-muted)] md:hidden">Abr.</label>
			<input type="text" data-field="abbr" maxlength="6" placeholder="FOR"
				class="w-16 rounded-lg border border-[var(--border-input)]/40 bg-[var(--bg-input)] px-2 py-2 text-center text-sm font-bold uppercase text-[var(--text-primary)] placeholder:text-[var(--text-placeholder)] outline-none transition focus:ring-2 focus:ring-[var(--ring-focus)]">
		</div>

		<div class="flex justify-end">
			<button type="button" data-remove title="Remover atributo"
				class="inline-flex items-center gap-1 rounded-lg border border-[var(--border-base)]/40 bg-[var(--bg-btn-secondary)] px-2 py-1.5 text-xs font-semibold text-[var(--text-primary)] transition hover:border-red-400/60 hover:text-red-300">
				<i class="ri-delete-bin-line"></i>
			</button>
		</div>
	</div>
</template>

<script>
	(() => {
		const container = document.getElementById('scoresContainer');
		const emptyEl   = document.getElementById('scoresEmpty');
		const tpl       = document.getElementById('scoreRowTemplate');
		const addBtn    = document.getElementById('addScoreBtn');
		const resetBtn  = document.getElementById('resetDefaultsBtn');
		const countEl   = document.getElementById('scoreCount');
		if (!container || !tpl || !addBtn) return;

		const INITIAL = <?= json_encode(array_map(static fn($s) => [
			'key'   => $s->score_key ?? '',
			'label' => $s->label ?? '',
			'abbr'  => $s->abbr ?? '',
		], $abilityScores), JSON_UNESCAPED_UNICODE) ?>;

		const DEFAULTS = [
			{ key: 'strength',     label: 'Força',         abbr: 'FOR' },
			{ key: 'dexterity',    label: 'Destreza',      abbr: 'DES' },
			{ key: 'constitution', label: 'Constituição',  abbr: 'CON' },
			{ key: 'intelligence', label: 'Inteligência',  abbr: 'INT' },
			{ key: 'wisdom',       label: 'Sabedoria',     abbr: 'SAB' },
			{ key: 'charisma',     label: 'Carisma',       abbr: 'CAR' },
		];

		const setInputNames = () => {
			[...container.querySelectorAll('.score-row')].forEach((row, idx) => {
				row.querySelector('[data-field="key"]').name   = `scores[${idx}][key]`;
				row.querySelector('[data-field="label"]').name = `scores[${idx}][label]`;
				row.querySelector('[data-field="abbr"]').name  = `scores[${idx}][abbr]`;
				row.querySelector('.row-index').textContent = idx + 1;
			});
			const total = container.querySelectorAll('.score-row').length;
			countEl.textContent = `${total} ${total === 1 ? 'atributo' : 'atributos'}`;
			emptyEl.classList.toggle('hidden', total > 0);
		};

		const addRow = (data = { key: '', label: '', abbr: '' }) => {
			const frag = tpl.content.cloneNode(true);
			const row  = frag.querySelector('.score-row');

			row.querySelector('[data-field="key"]').value   = data.key || '';
			row.querySelector('[data-field="label"]').value = data.label || '';
			row.querySelector('[data-field="abbr"]').value  = data.abbr || '';

			row.querySelector('[data-remove]').addEventListener('click', () => {
				row.remove();
				setInputNames();
			});

			row.querySelector('[data-move="up"]').addEventListener('click', () => {
				const prev = row.previousElementSibling;
				if (prev) {
					container.insertBefore(row, prev);
					setInputNames();
				}
			});
			row.querySelector('[data-move="down"]').addEventListener('click', () => {
				const next = row.nextElementSibling;
				if (next) {
					container.insertBefore(next, row);
					setInputNames();
				}
			});

			container.appendChild(row);
			setInputNames();
		};

		addBtn.addEventListener('click', () => addRow());

		resetBtn.addEventListener('click', () => {
			if (!confirm('Substituir os atributos actuais pelos 6 atributos D&D 5e por defeito?')) return;
			container.innerHTML = '';
			DEFAULTS.forEach(addRow);
		});

		// Init
		if (INITIAL.length === 0) {
			DEFAULTS.forEach(addRow);
		} else {
			INITIAL.forEach(addRow);
		}
	})();
</script>

<?= $this->endSection() ?>
