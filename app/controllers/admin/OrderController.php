<?php
namespace controllers\admin;

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
    public function index()
    {
        $data['orders'] = $this->orderModel->getAll();
        $this->view('admin/order/index', $data);
    }
}