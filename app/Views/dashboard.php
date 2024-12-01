<?= view('header') ?>
<div class="dashboard-container" style="text-align: center; padding: 20px;">
    <img src="https://upload.wikimedia.org/wikipedia/en/6/62/FEU_Tech_official_seal.png" alt="FEU Tech Seal" style="max-width: 100%; height: auto;">
</div>

<?php
if ($userType == 'ITSO_Personnel') {
    echo '<script>window.location.href = "'. base_url('itso_dashboard') . '";</script>';
} elseif ($userType == 'Associate') {
    echo '<script>window.location.href = "'. base_url('associate_dashboard') . '";</script>';
} elseif ($userType == 'Student') {
    echo '<script>window.location.href = "'. base_url('student_dashboard') . '";</script>';
} else {
    echo '<script>window.location.href = "'. base_url('/') . '";</script>';
}
?>
