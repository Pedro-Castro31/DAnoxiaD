<div id="recoverPasswordModal" class="invisible fixed inset-0 z-50 grid place-items-center bg-black/60 opacity-0 transition">
    <div class="w-[92vw] max-w-md rounded-2xl border border-[var(--border-base)] bg-[var(--bg-modal)] p-6 shadow-2xl">
        <div class="flex items-start justify-between gap-3">
            <div>
                <h2 class="font-royal text-2xl text-[var(--text-primary)]">Recuperar Acesso</h2>
                <p class="mt-1 text-sm text-[var(--text-secondary)]">Introduza o seu e-mail para receber instrucoes de recuperacao.</p>
            </div>
            <button id="closeRecoverModal" class="rounded px-2 py-0.5 text-[var(--text-primary)] hover:bg-[var(--bg-btn)] hover:text-[var(--text-on-btn)] transition" aria-label="Fechar">
                <i class="ri-close-line text-xl"></i>
            </button>
        </div>

        <form id="recoverPasswordForm" method="post" action="<?= base_url('auth/recover') ?>" class="mt-6 space-y-4 text-sm" novalidate>
            <?= csrf_field() ?>

            <div>
                <label for="recoverEmail" class="mb-1 block text-[var(--text-secondary)]">E-mail</label>
                <input
                    type="email"
                    id="recoverEmail"
                    name="email"
                    placeholder="seu@email.com"
                    required
                    class="w-full rounded-lg border border-[var(--border-input)]/35 bg-[var(--bg-input)] px-3 py-2 text-[var(--text-primary)] placeholder:text-[var(--text-placeholder)] outline-none focus:ring-2 focus:ring-[var(--ring-focus)] transition"
                >
                <p id="recoverEmailError" class="mt-1 hidden text-xs text-[var(--text-error)]"></p>
            </div>

            <div class="flex justify-end gap-2">
                <button
                    type="button"
                    id="cancelRecoverModal"
                    class="rounded-lg border border-[var(--border-base)] bg-[var(--bg-btn-secondary)] px-4 py-2 text-[var(--text-primary)] hover:bg-[var(--bg-btn-sec-hover)] transition"
                >
                    Cancelar
                </button>
                <button
                    type="submit"
                    class="rounded-lg border border-[var(--border-accent)] bg-[var(--bg-accent)] px-4 py-2 font-semibold text-[var(--text-on-accent)] hover:bg-[var(--bg-accent-hover)] transition"
                >
                    Enviar
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    (() => {
        const recoverModal = document.getElementById('recoverPasswordModal');
        const closeRecoverBtn = document.getElementById('closeRecoverModal');
        const cancelRecoverBtn = document.getElementById('cancelRecoverModal');
        const recoverForm = document.getElementById('recoverPasswordForm');
        const recoverEmail = document.getElementById('recoverEmail');
        const recoverEmailError = document.getElementById('recoverEmailError');

        const openRecoverModal = () => {
            if (recoverModal) {
                recoverModal.classList.remove('invisible', 'opacity-0');
                if (recoverEmail) recoverEmail.focus();
            }
        };

        const closeRecoverModal = () => {
            if (recoverModal) {
                recoverModal.classList.add('opacity-0');
                setTimeout(() => recoverModal.classList.add('invisible'), 150);
                if (recoverForm) recoverForm.reset();
                if (recoverEmail && recoverEmailError) {
                    recoverEmail.classList.remove('input-error');
                    recoverEmailError.classList.add('hidden');
                    recoverEmailError.textContent = '';
                }
            }
        };

        closeRecoverBtn?.addEventListener('click', closeRecoverModal);
        cancelRecoverBtn?.addEventListener('click', closeRecoverModal);

        recoverModal?.addEventListener('click', (e) => {
            if (e.target === recoverModal) closeRecoverModal();
        });

        const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

        const clearField = () => {
            if (recoverEmail && recoverEmailError) {
                recoverEmail.classList.remove('input-error');
                recoverEmailError.textContent = '';
                recoverEmailError.classList.add('hidden');
            }
        };

        const setFieldError = (message) => {
            if (recoverEmail && recoverEmailError) {
                recoverEmail.classList.add('input-error');
                recoverEmailError.textContent = message;
                recoverEmailError.classList.remove('hidden');
            }
        };

        recoverEmail?.addEventListener('input', clearField);

        recoverForm?.addEventListener('submit', (event) => {
            const emailValue = recoverEmail?.value.trim() || '';

            if (!emailValue) {
                event.preventDefault();
                setFieldError('Campo obrigatorio.');
                return;
            }

            if (!emailPattern.test(emailValue)) {
                event.preventDefault();
                setFieldError('E-mail invalido.');
                return;
            }

            clearField();
        });

        window.openRecoverPasswordModal = openRecoverModal;
    })();
</script>
