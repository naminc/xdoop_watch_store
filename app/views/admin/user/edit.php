<?php
if (empty($_SESSION['user']) || $_SESSION['user']['role'] != 'admin') {
    header('Location: /');
    exit;
}
require_once __DIR__ . '/../../layouts/header.php';
?>
<?php require_once __DIR__ . '/../components/breadcrumb.php'; ?>
<main>
    <div class="my-account-wrapper pt-50 pb-50 pt-sm-50 pb-sm-50">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="myaccount-page-wrapper">
                        <div class="row">
                            <?php $active = 'user'; ?>
                            <?php require_once __DIR__ . '/../components/tab.php'; ?>
                            <div class="col-lg-9 col-md-8">
                                <div class="myaccount-content">
                                    <h3>Sửa người dùng</h3>
                                    <div class="account-details-form">
                                        <form method="post" action="/admin/user/edit/<?= $user['id'] ?>">
                                            <div class="single-input-item">
                                                <label for="fullname" class="required">Họ tên </label>
                                                <input type="text" name="fullname" placeholder="Họ tên" value="<?= $user['fullname'] ?>" required />
                                            </div>
                                            <div class="single-input-item">
                                                <label for="username" class="required">Tên người dùng</label>
                                                <input type="text" name="username" placeholder="Tên người dùng" value="<?= $user['username'] ?>" required />
                                            </div>
                                            <div class="single-input-item">
                                                <label for="email" class="required">Email</label>
                                                <input type="email" name="email" placeholder="Email" value="<?= $user['email'] ?>" required />
                                            </div>
                                            <div class="single-input-item">
                                                <label for="phone" class="required">Số điện thoại</label>
                                                <input type="tel" name="phone" placeholder="Số điện thoại" value="<?= $user['phone'] ?>" required />
                                            </div>
                                            <div class="single-input-item">
                                                <label for="role" class="required">Vai trò</label>
                                                <select name="role" required>
                                                    <option value="admin" <?= $user['role'] == 'admin' ? 'selected' : '' ?>>Admin</option>
                                                    <option value="user" <?= $user['role'] == 'user' ? 'selected' : '' ?>>User</option>
                                                </select>
                                            </div>
                                            <div class="single-input-item">
                                                <label for="status" class="required">Trạng thái</label>
                                                <select name="status" required>
                                                    <option value="1" <?= $user['status'] == 1 ? 'selected' : '' ?>>Hoạt động</option>
                                                    <option value="0" <?= $user['status'] == 0 ? 'selected' : '' ?>>Không hoạt động</option>
                                                </select>
                                            </div>
                                            <div class="single-input-item">
                                                <label for="password">Mật khẩu</label>
                                                <input type="password" name="password" placeholder="Mật khẩu" />
                                            </div>
                                            <div class="single-input-item">
                                                <label for="ip_address">IP</label>
                                                <input type="text" name="ip_address" placeholder="IP" value="<?= $user['ip_address'] ?>" />
                                            </div>
                                            <div class="single-input-item">
                                                <label for="user_agent">User Agent</label>
                                                <input type="text" name="user_agent" placeholder="User Agent" value="<?= $user['user_agent'] ?>" />
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="single-input-item">
                                                        <button class="check-btn sqr-btn" type="submit" name="edit"><i class="fa fa-save"></i> Sửa người dùng</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<?php require_once __DIR__ . '/../../layouts/footer.php'; ?>
<?php if (!empty($error)): ?>
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: <?= json_encode($error) ?>
        }).then(() => {
            window.location.href = <?= json_encode($redirect ?? "/admin/category/index") ?>;
        });
    </script>
<?php endif; ?>

<?php if (!empty($success)): ?>
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Success!',
            text: <?= json_encode($success) ?>
        }).then(() => {
            window.location.href = <?= json_encode($redirect ?? "/admin/category/index") ?>;
        });
    </script>
<?php endif; ?>