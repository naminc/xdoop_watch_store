<?php

namespace controllers\admin;

use core\BaseController;
use models\Category;

class CategoryController extends BaseController
{
    public function __construct()
    {
        parent::__construct(); // gọi constructor của BaseController
    }
    public function index()
    {
        $categoryM = new Category(); // khởi tạo model Category
        $data['categories'] = $categoryM->getAll(); // lấy tất cả danh mục
        $this->view('admin/category/index', $data); // hiển thị view index
    }

    public function create()
    {
        $data = [];
        $categoryM = new Category(); // khởi tạo model Category
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['create'])) {
            $categoryM->setName($_POST['name']); // set name
            $categoryM->setDescription($_POST['description']); // set description
            $categoryM->setStatus($_POST['status']); // set status
            $categoryM->setSlug($this->generateSlug($categoryM->getName())); // tạo slug
            if ($categoryM->create()) {
                $data['success'] = 'Thêm danh mục thành công';
                $data['redirect'] = '/admin/category/index';
            } else {
                $data['error'] = 'Thêm danh mục thất bại';
                $data['redirect'] = '/admin/category/create';
            }
        }
        $this->view('admin/category/create', $data); // hiển thị view create
    }
    public function edit($id)
    {
        $data = [];
        $categoryM = new Category(); // khởi tạo model Category
        $categoryM->setId($id); // set id
        $data['dcategory'] = $categoryM->getByID(); // lấy danh mục theo id
        if (!$data['dcategory']) {
            $data['error'] = 'Danh mục không tồn tại';
            $data['redirect'] = '/admin/category/index';
        }
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['edit'])) {
            $categoryM->setName($_POST['name']); // set name
            $categoryM->setDescription($_POST['description']); // set description
            $categoryM->setStatus($_POST['status']); // set status
            $categoryM->setSlug($this->generateSlug($categoryM->getName())); // tạo slug
            if ($categoryM->update()) { // cập nhật danh mục
                $data['success'] = 'Cập nhật danh mục thành công'; 
                $data['redirect'] = '/admin/category/index'; 
            } else {
                $data['error'] = 'Cập nhật danh mục thất bại';
                $data['redirect'] = '/admin/category/edit/' . $id;
            }
        }
        $this->view('admin/category/edit', $data); // hiển thị view edit
    }
    public function delete($id)
    {
        $data = [];
        $categoryM = new Category(); // khởi tạo model Category
        $categoryM->setId($id); // set id
        if ($categoryM->delete()) { // xóa danh mục
            $data['success'] = 'Xóa danh mục thành công'; 
            $data['redirect'] = '/admin/category/index'; 
        } else {
            $data['error'] = 'Xóa danh mục thất bại';
            $data['redirect'] = '/admin/category/index';
        }
        $this->view('admin/category/index', $data); // hiển thị view index
    }

    private function generateSlug($string) // tạo slug
    {
        $string = $this->stripVietnamese($string);
        $slug = strtolower($string);
        $slug = preg_replace('/[^a-z0-9\s-]/', '', $slug);
        $slug = preg_replace('/[\s-]+/', ' ', $slug);
        $slug = trim($slug);
        $slug = str_replace(' ', '-', $slug);
        return $slug;
    }
    
    private function stripVietnamese($str) // xóa dấu tiếng việt
    {
        $accents = [
            'a' => 'áàạảãâấầậẩẫăắằặẳẵ',
            'e' => 'éèẹẻẽêếềệểễ',
            'i' => 'íìịỉĩ',
            'o' => 'óòọỏõôốồộổỗơớờợởỡ',
            'u' => 'úùụủũưứừựửữ',
            'y' => 'ýỳỵỷỹ',
            'd' => 'đ'
        ];
        foreach ($accents as $nonAccent => $accentGroup) {
            $str = preg_replace("/[" . $accentGroup . "]/u", $nonAccent, $str);
        }
        $str = preg_replace("/[ÁÀẠẢÃÂẤẦẬẨẪĂẮẰẶẲẴ]/u", 'A', $str);
        $str = preg_replace("/[ÉÈẸẺẼÊẾỀỆỂỄ]/u", 'E', $str);
        $str = preg_replace("/[ÍÌỊỈĨ]/u", 'I', $str);
        $str = preg_replace("/[ÓÒỌỎÕÔỐỒỘỔỖƠỚỜỢỞỠ]/u", 'O', $str);
        $str = preg_replace("/[ÚÙỤỦŨƯỨỪỰỬỮ]/u", 'U', $str);
        $str = preg_replace("/[ÝỲỴỶỸ]/u", 'Y', $str);
        $str = preg_replace("/Đ/u", 'D', $str);
        return $str;
    }
}
