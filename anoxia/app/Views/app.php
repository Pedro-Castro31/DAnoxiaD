<!DOCTYPE html>
<html lang="pt-PT">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'Anoxia') ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="apple-touch-icon" sizes="180x180" href="<?= base_url('apple-touch-icon.png') ?>">
    <link rel="icon" type="image/png" sizes="32x32" href="<?= base_url('favicon-32x32.png') ?>">
    <link rel="icon" type="image/png" sizes="16x16" href="<?= base_url('favicon-16x16.png') ?>">
    <link rel="manifest" href="<?= base_url('site.webmanifest') ?>">
    <link href="https://fonts.googleapis.com/css2?family=Alegreya:wght@400;500;700;800&family=Cinzel:wght@500;700;800&family=Cormorant+Garamond:wght@400;500;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.9.1/fonts/remixicon.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('assets/css/app.css') ?>">
    <style>
        .app-desktop-only {
            display: none;
        }

        @media (min-width: 768px) {
            .app-desktop-only {
                display: flex;
            }

            .app-mobile-inline,
            .app-mobile-block {
                display: none !important;
            }
        }
    </style>
</head>
<body class="min-h-screen bg-[#2f1e14] text-[#f4e3c8] font-tavern">
    <div class="absolute inset-0 -z-10 bg-[radial-gradient(circle_at_20%_10%,#70472a_0%,#4b301f_42%,#2a1a12_100%)]"></div>

    <header class="sticky top-0 z-30 border-b border-[#8b633f]/30 bg-[#2b1c13]/85 backdrop-blur-sm">
        <div class="mx-auto flex max-w-7xl items-center justify-between px-4 py-3 sm:px-6">
            <a href="<?= base_url('/') ?>" class="inline-flex items-center">
                <img src="<?= base_url('assets/images/logo.png') ?>" alt="Anoxia" class="h-9 w-auto">
            </a>

            <div class="app-desktop-only relative items-center gap-3">
                <button
                    type="button"
                    id="avatarMenuButton"
                    class="inline-flex items-center gap-2 rounded-full border border-[#9d7550] bg-[#6d4628] px-2 py-1 text-sm font-semibold text-[#f3e2c7] transition hover:bg-[#7a5232]"
                    aria-label="Abrir menu do utilizador"
                    aria-expanded="false"
                >
                    <span class="inline-flex h-7 w-7 items-center justify-center rounded-full border border-[#b4895f] bg-[#5a3923]">
                        <?= esc(strtoupper(substr((string) (session()->get('user_name') ?? 'U'), 0, 1))) ?>
                    </span>
                    <i class="ri-arrow-down-s-line text-base" aria-hidden="true"></i>
                </button>

                <div
                    id="avatarDropdown"
                    class="absolute right-0 top-12 z-40 hidden w-48 rounded-xl border border-[#8b633f]/30 bg-[#2b1c13]/95 p-2 shadow-lg backdrop-blur-sm"
                >
                    <div class="mb-2 px-3 py-2">
                        <p class="text-xs uppercase tracking-wide text-[#caa679]">Utilizador</p>
                        <p class="mt-0.5 truncate text-sm font-semibold text-[#f3e2c7]">
                            <?= esc((string) (session()->get('user_name') ?? 'Utilizador')) ?>
                        </p>
                    </div>
                    <a
                        href="<?= base_url('auth/logout') ?>"
                        class="inline-flex w-full items-center gap-2 rounded-lg border border-[#8e653f] bg-[#6f4929] px-3 py-2 text-sm font-semibold text-[#f3e2c7] transition hover:bg-[#7e5430]"
                    >
                        <i class="ri-logout-box-r-line text-base" aria-hidden="true"></i>
                        <span>Terminar sessão</span>
                    </a>
                </div>
            </div>

            <button
                type="button"
                id="mobileMenuButton"
                class="app-mobile-inline h-9 w-9 items-center justify-center rounded-md border border-[#8e653f] bg-[#6f4929] text-[#f3e2c7] transition hover:bg-[#7e5430]"
                aria-label="Abrir menu"
            >
                <span class="inline-flex items-center justify-center text-xl leading-none">
                    <i class="ri-menu-line" aria-hidden="true"></i>
                </span>
            </button>
        </div>
    </header>

    <div id="mobileBackdrop" class="app-mobile-block fixed inset-0 z-40 hidden bg-black/60"></div>
    <aside id="mobileOffcanvas" class="app-mobile-block pointer-events-none fixed right-0 top-0 z-50 h-full w-72 translate-x-full border-l border-[#8b633f]/30 bg-[#2b1c13] p-5 transition-transform duration-200">
        <div class="flex items-center justify-between">
            <div class="inline-flex items-center gap-2">
                <span class="inline-flex h-9 w-9 items-center justify-center rounded-full border border-[#9d7550] bg-[#6d4628] text-sm font-semibold text-[#f3e2c7]">
                    <?= esc(strtoupper(substr((string) (session()->get('user_name') ?? 'U'), 0, 1))) ?>
                </span>
                <span class="text-sm text-[#dfc49d]"><?= esc((string) (session()->get('user_name') ?? 'Utilizador')) ?></span>
            </div>
            <button
                type="button"
                id="mobileMenuClose"
                class="inline-flex h-8 w-8 items-center justify-center rounded-md border border-[#8e653f] bg-[#6f4929] text-[#f3e2c7] transition hover:bg-[#7e5430]"
                aria-label="Fechar menu"
            >
                <span class="inline-flex items-center justify-center text-lg leading-none">
                    <i class="ri-close-large-line" aria-hidden="true"></i>
                </span>
            </button>
        </div>
        <div class="mt-6 space-y-3">
            <a href="<?= base_url('auth/logout') ?>" class="inline-flex rounded-lg border border-[#8e653f] bg-[#6f4929] px-4 py-2 text-sm font-semibold text-[#f3e2c7] transition hover:bg-[#7e5430]">
                Terminar sessão
            </a>
        </div>
    </aside>

    <main class="mx-auto w-full max-w-7xl px-4 py-6 sm:px-6">
        <?= $this->renderSection('content') ?>
        <?= $content ?? '' ?>
    </main>

    <script>
        (() => {
            const openBtn = document.getElementById('mobileMenuButton');
            const closeBtn = document.getElementById('mobileMenuClose');
            const offcanvas = document.getElementById('mobileOffcanvas');
            const backdrop = document.getElementById('mobileBackdrop');
            const avatarMenuButton = document.getElementById('avatarMenuButton');
            const avatarDropdown = document.getElementById('avatarDropdown');

            if (!openBtn || !closeBtn || !offcanvas || !backdrop) return;

            const open = () => {
                offcanvas.classList.remove('translate-x-full');
                offcanvas.classList.remove('pointer-events-none');
                backdrop.classList.remove('hidden');
                document.body.classList.add('overflow-hidden');
            };

            const close = () => {
                offcanvas.classList.add('translate-x-full');
                offcanvas.classList.add('pointer-events-none');
                backdrop.classList.add('hidden');
                document.body.classList.remove('overflow-hidden');
            };

            openBtn.addEventListener('click', open);
            closeBtn.addEventListener('click', close);
            backdrop.addEventListener('click', close);
            document.addEventListener('keydown', (event) => {
                if (event.key === 'Escape') close();
            });

            if (avatarMenuButton && avatarDropdown) {
                const openAvatar = () => {
                    avatarDropdown.classList.remove('hidden');
                    avatarMenuButton.setAttribute('aria-expanded', 'true');
                };

                const closeAvatar = () => {
                    avatarDropdown.classList.add('hidden');
                    avatarMenuButton.setAttribute('aria-expanded', 'false');
                };

                avatarMenuButton.addEventListener('click', (event) => {
                    event.stopPropagation();
                    const isHidden = avatarDropdown.classList.contains('hidden');
                    if (isHidden) openAvatar();
                    else closeAvatar();
                });

                document.addEventListener('click', (event) => {
                    if (!avatarDropdown.contains(event.target) && !avatarMenuButton.contains(event.target)) {
                        closeAvatar();
                    }
                });

                document.addEventListener('keydown', (event) => {
                    if (event.key === 'Escape') closeAvatar();
                });
            }
        })();
    </script>
</body>
</html>
