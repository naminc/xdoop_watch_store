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
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <h3 class="mb-0"><i class="fa fa-shopping-cart"></i> Quản lý sản phẩm</h3>
                                        <a href="/admin/product/create" class="btn btn-success"><i class="fa fa-plus"></i> Thêm sản phẩm</a>
                                    </div>
                                    <div class="myaccount-table table-responsive text-center">
                                        <table class="table table-bordered">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th>#</th>
                                                    <th>Tên sản phẩm</th>
                                                    <th>Slug</th>
                                                    <th>Mô tả</th>
                                                    <th>Ảnh sản phẩm</th>
                                                    <th>Giá</th>
                                                    <th>Số lượng tồn</th>
                                                    <th>Danh mục</th>
                                                    <th>Ngày tạo</th>
                                                    <th>Ngày cập nhật</th>
                                                    <th>Hành động</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                if (!empty($products)):
                                                    foreach ($products as $product): ?>
                                                <tr>
                                                    <td><?= $product['id'] ?></td>
                                                    <td><?= $product['name'] ?></td>
                                                    <td><?= $product['slug'] ?></td>
                                                    <td><textarea name="description" id="description" cols="30" rows="3" readonly><?= $product['description'] ?></textarea></td>
                                                    <td><img src="/uploads/products/<?= $product['image'] ?>" alt="<?= $product['name'] ?>" style="height: 100px; width: 100px; object-fit: cover;"></td>
                                                    <td><span class="badge bg-danger"><?= number_format($product['price'], 0, ',', '.') ?> VNĐ</span></td>
                                                    <td><?= $product['stock'] ?></td>
                                                    <td><?= $product['category_name'] ?></td>
                                                    <td><?= date('d/m/Y H:i:s', strtotime($product['created_at'])) ?></td>
                                                    <td><?= date('d/m/Y H:i:s', strtotime($product['updated_at'])) ?></td>
                                                    <td>
                                                        <a href="/admin/product/edit/<?= $product['id'] ?>" class="check-btn sqr-btn "><i class="fa fa-edit"></i></a>
                                                        <a onclick="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này không?')" href="/admin/product/delete/<?= $product['id'] ?>" class="check-btn delete-btn "><i class="fa fa-trash"></i></a>
                                                    </td>
                                                </tr>
                                                <?php endforeach;
                                                else: ?>
                                                    <tr>
                                                        <td colspan="11" class="text-center">Không có dữ liệu</td>
                                                    </tr>
                                                <?php endif; ?>
                                            </tbody>
                                        </table>
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