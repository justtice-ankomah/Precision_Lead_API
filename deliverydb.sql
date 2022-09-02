-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 03, 2022 at 07:39 AM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 8.0.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `deliverydb`
--

-- --------------------------------------------------------

--
-- Table structure for table `deliveries`
--

CREATE TABLE `deliveries` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT 'UNACCEPTED',
  `deliveryType` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `itemName` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `itemCategory` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `itemDesc` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `itemCode` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `senderId` bigint(20) UNSIGNED NOT NULL,
  `receiverId` bigint(20) UNSIGNED DEFAULT NULL,
  `receiverName` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `reciverContact` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `reciverIdNumber` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `riderId` bigint(20) UNSIGNED NOT NULL,
  `isDelvStarted` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'NO',
  `delvStartDate` datetime DEFAULT NULL,
  `delvEndDate` datetime DEFAULT NULL,
  `paymentMethod` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `costAmount` int(11) DEFAULT NULL,
  `paymentstatus` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT 'UNPAID',
  `pickUpLocationLat` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pickUpLocationLnt` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pickUpLocationName` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pickUpLocationDesc` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `destLocationLat` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `destLocationLnt` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `destLocationName` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `destLocationDesc` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
(1, '2012_07_14_160704_create_usersrgroup_id', 1),
(2, '2014_10_12_000000_create_users_table', 1),
(3, '2016_06_01_000001_create_oauth_auth_codes_table', 1),
(4, '2016_06_01_000002_create_oauth_access_tokens_table', 1),
(5, '2016_06_01_000003_create_oauth_refresh_tokens_table', 1),
(6, '2016_06_01_000004_create_oauth_clients_table', 1),
(7, '2016_06_01_000005_create_oauth_personal_access_clients_table', 1),
(8, '2016_07_14_230742_deliveries', 1),
(9, '2019_08_19_000000_create_failed_jobs_table', 1),
(10, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(11, '2022_07_15_055019_addtriggers', 1);

-- --------------------------------------------------------

--
-- Table structure for table `oauth_access_tokens`
--

CREATE TABLE `oauth_access_tokens` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `scopes` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `oauth_access_tokens`
--

INSERT INTO `oauth_access_tokens` (`id`, `user_id`, `client_id`, `name`, `scopes`, `revoked`, `created_at`, `updated_at`, `expires_at`) VALUES
('0c90e1c9044587523e8a29dee7e6055c766972cf24c5bac886f763e7a70a361f5560f84f28768f3f', 5, 1, 'Laravel-9-Passport-Auth', '[]', 0, '2022-08-03 02:25:45', '2022-08-03 02:25:45', '2023-08-02 18:25:45'),
('1a2e79e37b10bf8699b611414d49aa7bf6c035cfecf906133fca1ccc0c49fae7a724792e621c4fd9', 2, 1, 'Laravel-9-Passport-Auth', '[]', 0, '2022-08-03 02:23:44', '2022-08-03 02:23:44', '2023-08-02 18:23:44'),
('4c5a9c342958b41c794469179bf31fa95c7ea72068248285903940f960d8b2f051c2134b6d6eb918', 5, 1, 'Laravel-9-Passport-Auth', '[]', 0, '2022-08-03 02:25:33', '2022-08-03 02:25:33', '2023-08-02 18:25:33'),
('593cb58c6e7ee99e4d4bb03a254e3f7e25f363d77c4a4bcf319c5d113fc80e89975b7c36472483e4', 5, 1, 'Laravel-9-Passport-Auth', '[]', 0, '2022-08-03 02:34:44', '2022-08-03 02:34:44', '2023-08-02 18:34:44'),
('90f1e9b1cbf9c8dc1e3ca08dcd2ab6a3502c1fe51831c21d9bf26c102581f96d0b5716c7e7f4de30', 2, 1, 'Laravel-9-Passport-Auth', '[]', 0, '2022-08-03 02:23:20', '2022-08-03 02:23:20', '2023-08-02 18:23:20'),
('e66c454c8196814c1fe62e302a5521e36160265ac99072fa79cb6df55be349529ca73d5becf82cf0', 5, 1, 'Laravel-9-Passport-Auth', '[]', 0, '2022-08-03 02:35:31', '2022-08-03 02:35:31', '2023-08-02 18:35:31'),
('f115a4e06c982ec5e5f96afdabd561edc93f359dc10f4e87cac6f9fa9ae9720dc7622566e8d82360', 5, 1, 'Laravel-9-Passport-Auth', '[]', 0, '2022-08-03 02:32:13', '2022-08-03 02:32:13', '2023-08-02 18:32:13');

-- --------------------------------------------------------

--
-- Table structure for table `oauth_auth_codes`
--

CREATE TABLE `oauth_auth_codes` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `scopes` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_clients`
--

CREATE TABLE `oauth_clients` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `secret` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `provider` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `redirect` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `personal_access_client` tinyint(1) NOT NULL,
  `password_client` tinyint(1) NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `oauth_clients`
--

INSERT INTO `oauth_clients` (`id`, `user_id`, `name`, `secret`, `provider`, `redirect`, `personal_access_client`, `password_client`, `revoked`, `created_at`, `updated_at`) VALUES
(1, NULL, 'Laravel Personal Access Client', 'i5orx3VtjYcktmF4hu1oM1Cu5QQCLHFQgj7WiOEK', NULL, 'http://localhost', 1, 0, 0, '2022-08-03 02:22:28', '2022-08-03 02:22:28'),
(2, NULL, 'Laravel Password Grant Client', 'JV5OtlTA7bgSZCMrBnLBgWaPf5iTsii3zePBqx18', 'users', 'http://localhost', 0, 1, 0, '2022-08-03 02:22:28', '2022-08-03 02:22:28');

-- --------------------------------------------------------

--
-- Table structure for table `oauth_personal_access_clients`
--

CREATE TABLE `oauth_personal_access_clients` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `oauth_personal_access_clients`
--

INSERT INTO `oauth_personal_access_clients` (`id`, `client_id`, `created_at`, `updated_at`) VALUES
(1, 1, '2022-08-03 02:22:28', '2022-08-03 02:22:28');

-- --------------------------------------------------------

--
-- Table structure for table `oauth_refresh_tokens`
--

CREATE TABLE `oauth_refresh_tokens` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `access_token_id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `groupid` bigint(20) UNSIGNED NOT NULL,
  `fullname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phonenumber` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `profileUrl` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `momonumber` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `isUserBlocked` tinyint(1) NOT NULL DEFAULT 0,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phonenumber_verified_at` timestamp NULL DEFAULT NULL,
  `locationLat` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `locationLnt` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `locationName` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `locationDesc` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `groupid`, `fullname`, `username`, `phonenumber`, `profileUrl`, `momonumber`, `address`, `isUserBlocked`, `password`, `phonenumber_verified_at`, `locationLat`, `locationLnt`, `locationName`, `locationDesc`, `created_at`, `updated_at`) VALUES
(2, 1, 'admin amin', 'admin', '0249244558', NULL, NULL, 'accra digital center', 0, '$2y$10$y6bKgbPlWyfVTaBNl0vpHuz6v6rzC78Ahr44qzecJdRj9RhqT34hC', NULL, NULL, NULL, NULL, NULL, '2022-08-03 02:23:20', '2022-08-03 02:23:20'),
(5, 2, 'justice ankomah', 'justice', '0249244556', 'public/images/1659466642.jpg', NULL, 'accra digital center', 0, '$2y$10$gfhPWaam6Kba8wILgyacwuD82qXKC1NsChetI1Om/Qq9rRGA4HZGy', NULL, NULL, NULL, NULL, NULL, '2022-08-03 02:25:33', '2022-08-03 02:57:22');

-- --------------------------------------------------------

--
-- Table structure for table `usersgroupid`
--

CREATE TABLE `usersgroupid` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `usersgroupid`
--

INSERT INTO `usersgroupid` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'admin', NULL, NULL),
(2, 'users', '2022-08-03 02:24:43', '2022-08-03 02:24:43'),
(3, 'rider', '2022-08-03 02:24:50', '2022-08-03 02:24:50');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `deliveries`
--
ALTER TABLE `deliveries`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `deliveries_itemcode_unique` (`itemCode`),
  ADD KEY `deliveries_senderid_foreign` (`senderId`),
  ADD KEY `deliveries_receiverid_foreign` (`receiverId`),
  ADD KEY `deliveries_riderid_foreign` (`riderId`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `oauth_access_tokens`
--
ALTER TABLE `oauth_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_access_tokens_user_id_index` (`user_id`);

--
-- Indexes for table `oauth_auth_codes`
--
ALTER TABLE `oauth_auth_codes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_auth_codes_user_id_index` (`user_id`);

--
-- Indexes for table `oauth_clients`
--
ALTER TABLE `oauth_clients`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_clients_user_id_index` (`user_id`);

--
-- Indexes for table `oauth_personal_access_clients`
--
ALTER TABLE `oauth_personal_access_clients`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `oauth_refresh_tokens`
--
ALTER TABLE `oauth_refresh_tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_refresh_tokens_access_token_id_index` (`access_token_id`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_username_unique` (`username`),
  ADD UNIQUE KEY `users_phonenumber_unique` (`phonenumber`),
  ADD UNIQUE KEY `users_profileurl_unique` (`profileUrl`),
  ADD KEY `users_groupid_foreign` (`groupid`);

--
-- Indexes for table `usersgroupid`
--
ALTER TABLE `usersgroupid`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `usersgroupid_name_unique` (`name`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `deliveries`
--
ALTER TABLE `deliveries`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `oauth_clients`
--
ALTER TABLE `oauth_clients`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `oauth_personal_access_clients`
--
ALTER TABLE `oauth_personal_access_clients`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `usersgroupid`
--
ALTER TABLE `usersgroupid`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `deliveries`
--
ALTER TABLE `deliveries`
  ADD CONSTRAINT `deliveries_receiverid_foreign` FOREIGN KEY (`receiverId`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `deliveries_riderid_foreign` FOREIGN KEY (`riderId`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `deliveries_senderid_foreign` FOREIGN KEY (`senderId`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_groupid_foreign` FOREIGN KEY (`groupid`) REFERENCES `usersgroupid` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
