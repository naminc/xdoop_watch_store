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
                            <?php $active = 'dashboard'; ?>
                            <?php require_once __DIR__ . '/components/tab.php'; ?>
                            <div class="col-lg-9 col-md-8">
                                <div class="tab-content" id="myaccountContent">
                                    <div class="tab-pane fade show active" id="dashboad" role="tabpanel">
                                        <div class="myaccount-content">
                                            <h3><i class="fa fa-dashboard"></i> Bảng điều khiển</h3>
                                            <div class="row text-center mb-4">
                                                <div class="col-md-3 mb-2">
                                                    <div class="p-3 bg-dark text-white rounded shadow">
                                                        <h4><?= $totalOrders ?></h4>
                                                        <p style="color: #fff;"><i class="fa fa-cart-arrow-down"></i> Tổng đơn hàng</p>
                                                    </div>
                                                </div>
                                                <div class="col-md-3 mb-2">
                                                    <div class="p-3 bg-dark text-white rounded shadow">
                                                        <h4><?= $totalUsers ?></h4>
                                                        <p style="color: #fff;"><i class="fa fa-users"></i> Tổng người dùng</p>
                                                    </div>
                                                </div>
                                                <div class="col-md-3 mb-2">
                                                    <div class="p-3 bg-dark text-white rounded shadow">
                                                        <h4><?= $totalCategories ?></h4>
                                                        <p style="color: #fff;"><i class="fa fa-list-alt"></i> Tổng danh mục</p>
                                                    </div>
                                                </div>
                                                <div class="col-md-3 mb-2">
                                                    <div class="p-3 bg-dark text-white rounded shadow">
                                                        <h4><?= $totalProducts ?></h4>
                                                        <p style="color: #fff;"><i class="fa fa-shopping-cart"></i> Tổng sản phẩm</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row text-center mb-4 mt-4">
                                                <div class="col-md-3 mb-2">
                                                    <div class="p-3 bg-dark text-white rounded shadow">
                                                        <h5><?= number_format($totalRevenueAll, 0, ',', '.') ?> VNĐ</h5>
                                                        <p style="color: #fff;">Tổng doanh thu</p>
                                                        <a href="#" class="text-white" title=""><i class="fa fa-eye"></i></a>
                                                    </div>
                                                </div>
                                                <div class="col-md-3 mb-2">
                                                    <div class="p-3 bg-dark text-white rounded shadow">
                                                        <h5><?= number_format($totalRevenueDay, 0, ',', '.') ?> VNĐ</h5>
                                                        <p style="color: #fff;">Doanh thu ngày <?= date('d/m/Y') ?></p>
                                                        <a href="/admin/revenue/bydate" class="text-white" title="Xem theo ngày"><i class="fa fa-eye"></i></a>
                                                    </div>
                                                </div>
                                                <div class="col-md-3 mb-2">
                                                    <div class="p-3 bg-dark text-white rounded shadow">
                                                        <h5><?= number_format($totalRevenueMonth, 0, ',', '.') ?> VNĐ</h5>
                                                        <p style="color: #fff;">Doanh thu tháng <?= date('m/Y') ?></p>
                                                        <a href="/admin/revenue/bymonth" class="text-white" title="Xem theo tháng"><i class="fa fa-eye"></i></a>
                                                    </div>
                                                </div>
                                                <div class="col-md-3 mb-2">
                                                    <div class="p-3 bg-dark text-white rounded shadow">
                                                        <h5><?= number_format($totalRevenueYear, 0, ',', '.') ?> VNĐ</h5>
                                                        <p style="color: #fff;">Doanh thu năm <?= date('Y') ?></p>
                                                        <a href="/admin/revenue/byyear" class="text-white" title="Xem theo năm"><i class="fa fa-eye"></i></a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row mt-3 mb-2">
                                                <div class="col-md-12">
                                                    <div class="p-3 bg-dark text-white rounded shadow">
                                                        <h4>Sản phẩm bán chạy nhất</h4>
                                                        <ul class="list-group">
                                                            <?php foreach ($bestSelling as $product): ?>
                                                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                                                    <a href="/admin/product/edit/<?= $product['id'] ?>" style="text-decoration: none; color:rgb(68, 183, 133);"><?= $product['name']; ?> (ID: <?= $product['id']; ?>)</a>
                                                                    <span class="badge bg-success"><?= $product['total_sold']; ?> đã bán</span>
                                                                </li>
                                                            <?php endforeach; ?>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row mt-3">
                                                <div class="col-md-12">
                                                    <div class="p-3 bg-dark text-white rounded shadow">
                                                        <h4>Sản phẩm bán ít nhất</h4>
                                                        <ul class="list-group">
                                                            <?php foreach ($leastSelling as $product): ?>
                                                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                                                    <a href="/admin/product/edit/<?= $product['id'] ?>" style="text-decoration: none; color:rgb(68, 183, 133);"><?= $product['name']; ?> (ID: <?= $product['id']; ?>)</a>
                                                                    <span class="badge bg-warning"><?= $product['total_sold']; ?> đã bán</span>
                                                                </li>
                                                            <?php endforeach; ?>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row mt-3">
                                                <div class="col-md-12">
                                                    <div class="p-3 bg-dark text-white rounded shadow">
                                                        <h4>Sản phẩm chưa bán được lần nào</h4>
                                                        <ul class="list-group">
                                                            <?php foreach ($neverSold as $product): ?>
                                                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                                                    <a href="/admin/product/edit/<?= $product['id'] ?>" style="text-decoration: none; color:rgb(68, 183, 133);"><?= $product['name']; ?> (ID: <?= $product['id']; ?>)</a>
                                                                    <span class="badge bg-info">Còn lại <?= $product['stock']; ?> sản phẩm</span>
                                                                </li>
                                                            <?php endforeach; ?>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row mt-3">
                                                <div class="col-md-12">
                                                    <div class="p-3 bg-dark text-white rounded shadow">
                                                        <h4>Khách hàng mua nhiều nhất</h4>
                                                        <ul class="list-group">
                                                            <?php foreach ($bestCustomers as $customer): ?>
                                                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                                                    <a href="/admin/user/edit/<?= $customer['id'] ?>" style="text-decoration: none; color:rgb(68, 183, 133);"><?= $customer['fullname']; ?> (Tài khoản: <?= $customer['username']; ?>)</a>
                                                                    <span class="badge bg-info"><?= $customer['total_orders']; ?> đơn hàng</span>
                                                                </li>
                                                            <?php endforeach; ?>
                                                        </ul>
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
            </div>
        </div>
    </div>
    </div>
</main>
<?php require_once __DIR__ . '/../layouts/footer.php'; ?>