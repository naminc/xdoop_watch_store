<?php

namespace controllers\site;

use core\BaseController;
use models\Product;
use models\Cart;

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

        $cartM = new Cart();
        $cartM->setUserId($_SESSION['user']['id']);
        $cartM->setProductId($productM->getId());
        $cartM->setQuantity(max(1, intval($_POST['quantity'] ?? 1)));

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
}   