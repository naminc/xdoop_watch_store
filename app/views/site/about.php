<?php require_once __DIR__ . '/../layouts/header.php'; ?>
<div class="breadcrumb-area">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="breadcrumb-wrap">
                        <nav aria-label="breadcrumb">
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="/">Trang chủ</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Giới thiệu</li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <main>
        <div class="about-us-wrapper pt-98 pb-100 pt-sm-58 pb-sm-58">
            <div class="container">
                <div class="row">
                    <div class="col-xl-6 col-lg-6">
                        <div class="about-text-wrap">
                            <h2><span>Cung cấp</span>Sản phẩm tốt nhất cho bạn</h2>
                            <p>Chúng tôi cung cấp sản phẩm tốt nhất cho bạn. Chúng tôi là cửa hàng tốt nhất trên thế giới.</p>
                            <p>Một số khách hàng của chúng tôi nói rằng họ tin tưởng chúng tôi và mua sản phẩm của chúng tôi mà không có bất kỳ sự ngại ngùng nào vì họ tin tưởng chúng tôi và luôn hài lòng khi mua sản phẩm của chúng tôi.</p>
                            <p>Chúng tôi cung cấp sản phẩm tốt nhất cho bạn. Chúng tôi là cửa hàng tốt nhất trên thế giới.</p>
                        </div>
                    </div>
                    <div class="col-xl-5 col-lg-6 ms-auto">
                        <div class="about-image-wrap">
                            <img src="https://atlanticwatches.ch/wp-content/uploads/2022/09/Atlantic-Watches-For-Him.jpg" alt="About" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="team-area bg-gray pt-100 pb-58 pt-sm-56 pb-sm-16">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="section-title text-center pb-44">
                            <p>Đội ngũ nhân viên</p>
                            <h2>Đội ngũ nhân viên</h2>
                        </div>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-lg-5 col-md-6 col-sm-6">
                        <div class="team-member mb-30">
                            <div class="team-thumb img-full">
                                <img src="https://naminc.dev/pro5.jpg" style="width: 190px !important; height: 190px !important; object-fit: cover;" class="" alt="">
                                <div class="team-social">
                                    <a href="#"><i class="fa fa-facebook"></i></a>
                                    <a href="#"><i class="fa fa-twitter"></i></a>
                                    <a href="#"><i class="fa fa-linkedin"></i></a>
                                    <a href="#"><i class="fa fa-google-plus"></i></a>
                                </div>
                            </div>
                            <div class="team-content text-center">
                                <h3>Ngo Dinh Nam</h3>
                                <h6>Developer</h6>
                                <p>Tôi là một lập trình viên và tôi làm việc tại <?= $setting['brand']; ?> store.</p>
                            </div>
                        </div>
                    </div> <!-- end single team member -->
                </div>
            </div>
        </div>
        <div class="choosing-area pt-100 pb-92 pb-md-62 pt-sm-58 pb-sm-20">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="section-title text-center pb-44">
                            <p>Dịch vụ chính</p>
                            <h2>Tại sao chọn chúng tôi</h2>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4">
                        <div class="single-choose-item text-center mb-md-30 mb-sm-30">
                            <i class="fa fa-globe"></i>
                            <h4>Miễn phí vận chuyển</h4>
                            <p>Chúng tôi cung cấp dịch vụ vận chuyển miễn phí cho khách hàng.</p>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="single-choose-item text-center mb-md-30 mb-sm-30">
                            <i class="fa fa-plane"></i>
                            <h4>Giao hàng nhanh</h4>
                            <p>Chúng tôi cung cấp dịch vụ giao hàng nhanh cho khách hàng.</p>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="single-choose-item text-center mb-md-30 mb-sm-30">
                            <i class="fa fa-comments"></i>
                            <h4>Hỗ trợ khách hàng</h4>
                            <p>Chúng tôi cung cấp dịch vụ hỗ trợ khách hàng cho khách hàng.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
<?php require_once __DIR__ . '/../layouts/footer.php'; ?>