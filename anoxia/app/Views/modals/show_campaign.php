<div id="showCampaignBackdrop" class="invisible fixed inset-0 z-40 grid place-items-center bg-black/60 opacity-0 transition">
	<div class="w-[92vw] max-w-3xl rounded-2xl border border-[#9b7450] bg-[#3f2819] p-6 shadow-2xl">
		<div class="flex items-start justify-between gap-3">
			<div></div>
			<button id="closeShowCampaignBtn" class="rounded px-2 py-0.5 hover:bg-[#6a4328]" type="button">x</button>
		</div>

		<div class="mt-4 grid gap-4 md:grid-cols-[220px_1fr]">
			<div class="h-44 w-full rounded-2xl border border-dashed border-[#8f6640] bg-[#2f1d12]/60 text-center text-xs uppercase tracking-[0.2em] text-[#cfae84]">
				<div class="flex h-full items-center justify-center">Image Placeholder</div>
			</div>
			<div>
				<p class="text-xs uppercase tracking-[0.3em] text-[#caa679]">Campaign</p>
				<h3 id="showCampaignTitle" class="mt-2 font-royal text-3xl text-[#f3e1c3]">Campaign Title</h3>
				<p id="showCampaignDescription" class="mt-3 text-sm text-[#dfc49d]">Campaign description goes here.</p>
			</div>
		</div>

		<div class="mt-5 flex flex-wrap justify-end gap-2 text-sm">
			<button type="button" class="rounded-lg border border-[#8f6640] bg-[#5a3924] px-3 py-1.5 text-[#f3e2c7]">Editar</button>
			<button type="button" class="rounded-lg border border-[#8f6640] bg-[#5a3924] px-3 py-1.5 text-[#f3e2c7]">Jogadores</button>
			<button type="button" class="rounded-lg border border-[#d4b07a] bg-[#c89b60] px-3 py-1.5 font-semibold text-[#2d1c12]">Jogar</button>
		</div>
	</div>
</div>

<script>
	(() => {
		const backdrop = document.getElementById('showCampaignBackdrop');
		const closeBtn = document.getElementById('closeShowCampaignBtn');
		const titleEl = document.getElementById('showCampaignTitle');
		const descEl = document.getElementById('showCampaignDescription');
		const triggers = document.querySelectorAll('[data-show-campaign]');

		if (!backdrop || !closeBtn || !titleEl || !descEl || !triggers.length) return;

		const open = (trigger) => {
			const name = trigger.dataset.campaignName || 'Campaign';
			const description = trigger.dataset.campaignDescription || '';
			titleEl.textContent = name;
			descEl.textContent = description || 'No description provided.';
			backdrop.classList.remove('invisible', 'opacity-0');
		};

		const close = () => {
			backdrop.classList.add('opacity-0');
			setTimeout(() => backdrop.classList.add('invisible'), 150);
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
