<div id="recoverPasswordModal" class="invisible fixed inset-0 z-50 grid place-items-center bg-black/60 opacity-0 transition">
    <div class="w-[92vw] max-w-md rounded-2xl border border-[#9b7450] bg-[#3f2819] p-6 shadow-2xl">
        <div class="flex items-start justify-between gap-3">
            <div>
                <h2 class="font-royal text-2xl text-[#f6e8cd]">Recuperar Acesso</h2>
                <p class="mt-1 text-sm text-[#dfc49d]">Introduza o seu e-mail para receber instrucoes de recuperacao.</p>
            </div>
            <button id="closeRecoverModal" class="rounded px-2 py-0.5 text-[#f3e2c7] hover:bg-[#6a4328] transition" aria-label="Fechar">
                <i class="ri-close-line text-xl"></i>
            </button>
        </div>

        <form id="recoverPasswordForm" method="post" action="<?= base_url('auth/recover') ?>" class="mt-6 space-y-4 text-sm" novalidate>
            <?= csrf_field() ?>
            
            <div>
                <label for="recoverEmail" class="mb-1 block text-[#dfc49d]">E-mail</label>
                <input
                    type="email"
                    id="recoverEmail"
                    name="email"
                    placeholder="seu@email.com"
                    required
                    class="w-full rounded-lg border border-[#a87b4f]/35 bg-[#3e2718] px-3 py-2 text-[#f5e5ca] placeholder:text-[#d0ae80] outline-none focus:ring-2 focus:ring-[#d5b078] transition"
                >
                <p id="recoverEmailError" class="mt-1 hidden text-xs text-[#f6ccc3]"></p>
            </div>

            <div class="flex justify-end gap-2">
                <button
                    type="button"
                    id="cancelRecoverModal"
                    class="rounded-lg border border-[#8f6640] bg-[#5a3924] px-4 py-2 text-[#f3e2c7] hover:bg-[#6b4528] transition"
                >
                    Cancelar
                </button>
                <button
                    type="submit"
                    class="rounded-lg border border-[#d4b07a] bg-[#c89b60] px-4 py-2 font-semibold text-[#2d1c12] hover:bg-[#dbb780] transition"
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
                
                // Reset form
                if (recoverForm) recoverForm.reset();
                if (recoverEmail && recoverEmailError) {
                    recoverEmail.classList.remove('border-[#b66b5a]', 'focus:ring-[#b66b5a]');
                    recoverEmailError.classList.add('hidden');
                    recoverEmailError.textContent = '';
                }
            }
        };

        // Event listeners for modal controls
        closeRecoverBtn?.addEventListener('click', closeRecoverModal);
        cancelRecoverBtn?.addEventListener('click', closeRecoverModal);
        
        recoverModal?.addEventListener('click', (e) => {
            if (e.target === recoverModal) closeRecoverModal();
        });

        // Form validation
        const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

        const clearField = () => {
            if (recoverEmail && recoverEmailError) {
                recoverEmail.classList.remove('border-[#b66b5a]', 'focus:ring-[#b66b5a]');
                recoverEmailError.textContent = '';
                recoverEmailError.classList.add('hidden');
            }
        };

        const setFieldError = (message) => {
            if (recoverEmail && recoverEmailError) {
                recoverEmail.classList.add('border-[#b66b5a]', 'focus:ring-[#b66b5a]');
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
            // Form will submit normally to the server
        });

        // Expose function globally so login page can call it
        window.openRecoverPasswordModal = openRecoverModal;
    })();
</script>
