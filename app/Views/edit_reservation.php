<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Reservation</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <?= view('style') ?>
</head>
<body>
<?= view('adminheader') ?>
<div class="container-fluid">
    <div class="row">
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4" style="margin-right: 20px">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Edit Reservation</h1>
                <?= view('accounttop') ?>
            </div>
            <?php if (session()->getFlashdata('errors')): ?>
                <div class="alert alert-danger"><?= session()->getFlashdata('errors') ?></div>
            <?php endif; ?>
            <form action="<?= base_url('reservation/update/'.$reservation['id']) ?>" method="post">
                <div class="form-group">
                    <label for="item_id">Item</label>
                    <select id="item_id" name="item_id" class="form-control" required>
                        <option value="" disabled>Select an Item</option>
                        <?php foreach ($stockItems as $item): ?>
                            <option value="<?= $item['item_id'] ?>" <?= $item['item_id'] == $reservation['item_id'] ? 'selected' : '' ?>><?= $item['name'] ?> (<?= $item['item_id'] ?>)</option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="reservation_date">Reservation Date</label>
                    <input type="date" id="reservation_date" name="reservation_date" class="form-control" value="<?= $reservation['reservation_date'] ?>" required>
                </div>
                <div class="d-flex justify-content-between">
                    <button type="submit" class="btn btn-primary">Update</button>
                    <a href="<?= base_url('reservation') ?>" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </main>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://kit.fontawesome.com/a076d05399.js"></script>
</body>
</html>
