<?php
if (empty($_SESSION['user']) || $_SESSION['user']['role'] != 'admin') {
    header('Location: /');
    exit;
}
require_once __DIR__ . '/../layouts/header.php';
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
                            <li class="breadcrumb-item active" aria-current="page">Admin Panel</li>
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
                            <?php $active = 'dashboard'; ?> 
                            <?php require_once __DIR__ . '/components/tab.php'; ?>
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
                                    <div class="tab-pane fade" id="settings" role="tabpanel">
                                        <div class="myaccount-content">
                                            <h3>Quản lý hệ thống</h3>

                                            <div class="account-details-form">

                                                <form method="post" action="/admin/setting/update" id="setting-form">
                                                    <div class="row">
                                                        <div class="col-lg-6">
                                                            <div class="single-input-item">
                                                                <label for="title" class="required">Tiêu đề </label>
                                                                <input type="text" id="title" placeholder="Tiêu đề cửa hàng" value="<?php echo $setting['title']; ?>" required />
                                                            </div>
                                                            <div class="single-input-item">
                                                                <label for="keyword" class="required">Từ khóa</label>
                                                                <input type="text" id="keyword" placeholder="Từ khóa" value="<?php echo $setting['keyword']; ?>" required />
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="single-input-item">
                                                                <label for="description" class="required">Mô tả</label>
                                                                <textarea id="description" rows="3" placeholder="Mô tả" required><?php echo $setting['description']; ?></textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-lg-6">
                                                            <div class="single-input-item">
                                                                <label for="domain" class="required">Tên miền</label>
                                                                <input type="text" id="domain" placeholder="Tên miền" value="<?php echo $setting['domain']; ?>" required />
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="single-input-item">
                                                                <label for="brand" class="required">Thương hiệu</label>
                                                                <input type="text" id="brand" placeholder="Thương hiệu" value="<?php echo $setting['brand']; ?>" required />
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-lg-6">
                                                            <div class="single-input-item">
                                                                <label for="email" class="required">Địa chỉ email</label>
                                                                <input type="text" id="email" placeholder="Địa chỉ email" value="<?php echo $setting['email']; ?>" required />
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="single-input-item">
                                                                <label for="phone" class="required">Số điện thoại</label>
                                                                <input type="text" id="phone" placeholder="Số điện thoại" value="<?php echo $setting['phone']; ?>" required />
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-lg-12">
                                                            <div class="single-input-item">
                                                                <label for="address" class="required">Địa chỉ</label>
                                                                <textarea id="address" rows="3" placeholder="Địa chỉ" required><?php echo $setting['address']; ?></textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-lg-6">
                                                            <div class="single-input-item">
                                                                <label for="logo" class="required">Đường dẫn Logo</label>
                                                                <input type="text" id="logo" placeholder="Đường dẫn Logo" value="<?php echo $setting['logo']; ?>" required />
                                                                <img src="<?php echo $setting['logo']; ?>" alt="Logo" style="height: 50px; margin-top: 5px;">
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="single-input-item">
                                                                <label for="favicon" class="required">Đường dẫn Favicon</label>
                                                                <input type="text" id="favicon" placeholder="Đường dẫn Favicon" value="<?php echo $setting['icon']; ?>" required />
                                                                <img src="<?php echo $setting['icon']; ?>" alt="Favicon" style="height: 50px; margin-top: 5px;">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-lg-12">
                                                            <div class="single-input-item">
                                                                <label for="maintenance" class="required">Trạng thái bảo trì</label>
                                                                <select id="maintenance" name="maintenance" required>
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
        </div>
    </div>
</main>
<script>
    $(function() {
        $("#login").click(function(e) {
            e.preventDefault();
            let username = $("#login-username").val();
            let password = $("#login-password").val();
            if (!username) {
                toarst("", "Tên đăng nhập không được để trống", "error");
                return;
            }
            if (!password) {
                toarst("", "Mật khẩu không được để trống", "error");
                return;
            }
            $.ajax({
                type: "POST",
                url: "/ajax/auth/login.php",
                data: {
                    username,
                    password,
                },
                dataType: "json",
                beforeSend: function() {
                    wait("#login", false);
                },
                complete: function() {
                    wait("#login", true, '<i class="fa fa-sign-in"></i> Đăng nhập');
                },
                success: function(res) {
                    if (res.success) {
                        toarst("", res.success, "success");
                        setTimeout(() => {
                            window.location.reload();
                        }, 1500);
                    } else {
                        toarst("", res.error, "error");
                    }
                },
                error: function(error) {
                    console.log(error);
                },
            });
        });
    });
</script>
<?php require_once __DIR__ . '/../layouts/footer.php'; ?>