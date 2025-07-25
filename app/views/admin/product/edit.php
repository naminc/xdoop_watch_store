<?php
if (empty($_SESSION['user']) || $_SESSION['user']['role'] != 'admin') {
    header('Location: /');
    exit;
}
require_once __DIR__ . '/../../layouts/header.php';
?>
<?php require_once __DIR__ . '/../components/breadcrumb.php'; ?>
<main>
    <div class="my-account-wrapper pt-50 pb-50 pt-sm-50 pb-sm-50">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="myaccount-page-wrapper">
                        <div class="row">
                            <?php $active = 'product'; ?>
                            <?php require_once __DIR__ . '/../components/tab.php'; ?>
                            <div class="col-lg-9 col-md-8">
                                <div class="myaccount-content">
                                    <h3>Sửa sản phẩm</h3>
                                    <div class="account-details-form">
                                        <form method="post" action="/admin/product/edit/<?= $dproduct['id'] ?>" enctype="multipart/form-data">
                                            <div class="single-input-item">
                                                <label for="name" class="required">Tên sản phẩm </label>
                                                <input type="text" name="name" placeholder="Tên sản phẩm" value="<?= $dproduct['name'] ?>" required />
                                            </div>
                                            <div class="single-input-item">
                                                <label for="description" class="required">Mô tả</label>
                                                <textarea name="description" rows="3" placeholder="Mô tả" required><?= $dproduct['description'] ?></textarea>
                                            </div>
                                            <div class="single-input-item">
                                                <label for="image" class="required">Ảnh</label>
                                                <input type="file" name="image" placeholder="Ảnh" />
                                            </div>
                                            <div class="single-input-item">
                                                <label for="price" class="required">Giá</label>
                                                <input type="number" name="price" placeholder="Giá" value="<?= $dproduct['price'] ?>" required />
                                            </div>
                                            <div class="single-input-item">
                                                <label for="stock" class="required">Số lượng tồn</label>
                                                <input type="number" name="stock" placeholder="Số lượng tồn" value="<?= $dproduct['stock'] ?>" required />
                                            </div>
                                            <div class="single-input-item">
                                                <label for="category_id" class="required">Danh mục</label>
                                                <select name="category_id" required>
                                                    <option value="">Chọn danh mục</option>
                                                    <?php foreach ($list_category as $category): ?>
                                                        <option value="<?= $category['id'] ?>" <?= $dproduct['category_id'] == $category['id'] ? 'selected' : '' ?>><?= $category['name'] ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="single-input-item">
                                                        <button class="check-btn sqr-btn" type="submit" name="edit"><i class="fa fa-save"></i> Sửa sản phẩm</button>
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
</main>

<?php require_once __DIR__ . '/../../layouts/footer.php'; ?>
<?php if (!empty($error)): ?>
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: <?= json_encode($error) ?>
        }).then(() => {
            window.location.href = <?= json_encode($redirect ?? "/admin/product/index") ?>;
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
            window.location.href = <?= json_encode($redirect ?? "/admin/product/index") ?>;
        });
    </script>
<?php endif; ?>