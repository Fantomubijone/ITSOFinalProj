<?= view('adminheader') ?>
<div class="container-fluid">
    <div class="row">
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">User Management</h1>

                <div class="profile">
                    <i class="fa-solid fa-user"></i>
                    <div class="profile-info">
                        <p class="name"><?= $first_name ?> <?= $last_name ?></p>
                        <p class="email"><?= $email ?></p>
                    </div>
                </div>
            </div>
            <div>
                <a href="<?= base_url('user_management/create') ?>" class="btn btn-primary">Add New User</a>

            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>School ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>User Type</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user): ?>
                        <tr>
                            <td><?= $user['id'] ?></td>
                            <td><?= $user['school_id'] ?></td>
                            <td><?= $user['first_name'] ?> <?= $user['last_name'] ?></td>
                            <td><?= $user['email'] ?></td>
                            <td><?= $user['user_type'] ?></td>
                            <td><?= $user['status'] ? 'Active' : 'Deactivated' ?></td>
                            <td class="action-buttons">
                                <a href="<?= base_url('user_management/edit/' . $user['id']) ?>" class="btn btn-warning btn-sm">Edit</a>
                                <a href="<?= base_url('user_management/deactivate/' . $user['id']) ?>" class="btn btn-danger btn-sm">Deactivate</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            </div>
        </main>
    </div>
</div>

</body>
</html>
