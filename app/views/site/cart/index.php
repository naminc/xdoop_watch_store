<?php
require_once __DIR__ . '/../../layouts/header.php';
?>
<?php require_once __DIR__ . '/../components/breadcrumb.php'; ?>
<main>
    <!-- cart main wrapper start -->
    <div class="cart-main-wrapper pt-100 pb-100 pt-sm-58 pb-sm-58">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="cart-table table-responsive" style="background-color: #fff;">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th class="pro-thumbnail">Hình ảnh</th>
                                    <th class="pro-title">Sản phẩm</th>
                                    <th class="pro-price">Giá</th>
                                    <th class="pro-quantity">Số lượng</th>
                                    <th class="pro-subtotal">Tổng</th>
                                    <th class="pro-remove">Xóa</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($cart)) : ?>
                                    <?php $discount = 0; ?>
                                    <?php foreach ($cart as $item) : ?>
                                        <tr>
                                            <td class="pro-thumbnail"><a href="#"><img class="img-fluid" src="/uploads/products/<?= $item['image'] ?>"
                                                        alt="Product" /></a></td>
                                            <td class="pro-title"><a href="/product/detail/<?= $item['slug'] ?>"><?= $item['name'] ?></a></td>
                                            <td class="pro-price"><span><?= number_format($item['price'], 0, ',', '.') ?> VNĐ</span></td>
                                            <td class="pro-quantity">
                                                <form action="/cart/update/<?= $item['id'] ?>" method="post" class="d-flex align-items-center gap-2">
                                                    <div class="input-group" style="width: 70px;">
                                                        <input type="number"
                                                            name="quantity"
                                                            class="form-control form-control-sm text-center input-qty"
                                                            value="<?= (int)$item['quantity'] ?>"
                                                            min="1" step="1" required>
                                                    </div>
                                                    <button type="submit" class="sqr-btn-sm">Cập nhật</button>
                                                </form>
                                            </td>
                                            <td class="pro-subtotal"><span><?= number_format($item['price'] * $item['quantity'], 0, ',', '.') ?> VNĐ</span></td>
                                            <td class="pro-remove">
                                                <form action="/cart/remove/<?= $item['id'] ?>" method="post">
                                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này khỏi giỏ hàng không?')"><i class="fa fa-trash-o"></i></button>
                                                </form>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else : ?>
                                    <tr>
                                        <td colspan="6" class="text-center">Không có sản phẩm nào trong giỏ hàng</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                    <!-- Cart Update Option -->


                    <div class="cart-update-option d-block d-md-flex justify-content-between">
                        <div class="apply-coupon-wrapper">
                            <form action="/cart/applycoupon" method="post" class=" d-block d-md-flex">
                                <input type="text" name="coupon" placeholder="Nhập mã giảm giá" required />
                                <button class="sqr-btn" name="applycoupon">Áp dụng</button>
                            </form>
                        </div>
                        <?php if (!empty($_SESSION['coupon'])): ?>
                            <div class="alert alert-success">
                                Mã <strong><?= $_SESSION['coupon']['code'] ?></strong> đã được áp dụng!
                                (Giảm: <?= $_SESSION['coupon']['discount_type'] === 'percentage' ? $_SESSION['coupon']['discount_value'] . '%' : number_format($_SESSION['coupon']['discount_value'], 0, ',', '.') . ' VNĐ' ?>)
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="cart-calculator-wrapper">
                        <div class="cart-calculate-items">
                            <h3>Tổng tiền</h3>
                            <div class="table-responsive">
                                <table class="table">
                                    <tr>
                                        <td>Tổng tiền</td>
                                        <td><?= number_format($subtotal, 0, ',', '.') ?> VNĐ</td>
                                    </tr>
                                    <tr>
                                        <td>Phí vận chuyển</td>
                                        <td>Miễn phí</td>
                                    </tr>
                                    <?php if (!empty($_SESSION['coupon'])): ?>
                                        <tr>
                                            <td>Giảm giá</td>
                                            <td><?php if ($_SESSION['coupon']['discount_type'] == 'percentage') {
                                                    $discount = $subtotal * $_SESSION['coupon']['discount_value'] / 100;
                                                    echo $_SESSION['coupon']['discount_value'] . '%';
                                                } else {
                                                    $discount = $_SESSION['coupon']['discount_value'];
                                                    echo number_format($_SESSION['coupon']['discount_value'], 0, ',', '.') . ' VNĐ';
                                                }
                                                ?></td>
                                        </tr>
                                    <?php endif; ?>
                                    <tr class="total">
                                        <td>Tổng tiền</td>
                                        <td class="total-amount"><?= number_format($subtotal - $discount, 0, ',', '.') ?> VNĐ</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <a href="/checkout" class="sqr-btn d-block"><i class="fa fa-credit-card"></i> Thanh toán</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- cart main wrapper end -->
</main>
<?php require_once __DIR__ . '/../../layouts/footer.php'; ?>
<?php if (!empty($error)): ?>
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: <?= json_encode($error) ?>
        }).then(() => {
            window.location.href = <?= json_encode($redirect ?? "/cart/index") ?>;
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
            window.location.href = <?= json_encode($redirect ?? "/cart/index") ?>;
        });
    </script>
<?php endif; ?>