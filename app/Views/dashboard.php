<?= view('header') ?>
    <div class="dashboard-container">
        <h1>Welcome to the Dashboard</h1>
        <p>Your user type is: <?= $userType ?></p>
        <a href="<?= base_url('logout') ?>" class="btn btn-danger w-100">Logout</a>
    </div>

