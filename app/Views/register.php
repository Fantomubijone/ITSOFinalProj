<?= view('header') ?>
<div class="login-container" style="max-width: 600px;">
    <h1 style="font-weight: Bold;">Account Registration</h1>
    <?php if (isset($validation)): ?>
        <div class="alert alert-danger"><?= $validation->listErrors() ?></div>
    <?php endif; ?>
    <form id="registrationForm" action="<?= base_url('processRegister') ?>" method="post">
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
        <button type="submit" class="btn btn-primary w-100">Register</button>
    </form>
    <p class="register-link">Already have an account? <a href="<?= base_url('/') ?>" class="no-underline">Login here</a></p>

    <!-- Modal -->
    <div class="modal fade" id="verificationModal" tabindex="-1" aria-labelledby="verificationModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content text-center" style="background: rgba(255, 255, 255, 0.9); backdrop-filter: blur(10px); padding: 20px;">
                <div class="modal-body">
                    <img src="https://i.ibb.co/k2DMSbF/tick.png" class="img-fluid mb-3" alt="Email Sent" style="max-width: 150px;">
                    <h1 class="h5 mb-3">Check email for verification</h1>
                    <p>We've sent an email to verify your account. Please confirm the email we sent.</p>
                    <a href="<?= base_url('/') ?>" class="btn btn-primary w-100" style="background-color: #004d40; border: none; border-radius: 8px;">OK</a>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://kit.fontawesome.com/a076d05399.js"></script>
<script>
    $(document).ready(function(){
        <?php if (session()->getFlashdata('success')): ?>
            $('#verificationModal').modal('show');
        <?php endif; ?>

        $('#verificationModal').on('hidden.bs.modal', function () {
            window.location.href = "<?= base_url('/') ?>";
        });

        $('.btn-primary').on('click', function() {
            window.location.href = "<?= base_url('/') ?>";
        });
    });
</script>
</body>
</html>
