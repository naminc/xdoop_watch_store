<?php
if (isset($_SESSION['user'])) {
    header('Location: /home');
    exit;
}
require_once __DIR__ . '/../../layouts/header.php';
?>
<?php require_once __DIR__ . '/../components/breadcrumb.php'; ?>    
<main>
    <div class="login-register-wrapper pt-50 pb-50 pt-sm-50 pb-sm-50">
        <div class="container">
            <div class="member-area-from-wrap">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="login-reg-form-wrap  pr-lg-50">
                            <h2>Đăng nhập</h2>
                            <form method="post">
                                <div class="single-input-item">
                                    <input type="text" name="username" placeholder="Tên đăng nhập" required />
                                </div>
                                <div class="single-input-item">
                                    <input type="password" name="password" placeholder="Mật khẩu" required />
                                </div>
                                <div class="single-input-item">
                                    <div class="login-reg-form-meta d-flex align-items-center justify-content-between">
                                        <div class="remember-meta">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="rememberMe">
                                                <label class="custom-control-label" for="rememberMe">Nhớ tôi</label>
                                            </div>
                                        </div>
                                        <a href="#" class="forget-pwd">Quên mật khẩu?</a>
                                    </div>
                                </div>
                                <div class="single-input-item">
                                    <button class="sqr-btn" type="submit" name="login">Đăng nhập</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="login-reg-form-wrap mt-md-100 mt-sm-58">
                            <h2>Đăng ký</h2>
                            <form method="post">
                                <div class="single-input-item">
                                    <input type="text" name="username" placeholder="Tên đăng nhập" required />
                                </div>
                                <div class="single-input-item">
                                    <input type="email" name="email" placeholder="Địa chỉ email" required />
                                </div>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="single-input-item">
                                            <input type="password" name="password" placeholder="Mật khẩu" required />
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="single-input-item">
                                            <input type="password" name="confirm_password" placeholder="Nhập lại mật khẩu" required />
                                        </div>
                                    </div>
                                </div>
                                <div class="single-input-item">
                                    <div class="login-reg-form-meta">
                                        <div class="remember-meta">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="subnewsletter">
                                                <label class="custom-control-label" for="subnewsletter">Đăng ký nhận tin</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="single-input-item">
                                    <button class="sqr-btn" type="submit" name="register">Đăng ký</button>
                                </div>
                            </form>
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
            window.location.href = <?= json_encode($redirect ?? "/auth/login") ?>;
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
            window.location.href = <?= json_encode($redirect ?? "/") ?>;
        });
    </script>
<?php endif; ?>