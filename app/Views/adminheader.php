<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/442b633764.js" crossorigin="anonymous"></script>
    <?= view('style') ?>
</head>
<body>
<div id="sidebar" class="sidebar">
    <button class="toggle-btn">&#9776;</button>
    <div class="sidebar-sticky">
        <ul class="nav flex-column" style="padding-left: 0px;">

        <?php 
        
        $session = session();
        

        if ($session->get('userType') === 'ITSO_Personnel'): ?>
            <li class="nav-item">
                <a class="nav-link" aria-current="page" href="<?= base_url('itso_dashboard') ?>">
                    <i class="fa-solid fa-gauge" style="color: #ffffff;"></i>
                    <span class="nav-text">Dashboard</span>
                </a>
            </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('user_management') ?>">
                        <i class="fa-solid fa-user-cog" style="color: #ffffff;"></i>
                        <span class="nav-text">User Management</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('equipment_management') ?>">
                        <i class="fa-solid fa-laptop" style="color: #ffffff;"></i>
                        <span class="nav-text">Equipment Management</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('reports') ?>">
                        <i class="fa-solid fa-file-alt" style="color: #ffffff;"></i>
                        <span class="nav-text">Reports</span>
                    </a>
                </li>
                  <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('logout') ?>">
                        <i class="fa-solid fa-sign-out-alt" style="color: #ffffff;"></i>
                        <span class="nav-text">Logout</span>
                    </a>
                </li>


            <?php elseif ($session->get('userType') === 'Student'): ?>
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('borrow') ?>">
                        <i class="fa-solid fa-hand-holding" style="color: #ffffff;"></i>
                        <span class="nav-text">Borrow</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('return') ?>">
                        <i class="fa-solid fa-undo" style="color: #ffffff;"></i>
                        <span class="nav-text">Return</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('logout') ?>">
                        <i class="fa-solid fa-sign-out-alt" style="color: #ffffff;"></i>
                        <span class="nav-text">Logout</span>
                    </a>
                </li>


            <?php elseif ($session->get('userType') === 'Associate'): ?>
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('borrow') ?>">
                        <i class="fa-solid fa-hand-holding" style="color: #ffffff;"></i>
                        <span class="nav-text">Borrow</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('return') ?>">
                        <i class="fa-solid fa-undo" style="color: #ffffff;"></i>
                        <span class="nav-text">Return</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('reservation') ?>">
                        <i class="fa-solid fa-calendar-check" style="color: #ffffff;"></i>
                        <span class="nav-text">Reservation</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('logout') ?>">
                        <i class="fa-solid fa-sign-out-alt" style="color: #ffffff;"></i>
                        <span class="nav-text">Logout</span>
                    </a>
                </li>
            <?php endif; ?>
        </ul>
    </div>
</div>

<script>
document.querySelector('.toggle-btn').addEventListener('click', function() {
    document.getElementById('sidebar').classList.toggle('active');
});
</script>
</body>
</html>
