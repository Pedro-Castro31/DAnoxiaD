<div id="showPersonagemBackdrop" class="invisible fixed inset-0 z-40 grid place-items-start justify-center overflow-y-auto bg-black/60 px-4 py-10 opacity-0 transition-opacity duration-200">
	<div id="showPersonagemPanel" class="w-full max-w-3xl translate-y-3 scale-95 rounded-2xl border border-[var(--border-base)] bg-[var(--bg-modal)] p-6 opacity-0 shadow-2xl transition duration-200">

		<!-- Header -->
		<div class="flex items-start justify-between gap-3">
			<div>
				<p id="sheetCampaign" class="text-[11px] uppercase tracking-[0.25em] text-[var(--text-muted)]">Ficha de Personagem</p>
				<h2 id="sheetName" class="mt-1 font-royal text-3xl text-[var(--text-primary)]">—</h2>
			</div>
			<button id="closeShowPersonagemBtn" type="button"
				class="rounded-md px-2 py-1 text-[var(--text-primary)] transition hover:bg-[var(--bg-btn)] hover:text-[var(--text-on-btn)]" aria-label="Fechar ficha">
				<i class="ri-close-line text-xl" aria-hidden="true"></i>
			</button>
		</div>

		<!-- Identity row -->
		<div class="mt-5 grid gap-3 sm:grid-cols-2 lg:grid-cols-4">
			<div class="rounded-xl border border-[var(--border-base)]/50 bg-[var(--bg-card-alt)]/70 p-3">
				<p class="text-[10px] uppercase tracking-[0.2em] text-[var(--text-muted)]">Classe</p>
				<p id="sheetClass" class="mt-1 font-semibold text-[var(--text-primary)]">—</p>
			</div>
			<div class="rounded-xl border border-[var(--border-base)]/50 bg-[var(--bg-card-alt)]/70 p-3">
				<p class="text-[10px] uppercase tracking-[0.2em] text-[var(--text-muted)]">Raça</p>
				<p id="sheetRace" class="mt-1 font-semibold text-[var(--text-primary)]">—</p>
			</div>
			<div class="rounded-xl border border-[var(--border-base)]/50 bg-[var(--bg-card-alt)]/70 p-3">
				<p class="text-[10px] uppercase tracking-[0.2em] text-[var(--text-muted)]">Nível</p>
				<p id="sheetLevel" class="mt-1 font-semibold text-[var(--text-primary)]">—</p>
			</div>
			<div class="rounded-xl border border-[var(--border-base)]/50 bg-[var(--bg-card-alt)]/70 p-3">
				<p class="text-[10px] uppercase tracking-[0.2em] text-[var(--text-muted)]">Background</p>
				<p id="sheetBackground" class="mt-1 font-semibold text-[var(--text-primary)]">—</p>
			</div>
		</div>

		<div class="mt-3 rounded-xl border border-[var(--border-base)]/50 bg-[var(--bg-card-alt)]/70 p-3">
			<p class="text-[10px] uppercase tracking-[0.2em] text-[var(--text-muted)]">Jogador</p>
			<p id="sheetPlayer" class="mt-1 text-sm text-[var(--text-primary)]">—</p>
		</div>

		<!-- HP -->
		<div class="mt-4 rounded-xl border border-[var(--border-base)]/50 bg-[var(--bg-card-alt)]/70 p-4">
			<div class="mb-2 flex items-center justify-between">
				<p class="text-[10px] font-semibold uppercase tracking-[0.2em] text-[var(--text-muted)]">Pontos de Vida</p>
				<p id="sheetHpText" class="text-sm font-bold text-[var(--text-primary)]">— / —</p>
			</div>
			<div class="h-3 overflow-hidden rounded-full bg-[var(--bg-overlay)]/50">
				<div id="sheetHpBar" class="h-full rounded-full transition-all duration-500" style="width: 0%"></div>
			</div>
		</div>

		<!-- Ability scores — rendered by JS from ABILITY_SCORES_CONFIG -->
		<div class="mt-4">
			<p class="mb-3 text-[10px] font-semibold uppercase tracking-[0.2em] text-[var(--text-muted)]">Atributos</p>
			<div id="sheetAbilityScores" class="grid gap-3" style="grid-template-columns: repeat(auto-fill, minmax(100px, 1fr))"></div>
		</div>

		<!-- Notes -->
		<div id="sheetNotesWrap" class="mt-4 hidden rounded-xl border border-[var(--border-base)]/50 bg-[var(--bg-card-alt)]/70 p-4">
			<p class="text-[10px] uppercase tracking-[0.2em] text-[var(--text-muted)]">Notas</p>
			<p id="sheetNotes" class="mt-2 whitespace-pre-wrap text-sm leading-relaxed text-[var(--text-secondary)]">—</p>
		</div>

		<div class="mt-5 flex justify-end">
			<button type="button" id="closeShowPersonagemFooterBtn"
				class="rounded-lg border border-[var(--border-base)] bg-[var(--bg-btn-secondary)] px-4 py-2 text-sm font-semibold text-[var(--text-primary)] transition hover:bg-[var(--bg-btn-sec-hover)]">
				Fechar
			</button>
		</div>
	</div>
</div>

<script>
	(() => {
		const backdrop   = document.getElementById('showPersonagemBackdrop');
		const panel      = document.getElementById('showPersonagemPanel');
		const closeBtns  = [
			document.getElementById('closeShowPersonagemBtn'),
			document.getElementById('closeShowPersonagemFooterBtn'),
		];

		const sheetName       = document.getElementById('sheetName');
		const sheetCampaign   = document.getElementById('sheetCampaign');
		const sheetClass      = document.getElementById('sheetClass');
		const sheetRace       = document.getElementById('sheetRace');
		const sheetLevel      = document.getElementById('sheetLevel');
		const sheetBackground = document.getElementById('sheetBackground');
		const sheetPlayer     = document.getElementById('sheetPlayer');
		const sheetHpText     = document.getElementById('sheetHpText');
		const sheetHpBar      = document.getElementById('sheetHpBar');
		const sheetAbilities  = document.getElementById('sheetAbilityScores');
		const sheetNotes      = document.getElementById('sheetNotes');
		const sheetNotesWrap  = document.getElementById('sheetNotesWrap');

		if (!backdrop || !panel) return;

		const modifier = (score) => {
			const mod = Math.floor((score - 10) / 2);
			return (mod >= 0 ? '+' : '') + mod;
		};

		const hpColor = (pct) => {
			if (pct > 50) return 'var(--badge-active-text)';
			if (pct > 25) return '#d97706';
			return '#ef4444';
		};

		const open = (article) => {
			const name       = article.dataset.personagemName || '—';
			const player     = article.dataset.personagemPlayer || '—';
			const race       = article.dataset.personagemRace || '—';
			const cls        = article.dataset.personagemClass || '—';
			const level      = article.dataset.personagemLevel || '1';
			const background = article.dataset.personagemBackground || '—';
			const hpCurrent  = parseInt(article.dataset.personagemHpCurrent || '0', 10);
			const hpMax      = parseInt(article.dataset.personagemHpMax || '0', 10);
			const notes      = article.dataset.personagemNotes || '';
			const campaign   = article.dataset.personagemCampaign || '';

			let scores = {};
			try { scores = JSON.parse(article.dataset.personagemScores || '{}'); } catch (_) {}

			sheetName.textContent       = name;
			sheetCampaign.textContent   = campaign ? `Campanha: ${campaign}` : 'Ficha de Personagem';
			sheetClass.textContent      = cls;
			sheetRace.textContent       = race;
			sheetLevel.textContent      = level;
			sheetBackground.textContent = background;
			sheetPlayer.textContent     = player;

			const hpPct = hpMax > 0 ? Math.max(0, Math.min(100, Math.round(hpCurrent / hpMax * 100))) : 0;
			sheetHpText.textContent     = `${hpCurrent} / ${hpMax}`;
			sheetHpBar.style.width      = hpPct + '%';
			sheetHpBar.style.backgroundColor = hpColor(hpPct);

			// Ability score circles
			sheetAbilities.innerHTML = '';
			if (typeof ABILITY_SCORES_CONFIG !== 'undefined') {
				ABILITY_SCORES_CONFIG.forEach(({ key, label }) => {
					const val = parseInt(scores[key] ?? 10, 10);
					const mod = modifier(val);
					sheetAbilities.insertAdjacentHTML('beforeend', `
						<div class="flex flex-col items-center gap-1 rounded-xl border border-[var(--border-base)]/40 bg-[var(--bg-card-alt)]/60 py-3 px-2">
							<span class="text-[10px] font-semibold uppercase tracking-wide text-[var(--text-muted)] text-center leading-tight">${label}</span>
							<div class="flex h-14 w-14 flex-col items-center justify-center rounded-full border-2 border-[var(--border-accent)]/60 bg-[var(--bg-overlay)]/50">
								<span class="text-[11px] font-bold text-[var(--text-secondary)]">${mod}</span>
								<span class="text-xl font-bold leading-none text-[var(--text-primary)]">${val}</span>
							</div>
						</div>
					`);
				});
			}

			if (notes) {
				sheetNotes.textContent = notes;
				sheetNotesWrap.classList.remove('hidden');
			} else {
				sheetNotesWrap.classList.add('hidden');
			}

			backdrop.classList.remove('invisible');
			requestAnimationFrame(() => {
				backdrop.classList.remove('opacity-0');
				panel.classList.remove('translate-y-3', 'scale-95', 'opacity-0');
			});
		};

		const close = () => {
			backdrop.classList.add('opacity-0');
			panel.classList.add('translate-y-3', 'scale-95', 'opacity-0');
			setTimeout(() => backdrop.classList.add('invisible'), 200);
		};

		document.querySelectorAll('[data-open-sheet]').forEach((btn) => {
			btn.addEventListener('click', () => open(btn.closest('article')));
		});

		closeBtns.forEach((btn) => btn && btn.addEventListener('click', close));
		backdrop.addEventListener('click', (e) => { if (e.target === backdrop) close(); });
		document.addEventListener('keydown', (e) => { if (e.key === 'Escape') close(); });
	})();
</script>
