<?php require_once __DIR__ . '/../layouts/header.php'; ?>
<?php require_once __DIR__ . '/components/breadcrumb.php'; ?>
<main>
    <!-- contact wrapper area start -->
    <div class="contact-top-area pt-100 pb-98 pt-sm-58 pb-sm-58">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section-title text-center pb-44">
                        <p style="color: #ffffff !important;">Liên hệ</p>
                        <h2 style="color: #ffffff !important;">Thông tin liên hệ</h2>
                    </div>
                </div>
            </div> <!-- section title end -->
            <div class="row">
                <div class="col-lg-4 col-md-6 col-sm-6">
                    <div class="contact-single-info mb-30 text-center">
                        <div class="contact-icon">
                            <i class="fa fa-map-marker"></i>
                        </div>
                        <h3 style="color: #ffffff !important;">Địa chỉ</h3>
                        <p style="color: #ffffff !important;"><?php echo $setting['address']; ?></p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-6">
                    <div class="contact-single-info mb-30 text-center">
                        <div class="contact-icon">
                            <i class="fa fa-phone"></i>
                        </div>
                        <h3 style="color: #ffffff !important;">Số điện thoại</h3>
                        <p style="color: #ffffff !important;">Call: <a style="color: #ffffff !important;" href="tel:<?php echo $setting['phone']; ?>"><?php echo $setting['phone']; ?></a></p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-6">
                    <div class="contact-single-info mb-30 text-center">
                        <div class="contact-icon">
                            <i class="fa fa-envelope"></i>
                        </div>
                        <h3 style="color: #ffffff !important;">Email</h3>
                        <p style="color: #ffffff !important;"><a style="color: #ffffff !important;" href="mailto:<?php echo $setting['email']; ?>"><?php echo $setting['email']; ?></a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- contact wrapper area end -->
</main>
<?php require_once __DIR__ . '/../layouts/footer.php'; ?>