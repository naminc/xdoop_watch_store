<?php

namespace controllers\site;

use core\BaseController;
use models\Cart;
use models\Order;
use models\OrderItem;
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
        $total = $cartM->getCartSubtotal();
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
            $orderItemM = new OrderItem();
            $orderItemM->setOrderId($orderId);
            $orderItemM->setProductId($item['product_id']);
            $orderItemM->setQuantity($item['quantity']);
            $orderItemM->setPrice($item['price']);
            $orderItemM->addOrderItem();
        }
        $cartM->clearCart();
        $data['success'] = 'Đặt hàng thành công!';
        $data['redirect'] = '/home';
        $this->view('site/home/index', $data);
    }
}