<?php
$category = $data['category'];
$products = $data['products'];
?>
<h1>Danh mục: <?= $category['name'] ?></h1>
<div class="row">
    <div class="col-md-12">
        <h2>Sản phẩm</h2>
    </div>
    <?php foreach ($products as $product): ?>
        <div class="col-md-4">
            <div class="card">
                <img src="<?= $product['image'] ?>" alt="<?= $product['name'] ?>">
                <div class="card-body">
                    <h5 class="card-title"><?= $product['name'] ?></h5>
                    <p class="card-text"><?= $product['description'] ?></p>
                    <p class="card-text"><?= $product['price'] ?></p>
                    <a href="/product/detail/<?= $product['slug'] ?>" class="btn btn-primary">Xem chi tiết</a>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>  