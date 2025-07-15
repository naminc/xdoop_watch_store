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
                            <?php $active = 'user'; ?>
                            <?php require_once __DIR__ . '/../components/tab.php'; ?>
                            <div class="col-lg-9 col-md-8">
                                <div class="myaccount-content">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <h3 class="mb-0"><i class="fa fa-users"></i> Quản lý người dùng</h3>
                                        <a href="/admin/user/create" class="btn btn-success"><i class="fa fa-plus"></i> Thêm người dùng</a>
                                    </div>
                                    <div class="myaccount-table table-responsive text-center">
                                        <table class="table table-bordered">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th>#</th>
                                                    <th>Họ tên</th>
                                                    <th>Tên người dùng</th>
                                                    <th>Email</th>
                                                    <th>Số điện thoại</th>
                                                    <th>Vai trò</th>
                                                    <th>Trạng thái</th>
                                                    <th>IP/User-Agent</th>
                                                    <th>Ngày tạo</th>
                                                    <th>Hành động</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                if (!empty($users)):
                                                    foreach ($users as $user): ?>
                                                <tr>
                                                    <td><?= $user['id'] ?></td>
                                                    <td><?= empty($user['fullname']) ? 'NULL' : $user['fullname'] ?></td>
                                                    <td><?= $user['username'] ?></td>
                                                    <td><?= $user['email'] ?></td>
                                                    <td><?= empty($user['phone']) ? 'NULL' : $user['phone'] ?></td>
                                                    <td><?= $user['role'] == 'admin' ? '<span class="badge bg-success">Admin</span>' : '<span class="badge bg-primary">User</span>' ?></td>
                                                    <td><span class="badge bg-<?= $user['status'] == 1 ? 'success' : 'danger' ?>"><?= $user['status'] == 1 ? 'Hoạt động' : 'Không hoạt động' ?></span></td>
                                                    <td><textarea class="form-control" rows="2" readonly><?= $user['ip_address'] ?> / <?= $user['user_agent'] ?></textarea></td>
                                                    <td><?= date('d/m/Y H:i:s', strtotime($user['created_at'])) ?></td>
                                                    <td>
                                                        <a href="/admin/user/edit/<?= $user['id'] ?>" class="check-btn sqr-btn "><i class="fa fa-edit"></i></a>
                                                        <a onclick="return confirm('Bạn có chắc chắn muốn xóa người dùng này không?')" href="/admin/user/delete/<?= $user['id'] ?>" class="check-btn delete-btn "><i class="fa fa-trash"></i></a>
                                                    </td>
                                                </tr>
                                                <?php endforeach;
                                                else: ?>
                                                    <tr>
                                                        <td colspan="9" class="text-center">Không có dữ liệu</td>
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
            window.location.href = <?= json_encode($redirect ?? "/admin/user/index") ?>;
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
            window.location.href = <?= json_encode($redirect ?? "/admin/user/index") ?>;
        });
    </script>
<?php endif; ?>