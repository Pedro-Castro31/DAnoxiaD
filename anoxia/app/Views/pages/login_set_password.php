<?php
$resetError = session()->getFlashdata('reset_error');
$resetInfo = session()->getFlashdata('reset_info');
?>
<!DOCTYPE html>
<html lang="pt-PT">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Redefinir Palavra-passe | Anoxia</title>
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Alegreya:wght@400;500;700;800&family=Cinzel:wght@500;700;800&family=Cormorant+Garamond:wght@400;500;700&display=swap" rel="stylesheet">
	<link href="https://cdn.jsdelivr.net/npm/remixicon@4.5.0/fonts/remixicon.css" rel="stylesheet">
	<link rel="stylesheet" href="<?= base_url('assets/css/app.css') ?>">
</head>
<body class="min-h-screen bg-[#2f1e14] text-[#f4e3c8] font-tavern">
	<div class="absolute inset-0 -z-10 bg-[radial-gradient(circle_at_20%_10%,#70472a_0%,#4b301f_42%,#2a1a12_100%)]"></div>

	<main class="mx-auto grid min-h-screen w-full max-w-7xl place-items-center px-6 py-8">
		<section class="w-full overflow-hidden rounded-3xl border border-[#8d643d]/35 bg-[#5a3923]/65 p-8 shadow-[0_14px_34px_rgba(10,6,4,0.35)] sm:p-10">
			<a href="<?= base_url('login') ?>" class="mx-auto mb-6 flex w-fit items-center gap-3">
				<img src="<?= base_url('assets/images/logo.png') ?>" alt="Anoxia" class="w-auto" style="height: 200px;">
			</a>

			<h1 class="text-center font-royal text-4xl text-[#f6e8cd]">Redefinir Palavra-passe</h1>
			<p class="mt-2 text-center text-[#dfc49d]">Crie uma nova palavra-passe para a sua conta.</p>

			<?php if ($resetError): ?>
				<div class="mt-6 rounded-lg border border-[#b66b5a] bg-[#f3cbc2] px-4 py-3 text-sm text-[#5f1f19]">
					<?= esc($resetError) ?>
				</div>
			<?php endif; ?>

			<?php if ($resetInfo): ?>
				<div class="mt-6 rounded-lg border border-[#6f9b5a] bg-[#d8edce] px-4 py-3 text-sm text-[#264a1e]">
					<?= esc($resetInfo) ?>
				</div>
			<?php endif; ?>

			<form method="post" action="<?= base_url('auth/reset-password') ?>" class="mt-8 space-y-4 text-sm" novalidate id="resetPasswordForm">
				<?= csrf_field() ?>
				<input type="hidden" name="token" value="<?= esc($token ?? '') ?>">

				<div>
					<label class="mb-1 block text-[#dfc49d]">Nova palavra-passe</label>
					<input
						type="password"
						id="password"
						name="password"
						required
						minlength="8"
						autocomplete="new-password"
						placeholder="Minimo 8 caracteres"
						class="w-full rounded-lg border border-[#a87b4f]/35 bg-[#3e2718] px-3 py-2 text-[#f5e5ca] placeholder:text-[#d0ae80] outline-none focus:ring-2 focus:ring-[#d5b078] transition"
					>
					<p id="passwordError" class="mt-1 hidden text-xs text-[#f6ccc3]"></p>
				</div>

				<div>
					<label class="mb-1 block text-[#dfc49d]">Confirmar palavra-passe</label>
					<input
						type="password"
						id="passwordConfirm"
						name="password_confirm"
						required
						minlength="8"
						autocomplete="new-password"
						placeholder="Repita a palavra-passe"
						class="w-full rounded-lg border border-[#a87b4f]/35 bg-[#3e2718] px-3 py-2 text-[#f5e5ca] placeholder:text-[#d0ae80] outline-none focus:ring-2 focus:ring-[#d5b078] transition"
					>
					<p id="passwordConfirmError" class="mt-1 hidden text-xs text-[#f6ccc3]"></p>
				</div>

				<button
					type="submit"
					class="w-full rounded-lg border border-[#d4b07a] bg-[#c89b60] px-4 py-2 font-semibold text-[#2d1c12] hover:bg-[#dbb780] transition"
				>
					Atualizar palavra-passe
				</button>

				<p class="text-center text-xs text-[#dfc49d]">
					Este link expira em 1 hora. Se expirou, solicite um novo pedido.
				</p>
			</form>
		</section>
	</main>

	<script>
		(() => {
			const form = document.getElementById('resetPasswordForm');
			const password = document.getElementById('password');
			const passwordConfirm = document.getElementById('passwordConfirm');
			const passwordError = document.getElementById('passwordError');
			const passwordConfirmError = document.getElementById('passwordConfirmError');

			if (!form || !password || !passwordConfirm || !passwordError || !passwordConfirmError) return;

			const errorBorder = 'border-[#b66b5a]';
			const errorRing = 'focus:ring-[#b66b5a]';

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

			password.addEventListener('input', () => clearField(password, passwordError));
			passwordConfirm.addEventListener('input', () => clearField(passwordConfirm, passwordConfirmError));

			form.addEventListener('submit', (event) => {
				let hasError = false;
				const passwordValue = password.value.trim();
				const confirmValue = passwordConfirm.value.trim();

				if (!passwordValue) {
					setFieldError(password, passwordError, 'Campo obrigatorio.');
					hasError = true;
				} else if (passwordValue.length < 8) {
					setFieldError(password, passwordError, 'Minimo 8 caracteres.');
					hasError = true;
				}

				if (!confirmValue) {
					setFieldError(passwordConfirm, passwordConfirmError, 'Campo obrigatorio.');
					hasError = true;
				} else if (passwordValue && confirmValue !== passwordValue) {
					setFieldError(passwordConfirm, passwordConfirmError, 'As palavras-passe nao coincidem.');
					hasError = true;
				}

				if (hasError) event.preventDefault();
			});
		})();
	</script>
</body>
</html>
