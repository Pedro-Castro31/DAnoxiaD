<div id="createUserBackdrop" class="invisible fixed inset-0 z-40 grid place-items-center bg-black/60 opacity-0 transition">
	<div class="w-[92vw] max-w-lg rounded-2xl border border-[var(--border-base)] bg-[var(--bg-modal)] p-6 shadow-2xl">
		<div class="flex items-start justify-between gap-3">
			<div>
				<h3 class="font-royal text-2xl text-[var(--text-primary)]">Create User</h3>
				<p class="mt-1 text-sm text-[var(--text-secondary)]">Add a new member with name and email.</p>
			</div>
			<button id="closeCreateUserBtn" class="rounded px-2 py-0.5 text-[var(--text-primary)] hover:bg-[var(--bg-btn)] hover:text-[var(--text-on-btn)]" type="button">x</button>
		</div>

		<form method="post" action="<?= base_url('admin/users/create') ?>" class="mt-5 grid gap-4 text-sm">
			<?= csrf_field() ?>
			<div>
				<label class="mb-1 block text-[var(--text-secondary)]">Full Name</label>
				<input
					type="text"
					name="name"
					placeholder="Captain Alden"
					class="w-full rounded-lg border border-[var(--border-input)]/35 bg-[var(--bg-input)] px-3 py-2 text-[var(--text-primary)] placeholder:text-[var(--text-placeholder)] outline-none focus:ring-2 focus:ring-[var(--ring-focus)] transition"
					required
				>
			</div>
			<div>
				<label class="mb-1 block text-[var(--text-secondary)]">Email</label>
				<input
					type="email"
					name="email"
					placeholder="captain@keep.local"
					class="w-full rounded-lg border border-[var(--border-input)]/35 bg-[var(--bg-input)] px-3 py-2 text-[var(--text-primary)] placeholder:text-[var(--text-placeholder)] outline-none focus:ring-2 focus:ring-[var(--ring-focus)] transition"
					required
				>
			</div>
			<div class="flex flex-wrap justify-end gap-2">
				<button id="cancelCreateUserBtn" type="button" class="rounded-lg border border-[var(--border-base)] bg-[var(--bg-btn-secondary)] px-3 py-1.5 text-[var(--text-primary)]">Cancel</button>
				<button type="submit" class="rounded-lg border border-[var(--border-accent)] bg-[var(--bg-accent)] px-3 py-1.5 font-semibold text-[var(--text-on-accent)]">Create</button>
			</div>
		</form>
	</div>
</div>

<script>
	(() => {
		const openBtn = document.getElementById('openCreateUserBtn');
		const closeBtn = document.getElementById('closeCreateUserBtn');
		const cancelBtn = document.getElementById('cancelCreateUserBtn');
		const backdrop = document.getElementById('createUserBackdrop');

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
		backdrop.addEventListener('click', (event) => {
			if (event.target === backdrop) close();
		});
		document.addEventListener('keydown', (event) => {
			if (event.key === 'Escape') close();
		});
	})();
</script>
