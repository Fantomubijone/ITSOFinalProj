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