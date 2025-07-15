<?php

namespace controllers\admin;

use core\BaseController;
use models\Category;

class CategoryController extends BaseController
{
    private $categoryModel;
    public function __construct()
    {
        parent::__construct();
        $this->categoryModel = new Category();
    }
    public function index()
    {
        $data['categories'] = $this->categoryModel->getAll();
        $this->view('admin/category/index', $data);
    }

    public function create()
    {
        $data = [];
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['create'])) {
            $name = $_POST['name'];
            $description = $_POST['description'];
            $status = $_POST['status'];
            $slug = $this->generateSlug($name);
            $result = $this->categoryModel->create($name, $slug, $description, $status);
            if ($result) {
                $data['success'] = 'Thêm danh mục thành công';
                $data['redirect'] = '/admin/category/index';
            } else {
                $data['error'] = 'Thêm danh mục thất bại';
                $data['redirect'] = '/admin/category/create';
            }
        }
        $this->view('admin/category/create', $data);
    }
    public function edit($id)
    {
        $data = [];
        $data['dcategory'] = $this->categoryModel->getByID($id);
        if (!$data['dcategory']) {
            $data['error'] = 'Danh mục không tồn tại';
            $data['redirect'] = '/admin/category/index';
        }
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['edit'])) {
            $name = $_POST['name'];
            $description = $_POST['description'];
            $status = $_POST['status'];
            $slug = $this->generateSlug($name);
            $result = $this->categoryModel->update($id, $name, $slug, $description, $status);
            if ($result) {
                $data['success'] = 'Cập nhật danh mục thành công';
                $data['redirect'] = '/admin/category/index';
            } else {
                $data['error'] = 'Cập nhật danh mục thất bại';
                $data['redirect'] = '/admin/category/edit/' . $id;
            }
        }
        $this->view('admin/category/edit', $data);
    }
    public function delete($id)
    {
        $result = $this->categoryModel->delete($id);
        if ($result) {
            $data['success'] = 'Xóa danh mục thành công';
            $data['redirect'] = '/admin/category/index';
        } else {
            $data['error'] = 'Xóa danh mục thất bại';
            $data['redirect'] = '/admin/category/index';
        }
        $this->view('admin/category/index', $data);
    }

    private function generateSlug($string)
    {
        $string = $this->stripVietnamese($string);
        $slug = strtolower($string);
        $slug = preg_replace('/[^a-z0-9\s-]/', '', $slug);
        $slug = preg_replace('/[\s-]+/', ' ', $slug);
        $slug = trim($slug);
        $slug = str_replace(' ', '-', $slug);
        return $slug;
    }
    
    private function stripVietnamese($str)
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
