<div id="listUsersBackdrop" class="invisible fixed inset-0 z-40 grid place-items-center bg-black/60 opacity-0 transition">
	<div class="w-[92vw] max-w-4xl rounded-2xl border border-[#9b7450] bg-[#3f2819] p-6 shadow-2xl">
		<div class="flex items-start justify-between gap-3">
			<div>
				<h3 class="font-royal text-2xl text-[#f3e1c3]">User List</h3>
				<p class="mt-1 text-sm text-[#dfc49d]">All registered accounts from the database.</p>
			</div>
			<button id="closeListUsersBtn" class="rounded px-2 py-0.5 hover:bg-[#6a4328]" type="button">x</button>
		</div>

		<div class="mt-4 grid gap-3 text-sm md:grid-cols-3">
			<div class="md:col-span-2">
				<label class="mb-1 block text-[#dfc49d]">Search</label>
				<input
					type="text"
					id="listUsersSearch"
					placeholder="Search by id, name, or email"
					class="w-full rounded-lg border border-[#a87b4f]/35 bg-[#3e2718] px-3 py-2 text-[#f5e5ca] placeholder:text-[#d0ae80] outline-none focus:ring-2 focus:ring-[#d5b078] transition"
				>
			</div>
			<div>
				<label class="mb-1 block text-[#dfc49d]">Admin</label>
				<select
					id="listUsersRole"
					class="w-full rounded-lg border border-[#a87b4f]/35 bg-[#3e2718] px-3 py-2 text-[#f5e5ca] outline-none focus:ring-2 focus:ring-[#d5b078] transition"
				>
					<option value="">All</option>
					<option value="1">Admin</option>
					<option value="0">User</option>
				</select>
			</div>
		</div>

		<div class="mt-4 overflow-x-auto rounded-xl border border-[#8f6640]/35">
			<table class="min-w-full text-left text-sm" id="listUsersTable">
				<thead class="bg-[#6f4928] text-[#f8eedc]">
					<tr>
						<th class="px-4 py-3">ID</th>
						<th class="px-4 py-3">Name</th>
						<th class="px-4 py-3">Email</th>
						<th class="px-4 py-3">Is Admin</th>
						<th class="px-4 py-3">Is DM</th>
					</tr>
				</thead>
				<tbody class="bg-[#3c2618] text-[#f0ddbf]">
					<?php if (!empty($users)): ?>
						<?php foreach ($users as $user): ?>
							<?php $isAdmin = !empty($user->is_admin) ? '1' : '0'; ?>
							<tr class="border-t border-[#7f5938]/35" data-user-row data-id="<?= esc((string) ($user->id ?? '')) ?>" data-name="<?= esc((string) ($user->name ?? '')) ?>" data-email="<?= esc((string) ($user->email ?? '')) ?>" data-admin="<?= esc($isAdmin) ?>">
								<td class="px-4 py-3"><?= esc((string) ($user->id ?? '')) ?></td>
								<td class="px-4 py-3"><?= esc((string) ($user->name ?? '')) ?></td>
								<td class="px-4 py-3"><?= esc((string) ($user->email ?? '')) ?></td>
								<td class="px-4 py-3">
									<?= $isAdmin === '1' ? 'Yes' : 'No' ?>
								</td>
								<td class="px-4 py-3">
									<?= !empty($user->is_dm_active) ? 'Yes' : 'No' ?>
								</td>
							</tr>
						<?php endforeach; ?>
						<tr id="listUsersEmptyRow" class="border-t border-[#7f5938]/35 hidden">
							<td colspan="5" class="px-4 py-6 text-center text-[#dfc49d]">No users match the current filters.</td>
						</tr>
					<?php else: ?>
						<tr id="listUsersEmptyRow" class="border-t border-[#7f5938]/35">
							<td colspan="5" class="px-4 py-6 text-center text-[#dfc49d]">No users found.</td>
						</tr>
					<?php endif; ?>
				</tbody>
			</table>
		</div>
	</div>
</div>

<script>
	(() => {
		const openBtn = document.getElementById('openListUsersBtn');
		const closeBtn = document.getElementById('closeListUsersBtn');
		const backdrop = document.getElementById('listUsersBackdrop');
		const searchInput = document.getElementById('listUsersSearch');
		const roleSelect = document.getElementById('listUsersRole');
		const table = document.getElementById('listUsersTable');
		const emptyRow = document.getElementById('listUsersEmptyRow');

		if (!openBtn || !closeBtn || !backdrop || !table || !searchInput || !roleSelect) return;

		const rows = Array.from(table.querySelectorAll('tbody [data-user-row]'));

		const applyFilters = () => {
			const query = searchInput.value.trim().toLowerCase();
			const adminFilter = roleSelect.value;
			let visibleCount = 0;

			rows.forEach((row) => {
				const id = (row.dataset.id || '').toLowerCase();
				const name = (row.dataset.name || '').toLowerCase();
				const email = (row.dataset.email || '').toLowerCase();
				const admin = row.dataset.admin || '';
				const matchesQuery = !query || id.includes(query) || name.includes(query) || email.includes(query);
				const matchesAdmin = !adminFilter || adminFilter === admin;
				const show = matchesQuery && matchesAdmin;
				row.classList.toggle('hidden', !show);
				if (show) visibleCount += 1;
			});

			if (emptyRow) {
				emptyRow.classList.toggle('hidden', visibleCount > 0);
			}
		};

		const open = () => {
			backdrop.classList.remove('invisible', 'opacity-0');
			applyFilters();
		};

		const close = () => {
			backdrop.classList.add('opacity-0');
			setTimeout(() => backdrop.classList.add('invisible'), 150);
		};

		openBtn.addEventListener('click', open);
		closeBtn.addEventListener('click', close);
		backdrop.addEventListener('click', (event) => {
			if (event.target === backdrop) close();
		});
		searchInput.addEventListener('input', applyFilters);
		roleSelect.addEventListener('change', applyFilters);
		document.addEventListener('keydown', (event) => {
			if (event.key === 'Escape') close();
		});
	})();
</script>
