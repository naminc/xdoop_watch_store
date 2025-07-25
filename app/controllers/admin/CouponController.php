<?php

namespace controllers\admin;

use core\BaseController;
use models\Coupon;

class CouponController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
    }
    public function index()
    {
        $couponM = new Coupon();
        $data['coupons'] = $couponM->getAll();
        $this->view('admin/coupon/index', $data);
    }

    public function create()
    {
        $data = [];
        $couponM = new Coupon();
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['create'])) {
            $couponM->setCode($_POST['code']);
            $couponM->setDiscountType($_POST['discount_type']);
            $couponM->setDiscountValue($_POST['discount_value']);
            $couponM->setExpiresAt($_POST['expires_at']);
            $couponM->setUsageLimit($_POST['usage_limit']);
            $couponM->setStatus($_POST['status']);
            if(empty($couponM->getCode()) || empty($couponM->getDiscountType()) || empty($couponM->getDiscountValue()) || empty($couponM->getExpiresAt()) || empty($couponM->getUsageLimit())) {
                $data['error'] = 'Vui lòng nhập đầy đủ thông tin';
                $data['redirect'] = '/admin/coupon/create';
            } else {
                if ($couponM->create()) {
                    $data['success'] = 'Thêm mã giảm giá thành công';
                    $data['redirect'] = '/admin/coupon/index';
                } else {
                    $data['error'] = 'Thêm mã giảm giá thất bại';
                    $data['redirect'] = '/admin/coupon/create';
                }
            }
        }
        $this->view('admin/coupon/create', $data);
    }
    public function edit($id)
    {
        $data = [];
        $couponM = new Coupon(); // khởi tạo model Coupon
        $couponM->setId($id); // set id
        $data['coupon'] = $couponM->getByID(); // lấy mã giảm giá theo id
        if (!$data['coupon']) {
            $data['error'] = 'Mã giảm giá không tồn tại';
            $data['redirect'] = '/admin/coupon/index';
        }
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['edit'])) {
            $couponM->setCode($_POST['code']); // set code
            $couponM->setDiscountType($_POST['discount_type']); // set discount type
            $couponM->setDiscountValue($_POST['discount_value']); // set discount value
            $couponM->setExpiresAt($_POST['expires_at']); // set expires at
            $couponM->setUsageLimit($_POST['usage_limit']); // set usage limit
            $couponM->setStatus($_POST['status']); // set status
            if(empty($couponM->getCode()) || empty($couponM->getDiscountType()) || empty($couponM->getDiscountValue()) || empty($couponM->getExpiresAt()) || empty($couponM->getUsageLimit())) {
                $data['error'] = 'Vui lòng nhập đầy đủ thông tin';
                $data['redirect'] = '/admin/coupon/edit/' . $id;
            } else {
                if ($couponM->update()) {
                    $data['success'] = 'Cập nhật mã giảm giá thành công'; 
                    $data['redirect'] = '/admin/coupon/index'; 
                } else {
                    $data['error'] = 'Cập nhật mã giảm giá thất bại';
                    $data['redirect'] = '/admin/coupon/edit/' . $id;
                }
            }
        }
        $this->view('admin/coupon/edit', $data); // hiển thị view edit
    }
    public function disable($id)
    {
        $data = [];
        $couponM = new Coupon(); // khởi tạo model Coupon
        $couponM->setId($id); // set id
        if ($couponM->disable()) { // tắt mã giảm giá
            $data['success'] = 'Tắt mã giảm giá thành công'; 
            $data['redirect'] = '/admin/coupon/index'; 
        } else {
            $data['error'] = 'Tắt mã giảm giá thất bại';
            $data['redirect'] = '/admin/coupon/index';
        }
        $this->view('admin/coupon/index', $data); // hiển thị view index
    }

    public function enable($id)
    {
        $data = [];
        $couponM = new Coupon(); // khởi tạo model Coupon
        $couponM->setId($id); // set id
        if ($couponM->enable()) { // bật mã giảm giá
            $data['success'] = 'Bật mã giảm giá thành công';
            $data['redirect'] = '/admin/coupon/index';
        } else {
            $data['error'] = 'Bật mã giảm giá thất bại';
            $data['redirect'] = '/admin/coupon/index';
        }
        $this->view('admin/coupon/index', $data); // hiển thị view index
    }
}