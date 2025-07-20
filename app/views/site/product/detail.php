<?php
require_once __DIR__ . '/../../layouts/header.php';
?>
<?php require_once __DIR__ . '/../components/breadcrumb.php'; ?>
<main>
        <div class="product-details-wrapper pt-50 pb-14 pt-sm-58">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <!-- product details inner end -->
                        <div class="product-details-inner" style="background-color: #fff !important;">
                            <div class="row">
                                <div class="col-lg-5">
                                    <div class="product-large-slider mb-10 slider-arrow-style slider-arrow-style__style-2">
                                        <div class="pro-large-img img-zoom" id="img1">
                                        <img src="/uploads/products/<?= $product['image'] ?>" alt="" style="max-width: 100%; width: 460px; height: auto;" />

                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-7">
                                    <div class="product-details-des pt-md-98 pt-sm-58 mt-5">
                                        <h3 style=""><?= $product['name'] ?></h3>
                                        <div class="pricebox mt-2">
                                            <span class="regular-price" style="color:rgb(177, 41, 41) !important; font-size: 24px;"  ><?= number_format($product['price'], 0, ',', '.') ?> VNĐ</span>
                                        </div>
                                        <p><?= $product['description'] ?></p>
                                        <form action="/cart/add/<?= $product['id'] ?>" method="post">
                                        <div class="quantity-cart-box d-flex align-items-center mb-24">
                                            <div class="quantity">
                                                <div class="pro-qty"><input type="number" name="quantity" value="1"></div>
                                            </div>
                                            <div class="product-btn product-btn__color">
                                                <button type="submit" class="btn btn-dark"><i class="ion-bag"></i>Thêm vào giỏ hàng</button>
                                            </div>
                                            </div>
                                        </form>
                                        <div class="availability mb-20">
                                            <h5>Tình trạng:</h5>
                                            <span><?= $product['status'] == 1 ? 'Còn hàng' : 'Hết hàng' ?></span>
                                        </div>
                                        <div class="share-icon mt-2">
                                            <h5>Chia sẻ:</h5>
                                            <a href="#"><i class="fa fa-facebook"></i></a>
                                            <a href="#"><i class="fa fa-twitter"></i></a>
                                            <a href="#"><i class="fa fa-pinterest"></i></a>
                                            <a href="#"><i class="fa fa-google-plus"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="product-review-info">
                                        <ul class="nav review-tab">
                                            <li>
                                                <a class="active" data-bs-toggle="tab" href="#tab_one">Mô tả</a>
                                            </li>
                                        </ul>
                                        <div class="tab-content reviews-tab">
                                            <div class="tab-pane fade show active" id="tab_one">
                                                <div class="tab-one">
                                                    <p><?= $product['description'] ?></p>
                                            </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>  
                        </div>
                        <!-- product details inner end -->
                        <!-- product details reviews start -->
                        <div class="product-details-reviews pt-98 pt-sm-58">
                          
                        </div> 
                        <!-- featured product area end -->
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