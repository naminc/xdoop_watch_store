<?php

namespace controllers\site;

use core\BaseController;
use models\Cart;
use models\Order;
class CheckoutController extends BaseController
{
    private $cartModel;
    private $orderModel;
    public function __construct()
    {
        parent::__construct();
        $this->cartModel = new Cart();
        $this->orderModel = new Order();
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
        $data['cart'] = $this->cartModel->getCart($_SESSION['user']['id']);
        $data['subtotal'] = $this->cartModel->getCartSubtotal($_SESSION['user']['id']);

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

        $fullname = $_POST['fullname'] ?? '';
        $phone = $_POST['phone'] ?? '';
        $email = $_POST['email'] ?? '';
        $address = $_POST['address'] ?? '';
        $district = $_POST['district'] ?? '';
        $city = $_POST['city'] ?? '';
        $postcode = $_POST['postcode'] ?? '';
        $note = $_POST['note'] ?? '';
        $paymentMethod = $_POST['paymentmethod'] ?? 'cash';
        $cartItems = $this->cartModel->getCart($userId);

        if (empty($cartItems)) {
            $data['error'] = 'Giỏ hàng của bạn đang trống.';
            $data['redirect'] = '/cart/index';
            $this->view('site/cart/index', $data);
            return;
        }
        $total = $this->cartModel->getCartSubtotal($userId);
        $orderId = $this->orderModel->createOrder([
            'user_id' => $userId,
            'fullname' => $fullname,
            'phone' => $phone,
            'email' => $email,
            'address' => $address,
            'district' => $district,
            'city' => $city,
            'postcode' => $postcode,
            'note' => $note,
            'payment_method' => $paymentMethod,
            'total' => $total
        ]);

        foreach ($cartItems as $item) {
            $this->orderModel->addOrderItem([
                'order_id' => $orderId,
                'product_id' => $item['product_id'],
                'quantity' => $item['quantity'],
                'price' => $item['price']
            ]);
        }
        $this->cartModel->clearCart($userId);
        $data['success'] = 'Đặt hàng thành công!';
        $data['redirect'] = '/home';
        $this->view('site/home/index', $data);
    }
}