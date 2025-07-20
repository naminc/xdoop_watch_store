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
                            <div class="col-lg-3 col-md-4">
                                <div class="myaccount-tab-menu nav" role="tablist">
                                    <a href="#dashboad" class="active" data-bs-toggle="tab"><i class="fa fa-dashboard"></i>
                                        Bảng điều khiển</a>
                                    <a href="#account-info" data-bs-toggle="tab"><i class="fa fa-user"></i> Thông tin tài khoản</a>
                                    <a href="#orders" data-bs-toggle="tab"><i class="fa fa-cart-arrow-down"></i> Đơn hàng</a>
                                    <a href="#payment-method" data-bs-toggle="tab"><i class="fa fa-credit-card"></i> Phương thức thanh toán</a>
                                    <a href="/auth/logout"><i class="fa fa-sign-out"></i> Đăng xuất</a>
                                </div>
                            </div>
                            <div class="col-lg-9 col-md-8">
                                <div class="tab-content" id="myaccountContent">
                                    <div class="tab-pane fade show active" id="dashboad" role="tabpanel">
                                        <div class="myaccount-content">
                                            <h3>Bảng điều khiển</h3>
                                            <div class="welcome">
                                                <p>Xin chào, <strong><?php echo $_SESSION['user']['username']; ?></strong> (Nếu không phải <strong><?php echo $_SESSION['user']['username']; ?> !</strong><a href="/auth/logout" class="logout"> Đăng xuất</a>)</p>
                                            </div>
                                            <p class="mb-0">Từ trang tài khoản, bạn có thể dễ dàng kiểm tra và xem đơn hàng gần nhất, quản lý địa chỉ giao hàng và thanh toán, chỉnh sửa mật khẩu và thông tin tài khoản của bạn.</p>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="orders" role="tabpanel">
                                        <div class="myaccount-content">
                                            <h3>Đơn hàng</h3>
                                            <div class="myaccount-table table-responsive text-center">
                                                <table class="table table-bordered">
                                                    <thead class="thead-light">
                                                        <tr>
                                                            <th>Mã đơn hàng</th>
                                                            <th>Ngày đặt hàng</th>
                                                            <th>Trạng thái</th>
                                                            <th>Tổng tiền</th>
                                                            <th>Hành động</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        if (!empty($orders)) {
                                                            foreach ($orders as $order) {
                                                        ?>
                                                                <tr>
                                                                    <td>#<?php echo $order['id']; ?></td>
                                                                    <td><?php echo $order['created_at']; ?></td>
                                                                    <td><?php
                                                                        switch ($order['status']) {
                                                                            case 'pending':
                                                                                echo '<span class="badge bg-warning">Chờ xử lý</span>';
                                                                                break;
                                                                            case 'processing':
                                                                                echo '<span class="badge bg-info">Đang xử lý</span>';
                                                                                break;
                                                                            case 'completed':
                                                                                echo '<span class="badge bg-success">Đã hoàn thành</span>';
                                                                                break;
                                                                            case 'cancelled':
                                                                                echo '<span class="badge bg-danger">Đã hủy</span>';
                                                                                break;
                                                                            default:
                                                                                echo '<span class="badge bg-secondary">Chưa xác định</span>';
                                                                                break;
                                                                        }
                                                                        ?>
                                                                    </td>
                                                                    <td><?php echo number_format($order['total'], 0, ',', '.'); ?> VNĐ</td>
                                                                    <td><a href="/order/detail/<?php echo $order['id']; ?>" class="check-btn sqr-btn ">Xem</a></td>
                                                                </tr>
                                                        <?php
                                                            }
                                                        }
                                                        ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="payment-method" role="tabpanel">
                                        <div class="myaccount-content">
                                            <h3>Phương thức thanh toán</h3>
                                            <p class="saved-message">Hiện tại chỉ hỗ trợ thanh toán tiền mặt khi nhận hàng.</p>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="account-info" role="tabpanel">
                                        <div class="myaccount-content">
                                            <h3>Thông tin tài khoản</h3>
                                            <div class="account-details-form">
                                                <form action="/account/update" method="post">
                                                    <div class="single-input-item">
                                                        <label for="username">Tên người dùng</label>
                                                        <input type="text" id="username" placeholder="Tên người dùng"
                                                            value="<?php echo isset($_SESSION['user']['username']) ? $_SESSION['user']['username'] : ''; ?>" readonly />
                                                    </div>

                                                    <div class="single-input-item">
                                                        <label for="display-name" class="required">Họ và tên</label>
                                                        <input type="text" id="display-name" name="fullname" placeholder="Họ và tên"
                                                            value="<?php echo isset($_SESSION['user']['fullname']) ? $_SESSION['user']['fullname'] : ''; ?>" required />
                                                    </div>

                                                    <div class="single-input-item">
                                                        <label for="email" class="required">Địa chỉ email</label>
                                                        <input type="email" id="email" name="email" placeholder="Địa chỉ email"
                                                            value="<?php echo isset($_SESSION['user']['email']) ? $_SESSION['user']['email'] : ''; ?>" required />
                                                    </div>

                                                    <div class="single-input-item">
                                                        <label for="phone" class="required">Số điện thoại</label>
                                                        <input type="text" id="phone" name="phone" placeholder="Số điện thoại"
                                                            value="<?php echo isset($_SESSION['user']['phone']) ? $_SESSION['user']['phone'] : ''; ?>" required />
                                                    </div>

                                                    <div class="single-input-item">
                                                        <button class="check-btn sqr-btn" type="submit" name="update-info">
                                                            <i class="fa fa-save"></i> Lưu thay đổi
                                                        </button>
                                                    </div>
                                                </form>
                                                <form action="/account/update" method="post">
                                                <fieldset>
                                                    <legend style="margin-bottom: 20px;">#Đổi mật khẩu</legend>
                                                    <div class="single-input-item">
                                                        <label for="current-pwd" class="required">Mật khẩu hiện tại</label>
                                                        <input type="password" name="password" id="current-pwd" minlength="6" placeholder="Mật khẩu hiện tại" required/>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-lg-6">
                                                            <div class="single-input-item">
                                                                <label for="new-pwd" class="required">Mật khẩu mới</label>
                                                                <input type="password" name="new-password" id="new-pwd" minlength="6" placeholder="Mật khẩu mới" required/>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="single-input-item">
                                                                <label for="confirm-pwd" class="required">Xác nhận mật khẩu</label>
                                                                <input type="password" name="confirm-password" id="confirm-pwd" minlength="6" placeholder="Xác nhận mật khẩu" required/>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </fieldset>
                                                <div class="single-input-item">
                                                    <button class="check-btn sqr-btn" type="submit" name="change-password"><i class="fa fa-lock"></i> Đổi mật khẩu</button>
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
            window.location.href = <?= json_encode($redirect ?? "/account") ?>;
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
            window.location.href = <?= json_encode($redirect ?? "/account") ?>;
        });
    </script>
<?php endif; ?>