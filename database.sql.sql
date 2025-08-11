-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th8 06, 2025 lúc 01:46 PM
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
-- Cấu trúc bảng cho bảng `coupons`
--

CREATE TABLE `coupons` (
  `id` int(11) NOT NULL,
  `code` varchar(50) NOT NULL,
  `discount_type` enum('percentage','fixed') NOT NULL,
  `discount_value` decimal(10,2) NOT NULL,
  `expires_at` datetime DEFAULT NULL,
  `usage_limit` int(11) DEFAULT NULL,
  `used_count` int(11) DEFAULT 0,
  `status` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `coupons`
--

INSERT INTO `coupons` (`id`, `code`, `discount_type`, `discount_value`, `expires_at`, `usage_limit`, `used_count`, `status`) VALUES
(1, 'GIAM10', 'percentage', 10.00, '2025-12-31 23:59:59', 100, 0, 1),
(3, 'VIP20', 'percentage', 20.00, '2025-07-31 14:19:48', 2, 2, 1),
(4, 'FREE100', 'fixed', 100000.00, '2025-07-31 23:59:59', 10, 10, 1),
(5, 'HETHAN', 'fixed', 30000.00, '2024-12-31 23:59:59', 10, 5, 1),
(6, 'FREE200', 'fixed', 200000.00, '2025-09-10 00:00:00', 5, 1, 1),
(8, 'VIP10', 'percentage', 10.00, '2026-10-16 00:12:00', 5, 1, 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `coupon_usages`
--

CREATE TABLE `coupon_usages` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `coupon_id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `used_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `coupon_usages`
--

INSERT INTO `coupon_usages` (`id`, `user_id`, `coupon_id`, `order_id`, `used_at`) VALUES
(5, 1, 4, 23, '2025-07-25 09:36:46'),
(7, 1, 6, 26, '2025-07-25 10:02:24'),
(9, 1, 3, 30, '2025-07-29 05:44:50');

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
(23, 1, 'Ngô Đình Nam', '0347101143', 'admin@naminc.dev', '39 đường số 19, khu phố 39', 'Hiệp Bình', 'Thành phố Hồ Chí Minh', '70000', 'FREE100', 'cash', 13367000.00, 'pending', '2025-07-25 16:36:46', '2025-07-25 16:36:46'),
(24, 1, 'Ngô Đình Nam', '0347101143', 'admin@naminc.dev', '39 đường số 19, khu phố 39', 'Hiệp Bình', 'Thành phố Hồ Chí Minh', '70000', 'VIP20', 'cash', 10773600.00, 'pending', '2025-07-25 16:38:48', '2025-07-25 16:38:48'),
(25, 1, 'Ngô Đình Nam', '0347101143', 'admin@naminc.dev', '39 đường số 19, khu phố 39', 'Hiệp Bình', 'Thành phố Hồ Chí Minh', '70000', 'None', 'cash', 13467000.00, 'shipping', '2025-07-25 16:39:21', '2025-07-25 16:43:02'),
(26, 1, 'Ngô Đình Nam', '0347101143', 'admin@naminc.dev', '39 đường số 19, khu phố 39', 'Hiệp Bình', 'Thành phố Hồ Chí Minh', '70000', 'FREE200', 'cash', 13267000.00, 'completed', '2025-07-25 17:02:23', '2025-07-25 17:03:04'),
(27, 1, 'Ngô Đình Nam', '0347101143', 'admin@naminc.dev', '39 đường số 19, khu phố 39', 'Hiệp Bình', 'Thành phố Hồ Chí Minh', '70000', '2BSgJJsN', 'cash', 969000.00, 'pending', '2025-07-25 17:11:51', '2025-07-25 17:11:51'),
(28, 1, 'Ngô Đình Nam', '0347101143', 'admin@naminc.dev', '39 đường số 19, khu phố 40', 'Hiệp Bình', 'Thành phố Hồ Chí Minh', '70000', '', 'cash', 9690000.00, 'pending', '2025-07-29 12:36:25', '2025-07-29 12:36:25'),
(29, 1, 'Ngô Đình Nam', '0347101143', 'admin@naminc.dev', '39 đường số 19, khu phố 39', 'Hiệp Bình', 'Thành phố Hồ Chí Minh', '70000', '', 'cash', 8230000.00, 'pending', '2025-07-29 12:41:03', '2025-07-29 12:41:03'),
(30, 1, 'Ngô Đình Nam', '0347101143', 'admin@naminc.dev', '39 đường số 19, khu phố 39', 'Hiệp Bình', 'Thành phố Hồ Chí Minh', '70000', '', 'cash', 10928000.00, 'pending', '2025-07-29 12:44:50', '2025-07-29 12:44:50'),
(31, 1, 'Ngô Đình Nam', '0347101143', 'admin@naminc.dev', '39 đường số 19, khu phố 39', 'Hiệp Bình', 'Thành phố Hồ Chí Minh', '70000', '', 'cash', 6300000.00, 'completed', '2025-07-29 12:53:11', '2025-08-01 15:12:18'),
(32, 1, 'Ngô Đình Nam', '0347101143', 'admin@naminc.dev', '39 đường số 19, khu phố 39', 'Hiệp Bình', 'Thành phố Hồ Chí Minh', '70000', '', 'cash', 11030000.00, 'pending', '2025-08-06 18:27:50', '2025-08-06 18:27:50'),
(33, 1, 'Ngô Đình Nam', '0347101143', 'admin@naminc.dev', '39 đường số 19, khu phố 39', 'Hiệp Bình', 'Thành phố Hồ Chí Minh', '70000', 'czxc', 'cash', 2800000.00, 'pending', '2025-08-06 18:37:02', '2025-08-06 18:37:02'),
(34, 1, 'Ngô Đình Nam', '0347101143', 'admin@naminc.dev', '39 đường số 19, khu phố 39', 'Hiệp Bình', 'Thành phố Hồ Chí Minh', '70000', '', 'cash', 4120000.00, 'pending', '2025-08-06 18:38:15', '2025-08-06 18:38:15'),
(35, 1, 'Ngô Đình Nam', '0347101143', 'admin@naminc.dev', '39 đường số 19, khu phố 39', 'Hiệp Bình', 'Thành phố Hồ Chí Minh', '70000', '', 'cash', 4120000.00, 'pending', '2025-08-06 18:44:17', '2025-08-06 18:44:17');

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
(41, 23, 37, 1, 6890000.00, '2025-07-25 16:36:46', '2025-07-25 16:36:46'),
(42, 23, 36, 1, 6577000.00, '2025-07-25 16:36:46', '2025-07-25 16:36:46'),
(43, 24, 37, 1, 6890000.00, '2025-07-25 16:38:48', '2025-07-25 16:38:48'),
(44, 24, 36, 1, 6577000.00, '2025-07-25 16:38:48', '2025-07-25 16:38:48'),
(45, 25, 37, 1, 6890000.00, '2025-07-25 16:39:21', '2025-07-25 16:39:21'),
(46, 25, 36, 1, 6577000.00, '2025-07-25 16:39:21', '2025-07-25 16:39:21'),
(47, 26, 37, 1, 6890000.00, '2025-07-25 17:02:24', '2025-07-25 17:02:24'),
(48, 26, 36, 1, 6577000.00, '2025-07-25 17:02:24', '2025-07-25 17:02:24'),
(49, 27, 37, 1, 6890000.00, '2025-07-25 17:11:51', '2025-07-25 17:11:51'),
(50, 27, 35, 1, 2800000.00, '2025-07-25 17:11:51', '2025-07-25 17:11:51'),
(51, 28, 37, 1, 6890000.00, '2025-07-29 12:36:25', '2025-07-29 12:36:25'),
(52, 28, 35, 1, 2800000.00, '2025-07-29 12:36:25', '2025-07-29 12:36:25'),
(53, 29, 35, 1, 2800000.00, '2025-07-29 12:41:03', '2025-07-29 12:41:03'),
(54, 29, 34, 1, 5430000.00, '2025-07-29 12:41:03', '2025-07-29 12:41:03'),
(55, 30, 34, 2, 5430000.00, '2025-07-29 12:44:50', '2025-07-29 12:44:50'),
(56, 30, 35, 1, 2800000.00, '2025-07-29 12:44:50', '2025-07-29 12:44:50'),
(57, 31, 31, 1, 6300000.00, '2025-07-29 12:53:11', '2025-07-29 12:53:11'),
(58, 32, 35, 2, 2800000.00, '2025-08-06 18:27:50', '2025-08-06 18:27:50'),
(59, 32, 34, 1, 5430000.00, '2025-08-06 18:27:50', '2025-08-06 18:27:50'),
(60, 33, 35, 1, 2800000.00, '2025-08-06 18:37:02', '2025-08-06 18:37:02'),
(61, 34, 30, 1, 4120000.00, '2025-08-06 18:38:15', '2025-08-06 18:38:15'),
(62, 35, 30, 1, 4120000.00, '2025-08-06 18:44:17', '2025-08-06 18:44:17');

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
  `stock` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `status` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `products`
--

INSERT INTO `products` (`id`, `name`, `slug`, `description`, `image`, `price`, `stock`, `category_id`, `status`, `created_at`, `updated_at`) VALUES
(30, 'Aurora Classic W1', 'aurora-classic-w1', 'Aurora Classic W1 là mẫu đồng hồ theo phong cách tối giản, nổi bật với mặt số trắng tinh khôi và kim xanh sắc nét. Vỏ thép không gỉ sáng bóng kết hợp cùng dây da nâu cổ điển tạo nên vẻ ngoài thanh lịch, sang trọng. Mẫu đồng hồ này là sự lựa chọn lý tưởng cho những quý ông yêu thích phong cách cổ điển, tinh tế, phù hợp với môi trường công sở hoặc các sự kiện trang trọng.', '687ca99303a5e_product-w1.jpg', 4120000.00, 8, 2, 0, '2025-07-20 08:32:19', '2025-08-06 11:44:17'),
(31, 'Celestia Moonphase W2', 'celestia-moonphase-w2', 'Celestia Moonphase W2 sở hữu thiết kế ấn tượng với mặt đồng hồ tích hợp lịch trăng (moonphase), kết hợp với nền sao và mặt trời tạo chiều sâu huyền ảo. Vỏ màu vàng sang trọng phối với dây da xanh dương nổi bật, mang đậm phong cách châu Âu cổ điển. Đây là mẫu đồng hồ dành cho những người yêu thích sự lãng mạn và tinh tế, đồng thời thể hiện gu thẩm mỹ độc đáo và đẳng cấp.', '687ca9b49534d_product-w2.jpg', 6300000.00, 9, 1, 1, '2025-07-20 08:32:52', '2025-07-29 05:53:11'),
(32, 'Chronomaster Heritage W3', 'chronomaster-heritage-w3', 'Chronomaster Heritage W3 là mẫu chronograph cổ điển với mặt trắng sáng và ba mặt số phụ tinh tế. Thiết kế cân đối, vỏ thép sáng bóng và dây da đen thanh lịch, tạo nên vẻ ngoài lịch lãm nhưng không kém phần mạnh mẽ. Đồng hồ phù hợp cho các quý ông yêu thích sự cổ điển kết hợp tính năng thể thao, sử dụng tốt trong công việc lẫn sự kiện.', '687ca9f6dc909_product-w3.jpg', 2800000.00, 10, 1, 1, '2025-07-20 08:33:58', '2025-07-25 06:17:26'),
(33, 'NeoTech Minimalist W4', 'neotech-minimalist-w4', 'NeoTech Minimalist W4 mang hơi thở hiện đại với mặt số đen tuyền đơn giản, tinh gọn trong từng chi tiết. Dây cao su đen mềm mại, dễ đeo và chống nước, phù hợp với lối sống năng động. Với phong cách tối giản và trẻ trung, đây là lựa chọn hoàn hảo cho giới trẻ thành thị, đặc biệt là những người yêu công nghệ hoặc hybrid smartwatch.', '687caa18dc98c_product-w4.jpg', 6800000.00, 10, 1, 1, '2025-07-20 08:34:32', '2025-07-25 06:17:29'),
(34, 'Titan Sport Chrono W5', 'titan-sport-chrono-w5', 'Titan Sport Chrono W5 là mẫu đồng hồ thể thao mang phong cách mạnh mẽ và cá tính. Vỏ thép đen phối với chi tiết viền vàng tạo điểm nhấn táo bạo, cùng với các nút bấm chức năng và 3 mặt số phụ hỗ trợ bấm giờ chuyên nghiệp. Dây cao su chắc chắn, phù hợp cho các hoạt động thể thao cường độ cao hoặc người yêu phong cách mạnh mẽ, nam tính.', '687caa5886d70_product-w5.jpg', 5430000.00, 3, 1, 1, '2025-07-20 08:35:36', '2025-08-06 11:27:50'),
(35, 'Vintage Rose Classic W6', 'vintage-rose-classic-w6', 'Vintage Rose Classic W6 là mẫu đồng hồ mang phong cách hoài cổ với thiết kế thanh lịch, viền vàng hồng nhẹ nhàng và dây da nâu sáng. Mặt số màu trắng trang nhã, kim mảnh và mặt phụ hiển thị giây nhỏ tinh tế. Mẫu đồng hồ này thể hiện sự nhẹ nhàng và lịch thiệp, phù hợp với người yêu thời trang cổ điển, tinh giản và sang trọng.', '687caab0ecc0e_product-w6.jpg', 2800000.00, 3, 2, 1, '2025-07-20 08:37:04', '2025-08-06 11:37:02'),
(36, 'Royal Blue Chronograph', 'royal-blue-chronograph', 'Royal Blue Chronograph là sự kết hợp hài hòa giữa cổ điển và thể thao, với mặt số xanh navy đậm cùng các chữ số La Mã màu trắng tạo nên độ tương phản cao. Vỏ thép vàng bóng bẩy kết hợp dây da nâu cao cấp, cùng với 3 mặt phụ chronograph hỗ trợ bấm giờ tiện lợi. Mẫu đồng hồ này mang đến sự đẳng cấp, phù hợp cho cả doanh nhân lẫn giới trẻ hiện đại yêu thích sự nổi bật và cá tính.', '687cae7758e20_product-06-removebg-preview.png', 6577000.00, 0, 1, 1, '2025-07-20 08:38:31', '2025-07-25 10:02:24'),
(37, 'TitanX Tactical Pro', 'titanx-tactical-pro', 'TitanX Tactical Pro là mẫu đồng hồ kỹ thuật số chuyên dụng dành cho các hoạt động ngoài trời và quân sự. Vỏ đồng hồ bằng nhựa ABS chịu lực, dây cao su dày dặn cùng màn hình điện tử lớn dễ quan sát. Tích hợp nhiều tính năng như hiển thị giờ, ngày, lịch, la bàn số, nhiệt kế, đo độ cao, áp suất không khí và đèn nền LED giúp bạn sẵn sàng trong mọi điều kiện. Phù hợp cho người yêu phượt, trekking, dã ngoại hoặc làm việc trong môi trường khắc nghiệt.', '687caf16844b8_product-10-removebg-preview.png', 6890000.00, 8, 5, 1, '2025-07-20 08:55:50', '2025-07-29 05:36:25');

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
(16, 'Dinh Nam Ngo', 'phong1234', '$2y$10$2ZrNOtdrd7YJWGDXg41YZOzGNyFmMG8VhtWP1DRPrj4I6qBaNZY3C', 'admin@naminc.deve4', '0347101143', 'admin', 1, '127.0.0.1', '', '2025-07-18 15:04:38', '2025-08-04 09:30:11'),
(21, 'Ngo Van', 'guest001', '$2y$10$GuuYnq1mN/lQK81iR.C37eHk4CWW/jbmBbc8wGme97.qiAV3Qpw6C', 'guest001@naminc.dev', '0347101143', 'user', 1, '', '', '2025-08-02 06:34:00', '2025-08-04 09:30:02');

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
-- Chỉ mục cho bảng `coupons`
--
ALTER TABLE `coupons`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `code` (`code`);

--
-- Chỉ mục cho bảng `coupon_usages`
--
ALTER TABLE `coupon_usages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `fk_coupon` (`coupon_id`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=86;

--
-- AUTO_INCREMENT cho bảng `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT cho bảng `coupons`
--
ALTER TABLE `coupons`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT cho bảng `coupon_usages`
--
ALTER TABLE `coupon_usages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT cho bảng `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT cho bảng `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- AUTO_INCREMENT cho bảng `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

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
-- Các ràng buộc cho bảng `coupon_usages`
--
ALTER TABLE `coupon_usages`
  ADD CONSTRAINT `coupon_usages_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `coupon_usages_ibfk_2` FOREIGN KEY (`coupon_id`) REFERENCES `coupons` (`id`),
  ADD CONSTRAINT `coupon_usages_ibfk_3` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`);

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
