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
	<section class="rounded-3xl border border-[#8d643d]/35 bg-[#5a3923]/70 p-6 shadow-[0_14px_34px_rgba(10,6,4,0.35)]">
		<div class="flex flex-wrap items-start justify-between gap-4">
			<div>
				<p class="text-xs uppercase tracking-[0.3em] text-[#caa679]">Admin</p>
				<h1 class="mt-2 font-royal text-4xl text-[#f6e8cd]">User Management</h1>
				<p class="mt-2 max-w-2xl text-[#dfc49d]">Create, review, edit, and deactivate user accounts from a single command center.</p>
			</div>
			<div class="flex flex-wrap gap-2 text-sm">
				<a href="<?= base_url('admin/users/export') ?>" class="rounded-lg border border-[#8f6640] bg-[#6f4929] px-4 py-2 font-semibold text-[#f3e2c7] transition hover:bg-[#7e5430]">Export CSV</a>
				<button id="openListUsersBtn" type="button" class="rounded-lg border border-[#8f6640] bg-[#4a2f1d] px-4 py-2 font-semibold text-[#f3e2c7] transition hover:bg-[#6f4929]">List Users</button>
				<button id="openCreateUserBtn" type="button" class="rounded-lg border border-[#d4b07a] bg-[#c89b60] px-4 py-2 font-semibold text-[#2d1c12] transition hover:bg-[#dbb780]">Create User</button>
			</div>
		</div>
	</section>

	<section class="grid gap-4 md:grid-cols-2 xl:grid-cols-3">
		<article class="rounded-2xl border border-[#8f6640]/35 bg-[#4a2f1d]/75 p-4">
			<p class="text-xs uppercase tracking-wide text-[#cfae84]">Total Users</p>
			<p class="mt-2 font-royal text-3xl text-[#f6e8cd]"><?= esc((string) $totalUsers) ?></p>
			<p class="mt-1 text-sm text-[#e2c8a3]">All registered accounts.</p>
		</article>
		<article class="rounded-2xl border border-[#8f6640]/35 bg-[#4a2f1d]/75 p-4">
			<p class="text-xs uppercase tracking-wide text-[#cfae84]">Admins</p>
			<p class="mt-2 font-royal text-3xl text-[#f6e8cd]"><?= esc((string) $adminUsers) ?></p>
			<p class="mt-1 text-sm text-[#e2c8a3]">Users with elevated access.</p>
		</article>
		<article class="rounded-2xl border border-[#8f6640]/35 bg-[#4a2f1d]/75 p-4">
			<p class="text-xs uppercase tracking-wide text-[#cfae84]">Dungeon Masters</p>
			<p class="mt-2 font-royal text-3xl text-[#f6e8cd]"><?= esc((string) $dmUsers) ?></p>
			<p class="mt-1 text-sm text-[#e2c8a3]">Assigned to campaigns.</p>
		</article>
		<article class="rounded-2xl border border-[#8f6640]/35 bg-[#4a2f1d]/75 p-4">
			<p class="text-xs uppercase tracking-wide text-[#cfae84]">Pending</p>
			<p class="mt-2 font-royal text-3xl text-[#f6e8cd]"><?= esc((string) $pendingUsers) ?></p>
			<p class="mt-1 text-sm text-[#e2c8a3]">Awaiting activation.</p>
		</article>
		<article class="rounded-2xl border border-[#8f6640]/35 bg-[#4a2f1d]/75 p-4">
			<p class="text-xs uppercase tracking-wide text-[#cfae84]">Active</p>
			<p class="mt-2 font-royal text-3xl text-[#f6e8cd]"><?= esc((string) $activeUsers) ?></p>
			<p class="mt-1 text-sm text-[#e2c8a3]">Can access the platform.</p>
		</article>
		<article class="rounded-2xl border border-[#8f6640]/35 bg-[#4a2f1d]/75 p-4">
			<p class="text-xs uppercase tracking-wide text-[#cfae84]">Inactive</p>
			<p class="mt-2 font-royal text-3xl text-[#f6e8cd]"><?= esc((string) $inactiveUsers) ?></p>
			<p class="mt-1 text-sm text-[#e2c8a3]">Disabled accounts.</p>
		</article>
	</section>

</div>

<?php include(APPPATH . 'Views/modals/list_users.php'); ?>
<?php include(APPPATH . 'Views/modals/create_user.php'); ?>

<?= $this->endSection() ?>
