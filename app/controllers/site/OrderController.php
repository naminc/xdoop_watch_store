<?php
namespace controllers\site;

use core\BaseController;
use models\Order;

class OrderController extends BaseController
{
    private $orderModel;

    public function __construct()
    {
        parent::__construct();
        $this->orderModel = new Order();
    }

    public function detail($id = '')
    {
        $order = $this->orderModel->getOrder($id);
        if (!$order) {
            http_response_code(404);
            echo "404 - Đơn hàng không tồn tại.";
            return;
        }
        $data['order'] = $order;
        $data['orderItems'] = $this->orderModel->getOrderItems($id);
        $data['breadcrumbs'] = 'Chi tiết đơn hàng';
        $this->view('site/order/detail', $data);
    }
}