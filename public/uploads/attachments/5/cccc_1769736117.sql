-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jan 30, 2026 at 12:26 AM
-- Server version: 5.7.44
-- PHP Version: 8.3.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `spam`
--

-- --------------------------------------------------------

--
-- Table structure for table `campaigns`
--

CREATE TABLE `campaigns` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `content` text COLLATE utf8mb4_unicode_ci,
  `images` text COLLATE utf8mb4_unicode_ci,
  `is_active` tinyint(1) DEFAULT '1',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `campaigns`
--

INSERT INTO `campaigns` (`id`, `title`, `content`, `images`, `is_active`, `created_at`) VALUES
(10, 'Bán Tai Nghe Airpods Rep', 'Airpods Pro 2 hổ vằn cực xịn, giá chỉ 450k. Freeship HN.', '[\"img/airpods1.jpg\"]', 1, '2026-01-29 03:50:28'),
(11, 'Dịch Vụ Chạy Ads FB', 'Nhận lên camp VPVP, hàng sạch, ngân sách lớn. Inbox.', '[\"img/ads.png\"]', 1, '2026-01-29 03:50:28'),
(12, 'Tuyển CTV Đăng Bài', 'Cần 20 CTV đăng bài group, lương 200k/ngày.', '[\"img/job.jpg\"]', 1, '2026-01-29 03:50:28'),
(13, 'Xả Kho Đồ Gia Dụng', 'Nồi chiên không dầu dọn kho giá sốc 599k.', '[\"img/cook.jpg\"]', 1, '2026-01-29 03:50:28'),
(14, 'Tour Du Lịch Thái Lan', 'Tour Thái 5N4Đ trọn gói chỉ 6tr990. Bay ngay tháng 2.', '[\"img/thai.jpg\"]', 1, '2026-01-29 03:50:28');

-- --------------------------------------------------------

--
-- Table structure for table `campaign_fb_group`
--

CREATE TABLE `campaign_fb_group` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `campaign_id` bigint(20) UNSIGNED NOT NULL,
  `fb_group_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `campaign_fb_group`
--

INSERT INTO `campaign_fb_group` (`id`, `campaign_id`, `fb_group_id`, `created_at`, `updated_at`) VALUES
(6, 10, 1, NULL, NULL),
(7, 10, 2, NULL, NULL),
(8, 10, 3, NULL, NULL),
(9, 11, 9, NULL, NULL),
(10, 11, 10, NULL, NULL),
(11, 11, 11, NULL, NULL),
(12, 11, 12, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `clients`
--

CREATE TABLE `clients` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `api_key` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `delay_min` int(11) DEFAULT '5',
  `delay_max` int(11) DEFAULT '30',
  `is_active` tinyint(1) DEFAULT '1',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL,
  `template_id` int(11) DEFAULT NULL,
  `region_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `clients`
--

INSERT INTO `clients` (`id`, `name`, `api_key`, `delay_min`, `delay_max`, `is_active`, `created_at`, `updated_at`, `template_id`, `region_id`) VALUES
(1, 'HN_Robot_01', 'KEY_HN_001', 5, 15, 1, '2026-01-29 03:50:28', '2026-01-29 10:36:21', 1, NULL),
(2, 'HN_Robot_02', 'KEY_HN_002', 10, 25, 1, '2026-01-29 03:50:28', '2026-01-29 10:27:18', 4, NULL),
(3, 'HN_Robot_03', 'KEY_HN_003', 5, 20, 1, '2026-01-29 03:50:28', '0000-00-00 00:00:00', NULL, NULL),
(4, 'HN_Robot_04', 'KEY_HN_004', 15, 45, 0, '2026-01-29 03:50:28', '0000-00-00 00:00:00', NULL, NULL),
(5, 'HN_Robot_05', 'KEY_HN_005', 5, 10, 1, '2026-01-29 03:50:28', '0000-00-00 00:00:00', NULL, NULL),
(6, 'HN_Robot_06', 'KEY_HN_006', 10, 30, 1, '2026-01-29 03:50:28', '0000-00-00 00:00:00', NULL, NULL),
(7, 'HCM_Bot_01', 'KEY_HCM_001', 5, 15, 1, '2026-01-29 03:50:28', '0000-00-00 00:00:00', NULL, NULL),
(8, 'HCM_Bot_02', 'KEY_HCM_002', 5, 20, 1, '2026-01-29 03:50:28', '0000-00-00 00:00:00', NULL, NULL),
(9, 'HCM_Bot_03', 'KEY_HCM_003', 10, 40, 1, '2026-01-29 03:50:28', '0000-00-00 00:00:00', NULL, NULL),
(10, 'HCM_Bot_04', 'KEY_HCM_004', 15, 30, 1, '2026-01-29 03:50:28', '0000-00-00 00:00:00', NULL, NULL),
(11, 'HCM_Bot_05', 'KEY_HCM_005', 5, 15, 1, '2026-01-29 03:50:28', '0000-00-00 00:00:00', NULL, NULL),
(12, 'HCM_Bot_06', 'KEY_HCM_006', 10, 20, 0, '2026-01-29 03:50:28', '0000-00-00 00:00:00', NULL, NULL),
(13, 'HCM_Bot_07', 'KEY_HCM_007', 5, 25, 1, '2026-01-29 03:50:28', '0000-00-00 00:00:00', NULL, NULL),
(14, 'HCM_Bot_08', 'KEY_HCM_008', 10, 30, 1, '2026-01-29 03:50:28', '0000-00-00 00:00:00', NULL, NULL),
(15, 'DN_Dung_01', 'KEY_DN_001', 5, 15, 1, '2026-01-29 03:50:28', '0000-00-00 00:00:00', NULL, NULL),
(16, 'DN_Dung_02', 'KEY_DN_002', 10, 25, 1, '2026-01-29 03:50:28', '0000-00-00 00:00:00', NULL, NULL),
(17, 'DN_Dung_03', 'KEY_DN_003', 15, 45, 1, '2026-01-29 03:50:28', '0000-00-00 00:00:00', NULL, NULL),
(18, 'DN_Dung_04', 'KEY_DN_004', 5, 20, 1, '2026-01-29 03:50:28', '0000-00-00 00:00:00', NULL, NULL),
(19, 'HP_HaiPhong_01', 'KEY_HP_001', 10, 30, 1, '2026-01-29 03:50:28', '0000-00-00 00:00:00', NULL, NULL),
(20, 'CT_CanTho_01', 'KEY_CT_001', 5, 15, 1, '2026-01-29 03:50:28', '0000-00-00 00:00:00', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `client_campaigns`
--

CREATE TABLE `client_campaigns` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `client_id` bigint(20) UNSIGNED DEFAULT NULL,
  `campaign_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `client_campaigns`
--

INSERT INTO `client_campaigns` (`id`, `client_id`, `campaign_id`, `created_at`) VALUES
(14, 1, 10, '2026-01-29 17:07:25'),
(15, 1, 11, '2026-01-29 17:11:13');

-- --------------------------------------------------------

--
-- Table structure for table `fb_groups`
--

CREATE TABLE `fb_groups` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `region_id` bigint(20) UNSIGNED DEFAULT NULL,
  `group_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `group_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `region` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `fb_groups`
--

INSERT INTO `fb_groups` (`id`, `region_id`, `group_name`, `group_url`, `region`, `created_at`) VALUES
(1, NULL, 'Chợ Tốt Hà Nội', 'fb.com/groups/chotothn', 'Hanoi', '2026-01-29 03:50:28'),
(2, NULL, 'Hội Sinh Viên HN', 'fb.com/groups/svhn', 'Hanoi', '2026-01-29 03:50:28'),
(3, NULL, 'Dân Chung Cư HN', 'fb.com/groups/cucuhn', 'Hanoi', '2026-01-29 03:50:28'),
(4, NULL, 'Việc Làm Hà Nội', 'fb.com/groups/vieclamhn', 'Hanoi', '2026-01-29 03:50:28'),
(5, NULL, 'Ship Tìm Người HN', 'fb.com/groups/shiptimnguoihn', 'Hanoi', '2026-01-29 03:50:28'),
(6, NULL, 'Review Ăn Uống HN', 'fb.com/groups/reviewanhn', 'Hanoi', '2026-01-29 03:50:28'),
(7, NULL, 'Rao Vặt Sài Gòn', 'fb.com/groups/raovatsg', 'HCM', '2026-01-29 03:50:28'),
(8, NULL, 'Hội Xe Ô Tô HCM', 'fb.com/groups/otohcm', 'HCM', '2026-01-29 03:50:28'),
(9, NULL, 'Cộng Đồng Marrketing SG', 'fb.com/groups/mkt-sg', 'HCM', '2026-01-29 03:50:28'),
(10, NULL, 'Tìm Nhà Trọ Q1', 'fb.com/groups/troq1', 'HCM', '2026-01-29 03:50:28'),
(11, NULL, 'Ăn Sập Sài Gòn', 'fb.com/groups/ansapsg', 'HCM', '2026-01-29 03:50:28'),
(12, NULL, 'Góc Đà Nẵng', 'fb.com/groups/gocdn', 'Danang', '2026-01-29 03:50:28'),
(13, NULL, 'Chợ Đồ Cũ Đà Thành', 'fb.com/groups/docudn', 'Danang', '2026-01-29 03:50:28'),
(14, NULL, 'Hải Sản Tươi Sống DN', 'fb.com/groups/haisandn', 'Danang', '2026-01-29 03:50:28');

-- --------------------------------------------------------

--
-- Table structure for table `keyword_filters`
--

CREATE TABLE `keyword_filters` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `keyword` varchar(255) NOT NULL,
  `reply_content` text NOT NULL,
  `is_active` tinyint(1) DEFAULT '1',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `keyword_filters`
--

INSERT INTO `keyword_filters` (`id`, `keyword`, `reply_content`, `is_active`, `created_at`) VALUES
(1, 'giá sao', 'Dạ bên em đang sale còn 450k freeship ạ!', 1, '2026-01-29 03:51:33'),
(2, 'check ib', 'Dạ anh/chị check tin nhắn chờ giúp em nhé.', 1, '2026-01-29 03:51:33'),
(3, 'còn không', 'Dạ sản phẩm vẫn còn sẵn hàng ạ.', 1, '2026-01-29 03:51:33'),
(4, 'địa chỉ', 'Dạ shop em ở 123 Cầu Giấy, Hà Nội ạ.', 1, '2026-01-29 03:51:33');

-- --------------------------------------------------------

--
-- Table structure for table `posting_logs`
--

CREATE TABLE `posting_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `client_id` bigint(20) UNSIGNED DEFAULT NULL,
  `campaign_id` bigint(20) UNSIGNED DEFAULT NULL,
  `group_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fb_post_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `posted_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `posting_logs`
--

INSERT INTO `posting_logs` (`id`, `client_id`, `campaign_id`, `group_url`, `fb_post_url`, `status`, `posted_at`) VALUES
(1, 1, 10, 'fb.com/groups/chotothn', 'fb.com/posts/101', 'success', '2026-01-29 01:05:00'),
(2, 2, 10, 'fb.com/groups/svhn', 'fb.com/posts/102', 'success', '2026-01-29 01:10:00'),
(3, 3, 11, 'fb.com/groups/vieclamhn', 'fb.com/posts/103', 'success', '2026-01-29 01:20:00'),
(4, 5, 12, 'fb.com/groups/shiptimnguoihn', 'fb.com/posts/104', 'success', '2026-01-29 01:45:00'),
(5, 7, 10, 'fb.com/groups/raovatsg', 'fb.com/posts/105', 'success', '2026-01-29 02:15:00'),
(6, 8, 13, 'fb.com/groups/troq1', 'fb.com/posts/106', 'success', '2026-01-29 02:30:00'),
(7, 15, 14, 'fb.com/groups/gocdn', 'fb.com/posts/107', 'success', '2026-01-29 03:00:00'),
(8, 1, 10, 'fb.com/groups/cucuhn', 'fb.com/posts/108', 'success', '2026-01-29 03:15:00'),
(9, 2, 10, 'fb.com/groups/reviewanhn', 'fb.com/posts/109', 'success', '2026-01-29 03:30:00'),
(10, 3, 11, 'fb.com/groups/mkt-sg', 'fb.com/posts/110', 'success', '2026-01-29 04:00:00'),
(11, 16, 14, 'fb.com/groups/haisandn', 'fb.com/posts/111', 'success', '2026-01-29 04:20:00'),
(12, 7, 10, 'fb.com/groups/ansapsg', 'fb.com/posts/112', 'success', '2026-01-29 04:45:00');

-- --------------------------------------------------------

--
-- Table structure for table `regions`
--

CREATE TABLE `regions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `scanned_posts`
--

CREATE TABLE `scanned_posts` (
  `id` int(11) NOT NULL,
  `fb_post_id` varchar(100) DEFAULT NULL,
  `content` text,
  `group_url` varchar(255) DEFAULT NULL,
  `status` enum('pending','commented','ignored') DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `schedule_templates`
--

CREATE TABLE `schedule_templates` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `template_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `times` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `schedule_templates`
--

INSERT INTO `schedule_templates` (`id`, `template_name`, `times`, `created_at`) VALUES
(1, 'Lịch Giờ Vàng (Sáng-Tối)', '[\"08:15\", \"11:45\", \"19:30\", \"21:00\"]', '2026-01-29 03:50:28'),
(2, 'Lịch Cày Đêm', '[\"23:00\", \"01:15\", \"03:30\"]', '2026-01-29 03:50:28'),
(3, 'Lịch Spam Dày (Mỗi 2h)', '[\"07:00\", \"09:00\", \"11:00\", \"13:00\", \"15:00\", \"17:00\", \"19:00\", \"21:00\"]', '2026-01-29 03:50:28'),
(4, 'Lịch Nghỉ Trưa', '[\"11:30\", \"12:15\", \"13:00\"]', '2026-01-29 03:50:28'),
(5, 'Lịch Cuối Tuần', '[\"09:00\", \"14:30\", \"16:00\", \"20:00\", \"22:30\"]', '2026-01-29 03:50:28');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','manager') DEFAULT 'manager',
  `region_access` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `campaigns`
--
ALTER TABLE `campaigns`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `campaign_fb_group`
--
ALTER TABLE `campaign_fb_group`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_campaign_id` (`campaign_id`),
  ADD KEY `idx_fb_group_id` (`fb_group_id`);

--
-- Indexes for table `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `client_campaigns`
--
ALTER TABLE `client_campaigns`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fb_groups`
--
ALTER TABLE `fb_groups`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `keyword_filters`
--
ALTER TABLE `keyword_filters`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `posting_logs`
--
ALTER TABLE `posting_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `regions`
--
ALTER TABLE `regions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `scanned_posts`
--
ALTER TABLE `scanned_posts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `fb_post_id` (`fb_post_id`);

--
-- Indexes for table `schedule_templates`
--
ALTER TABLE `schedule_templates`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `campaigns`
--
ALTER TABLE `campaigns`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `campaign_fb_group`
--
ALTER TABLE `campaign_fb_group`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `clients`
--
ALTER TABLE `clients`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `client_campaigns`
--
ALTER TABLE `client_campaigns`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `fb_groups`
--
ALTER TABLE `fb_groups`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `keyword_filters`
--
ALTER TABLE `keyword_filters`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `posting_logs`
--
ALTER TABLE `posting_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `regions`
--
ALTER TABLE `regions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `scanned_posts`
--
ALTER TABLE `scanned_posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `schedule_templates`
--
ALTER TABLE `schedule_templates`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
