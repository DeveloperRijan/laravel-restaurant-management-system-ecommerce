-- phpMyAdmin SQL Dump
-- version 4.9.7
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jul 20, 2021 at 02:26 AM
-- Server version: 5.6.41-84.1
-- PHP Version: 7.3.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `amappare_db_robo`
--

-- --------------------------------------------------------

--
-- Table structure for table `batch_coupons`
--

CREATE TABLE `batch_coupons` (
  `id` int(11) NOT NULL,
  `type` enum('Special','General') NOT NULL,
  `city` varchar(255) NOT NULL,
  `designation_id` bigint(20) UNSIGNED DEFAULT NULL,
  `batch_10` decimal(8,2) NOT NULL DEFAULT '0.00',
  `batch_20` decimal(8,2) NOT NULL DEFAULT '0.00',
  `coupon_percent` decimal(8,2) NOT NULL DEFAULT '0.00',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `batch_coupons`
--

INSERT INTO `batch_coupons` (`id`, `type`, `city`, `designation_id`, `batch_10`, `batch_20`, `coupon_percent`, `created_at`, `updated_at`) VALUES
(1, 'Special', 'London', 1, 0.00, 0.00, 20.00, NULL, '2021-06-01 06:06:23'),
(2, 'General', 'All', NULL, 0.00, 0.00, 10.00, NULL, '2021-06-01 06:06:23');

-- --------------------------------------------------------

--
-- Table structure for table `batch_coupon_purchase_histories`
--

CREATE TABLE `batch_coupon_purchase_histories` (
  `id` bigint(20) NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL COMMENT 'The staff id from users tbl',
  `batch` enum('10','20') NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `batch_coupon_purchase_histories`
--

INSERT INTO `batch_coupon_purchase_histories` (`id`, `user_id`, `batch`, `created_at`, `updated_at`) VALUES
(1, 6, '20', '2021-06-01 05:43:44', NULL),
(2, 7, '10', '2021-06-01 06:07:00', NULL),
(3, 10, '20', '2021-06-16 14:18:11', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `carts`
--

CREATE TABLE `carts` (
  `id` bigint(20) NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL COMMENT 'User ID is the id of Customer from users tbl where type = Customer',
  `product_id` bigint(20) NOT NULL,
  `qty` int(11) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `carts`
--

INSERT INTO `carts` (`id`, `user_id`, `product_id`, `qty`, `created_at`, `updated_at`) VALUES
(13, 4, 15, 1, '2021-06-30 00:33:07', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `type` enum('Main','Staff') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Main',
  `parent_id` bigint(20) UNSIGNED NOT NULL DEFAULT '0',
  `name` varchar(70) COLLATE utf8mb4_unicode_ci NOT NULL,
  `url` varchar(99) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'should be unique for each type',
  `featured_img` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_sub_child` enum('Yes') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` enum('Admin','Seller') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Admin',
  `creator_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `type`, `parent_id`, `name`, `url`, `featured_img`, `is_sub_child`, `created_by`, `creator_id`, `created_at`, `updated_at`) VALUES
(1, 'Main', 0, 'Dinner Fast', 'dinner-fast', 'category-icon-60a293d3ecc9e6698.png', NULL, 'Admin', 1, '2021-05-17 08:51:19', '2021-05-26 19:45:00'),
(2, 'Main', 0, 'Chickens Fry', 'chickens-fry', 'category-icon-60a38ea3dc61a2007.png', NULL, 'Admin', 1, '2021-05-18 03:53:39', '2021-05-26 19:44:44'),
(5, 'Main', 0, 'Bergur', 'bergur', NULL, NULL, 'Admin', 1, '2021-05-26 15:25:53', '2021-05-26 19:43:55'),
(6, 'Staff', 0, 'BergurStaff', 'bergur', NULL, NULL, 'Admin', 1, '2021-05-31 06:24:39', '2021-05-31 06:27:08');

-- --------------------------------------------------------

--
-- Table structure for table `chats`
--

CREATE TABLE `chats` (
  `id` bigint(20) NOT NULL,
  `sender_id` bigint(20) UNSIGNED DEFAULT NULL COMMENT 'The users tbl user ID',
  `ticket_id` bigint(20) NOT NULL,
  `msg` text NOT NULL,
  `responder_id` bigint(20) UNSIGNED DEFAULT NULL COMMENT 'The user ID of from  users tbl\r\nkitchend staff or admin',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `chats`
--

INSERT INTO `chats` (`id`, `sender_id`, `ticket_id`, `msg`, `responder_id`, `created_at`, `updated_at`) VALUES
(34, 4, 4443, 'Hi man\nI need urgent help\nare you there?', NULL, '2021-06-11 12:49:59', '2021-06-11 12:49:59'),
(35, 4, 4443, 'Man\nI am here', NULL, '2021-06-11 13:13:00', '2021-06-11 13:13:00'),
(36, 4, 4443, 'plse response me I need to talk urgent', NULL, '2021-06-11 13:13:11', '2021-06-11 13:13:11'),
(37, 4, 4443, 'are you there?', NULL, '2021-06-11 13:13:19', '2021-06-11 13:13:19'),
(38, 4, 4443, 'live ji', NULL, '2021-06-11 13:20:03', '2021-06-11 13:20:03'),
(39, 4, 4443, 'hope I hope', NULL, '2021-06-11 13:20:09', '2021-06-11 13:20:09'),
(40, 4, 4443, 'The support system is very low', NULL, '2021-06-11 13:20:17', '2021-06-11 13:20:17'),
(41, 4, 8554, 'Hi', NULL, '2021-06-11 13:36:22', '2021-06-11 13:36:22'),
(42, 12, 2745, 'Hi are you there?', NULL, '2021-06-12 04:08:23', '2021-06-12 04:08:23'),
(43, 12, 2745, 'Hi', NULL, '2021-06-12 04:20:57', '2021-06-12 04:20:57'),
(44, 12, 2745, 'Need help', NULL, '2021-06-12 04:21:10', '2021-06-12 04:21:10'),
(45, 12, 2745, 'are you there?', NULL, '2021-06-12 04:35:16', '2021-06-12 04:35:16'),
(46, 12, 2745, 'hi', 9, '2021-06-12 08:00:19', '2021-06-12 08:00:19'),
(47, NULL, 4443, 'Sorry for late response', 9, '2021-06-12 08:01:49', '2021-06-12 08:01:49'),
(48, NULL, 4443, 'support is cool', 9, '2021-06-12 08:08:44', '2021-06-12 08:08:44'),
(49, 4, 4443, 'No I mean you are helping me about last order?', NULL, '2021-06-12 08:09:10', '2021-06-12 08:09:10'),
(50, NULL, 4443, 'which order you mean?', 9, '2021-06-12 08:09:19', '2021-06-12 08:09:19'),
(51, 4, 4443, 'The order ID 1250', NULL, '2021-06-12 08:10:28', '2021-06-12 08:10:28'),
(52, NULL, 4443, 'ok please give me 2 mins, I am checking your order id and then back u plse....', 9, '2021-06-12 08:11:00', '2021-06-12 08:11:00'),
(53, 4, 4443, 'ok sure plse take your time', NULL, '2021-06-12 08:11:17', '2021-06-12 08:11:17'),
(54, NULL, 4443, 'Thanks', 9, '2021-06-12 08:11:26', '2021-06-12 08:11:26'),
(55, 4, 4443, 'Your are most welcome', NULL, '2021-06-12 08:11:36', '2021-06-12 08:11:36'),
(56, 4, 4443, 'Need more help', NULL, '2021-06-12 08:18:36', '2021-06-12 08:18:36'),
(57, NULL, 4443, 'ok come to me', 9, '2021-06-12 08:18:47', '2021-06-12 08:18:47'),
(58, NULL, 4443, 'good person', 9, '2021-06-12 08:19:26', '2021-06-12 08:19:26'),
(59, 4, 4443, 'coll', NULL, '2021-06-12 08:19:34', '2021-06-12 08:19:34'),
(60, 4, 4443, 'I ma here', NULL, '2021-06-12 08:21:59', '2021-06-12 08:21:59'),
(61, NULL, 4443, 'ok', 9, '2021-06-12 08:22:05', '2021-06-12 08:22:05'),
(62, NULL, 4443, 'olove you jquery', 9, '2021-06-12 08:38:51', '2021-06-12 08:38:51'),
(63, 4, 4443, 'I love you', NULL, '2021-06-12 08:39:14', '2021-06-12 08:39:14'),
(64, NULL, 4443, 'Coll man', 9, '2021-06-12 08:39:21', '2021-06-12 08:39:21'),
(65, NULL, 2745, 'Hello are you there?', 9, '2021-06-16 14:36:16', '2021-06-16 14:36:16'),
(66, 4, 4443, 'Hello Kitchen admin', NULL, '2021-06-16 14:36:53', '2021-06-16 14:36:53'),
(67, NULL, 4443, 'Hi how can I help you?', 9, '2021-06-16 14:37:16', '2021-06-16 14:37:16'),
(68, 4, 4443, 'I need some help in order item', NULL, '2021-06-16 14:37:36', '2021-06-16 14:37:36'),
(69, NULL, 4443, 'sure plse tell me details', 9, '2021-06-16 14:37:49', '2021-06-16 14:37:49');

-- --------------------------------------------------------

--
-- Table structure for table `cities`
--

CREATE TABLE `cities` (
  `id` bigint(20) NOT NULL,
  `name` varchar(99) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `companies`
--

CREATE TABLE `companies` (
  `id` int(11) NOT NULL,
  `name` varchar(99) NOT NULL,
  `code` varchar(99) NOT NULL,
  `address_line_one` varchar(255) NOT NULL,
  `address_line_two` varchar(255) DEFAULT NULL,
  `city` varchar(99) NOT NULL,
  `state` varchar(99) NOT NULL,
  `can_order_any_time` enum('Yes','No') NOT NULL DEFAULT 'Yes',
  `start_time` time DEFAULT NULL,
  `end_time` time DEFAULT NULL,
  `start_day` enum('Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday') DEFAULT NULL,
  `end_day` enum('Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday') DEFAULT NULL,
  `discount_percent` decimal(8,2) NOT NULL DEFAULT '0.00',
  `status` enum('Active','Inactive') NOT NULL DEFAULT 'Active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `companies`
--

INSERT INTO `companies` (`id`, `name`, `code`, `address_line_one`, `address_line_two`, `city`, `state`, `can_order_any_time`, `start_time`, `end_time`, `start_day`, `end_day`, `discount_percent`, `status`, `created_at`, `updated_at`) VALUES
(2, 'Hello Comapny', '213', 'This is address line one', NULL, 'Dhaka', 'Dhaka', 'No', '01:00:00', '17:00:00', 'Monday', 'Friday', 10.00, 'Active', '2021-06-13 14:01:04', '2021-06-14 08:03:09'),
(3, 'fdafd', '454', 'fadfd', NULL, 'fdaf', 'afdaf', 'Yes', NULL, NULL, NULL, NULL, 1.00, 'Active', '2021-06-13 14:01:56', '2021-06-13 14:01:56'),
(4, 'Comany B', '1250', 'csv', 'This is address line one', 'Dhaka', 'Dhaka', 'No', '01:00:00', '16:00:00', 'Monday', 'Thursday', 2.00, 'Active', '2021-06-13 14:02:22', '2021-06-14 09:48:09'),
(6, 'Test Company', '1510', 'Test address line one', NULL, 'Maxico', 'Maxico', 'No', '07:10:00', '17:30:00', 'Monday', 'Friday', 2.30, 'Active', '2021-06-16 14:22:13', '2021-06-16 14:22:13');

-- --------------------------------------------------------

--
-- Table structure for table `coupons`
--

CREATE TABLE `coupons` (
  `id` bigint(20) NOT NULL,
  `coupon_code` varchar(99) NOT NULL,
  `coupon_discount` decimal(8,2) NOT NULL COMMENT 'in percent %',
  `expire_date` date NOT NULL,
  `number_of_coupon` int(11) DEFAULT NULL COMMENT 'if NULL then unlimited else fix number_of_coupon',
  `coupon_used` int(11) NOT NULL DEFAULT '0' COMMENT 'How many coupons has been used',
  `status` enum('Active','Inactive','Expired') NOT NULL DEFAULT 'Active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `coupons`
--

INSERT INTO `coupons` (`id`, `coupon_code`, `coupon_discount`, `expire_date`, `number_of_coupon`, `coupon_used`, `status`, `created_at`, `updated_at`) VALUES
(1, 'FlashSell21', 5.00, '2021-06-30', NULL, 0, 'Active', '2021-06-16 14:28:22', '2021-06-16 14:28:22');

-- --------------------------------------------------------

--
-- Table structure for table `customer_addresses`
--

CREATE TABLE `customer_addresses` (
  `id` bigint(20) NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL COMMENT 'Customer ID in users tbl',
  `nick_name` varchar(99) NOT NULL COMMENT 'should be unique for corresponded user/customer',
  `mobile_number` bigint(20) NOT NULL,
  `address_line_1` varchar(255) NOT NULL,
  `address_line_2` varchar(255) DEFAULT NULL,
  `city` varchar(99) NOT NULL,
  `post_code` varchar(99) NOT NULL,
  `note` text,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `customer_addresses`
--

INSERT INTO `customer_addresses` (`id`, `user_id`, `nick_name`, `mobile_number`, `address_line_1`, `address_line_2`, `city`, `post_code`, `note`, `created_at`, `updated_at`) VALUES
(1, 4, 'test1', 1230123585, 'DH/12, DMCC, Baddha', NULL, 'Dhaka', '12500', 'This is one of my local address, so please delivery here politely.<br /><br /><br />\r\nThanks', '2021-05-26 20:29:59', '2021-06-28 01:36:16');

-- --------------------------------------------------------

--
-- Table structure for table `delivery_charges`
--

CREATE TABLE `delivery_charges` (
  `id` bigint(20) NOT NULL,
  `type` enum('General','AreaWise') NOT NULL DEFAULT 'General',
  `charge_amount` decimal(8,2) NOT NULL DEFAULT '0.00',
  `status` enum('Active','Inactive') NOT NULL DEFAULT 'Active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `delivery_charges`
--

INSERT INTO `delivery_charges` (`id`, `type`, `charge_amount`, `status`, `created_at`, `updated_at`) VALUES
(1, 'General', 5.03, 'Inactive', '2021-05-25 11:50:12', '2021-05-26 14:54:19');

-- --------------------------------------------------------

--
-- Table structure for table `designations`
--

CREATE TABLE `designations` (
  `id` bigint(20) NOT NULL,
  `title` varchar(99) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `designations`
--

INSERT INTO `designations` (`id`, `title`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Bus Drivers', '2021-06-01 01:56:23', '2021-06-01 02:03:31', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `id` bigint(20) NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `feedback`
--

INSERT INTO `feedback` (`id`, `user_id`, `product_id`, `created_at`, `updated_at`) VALUES
(1, 4, 5, '2021-05-26 20:28:18', '2021-05-26 20:28:18'),
(2, 4, 12, '2021-06-03 16:24:30', '2021-06-03 16:24:30');

-- --------------------------------------------------------

--
-- Table structure for table `frontend_u_i_s`
--

CREATE TABLE `frontend_u_i_s` (
  `id` int(11) NOT NULL,
  `app_logo` varchar(255) NOT NULL,
  `app_title` varchar(255) NOT NULL,
  `home_banner_title` varchar(255) DEFAULT NULL,
  `home_banner_title_color` varchar(255) DEFAULT NULL,
  `home_banner_description` varchar(255) DEFAULT NULL,
  `home_banner_description_color` varchar(255) DEFAULT NULL,
  `search_box_bg_color` varchar(255) NOT NULL,
  `search_box_text` varchar(255) NOT NULL,
  `search_box_text_color` varchar(255) NOT NULL,
  `search_button_text` varchar(255) NOT NULL,
  `search_button_text_color` varchar(255) NOT NULL,
  `search_button_bg_color` varchar(255) NOT NULL,
  `easy_2_step_left_title` varchar(255) NOT NULL,
  `easy_2_step_left_title_color` varchar(255) NOT NULL,
  `easy_2_step_left_description` varchar(255) NOT NULL,
  `easy_2_step_left_description_color` varchar(255) NOT NULL,
  `easy_2_step_right_title` varchar(255) NOT NULL,
  `easy_2_step_right_title_color` varchar(255) NOT NULL,
  `easy_2_step_right_description` varchar(255) NOT NULL,
  `easy_2_step_right_description_color` varchar(255) NOT NULL,
  `easy_2_step_small_text` varchar(255) NOT NULL,
  `app_section_bg_color` varchar(255) NOT NULL,
  `app_section_title` varchar(255) NOT NULL,
  `app_section_title_color` varchar(255) NOT NULL,
  `app_section_description` varchar(255) NOT NULL,
  `app_section_description_color` varchar(255) NOT NULL,
  `play_store_app_link` varchar(255) DEFAULT NULL,
  `apple_app_link` varchar(255) DEFAULT NULL,
  `footer_bg_color` varchar(255) NOT NULL,
  `facebook_url` varchar(255) DEFAULT NULL,
  `twitter_url` varchar(255) DEFAULT NULL,
  `linkedIn_url` varchar(255) DEFAULT NULL,
  `youtube_url` varchar(255) DEFAULT NULL,
  `instagram_url` varchar(255) DEFAULT NULL,
  `singin_image` varchar(255) NOT NULL,
  `signup_image` varchar(255) NOT NULL,
  `reservation_image` varchar(255) NOT NULL,
  `contact_email` varchar(255) NOT NULL,
  `contact_phone` varchar(20) NOT NULL,
  `contact_address` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `frontend_u_i_s`
--

INSERT INTO `frontend_u_i_s` (`id`, `app_logo`, `app_title`, `home_banner_title`, `home_banner_title_color`, `home_banner_description`, `home_banner_description_color`, `search_box_bg_color`, `search_box_text`, `search_box_text_color`, `search_button_text`, `search_button_text_color`, `search_button_bg_color`, `easy_2_step_left_title`, `easy_2_step_left_title_color`, `easy_2_step_left_description`, `easy_2_step_left_description_color`, `easy_2_step_right_title`, `easy_2_step_right_title_color`, `easy_2_step_right_description`, `easy_2_step_right_description_color`, `easy_2_step_small_text`, `app_section_bg_color`, `app_section_title`, `app_section_title_color`, `app_section_description`, `app_section_description_color`, `play_store_app_link`, `apple_app_link`, `footer_bg_color`, `facebook_url`, `twitter_url`, `linkedIn_url`, `youtube_url`, `instagram_url`, `singin_image`, `signup_image`, `reservation_image`, `contact_email`, `contact_phone`, `contact_address`, `created_at`, `updated_at`) VALUES
(1, 'app_logo.png', 'Food Pluk', 'Order Delivery & Take-Out', '#ffffff', 'Find Restaurants, Specials, and coupons for free', '#ffffff', '#ffffff', 'Search post code', '#666666', 'Feed Me', '#ffffff', '#dc4e1c', 'Choose a tasty dish', '#ffffff', 'We’ve got your covered wuth menus from over 345 delivery restaurants online.', '#ffffff', 'Pick up or Delivery', '#f7f7f7', 'Get your food delivered! And enjoy your meal! Pay online on pickup or delivery', '#ffffff', 'Pay by Cash on delivery, Card or PayPal', '#e8500e', 'The Best Foot Delivery App', '#fafafa', 'Now you can make food happen pretty much wherever you are thanks to the free easy-to-use Food Delivery & Takeout App', '#fafafa', 'https://paly.google.com', 'https://apple.apple.com', '#252a33', 'https://www.facebook.com', 'https://www.twitter.com', 'https://www.linkedin.com', 'https://www.youtube.com', 'https://www.instagram.com', 'singin_image.png', 'signup_image.png', 'reservation_image.png', 'contact@demo.com', '+123 1780 32 44 82', 'DS-29, London ##, , United Kingdom ##, 2311', '2021-05-18 02:42:44', '2021-06-26 23:48:54');

-- --------------------------------------------------------

--
-- Table structure for table `home_contents`
--

CREATE TABLE `home_contents` (
  `id` int(11) NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `order_by` enum('Latest','Oldest','Random') NOT NULL DEFAULT 'Latest',
  `position_no` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `home_contents`
--

INSERT INTO `home_contents` (`id`, `category_id`, `order_by`, `position_no`, `created_at`, `updated_at`) VALUES
(1, 1, 'Random', 1, '2021-05-18 03:54:22', '2021-05-19 08:22:01'),
(2, 2, 'Random', 2, '2021-05-18 03:54:22', '2021-05-19 08:22:01'),
(3, 3, 'Oldest', 3, '2021-05-18 03:54:22', '2021-05-19 08:22:01');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `type` enum('Authenticate','NonAuthenticate') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Authenticate',
  `for` enum('admin','user') COLLATE utf8mb4_unicode_ci NOT NULL,
  `notification_from` enum('User','Guest','Admin') COLLATE utf8mb4_unicode_ci DEFAULT 'Admin',
  `to_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `message` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `url` text COLLATE utf8mb4_unicode_ci,
  `status` tinyint(4) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `notification_settings`
--

CREATE TABLE `notification_settings` (
  `id` int(11) NOT NULL,
  `type` enum('orders') NOT NULL DEFAULT 'orders',
  `context` enum('Cancelled','In Progress','Out For Delivery','Completed') NOT NULL,
  `notification_mode` enum('Email','Phone','Both','No') NOT NULL DEFAULT 'Email',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `notification_settings`
--

INSERT INTO `notification_settings` (`id`, `type`, `context`, `notification_mode`, `created_at`, `updated_at`) VALUES
(1, 'orders', 'In Progress', 'Both', NULL, '2021-06-03 10:05:42'),
(2, 'orders', 'Out For Delivery', 'Phone', NULL, '2021-06-03 10:06:44'),
(3, 'orders', 'Completed', 'Email', NULL, NULL),
(4, 'orders', 'Cancelled', 'No', NULL, '2021-06-03 10:06:50');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) NOT NULL,
  `order_by` enum('Customer','Staff') NOT NULL DEFAULT 'Customer',
  `order_id` bigint(20) DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL COMMENT 'Customer ID from users tbl',
  `order_data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `address_data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `payment_type` enum('PAID','COD','CREDIT BALANCE') NOT NULL DEFAULT 'PAID' COMMENT 'COD=Cash on Delivery | Paid=Paid through online payment gateway',
  `payment_method` enum('Paypal','Others') DEFAULT NULL,
  `payment_id` bigint(20) UNSIGNED DEFAULT NULL,
  `status` enum('New','Cancelled','In Progress','Out For Delivery','Completed') NOT NULL DEFAULT 'New',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `order_by`, `order_id`, `user_id`, `order_data`, `address_data`, `payment_type`, `payment_method`, `payment_id`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Customer', 14234, 4, '{\"products\":[{\"cart\":{\"id\":2,\"user_id\":4,\"product_id\":5,\"qty\":2},\"product\":{\"id\":5,\"title\":\"Super Cool Group Dinner Party\",\"slug\":\"super-cool-group-dinner-party\",\"image\":\"product-60aefafc303c51622080252.19762760.png\",\"price\":\"155.00\",\"discount_price\":\"5.00\",\"item_discount_percent\":\"0.05\",\"total_amount_multiply_qty\":\"310.00\",\"total_discount_amount\":\"10.00\",\"total_amount_minus_total_dis\":\"300.00\"}},{\"cart\":{\"id\":1,\"user_id\":4,\"product_id\":2,\"qty\":1},\"product\":{\"id\":2,\"title\":\"Dinner Full\",\"slug\":\"dinner-full\",\"image\":\"product-60aefa4059ecc1622080064.36833550.png\",\"price\":\"110.00\",\"discount_price\":\"6.00\",\"item_discount_percent\":\"0.06\",\"total_amount_multiply_qty\":\"110.00\",\"total_discount_amount\":\"6.00\",\"total_amount_minus_total_dis\":\"104.00\"}}],\"summary\":{\"sub_total\":\"404.00\",\"totalItemsDiscountAmount\":11,\"delivery_charge\":{\"charge_amount\":\"Free\"},\"grand_total\":404},\"couponAppliedResponse\":null}', '{\"id\":1,\"user_id\":4,\"nick_name\":\"LocalAddress1\",\"mobile_number\":\"+880 1780 324482\",\"address_line_1\":\"DH\\/12, DMCC, Baddha\",\"address_line_2\":null,\"city\":\"Dhaka\",\"post_code\":\"1250\",\"note\":\"This is one of my local address, so please delivery here politely.<br \\/>\\r\\nThanks\",\"created_at\":\"2021-05-27T02:29:59.000000Z\",\"updated_at\":\"2021-05-27T02:30:11.000000Z\"}', 'COD', NULL, NULL, 'Completed', '2021-05-26 20:38:59', '2021-06-02 16:51:10', NULL),
(2, 'Staff', 27078, 7, '{\"checkout_summary\":{\"products\":[{\"product\":{\"id\":17,\"type\":\"Staff\",\"item_type\":\"Meal\",\"title\":\"This is burger meal\",\"slug\":\"this-is-burger-meal-small\",\"image\":\"product-60b4f8aa10f1f1622472874.06946029.png\",\"price\":\"90.00\",\"discount_price\":\"0.00\",\"item_discount_percent\":null,\"total_amount_multiply_qty\":\"90.00\",\"total_discount_amount\":\"0.00\",\"total_amount_minus_total_dis\":null}}],\"summary\":{\"sub_total\":\"90.00\",\"totalItemsDiscountAmount\":0,\"delivery_charge\":{\"charge_amount\":\"Free\"},\"grand_total\":72},\"couponAppliedResponse\":{\"coupon_discount_type\":\"Special\",\"coupon_discount_percent\":\"20.00\",\"coupon_discount_amount\":18,\"is_applied\":true,\"msg\":\"20.00% Coupon Applied\"}},\"order_processing_data\":{\"delivery_time\":\"Schedule\",\"schedule_date\":\"2021-06-03\",\"schedule_time\":\"16:15\",\"delivery_type\":\"Collection\"}}', '{\"id\":1,\"user_id\":7,\"nick_name\":\"staff_addr_1\",\"mobile_number\":\"01921 267068\",\"address_line_1\":\"This is address line one\",\"address_line_2\":null,\"city\":\"Dhaka\",\"post_code\":\"1650\",\"note\":\"This is my office address\",\"created_at\":\"2021-06-02T08:20:12.000000Z\",\"updated_at\":\"2021-06-02T08:37:50.000000Z\"}', 'COD', NULL, NULL, 'New', '2021-06-02 04:18:49', '2021-06-03 12:00:27', NULL),
(3, 'Staff', 35116, 7, '{\"checkout_summary\":{\"products\":[{\"product\":{\"id\":17,\"type\":\"Staff\",\"item_type\":\"Meal\",\"title\":\"This is burger meal\",\"slug\":\"this-is-burger-meal-small\",\"image\":\"product-60b4f8aa10f1f1622472874.06946029.png\",\"price\":\"90.00\",\"discount_price\":\"0.00\",\"item_discount_percent\":null,\"total_amount_multiply_qty\":\"90.00\",\"total_discount_amount\":\"0.00\",\"total_amount_minus_total_dis\":null}}],\"summary\":{\"sub_total\":\"90.00\",\"totalItemsDiscountAmount\":0,\"delivery_charge\":{\"charge_amount\":\"Free\"},\"grand_total\":72},\"couponAppliedResponse\":{\"coupon_discount_type\":\"Special\",\"coupon_discount_percent\":\"20.00\",\"coupon_discount_amount\":18,\"is_applied\":true,\"msg\":\"20.00% Coupon Applied\"}},\"order_processing_data\":{\"delivery_time\":\"ASAP\",\"schedule_date\":null,\"schedule_time\":null,\"delivery_type\":\"Collection\"}}', '{\"id\":1,\"user_id\":7,\"nick_name\":\"staff_addr_1\",\"mobile_number\":\"01921 267068\",\"address_line_1\":\"This is address line one\",\"address_line_2\":null,\"city\":\"Dhaka\",\"post_code\":\"1650\",\"note\":\"This is my office address\",\"created_at\":\"2021-06-02T08:20:12.000000Z\",\"updated_at\":\"2021-06-02T08:37:50.000000Z\"}', 'CREDIT BALANCE', NULL, NULL, 'In Progress', '2021-06-02 11:10:45', '2021-06-03 13:04:02', NULL),
(4, 'Customer', 41349, 4, '{\"products\":[{\"cart\":{\"id\":4,\"user_id\":4,\"product_id\":10,\"qty\":1},\"product\":{\"id\":10,\"title\":\"Comes Ins Item\",\"slug\":\"comes-ins-item\",\"image\":\"product-60afdbd7e6de11622137815.94568101.png\",\"price\":\"170.00\",\"discount_price\":\"12.00\",\"item_discount_percent\":\"0.12\",\"total_amount_multiply_qty\":\"170.00\",\"total_discount_amount\":\"12.00\",\"total_amount_minus_total_dis\":\"158.00\"}}],\"summary\":{\"sub_total\":\"158.00\",\"totalItemsDiscountAmount\":12,\"delivery_charge\":{\"charge_amount\":\"Free\"},\"grand_total\":158},\"couponAppliedResponse\":null}', '{\"id\":1,\"user_id\":4,\"nick_name\":\"test1\",\"mobile_number\":\"+880 1780 324482\",\"address_line_1\":\"DH\\/12, DMCC, Baddha\",\"address_line_2\":null,\"city\":\"Dhaka\",\"post_code\":\"12500\",\"note\":\"This is one of my local address, so please delivery here politely.<br \\/><br \\/>\\r\\nThanks\",\"created_at\":\"2021-05-27T02:29:59.000000Z\",\"updated_at\":\"2021-06-03T22:26:44.000000Z\"}', 'COD', NULL, NULL, 'New', '2021-06-03 16:32:18', '2021-06-03 16:32:18', NULL),
(5, 'Staff', 56245, 11, '{\"checkout_summary\":{\"products\":[{\"product\":{\"id\":17,\"type\":\"Staff\",\"item_type\":\"Meal\",\"title\":\"This is burger meal\",\"slug\":\"this-is-burger-meal-small-1\",\"image\":\"product-60b4f8aa10f1f1622472874.06946029.png\",\"price\":\"90.00\",\"discount_price\":\"0.00\",\"item_discount_percent\":null,\"total_amount_multiply_qty\":\"90.00\",\"total_discount_amount\":\"0.00\",\"total_amount_minus_total_dis\":null}}],\"summary\":{\"sub_total\":\"90.00\",\"totalItemsDiscountAmount\":0,\"delivery_charge\":{\"charge_amount\":\"Free\"},\"grand_total\":90},\"couponAppliedResponse\":null},\"order_processing_data\":{\"delivery_time\":\"Schedule\",\"schedule_date\":\"2021-06-08\",\"schedule_time\":\"08:10\",\"delivery_type\":\"Delivery\"}}', '{\"id\":2,\"user_id\":11,\"nick_name\":\"MyShAddress\",\"mobile_number\":1234567891,\"address_line_1\":\"This is address line one\",\"address_line_2\":null,\"city\":\"Dhaka\",\"post_code\":\"Dhaka\",\"note\":\"Coupon Me\",\"created_at\":\"2021-06-04T01:11:27.000000Z\",\"updated_at\":\"2021-06-04T01:11:27.000000Z\"}', 'COD', NULL, NULL, 'New', '2021-06-04 01:11:50', '2021-06-04 01:11:50', NULL),
(6, 'Customer', 62376, 4, '{\"products\":[{\"cart\":{\"id\":8,\"user_id\":4,\"product_id\":8,\"qty\":1},\"product\":{\"id\":8,\"title\":\"Heavy food healthy died !\",\"slug\":\"heavy-food-healthy-died\",\"image\":\"product-60afdb4c59a421622137676.36724404.jpg\",\"price\":\"55.00\",\"discount_price\":\"3.00\",\"item_discount_percent\":\"0.03\",\"total_amount_multiply_qty\":\"55.00\",\"total_discount_amount\":\"3.00\",\"total_amount_minus_total_dis\":\"52.00\"}}],\"summary\":{\"sub_total\":\"52.00\",\"totalItemsDiscountAmount\":3,\"delivery_charge\":{\"charge_amount\":\"Free\"},\"grand_total\":52},\"couponAppliedResponse\":null}', '{\"id\":1,\"user_id\":4,\"nick_name\":\"test1\",\"mobile_number\":1230123585,\"address_line_1\":\"DH\\/12, DMCC, Baddha\",\"address_line_2\":null,\"city\":\"Dhaka\",\"post_code\":\"12500\",\"note\":\"This is one of my local address, so please delivery here politely.<br \\/><br \\/>\\r\\nThanks\",\"created_at\":\"2021-05-27T01:29:59.000000Z\",\"updated_at\":\"2021-06-03T21:26:44.000000Z\"}', 'COD', NULL, NULL, 'New', '2021-06-10 12:47:48', '2021-06-10 12:47:48', NULL),
(7, 'Customer', 76995, 4, '{\"products\":[{\"cart\":{\"id\":9,\"user_id\":4,\"product_id\":5,\"qty\":1},\"product\":{\"id\":5,\"title\":\"Super Cool Group Dinner Party\",\"slug\":\"super-cool-group-dinner-party\",\"image\":\"product-60aefafc303c51622080252.19762760.png\",\"price\":\"155.00\",\"discount_price\":\"5.00\",\"item_discount_percent\":\"0.05\",\"total_amount_multiply_qty\":\"155.00\",\"total_discount_amount\":\"5.00\",\"total_amount_minus_total_dis\":\"150.00\"}}],\"summary\":{\"sub_total\":\"150.00\",\"totalItemsDiscountAmount\":5,\"delivery_charge\":{\"charge_amount\":\"Free\"},\"grand_total\":150},\"couponAppliedResponse\":null}', '{\"id\":1,\"user_id\":4,\"nick_name\":\"test1\",\"mobile_number\":1230123585,\"address_line_1\":\"DH\\/12, DMCC, Baddha\",\"address_line_2\":null,\"city\":\"Dhaka\",\"post_code\":\"12500\",\"note\":\"This is one of my local address, so please delivery here politely.<br \\/><br \\/>\\r\\nThanks\",\"created_at\":\"2021-05-27T01:29:59.000000Z\",\"updated_at\":\"2021-06-03T21:26:44.000000Z\"}', 'COD', NULL, NULL, 'New', '2021-06-16 14:41:23', '2021-06-16 14:41:23', NULL),
(8, 'Customer', 86160, 4, '{\"products\":[{\"cart\":{\"id\":12,\"user_id\":4,\"product_id\":15,\"qty\":1},\"product\":{\"id\":15,\"title\":\"HelloProduct\",\"slug\":\"helloproduct-1\",\"image\":\"product-60b3afd4c0d881622388692.78997219.jpg\",\"price\":\"150.00\",\"discount_price\":\"10.00\",\"item_discount_percent\":\"0.10\",\"total_amount_multiply_qty\":\"150.00\",\"total_discount_amount\":\"10.00\",\"total_amount_minus_total_dis\":\"140.00\"}},{\"cart\":{\"id\":11,\"user_id\":4,\"product_id\":16,\"qty\":3},\"product\":{\"id\":16,\"title\":\"Nice Burger\",\"slug\":\"nice-burger-small\",\"image\":\"product-60b3b28a761001622389386.4836550.png\",\"price\":\"190.00\",\"discount_price\":\"15.00\",\"item_discount_percent\":\"0.15\",\"total_amount_multiply_qty\":\"570.00\",\"total_discount_amount\":\"45.00\",\"total_amount_minus_total_dis\":\"525.00\"}},{\"cart\":{\"id\":10,\"user_id\":4,\"product_id\":18,\"qty\":1},\"product\":{\"id\":18,\"title\":\"Test Item\",\"slug\":\"test-item-large\",\"image\":\"product-60d5e62de06791624630829.91929696.jpg\",\"price\":\"10.00\",\"discount_price\":\"2.00\",\"item_discount_percent\":\"0.02\",\"total_amount_multiply_qty\":\"10.00\",\"total_discount_amount\":\"2.00\",\"total_amount_minus_total_dis\":\"8.00\"}}],\"summary\":{\"sub_total\":\"673.00\",\"totalItemsDiscountAmount\":27,\"delivery_charge\":{\"charge_amount\":\"Free\"},\"grand_total\":673},\"couponAppliedResponse\":null}', '{\"id\":1,\"user_id\":4,\"nick_name\":\"test1\",\"mobile_number\":1230123585,\"address_line_1\":\"DH\\/12, DMCC, Baddha\",\"address_line_2\":null,\"city\":\"Dhaka\",\"post_code\":\"12500\",\"note\":\"This is one of my local address, so please delivery here politely.<br \\/><br \\/><br \\/>\\r\\nThanks\",\"created_at\":\"2021-05-26T14:29:59.000000Z\",\"updated_at\":\"2021-06-27T19:36:16.000000Z\"}', 'COD', NULL, NULL, 'New', '2021-06-28 01:39:46', '2021-06-28 01:39:46', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_options`
--

CREATE TABLE `password_reset_options` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `type` enum('Customer','Admin','KitchenStaff','Staff') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Customer',
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` bigint(20) NOT NULL,
  `paid_for` enum('ORDER','CREDIT') NOT NULL DEFAULT 'ORDER',
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `payment_method` enum('Paypal') NOT NULL DEFAULT 'Paypal',
  `paid_amount` decimal(8,2) NOT NULL,
  `payer_name` varchar(255) NOT NULL,
  `payer_email` varchar(255) NOT NULL,
  `paypal_transaction_id` varchar(255) NOT NULL,
  `payer_country` varchar(255) NOT NULL,
  `status` enum('COMPLETED','CANCELLED') NOT NULL DEFAULT 'COMPLETED',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`id`, `paid_for`, `user_id`, `payment_method`, `paid_amount`, `payer_name`, `payer_email`, `paypal_transaction_id`, `payer_country`, `status`, `created_at`, `updated_at`) VALUES
(2, 'CREDIT', 7, 'Paypal', 50.00, 'Test', 'test@credit.com', 'test-credit-trn-id4337', 'USA', 'COMPLETED', '2021-06-02 06:52:58', '2021-06-02 06:52:58'),
(3, 'CREDIT', 7, 'Paypal', 90.00, 'Test', 'test@credit.com', 'test-credit-trn-id5405', 'USA', 'COMPLETED', '2021-06-02 06:53:26', '2021-06-02 06:53:26');

-- --------------------------------------------------------

--
-- Table structure for table `payment_gateways`
--

CREATE TABLE `payment_gateways` (
  `id` bigint(20) NOT NULL,
  `gateway` enum('Paypal') NOT NULL,
  `client_id` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `payment_gateways`
--

INSERT INTO `payment_gateways` (`id`, `gateway`, `client_id`, `created_at`, `updated_at`) VALUES
(1, 'Paypal', 'AXY6xMbstES-33nv8sq3QAcg6TUCnlsV_1bPaqqOWhFMBULJdDrhNujLzGP-8x5bgiEybFHrfeYVV1j6', '2021-04-30 05:45:03', '2021-04-30 05:45:03');

-- --------------------------------------------------------

--
-- Table structure for table `post_code`
--

CREATE TABLE `post_code` (
  `id` bigint(20) NOT NULL,
  `post_code` varchar(99) NOT NULL COMMENT 'Base post code',
  `radius_distance_km` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `post_code`
--

INSERT INTO `post_code` (`id`, `post_code`, `radius_distance_km`, `created_at`, `updated_at`) VALUES
(1, '12 B', 100, '2021-06-01 03:53:42', '2021-06-01 03:57:56');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint(20) NOT NULL,
  `type` enum('Main','Staff') NOT NULL DEFAULT 'Main',
  `item_type` enum('Product','Meal') NOT NULL DEFAULT 'Product',
  `product_id` bigint(20) DEFAULT NULL COMMENT 'Product ID so that customers can track using this ID',
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(99) NOT NULL,
  `slug` varchar(99) NOT NULL,
  `description` text NOT NULL,
  `price` decimal(8,2) NOT NULL,
  `discount_price` decimal(8,2) NOT NULL DEFAULT '0.00',
  `images` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `field_names` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `field_values` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `options` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `size` enum('large','small') NOT NULL,
  `note` text,
  `total_feedback` bigint(20) NOT NULL DEFAULT '0',
  `status` enum('Active','Inactive') NOT NULL DEFAULT 'Active',
  `stock_status` enum('Sold Out','Available') NOT NULL DEFAULT 'Available',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `type`, `item_type`, `product_id`, `category_id`, `title`, `slug`, `description`, `price`, `discount_price`, `images`, `field_names`, `field_values`, `options`, `size`, `note`, `total_feedback`, `status`, `stock_status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Main', 'Product', 30481, 2, 'Chickens Fri - Item 1', 'chickens-fri-item-1', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.\r\n\r\nLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', 40.00, 4.00, '[\"product-60aefa193ab651622080025.24059425.png\",\"product-60aefa193dd271622080025.25326941.png\",\"product-60aefa193e2411622080025.25459663.jpg\"]', NULL, NULL, NULL, 'large', NULL, 0, 'Active', 'Sold Out', '2021-05-26 19:47:05', '2021-05-26 19:47:05', NULL),
(2, 'Main', 'Product', 81622, 1, 'Dinner Full', 'dinner-full', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.\r\n\r\nLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.\r\n\r\nLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', 110.00, 6.00, '[\"product-60aefa4059ecc1622080064.36833550.png\",\"product-60aefa405a24f1622080064.36924392.jpg\"]', NULL, NULL, NULL, 'large', NULL, 0, 'Active', 'Sold Out', '2021-05-26 19:47:44', '2021-05-26 19:47:44', NULL),
(3, 'Main', 'Product', 65263, 5, 'Sugo Help Vegetables Burger', 'sugo-help-vegetables-burger', 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).\r\n\r\nIt is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).', 70.00, 0.00, '[\"product-60aefa75dd42f1622080117.90638415.png\",\"product-60aefa75dd7f41622080117.90739437.jpg\"]', NULL, NULL, NULL, 'large', NULL, 0, 'Active', 'Available', '2021-05-26 19:48:37', '2021-05-26 19:48:37', NULL),
(4, 'Main', 'Product', 60554, 1, 'Dinner Dimuon Item', 'dinner-dimuon-item', 'Dinner Dimuon Item It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).\r\n\r\nIt is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).\r\n\r\nDinner Dimuon Item It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).\r\n\r\nIt is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).', 170.00, 12.00, '[\"product-60aefacce50f91622080204.93824877.png\",\"product-60aefacce59701622080204.94052057.jpg\",\"product-60aefacce5cae1622080204.9412958.jpg\"]', NULL, NULL, NULL, 'large', 'Hello Note', 0, 'Active', 'Available', '2021-05-26 19:50:04', '2021-05-26 19:50:05', NULL),
(5, 'Main', 'Product', 38535, 1, 'Super Cool Group Dinner Party', 'super-cool-group-dinner-party', 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).\r\n\r\nIt is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).', 155.00, 5.00, '[\"product-60aefafc303c51622080252.19762760.png\",\"product-60aefafc307fb1622080252.19873478.jpg\"]', NULL, NULL, NULL, 'large', NULL, 1, 'Active', 'Available', '2021-05-26 19:50:52', '2021-05-26 20:28:18', NULL),
(6, 'Main', 'Product', 60536, 5, 'Night Food', 'night-food', 'This is burger night food items', 190.00, 0.00, '[\"product-60afdaee34dd01622137582.21654665.png\"]', NULL, NULL, NULL, 'large', NULL, 0, 'Active', 'Available', '2021-05-27 11:46:22', '2021-05-27 11:46:22', NULL),
(7, 'Main', 'Product', 9137, 2, 'Holy Food', 'holy-food', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.\r\n\r\nLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', 35.00, 7.00, '[\"product-60afdb2423d7f1622137636.14686098.png\",\"product-60afdb242482a1622137636.14961034.jpg\"]', NULL, NULL, NULL, 'large', NULL, 0, 'Active', 'Available', '2021-05-27 11:47:16', '2021-05-27 11:47:16', NULL),
(8, 'Main', 'Product', 80828, 1, 'Heavy food healthy died !', 'heavy-food-healthy-died', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.\r\n\r\nLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', 55.00, 3.00, '[\"product-60afdb4c59a421622137676.36724404.jpg\",\"product-60afdb4c59e361622137676.36828853.jpg\"]', NULL, NULL, NULL, 'large', NULL, 0, 'Active', 'Available', '2021-05-27 11:47:56', '2021-05-27 11:47:56', NULL),
(9, 'Main', 'Product', 71309, 2, 'OneTime life hack item', 'onetime-life-hack-item', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.\r\n\r\nLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', 16.00, 2.00, '[\"product-60afdb98dccd61622137752.9044404.png\",\"product-60afdb98dd1621622137752.90561889.jpg\",\"product-60afdb98dd4121622137752.90635232.jpg\"]', NULL, NULL, NULL, 'large', NULL, 0, 'Active', 'Available', '2021-05-27 11:49:12', '2021-05-27 11:49:12', NULL),
(10, 'Main', 'Product', 431910, 1, 'Comes Ins Item', 'comes-ins-item', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.\r\n\r\nLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', 170.00, 12.00, '[\"product-60afdbd7e6de11622137815.94568101.png\",\"product-60afdbd7e71c61622137815.94662302.jpg\",\"product-60afdbd7e74ee1622137815.94748062.jpg\"]', NULL, NULL, NULL, 'large', NULL, 0, 'Active', 'Available', '2021-05-27 11:50:15', '2021-05-27 11:50:15', NULL),
(11, 'Main', 'Product', 396711, 5, 'Roast Chickens', 'roast-chickens', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.\r\n\r\nLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', 90.00, 0.00, '[\"product-60afdc69c00681622137961.78653402.png\",\"product-60afdc69c053e1622137961.78784591.jpg\"]', NULL, NULL, NULL, 'large', NULL, 0, 'Active', 'Available', '2021-05-27 11:52:41', '2021-05-27 11:52:41', NULL),
(12, 'Main', 'Product', 43012, 2, 'Google Iem', 'google-iem', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.\r\n\r\nLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', 65.00, 15.00, '[\"product-60afdc83612191622137987.39794634.png\",\"product-60afdc83616231622137987.39894525.jpg\"]', NULL, NULL, NULL, 'large', NULL, 1, 'Active', 'Sold Out', '2021-05-27 11:53:07', '2021-06-03 16:24:30', NULL),
(13, 'Main', 'Product', 213513, 2, 'Hot Fry - Yammy', 'hot-fry-yammy', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.\r\n\r\nLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', 190.00, 18.00, '[\"product-60afdca0d9fc01622138016.89291319.png\",\"product-60afdca0da39a1622138016.89396803.jpg\"]', NULL, NULL, NULL, 'large', NULL, 0, 'Active', 'Sold Out', '2021-05-27 11:53:36', '2021-06-03 12:51:48', NULL),
(14, 'Main', 'Product', 699414, 5, 'Test product', 'test-product', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.\r\n\r\nLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', 100.00, 10.00, '[\"product-60b3a4dfd4ba91622385887.87131039.jpg\",\"product-60b3a4dfd6e351622385887.88022515.png\"]', '[\"Vitamin\",\"Minerals\"]', '[\"Cool\",\"10%\"]', NULL, 'large', NULL, 0, 'Active', 'Available', '2021-05-30 08:44:47', '2021-05-30 08:53:53', NULL),
(15, 'Main', 'Product', 313515, 5, 'HelloProduct', 'helloproduct-1', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.\r\n\r\nLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', 150.00, 10.00, '[\"product-60b3afd4c0d881622388692.78997219.jpg\",\"product-60b3afd4c11cc1622388692.7915318.jpg\"]', '[\"Suger\",\"Vitamin\",\"Mineral\"]', '[\"0%\",\"D\",\"10%\"]', NULL, 'large', 'This is test note about this product update', 0, 'Active', 'Available', '2021-05-30 09:31:32', '2021-05-30 09:36:24', NULL),
(16, 'Main', 'Product', 554116, 5, 'Nice Burger', 'nice-burger-small', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.\r\n\r\nLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', 190.00, 15.00, '[\"product-60b3b28a761001622389386.4836550.png\",\"product-60b3b28a7655b1622389386.48477944.png\"]', '[\"Menerials\"]', '[\"10%\"]', NULL, 'small', 'Good food - good life', 0, 'Active', 'Available', '2021-05-30 09:43:06', '2021-05-30 09:43:06', NULL),
(17, 'Staff', 'Meal', 649417, 6, 'This is burger meal', 'this-is-burger-meal-small-1', 'This is burger meal This is burger meal This is burger meal This is burger meal This is burger meal This is burger meal This is burger meal This is burger meal This is burger meal This is burger meal This is burger meal This is burger meal This is burger meal This is burger meal This is burger meal This is burger meal This is burger meal This is burger meal This is burger meal This is burger meal This is burger meal This is burger meal This is burger meal This is burger meal \r\n\r\nThis is burger meal This is burger meal This is burger meal This is burger meal This is burger meal This is burger meal This is burger meal This is burger meal This is burger meal This is burger meal This is burger meal This is burger meal \r\n\r\nThis is burger meal This is burger meal This is burger meal This is burger meal This is burger meal This is burger meal This is burger meal This is burger meal This is burger meal This is burger meal This is burger meal This is burger meal', 90.00, 0.00, '[\"product-60b4f8aa10f1f1622472874.06946029.png\"]', '[\"Vitam\",\"Minal\",\"Diet Quality\"]', '[\"10%\",\"10%\",\"100%\"]', NULL, 'small', 'This is small size menu', 0, 'Active', 'Available', '2021-05-31 08:54:34', '2021-06-16 14:10:51', NULL),
(18, 'Main', 'Product', 953218, 2, 'Test Item', 'test-item-large', 'This is cox', 10.00, 2.00, '[\"product-60d5e62de06791624630829.91929696.jpg\",\"product-60d5e62de60131624630829.94219280.jpg\",\"product-60d5e62de63cd1624630829.94319984.jpg\"]', '[\"Vitam\",\"Mineral\"]', '[\"1%\",\"Minimal\"]', '[{\"label\":\"You like?\",\"option_type\":\"Single\",\"fields\":{\"1\":{\"option_name\":\"Beaf\",\"extra_charge\":\"2\"},\"2\":{\"option_name\":\"Mutton\",\"extra_charge\":\"3\"}}},{\"label\":\"Your rights?\",\"option_type\":\"Multi\",\"fields\":{\"3\":{\"option_name\":\"Vegitable\",\"extra_charge\":\"6\"},\"4\":{\"option_name\":\"Goulfs\",\"extra_charge\":null}}}]', 'large', 'This is test note', 0, 'Active', 'Available', '2021-06-25 09:20:29', '2021-06-25 09:20:30', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `sliders`
--

CREATE TABLE `sliders` (
  `id` int(11) NOT NULL,
  `image` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `sliders`
--

INSERT INTO `sliders` (`id`, `image`, `created_at`, `updated_at`) VALUES
(4, '60b393c2180896949.jpg', '2021-05-30 07:31:46', '2021-05-30 07:31:46'),
(5, '60b393cdda12f3001.png', '2021-05-30 07:31:57', '2021-05-30 07:31:57');

-- --------------------------------------------------------

--
-- Table structure for table `staff_addresses`
--

CREATE TABLE `staff_addresses` (
  `id` bigint(20) NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL COMMENT 'staff id of users tbl',
  `nick_name` varchar(99) NOT NULL COMMENT 'should be unique for corresponded user/staff',
  `mobile_number` bigint(20) NOT NULL,
  `address_line_1` varchar(255) NOT NULL,
  `address_line_2` varchar(255) DEFAULT NULL,
  `city` varchar(99) NOT NULL,
  `post_code` varchar(99) NOT NULL,
  `note` text,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `staff_addresses`
--

INSERT INTO `staff_addresses` (`id`, `user_id`, `nick_name`, `mobile_number`, `address_line_1`, `address_line_2`, `city`, `post_code`, `note`, `created_at`, `updated_at`) VALUES
(1, 7, 'staff_addr_1', 1921001010, 'This is address line one', NULL, 'Dhaka', '1650', 'This is my office address', '2021-06-02 02:20:12', '2021-06-02 02:37:50'),
(2, 11, 'MyShAddress', 1234567891, 'This is address line one', NULL, 'Dhaka', 'Dhaka', 'Coupon Me', '2021-06-04 01:11:27', '2021-06-04 01:11:27');

-- --------------------------------------------------------

--
-- Table structure for table `staff_allowed_delivery_orders`
--

CREATE TABLE `staff_allowed_delivery_orders` (
  `id` bigint(20) NOT NULL,
  `code` varchar(99) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `staff_allowed_delivery_orders`
--

INSERT INTO `staff_allowed_delivery_orders` (`id`, `code`, `created_at`, `updated_at`) VALUES
(1, '3201', '2021-06-03 08:35:25', '2021-06-03 08:35:25');

-- --------------------------------------------------------

--
-- Table structure for table `staff_batch_coupons`
--

CREATE TABLE `staff_batch_coupons` (
  `id` bigint(20) NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL COMMENT 'Staff ID from users tbl',
  `total_coupons` int(11) NOT NULL DEFAULT '0',
  `remaining_coupons` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `staff_batch_coupons`
--

INSERT INTO `staff_batch_coupons` (`id`, `user_id`, `total_coupons`, `remaining_coupons`, `created_at`, `updated_at`) VALUES
(2, 6, 20, 20, '2021-06-01 05:43:44', NULL),
(3, 7, 10, 6, '2021-06-01 06:06:59', '2021-06-02 11:10:45'),
(4, 10, 20, 20, '2021-06-16 14:18:11', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `staff_credits`
--

CREATE TABLE `staff_credits` (
  `id` bigint(20) NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL COMMENT 'Staff ID from users tbl',
  `total_balance` decimal(8,2) NOT NULL DEFAULT '0.00',
  `remaining_balance` decimal(8,2) NOT NULL DEFAULT '0.00',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `staff_credits`
--

INSERT INTO `staff_credits` (`id`, `user_id`, `total_balance`, `remaining_balance`, `created_at`, `updated_at`) VALUES
(1, 7, 140.00, 68.00, '2021-06-02 06:52:58', '2021-06-02 11:10:45');

-- --------------------------------------------------------

--
-- Table structure for table `staff_invitations`
--

CREATE TABLE `staff_invitations` (
  `id` bigint(20) NOT NULL,
  `name` varchar(255) NOT NULL,
  `staff_id` varchar(99) DEFAULT NULL,
  `email` varchar(99) DEFAULT NULL,
  `designation` varchar(255) DEFAULT NULL,
  `status` enum('Pending','Accepted') NOT NULL DEFAULT 'Pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `staff_invitations`
--

INSERT INTO `staff_invitations` (`id`, `name`, `staff_id`, `email`, `designation`, `status`, `created_at`, `updated_at`) VALUES
(3, 'Kamrul', '3530', 'kamrul@yopmail.com', 'Bus Drivers', 'Accepted', '2021-05-31 00:47:31', '2021-05-31 05:29:10');

-- --------------------------------------------------------

--
-- Table structure for table `support_tickets`
--

CREATE TABLE `support_tickets` (
  `id` bigint(20) NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `ticket_id` bigint(20) DEFAULT NULL,
  `subject` varchar(255) NOT NULL,
  `status` enum('Open','Closed') NOT NULL DEFAULT 'Open',
  `closed_by` bigint(20) DEFAULT NULL COMMENT 'Ticket Closed by - users tbl ID',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `support_tickets`
--

INSERT INTO `support_tickets` (`id`, `user_id`, `ticket_id`, `subject`, `status`, `closed_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(3, 4, 4443, 'Test Support', 'Closed', 4, '2021-06-11 10:29:46', '2021-06-16 14:37:56', NULL),
(4, 4, 8554, 'Hi Man', 'Closed', 4, '2021-06-11 13:35:39', '2021-06-11 13:37:29', NULL),
(5, 12, 2745, 'Need Help', 'Open', NULL, '2021-06-12 04:08:02', '2021-06-12 04:08:02', NULL),
(6, 4, 9226, 'i just made an order, can you please help me', 'Open', NULL, '2021-06-28 01:40:56', '2021-06-28 01:40:56', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `s_m_s_send_logs`
--

CREATE TABLE `s_m_s_send_logs` (
  `id` bigint(20) NOT NULL,
  `type` enum('OrderNotification') NOT NULL DEFAULT 'OrderNotification',
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `response` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `s_m_s_send_logs`
--

INSERT INTO `s_m_s_send_logs` (`id`, `type`, `user_id`, `response`, `created_at`, `updated_at`) VALUES
(1, 'OrderNotification', 7, '\"{\\\"count\\\":1,\\\"originator\\\":\\\"VoodooSMS\\\",\\\"body\\\":\\\"Your order is now In Progress. Order ID : #35116\\\",\\\"scheduledDateTime\\\":null,\\\"credits\\\":1,\\\"balance\\\":222,\\\"messages\\\":[{\\\"id\\\":null,\\\"recipient\\\":447133875699,\\\"reference\\\":null,\\\"status\\\":\\\"SANDBOX\\\"}]}\"', '2021-06-03 11:44:27', NULL),
(2, 'OrderNotification', 7, '\"{\\\"count\\\":1,\\\"originator\\\":\\\"VoodooSMS\\\",\\\"body\\\":\\\"Your order is now Out For Delivery. Order ID : #27078\\\",\\\"scheduledDateTime\\\":null,\\\"credits\\\":1,\\\"balance\\\":222,\\\"messages\\\":[{\\\"id\\\":null,\\\"recipient\\\":447133875699,\\\"reference\\\":null,\\\"status\\\":\\\"SANDBOX\\\"}]}\"', '2021-06-03 11:59:38', NULL),
(3, 'OrderNotification', 7, '\"{\\\"count\\\":1,\\\"originator\\\":\\\"VoodooSMS\\\",\\\"body\\\":\\\"Your order is now In Progress. Order ID : #35116\\\",\\\"scheduledDateTime\\\":null,\\\"credits\\\":1,\\\"balance\\\":222,\\\"messages\\\":[{\\\"id\\\":null,\\\"recipient\\\":447133875699,\\\"reference\\\":null,\\\"status\\\":\\\"SANDBOX\\\"}]}\"', '2021-06-03 13:04:09', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `type` enum('Admin','Customer','Staff','Kitchen Staff') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Customer',
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(99) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` bigint(20) DEFAULT NULL,
  `address_line_one` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address_line_two` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(99) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `state` varchar(99) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `post_code` varchar(99) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `company_id` bigint(20) UNSIGNED DEFAULT NULL COMMENT 'Applicable for Staff',
  `designation_id` bigint(20) UNSIGNED DEFAULT NULL COMMENT 'designation id applicable for staff',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('Active','Pending','Inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `type`, `name`, `email`, `phone`, `address_line_one`, `address_line_two`, `city`, `state`, `post_code`, `email_verified_at`, `password`, `company_id`, `designation_id`, `remember_token`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Admin', 'Test Admin', 'testadmin@yopmail.com', 0, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$UnnhWWUGZ5YKPrSiW0QHiu/m6dcElgP2jEkTOmrsBp2lMA2Cv6zve', NULL, NULL, NULL, 'Active', '2021-05-17 12:24:59', '2021-05-26 19:43:20', NULL),
(4, 'Customer', 'TestCustomer1', 'TestCustomer1@gmail.com', 1780, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$eZlJUXnmMDChIQh54iP5Puut7uXjzWulG.C.zWPsck.NIL1bsloW6', NULL, NULL, NULL, 'Active', '2021-05-26 20:26:48', '2021-05-30 11:58:43', NULL),
(6, 'Staff', 'Kamrul', 'kamrul@yopmail.com', 1780324482, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$6CoGhmzvCqHk7XJcWp7RYukrUxuSdqNdEGJoNM6yCRjw9gZgXm7bm', NULL, NULL, NULL, 'Active', '2021-05-31 05:29:10', '2021-05-31 05:29:10', NULL),
(7, 'Staff', 'HellStaff1', 'HellStaff1@yopmail.com', 7133875699, 'Baddha, 1/3 Road', NULL, 'London', 'Dhaka', NULL, NULL, '$2y$10$M0DFI6UYqrV7Wp8dd/wUQeZyUDGr.he4YvHko3zv2Q80a0kr7ZuHy', NULL, 1, NULL, 'Active', '2021-06-01 00:28:18', '2021-06-03 00:51:31', NULL),
(8, 'Staff', 'HellStaff2', 'HellStaff112@yopmail.com', 2147483647, 'Baddha, 1/3 Road', NULL, 'Dhaka', 'Dhaka', NULL, NULL, '$2y$10$yuG4FsL36sggoQIp7FgXy.2R2Z9WW7/E113gd1WHI6b1YuYKkNRgi', NULL, NULL, NULL, 'Active', '2021-06-01 00:29:10', '2021-06-03 00:51:57', NULL),
(9, 'Kitchen Staff', 'Kitch Staff1', 'kitchenstaff1@gmail.com', 1780322482, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$LMF7jdJibB7goWrGdeNg9urhljwqoPpxtSS0p5SFTOfBA.Nqa9mOW', NULL, NULL, NULL, 'Active', '2021-06-01 04:19:56', '2021-06-04 01:54:23', NULL),
(10, 'Staff', 'Staff Khan', 'Staffkhan1@yopmail.com', 1780324482, 'Hollvaly line raod 1', NULL, 'London', 'Halshire', NULL, NULL, '$2y$10$bCipBMwGEJwclahDkwOaSu6h4cBG3hbTJI3UbKaGXQNClbzA7.ez6', NULL, 1, NULL, 'Active', '2021-06-03 05:15:44', '2021-06-03 07:27:45', NULL),
(11, 'Staff', 'dbcstaff Cool', 'dbcstaff@yopmail.com', 3215698745, 'This is address line one', NULL, 'London', 'Hamlshire', NULL, NULL, '$2y$10$fzWuvrnjjvY9/Z5IJjkaHesjkLtpAW9W8UvA3rskW7B38B82ZSxJK', NULL, 1, NULL, 'Active', '2021-06-03 23:11:59', '2021-06-04 01:41:42', NULL),
(12, 'Customer', 'My Cus', 'mycus@yopmail.com', 1234568451, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$RpNxgI/psFmXK0dsuXMJzOlPeUpW8tBdvetyQ3oqbTNDj3xNZnI6u', NULL, NULL, NULL, 'Active', '2021-06-12 04:07:16', '2021-06-12 04:07:16', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `batch_coupons`
--
ALTER TABLE `batch_coupons`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `batch_coupon_purchase_histories`
--
ALTER TABLE `batch_coupon_purchase_histories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `carts`
--
ALTER TABLE `carts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `chats`
--
ALTER TABLE `chats`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cities`
--
ALTER TABLE `cities`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `companies`
--
ALTER TABLE `companies`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `code` (`code`);

--
-- Indexes for table `coupons`
--
ALTER TABLE `coupons`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `coupon_code` (`coupon_code`);

--
-- Indexes for table `customer_addresses`
--
ALTER TABLE `customer_addresses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `delivery_charges`
--
ALTER TABLE `delivery_charges`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `designations`
--
ALTER TABLE `designations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `title` (`title`);

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `frontend_u_i_s`
--
ALTER TABLE `frontend_u_i_s`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `home_contents`
--
ALTER TABLE `home_contents`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notification_settings`
--
ALTER TABLE `notification_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_options`
--
ALTER TABLE `password_reset_options`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payment_gateways`
--
ALTER TABLE `payment_gateways`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `post_code`
--
ALTER TABLE `post_code`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sliders`
--
ALTER TABLE `sliders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `staff_addresses`
--
ALTER TABLE `staff_addresses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `staff_allowed_delivery_orders`
--
ALTER TABLE `staff_allowed_delivery_orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `staff_batch_coupons`
--
ALTER TABLE `staff_batch_coupons`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `staff_credits`
--
ALTER TABLE `staff_credits`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `staff_invitations`
--
ALTER TABLE `staff_invitations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `support_tickets`
--
ALTER TABLE `support_tickets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `s_m_s_send_logs`
--
ALTER TABLE `s_m_s_send_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `batch_coupons`
--
ALTER TABLE `batch_coupons`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `batch_coupon_purchase_histories`
--
ALTER TABLE `batch_coupon_purchase_histories`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `carts`
--
ALTER TABLE `carts`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `chats`
--
ALTER TABLE `chats`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;

--
-- AUTO_INCREMENT for table `companies`
--
ALTER TABLE `companies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `coupons`
--
ALTER TABLE `coupons`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `customer_addresses`
--
ALTER TABLE `customer_addresses`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `delivery_charges`
--
ALTER TABLE `delivery_charges`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `designations`
--
ALTER TABLE `designations`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `frontend_u_i_s`
--
ALTER TABLE `frontend_u_i_s`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `home_contents`
--
ALTER TABLE `home_contents`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `notification_settings`
--
ALTER TABLE `notification_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `password_reset_options`
--
ALTER TABLE `password_reset_options`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `payment_gateways`
--
ALTER TABLE `payment_gateways`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `post_code`
--
ALTER TABLE `post_code`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `sliders`
--
ALTER TABLE `sliders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `staff_addresses`
--
ALTER TABLE `staff_addresses`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `staff_allowed_delivery_orders`
--
ALTER TABLE `staff_allowed_delivery_orders`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `staff_batch_coupons`
--
ALTER TABLE `staff_batch_coupons`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `staff_credits`
--
ALTER TABLE `staff_credits`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `staff_invitations`
--
ALTER TABLE `staff_invitations`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `support_tickets`
--
ALTER TABLE `support_tickets`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `s_m_s_send_logs`
--
ALTER TABLE `s_m_s_send_logs`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
