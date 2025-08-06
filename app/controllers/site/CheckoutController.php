<?php

namespace controllers\site;

use core\BaseController;
use models\Cart;
use models\Order;
use models\OrderItem;
use models\Product;
use models\Coupon;
use models\CouponUsage;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once __DIR__ . '/../../../vendor/autoload.php';

class CheckoutController extends BaseController
{
    private $config;
    public function __construct()
    {
        parent::__construct();
        $configPath = __DIR__ . '/../../config/config.php';
        if (!file_exists($configPath)) {
            die('File config.php không tồn tại.');
        }
        $this->config = require $configPath;
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

        $mail = new PHPMailer(true);
        $mail->CharSet = 'UTF-8';
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        try {
            $mail->isSMTP();
            $mail->Host       = $this->config['smtp']['host'];
            $mail->SMTPAuth   = true;
            $mail->Username   = $this->config['smtp']['username'];
            $mail->Password   = $this->config['smtp']['password'];
            $mail->SMTPSecure = $this->config['smtp']['encryption'];
            $mail->Port       = $this->config['smtp']['port'];

            $mail->setFrom($this->config['smtp']['from_email'], $this->config['smtp']['from_name']);
            $mail->addAddress($_POST['email'], $_POST['fullname']);

            $mail->isHTML(true);
            $mail->Subject = mb_encode_mimeheader('Xác nhận đơn hàng #' . $orderId, 'UTF-8', 'B');

            $itemsHtml = '';
            foreach ($cartItems as $item) {
                $itemsHtml .= "
        <tr>
            <td style='padding: 8px; border: 1px solid #ddd;'>{$item['name']}</td>
            <td style='padding: 8px; border: 1px solid #ddd;'>{$item['quantity']}</td>
            <td style='padding: 8px; border: 1px solid #ddd;'>" . number_format($item['price'], 0, ',', '.') . "đ</td>
        </tr>
    ";
            }

            $mail->Body = "
<div style='font-family: Arial, sans-serif; color: #333;'>
    <h2 style='color: #2c3e50;'>Cảm ơn bạn đã đặt hàng tại Xdoop!</h2>
    <p>Xin chào <strong>{$orderM->getFullname()}</strong>,</p>
    <p>Chúng tôi đã nhận được đơn hàng của bạn. Dưới đây là chi tiết đơn hàng:</p>

    <h3 style='color: #2c3e50;'>Thông tin đơn hàng</h3>
    <p><strong>Mã đơn hàng:</strong> #{$orderId}</p>
    <p><strong>Ngày đặt:</strong> " . date('d/m/Y H:i') . "</p>
    <p><strong>Phương thức thanh toán:</strong> Thanh toán khi nhận hàng</p>

    <h3 style='color: #2c3e50;'>Thông tin người nhận</h3>
    <p><strong>Họ tên:</strong> {$orderM->getFullname()}</p>
    <p><strong>SĐT:</strong> {$orderM->getPhone()}</p>
    <p><strong>Email:</strong> {$orderM->getEmail()}</p>
    <p><strong>Địa chỉ:</strong> {$orderM->getAddress()}, {$orderM->getDistrict()}, {$orderM->getCity()} - {$orderM->getPostcode()}</p>

    <h3 style='color: #2c3e50;'>Sản phẩm đã đặt</h3>
    <table style='border-collapse: collapse; width: 100%; margin-top: 10px;'>
        <thead>
            <tr>
                <th style='padding: 8px; border: 1px solid #ddd; background-color: #f7f7f7;'>Tên sản phẩm</th>
                <th style='padding: 8px; border: 1px solid #ddd; background-color: #f7f7f7;'>Số lượng</th>
                <th style='padding: 8px; border: 1px solid #ddd; background-color: #f7f7f7;'>Giá</th>
            </tr>
        </thead>
        <tbody>
            $itemsHtml
        </tbody>
    </table>

    <p style='margin-top: 10px;'><strong>Giảm giá:</strong> " . number_format($discount, 0, ',', '.') . "đ</p>
    <p><strong>Tổng tiền:</strong> <span style='color: #e74c3c; font-size: 18px;'>" . number_format($total, 0, ',', '.') . " VNĐ</span></p>

    <p>Chúng tôi sẽ liên hệ với bạn để xác nhận đơn hàng và tiến hành giao hàng sớm nhất.</p>
    <p>Trân trọng,<br><strong>Xdoop Team</strong></p>
</div>";

            $mail->send();
        } catch (Exception $e) {
            error_log("Email không gửi được. Lỗi: {$mail->ErrorInfo}");
        }

        $data['success'] = 'Đặt hàng thành công!';
        $data['redirect'] = '/home';
        $this->view('site/home/index', $data);
    }
}
