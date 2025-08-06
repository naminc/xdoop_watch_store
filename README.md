# Xdoop Store

> Website bán hàng PHP đơn giản, hỗ trợ quản lý người dùng, sản phẩm, giỏ hàng và thanh toán.

---

## 🎯 Tính năng chính

✅ Đăng ký / Đăng nhập người dùng (session)  
✅ Quản trị (admin) người dùng  
✅ Danh sách sản phẩm  
✅ Giỏ hàng và thanh toán  
✅ Quản lý địa chỉ giao hàng  
✅ Lịch sử đơn hàng

---

## 📂 Cấu trúc thư mục
```
/
├── app/
│ ├── controllers/
│ ├── models/
│ ├── views/
│ └── core/
├── public/
│ ├── assets/
│ └── index.php
└── README.md
```

- **app/controllers/**: Controller xử lý logic
- **app/models/**: Model giao tiếp với database
- **app/views/**: Giao diện (template PHP)
- **app/core/**: Lớp core (Router, Controller, Database,...)
- **public/**: Thư mục public, assets tĩnh, file index.php

---

## ⚙️ Yêu cầu cài đặt

- PHP >= 8.0
- MySQL/MariaDB
- Apache hoặc Nginx
- Composer (tuỳ chọn)

---

## 🚀 Cài đặt nhanh

1️⃣ Clone project, cài thư viện

```bash
git clone https://github.com/naminc/xdoop_watch_store.git
```

```bash
composer install
```

2️⃣ Tạo database
- Tạo DBNAME, USERNAME, PASSWORD
- Import file db.sql

3️⃣ Cấu hình kết nối DB & SMTP
- Cấu hình thông tin Database & SMTP trong **app/config/config.php**
```env
return [
    'database' => [
        'host' => 'localhost',
        'user' => 'root',
        'pass' => '',
        'dbname' => 'ruiz-watch',
        'charset' => 'utf8'
    ],
    'smtp' => [
        'host' => 'smtp.gmail.com',
        'username' => '',
        'password' => '',
        'encryption' => 'tls',
        'port' => 587,
        'from_email' => '',
        'from_name' => ''
    ]
];
```

---

## 📄 License

Released under the [MIT License](LICENSE)  
© 2025 [naminc](https://github.com/naminc)