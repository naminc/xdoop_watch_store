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
                            <?php $active = 'coupon'; ?>
                            <?php require_once __DIR__ . '/../components/tab.php'; ?>
                            <div class="col-lg-9 col-md-8">
                                <div class="myaccount-content">
                                    <h3>Sửa mã giảm giá</h3>
                                    <div class="account-details-form">
                                        <form method="post" action="/admin/coupon/edit/<?= $coupon['id'] ?>">
                                            <div class="single-input-item">
                                                <label for="code" class="required">Mã giảm giá</label>
                                                <input type="text" name="code" placeholder="Mã giảm giá" value="<?= $coupon['code'] ?>" required />
                                            </div>
                                            <div class="single-input-item">
                                                <label for="discount_type" class="required">Loại giảm giá</label>
                                                <select name="discount_type" required>
                                                    <option value="percentage" <?= $coupon['discount_type'] == 'percentage' ? 'selected' : '' ?>>Phần trăm</option>
                                                    <option value="fixed" <?= $coupon['discount_type'] == 'fixed' ? 'selected' : '' ?>>Tiền mặt</option>
                                                </select>
                                            </div>
                                            <div class="single-input-item">
                                                <label for="discount_value" class="required">Giá trị giảm giá</label>
                                                <input type="number" name="discount_value" placeholder="Giá trị giảm giá" value="<?= $coupon['discount_value'] ?>" required />
                                            </div>
                                            <div class="single-input-item">
                                                <label for="expires_at" class="required">Ngày hết hạn</label>
                                                <input type="datetime-local" name="expires_at" placeholder="Ngày hết hạn" value="<?= $coupon['expires_at'] ?>" required />
                                            </div>
                                            <div class="single-input-item">
                                                <label for="usage_limit" class="required">Số lần sử dụng tối đa</label>
                                                <input type="number" name="usage_limit" placeholder="Số lần sử dụng tối đa" value="<?= $coupon['usage_limit'] ?>" required />
                                            </div>
                                            <div class="single-input-item">
                                                <label for="status" class="required">Trạng thái</label>
                                                <select name="status" required>
                                                    <option value="1" <?= $coupon['status'] == 1 ? 'selected' : '' ?>>Hoạt động</option>
                                                    <option value="0" <?= $coupon['status'] == 0 ? 'selected' : '' ?>>Không hoạt động</option>
                                                </select>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="single-input-item">
                                                        <button class="check-btn sqr-btn" type="submit" name="edit"><i class="fa fa-save"></i> Sửa mã giảm giá</button>
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
            window.location.href = <?= json_encode($redirect ?? "/admin/coupon/index") ?>;
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
            window.location.href = <?= json_encode($redirect ?? "/admin/coupon/index") ?>;
        });
    </script>
<?php endif; ?>