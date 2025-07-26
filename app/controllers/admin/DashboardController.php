<?php
namespace controllers\admin;

use core\BaseController;
use models\Order;
use models\User;
use models\Product;
use models\Category;

class DashboardController extends BaseController
{
    private $orderModel;
    private $userModel;
    private $productModel;
    private $categoryModel;

    public function __construct()
    {
        parent::__construct(); // gọi constructor của BaseController
        $this->orderModel = new Order(); // khởi tạo model Order
        $this->userModel = new User(); // khởi tạo model User
        $this->productModel = new Product(); // khởi tạo model Product
        $this->categoryModel = new Category(); // khởi tạo model Category
    }
    public function index()
    {
        $data = [
            'totalOrders' => $this->orderModel->countAll(), // lấy tổng số đơn hàng
            'totalUsers' => $this->userModel->countAll(), // lấy tổng số người dùng
            'totalProducts' => $this->productModel->countAll(), // lấy tổng số sản phẩm
            'totalCategories' => $this->categoryModel->countAll(), // lấy tổng số danh mục
            'totalOrdersPending' => $this->orderModel->countAllPending(), // lấy tổng số đơn hàng chờ xử lý
            'totalOrdersProcessing' => $this->orderModel->countAllProcessing(), // lấy tổng số đơn hàng đang xử lý
            'totalOrdersCompleted' => $this->orderModel->countAllCompleted(), // lấy tổng số đơn hàng đã hoàn thành
            'totalOrdersCancelled' => $this->orderModel->countAllCancelled(), // lấy tổng số đơn hàng đã hủy
            'totalOrdersShipping' => $this->orderModel->countAllShipping(), // lấy tổng số đơn hàng đang giao
            'totalRevenueDay' => $this->orderModel->getTotalRevenueDay(), // lấy tổng số doanh thu theo ngày
            'totalRevenueMonth' => $this->orderModel->getTotalRevenueMonth(), // lấy tổng số doanh thu theo tháng
            'totalRevenueYear' => $this->orderModel->getTotalRevenueYear(), // lấy tổng số doanh thu theo năm
            'totalRevenueAll' => $this->orderModel->getTotalRevenueAll(), // lấy tổng số doanh thu
            'bestSelling' => $this->productModel->getBestSellingProducts(), // lấy sản phẩm bán chạy
            'leastSelling' => $this->productModel->getLeastSellingProducts(), // lấy sản phẩm bán ít
            'neverSold' => $this->productModel->getNeverSoldProducts(), // lấy sản phẩm chưa bán được lần nào
        ];
        $data['breadcrumbs'] = 'Bảng điều khiển'; // lấy breadcrumbs
        $this->view('admin/dashboard', $data); // hiển thị view dashboard
    }
}
