<div id="listUsersBackdrop" class="invisible fixed inset-0 z-40 grid place-items-center bg-black/60 opacity-0 transition">
	<div class="w-[92vw] max-w-4xl rounded-2xl border border-[var(--border-base)] bg-[var(--bg-modal)] p-6 shadow-2xl">
		<div class="flex items-start justify-between gap-3">
			<div>
				<h3 class="font-royal text-2xl text-[var(--text-primary)]">User List</h3>
				<p class="mt-1 text-sm text-[var(--text-secondary)]">All registered accounts from the database.</p>
			</div>
			<button id="closeListUsersBtn" class="rounded px-2 py-0.5 text-[var(--text-primary)] hover:bg-[var(--bg-btn)] hover:text-[var(--text-on-btn)]" type="button">x</button>
		</div>

		<div class="mt-4 grid gap-3 text-sm md:grid-cols-4">
			<div class="md:col-span-2">
				<label class="mb-1 block text-[var(--text-secondary)]">Search</label>
				<input
					type="text"
					id="listUsersSearch"
					placeholder="Search by id, name, or email"
					class="w-full rounded-lg border border-[var(--border-input)]/35 bg-[var(--bg-input)] px-3 py-2 text-[var(--text-primary)] placeholder:text-[var(--text-placeholder)] outline-none focus:ring-2 focus:ring-[var(--ring-focus)] transition"
				>
			</div>
			<div>
				<label class="mb-1 block text-[var(--text-secondary)]">Role</label>
				<select
					id="listUsersRole"
					class="w-full rounded-lg border border-[var(--border-input)]/35 bg-[var(--bg-input)] px-3 py-2 text-[var(--text-primary)] outline-none focus:ring-2 focus:ring-[var(--ring-focus)] transition"
				>
					<option value="">All</option>
					<option value="1">Admin</option>
					<option value="0">User</option>
					<option value="dm">Dungeon Master</option>
				</select>
			</div>
			<div>
				<label class="mb-1 block text-[var(--text-secondary)]">Status</label>
				<select
					id="listUsersStatus"
					class="w-full rounded-lg border border-[var(--border-input)]/35 bg-[var(--bg-input)] px-3 py-2 text-[var(--text-primary)] outline-none focus:ring-2 focus:ring-[var(--ring-focus)] transition"
				>
					<option value="">All</option>
					<option value="active">Active</option>
					<option value="inactive">Inactive</option>
					<option value="pending">Pending</option>
				</select>
			</div>
		</div>

		<div class="mt-4 overflow-x-auto rounded-xl border border-[var(--border-base)]/35">
			<table class="min-w-full text-left text-sm" id="listUsersTable">
				<thead class="bg-[var(--bg-table-header)] text-[var(--text-primary)]">
					<tr>
						<th class="px-4 py-3">ID</th>
						<th class="px-4 py-3">Name</th>
						<th class="px-4 py-3">Email</th>
						<th class="px-4 py-3">Is Admin</th>
						<th class="px-4 py-3">Is DM</th>
						<th class="px-4 py-3">Is Active</th>
						<th class="px-4 py-3">Is Pending</th>
					</tr>
				</thead>
				<tbody class="bg-[var(--bg-table-body)] text-[var(--text-secondary)]">
					<?php if (!empty($users)): ?>
						<?php foreach ($users as $user): ?>
							<?php $isAdmin = !empty($user->is_admin) ? '1' : '0'; ?>
							<?php $hasPassword = !empty($user->password_hash); ?>
							<?php $isActive = ((int) ($user->is_active ?? 0) === 1) && $hasPassword; ?>
							<?php $isPending = ($user->is_active === null) || !$hasPassword; ?>
							<?php $isInactive = ((int) ($user->is_active ?? 0) === 0) && !$isPending; ?>
							<?php $isDm = !empty($user->is_dm_active); ?>
							<?php $status = $isPending ? 'pending' : ($isActive ? 'active' : 'inactive'); ?>
							<tr class="border-t border-[var(--border-subtle)]/35" data-user-row data-id="<?= esc((string) ($user->id ?? '')) ?>" data-name="<?= esc((string) ($user->name ?? '')) ?>" data-email="<?= esc((string) ($user->email ?? '')) ?>" data-admin="<?= esc($isAdmin) ?>" data-dm="<?= $isDm ? '1' : '0' ?>" data-status="<?= esc($status) ?>">
								<td class="px-4 py-3"><?= esc((string) ($user->id ?? '')) ?></td>
								<td class="px-4 py-3"><?= esc((string) ($user->name ?? '')) ?></td>
								<td class="px-4 py-3"><?= esc((string) ($user->email ?? '')) ?></td>
								<td class="px-4 py-3"><?= $isAdmin === '1' ? 'Yes' : 'No' ?></td>
								<td class="px-4 py-3"><?= $isDm ? 'Yes' : 'No' ?></td>
								<td class="px-4 py-3"><?= $isActive ? 'Yes' : 'No' ?></td>
								<td class="px-4 py-3"><?= $isPending ? 'Yes' : 'No' ?></td>
							</tr>
						<?php endforeach; ?>
						<tr id="listUsersEmptyRow" class="border-t border-[var(--border-subtle)]/35 hidden">
							<td colspan="7" class="px-4 py-6 text-center text-[var(--text-secondary)]">No users match the current filters.</td>
						</tr>
					<?php else: ?>
						<tr id="listUsersEmptyRow" class="border-t border-[var(--border-subtle)]/35">
							<td colspan="7" class="px-4 py-6 text-center text-[var(--text-secondary)]">No users found.</td>
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
		const statusSelect = document.getElementById('listUsersStatus');
		const emptyRow = document.getElementById('listUsersEmptyRow');

		if (!openBtn || !closeBtn || !backdrop || !table || !searchInput || !roleSelect || !statusSelect) return;

		const rows = Array.from(table.querySelectorAll('tbody [data-user-row]'));

		const applyFilters = () => {
			const query = searchInput.value.trim().toLowerCase();
			const adminFilter = roleSelect.value;
			const statusFilter = statusSelect.value;
			let visibleCount = 0;

			rows.forEach((row) => {
				const id = (row.dataset.id || '').toLowerCase();
				const name = (row.dataset.name || '').toLowerCase();
				const email = (row.dataset.email || '').toLowerCase();
				const admin = row.dataset.admin || '';
				const dm = row.dataset.dm || '';
				const status = row.dataset.status || '';
				const matchesQuery = !query || id.includes(query) || name.includes(query) || email.includes(query);
				const matchesRole = !adminFilter || (adminFilter === 'dm' ? dm === '1' : adminFilter === admin);
				const matchesStatus = !statusFilter || statusFilter === status;
				const show = matchesQuery && matchesRole && matchesStatus;
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
		statusSelect.addEventListener('change', applyFilters);
		document.addEventListener('keydown', (event) => {
			if (event.key === 'Escape') close();
		});
	})();
</script>
