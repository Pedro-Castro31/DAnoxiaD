<?php
$authError = session()->getFlashdata('auth_error');
$authInfo = session()->getFlashdata('auth_info');
?>
<!DOCTYPE html>
<html lang="pt-PT">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sessão | Anoxia</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Alegreya:wght@400;500;700;800&family=Cinzel:wght@500;700;800&family=Cormorant+Garamond:wght@400;500;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.5.0/fonts/remixicon.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('assets/css/app.css') ?>">
</head>
<body class="min-h-screen bg-[#2f1e14] text-[#f4e3c8] font-tavern">
    <div class="absolute inset-0 -z-10 bg-[radial-gradient(circle_at_20%_10%,#70472a_0%,#4b301f_42%,#2a1a12_100%)]"></div>

    <main class="mx-auto grid min-h-screen w-full max-w-7xl place-items-center px-6 py-8">
        <section class="w-full overflow-hidden rounded-3xl border border-[#8d643d]/35 bg-[#5a3923]/65 shadow-[0_14px_34px_rgba(10,6,4,0.35)] md:grid md:grid-cols-2">
            <div class="relative hidden min-h-[560px] border-r border-[#8d643d]/35 md:block">
                <div class="absolute inset-0">
                    <img src="<?= base_url('assets/images/login/slide-1.png') ?>" alt="Pre-visualizacao do painel 1" class="slide-item h-full w-full object-cover opacity-100 transition duration-700" data-slide>
                    <img src="<?= base_url('assets/images/login/slide-2.png') ?>" alt="Pre-visualizacao do painel 2" class="slide-item absolute inset-0 h-full w-full object-cover opacity-0 transition duration-700" data-slide>
                    <img src="<?= base_url('assets/images/login/slide-3.png') ?>" alt="Pre-visualizacao do painel 3" class="slide-item absolute inset-0 h-full w-full object-cover opacity-0 transition duration-700" data-slide>
                    <img src="<?= base_url('assets/images/login/slide-4.png') ?>" alt="Pre-visualizacao do painel 4" class="slide-item absolute inset-0 h-full w-full object-cover opacity-0 transition duration-700" data-slide>
                    <img src="<?= base_url('assets/images/login/slide-5.png') ?>" alt="Pre-visualizacao do painel 5" class="slide-item absolute inset-0 h-full w-full object-cover opacity-0 transition duration-700" data-slide>
                </div>
                <div class="absolute inset-0 bg-black/30"></div>
                <div class="absolute bottom-0 left-0 right-0 p-6">
                    <p class="font-royal text-2xl text-[#f6e8cd]">Acesso Seguro</p>
                    <p class="mt-2 text-sm text-[#efddbf]">Use as suas credenciais para aceder a plataforma.</p>
                </div>
            </div>

            <div class="flex min-h-[560px] items-center justify-center p-6 sm:p-10">
                <div class="w-full max-w-md">
                    <a href="<?= base_url('/') ?>" class="mx-auto mb-8 flex w-fit items-center gap-3">
                        <img
                            src="<?= base_url('assets/images/logo.png') ?>"
                            alt="Anoxia"
                            class="w-auto"
                        >
                    </a>

                    <h1 class="text-center font-royal text-4xl text-[#f6e8cd]">Iniciar Sessão</h1>
                    <p class="mt-2 text-center text-[#dfc49d]">Autentique-se para aceder a sua conta.</p>

                    <form method="post" action="<?= base_url('auth/login') ?>" class="mt-8 space-y-4 text-sm" novalidate id="loginForm">
                        <?= csrf_field() ?>

                        <div>
                            <label class="mb-1 block text-[#dfc49d]">E-mail</label>
                            <input
                                type="email"
                                id="email"
                                name="email"
                                placeholder="seu@email.com"
                                value="<?= esc(old('email')) ?>"
                                required
                                class="w-full rounded-lg border border-[#a87b4f]/35 bg-[#3e2718] px-3 py-2 text-[#f5e5ca] placeholder:text-[#d0ae80] outline-none focus:ring-2 focus:ring-[#d5b078] transition"
                            >
                            <p id="emailError" class="mt-1 hidden text-xs text-[#f6ccc3]"></p>
                        </div>

                        <div>
                            <label class="mb-1 block text-[#dfc49d]">Palavra-passe</label>
                            <div class="relative">
                                <input
                                    type="password"
                                    id="password"
                                    name="password"
                                    placeholder="Introduza a sua palavra-passe"
                                    required
                                    autocomplete="off"
                                    class="w-full rounded-lg border border-[#a87b4f]/35 bg-[#3e2718] px-3 py-2 pr-24 text-[#f5e5ca] placeholder:text-[#d0ae80] outline-none focus:ring-2 focus:ring-[#d5b078] transition"
                                >
                                <button
                                    type="button"
                                    id="togglePassword"
                                    class="absolute right-1.5 top-1/2 inline-flex h-8 w-8 -translate-y-1/2 items-center p-1 justify-center rounded-md border border-[#8e653f] bg-[#6f4929] text-[#f3e2c7] hover:bg-[#7e5430] transition"
                                    aria-label="Mostrar palavra-passe"
                                    title="Mostrar palavra-passe"
                                >
                                    <i id="eyeOpenIcon" class="ri-eye-line text-[18px] leading-none" aria-hidden="true"></i>
                                    <i id="eyeClosedIcon" class="ri-eye-off-line hidden text-[18px] leading-none" aria-hidden="true"></i>
                                </button>
                            </div>
                            <p id="passwordError" class="mt-1 hidden text-xs text-[#f6ccc3]"></p>
                        </div>

                        <div class="flex items-center justify-between gap-3">
                            <label class="inline-flex items-center gap-2 text-[#dfc49d]">
                                <input
                                    type="checkbox"
                                    name="remember_me"
                                    value="1"
                                >
                                <span>Lembrar-me</span>
                            </label>
                            <a href="#" id="openRecoverPasswordLink" class="text-[#d4b07a] hover:text-[#f6e8cd] transition">Recuperar acesso</a>
                        </div>

                        <button
                            type="submit"
                            class="w-full rounded-lg border border-[#d4b07a] bg-[#c89b60] px-4 py-2 font-semibold text-[#2d1c12] hover:bg-[#dbb780] transition"
                        >
                            Iniciar sessão
                        </button>
                    </form>
                </div>
            </div>
        </section>
    </main>

    <div id="toastContainer" class="fixed bottom-4 right-4 z-50 flex w-[320px] max-w-[90vw] flex-col gap-2"></div>

    <?php include(APPPATH . 'Views/modals/recover_password.php'); ?>

    <script>
        (() => {
            const toastContainer = document.getElementById('toastContainer');
            const authError = <?= json_encode($authError) ?>;
            const authInfo = <?= json_encode($authInfo) ?>;

            const showToast = (message, type = 'danger') => {
                if (!toastContainer || !message) return;

                const toastStyles = {
                    success: 'border-[#6f9b5a] bg-[#d8edce] text-[#264a1e]',
                    warning: 'border-[#b4895f] bg-[#f3e0b6] text-[#5c3a1a]',
                    danger: 'border-[#b66b5a] bg-[#f3cbc2] text-[#5f1f19]',
                    info: 'border-[#8d643d] bg-[#4b301d] text-[#f0ddbf]',
                };

                const toast = document.createElement('div');
                toast.className = `rounded-lg border px-4 py-3 text-sm shadow-lg transition ${toastStyles[type] || toastStyles.danger}`;
                toast.innerHTML = `
                    <div class="flex items-start justify-between gap-3">
                        <span>${message}</span>
                        <button class="toast-close rounded px-2 py-0.5 font-semibold hover:opacity-80">x</button>
                    </div>
                `;
                toastContainer.appendChild(toast);

                const remove = () => {
                    toast.classList.add('opacity-0', 'translate-x-2');
                    setTimeout(() => toast.remove(), 180);
                };

                toast.querySelector('.toast-close')?.addEventListener('click', remove);
                setTimeout(remove, 5000);
            };

            if (authError) showToast(authError, 'danger');
            if (authInfo) showToast(authInfo, 'success');

            // Open password recovery modal
            const openRecoverPasswordLink = document.getElementById('openRecoverPasswordLink');
            openRecoverPasswordLink?.addEventListener('click', (e) => {
                e.preventDefault();
                if (typeof window.openRecoverPasswordModal === 'function') {
                    window.openRecoverPasswordModal();
                }
            });

            const slides = document.querySelectorAll('[data-slide]');
            if (slides.length) {
                let active = 0;
                setInterval(() => {
                    slides[active].classList.add('opacity-0');
                    slides[active].classList.remove('opacity-100');
                    active = (active + 1) % slides.length;
                    slides[active].classList.remove('opacity-0');
                    slides[active].classList.add('opacity-100');
                }, 4200);
            }

            const form = document.getElementById('loginForm');
            const email = document.getElementById('email');
            const password = document.getElementById('password');
            const togglePassword = document.getElementById('togglePassword');
            const emailError = document.getElementById('emailError');
            const passwordError = document.getElementById('passwordError');

            if (!form || !email || !password || !emailError || !passwordError) return;

            if (togglePassword) {
                const eyeOpenIcon = document.getElementById('eyeOpenIcon');
                const eyeClosedIcon = document.getElementById('eyeClosedIcon');

                togglePassword.addEventListener('click', () => {
                    const showing = password.type === 'text';
                    password.type = showing ? 'password' : 'text';
                    eyeOpenIcon?.classList.toggle('hidden', !showing);
                    eyeClosedIcon?.classList.toggle('hidden', showing);
                    togglePassword.setAttribute('aria-label', showing ? 'Mostrar palavra-passe' : 'Ocultar palavra-passe');
                    togglePassword.setAttribute('title', showing ? 'Mostrar palavra-passe' : 'Ocultar palavra-passe');
                });
            }

            const errorBorder = 'border-[#b66b5a]';
            const errorRing = 'focus:ring-[#b66b5a]';
            const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

            const clearField = (field, errorEl) => {
                field.classList.remove(errorBorder, errorRing);
                errorEl.textContent = '';
                errorEl.classList.add('hidden');
            };

            const setFieldError = (field, errorEl, message) => {
                field.classList.add(errorBorder, errorRing);
                errorEl.textContent = message;
                errorEl.classList.remove('hidden');
            };

            email.addEventListener('input', () => clearField(email, emailError));
            password.addEventListener('input', () => clearField(password, passwordError));

            form.addEventListener('submit', (event) => {
                let hasError = false;
                const emailValue = email.value.trim();
                const passwordValue = password.value.trim();

                if (!emailValue) {
                    setFieldError(email, emailError, 'Campo obrigatorio.');
                    hasError = true;
                } else if (!emailPattern.test(emailValue)) {
                    setFieldError(email, emailError, 'E-mail invalido.');
                    hasError = true;
                } else {
                    clearField(email, emailError);
                }

                if (!passwordValue) {
                    setFieldError(password, passwordError, 'Campo obrigatorio.');
                    hasError = true;
                } else {
                    clearField(password, passwordError);
                }

                if (hasError) {
                    event.preventDefault();
                }
            });

        })();
    </script>
</body>
</html>
