<?php

namespace controllers\admin;

use core\BaseController;
use models\Category;
use models\Product;

class ProductController extends BaseController
{
    public function __construct()
    {
        parent::__construct(); // gọi constructor của BaseController
    }
    public function index()
    {
        $productM = new Product(); // khởi tạo model Product
        $data['products'] = $productM->getAll(); // lấy tất cả sản phẩm
        $this->view('admin/product/index', $data); // hiển thị view index
    }
    public function create()
    {
        $data = [];
        $categoryM = new Category(); // khởi tạo model Category
        $data['list_category'] = $categoryM->getAll(); // lấy tất cả danh mục
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['create'])) { // kiểm tra xem phương thức request có phải là POST và có tồn tại biến create không
            $productM = new Product(); // khởi tạo model Product
            $productM->setName($_POST['name']);
            $productM->setDescription($_POST['description']); // set description
            $productM->setPrice($_POST['price']); // set price
            $productM->setCategoryId($_POST['category_id']); // set category id
            $productM->setStatus($_POST['status']); // set status
            $image = $_FILES['image']; // lấy ảnh
            $productM->setSlug($this->generateSlug($productM->getName())); // tạo slug
            if (empty($productM->getName()) || empty($productM->getDescription()) || empty($productM->getPrice()) || empty($productM->getCategoryId()) || $productM->getStatus() === "" || $image['error'] != 0) {
                $data['error'] = 'Vui lòng điền đầy đủ thông tin và chọn ảnh hợp lệ';
                $data['redirect'] = '/admin/product/create';
                $this->view('admin/product/create', $data); // hiển thị view create
                return;
            }
            if ($productM->checkSlug() > 0) { // kiểm tra xem slug đã tồn tại chưa
                $data['error'] = 'Slug đã tồn tại';
                $data['redirect'] = '/admin/product/create';
                $this->view('admin/product/create', $data); // hiển thị view create
                return;
            }
            $uploadDir = __DIR__ . '/../../../public/uploads/products/'; // đường dẫn lưu ảnh
            $uploadResult = $this->uploadImage($image, $uploadDir); // upload ảnh 
            if (!empty($uploadResult['error'])) {
                $data['error'] = $uploadResult['error'];
                $data['redirect'] = '/admin/product/create';
                $this->view('admin/product/create', $data); // hiển thị view create
                return;
            }
            $filename = $uploadResult['filename']; // lấy tên ảnh
            $productM->setImage($filename); // set ảnh
            $result = $productM->create(); // tạo sản phẩm
            if ($result) {
                $data['success'] = 'Thêm sản phẩm thành công';
                $data['redirect'] = '/admin/product/index';
            } else {
                $data['error'] = 'Thêm sản phẩm thất bại';
                $data['redirect'] = '/admin/product/create';
            }
            $this->view('admin/product/create', $data); // hiển thị view create
            return;
        }
        $this->view('admin/product/create', $data); // hiển thị view create
    }
    public function edit($id)
    {
        $productM = new Product(); // khởi tạo model Product
        $productM->setId($id); // set id
        $data['dproduct'] = $productM->getProductById(); // lấy sản phẩm theo id
        $categoryM = new Category(); // khởi tạo model Category
        $data['list_category'] = $categoryM->getAll(); // lấy tất cả danh mục

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit'])) { 
            $productM->setName($_POST['name']); // set name
            $productM->setDescription($_POST['description']); // set description
            $productM->setPrice($_POST['price']); // set price
            $productM->setCategoryId($_POST['category_id']); // set category id
            $productM->setStatus($_POST['status']); // set status
            $image = $_FILES['image']; // lấy ảnh
            $productM->setSlug($this->generateSlug($productM->getName())); // tạo slug

            if (empty($productM->getName()) || empty($productM->getDescription()) || empty($productM->getPrice()) || empty($productM->getCategoryId()) || $productM->getStatus() === "") {
                $data['error'] = 'Vui lòng điền đầy đủ thông tin';
                $data['redirect'] = '/admin/product/edit/' . $id;
                $this->view('admin/product/edit', $data); // hiển thị view edit
                return;
            }

            if ($productM->checkSlug() > 0) { // kiểm tra xem slug đã tồn tại chưa
                $data['error'] = 'Slug đã tồn tại';
                $data['redirect'] = '/admin/product/edit/' . $id;
                $this->view('admin/product/edit', $data); // hiển thị view edit
                return;
            }

            if ($image['error'] == 0) { // kiểm tra xem có ảnh mới không
                $uploadDir = __DIR__ . '/../../../public/uploads/products/'; // đường dẫn lưu ảnh
                $uploadResult = $this->uploadImage($image, $uploadDir); // upload ảnh
                if (!empty($uploadResult['error'])) { // kiểm tra xem có lỗi không
                    $data['error'] = $uploadResult['error'];
                    $data['redirect'] = '/admin/product/edit/' . $id;
                    $this->view('admin/product/edit', $data); 
                    return;
                }
                $filename = $uploadResult['filename']; // lấy tên ảnh
            } else {
                $filename = $data['dproduct']['image']; // lấy tên ảnh cũ
            }

            $productM->setImage($filename); // set ảnh
            $result = $productM->update(); // cập nhật sản phẩm

            if ($result) {
                $data['success'] = 'Cập nhật sản phẩm thành công';
                $data['redirect'] = '/admin/product/index';
            } else {
                $data['error'] = 'Cập nhật sản phẩm thất bại';
                $data['redirect'] = '/admin/product/edit/' . $id;
            }

            $this->view('admin/product/edit', $data); // hiển thị view edit
            return;
        }

        $this->view('admin/product/edit', $data); // hiển thị view edit
    }

    public function delete($id)
    {
        $productM = new Product(); // khởi tạo model Product
        $productM->setId($id); // set id
        $result = $productM->delete(); // xóa sản phẩm
        if ($result) {
            $data['success'] = 'Xóa sản phẩm thành công';
            $data['redirect'] = '/admin/product/index';
        } else {
            $data['error'] = 'Xóa sản phẩm thất bại';
            $data['redirect'] = '/admin/product/index';
        }
        $this->view('admin/product/index', $data); // hiển thị view index
    }
    private function uploadImage($file, $uploadDir) // upload ảnh
    {
        if ($file['error'] != 0) { // kiểm tra xem có lỗi không
            return ['error' => 'Lỗi upload file'];
        }
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp']; // kiểm tra xem định dạng ảnh có hợp lệ không
        if (!in_array($file['type'], $allowedTypes)) { // kiểm tra xem định dạng ảnh có hợp lệ không
            return ['error' => 'File ảnh không hợp lệ. Chỉ chấp nhận jpeg, png, gif, webp'];
        }
        $filename = uniqid() . '_' . basename($file['name']); // tạo tên ảnh
        $targetFile = rtrim($uploadDir, '/') . '/' . $filename; // đường dẫn lưu ảnh
        if (!move_uploaded_file($file['tmp_name'], $targetFile)) { // lưu ảnh
            return ['error' => 'Không thể lưu ảnh lên server'];
        }
        return ['filename' => $filename];
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
