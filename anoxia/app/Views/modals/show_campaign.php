<div id="showCampaignBackdrop" class="invisible fixed inset-0 z-40 grid place-items-center bg-black/60 opacity-0 transition-opacity duration-200">
	<div id="showCampaignPanel" class="w-[94vw] max-w-4xl translate-y-3 scale-95 rounded-2xl border border-[var(--border-base)] bg-[var(--bg-modal)] p-6 opacity-0 shadow-2xl transition duration-200">
		<div class="flex items-start justify-between gap-3">
			<div>
				<p class="text-xs uppercase tracking-[0.25em] text-[var(--text-muted)]">Detalhes da Campanha</p>
				<h3 id="showCampaignTitle" class="mt-2 font-royal text-3xl text-[var(--text-primary)]">Campaign Title</h3>
			</div>
			<button id="closeShowCampaignBtn" class="rounded-md px-2 py-1 text-[var(--text-primary)] transition hover:bg-[var(--bg-btn)] hover:text-[var(--text-on-btn)]" type="button" aria-label="Fechar detalhes">
				<i class="ri-close-line text-xl" aria-hidden="true"></i>
			</button>
		</div>

		<div class="mt-5 grid gap-4 md:grid-cols-[260px_1fr]">
			<div class="w-full overflow-hidden rounded-2xl border border-dashed border-[var(--border-base)] bg-[var(--bg-overlay)]/60 shadow-[0_10px_20px_rgba(10,6,4,0.25)]" style="aspect-ratio: 16 / 9;">
				<img id="showCampaignImage" src="<?= esc(site_url('assets/images/campaign-default.svg')) ?>" alt="Campaign image" class="h-full w-full object-cover">
			</div>
			<div>
				<div class="grid gap-2 sm:grid-cols-2">
					<div class="rounded-xl border border-[var(--border-base)]/50 bg-[var(--bg-card-alt)]/70 p-3">
						<p class="text-[11px] uppercase tracking-[0.2em] text-[var(--text-muted)]">ID</p>
						<p id="showCampaignId" class="mt-1 text-sm font-semibold text-[var(--text-primary)]">-</p>
					</div>
					<div class="rounded-xl border border-[var(--border-base)]/50 bg-[var(--bg-card-alt)]/70 p-3">
						<p class="text-[11px] uppercase tracking-[0.2em] text-[var(--text-muted)]">Estado</p>
						<p id="showCampaignStatus" class="mt-1 text-sm font-semibold text-[var(--text-primary)]">-</p>
					</div>
				</div>
				<div class="mt-3 rounded-xl border border-[var(--border-base)]/50 bg-[var(--bg-card-alt)]/70 p-3">
					<p class="text-[11px] uppercase tracking-[0.2em] text-[var(--text-muted)]">DM</p>
					<p id="showCampaignDm" class="mt-1 text-sm font-semibold text-[var(--text-primary)]">-</p>
				</div>
				<div class="mt-3 rounded-xl border border-[var(--border-base)]/50 bg-[var(--bg-card-alt)]/70 p-3">
					<p class="text-[11px] uppercase tracking-[0.2em] text-[var(--text-muted)]">Imagem (path)</p>
					<p id="showCampaignImgPath" class="mt-1 truncate text-sm text-[var(--text-primary)]">-</p>
				</div>
			</div>
		</div>

		<div class="mt-4 rounded-xl border border-[var(--border-base)]/50 bg-[var(--bg-card-alt)]/70 p-4">
			<p class="text-[11px] uppercase tracking-[0.2em] text-[var(--text-muted)]">Descrição</p>
			<p id="showCampaignDescription" class="mt-2 text-sm leading-relaxed text-[var(--text-secondary)]">Campaign description goes here.</p>
		</div>

		<div class="mt-5 flex flex-wrap justify-end gap-2 text-sm">
			<button type="button" class="rounded-lg border border-[var(--border-base)] bg-[var(--bg-btn-secondary)] px-3 py-1.5 text-[var(--text-primary)] transition hover:bg-[var(--bg-btn-sec-hover)]">Editar</button>
			<button type="button" class="rounded-lg border border-[var(--border-base)] bg-[var(--bg-btn-secondary)] px-3 py-1.5 text-[var(--text-primary)] transition hover:bg-[var(--bg-btn-sec-hover)]">Jogadores</button>
			<button type="button" class="rounded-lg border border-[var(--border-accent)] bg-[var(--bg-accent)] px-3 py-1.5 font-semibold text-[var(--text-on-accent)] transition hover:bg-[var(--bg-accent-hover)]">Jogar</button>
		</div>
	</div>
</div>

<script>
	(() => {
		const backdrop = document.getElementById('showCampaignBackdrop');
		const panel = document.getElementById('showCampaignPanel');
		const closeBtn = document.getElementById('closeShowCampaignBtn');
		const titleEl = document.getElementById('showCampaignTitle');
		const descEl = document.getElementById('showCampaignDescription');
		const imageEl = document.getElementById('showCampaignImage');
		const idEl = document.getElementById('showCampaignId');
		const statusEl = document.getElementById('showCampaignStatus');
		const dmEl = document.getElementById('showCampaignDm');
		const imgPathEl = document.getElementById('showCampaignImgPath');
		const triggers = document.querySelectorAll('[data-show-campaign]');

		if (!backdrop || !panel || !closeBtn || !titleEl || !descEl || !imageEl || !idEl || !statusEl || !dmEl || !imgPathEl || !triggers.length) return;

		const open = (trigger) => {
			const name = trigger.dataset.campaignName || 'Campaign';
			const description = trigger.dataset.campaignDescription || '';
			const fallbackImage = trigger.dataset.campaignImageFallback || '<?= esc(site_url('assets/images/campaign-default.svg')) ?>';
			const campaignImage = trigger.dataset.campaignImage || fallbackImage;
			const campaignId = trigger.dataset.campaignId || '-';
			const campaignStatus = trigger.dataset.campaignStatus || '-';
			const campaignDm = trigger.dataset.campaignDm || '-';
			const campaignImgPath = trigger.dataset.campaignImgPath || '-';

			titleEl.textContent = name;
			descEl.textContent = description || 'No description provided.';
			idEl.textContent = campaignId;
			statusEl.textContent = campaignStatus;
			dmEl.textContent = campaignDm;
			imgPathEl.textContent = campaignImgPath;
			imageEl.src = campaignImage;
			imageEl.onerror = () => {
				imageEl.onerror = null;
				imageEl.src = fallbackImage;
			};
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

		triggers.forEach((trigger) => {
			trigger.addEventListener('click', () => open(trigger));
		});

		closeBtn.addEventListener('click', close);
		backdrop.addEventListener('click', (event) => {
			if (event.target === backdrop) close();
		});
		document.addEventListener('keydown', (event) => {
			if (event.key === 'Escape') close();
		});
	})();
</script>
