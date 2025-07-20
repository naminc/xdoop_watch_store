<?php

namespace controllers\site;

use core\BaseController;
use models\Product;
use models\Cart;

class CartController extends BaseController
{
    private $productModel;
    private $cartModel;

    public function __construct()
    {
        parent::__construct();
        $this->productModel = new Product();
        $this->cartModel = new Cart();
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
        $data['cart'] = $this->cartModel->getCart($_SESSION['user']['id']);
        $data['subtotal'] = $this->cartModel->getCartSubtotal($_SESSION['user']['id']);
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
        $product = $this->productModel->getProductById($id);
        if (!$product) {
            $data['error'] = 'Sản phẩm không tồn tại.';
            $data['redirect'] = '/home';
            $this->view('site/home/index', $data);
            return;
        }

        $quantity = $_POST['quantity'] ?? 1;
        $quantity = max(1, intval($quantity));
        $user_id = $_SESSION['user']['id'];

        if ($this->cartModel->addToCart($user_id, $id, $quantity)) {
            $data['success'] = 'Thêm sản phẩm vào giỏ hàng thành công.';
            $data['redirect'] = '/home';
        } else {
            $data['error'] = 'Thêm sản phẩm vào giỏ hàng thất bại.';
            $data['redirect'] = '/home';
        }

        $this->view('site/home/index', $data);
    }
    public function update($id)
    {
        $data = [];
        $data['cart'] = $this->cartModel->getCart($_SESSION['user']['id']);
        $this->view('site/cart/index', $data);
    }
    public function remove($id)
    {
        $data = [];
        if ($this->cartModel->removeFromCart($id)) {
            $data['success'] = 'Xóa sản phẩm khỏi giỏ hàng thành công.';
            $data['redirect'] = '/cart/index';
        } else {
            $data['error'] = 'Xóa sản phẩm khỏi giỏ hàng thất bại.';
            $data['redirect'] = '/cart/index';
        }
        $this->view('site/cart/index', $data);
    }
}   