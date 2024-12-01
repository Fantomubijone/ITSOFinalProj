<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New User</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <?= view('style') ?>
</head>
<body>
<?= view('header') ?>
<div class="login-container" style="max-width: 600px;">
    <h1 style="font-weight: Bold;">Add New User</h1>
    <?php if (session()->getFlashdata('validation')): ?>
        <div class="alert alert-danger"><?= session()->getFlashdata('validation')->listErrors() ?></div>
    <?php endif; ?>
    <form id="registrationForm" action="<?= base_url('user_management/store') ?>" method="post">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <input type="text" id="first_name" name="first_name" placeholder=" " required>
                    <label for="first_name">First Name</label>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <input type="text" id="last_name" name="last_name" placeholder=" " required>
                    <label for="last_name">Last Name</label>
                </div>
            </div>
        </div>
        <div class="form-group">
            <input type="text" id="school_id" name="school_id" placeholder=" " required>
            <label for="school_id">School ID</label>
        </div>
        <div class="form-group">
            <input type="email" id="email" name="email" placeholder=" " required>
            <label for="email">Email</label>
        </div>
        <div class="form-group">
            <input type="password" id="password" name="password" placeholder=" " required>
            <label for="password">Password</label>
        </div>
        <div class="form-group">
            <input type="password" id="confirm_password" name="confirm_password" placeholder=" " required>
            <label for="confirm_password">Confirm Password</label>
        </div>
        <div class="form-group">
            <select id="user_type" name="user_type" required>
                <option value="" disabled selected>Select User Type</option>
                <option value="ITSO_Personnel">ITSO Personnel</option>
                <option value="Associate">Associate</option>
                <option value="Student">Student</option>
            </select>
        </div>
        <div class="d-flex justify-content-between">
            <button type="submit" class="btn btn-primary">Register</button>
            <a href="<?= base_url('user_management') ?>" class="btn btn-primary" style = "width: 100%; background-color: #00796b; border: none; margin-top: 10px">Cancel</a>
        </div>
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://kit.fontawesome.com/a076d05399.js"></script>
</body>
</html>
