<?php require_once __DIR__ . '/../../layouts/header.php'; ?>
<div class="hero-area">
    <div class="hero-slider-active slider-arrow-style slick-dot-style hero-dot">
        <div class="hero-single-slide hero-2 hero-2__Style-5 d-flex align-items-center" style="background-image: url(assets/img/slider/slide-9.jpg);">
            <div class="container">
                <div class="slider-content text-center">
                    <h1>Một chiếc đồng hồ thông minh với<br>màn hình luôn bật<br>và tính năng Fitbit.</h1>
                    <h3 class="text-white">Và thời lượng pin 30 ngày</h3>
                    <a href="/" class="slider-btn">Xem bộ sưu tập</a>
                </div>
            </div>
        </div>
        <div class="hero-single-slide hero-2 hero-2__Style-5 d-flex align-items-center" style="background-image: url(assets/img/slider/slide-10.jpg);">
            <div class="container">
                <div class="slider-content text-center ms-auto">
                    <h1>Một chiếc đồng hồ thông minh với<br>màn hình luôn bật<br>và tính năng Fitbit.</h1>
                    <h3 class="text-white">Và thời lượng pin 30 ngày</h3>
                    <a href="/" class="slider-btn">Xem bộ sưu tập</a>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="banner-statistic-one pt-100 pt-sm-58">
    <div class="container">
        <div class="row">
            <div class="col1 col-sm-6">
                <div class="img-container img-full fix">
                    <a href="#">
                        <img src="/assets/img/banner/cms_5.1.jpg" alt="banner image">
                    </a>
                </div>
            </div>
            <div class="col2 col-sm-6">
                <div class="img-container img-full fix">
                    <a href="#">
                        <img src="/assets/img/banner/cms_5.2.jpg" alt="banner image">
                    </a>
                </div>
            </div>
            <div class="col3 col">
                <div class="img-container img-full fix mb-30">
                    <a href="#">
                        <img src="/assets/img/banner/cms_5.3.jpg" alt="banner image">
                    </a>
                </div>
                <div class="img-container img-full fix">
                    <a href="#">
                        <img src="/assets/img/banner/cms_5.4.jpg" alt="banner image">
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="page-section pt-100 pb-50">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="section-title text-center pb-44">
                    <p>Tất cả sản phẩm</p>
                    <h2 class="text-white">Tất cả sản phẩm</h2>
                </div>
            </div>
        </div>

        <div class="row">
            <?php foreach ($products as $product) : ?>
                <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                    <div class="product-item item-black">
                        <div class="product-thumb">
                            <a href="/product/detail/<?php echo $product['slug']; ?>">
                                <img src="/uploads/products/<?php echo $product['image']; ?>" alt="product image">
                            </a>
                            <div class="box-label">
                                <div class="product-label new">
                                    <span>new</span>
                                </div>
                            </div>
                            <div class="product-action-link">
                                <a href="#" data-bs-toggle="modal" data-bs-target="#quick_view" title="Quick view">
                                    <i class="ion-ios-eye-outline"></i>
                                </a>
                            </div>
                        </div>
                        <div class="product-description text-center">
                            <div class="manufacturer">
                                <p><a href="product-details.html"><?php echo $product['category_name']; ?></a></p>
                            </div>
                            <div class="product-name">
                                <h3><a href="/product/detail/<?php echo $product['slug']; ?>"><?php echo $product['name']; ?></a></h3>
                            </div>
                            <div class="price-box">
                                <span class="regular-price"><?php echo number_format($product['price'], 0, ',', '.'); ?> VNĐ</span>
                            </div>
                            <div class="hover-box text-center">
                                <div class="product-btn">
                                    <form action="/cart/add/<?php echo $product['id']; ?>" method="post">
                                        <input type="hidden" name="quantity" value="1">
                                        <button type="submit" class="btn btn-light"><i class="ion-bag"></i>Thêm vào giỏ hàng</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

    </div>
</div>

<div class="banner-feature-area bg-black pt-62 pb-60 pt-sm-56 pb-sm-20">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-md-4">
                <div class="banner-single-feature text-center mb-sm-30">
                    <i class="ion-paper-airplane"></i>
                    <h4>Giao hàng miễn phí</h4>
                    <p>Chúng tôi cung cấp dịch vụ giao hàng toàn quốc với đội ngũ nhân viên chuyên nghiệp, đảm bảo sự an toàn và nhanh chóng. Phí vận chuyển được tính dựa trên địa chỉ giao hàng.</p>
                </div>
            </div>
            <div class="col-lg-4 col-md-4">
                <div class="banner-single-feature text-center mb-sm-30">
                    <i class="ion-ios-time-outline"></i>
                    <h4>Đổi trả dễ dàng</h4>
                    <p>Chúng tôi cung cấp dịch vụ đổi trả dễ dàng với đội ngũ nhân viên chuyên nghiệp, đảm bảo sự an toàn và nhanh chóng. Phí đổi trả được tính dựa trên địa chỉ giao hàng.</p>
                </div>
            </div>
            <div class="col-lg-4 col-md-4">
                <div class="banner-single-feature text-center mb-sm-30">
                    <i class="ion-trophy"></i>
                    <h4>Bảo hành lâu dài</h4>
                    <p>Chúng tôi cung cấp dịch vụ bảo hành lâu dài với đội ngũ nhân viên chuyên nghiệp, đảm bảo sự an toàn và nhanh chóng. Phí bảo hành được tính dựa trên địa chỉ giao hàng.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../../layouts/footer.php'; ?>
<?php if (!empty($error)): ?>
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: <?= json_encode($error) ?>
        }).then(() => {
            window.location.href = <?= json_encode($redirect ?? "/") ?>;
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
            window.location.href = <?= json_encode($redirect ?? "/home") ?>;
        });
    </script>
<?php endif; ?>