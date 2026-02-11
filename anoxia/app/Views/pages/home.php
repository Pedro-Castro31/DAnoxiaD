<?= $this->extend('app') ?>

<?= $this->section('content') ?>
<div class="flex flex-col gap-6">
    <section class="rounded-3xl border border-[#8d643d]/35 bg-[#5a3923]/70 p-6 shadow-[0_14px_34px_rgba(10,6,4,0.35)]">
        <?php if (session()->get('logged_in')): ?>
            <h1 class="font-royal text-4xl text-[#f6e8cd]">Welcome, <?= esc(session()->get('user_name')) ?></h1>
            <p class="mt-2 max-w-3xl text-[#dfc49d]">You are authenticated and ready to use the platform.</p>
        <?php else: ?>
            <h1 class="font-royal text-4xl text-[#f6e8cd]">Welcome to Anoxia</h1>
            <p class="mt-2 max-w-3xl text-[#dfc49d]">Please login to continue.</p>
        <?php endif; ?>
    </section>

    <section class="rounded-3xl border border-[#8d643d]/35 bg-[#5a3923]/70 p-6 shadow-[0_14px_34px_rgba(10,6,4,0.35)]">
        <h2 class="mb-4 font-royal text-2xl text-[#f6e8cd]">Detailed User List</h2>
        <p class="mb-4 text-[#dfc49d]">Status: <strong><?= esc($db_status ?? 'Unknown') ?></strong></p>

        <?php if (!empty($users)): ?>
            <div class="overflow-x-auto">
                <table class="w-full border border-[#8d643d] text-left">
                    <thead class="bg-[#4a2f1d] text-[#f6e8cd]">
                        <tr>
                            <th class="border border-[#8d643d] px-4 py-2">ID</th>
                            <th class="border border-[#8d643d] px-4 py-2">Nome</th>
                            <th class="border border-[#8d643d] px-4 py-2">Email</th>
                            <th class="border border-[#8d643d] px-4 py-2">Role</th>
                            <th class="border border-[#8d643d] px-4 py-2">is_admin</th>
                            <th class="border border-[#8d643d] px-4 py-2">is_dm</th>
                            <th class="border border-[#8d643d] px-4 py-2">is_active</th>
                            <th class="border border-[#8d643d] px-4 py-2">Password Hash</th>
                        </tr>
                    </thead>
                    <tbody class="text-[#dfc49d]">
                        <?php foreach ($users as $user): ?>
                            <?php
                                $isAdmin = property_exists($user, 'is_admin') && (int) $user->is_admin === 1;
                                $isDm = property_exists($user, 'derived_is_dm')
                                    ? (int) $user->derived_is_dm === 1
                                    : (property_exists($user, 'is_dm') && (int) $user->is_dm === 1);
                                $role = $isAdmin ? 'admin' : ($isDm ? 'dm' : 'player');
                            ?>
                            <tr class="hover:bg-[#3e2718]">
                                <td class="border border-[#8d643d] px-4 py-2"><?= esc($user->id) ?></td>
                                <td class="border border-[#8d643d] px-4 py-2"><?= esc($user->name) ?></td>
                                <td class="border border-[#8d643d] px-4 py-2"><?= esc($user->email) ?></td>
                                <td class="border border-[#8d643d] px-4 py-2"><?= esc($role) ?></td>
                                <td class="border border-[#8d643d] px-4 py-2"><?= $isAdmin ? '1' : '0' ?></td>
                                <td class="border border-[#8d643d] px-4 py-2"><?= $isDm ? '1' : '0' ?></td>
                                <td class="border border-[#8d643d] px-4 py-2"><?= property_exists($user, 'is_active') ? ((int) $user->is_active === 1 ? '1' : '0') : '-' ?></td>
                                <td class="border border-[#8d643d] px-4 py-2"><?= property_exists($user, 'password_hash') && $user->password_hash ? 'Yes' : 'No' ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <p class="text-[#b66b5a]">No users found or database error.</p>
        <?php endif; ?>
    </section>
</div>
<?= $this->endSection() ?>
