<?= view('adminheader') ?>
<div class="container-fluid">
    <div class="row">
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">ITSO Dashboard</h1>
                <?= view('accounttop') ?>
                
            </div>
            <div class="dashboard-container" style="text-align: center; padding: 20px;">
                <img src="https://upload.wikimedia.org/wikipedia/en/6/62/FEU_Tech_official_seal.png" alt="FEU Tech Seal" style="max-width: 100%; height: auto;">
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
