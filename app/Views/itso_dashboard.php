<?= view('adminheader') ?>
<div class="container-fluid">
    <div class="row">
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">ITSO Dashboard</h1>

                <div class="profile">
                    <i class="fa-solid fa-user"></i>
                    <div class="profile-info">
                        <p class="name"><?= $first_name ?> <?= $last_name ?></p>
                        <p class="email"><?= $email ?></p>
                    </div>
                </div>
            </div>
            <div class="content">
              
            </div>
        </main>
    </div>
</div>

<script>
    function checkWindowSize() {
        if (window.innerWidth <= 768) {
            document.getElementById('sidebar').classList.add('collapsed');
            document.querySelector('.container-fluid').classList.add('collapsed');
        } else {
            document.getElementById('sidebar').classList.remove('collapsed');
            document.querySelector('.container-fluid').classList.remove('collapsed');
        }
    }

    window.addEventListener('resize', checkWindowSize);
    window.addEventListener('load', checkWindowSize);

    document.querySelector('.toggle-btn').addEventListener('click', function() {
        document.getElementById('sidebar').classList.toggle('collapsed');
        document.querySelector('.container-fluid').classList.toggle('collapsed');
    });
</script>
</body>
</html>
