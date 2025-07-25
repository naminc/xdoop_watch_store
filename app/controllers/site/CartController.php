<?php

namespace controllers\site;

use core\BaseController;
use models\Product;
use models\Cart;
use models\Coupon;
use models\CouponUsage;

class CartController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
    }
    public function index()
    {
        $data = [];
        if (empty($_SESSION['user'])) {
            $data['error'] = 'Bạn phải đăng nhập để xem giỏ hàng.';
            $data['redirect'] = '/auth/login';
            $this->view('site/home/index', $data);
            return;
        }
        $cartM = new Cart();
        $cartM->setUserId($_SESSION['user']['id']);
        $data['cart'] = $cartM->getCart();
        $data['subtotal'] = $cartM->getCartSubtotal();
        $data['breadcrumbs'] = 'Giỏ hàng';
        $this->view('site/cart/index', $data);
    }
    public function add($id)
    {
        $data = [];
        if (empty($_SESSION['user'])) {
            $data['error'] = 'Bạn phải đăng nhập để thêm sản phẩm vào giỏ hàng.';
            $data['redirect'] = '/auth/login';
            $this->view('site/home/index', $data);
            return;
        }
        $productM = new Product();
        $productM->setId($id);
        $product = $productM->getProductById();
        if (!$product) {
            $data['error'] = 'Sản phẩm không tồn tại.';
            $data['redirect'] = '/home';
            $this->view('site/home/index', $data);
            return;
        }
        if ($productM->checkStock() <= 0) {
            $data['error'] = 'Sản phẩm đã hết hàng.';
            $data['redirect'] = '/home';
            $this->view('site/home/index', $data);
            return;
        }
        $cartM = new Cart();
        $cartM->setUserId($_SESSION['user']['id']);
        $cartM->setProductId($productM->getId());
        $cartM->setQuantity(max(1, intval($_POST['quantity'] ?? 1)));

        if ($productM->checkStock() < $cartM->getQuantity()) {
            $data['error'] = 'Vượt quá số lượng tồn của sản phẩm.';
            $data['redirect'] = '/home';
            $this->view('site/home/index', $data);
            return;
        }
        if ($cartM->addToCart()) {
            $data['success'] = 'Thêm sản phẩm vào giỏ hàng thành công.';
            $data['redirect'] = '/home';
        } else {
            $data['error'] = 'Thêm sản phẩm vào giỏ hàng thất bại.';
            $data['redirect'] = '/home';
        }

        $this->view('site/home/index', $data);
    }
    public function remove($id)
    {
        $data = [];
        $cartM = new Cart();
        $cartM->setId($id);
        if ($cartM->removeFromCart()) {
            $data['success'] = 'Xóa sản phẩm khỏi giỏ hàng thành công.';
            $data['redirect'] = '/cart/index';
        } else {
            $data['error'] = 'Xóa sản phẩm khỏi giỏ hàng thất bại.';
            $data['redirect'] = '/cart/index';
        }
        $this->view('site/cart/index', $data);
    }

    public function applycoupon()
    {
        $data = [];
        if (empty($_SESSION['user'])) {
            $data['error'] = 'Bạn phải đăng nhập để sử dụng mã giảm giá.';
            $data['redirect'] = '/auth/login';
            $this->view('site/cart/index', $data);
            return;
        }
        $cartM = new Cart();
        $cartM->setUserId($_SESSION['user']['id']);
        $cartItems = $cartM->getCart();
        if (empty($cartItems)) {
            $data['error'] = 'Giỏ hàng trống không thể áp dụng mã giảm giá.';
            $this->view('site/cart/index', $data);
            return;
        }
        $code = trim($_POST['coupon'] ?? '');
        if (empty($code)) {
            $data['error'] = 'Vui lòng nhập mã giảm giá.';
            $this->view('site/cart/index', $data);
            return;
        }
        $couponM = new Coupon();
        $couponM->setCode($code);
        $coupon = $couponM->getByCode();
        if (!$coupon) {
            $data['error'] = 'Mã giảm giá không hợp lệ.';
            unset($_SESSION['coupon']);
            $this->view('site/cart/index', $data);
            return;
        }
        $couponUsageM = new CouponUsage();
        $couponUsageM->setCouponId($coupon['id']);
        $couponUsageM->setUserId($_SESSION['user']['id']);
        if ($couponUsageM->checkUsed()) {
            $data['error'] = 'Bạn đã sử dụng mã giảm giá này trước đó.';
            unset($_SESSION['coupon']);
            $this->view('site/cart/index', $data);
            return;
        }
        if ($coupon['status'] == 0) {
            $data['error'] = 'Mã giảm giá đã bị vô hiệu hóa.';
            unset($_SESSION['coupon']);
            $this->view('site/cart/index', $data);
            return;
        }
        $cartM = new Cart();
        $cartM->setUserId($_SESSION['user']['id']);
        if ($coupon['expires_at'] && strtotime($coupon['expires_at']) < time()) {
            $data['error'] = 'Mã giảm giá đã hết hạn.';
            unset($_SESSION['coupon']);
            $this->view('site/cart/index', $data);
            return;
        }
        if ($coupon['usage_limit'] && $coupon['used_count'] >= $coupon['usage_limit']) {
            $data['error'] = 'Mã giảm giá đã được sử dụng hết.';
            unset($_SESSION['coupon']);
            $this->view('site/cart/index', $data);
            return;
        }
        $_SESSION['coupon'] = $coupon;
        $data['success'] = 'Áp dụng mã giảm giá thành công!';
        $data['redirect'] = '/cart/index';
        $data['cart'] = $cartM->getCart();
        $data['subtotal'] = $cartM->getCartSubtotal();
        $this->view('site/cart/index', $data);
    }
}
