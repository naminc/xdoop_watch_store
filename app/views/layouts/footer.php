    <!-- footer area start -->
    <footer>

        <!-- newsletter area start -->
        <div class="newsletter-area bg-black pt-64 pb-64 pt-sm-56 pb-sm-58">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 col-md-6">
                        <div class="newsletter-inner white-bg">
                            <div class="newsletter-title">
                                <h3>Đăng ký nhận tin</h3>
                            </div>
                            <div class="newsletter-box">
                                <form id="mc-form">
                                    <input type="email" id="mc-email" autocomplete="off" placeholder="Email của bạn">
                                    <button class="newsletter-btn hm_5" id="mc-submit"><i class="ion-android-send"></i></button>
                                </form>
                            </div>
                        </div>
                        <!-- mailchimp-alerts Start -->
                        <div class="mailchimp-alerts">
                            <div class="mailchimp-submitting"></div><!-- mailchimp-submitting end -->
                            <div class="mailchimp-success"></div><!-- mailchimp-success end -->
                            <div class="mailchimp-error"></div><!-- mailchimp-error end -->
                        </div>
                        <!-- mailchimp-alerts end -->
                    </div>
                    <div class="col-lg-6 col-md-6 ms-auto">
                        <div class="social-share-area white-bg">
                            <h3>Theo dõi</h3>
                            <div class="social-icon">
                                <a href="#"><i class="fa fa-facebook"></i></a>
                                <a href="#"><i class="fa fa-twitter"></i></a>
                                <a href="#"><i class="fa fa-rss"></i></a>
                                <a href="#"><i class="fa fa-youtube"></i></a>
                                <a href="#"><i class="fa fa-instagram"></i></a>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- newsletter area end -->

        <!-- footer widget area start -->
        <div class="footer-widget-area white-bg pt-62 pb-56 pb-md-26 pt-sm-56 pb-sm-20">
            <div class="container">
                <div class="row">
                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <div class="footer-widget">
                            <div class="footer-widget-title">
                                <h3>Giao hàng</h3>
                            </div>
                            <div class="footer-widget-body">
                                <p>Chúng tôi cung cấp dịch vụ giao hàng toàn quốc với đội ngũ nhân viên chuyên nghiệp, đảm bảo sự an toàn và nhanh chóng.</p>
                            </div>
                            <div class="footer-widget-title mt-20">
                                <h3>Phương thức thanh toán</h3>
                            </div>
                            <div class="footer-widget-body">
                                <p>Chúng tôi hiện chỉ chấp nhận phương thức thanh toán bằng tiền mặt sau khi nhận hàng.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-6 col-sm-6">
                        <div class="footer-widget">
                            <div class="footer-widget-title">
                                <h3>Thông tin</h3>
                            </div>
                            <div class="footer-widget-body">
                                <ul class="useful-link">
                                    <li><a href="/about">Giới thiệu</a></li>
                                    <li><a href="/contact">Liên hệ</a></li>
                                    <li><a href="/promotion">Khuyến mãi</a></li>
                                    <li><a href="/">Điều khoản điều kiện</a></li>
                                    <li><a href="/">Trang chủ</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <div class="footer-widget">
                            <div class="footer-widget-title">
                                <h3>Vị trí cửa hàng</h3>
                            </div>
                            <div class="footer-widget-body">
                                  <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3918.800995363982!2d106.71804047469793!3d10.826536089325282!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31752881823d0fd5%3A0xd22e8c05452a8699!2zMzkgxJAuIFPhu5EgMTksIEhp4buHcCBCw6xuaCBDaMOhbmgsIFRo4bunIMSQ4bupYywgSOG7kyBDaMOtIE1pbmgsIFZp4buHdCBOYW0!5e0!3m2!1svi!2s!4v1751804433283!5m2!1svi!2s" width="100%"
                                      height="250"
                                      style="border:0;"
                                      allowfullscreen=""
                                      loading="lazy"
                                      referrerpolicy="no-referrer-when-downgrade">>
                                  </iframe>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-6">
                        <div class="footer-widget">
                            <div class="footer-widget-title">
                                <div class="footer-logo">
                                    <a href="/">
                                        <img src="<?php echo $setting['logo']; ?>" alt="">
                                    </a>
                                </div>
                            </div>
                            <div class="footer-widget-body">
                                <ul class="address-box">
                                    <li>
                                        <span>Địa chỉ:</span>
                                        <p><?php echo $setting['address']; ?></p>
                                    </li>
                                    <li>
                                        <span>Liên hệ:</span>
                                        <p><a href="tel:<?php echo $setting['phone']; ?>"><?php echo $setting['phone']; ?></a></p>
                                    </li>
                                    <li>
                                        <span>Email:</span>
                                        <p><a href="mailto:<?php echo $setting['email']; ?>"><?php echo $setting['email']; ?></a></p>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- footer widget area end -->

        <!-- footer botton area start -->
        <div class="footer-bottom-area">
            <div class="container">
                <div class="bdr-top-2 pt-18 pb-18">
                    <div class="row align-items-center">
                        <div class="col-md-6 order-2 order-md-1">
                            <div class="copyright-text white-bg">
                                <p>2025 © <b><?php echo $setting['domain']; ?></b> Made with <i class="fa fa-heart text-danger"></i> by <a href="https://naminc.dev"><b><?php echo $setting['owner']; ?></b></a></p>
                            </div>
                        </div>
                        <div class="col-md-6 ms-auto order-1 order-md-2">
                            <div class="footer-payment">
                                <img src="/assets/img/payment.png" alt="">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- footer botton area end -->

    </footer>
    <!-- footer area end -->
    <!-- Scroll to top start -->
    <div class="scroll-top not-visible">
        <i class="fa fa-angle-up"></i>
    </div>
    <!-- Scroll to Top End -->

    <!--All jQuery, Third Party Plugins & Activation (main.js) Files-->
    <script src="/assets/js/vendor/modernizr-3.6.0.min.js"></script>
    <!-- Jquery Min Js -->
    <script src="/assets/js/vendor/jquery-3.3.1.min.js"></script>
    <!-- Bootstrap Min Js -->
    <script src="/assets/js/vendor/bootstrap.bundle.min.js"></script>
    <!-- Plugins Js-->
    <script src="/assets/js/plugins.js"></script>
    <!-- Ajax Mail Js -->
    <script src="/assets/js/ajax-mail.js"></script>
    <!-- Active Js -->
    <script src="/assets/js/main.js"></script>

    </body>

    </html>