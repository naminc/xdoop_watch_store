<?php require_once __DIR__ . '/../../layouts/header.php'; ?>
<?php require_once __DIR__ . '/../components/breadcrumb.php'; ?>

<main>
    <div class="container pt-50 pb-50">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="bg-dark text-white p-4 rounded shadow">
                    <h3 class="text-center mb-4"><i class="fa fa-calendar"></i> Xem doanh thu theo ngày</h3>

                    <form action="/admin/revenue/bydate" method="post">
                        <div class="mb-3">
                            <label for="date" class="form-label">Chọn ngày:</label>
                            <input type="date" id="date" name="date" class="form-control" required value="<?= date('Y-m-d') ?>">
                        </div>
                        <button type="submit" class="btn btn-success w-100"><i class="fa fa-search"></i> Xem doanh thu</button>
                    </form>
                    <?php if (isset($selectedDate)): ?>
                        <?php if ($revenue == 0 || $revenue == null): ?>
                            <div class="alert alert-danger mt-3">
                                Không có doanh thu nào trong ngày <strong><?= date('d/m/Y', strtotime($selectedDate)) ?></strong>
                            </div>
                        <?php else: ?>
                            <div class="alert alert-info mt-3">
                                Doanh thu ngày <strong><?= date('d/m/Y', strtotime($selectedDate)) ?></strong> là:
                                <strong><?= number_format($revenue, 0, ',', '.') ?> VNĐ</strong>
                            </div>
                        <?php endif; ?>
                    <?php endif; ?>
                    <a href="/admin/dashboard" class="sqr-btn mt-3"><i class="fa fa-arrow-left"></i> Quay lại</a>
                </div>
            </div>
        </div>
    </div>
</main>

<?php require_once __DIR__ . '/../../layouts/footer.php'; ?>
