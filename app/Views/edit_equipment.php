<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Equipment</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <?= view('style') ?>
</head>
<body>
<?= view('adminheader') ?>
<div class="container-fluid">
    <div class="row">
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4" style="margin-right: 20px">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Edit Equipment</h1>
                <?= view('accounttop') ?>
            </div>
            <?php if (session()->getFlashdata('errors')): ?>
                <div class="alert alert-danger"><?= session()->getFlashdata('errors') ?></div>
            <?php endif; ?>
            <form id="editEquipmentForm" action="<?= base_url('equipment_management/update/'.$equipment['id']) ?>" method="post">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <input type="text" id="item_id" name="item_id" value="<?= $equipment['item_id'] ?>" placeholder=" " class="form-control" disabled>
                            <label for="item_id">Item ID</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <input type="text" id="name" name="name" value="<?= $equipment['name'] ?>" placeholder=" " class="form-control" required>
                            <label for="name">Name</label>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <select id="status" name="status" class="form-control" required>
                        <option value="" disabled>Select Status</option>
                        <option value="Stock" <?= $equipment['status'] == 'Stock' ? 'selected' : '' ?>>Stock</option>
                        <option value="Defective" <?= $equipment['status'] == 'Defective' ? 'selected' : '' ?>>Defective</option>
                    </select>
                </div>
                <div class="form-group">
                    <input type="text" id="category" name="category" value="<?= $equipment['category'] ?>" placeholder=" " class="form-control" required>
                    <label for="category">Category</label>
                </div>
                <div class="d-flex justify-content-between">
                    <button type="submit" class="btn btn-primary">Update</button>
                    <a href="<?= base_url('equipment_management') ?>" class="btn btn-secondary">Cancel</a>
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
