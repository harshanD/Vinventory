-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 18, 2019 at 05:28 PM
-- Server version: 10.1.40-MariaDB
-- PHP Version: 7.3.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `stock`
--

-- --------------------------------------------------------

--
-- Table structure for table `adjustment`
--

CREATE TABLE `adjustment` (
  `id` int(10) UNSIGNED NOT NULL,
  `reference_code` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` date NOT NULL,
  `location` int(10) UNSIGNED NOT NULL,
  `note` text COLLATE utf8mb4_unicode_ci,
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0=active,1=inactive',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_by` int(10) UNSIGNED DEFAULT NULL,
  `updated_by` int(10) UNSIGNED DEFAULT NULL,
  `deleted_by` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `adjustment`
--

INSERT INTO `adjustment` (`id`, `reference_code`, `date`, `location`, `note`, `status`, `deleted_at`, `created_at`, `updated_at`, `created_by`, `updated_by`, `deleted_by`) VALUES
(1, 'ADJUST-000001', '2019-10-18', 1, 'adjustment note', 0, NULL, '2019-10-18 10:39:43', '2019-10-17 18:30:00', 1, 1, NULL),
(2, 'ADJUST-000002', '2019-11-18', 1, NULL, 0, NULL, '2019-11-18 15:58:26', '2019-11-18 15:58:26', 1, 1, NULL),
(3, 'ADJUST-000003', '2019-12-18', 1, NULL, 0, NULL, '2019-12-18 16:12:53', '2019-12-18 16:12:53', 1, 1, NULL),
(4, 'ADJUST-000004', '2019-12-18', 2, NULL, 0, NULL, '2019-12-18 16:25:31', '2019-12-18 16:25:31', 1, 1, NULL),
(5, 'ADJUST-000005', '2019-12-18', 1, 'Substract', 0, NULL, '2019-12-18 16:26:28', '2019-12-18 16:26:28', 1, 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `biller`
--

CREATE TABLE `biller` (
  `id` int(10) UNSIGNED NOT NULL,
  `company` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(12) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `invoice_footer` text COLLATE utf8mb4_unicode_ci,
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '1=inactive,0=active',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_by` int(10) UNSIGNED DEFAULT NULL,
  `updated_by` int(10) UNSIGNED DEFAULT NULL,
  `deleted_by` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `biller`
--

INSERT INTO `biller` (`id`, `company`, `name`, `email`, `phone`, `address`, `invoice_footer`, `status`, `deleted_at`, `created_at`, `updated_at`, `created_by`, `updated_by`, `deleted_by`) VALUES
(1, 'test biller company', 'Test biller', 'harshan.dilantha@gmail.com', '0711513461', 'kinihitiya goda,, narawala, poddala', NULL, 0, NULL, '2019-10-17 15:38:15', '2019-10-17 15:38:15', 1, 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `brands`
--

CREATE TABLE `brands` (
  `id` int(10) UNSIGNED NOT NULL,
  `code` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `brand` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '1=inactive,0=active',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_by` int(10) UNSIGNED DEFAULT NULL,
  `updated_by` int(10) UNSIGNED DEFAULT NULL,
  `deleted_by` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `brands`
--

INSERT INTO `brands` (`id`, `code`, `brand`, `description`, `status`, `deleted_at`, `created_at`, `updated_at`, `created_by`, `updated_by`, `deleted_by`) VALUES
(1, 'Wijaya', 'Wijaya', NULL, 0, NULL, '2019-10-16 12:00:00', '2019-10-16 12:00:00', NULL, NULL, NULL),
(2, 'Freelan', 'Freelan', NULL, 0, NULL, '2019-10-16 12:00:00', '2019-10-16 12:00:00', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(10) UNSIGNED NOT NULL,
  `code` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `category` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '1=inactive,0=active',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_by` int(10) UNSIGNED DEFAULT NULL,
  `updated_by` int(10) UNSIGNED DEFAULT NULL,
  `deleted_by` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `code`, `category`, `description`, `status`, `deleted_at`, `created_at`, `updated_at`, `created_by`, `updated_by`, `deleted_by`) VALUES
(1, 'E-0', 'Chili Powder', NULL, 0, NULL, '2019-10-16 12:00:16', '2019-10-16 12:00:16', NULL, NULL, NULL),
(2, 'E-0', 'Noodles', NULL, 0, NULL, '2019-10-16 12:00:16', '2019-10-16 12:00:16', NULL, NULL, NULL),
(3, 'Bly', 'Barley', NULL, 0, NULL, '2019-10-17 16:31:02', '2019-10-17 16:31:02', 1, 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `id` int(10) UNSIGNED NOT NULL,
  `company` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(12) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '1=inactive,0=active',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_by` int(10) UNSIGNED DEFAULT NULL,
  `updated_by` int(10) UNSIGNED DEFAULT NULL,
  `deleted_by` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`id`, `company`, `name`, `email`, `phone`, `address`, `status`, `deleted_at`, `created_at`, `updated_at`, `created_by`, `updated_by`, `deleted_by`) VALUES
(1, 'test customer', 'test customer', 'harshan.dilantha@gmail.com', '0711513461', 'kinihitiya goda,, narawala, poddala', 0, NULL, '2019-10-17 15:39:14', '2019-10-17 15:39:14', 1, 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `invoice`
--

CREATE TABLE `invoice` (
  `id` int(10) UNSIGNED NOT NULL,
  `invoice_code` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `location` int(10) UNSIGNED NOT NULL,
  `biller` int(10) UNSIGNED NOT NULL,
  `customer` int(10) UNSIGNED NOT NULL,
  `discount` double DEFAULT NULL,
  `discount_val_or_per` double DEFAULT NULL,
  `tax_amount` double DEFAULT NULL,
  `tax_per` double DEFAULT NULL,
  `invoice_grand_total` double NOT NULL,
  `invoice_date` date NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '1=inactive,0=active',
  `sales_status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1=pending,2=completed',
  `payment_status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1=pending,2=due,3=partial,4=paid',
  `sale_note` text COLLATE utf8mb4_unicode_ci,
  `staff_note` text COLLATE utf8mb4_unicode_ci,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_by` int(10) UNSIGNED DEFAULT NULL,
  `updated_by` int(10) UNSIGNED DEFAULT NULL,
  `deleted_by` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `invoice`
--

INSERT INTO `invoice` (`id`, `invoice_code`, `location`, `biller`, `customer`, `discount`, `discount_val_or_per`, `tax_amount`, `tax_per`, `invoice_grand_total`, `invoice_date`, `status`, `sales_status`, `payment_status`, `sale_note`, `staff_note`, `deleted_at`, `created_at`, `updated_at`, `created_by`, `updated_by`, `deleted_by`) VALUES
(1, 'IV-000001', 1, 1, 1, 5, 5, 189, 20, 1134, '2019-10-17', 0, 1, 3, 'test sale', 'test staff note', NULL, '2019-10-17 15:44:15', '2019-10-18 10:13:27', 1, 1, NULL),
(2, 'IV-000002', 2, 1, 1, 5, 5, 219, 20, 1314, '2019-10-17', 0, 1, 1, 'test sale note 2', 'test staff note 2', NULL, '2019-10-17 15:53:22', '2019-10-17 15:53:22', 1, 1, NULL),
(3, 'IV-000003', 1, 1, 1, 200, 200, 810, 20, 4860, '2019-11-18', 0, 1, 1, NULL, NULL, NULL, '2019-11-18 11:31:36', '2019-11-18 11:31:36', 1, 1, NULL),
(4, 'IV-000004', 2, 1, 1, 150, 150, 1050, 20, 6300, '2019-11-18', 0, 1, 1, NULL, NULL, NULL, '2019-11-18 11:32:48', '2019-11-18 11:32:48', 1, 1, NULL),
(5, 'IV-000005', 1, 1, 1, 0, 0, 3100, 20, 18600, '2019-12-18', 0, 2, 4, NULL, NULL, NULL, '2019-12-18 16:13:52', '2019-12-18 16:13:52', 1, 1, NULL),
(6, 'IV-000006', 2, 1, 1, 0, 0, 0, 0, 6750, '2019-12-18', 0, 1, 1, NULL, NULL, NULL, '2019-12-18 16:14:52', '2019-12-18 16:14:52', 1, 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `invoice_details`
--

CREATE TABLE `invoice_details` (
  `id` int(10) UNSIGNED NOT NULL,
  `invoice_id` int(10) UNSIGNED NOT NULL,
  `serial_number` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `item_id` int(10) UNSIGNED NOT NULL,
  `qty` double DEFAULT NULL,
  `selling_price` double NOT NULL,
  `tax_val` double DEFAULT NULL,
  `tax_per` double DEFAULT NULL,
  `discount` double DEFAULT NULL,
  `sub_total` double NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `invoice_details`
--

INSERT INTO `invoice_details` (`id`, `invoice_id`, `serial_number`, `item_id`, `qty`, `selling_price`, `tax_val`, `tax_per`, `discount`, `sub_total`, `created_at`, `updated_at`) VALUES
(1, 1, '', 1, 10, 100, 15.83, 20, 50, 950, '2019-10-17 15:44:15', '2019-10-17 15:44:15'),
(2, 2, '', 3, 5, 100, 15.83, 20, 25, 475, '2019-10-17 15:53:22', '2019-10-17 15:53:22'),
(3, 2, '', 4, 5, 130, 20.83, 20, 25, 625, '2019-10-17 15:53:22', '2019-10-17 15:53:22'),
(4, 3, '', 1, 10, 100, 0, 0, 0, 1000, '2019-11-18 11:31:36', '2019-11-18 11:31:36'),
(5, 3, '', 4, 25, 130, 0, 0, 0, 3250, '2019-11-18 11:31:36', '2019-11-18 11:31:36'),
(6, 4, '', 4, 30, 130, 0, 0, 0, 3900, '2019-11-18 11:32:48', '2019-11-18 11:32:48'),
(7, 4, '', 2, 5, 300, 0, 0, 0, 1500, '2019-11-18 11:32:48', '2019-11-18 11:32:48'),
(8, 5, '', 1, 10, 100, 0, 0, 0, 1000, '2019-12-18 16:13:52', '2019-12-18 16:13:52'),
(9, 5, '', 2, 50, 300, 48.33, 20, 500, 14500, '2019-12-18 16:13:52', '2019-12-18 16:13:52'),
(10, 6, '', 1, 10, 100, 15, 20, 100, 900, '2019-12-18 16:14:52', '2019-12-18 16:14:52'),
(11, 6, '', 4, 45, 130, 0, 0, 0, 5850, '2019-12-18 16:14:52', '2019-12-18 16:14:52');

-- --------------------------------------------------------

--
-- Table structure for table `locations`
--

CREATE TABLE `locations` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `telephone` varchar(12) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `contact_person` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` int(11) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '1=inactive,0=active',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_by` int(10) UNSIGNED DEFAULT NULL,
  `updated_by` int(10) UNSIGNED DEFAULT NULL,
  `deleted_by` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `locations`
--

INSERT INTO `locations` (`id`, `name`, `code`, `address`, `telephone`, `email`, `contact_person`, `type`, `status`, `deleted_at`, `created_at`, `updated_at`, `created_by`, `updated_by`, `deleted_by`) VALUES
(1, 'Kalegana', 'W-KLG', 'kinihitiyagoda, narawala,poddala,galle, house', '0711513461', 'harshan.dilantha@gmail.com', 'prasnanna', 1, 0, NULL, '2019-08-16 12:00:50', '2019-08-16 12:00:50', NULL, NULL, NULL),
(2, 'Karapitiya', 'W-KRPT', 'kinihitiyagoda, narawala,poddala,galle, house', '0711513461', 'harshan.dilantha@gmail.com', 'prasnanna', 1, 0, NULL, '2019-08-16 12:00:50', '2019-08-16 12:00:50', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_05_14_062414_create_roles_table', 1),
(4, '2019_07_17_145423_create_tax_profiles_table', 1),
(5, '2019_07_18_172809_create_locations_table', 1),
(6, '2019_07_18_172906_create_supplier_table', 1),
(7, '2019_07_18_172936_create_product_brand_pivot_table', 1),
(8, '2019_07_18_173037_create_product_category_pivot_table', 1),
(9, '2019_07_18_173200_create_brands_table', 1),
(10, '2019_07_18_173233_create_categories_table', 1),
(11, '2019_07_18_173234_create_products_table', 1),
(12, '2019_07_18_173321_create_po_header_table', 1),
(13, '2019_07_18_173336_create_po_details_table', 1),
(14, '2019_07_19_164340_create_biller_table', 1),
(15, '2019_07_19_164424_create_customer_table', 1),
(16, '2019_07_20_145048_create_invoice_table', 1),
(17, '2019_07_20_145106_create_invoice_details_table', 1),
(18, '2019_07_20_145136_create_stock_return_table', 1),
(19, '2019_07_20_145146_create_stock_return_details_table', 1),
(20, '2019_07_24_062236_create_role_user_pivot_table', 1),
(21, '2019_07_31_183840_create_products_supplier_pivot_table', 1),
(22, '2019_08_16_165830_create_stock_table', 1),
(23, '2019_08_16_165952_create_stock_items_table', 1),
(24, '2019_08_21_063351_create_transfers_table', 1),
(25, '2019_08_29_042718_create_adjustment_table', 1),
(26, '2019_09_03_053815_create_payments_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` int(10) UNSIGNED NOT NULL,
  `reference_code` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `parent_reference_code` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` date NOT NULL,
  `pay_type` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `cheque_no` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `note` text COLLATE utf8mb4_unicode_ci,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_by` int(10) UNSIGNED DEFAULT NULL,
  `updated_by` int(10) UNSIGNED DEFAULT NULL,
  `deleted_by` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`id`, `reference_code`, `parent_reference_code`, `value`, `date`, `pay_type`, `cheque_no`, `note`, `deleted_at`, `created_at`, `updated_at`, `created_by`, `updated_by`, `deleted_by`) VALUES
(1, 'P-000001', 'IV-000001', '800', '2019-10-18', 'cash', NULL, NULL, NULL, '2019-10-18 10:13:27', '2019-10-18 10:14:40', 1, 1, NULL),
(2, 'P-000002', 'IV-000001', '20', '2019-10-18', 'cheque', '12345', NULL, '2019-12-18 10:14:17', '2019-10-18 10:13:42', '2019-10-18 10:14:17', 1, 1, 1),
(3, 'P-000003', 'IV-000001', '100', '2019-10-18', 'cheque', '12345', NULL, NULL, '2019-10-18 10:14:59', '2019-10-18 10:15:13', 1, 1, NULL),
(4, 'P-000004', 'PO-000005', '840', '2019-11-18', 'cash', NULL, NULL, NULL, '2019-11-18 16:03:27', '2019-11-18 16:03:27', 1, 1, NULL),
(5, 'P-000005', 'PO-000002', '38520', '2019-11-18', 'cash', NULL, NULL, NULL, '2019-11-18 16:03:46', '2019-11-18 16:03:46', 1, 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `po_details`
--

CREATE TABLE `po_details` (
  `id` int(10) UNSIGNED NOT NULL,
  `po_header` int(10) UNSIGNED NOT NULL,
  `item_id` int(10) UNSIGNED NOT NULL,
  `cost_price` double NOT NULL,
  `qty` double NOT NULL,
  `received_qty` double NOT NULL DEFAULT '0',
  `tax_val` double DEFAULT NULL,
  `tax_percentage` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `discount` double DEFAULT NULL,
  `sub_total` double NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `po_details`
--

INSERT INTO `po_details` (`id`, `po_header`, `item_id`, `cost_price`, `qty`, `received_qty`, `tax_val`, `tax_percentage`, `discount`, `sub_total`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 80, 100, 100, 0, 0, 500, 7500, '2019-10-17 15:08:18', '2019-10-17 15:30:59'),
(2, 1, 2, 250, 100, 100, 40, 20, 1000, 24000, '2019-10-17 15:08:18', '2019-10-17 15:30:59'),
(3, 2, 3, 80, 200, 50, 13, 20, 400, 15600, '2019-10-17 15:28:20', '2019-10-17 15:31:41'),
(4, 2, 4, 90, 200, 50, 14.17, 20, 1000, 17000, '2019-10-17 15:28:20', '2019-10-17 15:31:41'),
(5, 3, 1, 80, 150, 50, 0, 0, 0, 12000, '2019-11-18 11:20:41', '2019-11-18 11:30:20'),
(6, 3, 2, 250, 150, 25, 0, 0, 0, 37500, '2019-11-18 11:20:41', '2019-11-18 11:30:20'),
(7, 4, 3, 80, 200, 200, 11.67, 20, 2000, 14000, '2019-11-18 11:29:34', '2019-11-18 11:30:07'),
(8, 4, 4, 90, 300, 300, 0, 0, 0, 27000, '2019-11-18 11:29:34', '2019-11-18 11:30:07'),
(9, 5, 1, 80, 10, 5, 0, 0, 0, 800, '2019-11-18 13:42:38', '2019-11-18 13:43:46'),
(10, 6, 1, 80, 100, 100, 13.33, 20, 0, 8000, '2019-12-18 16:16:15', '2019-12-18 16:17:20'),
(11, 6, 2, 250, 100, 100, 41.67, 20, 0, 25000, '2019-12-18 16:16:15', '2019-12-18 16:17:20');

-- --------------------------------------------------------

--
-- Table structure for table `po_header`
--

CREATE TABLE `po_header` (
  `id` int(10) UNSIGNED NOT NULL,
  `location` int(10) UNSIGNED NOT NULL,
  `supplier` int(10) UNSIGNED NOT NULL,
  `referenceCode` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `due_date` date DEFAULT NULL,
  `tax` double UNSIGNED NOT NULL,
  `tax_percentage` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `discount` double UNSIGNED NOT NULL,
  `discount_val_or_per` double UNSIGNED NOT NULL DEFAULT '0',
  `grand_total` double UNSIGNED NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '3' COMMENT '1=received,2=ordered,3=pending,4=canceled',
  `payment_status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1=pending,2=due,3=partial,4=paid',
  `approve_status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0=not_approve,1=approved',
  `remark` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_by` int(10) UNSIGNED DEFAULT NULL,
  `updated_by` int(10) UNSIGNED DEFAULT NULL,
  `deleted_by` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `po_header`
--

INSERT INTO `po_header` (`id`, `location`, `supplier`, `referenceCode`, `due_date`, `tax`, `tax_percentage`, `discount`, `discount_val_or_per`, `grand_total`, `status`, `payment_status`, `approve_status`, `remark`, `deleted_at`, `created_at`, `updated_at`, `created_by`, `updated_by`, `deleted_by`) VALUES
(1, 1, 1, 'PO-000001', '2019-10-17', 6299, 20, 5, 5, 37794, 1, 1, 0, 'test note', NULL, '2019-10-17 15:08:18', '2019-10-17 15:30:59', 1, 1, NULL),
(2, 2, 3, 'PO-000002', '2019-10-17', 6420, 20, 500, 500, 38520, 1, 4, 0, 'test  po 2', NULL, '2019-10-17 15:28:20', '2019-12-18 16:03:46', 1, 1, NULL),
(3, 1, 2, 'PO-000003', '2019-11-18', 9840, 20, 300, 300, 59040, 1, 1, 0, NULL, NULL, '2019-11-18 11:20:41', '2019-11-18 11:20:41', 1, 1, NULL),
(4, 2, 3, 'PO-000004', '2019-11-18', 8000, 20, 1000, 1000, 48000, 1, 1, 0, NULL, NULL, '2019-11-18 11:29:34', '2019-11-18 11:30:07', 1, 1, NULL),
(5, 2, 2, 'PO-000005', '2019-11-18', 140, 20, 100, 100, 840, 1, 4, 0, NULL, NULL, '2019-11-18 13:42:38', '2019-11-18 16:03:27', 1, 1, NULL),
(6, 2, 1, 'PO-000006', '2019-12-18', 6400, 20, 1000, 1000, 38400, 1, 1, 0, NULL, NULL, '2019-12-18 16:16:15', '2019-12-18 16:17:20', 1, 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(10) UNSIGNED NOT NULL,
  `barcode` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sku` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `item_code` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `short_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `img_url` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `category` int(10) UNSIGNED NOT NULL,
  `brand` int(10) UNSIGNED NOT NULL,
  `selling_price` double NOT NULL,
  `cost_price` double NOT NULL,
  `weight` double NOT NULL,
  `unit` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'meter=1,piece=2,kilogram=3',
  `availability` double DEFAULT NULL,
  `reorder_level` double DEFAULT NULL,
  `reorder_activation` double NOT NULL DEFAULT '0' COMMENT 'active=0,inactive=1',
  `tax` int(11) DEFAULT NULL,
  `tax_method` int(11) DEFAULT NULL COMMENT 'exclusive=1,inclusive=2',
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '1=inactive,0=active',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_by` int(10) UNSIGNED DEFAULT NULL,
  `updated_by` int(10) UNSIGNED DEFAULT NULL,
  `deleted_by` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `barcode`, `sku`, `item_code`, `name`, `short_name`, `description`, `img_url`, `category`, `brand`, `selling_price`, `cost_price`, `weight`, `unit`, `availability`, `reorder_level`, `reorder_activation`, `tax`, `tax_method`, `status`, `deleted_at`, `created_at`, `updated_at`, `created_by`, `updated_by`, `deleted_by`) VALUES
(1, NULL, '121', 'ch250', 'Chili pieces 250', 'chili pieces 250', '', 'products/qSnKsPa6le2Vl7rOtAe4EFNSBo1Mbf9bpFPFXsSr.jpeg', 1, 1, 100, 80, 0.25, '3', 255, 0, 1, 0, 1, 0, NULL, '2019-08-16 12:03:24', '2019-12-18 16:17:20', NULL, 1, NULL),
(2, NULL, '3s', 'nd5', 'Noodles 5KG', 'noodles 5KG', '', 'products/BzEVSojuISNpMiIcrDRQJRQQx12SWCFZ7AkAROfz.jpeg', 1, 1, 300, 250, 5, '3', 225, 0, 1, 0, 2, 0, NULL, '2019-08-16 12:05:08', '2019-12-18 16:17:20', NULL, 1, NULL),
(3, NULL, 'CM', 'MCM', 'Meat curry powder mixture', 'Meat curry mixture', '', 'products/O14jId1I1UCBV8ZGOennZK1ud2L20AJDOI8d80oR.jpeg', 1, 2, 100, 80, 0.1, '3', 250, 5, 0, 1, 1, 0, NULL, '2019-12-17 14:39:32', '2019-12-18 11:30:07', 1, 1, NULL),
(4, NULL, 'pma', 'BP', 'Barley powder', 'Barley powder', '', 'products/IUZgqFgvQHPgNNVL5YoHg1g8zXxi9DeFdBL4QPGF.png', 3, 2, 130, 90, 0.1, '3', 300, 5, 0, 2, 1, 0, NULL, '2019-12-17 14:58:25', '2019-12-18 11:30:07', 1, 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `products_supplier`
--

CREATE TABLE `products_supplier` (
  `products_id` int(11) NOT NULL,
  `supplier_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products_supplier`
--

INSERT INTO `products_supplier` (`products_id`, `supplier_id`, `created_at`, `updated_at`) VALUES
(1, 1, NULL, NULL),
(1, 2, NULL, NULL),
(2, 1, NULL, NULL),
(2, 2, NULL, NULL),
(3, 3, NULL, NULL),
(4, 3, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `product_brand`
--

CREATE TABLE `product_brand` (
  `product_id` int(11) NOT NULL,
  `brand_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product_category`
--

CREATE TABLE `product_category` (
  `product_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `permissions` text COLLATE utf8mb4_unicode_ci,
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '1=inactive,0=active',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_by` int(10) UNSIGNED DEFAULT NULL,
  `updated_by` int(10) UNSIGNED DEFAULT NULL,
  `deleted_by` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `permissions`, `status`, `deleted_at`, `created_at`, `updated_at`, `created_by`, `updated_by`, `deleted_by`) VALUES
(1, 'Admin', 'a:89:{i:0;s:10:\"createUser\";i:1;s:10:\"updateUser\";i:2;s:8:\"viewUser\";i:3;s:10:\"deleteUser\";i:4;s:10:\"createRole\";i:5;s:10:\"updateRole\";i:6;s:8:\"viewRole\";i:7;s:10:\"deleteRole\";i:8;s:11:\"createBrand\";i:9;s:11:\"updateBrand\";i:10;s:9:\"viewBrand\";i:11;s:11:\"deleteBrand\";i:12;s:14:\"createCategory\";i:13;s:14:\"updateCategory\";i:14;s:12:\"viewCategory\";i:15;s:14:\"deleteCategory\";i:16;s:12:\"createBiller\";i:17;s:12:\"updateBiller\";i:18;s:10:\"viewBiller\";i:19;s:12:\"deleteBiller\";i:20;s:14:\"createCustomer\";i:21;s:14:\"updateCustomer\";i:22;s:12:\"viewCustomer\";i:23;s:14:\"deleteCustomer\";i:24;s:14:\"createSupplier\";i:25;s:14:\"updateSupplier\";i:26;s:12:\"viewSupplier\";i:27;s:14:\"deleteSupplier\";i:28;s:15:\"createWarehouse\";i:29;s:15:\"updateWarehouse\";i:30;s:13:\"viewWarehouse\";i:31;s:15:\"deleteWarehouse\";i:32;s:13:\"createProduct\";i:33;s:13:\"updateProduct\";i:34;s:11:\"viewProduct\";i:35;s:13:\"deleteProduct\";i:36;s:11:\"createOrder\";i:37;s:11:\"updateOrder\";i:38;s:9:\"viewOrder\";i:39;s:11:\"deleteOrder\";i:40;s:10:\"createSale\";i:41;s:10:\"updateSale\";i:42;s:8:\"viewSale\";i:43;s:10:\"deleteSale\";i:44;s:14:\"createTransfer\";i:45;s:14:\"updateTransfer\";i:46;s:12:\"viewTransfer\";i:47;s:14:\"deleteTransfer\";i:48;s:16:\"createAdjustment\";i:49;s:16:\"updateAdjustment\";i:50;s:14:\"viewAdjustment\";i:51;s:16:\"deleteAdjustment\";i:52;s:13:\"createReturns\";i:53;s:13:\"updateReturns\";i:54;s:11:\"viewReturns\";i:55;s:13:\"deleteReturns\";i:56;s:9:\"createTax\";i:57;s:9:\"updateTax\";i:58;s:7:\"viewTax\";i:59;s:9:\"deleteTax\";i:60;s:10:\"viewPeople\";i:61;s:12:\"viewSettings\";i:62;s:11:\"viewReports\";i:63;s:20:\"warehouseStockReport\";i:64;s:20:\"productQualityAlerts\";i:65;s:14:\"productsReport\";i:66;s:17:\"adjustmentsReport\";i:67;s:14:\"categoryReport\";i:68;s:12:\"brandsReport\";i:69;s:10:\"dailySales\";i:70;s:12:\"monthlySales\";i:71;s:11:\"salesReport\";i:72;s:14:\"paymentsReport\";i:73;s:14:\"dailyPurchases\";i:74;s:16:\"monthlyPurchases\";i:75;s:15:\"purchasesReport\";i:76;s:15:\"customersReport\";i:77;s:15:\"suppliersReport\";i:78;s:13:\"notifications\";i:79;s:14:\"quantityAlerts\";i:80;s:18:\"newRegisteredUsers\";i:81;s:9:\"dashChart\";i:82;s:7:\"dashTop\";i:83;s:14:\"poStockReceive\";i:84;s:9:\"poApprove\";i:85;s:6:\"poMail\";i:86;s:9:\"salesMail\";i:87;s:13:\"transfersMail\";i:88;s:11:\"viewProfile\";}', 0, NULL, '2019-12-17 13:57:24', '2019-12-18 14:45:53', NULL, 1, NULL),
(2, 'Manager', 'a:88:{i:0;s:10:\"createUser\";i:1;s:10:\"updateUser\";i:2;s:8:\"viewUser\";i:3;s:10:\"createRole\";i:4;s:10:\"updateRole\";i:5;s:8:\"viewRole\";i:6;s:10:\"deleteRole\";i:7;s:11:\"createBrand\";i:8;s:11:\"updateBrand\";i:9;s:9:\"viewBrand\";i:10;s:11:\"deleteBrand\";i:11;s:14:\"createCategory\";i:12;s:14:\"updateCategory\";i:13;s:12:\"viewCategory\";i:14;s:14:\"deleteCategory\";i:15;s:12:\"createBiller\";i:16;s:12:\"updateBiller\";i:17;s:10:\"viewBiller\";i:18;s:12:\"deleteBiller\";i:19;s:14:\"createCustomer\";i:20;s:14:\"updateCustomer\";i:21;s:12:\"viewCustomer\";i:22;s:14:\"deleteCustomer\";i:23;s:14:\"createSupplier\";i:24;s:14:\"updateSupplier\";i:25;s:12:\"viewSupplier\";i:26;s:14:\"deleteSupplier\";i:27;s:15:\"createWarehouse\";i:28;s:15:\"updateWarehouse\";i:29;s:13:\"viewWarehouse\";i:30;s:15:\"deleteWarehouse\";i:31;s:13:\"createProduct\";i:32;s:13:\"updateProduct\";i:33;s:11:\"viewProduct\";i:34;s:13:\"deleteProduct\";i:35;s:11:\"createOrder\";i:36;s:11:\"updateOrder\";i:37;s:9:\"viewOrder\";i:38;s:11:\"deleteOrder\";i:39;s:10:\"createSale\";i:40;s:10:\"updateSale\";i:41;s:8:\"viewSale\";i:42;s:10:\"deleteSale\";i:43;s:14:\"createTransfer\";i:44;s:14:\"updateTransfer\";i:45;s:12:\"viewTransfer\";i:46;s:14:\"deleteTransfer\";i:47;s:16:\"createAdjustment\";i:48;s:16:\"updateAdjustment\";i:49;s:14:\"viewAdjustment\";i:50;s:16:\"deleteAdjustment\";i:51;s:13:\"createReturns\";i:52;s:13:\"updateReturns\";i:53;s:11:\"viewReturns\";i:54;s:13:\"deleteReturns\";i:55;s:9:\"createTax\";i:56;s:9:\"updateTax\";i:57;s:7:\"viewTax\";i:58;s:9:\"deleteTax\";i:59;s:10:\"viewPeople\";i:60;s:12:\"viewSettings\";i:61;s:11:\"viewReports\";i:62;s:20:\"warehouseStockReport\";i:63;s:20:\"productQualityAlerts\";i:64;s:14:\"productsReport\";i:65;s:17:\"adjustmentsReport\";i:66;s:14:\"categoryReport\";i:67;s:12:\"brandsReport\";i:68;s:10:\"dailySales\";i:69;s:12:\"monthlySales\";i:70;s:11:\"salesReport\";i:71;s:14:\"paymentsReport\";i:72;s:14:\"dailyPurchases\";i:73;s:16:\"monthlyPurchases\";i:74;s:15:\"purchasesReport\";i:75;s:15:\"customersReport\";i:76;s:15:\"suppliersReport\";i:77;s:13:\"notifications\";i:78;s:14:\"quantityAlerts\";i:79;s:18:\"newRegisteredUsers\";i:80;s:9:\"dashChart\";i:81;s:7:\"dashTop\";i:82;s:14:\"poStockReceive\";i:83;s:9:\"poApprove\";i:84;s:6:\"poMail\";i:85;s:9:\"salesMail\";i:86;s:13:\"transfersMail\";i:87;s:11:\"viewProfile\";}', 0, NULL, '2019-12-17 13:57:24', '2019-12-17 16:35:04', NULL, 1, NULL),
(3, 'Accountant', 'a:12:{i:0;s:11:\"createOrder\";i:1;s:11:\"updateOrder\";i:2;s:9:\"viewOrder\";i:3;s:11:\"deleteOrder\";i:4;s:8:\"viewSale\";i:5;s:14:\"paymentsReport\";i:6;s:14:\"dailyPurchases\";i:7;s:16:\"monthlyPurchases\";i:8;s:15:\"purchasesReport\";i:9;s:9:\"poApprove\";i:10;s:6:\"poMail\";i:11;s:11:\"viewProfile\";}', 0, NULL, '2019-12-17 13:57:24', '2019-12-17 16:35:57', NULL, 1, NULL),
(4, 'WareHouse Officer', 'a:7:{i:0;s:14:\"createTransfer\";i:1;s:14:\"updateTransfer\";i:2;s:12:\"viewTransfer\";i:3;s:14:\"deleteTransfer\";i:4;s:11:\"viewReturns\";i:5;s:13:\"notifications\";i:6;s:14:\"quantityAlerts\";}', 0, NULL, '2019-12-17 13:57:24', '2019-12-17 16:36:40', NULL, 1, NULL),
(5, 'Sales Person', 'a:6:{i:0;s:10:\"createSale\";i:1;s:10:\"updateSale\";i:2;s:8:\"viewSale\";i:3;s:10:\"deleteSale\";i:4;s:11:\"salesReport\";i:5;s:11:\"viewProfile\";}', 0, NULL, '2019-12-17 13:57:24', '2019-12-17 16:35:47', NULL, 1, NULL),
(6, 'Guest', 'a:1:{i:0;s:11:\"viewProfile\";}', 0, NULL, '2019-12-17 13:57:24', '2019-12-17 16:36:54', NULL, 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `role_user`
--

CREATE TABLE `role_user` (
  `role_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_user`
--

INSERT INTO `role_user` (`role_id`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 1, '2019-12-17 13:57:24', '2019-12-17 13:57:24');

-- --------------------------------------------------------

--
-- Table structure for table `stock`
--

CREATE TABLE `stock` (
  `id` int(10) UNSIGNED NOT NULL,
  `po_reference_code` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `receive_code` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `receive_date` date NOT NULL,
  `location` int(10) UNSIGNED NOT NULL,
  `remarks` text COLLATE utf8mb4_unicode_ci,
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '1=inactive,0=active',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_by` int(10) UNSIGNED DEFAULT NULL,
  `updated_by` int(10) UNSIGNED DEFAULT NULL,
  `deleted_by` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `stock`
--

INSERT INTO `stock` (`id`, `po_reference_code`, `receive_code`, `receive_date`, `location`, `remarks`, `status`, `deleted_at`, `created_at`, `updated_at`, `created_by`, `updated_by`, `deleted_by`) VALUES
(1, 'PO-000001', 'R-000001', '2019-10-17', 1, 'recive all', 0, NULL, '2019-10-17 15:30:59', '2019-10-17 15:30:59', 1, 1, NULL),
(2, 'PO-000002', 'R-000002', '2019-10-17', 2, 'partially receive', 0, NULL, '2019-10-17 15:31:41', '2019-10-17 15:31:41', 1, 1, NULL),
(3, 'INVOICE-S', 'IV-000001-S', '2019-10-17', 1, '', 0, NULL, '2019-10-17 15:44:15', '2019-10-17 15:44:15', 1, 1, NULL),
(4, 'INVOICE-S', 'IV-000002-S', '2019-10-17', 2, '', 0, NULL, '2019-10-17 15:53:22', '2019-10-17 15:53:22', 1, 1, NULL),
(5, 'TRANSFER-A', 'TR-000001-A', '2019-10-17', 2, 'test transfer', 0, NULL, '2019-10-17 16:15:23', '2019-10-17 16:15:23', 1, 1, NULL),
(6, 'TRANSFER-S', 'TR-000001-S', '2019-10-17', 1, 'test transfer', 0, NULL, '2019-10-17 16:15:23', '2019-10-17 16:15:23', 1, 1, NULL),
(7, 'RETURNS-A', 'RETURNS-000001-A', '2019-10-17', 1, '', 0, NULL, '2019-10-17 16:18:37', '2019-10-17 16:18:37', 1, 1, NULL),
(8, 'ADJUST-A', 'ADJUST-000001-A', '2019-10-18', 1, '', 0, NULL, '2019-10-18 10:39:43', '2019-10-18 10:39:43', 1, 1, NULL),
(9, 'PO-000004', 'R-000004', '2019-11-18', 2, NULL, 0, NULL, '2019-12-18 11:30:07', '2019-12-18 11:30:07', 1, 1, NULL),
(10, 'PO-000003', 'R-000003', '2019-11-18', 1, NULL, 0, NULL, '2019-12-18 11:30:20', '2019-12-18 11:30:20', 1, 1, NULL),
(11, 'INVOICE-S', 'IV-000003-S', '2019-11-18', 1, '', 0, NULL, '2019-12-18 11:31:36', '2019-12-18 11:31:36', 1, 1, NULL),
(12, 'INVOICE-S', 'IV-000004-S', '2019-11-18', 2, '', 0, NULL, '2019-12-18 11:32:48', '2019-12-18 11:32:48', 1, 1, NULL),
(15, 'TRANSFER-A', 'TR-000002-A', '2019-11-18', 1, NULL, 0, NULL, '2019-12-18 12:09:56', '2019-12-18 12:09:56', 1, 1, NULL),
(16, 'TRANSFER-S', 'TR-000002-S', '2019-11-18', 2, NULL, 0, NULL, '2019-12-18 12:09:56', '2019-12-18 12:09:56', 1, 1, NULL),
(17, 'PO-000005', 'R-000005', '2019-11-18', 2, NULL, 0, NULL, '2019-12-18 13:43:46', '2019-12-18 13:43:46', 1, 1, NULL),
(18, 'TRANSFER-A', 'TR-000003-A', '2019-11-18', 2, NULL, 0, NULL, '2019-12-18 13:46:11', '2019-12-18 13:46:11', 1, 1, NULL),
(19, 'TRANSFER-S', 'TR-000003-S', '2019-11-18', 1, NULL, 0, NULL, '2019-12-18 13:46:11', '2019-12-18 13:46:11', 1, 1, NULL),
(20, 'RETURNS-A', 'RETURNS-000002-A', '2019-11-18', 1, '', 0, NULL, '2019-12-18 14:06:51', '2019-12-18 14:06:51', 1, 1, NULL),
(21, 'ADJUST-S', 'ADJUST-000002-S', '2019-11-18', 1, '', 0, NULL, '2019-12-18 15:58:26', '2019-12-18 15:58:26', 1, 1, NULL),
(22, 'ADJUST-A', 'ADJUST-000003-A', '2019-12-18', 1, '', 0, NULL, '2019-12-18 16:12:53', '2019-12-18 16:12:53', 1, 1, NULL),
(23, 'INVOICE-S', 'IV-000005-S', '2019-12-18', 1, '', 0, NULL, '2019-12-18 16:13:52', '2019-12-18 16:13:52', 1, 1, NULL),
(24, 'INVOICE-S', 'IV-000006-S', '2019-12-18', 2, '', 0, NULL, '2019-12-18 16:14:52', '2019-12-18 16:14:52', 1, 1, NULL),
(25, 'PO-000006', 'R-000006', '2019-12-18', 2, NULL, 0, NULL, '2019-12-18 16:17:20', '2019-12-18 16:17:20', 1, 1, NULL),
(26, 'TRANSFER-A', 'TR-000004-A', '2019-12-18', 1, NULL, 0, NULL, '2019-12-18 16:17:49', '2019-12-18 16:17:49', 1, 1, NULL),
(27, 'TRANSFER-S', 'TR-000004-S', '2019-12-18', 2, NULL, 0, NULL, '2019-12-18 16:17:49', '2019-12-18 16:17:49', 1, 1, NULL),
(28, 'RETURNS-A', 'RETURNS-000003-A', '2019-12-18', 2, '', 0, NULL, '2019-12-18 16:18:19', '2019-12-18 16:18:19', 1, 1, NULL),
(29, 'ADJUST-S', 'ADJUST-000004-S', '2019-12-18', 2, '', 0, NULL, '2019-12-18 16:25:31', '2019-12-18 16:25:31', 1, 1, NULL),
(30, 'ADJUST-S', 'ADJUST-000005-S', '2019-12-18', 1, '', 0, NULL, '2019-12-18 16:26:28', '2019-12-18 16:26:28', 1, 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `stock_items`
--

CREATE TABLE `stock_items` (
  `id` int(10) UNSIGNED NOT NULL,
  `stock_id` int(10) UNSIGNED NOT NULL,
  `item_id` int(10) UNSIGNED NOT NULL,
  `qty` double NOT NULL,
  `cost_price` double NOT NULL,
  `tax_per` double DEFAULT NULL,
  `method` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'A' COMMENT 'add=A  , subtract=S',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `stock_items`
--

INSERT INTO `stock_items` (`id`, `stock_id`, `item_id`, `qty`, `cost_price`, `tax_per`, `method`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 100, 80, 0, 'A', '2019-12-17 15:30:59', '2019-12-17 15:30:59'),
(2, 1, 2, 100, 250, 20, 'A', '2019-12-17 15:30:59', '2019-12-17 15:30:59'),
(3, 2, 3, 50, 80, 20, 'A', '2019-12-17 15:31:41', '2019-12-17 15:31:41'),
(4, 2, 4, 50, 90, 20, 'A', '2019-12-17 15:31:41', '2019-12-17 15:31:41'),
(5, 3, 1, 10, 100, 20, 'S', '2019-12-17 15:44:15', '2019-12-17 15:44:15'),
(6, 4, 3, 5, 100, 20, 'S', '2019-12-17 15:53:22', '2019-12-17 15:53:22'),
(7, 4, 4, 5, 130, 20, 'S', '2019-12-17 15:53:22', '2019-12-17 15:53:22'),
(8, 5, 1, 20, 100, 0, 'A', '2019-12-17 16:15:23', '2019-12-17 16:15:23'),
(9, 6, 1, 20, 100, 0, 'S', '2019-12-17 16:15:23', '2019-12-17 16:15:23'),
(10, 5, 2, 5, 250, 0, 'A', '2019-12-17 16:15:23', '2019-12-17 16:15:23'),
(11, 6, 2, 5, 250, 0, 'S', '2019-12-17 16:15:23', '2019-12-17 16:15:23'),
(12, 7, 1, 10, 100, 0, 'A', '2019-12-17 16:18:37', '2019-12-17 16:18:37'),
(13, 7, 2, 5, 300, 0, 'A', '2019-12-17 16:18:37', '2019-12-17 16:18:37'),
(14, 7, 4, 10, 130, 0, 'A', '2019-12-17 16:18:37', '2019-12-17 16:18:37'),
(15, 8, 1, 10, 0, NULL, 'A', '2019-12-18 10:39:43', '2019-12-18 10:39:43'),
(16, 8, 4, 15, 0, NULL, 'A', '2019-12-18 10:39:43', '2019-12-18 10:39:43'),
(17, 9, 3, 200, 80, 20, 'A', '2019-12-18 11:30:07', '2019-12-18 11:30:07'),
(18, 9, 4, 300, 90, 0, 'A', '2019-12-18 11:30:07', '2019-12-18 11:30:07'),
(19, 10, 1, 50, 80, 0, 'A', '2019-12-18 11:30:20', '2019-12-18 11:30:20'),
(20, 10, 2, 25, 250, 0, 'A', '2019-12-18 11:30:20', '2019-12-18 11:30:20'),
(21, 11, 1, 10, 100, 0, 'S', '2019-12-18 11:31:36', '2019-12-18 11:31:36'),
(22, 11, 4, 25, 130, 0, 'S', '2019-12-18 11:31:36', '2019-12-18 11:31:36'),
(23, 12, 4, 30, 130, 0, 'S', '2019-12-18 11:32:48', '2019-12-18 11:32:48'),
(24, 12, 2, 5, 300, 0, 'S', '2019-12-18 11:32:48', '2019-12-18 11:32:48'),
(25, 15, 1, 10, 80, 0, 'A', '2019-12-18 12:09:56', '2019-12-18 12:09:56'),
(26, 16, 1, 10, 80, 0, 'S', '2019-12-18 12:09:56', '2019-12-18 12:09:56'),
(27, 15, 3, 10, 80, 0, 'A', '2019-12-18 12:09:56', '2019-12-18 12:09:56'),
(28, 16, 3, 10, 80, 0, 'S', '2019-12-18 12:09:56', '2019-12-18 12:09:56'),
(29, 17, 1, 5, 80, 0, 'A', '2019-12-18 13:43:46', '2019-12-18 13:43:46'),
(30, 18, 1, 2, 80, 0, 'A', '2019-12-18 13:46:11', '2019-12-18 13:46:11'),
(31, 19, 1, 2, 80, 0, 'S', '2019-12-18 13:46:11', '2019-12-18 13:46:11'),
(32, 20, 1, 15, 100, 20, 'A', '2019-12-18 14:06:51', '2019-12-18 14:06:51'),
(33, 21, 3, 2, 0, NULL, 'S', '2019-12-18 15:58:26', '2019-12-18 15:58:26'),
(34, 22, 1, 10, 0, NULL, 'A', '2019-12-18 16:12:53', '2019-12-18 16:12:53'),
(35, 22, 4, 10, 0, NULL, 'A', '2019-12-18 16:12:53', '2019-12-18 16:12:53'),
(36, 23, 1, 10, 100, 0, 'S', '2019-12-18 16:13:52', '2019-12-18 16:13:52'),
(37, 23, 2, 50, 300, 20, 'S', '2019-12-18 16:13:52', '2019-12-18 16:13:52'),
(38, 24, 1, 10, 100, 20, 'S', '2019-12-18 16:14:52', '2019-12-18 16:14:52'),
(39, 24, 4, 45, 130, 0, 'S', '2019-12-18 16:14:52', '2019-12-18 16:14:52'),
(40, 25, 1, 100, 80, 20, 'A', '2019-12-18 16:17:20', '2019-12-18 16:17:20'),
(41, 25, 2, 100, 250, 20, 'A', '2019-12-18 16:17:20', '2019-12-18 16:17:20'),
(42, 26, 1, 10, 80, 0, 'A', '2019-12-18 16:17:49', '2019-12-18 16:17:49'),
(43, 27, 1, 10, 80, 0, 'S', '2019-12-18 16:17:49', '2019-12-18 16:17:49'),
(44, 28, 1, 1, 100, 0, 'A', '2019-12-18 16:18:19', '2019-12-18 16:18:19'),
(45, 28, 2, 2, 300, 0, 'A', '2019-12-18 16:18:19', '2019-12-18 16:18:19'),
(46, 29, 4, 270, 0, NULL, 'S', '2019-12-18 16:25:31', '2019-12-18 16:25:31'),
(47, 30, 4, 5, 0, NULL, 'S', '2019-12-18 16:26:28', '2019-12-18 16:26:28');

-- --------------------------------------------------------

--
-- Table structure for table `stock_return`
--

CREATE TABLE `stock_return` (
  `id` int(10) UNSIGNED NOT NULL,
  `return_reference_code` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `location` int(10) UNSIGNED NOT NULL,
  `date` date DEFAULT NULL,
  `biller` int(10) UNSIGNED NOT NULL,
  `customer` int(10) UNSIGNED NOT NULL,
  `discount` double DEFAULT NULL,
  `discount_val_or_per` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tax_per` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tax_amount` double DEFAULT NULL,
  `grand_total` double NOT NULL,
  `return_type` int(11) NOT NULL DEFAULT '1' COMMENT '1=sr,2=mr',
  `return_note` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `staff_note` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '1=inactive,0=active',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_by` int(10) UNSIGNED DEFAULT NULL,
  `updated_by` int(10) UNSIGNED DEFAULT NULL,
  `deleted_by` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `stock_return`
--

INSERT INTO `stock_return` (`id`, `return_reference_code`, `location`, `date`, `biller`, `customer`, `discount`, `discount_val_or_per`, `tax_per`, `tax_amount`, `grand_total`, `return_type`, `return_note`, `staff_note`, `status`, `deleted_at`, `created_at`, `updated_at`, `created_by`, `updated_by`, `deleted_by`) VALUES
(1, 'RETURNS-000001', 1, '2019-10-17', 1, 1, 5, '5', '0', 0, 3795, 1, 'test return note', 'test return staff note', 0, NULL, '2019-10-17 16:18:37', '2019-10-17 16:18:37', 1, 1, NULL),
(2, 'RETURNS-000002', 1, '2019-11-18', 1, 1, 50, '50', '20', 260, 1560, 1, NULL, NULL, 0, NULL, '2019-11-18 14:06:51', '2019-11-18 14:06:51', 1, 1, NULL),
(3, 'RETURNS-000003', 2, '2019-12-18', 1, 1, 0, '0', '20', 140, 840, 1, NULL, NULL, 0, NULL, '2019-12-18 16:18:19', '2019-12-18 16:18:19', 1, 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `stock_return_details`
--

CREATE TABLE `stock_return_details` (
  `id` int(10) UNSIGNED NOT NULL,
  `return_id` int(10) UNSIGNED NOT NULL,
  `item_id` int(10) UNSIGNED NOT NULL,
  `qty` double NOT NULL,
  `selling_price` double NOT NULL,
  `tax_val` double DEFAULT NULL,
  `tax_per` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `discount` double DEFAULT NULL,
  `sub_total` double NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `stock_return_details`
--

INSERT INTO `stock_return_details` (`id`, `return_id`, `item_id`, `qty`, `selling_price`, `tax_val`, `tax_per`, `discount`, `sub_total`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 10, 100, 0, '0', 0, 1000, '2019-10-17 16:18:37', '2019-10-17 16:18:37'),
(2, 1, 2, 5, 300, 0, '0', 0, 1500, '2019-10-17 16:18:37', '2019-10-17 16:18:37'),
(3, 1, 4, 10, 130, 0, '0', 0, 1300, '2019-10-17 16:18:37', '2019-10-17 16:18:37'),
(4, 2, 1, 15, 100, 15, '20', 150, 1350, '2019-11-18 14:06:51', '2019-11-18 14:06:51'),
(5, 3, 1, 1, 100, 0, '0', 0, 100, '2019-12-18 16:18:19', '2019-12-18 16:18:19'),
(6, 3, 2, 2, 300, 0, '0', 0, 600, '2019-12-18 16:18:19', '2019-12-18 16:18:19');

-- --------------------------------------------------------

--
-- Table structure for table `supplier`
--

CREATE TABLE `supplier` (
  `id` int(10) UNSIGNED NOT NULL,
  `company` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '1=inactive,0=active',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_by` int(10) UNSIGNED DEFAULT NULL,
  `updated_by` int(10) UNSIGNED DEFAULT NULL,
  `deleted_by` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `supplier`
--

INSERT INTO `supplier` (`id`, `company`, `name`, `address`, `phone`, `email`, `status`, `deleted_at`, `created_at`, `updated_at`, `created_by`, `updated_by`, `deleted_by`) VALUES
(1, 'wijaya', 'wijaya-Paranagama', 'wijaya-Paranagama , address, Galle', '0711513461', 'harshan.dilantha@gmail.com', 0, NULL, NULL, '2019-12-17 16:29:02', NULL, 1, NULL),
(2, 'wijaya', 'wijaya-Amarathunga', 'wijaya-Amarathunga , address, Galle', '0711513461', 'harshan.dilantha@gmail.com', 0, NULL, NULL, '2019-12-17 16:28:59', NULL, 1, NULL),
(3, 'wijaya', 'Freelan-Rajapaksha', 'Freelan-Rajapaksha , address, Galle', '0711513461', 'harshan.dilantha@gmail.com', 0, NULL, NULL, '2019-12-17 16:28:56', NULL, 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tax_profiles`
--

CREATE TABLE `tax_profiles` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `value` double NOT NULL DEFAULT '0',
  `type` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '1=inactive,0=active',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_by` int(10) UNSIGNED DEFAULT NULL,
  `updated_by` int(10) UNSIGNED DEFAULT NULL,
  `deleted_by` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tax_profiles`
--

INSERT INTO `tax_profiles` (`id`, `name`, `code`, `value`, `type`, `status`, `deleted_at`, `created_at`, `updated_at`, `created_by`, `updated_by`, `deleted_by`) VALUES
(1, 'No Tax', '0%', 0, 'Percentage', 0, NULL, '2019-08-20 12:27:51', '2019-08-28 05:51:10', NULL, NULL, NULL),
(2, '20 % tax', '20 %', 20, 'Percentage', 0, NULL, '2019-08-28 05:52:35', '2019-08-28 05:52:35', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `transfers`
--

CREATE TABLE `transfers` (
  `id` int(10) UNSIGNED NOT NULL,
  `tr_reference_code` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `receive_code` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'reference from stock',
  `tr_date` date NOT NULL,
  `from_location` int(10) UNSIGNED NOT NULL,
  `to_location` int(10) UNSIGNED NOT NULL,
  `tot_tax` double DEFAULT NULL,
  `grand_total` double NOT NULL,
  `remarks` text COLLATE utf8mb4_unicode_ci,
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '1=completed,2=pending,3=set,4=cancel',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_by` int(10) UNSIGNED DEFAULT NULL,
  `updated_by` int(10) UNSIGNED DEFAULT NULL,
  `deleted_by` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `transfers`
--

INSERT INTO `transfers` (`id`, `tr_reference_code`, `receive_code`, `tr_date`, `from_location`, `to_location`, `tot_tax`, `grand_total`, `remarks`, `status`, `deleted_at`, `created_at`, `updated_at`, `created_by`, `updated_by`, `deleted_by`) VALUES
(1, 'TR-000001', '', '2019-10-17', 1, 2, 0, 3250, 'test transfer', 2, NULL, '2019-10-17 16:15:23', '2019-10-17 16:15:23', 1, 1, NULL),
(2, 'TR-000002', '', '2019-11-18', 2, 1, 0, 1600, NULL, 2, NULL, '2019-11-18 12:09:56', '2019-11-18 12:09:56', 1, 1, NULL),
(3, 'TR-000003', '', '2019-11-18', 1, 2, 0, 160, NULL, 1, NULL, '2019-11-18 13:46:11', '2019-11-18 13:46:11', 1, 1, NULL),
(4, 'TR-000004', '', '2019-12-18', 2, 1, 0, 800, NULL, 1, NULL, '2019-12-18 16:17:49', '2019-12-18 16:17:49', 1, 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `avatar` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '/avatars/avatar.png',
  `phone` varchar(12) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gender` tinyint(4) DEFAULT NULL COMMENT '1=male,2=female',
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '1=inactive,0=active',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_by` int(10) UNSIGNED DEFAULT NULL,
  `updated_by` int(10) UNSIGNED DEFAULT NULL,
  `deleted_by` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `avatar`, `phone`, `gender`, `email_verified_at`, `password`, `status`, `deleted_at`, `remember_token`, `created_at`, `updated_at`, `created_by`, `updated_by`, `deleted_by`) VALUES
(1, 'Admin', 'admin@admin.com', '/avatars/avatar.png', NULL, 1, '2019-12-17 13:57:24', '$2y$10$Y940WFUlg.61qKWDkDBpdOe6QwqTiILnMFXNfqZyMLWi9/IOoTa1q', 0, NULL, NULL, '2019-12-17 13:57:24', '2019-12-17 13:57:24', NULL, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `adjustment`
--
ALTER TABLE `adjustment`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `adjustment_reference_code_unique` (`reference_code`),
  ADD KEY `adjustment_location_foreign` (`location`),
  ADD KEY `adjustment_created_by_foreign` (`created_by`),
  ADD KEY `adjustment_updated_by_foreign` (`updated_by`),
  ADD KEY `adjustment_deleted_by_foreign` (`deleted_by`);

--
-- Indexes for table `biller`
--
ALTER TABLE `biller`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `biller_name_unique` (`name`),
  ADD KEY `biller_created_by_foreign` (`created_by`),
  ADD KEY `biller_updated_by_foreign` (`updated_by`),
  ADD KEY `biller_deleted_by_foreign` (`deleted_by`);

--
-- Indexes for table `brands`
--
ALTER TABLE `brands`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `brands_brand_unique` (`brand`),
  ADD KEY `brands_created_by_foreign` (`created_by`),
  ADD KEY `brands_updated_by_foreign` (`updated_by`),
  ADD KEY `brands_deleted_by_foreign` (`deleted_by`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `categories_category_unique` (`category`),
  ADD KEY `categories_created_by_foreign` (`created_by`),
  ADD KEY `categories_updated_by_foreign` (`updated_by`),
  ADD KEY `categories_deleted_by_foreign` (`deleted_by`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `customer_name_unique` (`name`),
  ADD KEY `customer_created_by_foreign` (`created_by`),
  ADD KEY `customer_updated_by_foreign` (`updated_by`),
  ADD KEY `customer_deleted_by_foreign` (`deleted_by`);

--
-- Indexes for table `invoice`
--
ALTER TABLE `invoice`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `invoice_invoice_code_unique` (`invoice_code`),
  ADD KEY `invoice_location_foreign` (`location`),
  ADD KEY `invoice_biller_foreign` (`biller`),
  ADD KEY `invoice_customer_foreign` (`customer`),
  ADD KEY `invoice_created_by_foreign` (`created_by`),
  ADD KEY `invoice_updated_by_foreign` (`updated_by`),
  ADD KEY `invoice_deleted_by_foreign` (`deleted_by`);

--
-- Indexes for table `invoice_details`
--
ALTER TABLE `invoice_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `invoice_details_invoice_id_foreign` (`invoice_id`),
  ADD KEY `invoice_details_item_id_foreign` (`item_id`);

--
-- Indexes for table `locations`
--
ALTER TABLE `locations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `locations_name_unique` (`name`),
  ADD KEY `locations_created_by_foreign` (`created_by`),
  ADD KEY `locations_updated_by_foreign` (`updated_by`),
  ADD KEY `locations_deleted_by_foreign` (`deleted_by`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `payments_reference_code_unique` (`reference_code`),
  ADD KEY `payments_created_by_foreign` (`created_by`),
  ADD KEY `payments_updated_by_foreign` (`updated_by`),
  ADD KEY `payments_deleted_by_foreign` (`deleted_by`);

--
-- Indexes for table `po_details`
--
ALTER TABLE `po_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `po_details_po_header_foreign` (`po_header`),
  ADD KEY `po_details_item_id_foreign` (`item_id`);

--
-- Indexes for table `po_header`
--
ALTER TABLE `po_header`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `po_header_referencecode_unique` (`referenceCode`),
  ADD KEY `po_header_location_foreign` (`location`),
  ADD KEY `po_header_supplier_foreign` (`supplier`),
  ADD KEY `po_header_created_by_foreign` (`created_by`),
  ADD KEY `po_header_updated_by_foreign` (`updated_by`),
  ADD KEY `po_header_deleted_by_foreign` (`deleted_by`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `products_item_code_unique` (`item_code`),
  ADD UNIQUE KEY `products_name_unique` (`name`),
  ADD UNIQUE KEY `products_short_name_unique` (`short_name`),
  ADD KEY `products_category_foreign` (`category`),
  ADD KEY `products_brand_foreign` (`brand`),
  ADD KEY `products_created_by_foreign` (`created_by`),
  ADD KEY `products_updated_by_foreign` (`updated_by`),
  ADD KEY `products_deleted_by_foreign` (`deleted_by`);

--
-- Indexes for table `products_supplier`
--
ALTER TABLE `products_supplier`
  ADD PRIMARY KEY (`products_id`,`supplier_id`);

--
-- Indexes for table `product_brand`
--
ALTER TABLE `product_brand`
  ADD PRIMARY KEY (`product_id`,`brand_id`);

--
-- Indexes for table `product_category`
--
ALTER TABLE `product_category`
  ADD PRIMARY KEY (`product_id`,`category_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_unique` (`name`),
  ADD KEY `roles_created_by_foreign` (`created_by`),
  ADD KEY `roles_updated_by_foreign` (`updated_by`),
  ADD KEY `roles_deleted_by_foreign` (`deleted_by`);

--
-- Indexes for table `role_user`
--
ALTER TABLE `role_user`
  ADD PRIMARY KEY (`role_id`,`user_id`);

--
-- Indexes for table `stock`
--
ALTER TABLE `stock`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `stock_receive_code_unique` (`receive_code`),
  ADD KEY `stock_location_foreign` (`location`),
  ADD KEY `stock_created_by_foreign` (`created_by`),
  ADD KEY `stock_updated_by_foreign` (`updated_by`),
  ADD KEY `stock_deleted_by_foreign` (`deleted_by`);

--
-- Indexes for table `stock_items`
--
ALTER TABLE `stock_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `stock_items_stock_id_foreign` (`stock_id`),
  ADD KEY `stock_items_item_id_foreign` (`item_id`);

--
-- Indexes for table `stock_return`
--
ALTER TABLE `stock_return`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `stock_return_return_reference_code_unique` (`return_reference_code`),
  ADD KEY `stock_return_location_foreign` (`location`),
  ADD KEY `stock_return_biller_foreign` (`biller`),
  ADD KEY `stock_return_customer_foreign` (`customer`),
  ADD KEY `stock_return_created_by_foreign` (`created_by`),
  ADD KEY `stock_return_updated_by_foreign` (`updated_by`),
  ADD KEY `stock_return_deleted_by_foreign` (`deleted_by`);

--
-- Indexes for table `stock_return_details`
--
ALTER TABLE `stock_return_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `stock_return_details_return_id_foreign` (`return_id`),
  ADD KEY `stock_return_details_item_id_foreign` (`item_id`);

--
-- Indexes for table `supplier`
--
ALTER TABLE `supplier`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `supplier_name_unique` (`name`),
  ADD KEY `supplier_created_by_foreign` (`created_by`),
  ADD KEY `supplier_updated_by_foreign` (`updated_by`),
  ADD KEY `supplier_deleted_by_foreign` (`deleted_by`);

--
-- Indexes for table `tax_profiles`
--
ALTER TABLE `tax_profiles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `tax_profiles_name_unique` (`name`),
  ADD KEY `tax_profiles_created_by_foreign` (`created_by`),
  ADD KEY `tax_profiles_updated_by_foreign` (`updated_by`),
  ADD KEY `tax_profiles_deleted_by_foreign` (`deleted_by`);

--
-- Indexes for table `transfers`
--
ALTER TABLE `transfers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `transfers_from_location_foreign` (`from_location`),
  ADD KEY `transfers_to_location_foreign` (`to_location`),
  ADD KEY `transfers_created_by_foreign` (`created_by`),
  ADD KEY `transfers_updated_by_foreign` (`updated_by`),
  ADD KEY `transfers_deleted_by_foreign` (`deleted_by`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `users_created_by_foreign` (`created_by`),
  ADD KEY `users_updated_by_foreign` (`updated_by`),
  ADD KEY `users_deleted_by_foreign` (`deleted_by`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `adjustment`
--
ALTER TABLE `adjustment`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `biller`
--
ALTER TABLE `biller`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `brands`
--
ALTER TABLE `brands`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `invoice`
--
ALTER TABLE `invoice`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `invoice_details`
--
ALTER TABLE `invoice_details`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `locations`
--
ALTER TABLE `locations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `po_details`
--
ALTER TABLE `po_details`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `po_header`
--
ALTER TABLE `po_header`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `stock`
--
ALTER TABLE `stock`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `stock_items`
--
ALTER TABLE `stock_items`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `stock_return`
--
ALTER TABLE `stock_return`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `stock_return_details`
--
ALTER TABLE `stock_return_details`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `supplier`
--
ALTER TABLE `supplier`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tax_profiles`
--
ALTER TABLE `tax_profiles`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `transfers`
--
ALTER TABLE `transfers`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `adjustment`
--
ALTER TABLE `adjustment`
  ADD CONSTRAINT `adjustment_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `adjustment_deleted_by_foreign` FOREIGN KEY (`deleted_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `adjustment_location_foreign` FOREIGN KEY (`location`) REFERENCES `locations` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `adjustment_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `biller`
--
ALTER TABLE `biller`
  ADD CONSTRAINT `biller_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `biller_deleted_by_foreign` FOREIGN KEY (`deleted_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `biller_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `brands`
--
ALTER TABLE `brands`
  ADD CONSTRAINT `brands_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `brands_deleted_by_foreign` FOREIGN KEY (`deleted_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `brands_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `categories`
--
ALTER TABLE `categories`
  ADD CONSTRAINT `categories_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `categories_deleted_by_foreign` FOREIGN KEY (`deleted_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `categories_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `customer`
--
ALTER TABLE `customer`
  ADD CONSTRAINT `customer_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `customer_deleted_by_foreign` FOREIGN KEY (`deleted_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `customer_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `invoice`
--
ALTER TABLE `invoice`
  ADD CONSTRAINT `invoice_biller_foreign` FOREIGN KEY (`biller`) REFERENCES `biller` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `invoice_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `invoice_customer_foreign` FOREIGN KEY (`customer`) REFERENCES `customer` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `invoice_deleted_by_foreign` FOREIGN KEY (`deleted_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `invoice_location_foreign` FOREIGN KEY (`location`) REFERENCES `locations` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `invoice_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `invoice_details`
--
ALTER TABLE `invoice_details`
  ADD CONSTRAINT `invoice_details_invoice_id_foreign` FOREIGN KEY (`invoice_id`) REFERENCES `invoice` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `invoice_details_item_id_foreign` FOREIGN KEY (`item_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `locations`
--
ALTER TABLE `locations`
  ADD CONSTRAINT `locations_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `locations_deleted_by_foreign` FOREIGN KEY (`deleted_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `locations_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `payments_deleted_by_foreign` FOREIGN KEY (`deleted_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `payments_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `po_details`
--
ALTER TABLE `po_details`
  ADD CONSTRAINT `po_details_item_id_foreign` FOREIGN KEY (`item_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `po_details_po_header_foreign` FOREIGN KEY (`po_header`) REFERENCES `po_header` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `po_header`
--
ALTER TABLE `po_header`
  ADD CONSTRAINT `po_header_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `po_header_deleted_by_foreign` FOREIGN KEY (`deleted_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `po_header_location_foreign` FOREIGN KEY (`location`) REFERENCES `locations` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `po_header_supplier_foreign` FOREIGN KEY (`supplier`) REFERENCES `supplier` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `po_header_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_brand_foreign` FOREIGN KEY (`brand`) REFERENCES `brands` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `products_category_foreign` FOREIGN KEY (`category`) REFERENCES `categories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `products_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `products_deleted_by_foreign` FOREIGN KEY (`deleted_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `products_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `roles`
--
ALTER TABLE `roles`
  ADD CONSTRAINT `roles_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `roles_deleted_by_foreign` FOREIGN KEY (`deleted_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `roles_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `stock`
--
ALTER TABLE `stock`
  ADD CONSTRAINT `stock_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `stock_deleted_by_foreign` FOREIGN KEY (`deleted_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `stock_location_foreign` FOREIGN KEY (`location`) REFERENCES `locations` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `stock_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `stock_items`
--
ALTER TABLE `stock_items`
  ADD CONSTRAINT `stock_items_item_id_foreign` FOREIGN KEY (`item_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `stock_items_stock_id_foreign` FOREIGN KEY (`stock_id`) REFERENCES `stock` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `stock_return`
--
ALTER TABLE `stock_return`
  ADD CONSTRAINT `stock_return_biller_foreign` FOREIGN KEY (`biller`) REFERENCES `biller` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `stock_return_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `stock_return_customer_foreign` FOREIGN KEY (`customer`) REFERENCES `customer` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `stock_return_deleted_by_foreign` FOREIGN KEY (`deleted_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `stock_return_location_foreign` FOREIGN KEY (`location`) REFERENCES `locations` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `stock_return_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `stock_return_details`
--
ALTER TABLE `stock_return_details`
  ADD CONSTRAINT `stock_return_details_item_id_foreign` FOREIGN KEY (`item_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `stock_return_details_return_id_foreign` FOREIGN KEY (`return_id`) REFERENCES `stock_return` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `supplier`
--
ALTER TABLE `supplier`
  ADD CONSTRAINT `supplier_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `supplier_deleted_by_foreign` FOREIGN KEY (`deleted_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `supplier_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tax_profiles`
--
ALTER TABLE `tax_profiles`
  ADD CONSTRAINT `tax_profiles_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tax_profiles_deleted_by_foreign` FOREIGN KEY (`deleted_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tax_profiles_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `transfers`
--
ALTER TABLE `transfers`
  ADD CONSTRAINT `transfers_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `transfers_deleted_by_foreign` FOREIGN KEY (`deleted_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `transfers_from_location_foreign` FOREIGN KEY (`from_location`) REFERENCES `locations` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `transfers_to_location_foreign` FOREIGN KEY (`to_location`) REFERENCES `locations` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `transfers_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `users_deleted_by_foreign` FOREIGN KEY (`deleted_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `users_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
