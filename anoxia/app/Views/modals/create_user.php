<div id="createUserBackdrop" class="invisible fixed inset-0 z-40 grid place-items-center bg-black/60 opacity-0 transition">
	<div class="w-[92vw] max-w-lg rounded-2xl border border-[#9b7450] bg-[#3f2819] p-6 shadow-2xl">
		<div class="flex items-start justify-between gap-3">
			<div>
				<h3 class="font-royal text-2xl text-[#f3e1c3]">Create User</h3>
				<p class="mt-1 text-sm text-[#dfc49d]">Add a new member with name and email.</p>
			</div>
			<button id="closeCreateUserBtn" class="rounded px-2 py-0.5 hover:bg-[#6a4328]" type="button">x</button>
		</div>

		<form method="post" action="<?= base_url('admin/users/create') ?>" class="mt-5 grid gap-4 text-sm">
			<?= csrf_field() ?>
			<div>
				<label class="mb-1 block text-[#dfc49d]">Full Name</label>
				<input
					type="text"
					name="name"
					placeholder="Captain Alden"
					class="w-full rounded-lg border border-[#a87b4f]/35 bg-[#3e2718] px-3 py-2 text-[#f5e5ca] placeholder:text-[#d0ae80] outline-none focus:ring-2 focus:ring-[#d5b078] transition"
					required
				>
			</div>
			<div>
				<label class="mb-1 block text-[#dfc49d]">Email</label>
				<input
					type="email"
					name="email"
					placeholder="captain@keep.local"
					class="w-full rounded-lg border border-[#a87b4f]/35 bg-[#3e2718] px-3 py-2 text-[#f5e5ca] placeholder:text-[#d0ae80] outline-none focus:ring-2 focus:ring-[#d5b078] transition"
					required
				>
			</div>
			<div class="flex flex-wrap justify-end gap-2">
				<button id="cancelCreateUserBtn" type="button" class="rounded-lg border border-[#8f6640] bg-[#5a3924] px-3 py-1.5 text-[#f3e2c7]">Cancel</button>
				<button type="submit" class="rounded-lg border border-[#d4b07a] bg-[#c89b60] px-3 py-1.5 font-semibold text-[#2d1c12]">Create</button>
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
