-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 12, 2019 at 06:53 PM
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
(6, 'ADJUST-000001', '2019-08-29', 2, 'dasd updated', 0, NULL, '2019-08-29 00:52:03', '2019-08-29 05:33:41', 1, 1, NULL),
(7, 'ADJUST-000002', '2019-09-05', 2, NULL, 0, NULL, '2019-09-04 23:16:27', '2019-09-04 23:16:27', 2, 1, NULL),
(8, 'ADJUST-000003', '2019-09-06', 2, NULL, 0, NULL, '2019-09-06 09:36:42', '2019-09-06 09:36:42', 1, 1, NULL);

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
(1, 'biller 1', 'biller name', 'harshan.dilantha@gmail.com', '0711513461', 'kinihitiyagoda, narawala,poddala,galle, house', 'biller footer', 0, NULL, '2019-08-23 09:46:07', '2019-09-04 12:26:18', 1, 1, 1);

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
(1, 'wijaya', 'wijaya', NULL, 0, NULL, '2019-08-16 12:00:00', '2019-08-16 12:00:00', NULL, NULL, NULL),
(2, 'matara freelond', 'matara freelond', NULL, 0, NULL, '2019-09-15 01:35:58', '2019-09-15 01:35:58', 1, 1, NULL);

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
(1, 'f-0', 'food', NULL, 0, NULL, '2019-08-16 12:00:16', '2019-08-16 12:00:16', NULL, NULL, NULL),
(2, 'clothes', 'clothes', NULL, 0, NULL, '2019-09-15 00:54:38', '2019-09-15 00:54:38', 1, 1, NULL);

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
(1, 'harshan company 1', 'harshan customer1', 'harshan.dilantha@gmail.com', '0711513461', 'asdf, kjadhkdna updated 2', 0, NULL, '2019-08-23 01:21:34', '2019-09-04 12:26:38', 1, 1, NULL),
(2, 'biller 1', 'sdasdd', 'biller@gmail.com', '0711513461', 'kinihitiyagoda, narawala,poddala,galle, house', 0, '2019-08-31 05:46:02', '2019-08-23 09:44:19', '2019-08-31 05:46:02', 1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `gtn`
--

CREATE TABLE `gtn` (
  `id` int(10) UNSIGNED NOT NULL,
  `location` int(10) UNSIGNED NOT NULL,
  `destination_location` int(10) UNSIGNED NOT NULL,
  `remarks` text COLLATE utf8mb4_unicode_ci,
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '1=inactive,0=active',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `invoice`
--

CREATE TABLE `invoice` (
  `id` int(10) UNSIGNED NOT NULL,
  `invoice_code` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `location` int(10) UNSIGNED NOT NULL,
  `biller` int(10) UNSIGNED NOT NULL,
  `customer` int(10) NOT NULL,
  `discount` double DEFAULT NULL,
  `discount_val_or_per` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tax_amount` double DEFAULT NULL,
  `tax_per` double DEFAULT NULL,
  `invoice_grand_total` double NOT NULL,
  `invoice_date` date NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '1=inactive,0=active',
  `sales_status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '1=completed,0=pending',
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
(14, 'IV-000008', 2, 1, 1, 0, '0.00', 0, 0, 100, '2019-09-02', 0, 2, 2, NULL, NULL, '2019-09-15 11:08:15', '2019-09-02 00:27:52', '2019-09-15 11:08:15', 1, 1, 1),
(18, 'IV-000012', 2, 1, 1, 0, '0', 0, 0, 100, '2019-09-02', 0, 2, 2, NULL, NULL, '2019-09-15 11:08:00', '2019-09-02 00:29:07', '2019-09-15 11:08:00', 1, 1, 1),
(19, 'IV-000013', 2, 1, 1, 5, '5.00', 197, 20, 1182, '2019-09-05', 0, 2, 2, NULL, NULL, NULL, '2019-09-05 05:36:35', '2019-11-11 06:45:33', 1, 1, NULL),
(20, 'IV-000014', 2, 1, 1, 0, '0', 0, NULL, 0, '2019-11-12', 0, 1, 1, NULL, NULL, NULL, '2019-11-12 11:16:09', '2019-11-12 11:16:09', 1, 1, NULL);

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
(17, 14, '', 1, 1, 100, 0, 0, 0, 100, '2019-09-02 00:27:52', '2019-09-02 00:27:52'),
(21, 18, '', 1, 1, 100, 0, 0, 0, 100, '2019-09-02 00:29:07', '2019-09-02 00:29:07'),
(22, 19, '', 4, 5, 200, 33, 20, 10, 990, '2019-09-05 05:36:35', '2019-09-15 10:53:08'),
(23, 20, '', 1, 1, 100, 0, 0, 0, 100, '2019-11-12 11:16:09', '2019-11-12 11:16:09');

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
(2, 'galle warehosue', 'g-w', 'kinihitiyagoda, narawala,poddala,galle, house', '0711513461', 'harshan.dilantha@gmail.com', 'harshan', 1, 0, NULL, '2019-08-21 11:04:08', '2019-08-28 06:39:55', NULL, 1, NULL),
(3, 'thudugala WH', 'thudugala', 'kinihitiyagoda, narawala,poddala,galle, house', '0711513461', 'harshan.dilantha@gmail.com', 'thudugala owner', 1, 0, NULL, '2019-09-04 12:17:43', '2019-09-04 12:18:00', 1, 1, 1);

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
(20, '2019_07_20_145248_create_gtn_table', 1),
(21, '2019_07_20_145259_create_gtn_details_table', 1),
(22, '2019_07_20_150243_create_grn_header_table', 1),
(23, '2019_07_20_150306_create_grn_details_table', 1),
(24, '2019_07_24_062236_create_role_user_pivot_table', 1),
(25, '2019_07_31_183840_create_products_supplier_pivot_table', 1),
(26, '2019_08_16_165830_create_stock_table', 1),
(27, '2019_08_16_165952_create_stock_items_table', 1),
(28, '2019_08_21_063351_create_transfers_table', 2),
(29, '2019_07_20_145106_create_invoice_details_table', 3),
(30, '2019_07_20_145048_create_invoice_table', 4),
(34, '2019_07_20_145146_create_stock_return_details_table', 6),
(35, '2019_07_20_145136_create_stock_return_table', 7),
(37, '2019_08_29_042718_create_adjustment_table', 8),
(38, '2019_09_03_053815_create_payments_table', 9),
(39, '2019_09_04_182056_create_sessions_table', 10);

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
(1, 'P-000001', 'PO/M-000003', '100', '2019-09-03', 'cash', NULL, NULL, NULL, '2019-09-03 03:22:28', '2019-09-03 03:22:28', 1, 1, NULL),
(2, 'P-000002', 'PO/M-000003', '120', '2019-09-03', 'cheque', '11220', NULL, NULL, '2019-09-03 03:45:01', '2019-09-03 03:45:01', 1, 1, NULL),
(3, 'P-000003', 'PO/M-000003', '50', '2019-09-03', 'cash', NULL, NULL, '2019-09-04 05:03:13', '2019-09-03 04:24:11', '2019-09-04 05:03:13', 1, 1, 1),
(4, 'P-000004', 'PO/M-000003', '10', '2019-09-03', 'cash', NULL, NULL, '2019-09-04 05:01:21', '2019-09-03 04:35:21', '2019-09-04 05:01:21', 1, 1, 1),
(5, 'P-000005', 'PO/M-000003', '20', '2019-09-03', 'cash', NULL, NULL, '2019-09-04 05:00:01', '2019-09-03 04:36:33', '2019-09-04 05:00:01', 1, 1, 1),
(6, 'P-000006', 'PO-000001', '100', '2019-09-03', 'cash', NULL, NULL, '2019-09-04 04:16:21', '2019-09-03 04:36:44', '2019-09-04 04:16:21', 1, 1, 1),
(7, 'P-000007', 'PO-000001', '32900', '2019-09-03', 'cash', NULL, NULL, '2019-09-06 08:29:55', '2019-09-03 04:38:31', '2019-09-06 08:29:55', 1, 1, 1),
(8, 'P-000008', 'PO-000001', '10', '2019-09-03', 'cash', NULL, NULL, NULL, '2019-09-03 04:38:43', '2019-09-03 04:38:43', 1, 1, NULL),
(9, 'P-000009', 'PO-000001', '12', '2019-09-03', 'cash', '87855', 'cach', '2019-09-04 04:55:36', '2019-09-03 04:41:42', '2019-09-04 04:55:36', 1, 1, 1),
(10, 'adaddas', 'PO/M-000003', '100', '2019-09-03', 'cash', NULL, NULL, '2019-09-04 04:58:16', '2019-09-03 11:31:46', '2019-09-04 04:58:16', 1, 1, 1),
(11, 'P-000010', 'PO/M-000003', '3', '2019-09-03', 'cash', NULL, 'noteee 3', '2019-09-03 12:23:40', '2019-09-03 11:32:22', '2019-09-03 12:23:40', 1, 1, 1),
(12, 'P-000011', 'PO/M-000004', '3', '2019-09-03', 'cheque', '12355', 'jighjsd13213213', '2019-09-04 04:57:44', '2019-09-03 11:46:26', '2019-09-04 04:57:44', 1, 1, 1),
(13, 'P-000012', 'PO/M-000004', '2', '2019-09-03', 'cash', NULL, '22', '2019-09-03 12:20:28', '2019-09-03 12:10:47', '2019-09-03 12:20:28', 1, 1, 1),
(14, 'P-000013', 'IV-000010', '11', '2019-09-03', 'cash', NULL, 'first add 2 hh', NULL, '2019-09-03 12:54:35', '2019-09-04 02:56:49', 1, 1, NULL),
(15, 'P-000014', 'PO/M-000002', '800', '2019-09-04', 'cash', NULL, NULL, NULL, '2019-09-04 01:41:07', '2019-09-04 01:41:07', 1, 1, NULL),
(16, 'P-000015', 'PO-000001', '10', '2019-09-04', 'cash', NULL, NULL, '2019-09-04 04:16:12', '2019-09-04 01:43:48', '2019-09-04 04:16:12', 1, 1, 1),
(17, 'P-000016', 'IV-000006', '10', '2019-09-04', 'cash', NULL, NULL, NULL, '2019-09-04 01:46:24', '2019-09-04 01:46:24', 1, 1, NULL),
(18, 'P-000017', 'IV-000006', '1', '2019-09-04', 'cash', NULL, NULL, NULL, '2019-09-04 04:08:48', '2019-09-04 04:08:48', 1, 1, NULL);

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
(1, 1, 1, 80, 1, 0, 0, 0, 0, 80, '2019-09-06 06:35:18', '2019-09-06 06:35:18');

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
  `tax` double UNSIGNED NOT NULL DEFAULT '0',
  `tax_percentage` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `discount` double UNSIGNED NOT NULL,
  `discount_val_or_per` double UNSIGNED NOT NULL DEFAULT '0',
  `grand_total` double UNSIGNED NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '1=received,2=ordered,3=pending,4=canceled',
  `payment_status` tinyint(2) NOT NULL DEFAULT '1' COMMENT '1=pending,2=due,3=partial,4=paid	',
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

INSERT INTO `po_header` (`id`, `location`, `supplier`, `referenceCode`, `due_date`, `tax`, `tax_percentage`, `discount`, `discount_val_or_per`, `grand_total`, `status`, `payment_status`, `remark`, `deleted_at`, `created_at`, `updated_at`, `created_by`, `updated_by`, `deleted_by`) VALUES
(1, 2, 1, 'PO-000001', '2019-09-06', 0, 0, 0, 0, 80, 1, 3, NULL, NULL, '2019-09-06 06:35:18', '2019-09-06 08:29:55', 1, 1, NULL);

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
(1, NULL, '121', 'ch250', 'chili pieces 250', 'chili pieces 250', '', 'products/default.jpg', 1, 1, 100, 80, 0.25, '3', 0, 0, 1, 0, 2, 0, NULL, '2019-08-16 12:03:24', '2019-09-04 12:44:21', NULL, 1, NULL),
(2, NULL, '3s', 'nd5', 'noodles 5KG', 'noodles 5KG', '', 'products/s84gLk3JTnC7WB26XD6evdzXO5dR4v8chegNDVF7.jpeg', 1, 1, 300, 250, 5, '3', 0, 0, 1, 2, 1, 0, NULL, '2019-08-16 12:05:08', '2019-09-04 02:38:36', NULL, 1, NULL),
(3, NULL, '12005', 's100g', 'seeds 100g', 'seeds 100g', '', 'products/YFhOero6hAcCwxRUCSxYZqCCjy88MN4gREGykBlm.jpeg', 1, 1, 150, 100, 0.2, '2', 0, 100, 1, 2, 1, 0, NULL, '2019-08-20 12:34:41', '2019-09-05 05:32:32', NULL, 1, NULL),
(4, NULL, '1qweqw', 'C123', 'roast checkebn', NULL, '', 'products/dISa5zosMaEf0Nar3YQcVL7kaXPPo2WTUGvsZa1R.jpeg', 1, 1, 200, 150, 1.2, '1', 0, 101, 0, 0, 1, 0, NULL, '2019-08-31 08:01:43', '2019-09-05 05:15:06', 1, 1, NULL);

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
(3, 1, NULL, NULL),
(4, 1, NULL, NULL),
(4, 2, NULL, NULL);

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
(1, 'Admin', 'a:64:{i:0;s:10:\"createUser\";i:1;s:10:\"updateUser\";i:2;s:8:\"viewUser\";i:3;s:10:\"deleteUser\";i:4;s:10:\"createRole\";i:5;s:10:\"updateRole\";i:6;s:8:\"viewRole\";i:7;s:10:\"deleteRole\";i:8;s:11:\"createBrand\";i:9;s:11:\"updateBrand\";i:10;s:9:\"viewBrand\";i:11;s:11:\"deleteBrand\";i:12;s:14:\"createCategory\";i:13;s:14:\"updateCategory\";i:14;s:12:\"viewCategory\";i:15;s:14:\"deleteCategory\";i:16;s:12:\"createBiller\";i:17;s:12:\"updateBiller\";i:18;s:10:\"viewBiller\";i:19;s:12:\"deleteBiller\";i:20;s:14:\"createCustomer\";i:21;s:14:\"updateCustomer\";i:22;s:12:\"viewCustomer\";i:23;s:14:\"deleteCustomer\";i:24;s:14:\"createSupplier\";i:25;s:14:\"updateSupplier\";i:26;s:12:\"viewSupplier\";i:27;s:14:\"deleteSupplier\";i:28;s:15:\"createWarehouse\";i:29;s:15:\"updateWarehouse\";i:30;s:13:\"viewWarehouse\";i:31;s:15:\"deleteWarehouse\";i:32;s:13:\"createProduct\";i:33;s:13:\"updateProduct\";i:34;s:11:\"viewProduct\";i:35;s:13:\"deleteProduct\";i:36;s:11:\"createOrder\";i:37;s:11:\"updateOrder\";i:38;s:9:\"viewOrder\";i:39;s:11:\"deleteOrder\";i:40;s:10:\"createSale\";i:41;s:10:\"updateSale\";i:42;s:8:\"viewSale\";i:43;s:10:\"deleteSale\";i:44;s:14:\"createTransfer\";i:45;s:14:\"updateTransfer\";i:46;s:12:\"viewTransfer\";i:47;s:14:\"deleteTransfer\";i:48;s:16:\"createAdjustment\";i:49;s:16:\"updateAdjustment\";i:50;s:14:\"viewAdjustment\";i:51;s:16:\"deleteAdjustment\";i:52;s:13:\"createReturns\";i:53;s:13:\"updateReturns\";i:54;s:11:\"viewReturns\";i:55;s:13:\"deleteReturns\";i:56;s:9:\"createTax\";i:57;s:9:\"updateTax\";i:58;s:7:\"viewTax\";i:59;s:9:\"deleteTax\";i:60;s:10:\"viewPeople\";i:61;s:12:\"viewSettings\";i:62;s:11:\"viewReports\";i:63;s:11:\"viewProfile\";}', 0, NULL, '2019-08-18 23:45:05', '2019-08-31 05:56:23', NULL, 1, NULL),
(2, 'Employee', 'a:4:{i:0;s:10:\"createUser\";i:1;s:10:\"deleteUser\";i:2;s:9:\"viewOrder\";i:3;s:13:\"updateSetting\";}', 0, '2019-08-30 13:15:31', '2019-08-18 23:45:05', '2019-08-30 13:15:31', NULL, NULL, 1),
(3, 'Guest', 'a:1:{i:0;s:11:\"viewProfile\";}', 0, NULL, '2019-08-18 23:45:05', '2019-09-04 12:23:32', NULL, 1, NULL),
(4, 'new', 'a:4:{i:0;s:10:\"createUser\";i:1;s:10:\"deleteUser\";i:2;s:9:\"viewOrder\";i:3;s:13:\"updateSetting\";}', 0, '2019-08-30 13:15:05', '2019-08-30 12:07:12', '2019-08-30 13:15:05', NULL, 1, 1),
(5, 'dad', 'a:2:{i:0;s:10:\"createUser\";i:1;s:14:\"updateCategory\";}', 0, NULL, '2019-08-30 12:08:37', '2019-08-30 13:20:56', 1, 1, NULL);

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
(1, 1, '2019-08-18 23:45:05', '2019-08-18 23:45:05'),
(3, 2, '2019-08-30 05:44:40', '2019-08-30 05:44:40');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
(51, 'ADJUST-A', 'ADJUST-000001-A', '2019-08-29', 2, '', 0, NULL, '2019-08-29 00:52:03', '2019-08-29 00:52:03', NULL, NULL, NULL),
(52, 'ADJUST-S', 'ADJUST-000001-S', '2019-08-29', 2, '', 0, NULL, '2019-08-29 00:52:03', '2019-08-29 00:52:03', NULL, NULL, NULL),
(63, 'INVOICE-S', 'IV-000008-S', '2019-09-02', 2, '', 0, '2019-09-15 11:08:15', '2019-09-02 00:27:52', '2019-09-15 11:08:15', NULL, NULL, 1),
(67, 'INVOICE-S', 'IV-000012-S', '2019-09-02', 2, '', 0, '2019-09-15 11:08:00', '2019-09-02 00:29:07', '2019-09-15 11:08:00', NULL, NULL, 1),
(71, 'TRANSFER-A', 'TR-000013-A', '2019-09-04', 2, NULL, 0, NULL, '2019-09-04 09:21:08', '2019-09-04 09:21:08', NULL, NULL, NULL),
(72, 'ADJUST-A', 'ADJUST-000002-A', '2019-09-05', 2, '', 0, NULL, '2019-09-04 23:16:27', '2019-09-04 23:16:27', 1, 1, NULL),
(76, 'TRANSFER-A', 'TR-000001-A', '2019-09-05', 3, 'stock add to thudugala', 0, NULL, '2019-09-05 01:52:58', '2019-09-05 01:52:58', 1, 1, NULL),
(77, 'TRANSFER-S', 'TR-000001-S', '2019-09-05', 2, 'stock add to thudugala', 0, NULL, '2019-09-05 01:52:58', '2019-09-05 01:52:58', 1, 1, NULL),
(78, 'INVOICE-S', 'IV-000013-S', '2019-09-05', 2, '', 0, NULL, '2019-09-05 05:36:35', '2019-09-05 05:36:35', 1, 1, NULL),
(79, 'ADJUST-A', 'ADJUST-000003-A', '2019-09-06', 2, '', 0, NULL, '2019-09-06 09:36:42', '2019-09-06 09:36:42', 1, 1, NULL),
(80, 'INVOICE-S', 'IV-000014-S', '2019-11-12', 2, '', 0, NULL, '2019-11-12 11:16:09', '2019-11-12 11:16:09', 1, 1, NULL);

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
  `tax_per` double NOT NULL DEFAULT '0',
  `method` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'A' COMMENT 'add=A  , subtract=S',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `stock_items`
--

INSERT INTO `stock_items` (`id`, `stock_id`, `item_id`, `qty`, `cost_price`, `tax_per`, `method`, `created_at`, `updated_at`) VALUES
(88, 51, 1, 4, 0, 0, 'A', '2019-08-29 05:43:39', '2019-08-29 05:43:47'),
(101, 63, 1, 1, 100, 0, 'S', '2019-09-02 00:27:52', '2019-09-02 00:27:52'),
(105, 67, 1, 1, 100, 0, 'S', '2019-09-02 00:29:07', '2019-09-02 00:29:07'),
(110, 71, 1, 1, 80, 0, 'A', '2019-09-04 09:21:08', '2019-09-04 09:21:08'),
(111, 72, 4, 100, 0, 0, 'A', '2019-09-04 23:16:27', '2019-09-04 23:16:27'),
(112, 76, 4, 50, 150, 0, 'A', '2019-09-05 01:52:58', '2019-09-05 01:52:58'),
(113, 77, 4, 50, 150, 0, 'S', '2019-09-05 01:52:58', '2019-09-05 01:52:58'),
(114, 76, 1, 2, 80, 0, 'A', '2019-09-05 01:54:07', '2019-09-05 01:54:07'),
(115, 77, 1, 2, 80, 0, 'S', '2019-09-05 01:54:07', '2019-09-05 01:54:07'),
(116, 78, 4, 5, 200, 20, 'S', '2019-09-05 05:36:35', '2019-09-15 10:53:08'),
(117, 79, 1, 1, 0, 0, 'A', '2019-09-06 09:36:42', '2019-09-06 09:36:42'),
(118, 80, 1, 1, 100, 0, 'S', '2019-11-12 11:16:09', '2019-11-12 11:16:09');

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
(1, 'wijayaq', 'wijaya supllier', 'shdas,da asd,asdadh', '0711513461', 'harshan.dilantha@gmail.com', 0, NULL, NULL, '2019-09-04 11:36:36', NULL, NULL, NULL),
(2, 'sup 2', 'sup sds', 'kinihitiyagoda, narawala,poddala,galle, house', '0711513461', 'as@gmail.com', 0, NULL, '2019-08-22 12:39:19', '2019-08-22 12:39:19', NULL, NULL, NULL);

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
(1, 'TR-000001', '', '2019-09-05', 2, 3, 0, 7660, 'stock add to thudugala', 1, NULL, '2019-09-05 01:52:58', '2019-09-05 01:54:07', 1, 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `avatar` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '/img/avatar.png',
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
(1, 'Admin', 'admin@admin.com', 'avatars/VEGIr10Y9pucZltT3t2UU6JnC6iPZ3JK8855Jm8d.jpeg', NULL, 1, '2019-08-18 23:45:05', '$2y$10$kNJ1cZ5aZ8oHeMii48DE8.wBJi1gkm7hJwWu2nGuRr2AcMBVJpUTm', 0, NULL, NULL, '2019-08-18 23:45:05', '2019-08-30 05:36:23', NULL, NULL, NULL),
(2, 'harshan', 'dilantha@admin.com', '/avatars/avatar.png', '0711513461', 1, '2019-08-29 18:30:00', '$2y$10$wRICGNmv.vyYZF0n1gT77uMrXpKR5dhDim6JDuCyIMKfiJ/1YiF4q', 0, NULL, NULL, '2019-08-30 05:44:40', '2019-09-03 23:50:35', NULL, NULL, NULL);

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
-- Indexes for table `gtn`
--
ALTER TABLE `gtn`
  ADD PRIMARY KEY (`id`),
  ADD KEY `gtn_location_foreign` (`location`),
  ADD KEY `gtn_destination_location_foreign` (`destination_location`);

--
-- Indexes for table `invoice`
--
ALTER TABLE `invoice`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `invoice_invoice_code_unique` (`invoice_code`),
  ADD KEY `invoice_location_foreign` (`location`),
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
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD UNIQUE KEY `sessions_id_unique` (`id`);

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
  ADD KEY `stock_return_customer_id_foreign` (`customer`),
  ADD KEY `stock_return_created_by_foreign` (`created_by`),
  ADD KEY `stock_return_updated_by_foreign` (`updated_by`),
  ADD KEY `stock_return_deleted_by_foreign` (`deleted_by`);

--
-- Indexes for table `stock_return_details`
--
ALTER TABLE `stock_return_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `stock_return_details_return_id_foreign` (`return_id`),
  ADD KEY `stock_return_details_product_id_foreign` (`item_id`);

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
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

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
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `gtn`
--
ALTER TABLE `gtn`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `invoice`
--
ALTER TABLE `invoice`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `invoice_details`
--
ALTER TABLE `invoice_details`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `locations`
--
ALTER TABLE `locations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `po_details`
--
ALTER TABLE `po_details`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `po_header`
--
ALTER TABLE `po_header`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `stock`
--
ALTER TABLE `stock`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=81;

--
-- AUTO_INCREMENT for table `stock_items`
--
ALTER TABLE `stock_items`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=119;

--
-- AUTO_INCREMENT for table `stock_return`
--
ALTER TABLE `stock_return`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `stock_return_details`
--
ALTER TABLE `stock_return_details`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `supplier`
--
ALTER TABLE `supplier`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tax_profiles`
--
ALTER TABLE `tax_profiles`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `transfers`
--
ALTER TABLE `transfers`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

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
  ADD CONSTRAINT `biller_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `biller_deleted_by_foreign` FOREIGN KEY (`deleted_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `biller_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `brands`
--
ALTER TABLE `brands`
  ADD CONSTRAINT `brands_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `brands_deleted_by_foreign` FOREIGN KEY (`deleted_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `brands_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `categories`
--
ALTER TABLE `categories`
  ADD CONSTRAINT `categories_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `categories_deleted_by_foreign` FOREIGN KEY (`deleted_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `categories_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `customer`
--
ALTER TABLE `customer`
  ADD CONSTRAINT `customer_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `customer_deleted_by_foreign` FOREIGN KEY (`deleted_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `customer_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `gtn`
--
ALTER TABLE `gtn`
  ADD CONSTRAINT `gtn_destination_location_foreign` FOREIGN KEY (`destination_location`) REFERENCES `locations` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `gtn_location_foreign` FOREIGN KEY (`location`) REFERENCES `locations` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `invoice`
--
ALTER TABLE `invoice`
  ADD CONSTRAINT `invoice_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `invoice_deleted_by_foreign` FOREIGN KEY (`deleted_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `invoice_location_foreign` FOREIGN KEY (`location`) REFERENCES `locations` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `invoice_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

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
  ADD CONSTRAINT `locations_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `locations_deleted_by_foreign` FOREIGN KEY (`deleted_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `locations_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

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
  ADD CONSTRAINT `po_header_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `po_header_deleted_by_foreign` FOREIGN KEY (`deleted_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `po_header_location_foreign` FOREIGN KEY (`location`) REFERENCES `locations` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `po_header_supplier_foreign` FOREIGN KEY (`supplier`) REFERENCES `supplier` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `po_header_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_brand_foreign` FOREIGN KEY (`brand`) REFERENCES `brands` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `products_category_foreign` FOREIGN KEY (`category`) REFERENCES `categories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `products_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `products_deleted_by_foreign` FOREIGN KEY (`deleted_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `products_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `roles`
--
ALTER TABLE `roles`
  ADD CONSTRAINT `roles_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `roles_deleted_by_foreign` FOREIGN KEY (`deleted_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `roles_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `stock`
--
ALTER TABLE `stock`
  ADD CONSTRAINT `stock_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `stock_deleted_by_foreign` FOREIGN KEY (`deleted_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `stock_location_foreign` FOREIGN KEY (`location`) REFERENCES `locations` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `stock_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

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
  ADD CONSTRAINT `stock_return_customer_id_foreign` FOREIGN KEY (`customer`) REFERENCES `customer` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `stock_return_deleted_by_foreign` FOREIGN KEY (`deleted_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `stock_return_location_foreign` FOREIGN KEY (`location`) REFERENCES `locations` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `stock_return_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `stock_return_details`
--
ALTER TABLE `stock_return_details`
  ADD CONSTRAINT `stock_return_details_product_id_foreign` FOREIGN KEY (`item_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `stock_return_details_return_id_foreign` FOREIGN KEY (`return_id`) REFERENCES `stock_return` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `supplier`
--
ALTER TABLE `supplier`
  ADD CONSTRAINT `supplier_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `supplier_deleted_by_foreign` FOREIGN KEY (`deleted_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `supplier_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `tax_profiles`
--
ALTER TABLE `tax_profiles`
  ADD CONSTRAINT `tax_profiles_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `tax_profiles_deleted_by_foreign` FOREIGN KEY (`deleted_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `tax_profiles_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `transfers`
--
ALTER TABLE `transfers`
  ADD CONSTRAINT `transfers_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `transfers_deleted_by_foreign` FOREIGN KEY (`deleted_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `transfers_from_location_foreign` FOREIGN KEY (`from_location`) REFERENCES `locations` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `transfers_to_location_foreign` FOREIGN KEY (`to_location`) REFERENCES `locations` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `transfers_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `users_deleted_by_foreign` FOREIGN KEY (`deleted_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `users_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
