<form method="post" action="<?= base_url('auth/login') ?>" class="space-y-4 text-sm" id="loginForm" onsubmit="handleLogin(event)">
    <?= csrf_field() ?>
    
    <div>
        <label class="mb-1 block text-[#dfc49d]">Email</label>
        <input 
            type="email" 
            name="email" 
            placeholder="commander@keep.local" 
            required 
            class="w-full rounded-lg border border-[#a87b4f]/35 bg-[#3e2718] px-3 py-2 text-[#f5e5ca] placeholder:text-[#d0ae80] outline-none focus:ring-2 focus:ring-[#d5b078] transition"
        >
    </div>
    
    <div>
        <label class="mb-1 block text-[#dfc49d]">Password</label>
        <input 
            type="password" 
            name="password" 
            placeholder="Enter your password" 
            required 
            class="w-full rounded-lg border border-[#a87b4f]/35 bg-[#3e2718] px-3 py-2 text-[#f5e5ca] placeholder:text-[#d0ae80] outline-none focus:ring-2 focus:ring-[#d5b078] transition"
        >
    </div>
    
    <div>
        <label class="flex items-center gap-2 rounded-lg border border-[#8b623d] bg-[#4a2f1d] px-3 py-2 cursor-pointer hover:bg-[#553620] transition">
            <input 
                type="checkbox" 
                name="remember_me" 
                value="1" 
                class="h-4 w-4 rounded border-[#a67b50] bg-[#3e2818] text-[#d4b07a] accent-[#d4b07a]"
            >
            <span class="text-[#dfc49d]">Remember me for 30 days</span>
        </label>
    </div>
    
    <div class="flex flex-wrap gap-3 pt-2">
        <button 
            type="submit" 
            class="flex-1 rounded-lg border border-[#d4b07a] bg-[#c89b60] px-4 py-2 font-semibold text-[#2d1c12] hover:bg-[#dbb780] transition"
        >
            Enter Keep
        </button>
        <button 
            type="button" 
            onclick="closeLoginModal()" 
            class="rounded-lg border border-[#8e653f] bg-[#6f4929] px-4 py-2 font-semibold text-[#f3e2c7] hover:bg-[#7e5430] transition"
        >
            Cancel
        </button>
    </div>
</form>
