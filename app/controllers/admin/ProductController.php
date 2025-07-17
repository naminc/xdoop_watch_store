<?php

namespace controllers\admin;

use core\BaseController;
use models\Category;
use models\Product;

class ProductController extends BaseController
{
    private $categoryModel;
    private $productModel;
    public function __construct()
    {
        parent::__construct();
        $this->categoryModel = new Category();
        $this->productModel = new Product();
    }
    public function index()
    {
        $data['products'] = $this->productModel->getAll();
        $this->view('admin/product/index', $data);
    }
    public function create()
    {
        $data = [];
        $data['list_category'] = $this->categoryModel->getAll();
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['create'])) {
            $name = $_POST['name'];
            $description = $_POST['description'];
            $price = $_POST['price'];
            $category_id = $_POST['category_id'];
            $status = $_POST['status'];
            $image = $_FILES['image'];
            $slug = $this->generateSlug($name);
            if (empty($name) || empty($description) || empty($price) || empty($category_id) || $status === "" || $image['error'] != 0) {
                $data['error'] = 'Vui lòng điền đầy đủ thông tin và chọn ảnh hợp lệ';
                $data['redirect'] = '/admin/product/create';
                $this->view('admin/product/create', $data);
                return;
            }
            if ($this->productModel->checkSlug($slug) > 0) {
                $data['error'] = 'Slug đã tồn tại';
                $data['redirect'] = '/admin/product/create';
                $this->view('admin/product/create', $data);
                return;
            }
            $uploadDir = __DIR__ . '/../../../public/uploads/products/';
            $uploadResult = $this->uploadImage($image, $uploadDir);
            if (!empty($uploadResult['error'])) {
                $data['error'] = $uploadResult['error'];
                $data['redirect'] = '/admin/product/create';
                $this->view('admin/product/create', $data);
                return;
            }
            $filename = $uploadResult['filename'];
            $result = $this->productModel->create(
                $name,
                $description,
                $filename,
                $price,
                $category_id,
                $status,
                $slug
            );
            if ($result) {
                $data['success'] = 'Thêm sản phẩm thành công';
                $data['redirect'] = '/admin/product/index';
            } else {
                $data['error'] = 'Thêm sản phẩm thất bại';
                $data['redirect'] = '/admin/product/create';
            }
            $this->view('admin/product/create', $data);
            return;
        }
        $this->view('admin/product/create', $data);
    }
    public function edit($id)
    {
        $data['dproduct'] = $this->productModel->getProductById($id);
        $data['list_category'] = $this->categoryModel->getAll();

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit'])) {
            $name = $_POST['name'];
            $description = $_POST['description'];
            $price = $_POST['price'];
            $category_id = $_POST['category_id'];
            $status = $_POST['status'];
            $image = $_FILES['image'];
            $slug = $this->generateSlug($name);

            if (empty($name) || empty($description) || empty($price) || empty($category_id) || $status === "") {
                $data['error'] = 'Vui lòng điền đầy đủ thông tin';
                $data['redirect'] = '/admin/product/edit/' . $id;
                $this->view('admin/product/edit', $data);
                return;
            }

            if ($this->productModel->checkSlug($slug, $id) > 0) {
                $data['error'] = 'Slug đã tồn tại';
                $data['redirect'] = '/admin/product/edit/' . $id;
                $this->view('admin/product/edit', $data);
                return;
            }

            if ($image['error'] == 0) {
                // có ảnh mới
                $uploadDir = __DIR__ . '/../../../public/uploads/products/';
                $uploadResult = $this->uploadImage($image, $uploadDir);
                if (!empty($uploadResult['error'])) {
                    $data['error'] = $uploadResult['error'];
                    $data['redirect'] = '/admin/product/edit/' . $id;
                    $this->view('admin/product/edit', $data);
                    return;
                }
                $filename = $uploadResult['filename'];
            } else {
                // giữ ảnh cũ
                $filename = $data['dproduct']['image'];
            }

            $result = $this->productModel->update(
                $id,
                $name,
                $description,
                $filename,
                $price,
                $category_id,
                $status,
                $slug
            );

            if ($result) {
                $data['success'] = 'Cập nhật sản phẩm thành công';
                $data['redirect'] = '/admin/product/index';
            } else {
                $data['error'] = 'Cập nhật sản phẩm thất bại';
                $data['redirect'] = '/admin/product/edit/' . $id;
            }

            $this->view('admin/product/edit', $data);
            return;
        }

        $this->view('admin/product/edit', $data);
    }

    public function delete($id)
    {
        $result = $this->productModel->delete($id);
        if ($result) {
            $data['success'] = 'Xóa sản phẩm thành công';
            $data['redirect'] = '/admin/product/index';
        } else {
            $data['error'] = 'Xóa sản phẩm thất bại';
            $data['redirect'] = '/admin/product/index';
        }
        $this->view('admin/product/index', $data);
    }
    private function uploadImage($file, $uploadDir)
    {
        if ($file['error'] != 0) {
            return ['error' => 'Lỗi upload file'];
        }
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
        if (!in_array($file['type'], $allowedTypes)) {
            return ['error' => 'File ảnh không hợp lệ. Chỉ chấp nhận jpeg, png, gif, webp'];
        }
        $filename = uniqid() . '_' . basename($file['name']);
        $targetFile = rtrim($uploadDir, '/') . '/' . $filename;
        if (!move_uploaded_file($file['tmp_name'], $targetFile)) {
            return ['error' => 'Không thể lưu ảnh lên server'];
        }
        return ['filename' => $filename];
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
