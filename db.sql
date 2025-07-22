-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th7 22, 2025 lúc 04:32 PM
-- Phiên bản máy phục vụ: 10.4.32-MariaDB
-- Phiên bản PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `ruiz-watch`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `cart_items`
--

CREATE TABLE `cart_items` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `status` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `categories`
--

INSERT INTO `categories` (`id`, `name`, `slug`, `description`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Đồng hồ nam', 'dong-ho-nam', 'Các mẫu đồng hồ dành cho nam giới.', 1, '2025-07-08 13:23:18', '2025-07-15 10:12:12'),
(2, 'Đồng hồ nữ', 'dong-ho-nu', 'Các mẫu đồng hồ dành cho nữ giới.', 1, '2025-07-08 13:23:18', '2025-07-08 13:23:18'),
(5, 'Đồng hồ thông minh', 'dong-ho-thong-minh', 'Smartwatch với nhiều tính năng hay ho.', 1, '2025-07-08 13:23:18', '2025-07-15 10:15:16'),
(6, 'Phụ kiện đồng hồ', 'phu-kien-dong-ho', 'Dây đeo, hộp đựng, và phụ kiện khác.', 1, '2025-07-08 13:23:18', '2025-07-15 10:16:36');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `fullname` varchar(255) DEFAULT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `district` varchar(100) DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `postcode` varchar(20) DEFAULT NULL,
  `note` text DEFAULT NULL,
  `payment_method` varchar(50) DEFAULT NULL,
  `total` decimal(12,2) DEFAULT NULL,
  `status` varchar(50) DEFAULT 'pending',
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `fullname`, `phone`, `email`, `address`, `district`, `city`, `postcode`, `note`, `payment_method`, `total`, `status`, `created_at`, `updated_at`) VALUES
(5, 1, 'Ngô Đình Nam', '0347101143', 'admin@naminc.dev', '39 đường số 19, khu phố 48', 'Hiệp Bình', 'Thành phố Hồ Chí Minh', '70000', 'Ship cẩn thận', 'cash', 32400000.00, 'pending', '2025-07-22 20:43:26', '2025-07-22 21:14:34'),
(6, 1, 'TRoy Jome', '3067783344', 'inc006@xnaminc.com', '313 St Rd', 'Hiệp Bình', 'New York', '10001', '', 'cash', 9600000.00, 'shipping', '2025-07-22 20:48:06', '2025-07-22 21:09:30'),
(7, 1, 'Nam Ngo Dinh', '0347101143', 'ngodinhnam.dev@gmail.com', 'Xóm 1, thôn Phụng Sơn', 'Hiệp Bình', 'Gia Lai', '70000', 'dsfsdf', 'cash', 5430000.00, 'cancelled', '2025-07-22 21:03:33', '2025-07-22 21:04:01'),
(8, 18, 'Jame Bond', '91886554', 'j20116931@gmail.com', 'Straße 144, Hf. Lundborg', 'Hiệp Bình', 'Viborg', '8800', 'cvbvcb', 'cash', 13467000.00, 'completed', '2025-07-22 21:04:43', '2025-07-22 21:06:55'),
(9, 1, 'Daniel Johnson', '3056689900', 'yuyfkuw@exelica.com', '313 St Rd', 'Hiệp Bình', 'New York', '10001', 'zxc', 'cash', 13780000.00, 'shipping', '2025-07-22 21:18:21', '2025-07-22 21:19:52');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(12,2) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `quantity`, `price`, `created_at`, `updated_at`) VALUES
(12, 5, 31, 1, 6300000.00, '2025-07-22 20:43:26', '2025-07-22 20:43:26'),
(13, 5, 34, 1, 5430000.00, '2025-07-22 20:43:26', '2025-07-22 20:43:26'),
(14, 5, 37, 3, 6890000.00, '2025-07-22 20:43:26', '2025-07-22 20:43:26'),
(15, 6, 32, 1, 2800000.00, '2025-07-22 20:48:06', '2025-07-22 20:48:06'),
(16, 6, 33, 1, 6800000.00, '2025-07-22 20:48:06', '2025-07-22 20:48:06'),
(17, 7, 34, 1, 5430000.00, '2025-07-22 21:03:33', '2025-07-22 21:03:33'),
(18, 8, 37, 1, 6890000.00, '2025-07-22 21:04:43', '2025-07-22 21:04:43'),
(19, 8, 36, 1, 6577000.00, '2025-07-22 21:04:43', '2025-07-22 21:04:43'),
(20, 9, 37, 2, 6890000.00, '2025-07-22 21:18:21', '2025-07-22 21:18:21');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT 0.00,
  `category_id` int(11) NOT NULL,
  `status` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `products`
--

INSERT INTO `products` (`id`, `name`, `slug`, `description`, `image`, `price`, `category_id`, `status`, `created_at`, `updated_at`) VALUES
(30, 'Aurora Classic W1', 'aurora-classic-w1', 'Aurora Classic W1 là mẫu đồng hồ theo phong cách tối giản, nổi bật với mặt số trắng tinh khôi và kim xanh sắc nét. Vỏ thép không gỉ sáng bóng kết hợp cùng dây da nâu cổ điển tạo nên vẻ ngoài thanh lịch, sang trọng. Mẫu đồng hồ này là sự lựa chọn lý tưởng cho những quý ông yêu thích phong cách cổ điển, tinh tế, phù hợp với môi trường công sở hoặc các sự kiện trang trọng.', '687ca99303a5e_product-w1.jpg', 4120000.00, 2, 1, '2025-07-20 08:32:19', '2025-07-20 10:58:58'),
(31, 'Celestia Moonphase W2', 'celestia-moonphase-w2', 'Celestia Moonphase W2 sở hữu thiết kế ấn tượng với mặt đồng hồ tích hợp lịch trăng (moonphase), kết hợp với nền sao và mặt trời tạo chiều sâu huyền ảo. Vỏ màu vàng sang trọng phối với dây da xanh dương nổi bật, mang đậm phong cách châu Âu cổ điển. Đây là mẫu đồng hồ dành cho những người yêu thích sự lãng mạn và tinh tế, đồng thời thể hiện gu thẩm mỹ độc đáo và đẳng cấp.', '687ca9b49534d_product-w2.jpg', 6300000.00, 1, 1, '2025-07-20 08:32:52', '2025-07-20 10:58:58'),
(32, 'Chronomaster Heritage W3', 'chronomaster-heritage-w3', 'Chronomaster Heritage W3 là mẫu chronograph cổ điển với mặt trắng sáng và ba mặt số phụ tinh tế. Thiết kế cân đối, vỏ thép sáng bóng và dây da đen thanh lịch, tạo nên vẻ ngoài lịch lãm nhưng không kém phần mạnh mẽ. Đồng hồ phù hợp cho các quý ông yêu thích sự cổ điển kết hợp tính năng thể thao, sử dụng tốt trong công việc lẫn sự kiện.', '687ca9f6dc909_product-w3.jpg', 2800000.00, 1, 1, '2025-07-20 08:33:58', '2025-07-20 10:58:58'),
(33, 'NeoTech Minimalist W4', 'neotech-minimalist-w4', 'NeoTech Minimalist W4 mang hơi thở hiện đại với mặt số đen tuyền đơn giản, tinh gọn trong từng chi tiết. Dây cao su đen mềm mại, dễ đeo và chống nước, phù hợp với lối sống năng động. Với phong cách tối giản và trẻ trung, đây là lựa chọn hoàn hảo cho giới trẻ thành thị, đặc biệt là những người yêu công nghệ hoặc hybrid smartwatch.', '687caa18dc98c_product-w4.jpg', 6800000.00, 1, 1, '2025-07-20 08:34:32', '2025-07-20 10:58:58'),
(34, 'Titan Sport Chrono W5', 'titan-sport-chrono-w5', 'Titan Sport Chrono W5 là mẫu đồng hồ thể thao mang phong cách mạnh mẽ và cá tính. Vỏ thép đen phối với chi tiết viền vàng tạo điểm nhấn táo bạo, cùng với các nút bấm chức năng và 3 mặt số phụ hỗ trợ bấm giờ chuyên nghiệp. Dây cao su chắc chắn, phù hợp cho các hoạt động thể thao cường độ cao hoặc người yêu phong cách mạnh mẽ, nam tính.', '687caa5886d70_product-w5.jpg', 5430000.00, 1, 1, '2025-07-20 08:35:36', '2025-07-20 10:58:58'),
(35, 'Vintage Rose Classic W6', 'vintage-rose-classic-w6', 'Vintage Rose Classic W6 là mẫu đồng hồ mang phong cách hoài cổ với thiết kế thanh lịch, viền vàng hồng nhẹ nhàng và dây da nâu sáng. Mặt số màu trắng trang nhã, kim mảnh và mặt phụ hiển thị giây nhỏ tinh tế. Mẫu đồng hồ này thể hiện sự nhẹ nhàng và lịch thiệp, phù hợp với người yêu thời trang cổ điển, tinh giản và sang trọng.', '687caab0ecc0e_product-w6.jpg', 2800000.00, 2, 1, '2025-07-20 08:37:04', '2025-07-20 10:58:58'),
(36, 'Royal Blue Chronograph', 'royal-blue-chronograph', 'Royal Blue Chronograph là sự kết hợp hài hòa giữa cổ điển và thể thao, với mặt số xanh navy đậm cùng các chữ số La Mã màu trắng tạo nên độ tương phản cao. Vỏ thép vàng bóng bẩy kết hợp dây da nâu cao cấp, cùng với 3 mặt phụ chronograph hỗ trợ bấm giờ tiện lợi. Mẫu đồng hồ này mang đến sự đẳng cấp, phù hợp cho cả doanh nhân lẫn giới trẻ hiện đại yêu thích sự nổi bật và cá tính.', '687cae7758e20_product-06-removebg-preview.png', 6577000.00, 1, 1, '2025-07-20 08:38:31', '2025-07-20 10:58:58'),
(37, 'TitanX Tactical Pro', 'titanx-tactical-pro', 'TitanX Tactical Pro là mẫu đồng hồ kỹ thuật số chuyên dụng dành cho các hoạt động ngoài trời và quân sự. Vỏ đồng hồ bằng nhựa ABS chịu lực, dây cao su dày dặn cùng màn hình điện tử lớn dễ quan sát. Tích hợp nhiều tính năng như hiển thị giờ, ngày, lịch, la bàn số, nhiệt kế, đo độ cao, áp suất không khí và đèn nền LED giúp bạn sẵn sàng trong mọi điều kiện. Phù hợp cho người yêu phượt, trekking, dã ngoại hoặc làm việc trong môi trường khắc nghiệt.', '687caf16844b8_product-10-removebg-preview.png', 6890000.00, 5, 1, '2025-07-20 08:55:50', '2025-07-20 10:58:58');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `settings`
--

CREATE TABLE `settings` (
  `id` int(11) NOT NULL CHECK (`id` = 1),
  `title` varchar(255) DEFAULT NULL,
  `keyword` text NOT NULL,
  `description` text NOT NULL,
  `brand` varchar(32) NOT NULL,
  `domain` varchar(255) DEFAULT NULL,
  `owner` varchar(32) NOT NULL,
  `email` varchar(32) NOT NULL,
  `phone` varchar(32) NOT NULL,
  `address` text NOT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `icon` varchar(255) NOT NULL,
  `maintenance` varchar(10) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `settings`
--

INSERT INTO `settings` (`id`, `title`, `keyword`, `description`, `brand`, `domain`, `owner`, `email`, `phone`, `address`, `logo`, `icon`, `maintenance`, `created_at`, `updated_at`) VALUES
(1, 'Xdoop Watches Store', 'Xdoop Watches Store', 'Xdoop Watches Store', 'Xdoop', 'xdoop.com', 'naminc', 'admin@naminc.dev', '0347101143', '39 Đường số 19, Khu phố 4, Phường Hiệp Bình Chánh, TP. Thủ Đức, TP.HCM', '/assets/img/logo/xdoop.png', '/assets/img/favicon.ico', 'off', '2025-07-21 12:35:11', '2025-07-21 12:57:21');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `fullname` varchar(32) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `role` enum('admin','user') NOT NULL DEFAULT 'user',
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`id`, `fullname`, `username`, `password`, `email`, `phone`, `role`, `status`, `ip_address`, `user_agent`, `created_at`, `updated_at`) VALUES
(1, 'Ngo Dinh Nam', 'naminc', '$2y$10$Do4p3ZF1nyCu3YxheXGRBuJp1QwH2UKthx17nD9pVLUPcgh5gUCh.', 'admin@naminc.dev', '0347101143', 'admin', 1, NULL, NULL, '2025-07-07 13:00:24', '2025-07-20 12:14:43'),
(16, 'Dinh Nam Ngo', 'phong1234', '$2y$10$2ZrNOtdrd7YJWGDXg41YZOzGNyFmMG8VhtWP1DRPrj4I6qBaNZY3C', 'admin@naminc.deve4', '0347101143', 'admin', 1, '127.0.0.1', 'sdsdfg', '2025-07-18 15:04:38', '2025-07-18 15:12:26'),
(18, 'Daniel Johnson', 'ngungu', '$2y$10$UQ5dw7AfDbwrYjKu5rHqf.dCd7nAG9SuOzOGPa6ehKKKjVALGemCy', 'ngodinhnam.dev@gmail.com', '3056689900', 'admin', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36', '2025-07-20 12:52:56', '2025-07-20 13:08:03');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `cart_items`
--
ALTER TABLE `cart_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user` (`user_id`),
  ADD KEY `fk_product` (`product_id`);

--
-- Chỉ mục cho bảng `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Chỉ mục cho bảng `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Chỉ mục cho bảng `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Chỉ mục cho bảng `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`),
  ADD KEY `category_id` (`category_id`);

--
-- Chỉ mục cho bảng `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `cart_items`
--
ALTER TABLE `cart_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT cho bảng `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT cho bảng `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT cho bảng `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT cho bảng `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `cart_items`
--
ALTER TABLE `cart_items`
  ADD CONSTRAINT `fk_product` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
