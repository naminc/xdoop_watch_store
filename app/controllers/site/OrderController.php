<?php
namespace controllers\site;

use core\BaseController;
use models\Order;
use models\OrderItem;
class OrderController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function detail($id = '')
    {
        $orderM = new Order();
        $orderM->setId($id);
        $order = $orderM->getOrder();
        if (!$order) {
            http_response_code(404);
            echo "404 - Đơn hàng không tồn tại.";
            return;
        }
        $data['order'] = $order;
        $orderItemM = new OrderItem();
        $orderItemM->setOrderId($id);
        $data['orderItems'] = $orderItemM->getOrderItemsByOrderId();
        $data['breadcrumbs'] = 'Chi tiết đơn hàng';
        $this->view('site/order/detail', $data);
    }
}