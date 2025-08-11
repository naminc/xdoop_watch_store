<?php
namespace controllers\admin;

use core\BaseController;
use models\Order;
use models\OrderItem;
use models\Product;
class OrderController extends BaseController
{
    public function __construct()
    {
        parent::__construct(); // gọi constructor của BaseController
    }
    public function index()
    {
        $orderM = new Order(); // khởi tạo model Order
        $data['orders'] = $orderM->getAll(); // lấy tất cả đơn hàng
        $data['totalOrders'] = $orderM->countAll(); // lấy tổng số đơn hàng
        $data['totalOrdersPending'] = $orderM->countAllPending(); // lấy tổng số đơn hàng chờ xử lý
        $data['totalOrdersProcessing'] = $orderM->countAllProcessing(); // lấy tổng số đơn hàng đang xử lý
        $data['totalOrdersCompleted'] = $orderM->countAllCompleted(); // lấy tổng số đơn hàng đã hoàn thành
        $data['totalOrdersCancelled'] = $orderM->countAllCancelled(); // lấy tổng số đơn hàng đã hủy
        $data['totalOrdersShipping'] = $orderM->countAllShipping(); // lấy tổng số đơn hàng đang giao
        $data['breadcrumbs'] = 'Quản lý đơn hàng'; // lấy breadcrumbs
        $this->view('admin/order/index', $data); // hiển thị view index
    }

    public function edit($id = '')
    {
        $orderM = new Order(); // khởi tạo model Order
        $orderM->setId($id); // set id
        $order = $orderM->getOrder(); // lấy đơn hàng theo id
        if (!$order) {
            http_response_code(404); // trả về mã lỗi 404
            echo "404 - Đơn hàng không tồn tại."; // hiển thị thông báo lỗi
            return;
        }
        $data['order'] = $order; // lấy đơn hàng
        $orderItemM = new OrderItem(); // khởi tạo model OrderItem
        $orderItemM->setOrderId($order['id']); // set id
        $data['orderItems'] = $orderItemM->getOrderItemsByOrderId(); // lấy đơn hàng theo id

        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update'])) {
            $orderM->setStatus($_POST['status']); // set status
            if($orderM->getStatus() == 'cancelled') {
                foreach ($data['orderItems'] as $item) {
                    $productM = new Product(); // khởi tạo model Product
                    $productM->setId($item['product_id']); // set id
                    $productM->setStock($productM->checkStock() + $item['quantity']); // set quantity
                    $productM->updateStock(); // cập nhật sản phẩm
                }
            }
            if ($orderM->updateStatus()) { // cập nhật trạng thái đơn hàng
                $data['success'] = 'Cập nhật trạng thái đơn hàng thành công';
                $data['redirect'] = '/admin/order/edit/' . $id; 
            } else {
                $data['error'] = 'Cập nhật trạng thái đơn hàng thất bại';
                $data['redirect'] = '/admin/order/edit/' . $id;
            }
        }
        $this->view('admin/order/edit', $data); // hiển thị view edit
    }

}