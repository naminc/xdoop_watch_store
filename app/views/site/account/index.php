<?php
if (empty($_SESSION['user'])) {
    header('Location: /auth/login');
    exit;
}

require_once __DIR__ . '/../../layouts/header.php';
?>
    <!-- breadcrumb area start -->
    <div class="breadcrumb-area">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="breadcrumb-wrap">
                        <nav aria-label="breadcrumb">
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="/">Trang chủ</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Tài khoản</li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
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
                                                                <th>Order</th>
                                                                <th>Date</th>
                                                                <th>Status</th>
                                                                <th>Total</th>
                                                                <th>Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td>1</td>
                                                                <td>Aug 22, 2022</td>
                                                                <td>Pending</td>
                                                                <td>$3000</td>
                                                                <td><a href="cart.html" class="check-btn sqr-btn ">View</a></td>
                                                            </tr>
                                                            <tr>
                                                                <td>2</td>
                                                                <td>July 22, 2022</td>
                                                                <td>Approved</td>
                                                                <td>$200</td>
                                                                <td><a href="cart.html" class="check-btn sqr-btn ">View</a></td>
                                                            </tr>
                                                            <tr>
                                                                <td>3</td>
                                                                <td>June 12, 2017</td>
                                                                <td>On Hold</td>
                                                                <td>$990</td>
                                                                <td><a href="cart.html" class="check-btn sqr-btn ">View</a></td>
                                                            </tr>
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
                                                    <form action="#">
                                                        <div class="single-input-item">
                                                            <label for="username">Tên người dùng</label>
                                                            <input type="text" id="username" placeholder="Tên người dùng" value="<?php echo $_SESSION['user']['username']; ?>" readonly />
                                                        </div>
                                                        <div class="single-input-item">
                                                            <label for="display-name" class="required">Họ và tên</label>
                                                            <input type="text" id="display-name" placeholder="Họ và tên" value="<?php echo $_SESSION['user']['fullname']; ?>" required />
                                                        </div>
                                                        <div class="single-input-item">
                                                            <label for="email" class="required">Địa chỉ email</label>
                                                            <input type="email" id="email" placeholder="Địa chỉ email" value="<?php echo $_SESSION['user']['email']; ?>" required />
                                                        </div>
                                                        <div class="single-input-item">
                                                            <label for="phone" class="required">Số điện thoại</label>
                                                            <input type="text" id="phone" placeholder="Số điện thoại" value="<?php echo $_SESSION['user']['phone']; ?>" required />
                                                        </div>
                                                        <div class="single-input-item">
                                                            <button class="check-btn sqr-btn" type="submit" name="save-info"><i class="fa fa-save"></i> Lưu thay đổi</button>
                                                        </div>
                                                        <fieldset>
                                                            <legend style="margin-bottom: 20px;">#Đổi mật khẩu</legend>
                                                            <div class="single-input-item">
                                                                <label for="current-pwd" class="required">Mật khẩu hiện tại</label>
                                                                <input type="password" id="current-pwd" placeholder="Mật khẩu hiện tại" />
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-lg-6">
                                                                    <div class="single-input-item">
                                                                        <label for="new-pwd" class="required">Mật khẩu mới</label>
                                                                        <input type="password" id="new-pwd" placeholder="Mật khẩu mới" />
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-6">
                                                                    <div class="single-input-item">
                                                                        <label for="confirm-pwd" class="required">Xác nhận mật khẩu</label>
                                                                        <input type="password" id="confirm-pwd" placeholder="Xác nhận mật khẩu" />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </fieldset>
                                                        <div class="single-input-item">
                                                            <button class="check-btn sqr-btn"><i class="fa fa-lock"></i> Đổi mật khẩu</button>
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