<?php
if (empty($_SESSION['user'])) {
    header('Location: /auth/login');
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
                            <div class="col-lg-12">
                                <div class="tab-pane fade show active" id="order-detail" role="tabpanel">
                                    <div class="myaccount-content">
                                        <h3>#<?= $order['id'] ?> - Chi tiết đơn hàng</h3>

                                        <!-- Thông tin chung -->
                                        <div class="order-info">
                                            <p><strong>Mã đơn hàng:</strong> #<?= $order['id'] ?></p>
                                            <p><strong>Ngày đặt hàng:</strong> <?= $order['created_at'] ?></p>
                                            <p><strong>Trạng thái:</strong> <?php switch ($order['status']) {
                                                case 'pending':
                                                    echo '<span class="badge bg-warning"><i class="fa fa-spinner fa-spin"></i> Chờ xử lý</span>';
                                                    break;
                                                case 'processing':
                                                    echo '<span class="badge bg-info"><i class="fa fa-spinner fa-spin"></i> Đang xử lý</span>';
                                                    break;
                                                case 'completed':
                                                    echo '<span class="badge bg-success"><i class="fa fa-check"></i> Đã hoàn thành</span>';
                                                    break;
                                                case 'shipping':
                                                    echo '<span class="badge bg-info"><i class="fa fa-truck"></i> Đang giao hàng</span>';
                                                    break;
                                                case 'cancelled':
                                                    echo '<span class="badge bg-danger"><i class="fa fa-times"></i> Đã hủy</span>';
                                                    break;
                                                default:
                                                    echo '<span class="badge bg-secondary"><i class="fa fa-question"></i> Chưa xác định</span>';
                                                    break;
                                            } ?></p>
                                            <p><strong>Phương thức thanh toán:</strong> <?= $order['payment_method'] == 'cash' ? 'Thanh toán khi nhận hàng' : 'Thanh toán online' ?></p>
                                        </div>

                                        <!-- Thông tin người nhận -->
                                        <div class="order-address">
                                            <h4>Thông tin người nhận</h4>
                                            <p><strong>Họ tên:</strong> <?= $order['fullname'] ?></p>
                                            <p><strong>SĐT:</strong> <?= $order['phone'] ?></p>
                                            <p><strong>Email:</strong> <?= $order['email'] ?></p>
                                            <p><strong>Địa chỉ:</strong> <?= $order['address'] ?>, <?= $order['district'] ?>, <?= $order['city'] ?> - <?= $order['postcode'] ?></p>
                                            <p><strong>Ghi chú:</strong> <?= $order['note'] ?></p>
                                        </div>

                                        <!-- Danh sách sản phẩm -->
                                        <div class="order-products mt-4">
                                            <h4>Sản phẩm đã mua</h4>
                                            <div class="table-responsive">
                                                <table class="table table-bordered text-center">
                                                    <thead class="thead-light">
                                                        <tr>
                                                            <th>Ảnh</th>
                                                            <th>Tên sản phẩm</th>
                                                            <th>Giá</th>
                                                            <th>Số lượng</th>
                                                            <th>Thành tiền</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php foreach ($orderItems as $item): ?>
                                                            <tr>
                                                                <td><img src="/uploads/products/<?= $item['image'] ?>" width="70" alt="Ảnh sản phẩm"></td>
                                                                <td><a style="text-decoration: none; color:rgb(68, 183, 133);" href="/product/detail/<?= $item['slug'] ?>"><?= $item['name'] ?></a></td>
                                                                <td><?= number_format($item['price'], 0, ',', '.') ?> VNĐ</td>
                                                                <td><?= $item['quantity'] ?></td>
                                                                <td><?= number_format($item['price'] * $item['quantity'], 0, ',', '.') ?> VNĐ</td>
                                                            </tr>
                                                        <?php endforeach; ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                        <!-- Tổng tiền -->
                                        <div class="order-total mt-3">
                                            <h4 class="text-end">Tổng cộng: <strong><?= number_format($order['total'], 0, ',', '.') ?> VNĐ</strong></h4>
                                        </div>
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