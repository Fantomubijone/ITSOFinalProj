<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservations</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <?= view('style') ?>
</head>
<body>
<?= view('adminheader') ?>
<div class="container-fluid">
    <div class="row">
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4" style="margin-right: 20px">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">My Reservations</h1>
                <?= view('accounttop') ?>
            </div>
            <a href="<?= base_url('reservation/create') ?>" class="btn btn-primary mb-3">Add New Reservation</a>
            <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
            <?php endif; ?>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Item ID</th>
                        <th>Reservation Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($reservations as $reservation): ?>
                    <tr>
                        <td><?= $reservation['item_id'] ?></td>
                        <td><?= $reservation['reservation_date'] ?></td>
                        <td>
                            <a href="<?= base_url('reservation/edit/'.$reservation['id']) ?>" class="btn btn-warning btn-sm">Edit</a>
                            <a href="<?= base_url('reservation/delete/'.$reservation['id']) ?>" class="btn btn-danger btn-sm">Cancel</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </main>
    </div>
</div>
</body>
</html>
