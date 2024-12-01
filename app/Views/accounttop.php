<div class="profile">
    <a href="<?= base_url('user_management/update_account') ?>" style="text-decoration: none; color: inherit; display: flex; align-items: center;">
        <i class="fa-solid fa-user" style="margin-right: 10px;"></i>
        <div class="profile-info">
            <p class="name">
                <?= session()->get('first_name') ?> <?= session()->get('last_name') ?>
            </p>
            <p class="email"><?= session()->get('email') ?></p>
        </div>
    </a>
</div>

<!-- CSS for layout -->
<style>
.profile {
    display: flex;
    align-items: center;
}

.profile-info {
    margin-left: 10px;
}

.profile-info p {
    margin: 0;
}
</style>
