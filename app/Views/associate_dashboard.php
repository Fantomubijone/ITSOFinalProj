<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Associate Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/442b633764.js" crossorigin="anonymous"></script>
    <?= view('style') ?>
    <style>
        .content {
            padding: 1.5em;
            background: white;
            border-radius: 0.5em;
            box-shadow: 0 0.5em 1em rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>
<?= view('adminheader') ?>
<div class="container-fluid">
    <div class="row">
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Associate Dashboard</h1>
                <?= view('accounttop') ?>
            </div>
            <div class="content">
                <!-- Placeholder for content -->
                <p>Welcome to the Associate Dashboard. Here you can manage various tasks and view important information.</p>
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