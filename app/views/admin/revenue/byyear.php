<?php require_once __DIR__ . '/../../layouts/header.php'; ?>
<?php require_once __DIR__ . '/../components/breadcrumb.php'; ?>

<main>
    <div class="container pt-50 pb-50">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="bg-dark text-white p-4 rounded shadow">
                    <h3 class="text-center mb-4"><i class="fa fa-calendar"></i> Xem doanh thu theo năm</h3>

                    <form action="/admin/revenue/byyear" method="post" class="mb-4">
                        <label for="year">Chọn năm:</label>
                        <input type="number" name="year" id="year" class="form-control"
                            min="2000" max="<?= date('Y') ?>" required
                            value="<?= $selectedYear ?? date('Y') ?>">
                        <button type="submit" class="btn btn-success w-100 mt-3"><i class="fa fa-search"></i> Xem doanh thu</button>
                    </form>
                    <?php if (isset($selectedYear)): ?>
                        <?php if ($revenue == 0): ?>
                            <div class="alert alert-danger mt-3">
                                Không có doanh thu nào trong năm <strong><?= $selectedYear ?></strong>
                            </div>
                        <?php else: ?>
                            <div class="alert alert-info mt-3">
                                Doanh thu năm <strong><?= $selectedYear ?></strong> là:
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