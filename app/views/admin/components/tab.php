<div class="col-lg-3 col-md-4">
    <div class="myaccount-tab-menu nav">
        <a href="/admin/dashboard" <?php echo $active == 'dashboard' ? 'class="active"' : ''; ?>><i class="fa fa-dashboard"></i> Bảng điều khiển</a>
        <a href="/admin/setting" <?php echo $active == 'setting' ? 'class="active"' : ''; ?>><i class="fa fa-cogs"></i> Quản lý hệ thống</a>
        <a href="/admin/category/index" <?php echo $active == 'category' ? 'class="active"' : ''; ?>><i class="fa fa-list"></i> Quản lý danh mục</a>
        <a href="/admin/product/index" <?php echo $active == 'product' ? 'class="active"' : ''; ?>><i class="fa fa-shopping-cart"></i> Quản lý sản phẩm</a>
        <a href="/admin/order/index" <?php echo $active == 'order' ? 'class="active"' : ''; ?>><i class="fa fa-cart-arrow-down"></i> Quản lý đơn hàng</a>
        <a href="/admin/user/index" <?php echo $active == 'user' ? 'class="active"' : ''; ?>><i class="fa fa-users"></i> Quản lý người dùng</a>
    </div>
</div>