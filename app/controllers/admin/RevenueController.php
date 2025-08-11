<?php

namespace controllers\admin;

use core\BaseController;
use models\Order;

class RevenueController extends BaseController
{
    public function bydate()
    {
        $data = [
            'breadcrumbs' => 'Xem doanh thu theo ngày',
        ];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $date = $_POST['date'] ?? '';
            $selectedDate = date('Y-m-d', strtotime($date));
            $orderM = new Order();
            $data['revenue'] = $orderM->getRevenueByDate($selectedDate)['revenue'] ?? 0;
            $data['selectedDate'] = $selectedDate;
        }
        $this->view('admin/revenue/bydate', $data);
    }
    public function bymonth()
    {
        $data = [
            'breadcrumbs' => 'Xem doanh thu theo tháng',
        ];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $month = $_POST['month'] ?? '';
            $selectedMonth = date('Y-m', strtotime($month));
            $orderM = new Order();
            $data['revenue'] = $orderM->getRevenueByMonth($selectedMonth)['revenue'] ?? 0;
            $data['selectedMonth'] = $selectedMonth;
        }
        $this->view('admin/revenue/bymonth', $data);
    }
    public function byyear()
    {
        $data = [
            'breadcrumbs' => 'Xem doanh thu theo năm',
        ];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $year = $_POST['year'] ?? '';
            $selectedYear = (int)$year;
            $orderM = new Order();
            $data['revenue'] = $orderM->getRevenueByYear((int)$selectedYear);
            $data['selectedYear'] = $selectedYear;
        }
        $this->view('admin/revenue/byyear', $data);
    }
}
