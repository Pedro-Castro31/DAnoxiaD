<form method="post" action="<?php echo base_url('auth/login'); ?>">
    <?= csrf_field() ?>
    <input type="email" name="email" placeholder="Email" required style="width: 100%; padding: 8px; margin-bottom: 10px;">
    <input type="password" name="password" placeholder="Password" required style="width: 100%; padding: 8px; margin-bottom: 10px;">
    <label style="display: block; margin-bottom: 10px;">
        <input type="checkbox" name="remember_me" value="1">
        Remember me for 30 days
    </label>
    <button type="submit" style="width: 100%; padding: 8px;">Submit</button>
</form>
