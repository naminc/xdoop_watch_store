<?php
require_once __DIR__ . '/../layouts/header.php';
?>
<?php require_once __DIR__ . '/components/breadcrumb.php'; ?>
<main>
    <!-- checkout main wrapper start -->
    <div class="checkout-page-wrapper pt-50 pb-50 pt-sm-58 pb-sm-54">
        <div class="container">
            <form action="/checkout/process" method="post">
                <div class="row">
                    <!-- Checkout Billing Details -->
                    <div class="col-lg-6 p-3" style="background-color: #fff;">
                        <div class="checkout-billing-details-wrap">
                            <h2>Thông tin thanh toán</h2>
                            <div class="billing-form-wrap">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="single-input-item">
                                            <label for="fullname" class="required">Họ và tên</label>
                                            <input type="text" id="fullname" name="fullname" placeholder="Họ và tên" required />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="single-input-item">
                                            <label for="phone" class="required">Số điện thoại</label>
                                            <input type="text" id="phone" name="phone" placeholder="Số điện thoại" required />
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="single-input-item">
                                            <label for="email" class="required">Email</label>
                                            <input type="email" id="email" name="email" placeholder="Email" required />
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="single-input-item">
                                            <label for="street-address" class="required">Địa chỉ (Số nhà, Đường)</label>
                                            <input type="text" id="street-address" name="address" placeholder="Địa chỉ (Số nhà, Đường)" required />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="single-input-item">
                                            <label for="state" class="required">Phường/Xã</label>
                                            <input type="text" id="state" name="district" placeholder="Phường/Xã" required />
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="single-input-item">
                                            <label for="town" class="required">Tỉnh/Thành phố</label>
                                            <input type="text" id="town" name="city" placeholder="Tỉnh/Thành phố" required />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="single-input-item">
                                            <label for="postcode" class="required">Mã vùng</label>
                                            <input type="text" id="postcode" name="postcode" placeholder="Mã vùng" required />
                                        </div>
                                    </div>
                                </div>
                                <div class="single-input-item">
                                    <label for="note">Ghi chú (Nếu có)</label>
                                    <textarea name="note" id="note" cols="30" rows="3" placeholder="Ghi chú"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Order Summary Details -->
                    <div class="col-lg-6 p-3" style="background-color: #fff;">
                        <div class="order-summary-details mt-md-26 mt-sm-26">
                            <h2>Tóm tắt đơn hàng</h2>
                            <div class="order-summary-content mb-sm-4">
                                <!-- Order Summary Table -->
                                <div class="order-summary-table table-responsive text-center">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Sản phẩm</th>
                                                <th>Tổng</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            if (!empty($cart)):
                                                foreach ($cart as $item): ?>
                                                    <tr>
                                                        <td><a style="text-decoration: none; color:rgb(68, 183, 133);" href="/product/detail/<?= $item['slug'] ?>"><?= $item['name'] ?> <strong> × <?= $item['quantity'] ?></strong></a></td>
                                                        <td><?= number_format($item['price'], 0, ',', '.') ?> VNĐ</td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td>Phí vận chuyển</td>
                                                <td class="d-flex justify-content-center">
                                                    <ul class="shipping-type">
                                                        <li>
                                                            Miễn phí
                                                        </li>
                                                    </ul>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Tổng tiền</td>
                                                <td><strong><?= number_format($subtotal, 0, ',', '.') ?> VNĐ</strong></td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                                <!-- Order Payment Method -->
                                <div class="order-payment-method">
                                    <div class="single-payment-method show">
                                        <div class="payment-method-name">
                                            <div class="custom-control custom-radio">
                                                <input type="radio" id="cashon" name="paymentmethod" value="cash" class="custom-control-input" checked />
                                                <label class="custom-control-label" for="cashon">Thanh toán khi nhận hàng</label>
                                            </div>
                                        </div>
                                        <div class="payment-method-details" data-method="cash">
                                            <p>Vui lòng thanh toán khi nhận hàng.</p>
                                        </div>
                                    </div>
                                    <div class="summary-footer-area">
                                        <div class="custom-control custom-checkbox mb-14">
                                            <input type="checkbox" class="custom-control-input" id="terms" required />
                                            <label class="custom-control-label" for="terms">Tôi đã đọc và đồng ý với <a
                                                    href="#">điều khoản và điều kiện</a></label>
                                        </div>
                                        <button type="submit" name="checkout" class="check-btn sqr-btn">Đặt hàng</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- checkout main wrapper end -->
</main>
<?php require_once __DIR__ . '/../layouts/footer.php'; ?>