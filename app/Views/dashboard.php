<?= view('header') ?>
<div class="dashboard-container">
    <h1>Welcome to the Dashboard</h1>
    <p>Your user type is: <?= $userType ?></p>
    <a href="<?= base_url('logout') ?>" class="btn btn-danger w-100">Logout</a>
</div>

<?php if ($userType == 'ITSO_Personnel'): ?>
    <script>window.location.href = "<?= base_url('itso_dashboard') ?>";</script>
<?php elseif ($userType == 'Associate'): ?>
    <script>window.location.href = "<?= base_url('associate_dashboard') ?>";</script>
<?php elseif ($userType == 'Student'): ?>
    <script>window.location.href = "<?= base_url('student_dashboard') ?>";</script>
<?php else: ?>
    <script>window.location.href = "<?= base_url('/') ?>";</script>
<?php endif; ?>
