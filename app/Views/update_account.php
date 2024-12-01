<?= view('adminheader') ?>
<div class="container-fluid">
    <div class="row">
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4" style="margin-right: 20px">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Edit Profile</h1>
            </div>

            <?php if (session()->has('error')): ?>
                <div class="alert alert-danger"><?= session('error') ?></div>
            <?php endif; ?>

            <?php if (session()->has('success')): ?>
                <div class="alert alert-success"><?= session('success') ?></div>
            <?php endif; ?>

            <div>
                <form id="editProfileForm" action="<?= base_url('user_management/updateCurrent') ?>" method="post" onsubmit="return validateForm()">
                    <div class="mb-3">
                        <label for="first_name" class="form-label">First Name</label>
                        <input type="text" class="form-control" id="first_name" name="first_name" value="<?= $first_name ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="last_name" class="form-label">Last Name</label>
                        <input type="text" class="form-control" id="last_name" name="last_name" value="<?= $last_name ?>">
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" value="<?= $email ?>" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="role" class="form-label">Role</label>
                        <input type="text" class="form-control" id="role" name="role" value="<?= $role ?>" readonly>
                    </div>
                    
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" value="" id="updatePasswordCheck" onclick="togglePasswordFields()">
                        <label class="form-check-label" for="updatePasswordCheck">
                            Update Password
                        </label>
                    </div>
                    
                    <div id="passwordFields" style="display: none;">
                        <div class="mb-3">
                            <label for="old_password" class="form-label">Old Password</label>
                            <input type="password" class="form-control" id="old_password" name="old_password">
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">New Password</label>
                            <input type="password" class="form-control" id="password" name="password">
                        </div>
                        <div class="mb-3">
                            <label for="confirm_password" class="form-label">Confirm Password</label>
                            <input type="password" class="form-control" id="confirm_password" name="confirm_password">
                        </div>
                    </div>
                    
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                    <a href="<?= base_url('/') ?>" class="btn btn-secondary">Cancel</a>
                </form>
            </div>
        </main>
    </div>
</div>

<!-- JavaScript for form validation and toggling password fields -->
<script>
function togglePasswordFields() {
    const passwordFields = document.getElementById('passwordFields');
    const inputs = passwordFields.querySelectorAll('input');
    const updatePasswordChecked = document.getElementById('updatePasswordCheck').checked;

    if (!updatePasswordChecked) {
        // Clear the input fields if the checkbox is untoggled
        inputs.forEach(input => {
            input.value = '';
        });
    }

    passwordFields.style.display = updatePasswordChecked ? 'block' : 'none';

    inputs.forEach(input => {
        input.required = updatePasswordChecked; // Set required attribute based on checkbox
    });
}

function validateForm() {
    const updatePasswordChecked = document.getElementById('updatePasswordCheck').checked;

    if (updatePasswordChecked) {
        const oldPassword = document.getElementById('old_password').value;
        const newPassword = document.getElementById('password').value;
        const confirmPassword = document.getElementById('confirm_password').value;

        if (!oldPassword || !newPassword || !confirmPassword) {
            alert('All password fields are required when updating the password.');
            return false;
        }

        if (newPassword === oldPassword) {
            alert('New password cannot be the same as the old password.');
            return false;
        }

        if (newPassword !== confirmPassword) {
            alert('New password and confirm password do not match.');
            return false;
        }

        if (newPassword.length < 8) {
            alert('New password must be at least 8 characters long.');
            return false;
        }
    }

    return true;
}
</script>

<!-- CSS for better alignment and margins -->
<style>
.container-fluid {
    margin: auto 6em;
}
.mb-3 {
    margin-bottom: 1.5rem;
}

.form-control {
    padding: 10px;
    margin-bottom: 10px;
}

.btn-primary {
    background-color: #00796b;
    border: none;
    color: white;
    padding: 10px 20px;
    border-radius: 4px;
    cursor: pointer;
    transition: background-color 0.2s ease-in-out;
}

.btn-primary:hover {
    background-color: #005b4e;
}

.btn-secondary {
    background-color: #6c757d;
    border: none;
    color: white;
    padding: 10px 20px;
    border-radius: 4px;
    cursor: pointer;
    transition: background-color 0.2s ease-in-out;
    margin-left: 10px;
}

.btn-secondary:hover {
    background-color: #5a6268;
}

h2 {
    color: #00796b;
}
</style>
