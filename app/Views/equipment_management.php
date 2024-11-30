<?= view('adminheader') ?>
<div class="container-fluid">
    <div class="row">
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Equipment Management</h1>

                <div class="profile">
                    <i class="fa-solid fa-user"></i>
                    <div class="profile-info">
                        <p class="name"><?= $first_name ?> <?= $last_name ?></p>
                        <p class="email"><?= $email ?></p>
                    </div>
                </div>
            </div>
            <div>
                <a href="<?= base_url('equipment_management/create') ?>" class="btn btn-primary">Add New Equipment</a>

                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Item Name</th>
                            <th>Item Count</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($equipment as $item): ?>
                            <tr>
                                <td><?= $item['id'] ?></td>
                                <td><?= $item['name'] ?></td>
                                <td><?= $item['item_count'] ?></td>
                                <td><?= $item['status'] ? 'Available' : 'Unavailable' ?></td>
                                <td class="action-buttons">
                                    <a href="<?= base_url('equipment_management/edit/' . $item['id']) ?>" class="btn btn-warning btn-sm">Edit</a>
                                    <a href="<?= base_url('equipment_management/deactivate/' . $item['id']) ?>" class="btn btn-danger btn-sm">Deactivate</a>
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
