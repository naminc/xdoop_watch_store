<!DOCTYPE html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="keywords" content="<?php echo $setting['keyword']; ?>">
    <meta name="description" content="<?php echo $setting['description']; ?>">
    <!-- Site title -->
    <title><?php echo $setting['title']; ?></title>
    <!-- Favicon -->
    <link rel="shortcut icon" href="<?php echo $setting['icon']; ?>" type="image/x-icon">
    <!-- Bootstrap CSS -->
    <link href="/assets/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font-Awesome CSS -->
    <link href="/assets/css/font-awesome.min.css" rel="stylesheet">
    <!-- IonIcon CSS -->
    <link href="/assets/css/ionicons.min.css" rel="stylesheet">
    <!-- helper class css -->
    <link href="/assets/css/helper.min.css" rel="stylesheet">
    <!-- Plugins CSS -->
    <link href="/assets/css/plugins.css" rel="stylesheet">
    <!-- Main Style CSS -->
    <link href="/assets/css/style-green.css?v=<?php echo time(); ?>" rel="stylesheet">
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Custom JS -->
    <script src="/assets/js/custom.js?v=<?php echo time(); ?>"></script>
</head>

<body class="theme-color-5">

    <!-- header area start -->
    <header>

        <!-- header top start -->
        <div class="header-top-area theme-color-5 text-center text-md-start bdr-bottom">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 col-md-5">
                        <div class="header-call-action">
                            <p>Chào mừng bạn đến với <?php echo $setting['brand']; ?> store!</p>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-7">
                        <div class="header-top-right float-md-end float-none">
                            <nav>
                                <ul>
                                    <?php if (isset($_SESSION['user']) && $_SESSION['user']['role'] == 'admin') { ?>
                                    <li>
                                        <div class="dropdown header-top-dropdown">
                                            <a id="adminpanel" href="/admin/dashboard">
                                                Admin Panel
                                                <i class="fa fa-cogs"></i>
                                            </a>
                                        </div>
                                    </li>
                                    <?php } ?>
                                    <li>
                                        <div class="dropdown header-top-dropdown">
                                            <a class="dropdown-toggle" id="myaccount" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                Tài khoản
                                                <i class="fa fa-angle-down"></i>
                                            </a>
                                            <div class="dropdown-menu" aria-labelledby="myaccount">
                                                <?php if (isset($_SESSION['user'])) { ?>
                                                    <a class="dropdown-item" href="/account">Tài khoản</a>
                                                    <a class="dropdown-item" href="/auth/logout">Đăng xuất</a>
                                                <?php } else { ?>
                                                    <a class="dropdown-item" href="/auth/login">Đăng nhập</a>
                                                    <a class="dropdown-item" href="/auth/login">Đăng ký</a>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="dropdown header-top-dropdown">
                                            <a class="dropdown-toggle" id="language" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                Tiếng Việt
                                                <i class="fa fa-angle-down"></i>
                                            </a>
                                            <div class="dropdown-menu" aria-labelledby="language">
                                                <a class="dropdown-item" href="#">Tiếng Việt</a>
                                                <a class="dropdown-item" href="#">English</a>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="dropdown header-top-dropdown">
                                            <a class="dropdown-toggle" id="currency" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                VNĐ
                                                <i class="fa fa-angle-down"></i>
                                            </a>
                                            <div class="dropdown-menu" aria-labelledby="currency">
                                                <a class="dropdown-item" href="#">USD $</a>
                                                <a class="dropdown-item" href="#">EUR €</a>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- header top end -->

        <!-- main menu area start -->
        <div class="header-main sticky hm_5 theme-color-5 pt-sm-10 pb-sm-10 pt-md-10 pb-md-10">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-3 col-md-6 col-6">
                        <div class="logo">
                            <a href="/">
                                <img src="<?php echo $setting['logo']; ?>" alt="Brand logo">
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-6 d-none d-lg-block">
                        <div class="main-header-inner">
                            <div class="main-menu white-text">
                                <nav id="mobile-menu">
                                    <ul>
                                        <li class="active"><a href="/">Trang chủ</a>
                                        </li>
                                        <li><a href="#">Danh mục <i class="fa fa-angle-down"></i></a>
                                            <ul class="dropdown">
                                                <?php if (!empty($categories)): ?>
                                                    <?php foreach ($categories as $category): ?>
                                                        <li><a href="/category/detail/<?= $category['slug'] ?>"><?= $category['name'] ?></a></li>
                                                    <?php endforeach; ?>
                                                <?php else: ?>
                                                    <li><a href="#">Không có danh mục</a></li>
                                                <?php endif; ?>
                                            </ul>
                                        </li>
                                        <li><a href="/promotion">Khuyến mãi</a></li>
                                        <li><a href="/about">Giới thiệu</a></li>
                                        <li><a href="/contact">Liên hệ</a></li>
                                    </ul>
                                </nav>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-6 ms-auto">
                        <div class="header-setting-option setting-style-2 white-text">
                            <div class="search-wrap">
                                <button type="submit" class="search-trigger"><i class="ion-ios-search-strong"></i></button>
                            </div>
                            <div class="header-mini-cart">
                                <div class="mini-cart-btn">
                                    <i class="ion-bag"></i>
                                    <span class="cart-notification">2</span>
                                </div>
                                <ul class="cart-list">
                                    <li>
                                        <div class="cart-img">
                                            <a href="product-details.html"><img src="/assets/img/cart/cart-1.jpg" alt=""></a>
                                        </div>
                                        <div class="cart-info">
                                            <h4><a href="product-details.html">simple product 09</a></h4>
                                            <span>$60.00</span>
                                        </div>
                                        <div class="del-icon">
                                            <i class="fa fa-times"></i>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="cart-img">
                                            <a href="product-details.html"><img src="/assets/img/cart/cart-2.jpg" alt=""></a>
                                        </div>
                                        <div class="cart-info">
                                            <h4><a href="product-details.html">virtual product 10</a></h4>
                                            <span>$50.00</span>
                                        </div>
                                        <div class="del-icon">
                                            <i class="fa fa-times"></i>
                                        </div>
                                    </li>
                                    <li class="mini-cart-price">
                                        <span class="subtotal">subtotal : </span>
                                        <span class="subtotal-price ms-auto">$110.00</span>
                                    </li>
                                    <li class="checkout-btn">
                                        <a href="#">checkout</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 d-block d-lg-none">
                        <div class="mobile-menu header-5"></div>
                    </div>
                </div>
            </div>
        </div>
        <!-- main menu area end -->

        <!-- Start Search Popup -->
        <div class="box-search-content search_active block-bg close__top">
            <form class="minisearch" action="#">
                <div class="field__search">
                    <input type="text" placeholder="Tìm kiếm sản phẩm">
                    <div class="action">
                        <a href="#"><i class="fa fa-search"></i></a>
                    </div>
                </div>
            </form>
            <div class="close__wrap">
                <span>Đóng</span>
            </div>
        </div>
        <!-- End Search Popup -->

    </header>
    <!-- header area end -->