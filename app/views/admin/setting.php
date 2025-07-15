<?php
if (empty($_SESSION['user']) || $_SESSION['user']['role'] != 'admin') {
    header('Location: /');
    exit;
}
require_once __DIR__ . '/../layouts/header.php';
?>
<?php require_once __DIR__ . '/components/breadcrumb.php'; ?>
<main>
    <div class="my-account-wrapper pt-50 pb-50 pt-sm-50 pb-sm-50">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="myaccount-page-wrapper">
                        <div class="row">
                            <?php $active = 'setting'; ?>
                            <?php require_once __DIR__ . '/components/tab.php'; ?>
                            <div class="col-lg-9 col-md-8">
                                <div class="myaccount-content">
                                    <h3><i class="fa fa-cogs"></i> Quản lý hệ thống</h3>
                                    <div class="account-details-form">
                                        <form method="post" action="/admin/setting/update">
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <div class="single-input-item">
                                                        <label for="title" class="required">Tiêu đề </label>
                                                        <input type="text" name="title" placeholder="Tiêu đề cửa hàng" value="<?php echo $setting['title']; ?>" required />
                                                    </div>
                                                    <div class="single-input-item">
                                                        <label for="keyword" class="required">Từ khóa</label>
                                                        <input type="text" name="keyword" placeholder="Từ khóa" value="<?php echo $setting['keyword']; ?>" required />
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="single-input-item">
                                                        <label for="description" class="required">Mô tả</label>
                                                        <textarea name="description" rows="3" placeholder="Mô tả" required><?php echo $setting['description']; ?></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <div class="single-input-item">
                                                        <label for="domain" class="required">Tên miền</label>
                                                        <input type="text" name="domain" placeholder="Tên miền" value="<?php echo $setting['domain']; ?>" required />
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="single-input-item">
                                                        <label for="brand" class="required">Thương hiệu</label>
                                                        <input type="text" name="brand" placeholder="Thương hiệu" value="<?php echo $setting['brand']; ?>" required />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <div class="single-input-item">
                                                        <label for="email" class="required">Địa chỉ email</label>
                                                        <input type="text" name="email" placeholder="Địa chỉ email" value="<?php echo $setting['email']; ?>" required />
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="single-input-item">
                                                        <label for="phone" class="required">Số điện thoại</label>
                                                        <input type="text" name="phone" placeholder="Số điện thoại" value="<?php echo $setting['phone']; ?>" required />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="single-input-item">
                                                        <label for="address" class="required">Địa chỉ</label>
                                                        <textarea name="address" rows="3" placeholder="Địa chỉ" required><?php echo $setting['address']; ?></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <div class="single-input-item">
                                                        <label for="logo" class="required">Đường dẫn Logo</label>
                                                        <input type="text" name="logo" placeholder="Đường dẫn Logo" value="<?php echo $setting['logo']; ?>" required />
                                                        <img src="<?php echo $setting['logo']; ?>" alt="Logo" style="height: 50px; margin-top: 5px;">
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="single-input-item">
                                                        <label for="favicon" class="required">Đường dẫn Favicon</label>
                                                        <input type="text" name="icon" placeholder="Đường dẫn Favicon" value="<?php echo $setting['icon']; ?>" required />
                                                        <img src="<?php echo $setting['icon']; ?>" alt="Favicon" style="height: 50px; margin-top: 5px;">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="single-input-item">
                                                        <label for="maintenance" class="required">Trạng thái bảo trì</label>
                                                        <select name="maintenance" required>
                                                            <option value="on" <?php echo $setting['maintenance'] == 'on' ? 'selected' : ''; ?>>Bật</option>
                                                            <option value="off" <?php echo $setting['maintenance'] == 'off' ? 'selected' : ''; ?>>Tắt</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="single-input-item">
                                                        <button class="check-btn sqr-btn" type="submit" name="update"><i class="fa fa-save"></i> Lưu thay đổi</button>
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

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
<?php if (!empty($error)): ?>
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: <?= json_encode($error) ?>
        }).then(() => {
            window.location.href = <?= json_encode($redirect ?? "/admin/setting") ?>;
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
            window.location.href = <?= json_encode($redirect ?? "/admin/setting") ?>;
        });
    </script>
<?php endif; ?>