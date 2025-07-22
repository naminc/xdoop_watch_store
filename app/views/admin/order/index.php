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
                            <?php $active = 'order'; ?>
                            <?php require_once __DIR__ . '/../components/tab.php'; ?>
                            <div class="col-lg-9 col-md-8">
                                <div class="myaccount-content">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <h3 class="mb-0"><i class="fa fa-cart-arrow-down"></i> Quản lý đơn hàng</h3>
                                    </div>
                                    <div class="myaccount-table table-responsive text-center">
                                        <table class="table table-bordered">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th>Mã đơn hàng</th>
                                                    <th>Tài khoản</th>
                                                    <th>Tổng tiền</th>
                                                    <th>Trạng thái</th>
                                                    <th>Ngày tạo</th>
                                                    <th>Ngày cập nhật</th>
                                                    <th>Hành động</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                if (!empty($orders)):
                                                    foreach ($orders as $item): ?>
                                                <tr>
                                                    <td>#<?= $item['id'] ?></td>
                                                    <td><?= $item['user_name'] ?></td>
                                                    <td><?= number_format($item['total'], 0, ',', '.') ?> VNĐ</td>
                                                    <td>
                                                        <?php switch ($item['status']) {
                                                            case 'pending':
                                                                echo '<span class="badge bg-warning"><i class="fa fa-spinner fa-spin"></i> Chờ xử lý</span>';
                                                                break;
                                                            case 'processing':
                                                                echo '<span class="badge bg-info"><i class="fa fa-spinner fa-spin"></i> Đang xử lý</span>';
                                                                break;
                                                            case 'shipping':
                                                                echo '<span class="badge bg-info"><i class="fa fa-truck"></i> Đang giao hàng</span>';
                                                                break;
                                                            case 'completed':
                                                                echo '<span class="badge bg-success"><i class="fa fa-check"></i> Đã hoàn thành</span>';
                                                                break;
                                                            case 'cancelled':
                                                                echo '<span class="badge bg-danger"><i class="fa fa-times"></i> Đã hủy</span>';
                                                                break;
                                                            default:
                                                                echo '<span class="badge bg-secondary">Chưa xác định</span>';
                                                                break;
                                                        } ?>
                                                    </td>
                                                    <td><?= date('d/m/Y H:i:s', strtotime($item['created_at'])) ?></td>
                                                    <td><?= date('d/m/Y H:i:s', strtotime($item['updated_at'])) ?></td>
                                                    <td>
                                                        <a href="/admin/order/edit/<?= $item['id'] ?>" class="check-btn sqr-btn "><i class="fa fa-edit"></i></a>
                                                    </td>
                                                </tr>
                                                <?php endforeach;
                                                else: ?>
                                                    <tr>
                                                        <td colspan="11" class="text-center">Không có dữ liệu</td>
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
            window.location.href = <?= json_encode($redirect ?? "/admin/order/index") ?>;
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
            window.location.href = <?= json_encode($redirect ?? "/admin/order/index") ?>;
        });
    </script>
<?php endif; ?>