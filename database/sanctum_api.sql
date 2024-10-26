-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 26, 2024 at 08:23 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sanctum_api`
--

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

CREATE TABLE `accounts` (
  `acId` bigint(20) UNSIGNED NOT NULL,
  `acTitle` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `mobile` varchar(255) DEFAULT NULL,
  `openingBal` double NOT NULL DEFAULT 0,
  `CurrentBal` double NOT NULL DEFAULT 0,
  `uId` bigint(20) UNSIGNED NOT NULL,
  `currencyId` bigint(20) UNSIGNED NOT NULL,
  `accTypeId` bigint(20) UNSIGNED NOT NULL,
  `parentId` bigint(20) UNSIGNED NOT NULL,
  `areaId` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `accounts`
--

INSERT INTO `accounts` (`acId`, `acTitle`, `email`, `mobile`, `openingBal`, `CurrentBal`, `uId`, `currencyId`, `accTypeId`, `parentId`, `areaId`, `created_at`, `updated_at`) VALUES
(2, 'Syed Burhan', 'syedburhan@gmail.com', '+923346013608', 0, 0, 1, 1, 2, 1, 2, '2024-10-14 03:33:12', '2024-10-17 03:53:30'),
(3, 'Qaiser Shameer', 'qaisershameer@gmail.com', '+923346013608', 0, 0, 1, 3, 6, 1, 2, '2024-10-14 03:37:00', '2024-10-16 02:47:28'),
(4, 'Farhad Ahmd', 'farhadahmd@gmail.com', '+923346013608', 0, 0, 1, 2, 2, 1, 3, '2024-10-14 03:40:05', '2024-10-17 03:52:22'),
(5, 'Syed Mustafa', 'syedmustafa@gmail.com', '+923346013609', 0, 0, 1, 7, 2, 1, 1, '2024-10-16 01:30:15', '2024-10-16 01:30:15'),
(6, 'Muhmmad Muzamil', 'muhmmadmuzamil@gmail.com', '+923346013608', 0, 0, 1, 2, 2, 1, 4, '2024-10-16 02:10:47', '2024-10-17 03:50:00'),
(7, 'Mujahid Ameen', 'mujahidameen@gmail.com', '+923346013608', 0, 0, 1, 2, 1, 1, 2, '2024-10-16 02:17:56', '2024-10-17 03:01:22'),
(12, 'Faizan Ayub', 'faizanayub@gmail.com', '+923346013608', 0, 0, 1, 1, 1, 1, 4, '2024-10-17 02:24:40', '2024-10-17 02:24:40'),
(13, 'ABL', 'abl@gmail.com', '+923346013608', 0, 0, 1, 1, 3, 1, 4, '2024-10-17 03:42:41', '2024-10-17 03:42:41'),
(15, 'HMB', 'hmb@gmail.com', '+923346013608', 0, 0, 1, 1, 3, 1, 4, '2024-10-17 03:43:11', '2024-10-17 03:43:11'),
(16, 'UBL', 'ubl@gmail.com', '+923346013608', 0, 0, 1, 1, 3, 1, 4, '2024-10-17 03:43:23', '2024-10-17 03:43:23'),
(17, 'HBL', 'hbl@gmail.com', '+923346013608', 0, 0, 1, 1, 3, 1, 4, '2024-10-17 03:49:49', '2024-10-17 03:49:49'),
(18, 'Danish Kaneria', 'danishkaneria@gmail.com', '+923346013608', 0, 0, 1, 1, 1, 1, 1, '2024-10-17 03:53:03', '2024-10-17 03:53:03');

-- --------------------------------------------------------

--
-- Table structure for table `accparent`
--

CREATE TABLE `accparent` (
  `parentId` bigint(20) UNSIGNED NOT NULL,
  `accParentTitle` varchar(255) NOT NULL,
  `accTypeId` bigint(20) UNSIGNED NOT NULL,
  `uId` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `accparent`
--

INSERT INTO `accparent` (`parentId`, `accParentTitle`, `accTypeId`, `uId`, `created_at`, `updated_at`) VALUES
(1, 'PARENT 001', 1, 1, '2024-10-12 02:08:14', '2024-10-12 02:08:14'),
(2, 'PARENT 002', 2, 1, '2024-10-12 02:08:29', '2024-10-12 02:08:29'),
(3, 'PARENT 003', 3, 1, '2024-10-12 02:08:40', '2024-10-12 02:08:40'),
(4, 'PARENT 004', 4, 1, '2024-10-12 02:08:48', '2024-10-12 02:08:48');

-- --------------------------------------------------------

--
-- Table structure for table `acctype`
--

CREATE TABLE `acctype` (
  `accTypeId` bigint(20) UNSIGNED NOT NULL,
  `accTypeTitle` varchar(255) NOT NULL,
  `uId` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `acctype`
--

INSERT INTO `acctype` (`accTypeId`, `accTypeTitle`, `uId`, `created_at`, `updated_at`) VALUES
(1, 'CUSTOMER', 1, '2024-10-12 01:51:34', '2024-10-12 01:51:34'),
(2, 'SUPPLIER', 1, '2024-10-12 01:51:43', '2024-10-12 01:51:43'),
(3, 'BANK', 1, '2024-10-12 01:51:50', '2024-10-12 01:51:50'),
(4, 'ASSETS', 1, '2024-10-12 01:51:57', '2024-10-12 01:51:57'),
(5, 'LIABILITY', 1, '2024-10-12 01:52:03', '2024-10-12 01:52:03'),
(6, 'CAPITAL', 1, '2024-10-12 01:52:10', '2024-10-12 01:52:10'),
(7, 'REVENUE', 1, '2024-10-12 01:52:17', '2024-10-12 01:52:17'),
(8, 'EXPENSE', 1, '2024-10-12 01:52:24', '2024-10-12 01:52:24');

-- --------------------------------------------------------

--
-- Table structure for table `area`
--

CREATE TABLE `area` (
  `areaId` bigint(20) UNSIGNED NOT NULL,
  `areaTitle` varchar(255) NOT NULL,
  `uId` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `area`
--

INSERT INTO `area` (`areaId`, `areaTitle`, `uId`, `created_at`, `updated_at`) VALUES
(1, 'MULTAN', 1, '2024-10-12 03:20:27', '2024-10-12 03:20:27'),
(2, 'LAHORE', 1, '2024-10-12 03:21:55', '2024-10-12 03:22:03'),
(3, 'KARACHI', 1, '2024-10-12 03:22:16', '2024-10-12 03:22:16'),
(4, 'ISLMABAD', 1, '2024-10-12 03:22:26', '2024-10-12 03:22:26');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `currency`
--

CREATE TABLE `currency` (
  `currencyId` bigint(20) UNSIGNED NOT NULL,
  `currencyTitle` varchar(255) NOT NULL,
  `uId` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `currency`
--

INSERT INTO `currency` (`currencyId`, `currencyTitle`, `uId`, `created_at`, `updated_at`) VALUES
(1, 'PKR', 1, '2024-10-09 03:12:24', '2024-10-09 03:12:24'),
(2, 'SAR', 1, '2024-10-09 03:17:22', '2024-10-09 03:17:22'),
(3, 'USD', 1, '2024-10-09 03:18:04', '2024-10-10 01:15:01'),
(7, 'YUAN', 1, '2024-10-10 03:24:00', '2024-10-10 03:24:00');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '2024_09_24_070807_create_personal_access_tokens_table', 1),
(4, '2024_09_24_071813_create_posts_table', 1),
(5, '2024_09_26_064606_create_currency_table', 1),
(6, '2024_09_26_064623_create_area_table', 1),
(7, '2024_09_26_064655_create_accType_table', 1),
(8, '2024_09_26_064659_create_accParent_table', 1),
(9, '2024_09_26_064710_create_accounts_table', 1),
(10, '2024_09_26_064726_create_vouchers_table', 1),
(11, '2024_09_26_064812_create_vouchersdetail_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `personal_access_tokens`
--

INSERT INTO `personal_access_tokens` (`id`, `tokenable_type`, `tokenable_id`, `name`, `token`, `abilities`, `last_used_at`, `expires_at`, `created_at`, `updated_at`) VALUES
(1, 'App\\Models\\User', 1, 'API Token', '81b370e48c0b6788b90d7ca7a6ba09a5550d164bbb0e56b0969c1d9460c16608', '[\"*\"]', NULL, NULL, '2024-10-09 01:01:17', '2024-10-09 01:01:17'),
(2, 'App\\Models\\User', 1, 'API Token', '1e47c6b131d176e2286ab6d3a2544883d2cfddcd665523b3a001491506c3c8b8', '[\"*\"]', '2024-10-24 03:29:14', NULL, '2024-10-09 01:03:24', '2024-10-24 03:29:14');

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `postId` bigint(20) UNSIGNED NOT NULL,
  `postTitle` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `image` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `created_at`, `updated_at`) VALUES
(1, 'qaiser', 'qaiser@soft.com', '$2y$12$TfdK2RTgCMz8iPbOH5XDPua99jQxvzJfgMUIbt7aGv1HJdYItjt6e', '2024-10-09 01:00:43', '2024-10-09 01:00:43');

-- --------------------------------------------------------

--
-- Table structure for table `vouchers`
--

CREATE TABLE `vouchers` (
  `voucherId` bigint(20) UNSIGNED NOT NULL,
  `voucherDate` date NOT NULL,
  `voucherPrefix` varchar(255) NOT NULL,
  `remarksMaster` text DEFAULT NULL,
  `sumDebit` double NOT NULL DEFAULT 0,
  `sumCredit` double NOT NULL DEFAULT 0,
  `sumDebitSR` double NOT NULL DEFAULT 0,
  `sumCreditSR` double NOT NULL DEFAULT 0,
  `uId` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `vouchers`
--

INSERT INTO `vouchers` (`voucherId`, `voucherDate`, `voucherPrefix`, `remarksMaster`, `sumDebit`, `sumCredit`, `sumDebitSR`, `sumCreditSR`, `uId`, `created_at`, `updated_at`) VALUES
(1, '2024-10-24', 'CR', 'Cash Received.', 0, 600, 0, 6, 1, '2024-10-24 03:05:22', '2024-10-24 03:05:22'),
(2, '2024-10-24', 'CR', 'Cash Received.', 0, 1000, 0, 10, 1, '2024-10-24 03:10:07', '2024-10-24 03:10:07');

-- --------------------------------------------------------

--
-- Table structure for table `vouchersdetail`
--

CREATE TABLE `vouchersdetail` (
  `voucherDtid` bigint(20) UNSIGNED NOT NULL,
  `voucherId` bigint(20) UNSIGNED NOT NULL,
  `uId` bigint(20) UNSIGNED NOT NULL,
  `acId` bigint(20) UNSIGNED NOT NULL,
  `remarksDetail` text NOT NULL,
  `debit` double NOT NULL DEFAULT 0,
  `credit` double NOT NULL DEFAULT 0,
  `debitSR` double NOT NULL DEFAULT 0,
  `creditSR` double NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `vouchersdetail`
--

INSERT INTO `vouchersdetail` (`voucherDtid`, `voucherId`, `uId`, `acId`, `remarksDetail`, `debit`, `credit`, `debitSR`, `creditSR`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 13, 'Cash Received.', 0, 600, 0, 6, '2024-10-24 03:05:22', '2024-10-24 03:05:22'),
(2, 2, 1, 17, 'Cash Received.', 0, 1000, 0, 10, '2024-10-24 03:10:07', '2024-10-24 03:10:07');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`acId`),
  ADD KEY `accounts_uid_foreign` (`uId`),
  ADD KEY `accounts_currencyid_foreign` (`currencyId`),
  ADD KEY `accounts_acctypeid_foreign` (`accTypeId`),
  ADD KEY `accounts_parentid_foreign` (`parentId`),
  ADD KEY `accounts_areaid_foreign` (`areaId`);

--
-- Indexes for table `accparent`
--
ALTER TABLE `accparent`
  ADD PRIMARY KEY (`parentId`),
  ADD KEY `accparent_acctypeid_foreign` (`accTypeId`),
  ADD KEY `accparent_uid_foreign` (`uId`);

--
-- Indexes for table `acctype`
--
ALTER TABLE `acctype`
  ADD PRIMARY KEY (`accTypeId`),
  ADD KEY `acctype_uid_foreign` (`uId`);

--
-- Indexes for table `area`
--
ALTER TABLE `area`
  ADD PRIMARY KEY (`areaId`),
  ADD KEY `area_uid_foreign` (`uId`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `currency`
--
ALTER TABLE `currency`
  ADD PRIMARY KEY (`currencyId`),
  ADD KEY `currency_uid_foreign` (`uId`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`postId`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `vouchers`
--
ALTER TABLE `vouchers`
  ADD PRIMARY KEY (`voucherId`),
  ADD KEY `vouchers_uid_foreign` (`uId`);

--
-- Indexes for table `vouchersdetail`
--
ALTER TABLE `vouchersdetail`
  ADD PRIMARY KEY (`voucherDtid`),
  ADD KEY `vouchersdetail_voucherid_foreign` (`voucherId`),
  ADD KEY `vouchersdetail_uid_foreign` (`uId`),
  ADD KEY `vouchersdetail_acid_foreign` (`acId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accounts`
--
ALTER TABLE `accounts`
  MODIFY `acId` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `accparent`
--
ALTER TABLE `accparent`
  MODIFY `parentId` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `acctype`
--
ALTER TABLE `acctype`
  MODIFY `accTypeId` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `area`
--
ALTER TABLE `area`
  MODIFY `areaId` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `currency`
--
ALTER TABLE `currency`
  MODIFY `currencyId` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `postId` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `vouchers`
--
ALTER TABLE `vouchers`
  MODIFY `voucherId` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `vouchersdetail`
--
ALTER TABLE `vouchersdetail`
  MODIFY `voucherDtid` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `accounts`
--
ALTER TABLE `accounts`
  ADD CONSTRAINT `accounts_acctypeid_foreign` FOREIGN KEY (`accTypeId`) REFERENCES `acctype` (`accTypeId`),
  ADD CONSTRAINT `accounts_areaid_foreign` FOREIGN KEY (`areaId`) REFERENCES `area` (`areaId`),
  ADD CONSTRAINT `accounts_currencyid_foreign` FOREIGN KEY (`currencyId`) REFERENCES `currency` (`currencyId`),
  ADD CONSTRAINT `accounts_parentid_foreign` FOREIGN KEY (`parentId`) REFERENCES `accparent` (`parentId`),
  ADD CONSTRAINT `accounts_uid_foreign` FOREIGN KEY (`uId`) REFERENCES `users` (`id`);

--
-- Constraints for table `accparent`
--
ALTER TABLE `accparent`
  ADD CONSTRAINT `accparent_acctypeid_foreign` FOREIGN KEY (`accTypeId`) REFERENCES `acctype` (`accTypeId`),
  ADD CONSTRAINT `accparent_uid_foreign` FOREIGN KEY (`uId`) REFERENCES `users` (`id`);

--
-- Constraints for table `acctype`
--
ALTER TABLE `acctype`
  ADD CONSTRAINT `acctype_uid_foreign` FOREIGN KEY (`uId`) REFERENCES `users` (`id`);

--
-- Constraints for table `area`
--
ALTER TABLE `area`
  ADD CONSTRAINT `area_uid_foreign` FOREIGN KEY (`uId`) REFERENCES `users` (`id`);

--
-- Constraints for table `currency`
--
ALTER TABLE `currency`
  ADD CONSTRAINT `currency_uid_foreign` FOREIGN KEY (`uId`) REFERENCES `users` (`id`);

--
-- Constraints for table `vouchers`
--
ALTER TABLE `vouchers`
  ADD CONSTRAINT `vouchers_uid_foreign` FOREIGN KEY (`uId`) REFERENCES `users` (`id`);

--
-- Constraints for table `vouchersdetail`
--
ALTER TABLE `vouchersdetail`
  ADD CONSTRAINT `vouchersdetail_acid_foreign` FOREIGN KEY (`acId`) REFERENCES `accounts` (`acId`),
  ADD CONSTRAINT `vouchersdetail_uid_foreign` FOREIGN KEY (`uId`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `vouchersdetail_voucherid_foreign` FOREIGN KEY (`voucherId`) REFERENCES `vouchers` (`voucherId`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
