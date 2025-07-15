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
                            <?php $active = 'category'; ?>
                            <?php require_once __DIR__ . '/../components/tab.php'; ?>
                            <div class="col-lg-9 col-md-8">
                                <div class="myaccount-content">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <h3 class="mb-0"><i class="fa fa-list"></i> Quản lý danh mục</h3>
                                        <a href="/admin/category/create" class="btn btn-success"><i class="fa fa-plus"></i> Thêm danh mục</a>
                                    </div>
                                    <div class="myaccount-table table-responsive text-center">
                                        <table class="table table-bordered">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th>#</th>
                                                    <th>Tên danh mục</th>
                                                    <th>Slug</th>
                                                    <th>Mô tả</th>
                                                    <th>Trạng thái</th>
                                                    <th>Ngày tạo</th>
                                                    <th>Ngày cập nhật</th>
                                                    <th>Hành động</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                if (!empty($categories)):
                                                    foreach ($categories as $category): ?>
                                                <tr>
                                                    <td><?= $category['id'] ?></td>
                                                    <td><?= $category['name'] ?></td>
                                                    <td><?= $category['slug'] ?></td>
                                                    <td><?= $category['description'] ?></td>
                                                    <td><span class="badge bg-<?= $category['status'] == 1 ? 'success' : 'danger' ?>"><?= $category['status'] == 1 ? 'Đang hoạt động' : 'Không hoạt động' ?></span></td>
                                                    <td><?= date('d/m/Y H:i:s', strtotime($category['created_at'])) ?></td>
                                                    <td><?= date('d/m/Y H:i:s', strtotime($category['updated_at'])) ?></td>
                                                    <td>
                                                        <a href="/admin/category/edit/<?= $category['id'] ?>" class="check-btn sqr-btn "><i class="fa fa-edit"></i></a>
                                                        <a onclick="return confirm('Bạn có chắc chắn muốn xóa danh mục này không?')" href="/admin/category/delete/<?= $category['id'] ?>" class="check-btn delete-btn "><i class="fa fa-trash"></i></a>
                                                    </td>
                                                </tr>
                                                <?php endforeach;
                                                else: ?>
                                                    <tr>
                                                        <td colspan="8" class="text-center">Không có dữ liệu</td>
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
            window.location.href = <?= json_encode($redirect ?? "/admin/category/index") ?>;
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
            window.location.href = <?= json_encode($redirect ?? "/admin/category/index") ?>;
        });
    </script>
<?php endif; ?>