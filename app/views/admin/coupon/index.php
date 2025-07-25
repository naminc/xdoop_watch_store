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
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <h3 class="mb-0"><i class="fa fa-list"></i> Quản lý mã giảm giá</h3>
                                        <a href="/admin/coupon/create" class="btn btn-success"><i class="fa fa-plus"></i> Thêm mã giảm giá</a>
                                    </div>
                                    <div class="myaccount-table table-responsive text-center">
                                        <table class="table table-bordered">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th>#</th>
                                                    <th>Mã giảm giá</th>
                                                    <th>Loại giảm giá</th>
                                                    <th>Giá trị giảm giá</th>
                                                    <th>Ngày hết hạn</th>
                                                    <th>Số lần sử dụng tối đa</th>
                                                    <th>Số lần đã sử dụng</th>
                                                    <th>Trạng thái</th>
                                                    <th>Hành động</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                if (!empty($coupons)):
                                                    foreach ($coupons as $coupon): ?>
                                                <tr>
                                                    <td><?= $coupon['id'] ?></td>
                                                    <td><?= $coupon['code'] ?></td>
                                                    <td><?= $coupon['discount_type'] == 'percentage' ? 'Phần trăm' : 'Tiền mặt' ?></td>
                                                    <td><?= $coupon['discount_type'] == 'percentage' ? $coupon['discount_value'] . '%' : number_format($coupon['discount_value'], 0, ',', '.') . 'đ' ?></td>
                                                    <td><?= date('d/m/Y H:i:s', strtotime($coupon['expires_at'])) ?></td>
                                                    <td><?= $coupon['usage_limit'] ?></td>
                                                    <td><?= $coupon['used_count'] ?></td>
                                                    <td><span class="badge bg-<?= $coupon['status'] == 1 ? 'success' : 'danger' ?>"><?= $coupon['status'] == 1 ? 'Đang hoạt động' : 'Không hoạt động' ?></span></td>
                                                    <td>
                                                        <a href="/admin/coupon/edit/<?= $coupon['id'] ?>" class="check-btn sqr-btn "><i class="fa fa-edit"></i></a>
                                                        <a onclick="return confirm('Bạn có chắc chắn muốn <?= $coupon['status'] == 1 ? 'tắt' : 'bật' ?> mã giảm giá này không?')" href="/admin/coupon/<?= $coupon['status'] == 1 ? 'disable' : 'enable' ?>/<?= $coupon['id'] ?>" class="check-btn <?= $coupon['status'] == 1 ? 'delete-btn' : 'enable-btn' ?> "><i class="fa fa-<?= $coupon['status'] == 1 ? 'times' : 'check' ?>"></i></a>
                                                    </td>
                                                </tr>
                                                <?php endforeach;
                                                else: ?>
                                                    <tr>
                                                        <td colspan="9" class="text-center">Không có dữ liệu</td>
                                                    </tr>
                                                <?php endif; ?>
                                            </tbody>
                                        </table>
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