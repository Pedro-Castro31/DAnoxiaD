<?= $this->extend('app') ?>

<?= $this->section('content') ?>
<?php
$users = $users ?? [];
$totalUsers = $totalUsers ?? 0;
$adminUsers = $adminUsers ?? 0;
$dmUsers = $dmUsers ?? 0;
$pendingUsers = $pendingUsers ?? 0;
$activeUsers = $activeUsers ?? 0;
$inactiveUsers = $inactiveUsers ?? 0;
?>

<div class="flex flex-col gap-6">
	<section class="rounded-3xl border border-[var(--border-base)]/35 bg-[var(--bg-card)]/70 p-6 shadow-[0_14px_34px_rgba(10,6,4,0.35)]">
		<div class="flex flex-wrap items-start justify-between gap-4">
			<div>
				<p class="text-xs uppercase tracking-[0.3em] text-[var(--text-muted)]">Admin</p>
				<h1 class="mt-2 font-royal text-4xl text-[var(--text-primary)]">User Management</h1>
				<p class="mt-2 max-w-2xl text-[var(--text-secondary)]">Create, review, edit, and deactivate user accounts from a single command center.</p>
			</div>
			<div class="flex flex-wrap gap-2 text-sm">
				<a href="<?= base_url('admin/users/export') ?>" class="rounded-lg border border-[var(--border-base)] bg-[var(--bg-btn)] px-4 py-2 font-semibold text-[var(--text-on-btn)] transition hover:bg-[var(--bg-btn-hover)]">Export CSV</a>
				<button id="openListUsersBtn" type="button" class="rounded-lg border border-[var(--border-base)] bg-[var(--bg-card-alt)] px-4 py-2 font-semibold text-[var(--text-primary)] transition hover:bg-[var(--bg-btn)] hover:text-[var(--text-on-btn)]">List Users</button>
				<button id="openCreateUserBtn" type="button" class="rounded-lg border border-[var(--border-accent)] bg-[var(--bg-accent)] px-4 py-2 font-semibold text-[var(--text-on-accent)] transition hover:bg-[var(--bg-accent-hover)]">Create User</button>
			</div>
		</div>
	</section>

	<section class="grid gap-4 md:grid-cols-2 xl:grid-cols-3">
		<article class="rounded-2xl border border-[var(--border-base)]/35 bg-[var(--bg-card-alt)]/75 p-4">
			<p class="text-xs uppercase tracking-wide text-[var(--text-muted)]">Total Users</p>
			<p class="mt-2 font-royal text-3xl text-[var(--text-primary)]"><?= esc((string) $totalUsers) ?></p>
			<p class="mt-1 text-sm text-[var(--text-secondary)]">All registered accounts.</p>
		</article>
		<article class="rounded-2xl border border-[var(--border-base)]/35 bg-[var(--bg-card-alt)]/75 p-4">
			<p class="text-xs uppercase tracking-wide text-[var(--text-muted)]">Admins</p>
			<p class="mt-2 font-royal text-3xl text-[var(--text-primary)]"><?= esc((string) $adminUsers) ?></p>
			<p class="mt-1 text-sm text-[var(--text-secondary)]">Users with elevated access.</p>
		</article>
		<article class="rounded-2xl border border-[var(--border-base)]/35 bg-[var(--bg-card-alt)]/75 p-4">
			<p class="text-xs uppercase tracking-wide text-[var(--text-muted)]">Dungeon Masters</p>
			<p class="mt-2 font-royal text-3xl text-[var(--text-primary)]"><?= esc((string) $dmUsers) ?></p>
			<p class="mt-1 text-sm text-[var(--text-secondary)]">Assigned to campaigns.</p>
		</article>
		<article class="rounded-2xl border border-[var(--border-base)]/35 bg-[var(--bg-card-alt)]/75 p-4">
			<p class="text-xs uppercase tracking-wide text-[var(--text-muted)]">Pending</p>
			<p class="mt-2 font-royal text-3xl text-[var(--text-primary)]"><?= esc((string) $pendingUsers) ?></p>
			<p class="mt-1 text-sm text-[var(--text-secondary)]">Awaiting activation.</p>
		</article>
		<article class="rounded-2xl border border-[var(--border-base)]/35 bg-[var(--bg-card-alt)]/75 p-4">
			<p class="text-xs uppercase tracking-wide text-[var(--text-muted)]">Active</p>
			<p class="mt-2 font-royal text-3xl text-[var(--text-primary)]"><?= esc((string) $activeUsers) ?></p>
			<p class="mt-1 text-sm text-[var(--text-secondary)]">Can access the platform.</p>
		</article>
		<article class="rounded-2xl border border-[var(--border-base)]/35 bg-[var(--bg-card-alt)]/75 p-4">
			<p class="text-xs uppercase tracking-wide text-[var(--text-muted)]">Inactive</p>
			<p class="mt-2 font-royal text-3xl text-[var(--text-primary)]"><?= esc((string) $inactiveUsers) ?></p>
			<p class="mt-1 text-sm text-[var(--text-secondary)]">Disabled accounts.</p>
		</article>
	</section>

</div>

<?php include(APPPATH . 'Views/modals/list_users.php'); ?>
<?php include(APPPATH . 'Views/modals/create_user.php'); ?>

<?= $this->endSection() ?>
