<?php

namespace controllers\site;

use core\BaseController;
use models\Cart;
use models\Order;
use models\OrderItem;
use models\Product;
use models\Coupon;
use models\CouponUsage;

class CheckoutController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
    }
    public function index()
    {
        $data = [];
        if (empty($_SESSION['user'])) {
            $data['error'] = 'Bạn phải đăng nhập để thanh toán.';
            $data['redirect'] = '/auth/login';
            $this->view('site/home/index', $data);
            return;
        }
        $cartM = new Cart();
        $cartM->setUserId($_SESSION['user']['id']);
        $data['cart'] = $cartM->getCart();
        $data['subtotal'] = $cartM->getCartSubtotal();
        $data['breadcrumbs'] = 'Thanh toán';
        $this->view('site/checkout', $data);
    }

    public function process()
    {
        $data = [];
        if (empty($_SESSION['user'])) {
            $data['error'] = 'Bạn phải đăng nhập để thanh toán.';
            $data['redirect'] = '/auth/login';
            $this->view('site/home/index', $data);
            return;
        }

        $userId = $_SESSION['user']['id'];

        $cartM = new Cart();
        $cartM->setUserId($userId);
        $cartItems = $cartM->getCart();
        if (empty($cartItems)) {
            $data['error'] = 'Giỏ hàng của bạn đang trống.';
            $data['redirect'] = '/cart/index';
            $this->view('site/cart/index', $data);
            return;
        }
        foreach ($cartItems as $item) {
            $productM = new Product();
            $productM->setId($item['product_id']);
            $productM->setName($item['name']);
            if ($productM->checkStock() < $item['quantity']) {
                $data['error'] = 'Số lượng tồn của sản phẩm ' . $productM->getName() . ' không đủ.';
                $data['redirect'] = '/cart/index';
                $this->view('site/cart/index', $data);
                return;
            }
        }
        if (!empty($_SESSION['coupon'])) {
            $couponM = new Coupon();
            $couponM->setCode($_SESSION['coupon']['code']);
            $coupon = $couponM->getByCode();
            if (!$coupon) {
                $data['error'] = 'Mã giảm giá không hợp lệ.';
                unset($_SESSION['coupon']);
                $data['redirect'] = '/cart/index';
                $this->view('site/cart/index', $data);
                return;
            }
            $couponUsageM = new CouponUsage();
            $couponUsageM->setCouponId($coupon['id']);
            $couponUsageM->setUserId($_SESSION['user']['id']);
            if ($couponUsageM->checkUsed()) {
                $data['error'] = 'Bạn đã sử dụng mã giảm giá này trước đó.';
                unset($_SESSION['coupon']);
                $data['redirect'] = '/cart/index';
                $this->view('site/cart/index', $data);
                return;
            }
            if ($coupon['status'] == 0) {
                $data['error'] = 'Mã giảm giá đã bị vô hiệu hóa.';
                unset($_SESSION['coupon']);
                $data['redirect'] = '/cart/index';
                $this->view('site/cart/index', $data);
                return;
            }
            if ($coupon['expires_at'] && strtotime($coupon['expires_at']) < time()) {
                $data['error'] = 'Mã giảm giá đã hết hạn.';
                unset($_SESSION['coupon']);
                $data['redirect'] = '/cart/index';
                $this->view('site/cart/index', $data);
                return;
            }
            if ($coupon['usage_limit'] && $coupon['used_count'] >= $coupon['usage_limit']) {
                $data['error'] = 'Mã giảm giá đã được sử dụng hết.';
                unset($_SESSION['coupon']);
                $data['redirect'] = '/cart/index';
                $this->view('site/cart/index', $data);
                return;
            }
            if ($_SESSION['coupon']['discount_type'] == 'percentage') {
                $discount = $cartM->getCartSubtotal() * $_SESSION['coupon']['discount_value'] / 100;
            } else {
                $discount = $_SESSION['coupon']['discount_value'];
            }
        } else {
            $discount = 0;
        }
        $total = $cartM->getCartSubtotal() - $discount;
        $orderM = new Order();
        $orderM->setUserId($userId);
        $orderM->setFullname($_POST['fullname']);
        $orderM->setPhone($_POST['phone']);
        $orderM->setEmail($_POST['email']);
        $orderM->setAddress($_POST['address']);
        $orderM->setDistrict($_POST['district']);
        $orderM->setCity($_POST['city']);
        $orderM->setPostcode($_POST['postcode']);
        $orderM->setNote($_POST['note']);
        $orderM->setPaymentMethod($_POST['paymentmethod']);
        $orderM->setTotal($total);
        $orderId = $orderM->createOrder();

        foreach ($cartItems as $item) {
            $productM = new Product();
            $productM->setId($item['product_id']);
            $productM->setStock($productM->checkStock() - $item['quantity']);
            $productM->updateStock();
        }

        foreach ($cartItems as $item) {
            $orderItemM = new OrderItem();
            $orderItemM->setOrderId($orderId);
            $orderItemM->setProductId($item['product_id']);
            $orderItemM->setQuantity($item['quantity']);
            $orderItemM->setPrice($item['price']);
            $orderItemM->addOrderItem();
        }
        if (!empty($_SESSION['coupon'])) {
            $couponM = new Coupon();
            $couponM->setCode($_SESSION['coupon']['code']);
            $couponM->incrementUsage();
            $couponUsageM = new CouponUsage();
            $couponUsageM->setCouponId($_SESSION['coupon']['id']);
            $couponUsageM->setUserId($userId);
            $couponUsageM->setOrderId($orderId);
            $couponUsageM->create();
        }
        $cartM->clearCart();
        if (!empty($_SESSION['coupon'])) {
            unset($_SESSION['coupon']);
        }
        $data['success'] = 'Đặt hàng thành công!';
        $data['redirect'] = '/home';
        $this->view('site/home/index', $data);
    }
}