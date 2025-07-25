<?php require_once __DIR__ . '/../layouts/header.php'; ?>
<?php require_once __DIR__ . '/components/breadcrumb.php'; ?>
<main>
    <!-- faq main wrapper start -->
    <div class="faq-main-wrapper pt-50 pb-50 pt-sm-56 pb-sm-60">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="faq-inner">
                        <div class="accordion" id="general-question">
                            <div class="card">
                                <div class="card-header" id="headingOne">
                                    <h5 class="mb-0">
                                        <button class="accordio-heading" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                            <i class="ion-ribbon-b"></i>
                                            Voucher ưu đãi
                                        </button>
                                    </h5>
                                </div>

                                <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-bs-parent="#general-question">
                                    <div class="card-body">
                                        <p>
                                            Nhân dịp <?= $setting['brand'] ?> store khai trương, chúng tôi có nhiều chính sách ưu đãi cho khách hàng.
                                        </p>
                                        <div class="row" style="margin-top: 20px;">
                                            <div class="col-lg-6">
                                                <!-- Khối 1: Danh sách voucher -->
                                                <div style="border: 2px dashed red; padding: 15px; margin-bottom: 20px;">
                                                    <ul style="margin-bottom: 0;">
                                                        <li>
                                                            <strong>Voucher ưu đãi 100.000 VNĐ</strong><br>
                                                            Mã: <strong>FREE100</strong>
                                                            <p>Áp dụng cho mọi đơn hàng.</p>
                                                        </li>

                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div style="border: 2px dashed red; padding: 15px; margin-bottom: 20px;">
                                                    <ul style="margin-bottom: 0;">
                                                        <li>
                                                            <strong>Voucher ưu đãi giảm giá 20%</strong><br>
                                                            Mã: <strong>VIP20</strong>
                                                            <p>Áp dụng cho mọi đơn hàng.</p>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>


                                        <!-- Khối 2: Lưu ý -->
                                        <div style="border: 2px dashed green; padding: 15px; margin-top: 20px;">
                                            <strong>Lưu ý:</strong>
                                            <p>- Mỗi khách hàng chỉ sử dụng mã giảm giá 1 lần.</p>
                                            <p>- Mã giảm giá chỉ áp dụng cho đơn hàng đầu tiên của khách hàng.</p>
                                            <p>- Mã giảm giá không áp dụng cho sản phẩm đang trong thời gian khuyến mãi đặc biệt.</p>

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
    <!-- faq main wrapper end -->
</main>
<?php require_once __DIR__ . '/../layouts/footer.php'; ?>