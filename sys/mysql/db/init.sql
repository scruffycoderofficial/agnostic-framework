SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

--
-- Database: `d6_invoicing_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `first_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mobile` bigint(20)  COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` text  COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `email`, `mobile`, `address`, `password`, `created_at`, `updated_at`) VALUES (1, 'Luyanda', 'Siko', 'luyandasiko@gmail.com', '0835982536', '9 Kowie Close, Leiden, Delft, Cape Town 8000', 'tester', '2024-01-23 12:56:58', '2024-01-23 12:56:58');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `date_recieved` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `receiver_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `receiver_address` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_before_tax` decimal(10,2)  COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_tax` decimal(10,2)  COLLATE utf8mb4_unicode_ci NOT NULL,
  `tax_per` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_after_tax` double(10,2) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `amount_paid` decimal(10,2) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `total_amount_due` decimal(10,2) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `note` text COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `date_recieved`, `receiver_name`, `receiver_address`, `total_before_tax`, `total_tax`, `tax_per`, `total_after_tax`, `amount_paid`, `total_amount_due`, `note`) VALUES (1, 123456, '2021-01-31 19:33:42', 'Luyanda Siko', '9 Kowie Close, \nLeiden, \nDelft, \nCape Town 8000\nsikoluyanda@gmail.com', 342400.00, 684800.00, '200', 1027200.00, 45454.00, 981746.00, 'This is a sample note attached to the Order of this Customer');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` bigint UNSIGNED NOT NULL,
  `order_id` bigint UNSIGNED NOT NULL,
  `item_code` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL,
  `item_name` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL,
  `order_item_quantity` decimal(10,2)  COLLATE utf8mb4_unicode_ci NOT NULL,
  `order_item_price` decimal(10,2)  COLLATE utf8mb4_unicode_ci NOT NULL,
  `order_item_final_amount` decimal(10,2)  COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `item_code`, `item_name`, `order_item_quantity`, `order_item_price`, `order_item_final_amount`) VALUES
(1, 1, '24', 'Face Mask', 120.00, 2000.00, 240000.00),
(2, 1, '34', 'mobile', 10.00, 10000.00, 100000.00),
(3, 1, '34', 'Mobile Battery', 1.00, 34343.00, 34343.00),
(4, 1, '34', 'Mobile Cover', 10.00, 200.00, 2000.00);

