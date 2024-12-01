<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <?= view('style') ?>
</head>
<body>
<?= view('header') ?>
<div class="login-container" style="max-width: 600px;">
    <h1 style="font-weight: Bold;">Edit User</h1>
    <?php if (session()->getFlashdata('errors')): ?>
        <div class="alert alert-danger"><?= session()->getFlashdata('errors') ?></div>
    <?php endif; ?>
    <form id="editUserForm" action="<?= base_url('user_management/update/'.$user['id']) ?>" method="post">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <input type="text" id="first_name" name="first_name" value="<?= $user['first_name'] ?>" placeholder=" " required>
                    <label for="first_name">First Name</label>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <input type="text" id="last_name" name="last_name" value="<?= $user['last_name'] ?>" placeholder=" " required>
                    <label for="last_name">Last Name</label>
                </div>
            </div>
        </div>
        <div class="form-group">
            <input type="text" id="school_id" name="school_id" value="<?= $user['school_id'] ?>" placeholder=" " required>
            <label for="school_id">School ID</label>
        </div>
        <div class="form-group">
            <input type="email" id="email" name="email" value="<?= $user['email'] ?>" placeholder=" " disabled>
            <label for="email">Email</label>
        </div>
        <div class="form-group">
            <input type="password" id="password" name="password" placeholder=" ">
            <label for="password">Password</label>
        </div>
        <div class="form-group">
            <input type="password" id="confirm_password" name="confirm_password" placeholder=" ">
            <label for="confirm_password">Confirm Password</label>
        </div>
        <div class="form-group">
            <select id="user_type" name="user_type" required>
                <option value="" disabled>Select User Type</option>
                <option value="ITSO_Personnel" <?= $user['user_type'] == 'ITSO_Personnel' ? 'selected' : '' ?>>ITSO Personnel</option>
                <option value="Associate" <?= $user['user_type'] == 'Associate' ? 'selected' : '' ?>>Associate</option>
                <option value="Student" <?= $user['user_type'] == 'Student' ? 'selected' : '' ?>>Student</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary w-100">Update</button>
        <a href="<?= base_url('user_management') ?>" class="btn btn-primary" style = "width: 100%; background-color: #00796b; border: none; margin-top: 10px">Cancel</a>

    </form>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://kit.fontawesome.com/a076d05399.js"></script>
</body>
</html>
