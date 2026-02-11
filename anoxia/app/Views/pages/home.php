<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Anoxia</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Alegreya:wght@400;500;700;800&family=Cinzel:wght@500;700;800&family=Cormorant+Garamond:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('assets/css/app.css') ?>">
</head>
<body class="min-h-screen bg-[#2f1e14] text-[#f4e3c8] font-tavern">
    <div class="absolute inset-0 -z-10 bg-[radial-gradient(circle_at_20%_10%,#70472a_0%,#4b301f_42%,#2a1a12_100%)]"></div>

    <?= view('partials/navbar') ?>

    <main class="mx-auto flex max-w-7xl flex-col gap-6 px-6 py-8">
        <section class="rounded-3xl border border-[#8d643d]/35 bg-[#5a3923]/70 p-6 shadow-[0_14px_34px_rgba(10,6,4,0.35)]">
            <?php if (session()->get('logged_in')): ?>
                <h1 class="font-royal text-4xl text-[#f6e8cd]">Welcome, <?= esc(session()->get('user_name')) ?></h1>
                <p class="mt-2 max-w-3xl text-[#dfc49d]">Your medieval command center is ready. The war room awaits your orders.</p>
            <?php else: ?>
                <h1 class="font-royal text-4xl text-[#f6e8cd]">Welcome to Anoxia</h1>
                <p class="mt-2 max-w-3xl text-[#dfc49d]">Your medieval command center awaits. Login to access the war room.</p>
            <?php endif; ?>
        </section>

        <!-- Database Test -->
        <section class="rounded-3xl border border-[#8d643d]/35 bg-[#5a3923]/70 p-6 shadow-[0_14px_34px_rgba(10,6,4,0.35)]">
            <h2 class="font-royal text-2xl text-[#f6e8cd] mb-4">Database Test - All Users</h2>
            <p class="text-[#dfc49d] mb-4">Status: <strong><?= esc($db_status ?? 'Unknown') ?></strong></p>
            
            <?php if (!empty($users)): ?>
                <div class="overflow-x-auto">
                    <table class="w-full text-left border border-[#8d643d]">
                        <thead class="bg-[#4a2f1d] text-[#f6e8cd]">
                            <tr>
                                <th class="px-4 py-2 border border-[#8d643d]">ID</th>
                                <th class="px-4 py-2 border border-[#8d643d]">Name</th>
                                <th class="px-4 py-2 border border-[#8d643d]">Email</th>
                                <th class="px-4 py-2 border border-[#8d643d]">Admin</th>
                                <th class="px-4 py-2 border border-[#8d643d]">Has Password</th>
                            </tr>
                        </thead>
                        <tbody class="text-[#dfc49d]">
                            <?php foreach ($users as $user): ?>
                                <tr class="hover:bg-[#3e2718]">
                                    <td class="px-4 py-2 border border-[#8d643d]"><?= esc($user->id) ?></td>
                                    <td class="px-4 py-2 border border-[#8d643d]"><?= esc($user->name) ?></td>
                                    <td class="px-4 py-2 border border-[#8d643d]"><?= esc($user->email) ?></td>
                                    <td class="px-4 py-2 border border-[#8d643d]"><?= $user->is_admin ? 'Yes' : 'No' ?></td>
                                    <td class="px-4 py-2 border border-[#8d643d]"><?= $user->password_hash ? 'Yes' : 'No' ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <p class="text-[#b66b5a]">No users found or database error.</p>
            <?php endif; ?>
        </section>
    </main>

    <!-- Login Modal -->
    <div id="loginModal" class="invisible fixed inset-0 z-40 grid place-items-center bg-black/60 opacity-0 transition">
        <div class="w-[92vw] max-w-md rounded-2xl border border-[#9b7450] bg-[#3f2819] p-6 shadow-2xl">
            <div class="flex items-start justify-between gap-3">
                <div>
                    <h3 class="font-royal text-2xl text-[#f3e1c3]">Enter the Keep</h3>
                    <p class="mt-1 text-sm text-[#dfc49d]">Authenticate to access the war room</p>
                </div>
                <button onclick="closeLoginModal()" class="rounded px-2 py-0.5 text-2xl hover:bg-[#6a4328]">&times;</button>
            </div>
            <div class="mt-4">
            </div>
        </div>
    </div>

    <!-- Toast Container -->
    <div id="toastContainer" class="fixed bottom-4 right-4 z-50 flex w-[320px] max-w-[90vw] flex-col gap-2"></div>

    <script>
        function openLoginModal() {
            const modal = document.getElementById('loginModal');
            modal.classList.remove('invisible', 'opacity-0');
        }
        
        function closeLoginModal() {
            const modal = document.getElementById('loginModal');
            modal.classList.add('opacity-0');
            setTimeout(() => modal.classList.add('invisible'), 150);
        }
        
        // Close modal when clicking backdrop
        document.getElementById('loginModal')?.addEventListener('click', (e) => {
            if (e.target.id === 'loginModal') {
                closeLoginModal();
            }
        });
        
        // Toast functionality
        function showToast(message, type = 'danger') {
            const toastContainer = document.getElementById('toastContainer');
            if (!toastContainer) return;
            
            const toastStyles = {
                success: 'border-[#6f9b5a] bg-[#d8edce] text-[#264a1e]',
                warning: 'border-[#b4895f] bg-[#f3e0b6] text-[#5c3a1a]',
                danger: 'border-[#b66b5a] bg-[#f3cbc2] text-[#5f1f19]',
                info: 'border-[#8d643d] bg-[#4b301d] text-[#f0ddbf]'
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
        }
        
        // Handle login form submission via AJAX
        async function handleLogin(event) {
            event.preventDefault();
            
            const form = event.target;
            const formData = new FormData(form);
            const submitBtn = form.querySelector('button[type="submit"]');
            const originalText = submitBtn.textContent;
            
            // Disable button and show loading
            submitBtn.disabled = true;
            submitBtn.textContent = 'Authenticating...';
            
            try {
                const response = await fetch(form.action, {
                    method: 'POST',
                    body: formData
                });
                
                console.log('Response status:', response.status);
                console.log('Response headers:', response.headers.get('content-type'));
                
                const responseText = await response.text();
                console.log('Response text:', responseText.substring(0, 500));
                
                // Try to parse as JSON
                let result;
                try {
                    result = JSON.parse(responseText);
                } catch (e) {
                    throw new Error('Server returned HTML error page instead of JSON. Check server logs.');
                }
                
                console.log('Response data:', result);
                
                if (result.success) {
                    // Show success toast
                    showToast('Welcome back, ' + result.user.name + '!', 'success');
                    
                    // Close modal
                    closeLoginModal();
                    
                    // Update navbar
                    updateNavbar(result.user);
                    
                    // Reset form
                    form.reset();
                } else {
                    // Show error toast
                    showToast(result.message, 'danger');
                }
            } catch (error) {
                console.error('Login error:', error);
                console.error('Error name:', error.name);
                console.error('Error message:', error.message);
                console.error('Error stack:', error.stack);
                showToast('Connection error. Please try again.', 'danger');
            } finally {
                // Re-enable button
                submitBtn.disabled = false;
                submitBtn.textContent = originalText;
            }
        }
        
        // Update navbar after successful login
        function updateNavbar(user) {
            const navbarActions = document.getElementById('navbarActions');
            if (!navbarActions) return;
            
            navbarActions.innerHTML = `
                <div class="flex items-center gap-3">
                    <span class="rounded-full border border-[#9d7550] bg-[#6d4628] px-4 py-2 text-sm font-semibold uppercase tracking-wide text-[#f3e2c7]">
                        ${escapeHtml(user.name)}
                    </span>
                    <a href="<?= base_url('auth/logout') ?>" class="rounded-lg border border-[#8e653f] bg-[#6f4929] px-4 py-2 font-semibold text-[#f3e2c7] hover:bg-[#7e5430] transition">
                        Logout
                    </a>
                </div>
            `;
        }
        
        // Helper function to escape HTML
        function escapeHtml(text) {
            const div = document.createElement('div');
            div.textContent = text;
            return div.innerHTML;
        }
        
        // Debug: log session data
        console.log('Logged in:', <?= json_encode((bool)session()->get('logged_in')) ?>);
        console.log('User name:', <?= json_encode(session()->get('user_name')) ?>);
    </script>
</body>
</html>