<div id="createCampaignBackdrop" class="invisible fixed inset-0 z-40 grid place-items-center bg-black/60 opacity-0 transition">
	<div class="w-[92vw] max-w-xl rounded-2xl border border-[var(--border-base)] bg-[var(--bg-modal)] p-6 shadow-2xl">
		<div class="flex items-start justify-between gap-3">
			<div>
				<h3 class="font-royal text-2xl text-[var(--text-primary)]">Create Campaign</h3>
				<p class="mt-1 text-sm text-[var(--text-secondary)]">Add a campaign and assign a DM.</p>
			</div>
			<button id="closeCreateCampaignBtn" class="rounded px-2 py-0.5 text-[var(--text-primary)] hover:bg-[var(--bg-btn)] hover:text-[var(--text-on-btn)]" type="button">x</button>
		</div>

		<form id="createCampaignForm" method="post" action="<?= base_url('campaigns/create') ?>" class="mt-5 grid gap-4 text-sm">
			<?= csrf_field() ?>
			<div>
				<label class="mb-1 block text-[var(--text-secondary)]">Name</label>
				<input
					type="text"
					name="name"
					required
					placeholder="The Crimson Frontier"
					class="w-full rounded-lg border border-[var(--border-input)]/35 bg-[var(--bg-input)] px-3 py-2 text-[var(--text-primary)] placeholder:text-[var(--text-placeholder)] outline-none focus:ring-2 focus:ring-[var(--ring-focus)] transition"
				>
			</div>
			<div>
				<label class="mb-1 block text-[var(--text-secondary)]">Description</label>
				<textarea
					name="description"
					required
					rows="3"
					placeholder="Short summary of the storyline"
					class="w-full rounded-lg border border-[var(--border-input)]/35 bg-[var(--bg-input)] px-3 py-2 text-[var(--text-primary)] placeholder:text-[var(--text-placeholder)] outline-none focus:ring-2 focus:ring-[var(--ring-focus)] transition"
				></textarea>
			</div>
			<div>
				<label class="mb-1 block text-[var(--text-secondary)]">Choose DM:</label>
				<select
					name="dm_email"
					required
					class="w-full rounded-lg border border-[var(--border-input)]/35 bg-[var(--bg-input)] px-3 py-2 text-[var(--text-primary)] outline-none focus:ring-2 focus:ring-[var(--ring-focus)] transition"
				>
					<option value="">Select a user</option>
					<?php foreach (($users ?? []) as $user): ?>
						<option value="<?= esc((string) ($user->email ?? '')) ?>">
							<?= esc((string) ($user->name ?? '')) ?> (<?= esc((string) ($user->email ?? '')) ?>)
						</option>
					<?php endforeach; ?>
				</select>
			</div>
			<div class="flex flex-wrap justify-end gap-2">
				<button id="cancelCreateCampaignBtn" type="button" class="rounded-lg border border-[var(--border-base)] bg-[var(--bg-btn-secondary)] px-3 py-1.5 text-[var(--text-primary)]">Cancel</button>
				<button type="submit" class="rounded-lg border border-[var(--border-accent)] bg-[var(--bg-accent)] px-3 py-1.5 font-semibold text-[var(--text-on-accent)]">Create</button>
			</div>
		</form>
	</div>
</div>

<script>
	(() => {
		const openBtn = document.getElementById('openCreateCampaignBtn');
		const closeBtn = document.getElementById('closeCreateCampaignBtn');
		const cancelBtn = document.getElementById('cancelCreateCampaignBtn');
		const backdrop = document.getElementById('createCampaignBackdrop');
		const form = document.getElementById('createCampaignForm');

		if (!openBtn || !closeBtn || !cancelBtn || !backdrop || !form) return;

		const sanitize = (value) => value.replace(/(--|;|\/\*|\*\/)/g, '').trim();

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
		backdrop.addEventListener('click', (event) => {
			if (event.target === backdrop) close();
		});
		document.addEventListener('keydown', (event) => {
			if (event.key === 'Escape') close();
		});

		form.addEventListener('submit', () => {
			const nameInput = form.querySelector('[name="name"]');
			const descInput = form.querySelector('[name="description"]');
			if (nameInput) nameInput.value = sanitize(nameInput.value);
			if (descInput) descInput.value = sanitize(descInput.value);
		});
	})();
</script>
