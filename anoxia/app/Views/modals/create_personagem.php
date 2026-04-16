<div id="createPersonagemBackdrop" class="invisible fixed inset-0 z-40 grid place-items-start justify-center overflow-y-auto bg-black/60 px-4 py-10 opacity-0 transition">
	<div class="w-full max-w-2xl rounded-2xl border border-[var(--border-base)] bg-[var(--bg-modal)] p-6 shadow-2xl">
		<div class="flex items-start justify-between gap-3">
			<div>
				<h3 class="font-royal text-2xl text-[var(--text-primary)]">Nova Personagem</h3>
				<p class="mt-1 text-sm text-[var(--text-secondary)]">Preenche a ficha básica do teu personagem.</p>
			</div>
			<button id="closeCreatePersonagemBtn" type="button"
				class="rounded-md px-2 py-1 text-[var(--text-primary)] transition hover:bg-[var(--bg-btn)] hover:text-[var(--text-on-btn)]" aria-label="Fechar">
				<i class="ri-close-line text-xl" aria-hidden="true"></i>
			</button>
		</div>

		<form id="createPersonagemForm" method="post" action="<?= base_url('personagens/create') ?>" class="mt-5 grid gap-5 text-sm">
			<?= csrf_field() ?>

			<!-- Identity -->
			<fieldset class="grid gap-4 rounded-xl border border-[var(--border-base)]/30 p-4 sm:grid-cols-2">
				<legend class="px-1 text-[10px] font-semibold uppercase tracking-widest text-[var(--text-muted)]">Identidade</legend>
				<div class="sm:col-span-2">
					<label class="mb-1 block text-[var(--text-secondary)]">Nome do Personagem <span class="text-red-400">*</span></label>
					<input type="text" name="character_name" required placeholder="Aldric, o Cinzento"
						class="w-full rounded-lg border border-[var(--border-input)]/35 bg-[var(--bg-input)] px-3 py-2 text-[var(--text-primary)] placeholder:text-[var(--text-placeholder)] outline-none transition focus:ring-2 focus:ring-[var(--ring-focus)]">
				</div>
				<div>
					<label class="mb-1 block text-[var(--text-secondary)]">Nome do Jogador</label>
					<input type="text" name="player_name" placeholder="André"
						class="w-full rounded-lg border border-[var(--border-input)]/35 bg-[var(--bg-input)] px-3 py-2 text-[var(--text-primary)] placeholder:text-[var(--text-placeholder)] outline-none transition focus:ring-2 focus:ring-[var(--ring-focus)]">
				</div>
				<div>
					<label class="mb-1 block text-[var(--text-secondary)]">Raça</label>
					<input type="text" name="race" placeholder="Humano, Elfo, Anão…"
						class="w-full rounded-lg border border-[var(--border-input)]/35 bg-[var(--bg-input)] px-3 py-2 text-[var(--text-primary)] placeholder:text-[var(--text-placeholder)] outline-none transition focus:ring-2 focus:ring-[var(--ring-focus)]">
				</div>
				<div>
					<label class="mb-1 block text-[var(--text-secondary)]">Classe</label>
					<input type="text" name="class" placeholder="Guerreiro, Mago, Ladino…"
						class="w-full rounded-lg border border-[var(--border-input)]/35 bg-[var(--bg-input)] px-3 py-2 text-[var(--text-primary)] placeholder:text-[var(--text-placeholder)] outline-none transition focus:ring-2 focus:ring-[var(--ring-focus)]">
				</div>
				<div>
					<label class="mb-1 block text-[var(--text-secondary)]">Nível <span class="text-red-400">*</span></label>
					<input type="number" name="level" value="1" min="1" max="20" required
						class="w-full rounded-lg border border-[var(--border-input)]/35 bg-[var(--bg-input)] px-3 py-2 text-[var(--text-primary)] outline-none transition focus:ring-2 focus:ring-[var(--ring-focus)]">
				</div>
				<div>
					<label class="mb-1 block text-[var(--text-secondary)]">Background</label>
					<input type="text" name="background" placeholder="Soldado, Erudito…"
						class="w-full rounded-lg border border-[var(--border-input)]/35 bg-[var(--bg-input)] px-3 py-2 text-[var(--text-primary)] placeholder:text-[var(--text-placeholder)] outline-none transition focus:ring-2 focus:ring-[var(--ring-focus)]">
				</div>
			</fieldset>

			<!-- HP -->
			<fieldset class="grid gap-4 rounded-xl border border-[var(--border-base)]/30 p-4 sm:grid-cols-2">
				<legend class="px-1 text-[10px] font-semibold uppercase tracking-widest text-[var(--text-muted)]">Pontos de Vida</legend>
				<div>
					<label class="mb-1 block text-[var(--text-secondary)]">HP Atual</label>
					<input type="number" name="hp_current" value="0" min="0"
						class="w-full rounded-lg border border-[var(--border-input)]/35 bg-[var(--bg-input)] px-3 py-2 text-[var(--text-primary)] outline-none transition focus:ring-2 focus:ring-[var(--ring-focus)]">
				</div>
				<div>
					<label class="mb-1 block text-[var(--text-secondary)]">HP Máximo</label>
					<input type="number" name="hp_max" value="0" min="0"
						class="w-full rounded-lg border border-[var(--border-input)]/35 bg-[var(--bg-input)] px-3 py-2 text-[var(--text-primary)] outline-none transition focus:ring-2 focus:ring-[var(--ring-focus)]">
				</div>
			</fieldset>

			<!-- Ability Scores — rendered dynamically from ABILITY_SCORES_CONFIG -->
			<fieldset class="rounded-xl border border-[var(--border-base)]/30 p-4">
				<legend class="px-1 text-[10px] font-semibold uppercase tracking-widest text-[var(--text-muted)]">
					Atributos
					<span class="ml-1 font-normal normal-case text-[var(--text-muted)]/60">(configurável em app/Config/CharacterSheet.php)</span>
				</legend>
				<div id="abilityScoreInputsGrid" class="mt-3 grid gap-3 sm:grid-cols-3"></div>
			</fieldset>

			<!-- Campaign + Notes -->
			<div class="grid gap-4 sm:grid-cols-2">
				<div>
					<label class="mb-1 block text-[var(--text-secondary)]">Campanha (opcional)</label>
					<select name="campaign_id"
						class="w-full rounded-lg border border-[var(--border-input)]/35 bg-[var(--bg-input)] px-3 py-2 text-[var(--text-primary)] outline-none transition focus:ring-2 focus:ring-[var(--ring-focus)]">
						<option value="">— nenhuma —</option>
						<?php foreach (($campaigns ?? []) as $c): ?>
							<option value="<?= esc((string) ($c->id ?? '')) ?>"><?= esc((string) ($c->name ?? '')) ?></option>
						<?php endforeach ?>
					</select>
				</div>
				<div>
					<label class="mb-1 block text-[var(--text-secondary)]">Notas</label>
					<textarea name="notes" rows="3" placeholder="Traços, laços, ideais, falhas…"
						class="w-full rounded-lg border border-[var(--border-input)]/35 bg-[var(--bg-input)] px-3 py-2 text-[var(--text-primary)] placeholder:text-[var(--text-placeholder)] outline-none transition focus:ring-2 focus:ring-[var(--ring-focus)]"></textarea>
				</div>
			</div>

			<div class="flex flex-wrap justify-end gap-2">
				<button id="cancelCreatePersonagemBtn" type="button"
					class="rounded-lg border border-[var(--border-base)] bg-[var(--bg-btn-secondary)] px-3 py-1.5 text-[var(--text-primary)] transition hover:bg-[var(--bg-btn-sec-hover)]">
					Cancelar
				</button>
				<button type="submit"
					class="rounded-lg border border-[var(--border-accent)] bg-[var(--bg-accent)] px-3 py-1.5 font-semibold text-[var(--text-on-accent)] transition hover:bg-[var(--bg-accent-hover)]">
					Criar Personagem
				</button>
			</div>
		</form>
	</div>
</div>

<script>
	(() => {
		// Build ability score inputs from the config passed by the view
		const grid = document.getElementById('abilityScoreInputsGrid');
		if (grid && typeof ABILITY_SCORES_CONFIG !== 'undefined') {
			ABILITY_SCORES_CONFIG.forEach(({ key, label }) => {
				grid.insertAdjacentHTML('beforeend', `
					<div>
						<label class="mb-1 block text-[var(--text-secondary)]">${label}</label>
						<input
							type="number"
							name="ability_${key}"
							value="10"
							min="1"
							max="30"
							class="w-full rounded-lg border border-[var(--border-input)]/35 bg-[var(--bg-input)] px-3 py-2 text-[var(--text-primary)] outline-none transition focus:ring-2 focus:ring-[var(--ring-focus)]"
						>
					</div>
				`);
			});
		}

		const openBtn    = document.getElementById('openCreatePersonagemBtn');
		const closeBtn   = document.getElementById('closeCreatePersonagemBtn');
		const cancelBtn  = document.getElementById('cancelCreatePersonagemBtn');
		const backdrop   = document.getElementById('createPersonagemBackdrop');

		if (!openBtn || !closeBtn || !cancelBtn || !backdrop) return;

		const open = () => {
			backdrop.classList.remove('invisible', 'opacity-0');
		};
		const close = () => {
			backdrop.classList.add('opacity-0');
			setTimeout(() => backdrop.classList.add('invisible'), 150);
		};

		openBtn.addEventListener('click', open);
		closeBtn.addEventListener('click', close);
		cancelBtn.addEventListener('click', close);
		backdrop.addEventListener('click', (e) => { if (e.target === backdrop) close(); });
		document.addEventListener('keydown', (e) => { if (e.key === 'Escape') close(); });
	})();
</script>
