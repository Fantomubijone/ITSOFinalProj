<?= view('header') ?>
<div class="login-container">
    <h1 style="font-weight: Bold;">ITSO Management System</h1>
    <?php if (session()->getFlashdata('msg')): ?>
        <div class="alert alert-danger text-center"><?= session()->getFlashdata('msg') ?></div>
    <?php endif; ?>
    <form action="<?= base_url('processLogin') ?>" method="post">
        <div class="form-group">
            <input type="email" id="email" name="email" placeholder=" " required>
            <label for="email">Email</label>
        </div>
        <div class="form-group">
            <input type="password" id="password" name="password" placeholder=" " required>
            <label for="password">Password</label>
        </div>
        <button type="submit" class="btn btn-primary w-100 mb-3">Login</button>
    </form>
    <p class="register-link">Don't have an account? <a href="<?= base_url('register') ?>" class="no-underline">Register now</a></p>
</div>
</body>
</html>
