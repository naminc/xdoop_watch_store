<?php
require_once __DIR__ . '/../../layouts/header.php';
?>
<?php require_once __DIR__ . '/../components/breadcrumb.php'; ?>
<main>
    <div class="page-section pt-100 pb-50">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section-title text-center pb-44">
                        <p>Kết quả tìm kiếm</p>
                        <h2 class="text-white">Kết quả tìm kiếm: <?= $keyword  ?></h2>
                    </div>
                </div>
            </div>

            <div class="row">
                <?php if (!empty($noResult)): ?>
                    <div class="alert alert-warning text-center">
                        <?= $noResult ?>
                    </div>
                <?php endif; ?>
                <?php foreach ($products as $product) : ?>
                    <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                        <div class="product-item item-black">
                            <div class="product-thumb">
                                <a href="/product/detail/<?php echo $product['slug']; ?>">
                                    <img src="/uploads/products/<?php echo $product['image']; ?>" alt="product image">
                                </a>
                                <div class="box-label">
                                    <div class="product-label <?php if ($product['status'] == 1) echo 'new'; else echo 'discount'; ?>">
                                        <span><?php if ($product['status'] == 1) echo 'Còn hàng'; else echo 'Hết hàng'; ?></span>
                                    </div>
                                </div>
                                <div class="product-action-link">
                                    <a href="/product/detail/<?php echo $product['slug']; ?>" title="Xem chi tiết"  >
                                        <i class="ion-ios-eye-outline"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="product-description text-center">
                                <div class="manufacturer">
                                    <p><a href="/category/detail/<?php echo $product['category_slug']; ?>"><?php echo $product['category_name']; ?></a></p>
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
</main>

<?php require_once __DIR__ . '/../../layouts/footer.php'; ?>
<?php if (!empty($error)): ?>
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: <?= json_encode($error) ?>
        }).then(() => {
            window.location.href = <?= json_encode($redirect ?? "/home") ?>;
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