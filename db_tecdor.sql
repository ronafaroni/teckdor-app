-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Waktu pembuatan: 08 Bulan Mei 2025 pada 00.54
-- Versi server: 10.4.28-MariaDB
-- Versi PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_tecdor`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name_category` varchar(255) NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `categories`
--

INSERT INTO `categories` (`id`, `name_category`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'Living Room Furniture', NULL, '2025-02-01 00:35:49', '2025-02-01 00:35:49'),
(2, 'Bedroom Furniture', NULL, '2025-02-01 00:36:10', '2025-02-01 00:36:10'),
(3, 'Office Furniture', NULL, '2025-02-01 00:36:20', '2025-02-01 00:36:20'),
(4, 'Dining Room Furniture', NULL, '2025-02-01 00:36:32', '2025-02-01 00:36:32'),
(5, 'Outdoor Furniture', NULL, '2025-02-01 00:36:49', '2025-02-01 00:36:49');

-- --------------------------------------------------------

--
-- Struktur dari tabel `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `finishings`
--

CREATE TABLE `finishings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `finishings`
--

INSERT INTO `finishings` (`id`, `name`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'Varnish', NULL, '2025-05-07 03:51:30', '2025-05-07 04:08:14'),
(3, 'Natural', NULL, '2025-05-07 04:03:02', '2025-05-07 04:08:08');

-- --------------------------------------------------------

--
-- Struktur dari tabel `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(23, '2025_01_22_041342_create_categories_table', 1),
(24, '2025_01_22_041405_create_suppliers_table', 2),
(26, '0001_01_01_000000_create_users_table', 3),
(27, '2025_01_22_041357_create_products_table', 4),
(28, '2025_01_23_130745_create_product_imgs_table', 5),
(29, '2025_01_22_041351_create_orders_table', 6),
(30, '0001_01_01_000001_create_cache_table', 7),
(31, '0001_01_01_000002_create_jobs_table', 7),
(32, '2025_02_01_113912_add_code_order_to_orders', 8),
(33, '2025_02_03_140109_add_total_payment_to_orders', 9),
(35, '2025_02_03_134930_create_order_payments_table', 10),
(37, '2025_02_22_165637_create_order_progress_settings_table', 11),
(38, '2025_02_23_050530_create_order_progress_table', 12),
(39, '2025_02_24_063719_create_supplier_payments_table', 13),
(40, '2025_02_24_112608_add_supplier_payment_status_to_order', 14),
(41, '2025_05_07_103242_create_finishings_table', 15),
(42, '2025_05_07_112502_add_finishing_to_order_progress', 16);

-- --------------------------------------------------------

--
-- Struktur dari tabel `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `code_order` text DEFAULT NULL,
  `description` text DEFAULT NULL,
  `length` decimal(10,2) DEFAULT NULL,
  `width` decimal(10,2) DEFAULT NULL,
  `height` decimal(10,2) DEFAULT NULL,
  `qty` int(11) NOT NULL,
  `img_sample` varchar(255) DEFAULT NULL,
  `is_draft` varchar(255) NOT NULL,
  `status` varchar(255) DEFAULT NULL,
  `total_payment` int(11) DEFAULT NULL,
  `order_date` date DEFAULT NULL,
  `payment_status` varchar(255) DEFAULT NULL,
  `supplier_payment_status` varchar(255) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `orders`
--

INSERT INTO `orders` (`id`, `product_id`, `user_id`, `code_order`, `description`, `length`, `width`, `height`, `qty`, `img_sample`, `is_draft`, `status`, `total_payment`, `order_date`, `payment_status`, `supplier_payment_status`, `deleted_at`, `created_at`, `updated_at`) VALUES
(11, 2, 3, 'SN-6912-QZVB', 'This minimalist sofa features a sleek and contemporary design, perfect for modern homes. It combines simplicity and functionality, providing comfortable seating without sacrificing style. With its clean lines and neutral color palette, this sofa seamlessly blends into any living room, creating a calming atmosphere. The high-quality upholstery and durable frame ensure long-lasting use, while the compact size makes it an ideal choice for smaller spaces. Elevate your living space with this elegant and functional piece of furniture.', 200.00, 150.00, 50.00, 10, 'image_sample/eMSAvBaaI2GarIdOM2KPZjFGUIwTo4HSFphZimQW.jpg', 'false', 'approved', 2000000, '2025-02-03', 'Paid', 'paid', NULL, '2025-02-01 06:15:51', '2025-02-24 05:12:57'),
(12, 1, 3, 'SN-6912-QZVB', 'Embrace simplicity and elegance with our Minimalist Bed, designed to elevate your bedroom with clean lines and a sleek silhouette. Crafted with high-quality materials, this bed features a sturdy frame that ensures lasting durability while offering a contemporary aesthetic. Its minimalist design makes it a perfect fit for modern interiors, providing a serene and uncluttered sleeping space. Whether you\'re looking to maximize space or create a tranquil retreat, the Minimalist Bed is the ideal addition to your home.', 150.00, 250.00, 100.00, 15, 'image_sample/FAhhgnIYwahd79zI4kUDj2JE47k7FdKP1RcUEf1Y.jpg', 'false', 'approved', 1000000, '2025-02-03', 'Paid', NULL, NULL, '2025-02-01 06:16:57', '2025-02-05 13:13:52'),
(13, 2, 3, 'SN-3527-3BZP', 'Embrace simplicity and elegance with our Minimalist Bed, designed to elevate your bedroom with clean lines and a sleek silhouette. Crafted with high-quality materials, this bed features a sturdy frame that ensures lasting durability while offering a contemporary aesthetic. Its minimalist design makes it a perfect fit for modern interiors, providing a serene and uncluttered sleeping space. Whether you\'re looking to maximize space or create a tranquil retreat, the Minimalist Bed is the ideal addition to your home.', 150.00, 180.00, 75.00, 10, 'image_sample/VJ1XxOOXxAexVcl4dPrfran7bWjilIgGgNc89K7U.jpg', 'false', 'approved', 1500000, '2025-02-03', NULL, NULL, NULL, '2025-02-01 06:18:14', '2025-02-03 09:26:27'),
(23, 1, 3, 'SN-8558-9AG8', 'uiyi', 768.00, 868.00, 876.00, 10, 'image_sample/lWLFSEoqK8Ak0O2ffxGPfjgKjXQYfmWIC1iFKwtc.jpg', 'false', 'approved', 1500000, '2025-02-08', 'Paid', NULL, NULL, '2025-02-08 13:58:35', '2025-02-08 14:23:18'),
(25, 2, 3, 'SN.7148.BUR2', 'ljlkjljkl', 879.00, 9879.00, 989.00, 10, 'image_sample/dszlnWg2kRJmA8R4TSpbz1R4k5JSrQJGT2zZTz1q.jpg', 'false', 'approved', 2000000, '2025-02-08', NULL, NULL, NULL, '2025-02-08 14:03:33', '2025-02-08 14:05:24'),
(27, 1, 3, 'SN-9696-H5BF', NULL, NULL, NULL, NULL, 50, NULL, 'false', 'approved', 1000000, '2025-03-14', NULL, NULL, NULL, '2025-03-14 03:50:18', '2025-03-14 03:52:38'),
(34, 1, 3, 'SN-8559-4THS', NULL, NULL, NULL, NULL, 50, 'image_sample/XiP2Z56ZcS1azXvBBwOO6uvoL2FBWxjV5ARSNGR6.jpg', 'false', 'submission', NULL, NULL, NULL, NULL, NULL, '2025-03-14 05:41:43', '2025-03-14 05:44:51'),
(36, 1, 3, 'SN-2289-JQOU', NULL, NULL, NULL, NULL, 20, NULL, 'false', 'approved', 123, '2025-03-18', NULL, NULL, NULL, '2025-03-14 06:00:38', '2025-03-18 08:29:34'),
(37, 2, 3, 'SN.1252.QWMT', NULL, NULL, NULL, NULL, 30, 'image_sample/9qyh2wXVi5lGqi9UjaZiW92eb5qYBBIeZKvAWiEl.jpg', 'false', 'approved', 1000000, '2025-03-18', NULL, NULL, NULL, '2025-03-14 06:01:08', '2025-03-18 08:27:19'),
(40, 1, 3, NULL, NULL, NULL, NULL, NULL, 10, NULL, 'true', NULL, NULL, NULL, NULL, NULL, NULL, '2025-03-14 06:26:21', '2025-03-14 06:26:21'),
(41, 1, 3, NULL, NULL, NULL, NULL, NULL, 49, 'image_sample/XJKBU6YrwWZDZEecHd1tuCvhUP6iX2CQoIuwRUIy.jpg', 'true', NULL, NULL, NULL, NULL, NULL, NULL, '2025-03-17 22:17:36', '2025-03-17 22:17:36'),
(42, 2, 3, 'SN-3875-BNDS', NULL, NULL, NULL, NULL, 5, NULL, 'false', 'approved', 500000, '2025-05-07', NULL, NULL, NULL, '2025-05-07 03:00:21', '2025-05-07 03:04:59');

-- --------------------------------------------------------

--
-- Struktur dari tabel `order_payments`
--

CREATE TABLE `order_payments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code_order` varchar(255) NOT NULL,
  `order_id` bigint(20) UNSIGNED DEFAULT NULL,
  `total_payment` varchar(255) NOT NULL,
  `payment_status` varchar(255) NOT NULL,
  `payment_date` varchar(255) NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `order_payments`
--

INSERT INTO `order_payments` (`id`, `code_order`, `order_id`, `total_payment`, `payment_status`, `payment_date`, `deleted_at`, `created_at`, `updated_at`) VALUES
(47, 'SN-6912-QZVB', 12, '20000000', 'partially paid', '2025-02-07 11:00:13', NULL, '2025-02-07 04:00:13', '2025-02-07 04:00:13'),
(48, 'SN-6912-QZVB', 12, '10000000', 'partially paid', '2025-02-07 11:00:34', NULL, '2025-02-07 04:00:34', '2025-02-07 04:00:34'),
(56, 'SN-6912-QZVB', 12, '2000000', 'partially paid', '2025-02-22 16:19:30', NULL, '2025-02-22 09:19:30', '2025-02-22 09:19:30'),
(57, 'SN-6912-QZVB', 12, '3000000', 'partially paid', '2025-02-22 16:19:47', NULL, '2025-02-22 09:19:47', '2025-02-22 09:19:47'),
(58, 'SN-3875-BNDS', 42, '500000', 'partially paid', '2025-05-08 05:41:36', NULL, '2025-05-07 22:41:36', '2025-05-07 22:41:36'),
(59, 'SN-3875-BNDS', 42, '200000', 'partially paid', '2025-05-08 05:45:06', NULL, '2025-05-07 22:45:06', '2025-05-07 22:45:06');

-- --------------------------------------------------------

--
-- Struktur dari tabel `order_progress`
--

CREATE TABLE `order_progress` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code_order` varchar(255) NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `name_progress` varchar(255) DEFAULT NULL,
  `status` enum('progress','finish') NOT NULL DEFAULT 'progress',
  `finishing` varchar(255) NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `order_progress`
--

INSERT INTO `order_progress` (`id`, `code_order`, `order_id`, `name_progress`, `status`, `finishing`, `deleted_at`, `created_at`, `updated_at`) VALUES
(17, 'SN-6912-QZVB', 11, 'Order Received', 'progress', '', NULL, '2025-02-27 08:05:24', '2025-02-27 08:05:24'),
(18, 'SN-6912-QZVB', 11, 'Design Confirmation', 'progress', '', NULL, '2025-02-27 08:07:22', '2025-02-27 08:07:22'),
(20, 'SN-8558-9AG8', 23, 'Order Received', 'progress', '', NULL, '2025-02-27 08:55:18', '2025-02-27 08:55:18'),
(21, 'SN-8558-9AG8', 23, 'Quality Check (QC)', 'progress', '', NULL, '2025-02-27 09:12:20', '2025-02-27 09:12:20'),
(22, 'SN-8558-9AG8', 23, 'Assembly', 'progress', '', NULL, '2025-02-27 09:12:31', '2025-02-27 09:12:31'),
(27, 'SN-8558-9AG8', 23, 'Finishing', 'progress', '', NULL, '2025-02-27 09:20:48', '2025-02-27 09:20:48'),
(29, 'SN-8558-9AG8', 23, 'Finished', 'finish', '', NULL, '2025-02-27 09:25:29', '2025-02-27 09:25:29'),
(31, 'SN-6912-QZVB', 11, 'Finished', 'finish', '', NULL, '2025-02-27 14:14:15', '2025-02-27 14:14:15'),
(32, 'SN-6912-QZVB', 12, 'Finished', 'finish', '', NULL, '2025-03-15 00:15:46', '2025-03-15 00:15:46'),
(33, 'SN-3875-BNDS', 42, 'Order Received', 'progress', '', NULL, '2025-05-07 04:19:51', '2025-05-07 04:19:51'),
(34, 'SN-3875-BNDS', 42, 'Design Confirmation', 'progress', 'Varnish', NULL, '2025-05-07 04:32:44', '2025-05-07 04:32:44');

-- --------------------------------------------------------

--
-- Struktur dari tabel `order_progress_settings`
--

CREATE TABLE `order_progress_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name_progress` varchar(255) NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `order_progress_settings`
--

INSERT INTO `order_progress_settings` (`id`, `name_progress`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'Order Received', NULL, '2025-02-22 10:09:20', '2025-02-22 10:09:20'),
(2, 'Design Confirmation', NULL, '2025-02-22 10:09:42', '2025-02-22 10:09:42'),
(4, 'Production Started', NULL, '2025-02-22 10:10:12', '2025-02-22 10:10:12'),
(5, 'Quality Check (QC)', NULL, '2025-02-22 10:10:30', '2025-02-22 10:10:30'),
(6, 'Assemblys', NULL, '2025-02-22 10:10:43', '2025-05-07 04:12:30'),
(7, 'Finishing', NULL, '2025-02-22 10:10:56', '2025-02-22 10:10:56');

-- --------------------------------------------------------

--
-- Struktur dari tabel `order_shippings`
--

CREATE TABLE `order_shippings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code_shipping` varchar(255) NOT NULL,
  `order_id` int(11) NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `order_shippings`
--

INSERT INTO `order_shippings` (`id`, `code_shipping`, `order_id`, `deleted_at`, `created_at`, `updated_at`) VALUES
(33, 'SP-5790-9CD9', 23, NULL, '2025-03-15 00:20:55', '2025-03-15 00:20:55');

-- --------------------------------------------------------

--
-- Struktur dari tabel `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `supplier_id` bigint(20) UNSIGNED NOT NULL,
  `code_product` varchar(255) NOT NULL,
  `name_product` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `price` int(11) NOT NULL,
  `stock` int(11) NOT NULL,
  `length` decimal(10,2) DEFAULT NULL,
  `width` decimal(10,2) DEFAULT NULL,
  `height` decimal(10,2) DEFAULT NULL,
  `weight` decimal(10,2) DEFAULT NULL,
  `thumbnail` varchar(255) DEFAULT NULL,
  `status` enum('available','unavailable') NOT NULL DEFAULT 'available',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `products`
--

INSERT INTO `products` (`id`, `category_id`, `supplier_id`, `code_product`, `name_product`, `description`, `price`, `stock`, `length`, `width`, `height`, `weight`, `thumbnail`, `status`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 2, 2, 'P2754', 'Minimalist Bed', 'This bed features a clean, simple design with sleek lines and a neutral color palette. The frame is made from high-quality wood or metal, offering durability and stability. Its minimalist style ensures it fits seamlessly into any modern bedroom, creating a serene and clutter-free atmosphere. Ideal for those who appreciate a functional yet aesthetically pleasing design, the bed offers comfort without unnecessary embellishments.', 6000000, 100, 150.00, 120.00, 120.00, 30.00, 'thumbnail/GKdeO4YnwmvbccAeN5Lz5a8HS2K57p7HseNrtx2v.jpg', 'available', NULL, '2025-02-01 01:00:16', '2025-02-01 01:00:16'),
(2, 1, 5, 'P9363', 'Minimalist & Modern Sofa', 'This chair boasts a sleek, contemporary design, perfect for those who appreciate simplicity and elegance. Crafted from high-quality materials, its clean lines and neutral tones make it an ideal addition to any modern interior. The minimalist design eliminates excess details, focusing on comfort and functionality while maintaining a stylish and uncluttered look. Whether in a living room, office, or dining area, this chair complements various spaces with its timeless appeal.', 4500000, 25, 300.00, 120.00, 50.00, 15.00, 'thumbnail/QJr8eCeoqFjrDsTcKCZjbkobcP3pvqeTJ2i5exX1.jpg', 'available', NULL, '2025-02-01 01:08:57', '2025-03-18 01:50:15');

-- --------------------------------------------------------

--
-- Struktur dari tabel `product_imgs`
--

CREATE TABLE `product_imgs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `img_product` varchar(255) NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `product_imgs`
--

INSERT INTO `product_imgs` (`id`, `product_id`, `img_product`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 1, 'product_images/99uud5qQSIpcUTXWSajZw0AkfbokpcSoBr95tODp.jpg', NULL, '2025-02-01 01:00:16', '2025-02-01 01:00:16'),
(2, 1, 'product_images/uEmPm8EZkf1JjPQvZ3T2wIR62h340x4dV7lgYM8v.jpg', NULL, '2025-02-01 01:00:16', '2025-02-01 01:00:16'),
(3, 1, 'product_images/EJniLYbOxnF3uBTL24ccQQVmgLtIP9r1hk7l1AU8.png', NULL, '2025-02-01 01:00:16', '2025-02-01 01:00:16'),
(4, 1, 'product_images/6Cs8YjiJKWMI9GMTs8RNlgVoRUZQNCdMULn460Tn.png', NULL, '2025-02-01 01:00:16', '2025-02-01 01:00:16'),
(5, 1, 'product_images/SYHEYRmIy9I3RYEB53jrdIcK87DJYrrzX5xQIfKn.jpg', NULL, '2025-02-01 01:00:16', '2025-02-01 01:00:16'),
(6, 2, 'product_images/3d71Nolnq0dgW2ZT9QCdbmJpK3ls0ZkfC4zRcnyg.jpg', NULL, '2025-02-01 01:08:57', '2025-02-01 01:08:57'),
(7, 2, 'product_images/cKUhtBYernP3HU8X8lQZpP0RHNezi1u1zbXAlLSZ.jpg', NULL, '2025-02-01 01:10:46', '2025-02-01 01:10:46'),
(8, 2, 'product_images/JYWw5fHLywi5Lw9TexoIaqwDiR65Ew006pAcxO3m.jpg', NULL, '2025-02-01 01:11:09', '2025-02-01 01:11:09'),
(12, 2, 'product_images/1x78qgC2vKFmyZf5RX3L26AA2w5CRmuGLoATYKzj.jpg', NULL, '2025-03-18 01:50:16', '2025-03-18 01:50:16');

-- --------------------------------------------------------

--
-- Struktur dari tabel `product_stock`
--

CREATE TABLE `product_stock` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_code` varchar(20) NOT NULL,
  `stock` int(11) NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `product_stock`
--

INSERT INTO `product_stock` (`id`, `product_code`, `stock`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'P9363', 50, NULL, '2025-02-22 02:17:19', '2025-02-22 02:17:19'),
(2, 'P2754', 50, NULL, '2025-02-22 02:24:51', '2025-02-22 02:24:51'),
(4, 'P9363', 20, NULL, '2025-02-22 02:53:05', '2025-02-22 02:53:05'),
(5, 'P2754', 5, NULL, '2025-02-22 02:57:03', '2025-02-22 02:57:03'),
(6, 'P2754', 45, NULL, '2025-02-22 02:57:22', '2025-02-22 02:57:22'),
(7, 'P2754', 15, NULL, '2025-02-23 01:02:02', '2025-02-23 01:02:02');

-- --------------------------------------------------------

--
-- Struktur dari tabel `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('u6qW3XrNPUTI9fAcL8GDupUfnjiAhxZakuHgub7c', 1, '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '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', 1746658253);

-- --------------------------------------------------------

--
-- Struktur dari tabel `suppliers`
--

CREATE TABLE `suppliers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name_supplier` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `suppliers`
--

INSERT INTO `suppliers` (`id`, `name_supplier`, `address`, `phone`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'John Smith', '123 Maple Street, Springfield, IL 62701, USA', '089676544563', NULL, '2025-02-01 00:43:00', '2025-02-01 00:43:00'),
(2, 'Emily Johnson', '456 Oak Avenue, Los Angeles, CA 90001, USA', '089675654430', NULL, '2025-02-01 00:43:42', '2025-02-01 00:43:49'),
(5, 'David Lee', '654 Birch Lane, Sydney, NSW 2000, Australia', '089776546876', NULL, '2025-02-01 00:45:48', '2025-02-01 00:45:56');

-- --------------------------------------------------------

--
-- Struktur dari tabel `supplier_payments`
--

CREATE TABLE `supplier_payments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code_order` varchar(255) NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `supplier_id` bigint(20) UNSIGNED NOT NULL,
  `total_payment` varchar(255) NOT NULL,
  `payment_status` varchar(255) NOT NULL,
  `payment_date` varchar(255) NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `supplier_payments`
--

INSERT INTO `supplier_payments` (`id`, `code_order`, `order_id`, `product_id`, `supplier_id`, `total_payment`, `payment_status`, `payment_date`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'SN-6912-QZVB', 11, 2, 5, '10000000', 'partially paid', '2025-02-24 11:00:22', NULL, '2025-02-24 04:00:22', '2025-02-24 04:00:22'),
(5, 'SN-6912-QZVB', 11, 2, 5, '5000000', 'partially paid', '2025-02-24 11:15:53', NULL, '2025-02-24 04:15:53', '2025-02-24 04:15:53'),
(6, 'SN-6912-QZVB', 11, 2, 5, '3000000', 'partially paid', '2025-02-24 11:16:06', NULL, '2025-02-24 04:16:06', '2025-02-24 04:16:06'),
(9, 'SN-6912-QZVB', 11, 2, 5, '2000000', 'partially paid', '2025-02-24 11:43:17', NULL, '2025-02-24 04:43:17', '2025-02-24 04:43:17'),
(10, 'SN-6912-QZVB', 12, 1, 2, '10000000', 'partially paid', '2025-03-19 06:13:27', NULL, '2025-03-18 23:13:27', '2025-03-18 23:13:27'),
(11, 'SN-6912-QZVB', 12, 1, 2, '10000000', 'partially paid', '2025-03-19 06:13:37', NULL, '2025-03-18 23:13:37', '2025-03-18 23:13:37');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`, `deleted_at`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Administrator', 'admin@gmail.com', '$2y$12$OVX10wI2gQvz7XtZ.bToJuFMbcGIrqeG0zu5eOmC96VUbGLCkt3Ky', 'admin', NULL, NULL, '2025-02-01 00:27:10', '2025-02-01 00:27:10'),
(2, 'Finance', 'finance@gmail.com', '$2y$12$GqjRR3miHRf/sfSHU9tWk.Xk5iZCd8WRr0NGfkwln/NFfDBsKjHPG', 'finance', NULL, NULL, '2025-02-01 00:27:41', '2025-02-01 00:27:41'),
(3, 'Rona Faroni', 'ronafaroni95@gmail.com', '$2y$12$WMFzLh3UG/IDQCX5Zt5IHOx13RgjEovZ/3R0Th3f5iuanrEBFCXCe', 'customer', NULL, NULL, '2025-02-01 00:28:07', '2025-02-01 00:28:07'),
(4, 'Azizah Azzahra', 'azizah@gmail.com', '$2y$12$o6HHl47fCxfxlj0w32PU9Oiafx0Ib0azMI2lM.MWTdaDzkW7CRFRy', 'customer', NULL, NULL, '2025-02-02 00:00:15', '2025-02-02 00:00:15');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indeks untuk tabel `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indeks untuk tabel `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indeks untuk tabel `finishings`
--
ALTER TABLE `finishings`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indeks untuk tabel `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `orders_product_id_foreign` (`product_id`),
  ADD KEY `orders_user_id_foreign` (`user_id`);

--
-- Indeks untuk tabel `order_payments`
--
ALTER TABLE `order_payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_payments_order_id_foreign` (`order_id`);

--
-- Indeks untuk tabel `order_progress`
--
ALTER TABLE `order_progress`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `order_progress_settings`
--
ALTER TABLE `order_progress_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `order_shippings`
--
ALTER TABLE `order_shippings`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indeks untuk tabel `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `products_code_product_unique` (`code_product`),
  ADD KEY `products_category_id_foreign` (`category_id`),
  ADD KEY `products_supplier_id_foreign` (`supplier_id`);

--
-- Indeks untuk tabel `product_imgs`
--
ALTER TABLE `product_imgs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_imgs_product_id_foreign` (`product_id`);

--
-- Indeks untuk tabel `product_stock`
--
ALTER TABLE `product_stock`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indeks untuk tabel `suppliers`
--
ALTER TABLE `suppliers`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `supplier_payments`
--
ALTER TABLE `supplier_payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `supplier_payments_order_id_foreign` (`order_id`),
  ADD KEY `supplier_payments_product_id_foreign` (`product_id`),
  ADD KEY `supplier_payments_supplier_id_foreign` (`supplier_id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `finishings`
--
ALTER TABLE `finishings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT untuk tabel `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT untuk tabel `order_payments`
--
ALTER TABLE `order_payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- AUTO_INCREMENT untuk tabel `order_progress`
--
ALTER TABLE `order_progress`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT untuk tabel `order_progress_settings`
--
ALTER TABLE `order_progress_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `order_shippings`
--
ALTER TABLE `order_shippings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT untuk tabel `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `product_imgs`
--
ALTER TABLE `product_imgs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT untuk tabel `product_stock`
--
ALTER TABLE `product_stock`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `suppliers`
--
ALTER TABLE `suppliers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `supplier_payments`
--
ALTER TABLE `supplier_payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `orders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `order_payments`
--
ALTER TABLE `order_payments`
  ADD CONSTRAINT `order_payments_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `products_supplier_id_foreign` FOREIGN KEY (`supplier_id`) REFERENCES `suppliers` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `product_imgs`
--
ALTER TABLE `product_imgs`
  ADD CONSTRAINT `product_imgs_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `supplier_payments`
--
ALTER TABLE `supplier_payments`
  ADD CONSTRAINT `supplier_payments_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `supplier_payments_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `supplier_payments_supplier_id_foreign` FOREIGN KEY (`supplier_id`) REFERENCES `suppliers` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
