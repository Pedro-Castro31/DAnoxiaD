<?= $this->extend('app') ?>

<?= $this->section('content') ?>
<div class="flex flex-col gap-6">
    <section class="rounded-3xl border border-[#8d643d]/35 bg-[#5a3923]/70 p-6 shadow-[0_14px_34px_rgba(10,6,4,0.35)]">
        <h1 class="font-royal text-3xl text-[#f6e8cd]">Campanhas</h1>
        <p class="mt-2 text-[#dfc49d]">Lista temporária das campanhas associadas ao utilizador autenticado.</p>
    </section>

    <section class="rounded-3xl border border-[#8d643d]/35 bg-[#5a3923]/70 p-6 shadow-[0_14px_34px_rgba(10,6,4,0.35)]">
        <p class="mb-4 text-[#dfc49d]">Status: <strong><?= esc((string) ($db_status ?? 'Unknown')) ?></strong></p>

        <?php if (!empty($campaigns)): ?>
            <div class="overflow-x-auto">
                <table class="w-full border border-[#8d643d] text-left">
                    <thead class="bg-[#4a2f1d] text-[#f6e8cd]">
                        <tr>
                            <th class="border border-[#8d643d] px-4 py-2">ID</th>
                            <th class="border border-[#8d643d] px-4 py-2">Campanha</th>
                            <th class="border border-[#8d643d] px-4 py-2">Estado</th>
                            <th class="border border-[#8d643d] px-4 py-2">is_dm</th>
                        </tr>
                    </thead>
                    <tbody class="text-[#dfc49d]">
                        <?php foreach ($campaigns as $campaign): ?>
                            <tr class="hover:bg-[#3e2718]">
                                <td class="border border-[#8d643d] px-4 py-2"><?= esc((string) $campaign->id) ?></td>
                                <td class="border border-[#8d643d] px-4 py-2"><?= esc((string) $campaign->name) ?></td>
                                <td class="border border-[#8d643d] px-4 py-2">
                                    <?php if ($campaign->is_active === null): ?>
                                        -
                                    <?php else: ?>
                                        <?= $campaign->is_active === 1 ? 'Ativa' : 'Desativada' ?>
                                    <?php endif; ?>
                                </td>
                                <td class="border border-[#8d643d] px-4 py-2">
                                    <?php if ($campaign->is_dm === null): ?>
                                        -
                                    <?php else: ?>
                                        <?= $campaign->is_dm === 1 ? '1' : '0' ?>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <p class="text-[#b66b5a]">Sem campanhas para o utilizador atual.</p>
        <?php endif; ?>
    </section>
</div>
<?= $this->endSection() ?>
