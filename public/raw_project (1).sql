-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 11, 2026 at 01:03 PM
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
-- Database: `raw_project`
--

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('laravel-cache-spatie.permission.cache', 'a:3:{s:5:\"alias\";a:4:{s:1:\"a\";s:2:\"id\";s:1:\"b\";s:4:\"name\";s:1:\"c\";s:10:\"guard_name\";s:1:\"r\";s:5:\"roles\";}s:11:\"permissions\";a:23:{i:0;a:4:{s:1:\"a\";i:1;s:1:\"b\";s:9:\"user.view\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:3;}}i:1;a:4:{s:1:\"a\";i:2;s:1:\"b\";s:11:\"user.create\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:3;}}i:2;a:4:{s:1:\"a\";i:3;s:1:\"b\";s:9:\"user.edit\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:3;}}i:3;a:4:{s:1:\"a\";i:4;s:1:\"b\";s:11:\"user.delete\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:3;}}i:4;a:4:{s:1:\"a\";i:5;s:1:\"b\";s:9:\"role.view\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:3;}}i:5;a:4:{s:1:\"a\";i:6;s:1:\"b\";s:11:\"role.create\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:3;}}i:6;a:4:{s:1:\"a\";i:7;s:1:\"b\";s:9:\"role.edit\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:3;}}i:7;a:4:{s:1:\"a\";i:8;s:1:\"b\";s:11:\"role.delete\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:3;}}i:8;a:4:{s:1:\"a\";i:9;s:1:\"b\";s:15:\"permission.view\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:3;}}i:9;a:4:{s:1:\"a\";i:10;s:1:\"b\";s:17:\"permission.create\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:3;}}i:10;a:4:{s:1:\"a\";i:11;s:1:\"b\";s:15:\"permission.edit\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:3;}}i:11;a:4:{s:1:\"a\";i:12;s:1:\"b\";s:17:\"permission.delete\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:3;}}i:12;a:4:{s:1:\"a\";i:13;s:1:\"b\";s:14:\"candidate.view\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:3;}}i:13;a:4:{s:1:\"a\";i:14;s:1:\"b\";s:16:\"candidate.create\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:3;}}i:14;a:4:{s:1:\"a\";i:15;s:1:\"b\";s:14:\"candidate.edit\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:3;}}i:15;a:4:{s:1:\"a\";i:16;s:1:\"b\";s:16:\"candidate.verify\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:3;}}i:16;a:4:{s:1:\"a\";i:17;s:1:\"b\";s:16:\"candidate.delete\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:3;}}i:17;a:4:{s:1:\"a\";i:18;s:1:\"b\";s:15:\"candidates.show\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:3;}}i:18;a:4:{s:1:\"a\";i:19;s:1:\"b\";s:11:\"wallet.view\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:3;}}i:19;a:4:{s:1:\"a\";i:20;s:1:\"b\";s:13:\"wallet.credit\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:3;}}i:20;a:4:{s:1:\"a\";i:21;s:1:\"b\";s:12:\"wallet.debit\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:3;}}i:21;a:4:{s:1:\"a\";i:22;s:1:\"b\";s:13:\"wallet.refund\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:3;}}i:22;a:4:{s:1:\"a\";i:23;s:1:\"b\";s:13:\"wallet.report\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:3;}}}s:5:\"roles\";a:3:{i:0;a:3:{s:1:\"a\";i:1;s:1:\"b\";s:5:\"admin\";s:1:\"c\";s:3:\"web\";}i:1;a:3:{s:1:\"a\";i:2;s:1:\"b\";s:6:\"editor\";s:1:\"c\";s:3:\"web\";}i:2;a:3:{s:1:\"a\";i:3;s:1:\"b\";s:11:\"Super Admin\";s:1:\"c\";s:3:\"web\";}}}', 1770891845);

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
-- Table structure for table `candidates`
--

CREATE TABLE `candidates` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `father_name` varchar(255) DEFAULT NULL,
  `dob` date NOT NULL,
  `gender` varchar(255) NOT NULL,
  `marital_status` varchar(255) NOT NULL,
  `mobile` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `nationality` varchar(255) NOT NULL,
  `passport_number` varchar(255) NOT NULL,
  `passport_expiry` date NOT NULL,
  `kyc_status` enum('pending','partial','verified','rejected') NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `aadhaar_no` text DEFAULT NULL,
  `pan_no` text DEFAULT NULL,
  `bank_name` text DEFAULT NULL,
  `account_no` text DEFAULT NULL,
  `ifsc` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `candidates`
--

INSERT INTO `candidates` (`id`, `full_name`, `father_name`, `dob`, `gender`, `marital_status`, `mobile`, `email`, `nationality`, `passport_number`, `passport_expiry`, `kyc_status`, `created_at`, `updated_at`, `aadhaar_no`, `pan_no`, `bank_name`, `account_no`, `ifsc`) VALUES
(1, 'Ajay Kumar', 'Kashi Nath', '2026-02-10', 'Male', 'Single', '8863897161', NULL, 'indian', '3534564', '2026-02-10', 'rejected', '2026-02-10 02:29:02', '2026-02-11 01:20:53', '867948809073', 'KIIPK7404N', 'Airtel Payments Bank', '8863897163', 'AIR0000001'),
(2, 'Sanket Kumar', NULL, '2026-02-11', 'Male', 'Single', '8294169540', NULL, 'indian', '54676587', '2026-02-11', 'pending', '2026-02-11 01:08:48', '2026-02-11 01:08:48', NULL, NULL, NULL, NULL, NULL),
(4, 'harshika', NULL, '2026-02-11', 'Male', 'Single', '8863897160', NULL, 'indian', '353456434', '2026-02-11', 'pending', '2026-02-11 05:27:43', '2026-02-11 05:27:43', NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `candidate_addresses`
--

CREATE TABLE `candidate_addresses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `candidate_id` bigint(20) UNSIGNED NOT NULL,
  `type` enum('present','permanent') NOT NULL,
  `address` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `state` varchar(255) NOT NULL,
  `country` varchar(255) NOT NULL,
  `pincode` varchar(255) NOT NULL,
  `status` text DEFAULT NULL,
  `remarks` text DEFAULT NULL,
  `verified_by` text DEFAULT NULL,
  `verified_at` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `candidate_addresses`
--

INSERT INTO `candidate_addresses` (`id`, `candidate_id`, `type`, `address`, `city`, `state`, `country`, `pincode`, `status`, `remarks`, `verified_by`, `verified_at`, `created_at`, `updated_at`) VALUES
(4, 1, 'present', 'B.C. Road, Patna, Bihar, 800001', 'Patna HQ', 'Bihar', 'India', '800001', 'verified', 'All Ok', '2', '2026-02-11 09:40:30', '2026-02-10 04:01:02', '2026-02-11 04:10:30');

-- --------------------------------------------------------

--
-- Table structure for table `candidate_documents`
--

CREATE TABLE `candidate_documents` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `candidate_id` bigint(20) UNSIGNED NOT NULL,
  `document_type` varchar(255) NOT NULL,
  `document_file` varchar(255) NOT NULL,
  `verification_status` enum('pending','verified','rejected') NOT NULL DEFAULT 'pending',
  `verified_by` text DEFAULT NULL,
  `verified_at` text DEFAULT NULL,
  `remarks` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `candidate_documents`
--

INSERT INTO `candidate_documents` (`id`, `candidate_id`, `document_type`, `document_file`, `verification_status`, `verified_by`, `verified_at`, `remarks`, `created_at`, `updated_at`) VALUES
(1, 1, 'aadhaar_front', 'candidate_documents/dRR8iUTIrNqi9Pik5y7q715AKg9lTRbnTRvZQ5NV.png', 'verified', '2', '2026-02-11 06:50:21', NULL, '2026-02-10 04:22:45', '2026-02-11 01:20:21'),
(2, 1, 'aadhaar_back', 'candidate_documents/udX3WiJhzldJrWpO5AIQ8OZuSmjt7Sn6eVUjhM4r.png', 'rejected', '2', '2026-02-11 07:12:26', 'sgdhfgj', '2026-02-10 04:22:45', '2026-02-11 01:42:26'),
(3, 1, 'pan_front', 'candidate_documents/mAH0Two4nadiIgLDXsQigHzouVql2UgdWKX6ExBd.png', 'verified', '2', '2026-02-11 09:57:34', 'Good', '2026-02-10 04:22:45', '2026-02-11 04:27:34'),
(4, 1, 'pan_back', 'candidate_documents/TpYjWJXl9ElKRRWTIwxlXrasJMyjkHPlV4OyneRi.png', 'verified', '2', '2026-02-11 08:03:25', 'sdfghj', '2026-02-10 04:22:45', '2026-02-11 02:33:25'),
(5, 1, 'passport', 'candidate_documents/ttvJKNXKu4zEQ9wizEO7ZjjngJffLRjNBB4NJ0Wn.png', 'verified', '2', '2026-02-11 06:50:35', NULL, '2026-02-10 04:22:45', '2026-02-11 01:20:35'),
(6, 1, 'bank_passbook', 'candidate_documents/CACOsttesLHjftclWBOK2pCczQ5OB50bJlDOSg4f.png', 'pending', NULL, NULL, NULL, '2026-02-10 04:22:45', '2026-02-10 04:22:45'),
(7, 1, '10th_marksheet', 'candidate_documents/vYKQsBG7xBr6pdtS7LKavHiP9yvhbIOoKnH0qkzI.png', 'pending', NULL, NULL, NULL, '2026-02-10 04:22:45', '2026-02-10 04:22:45'),
(8, 1, '12th_marksheet', 'candidate_documents/cd54VElSZhTPZIUZfp8Q8kKULRJwfspC6RJWmOBq.png', 'pending', NULL, NULL, NULL, '2026-02-10 04:22:45', '2026-02-10 04:22:45'),
(9, 1, 'graduation_marksheet', 'candidate_documents/R2rODoFamZ6dpyWQ5aX3Uu4bgq2ub8u5jAZIw6w0.png', 'pending', NULL, NULL, NULL, '2026-02-10 04:22:45', '2026-02-10 04:22:45');

-- --------------------------------------------------------

--
-- Table structure for table `candidate_educations`
--

CREATE TABLE `candidate_educations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `candidate_id` bigint(20) UNSIGNED NOT NULL,
  `level` enum('matric','intermediate','graduation','other','eight','iti') NOT NULL,
  `board_university` varchar(255) NOT NULL,
  `institution` varchar(255) DEFAULT NULL,
  `passing_year` varchar(255) NOT NULL,
  `marks` varchar(255) DEFAULT NULL,
  `certificate` varchar(255) DEFAULT NULL,
  `verification_status` enum('pending','verified','rejected') NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `roll_no` text DEFAULT NULL,
  `roll_code` text DEFAULT NULL,
  `status` text DEFAULT NULL,
  `remarks` text DEFAULT NULL,
  `verified_by` text DEFAULT NULL,
  `verified_at` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `candidate_educations`
--

INSERT INTO `candidate_educations` (`id`, `candidate_id`, `level`, `board_university`, `institution`, `passing_year`, `marks`, `certificate`, `verification_status`, `created_at`, `updated_at`, `roll_no`, `roll_code`, `status`, `remarks`, `verified_by`, `verified_at`) VALUES
(13, 1, 'matric', 'BSEB', NULL, '2010', '400', NULL, 'verified', '2026-02-10 04:20:31', '2026-02-11 04:23:32', '1234', '1234', 'verified', 'All Ok', '2', NULL),
(14, 1, 'matric', 'BSEB', NULL, '2010', '400', NULL, 'pending', '2026-02-10 04:20:31', '2026-02-10 04:20:31', '1234', '1234', NULL, NULL, NULL, NULL),
(15, 1, 'intermediate', 'BSEB', NULL, '2010', '400', NULL, 'pending', '2026-02-10 04:20:31', '2026-02-10 04:20:31', '1234', '1234', NULL, NULL, NULL, NULL),
(16, 1, 'graduation', 'BSEB', NULL, '2010', '400', NULL, 'pending', '2026-02-10 04:20:31', '2026-02-10 04:20:31', '1234', '32443', NULL, NULL, NULL, NULL),
(17, 1, 'matric', 'BSEB', NULL, '2010', '400', NULL, 'pending', '2026-02-10 04:20:31', '2026-02-10 04:20:31', '1234', '1234', NULL, NULL, NULL, NULL),
(18, 1, 'other', 'BSEB', NULL, '2020', '400', NULL, 'pending', '2026-02-10 04:20:31', '2026-02-10 04:20:31', '1234', '32443', NULL, NULL, NULL, NULL),
(19, 1, 'other', 'BSEB', NULL, '2020', '400', NULL, 'pending', '2026-02-10 04:20:31', '2026-02-10 04:20:31', '1234', '32443', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `candidate_wallets`
--

CREATE TABLE `candidate_wallets` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `candidate_id` bigint(20) UNSIGNED NOT NULL,
  `wallet_uid` text DEFAULT NULL,
  `balance` decimal(12,2) NOT NULL DEFAULT 0.00,
  `status` text NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `candidate_wallets`
--

INSERT INTO `candidate_wallets` (`id`, `candidate_id`, `wallet_uid`, `balance`, `status`, `created_at`, `updated_at`) VALUES
(2, 4, '5FVG9855', 0.00, 'active', '2026-02-11 05:27:44', '2026-02-11 05:27:44');

-- --------------------------------------------------------

--
-- Table structure for table `document_verification_histories`
--

CREATE TABLE `document_verification_histories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `document_id` bigint(20) UNSIGNED NOT NULL,
  `action_by` bigint(20) UNSIGNED DEFAULT NULL,
  `status` varchar(255) NOT NULL,
  `remarks` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `document_verification_histories`
--

INSERT INTO `document_verification_histories` (`id`, `document_id`, `action_by`, `status`, `remarks`, `created_at`, `updated_at`) VALUES
(1, 2, 2, 'rejected', 'sgdhfgj', '2026-02-11 01:42:26', '2026-02-11 01:42:26'),
(2, 4, 2, 'verified', 'sdfghj', '2026-02-11 02:33:25', '2026-02-11 02:33:25'),
(3, 3, NULL, 'verified', 'Good', '2026-02-11 04:27:34', '2026-02-11 04:27:34');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
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
-- Table structure for table `jobs`
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
-- Table structure for table `job_batches`
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
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_02_09_075801_create_permission_tables', 1),
(5, '2026_02_10_072558_create_candidates_table', 2),
(6, '2026_02_10_072606_create_candidate_addresses_table', 2),
(7, '2026_02_10_072612_create_candidate_education_table', 2),
(8, '2026_02_10_072618_create_candidate_documents_table', 2),
(9, '2026_02_11_070535_create_document_verification_histories_table', 3),
(10, '2026_02_11_101301_create_candidate_wallets_table', 4),
(11, '2026_02_11_101334_create_wallet_transactions_table', 4);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(2, 'App\\Models\\User', 3),
(3, 'App\\Models\\User', 1),
(3, 'App\\Models\\User', 2);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'user.view', 'web', '2026-02-09 02:30:37', '2026-02-09 02:30:37'),
(2, 'user.create', 'web', '2026-02-09 02:30:37', '2026-02-09 02:30:37'),
(3, 'user.edit', 'web', '2026-02-09 02:30:37', '2026-02-09 02:30:37'),
(4, 'user.delete', 'web', '2026-02-09 02:30:37', '2026-02-09 02:30:37'),
(5, 'role.view', 'web', '2026-02-09 04:59:03', '2026-02-09 04:59:03'),
(6, 'role.create', 'web', '2026-02-09 04:59:03', '2026-02-09 04:59:03'),
(7, 'role.edit', 'web', '2026-02-09 04:59:03', '2026-02-09 04:59:03'),
(8, 'role.delete', 'web', '2026-02-09 04:59:03', '2026-02-09 04:59:03'),
(9, 'permission.view', 'web', '2026-02-09 04:59:03', '2026-02-09 04:59:03'),
(10, 'permission.create', 'web', '2026-02-09 04:59:03', '2026-02-09 04:59:03'),
(11, 'permission.edit', 'web', '2026-02-09 04:59:03', '2026-02-09 04:59:03'),
(12, 'permission.delete', 'web', '2026-02-09 04:59:03', '2026-02-09 04:59:03'),
(13, 'candidate.view', 'web', '2026-02-10 01:36:48', '2026-02-10 01:47:31'),
(14, 'candidate.create', 'web', '2026-02-10 01:37:00', '2026-02-10 01:47:47'),
(15, 'candidate.edit', 'web', '2026-02-10 01:37:11', '2026-02-10 01:48:05'),
(16, 'candidate.verify', 'web', '2026-02-10 01:37:27', '2026-02-10 01:48:17'),
(17, 'candidate.delete', 'web', '2026-02-10 01:48:26', '2026-02-10 01:48:26'),
(18, 'candidates.show', 'web', '2026-02-11 04:02:21', '2026-02-11 04:02:21'),
(19, 'wallet.view', 'web', '2026-02-11 04:52:24', '2026-02-11 04:52:24'),
(20, 'wallet.credit', 'web', '2026-02-11 04:52:38', '2026-02-11 04:52:38'),
(21, 'wallet.debit', 'web', '2026-02-11 04:52:48', '2026-02-11 04:52:48'),
(22, 'wallet.refund', 'web', '2026-02-11 04:52:56', '2026-02-11 04:52:56'),
(23, 'wallet.report', 'web', '2026-02-11 04:53:04', '2026-02-11 04:53:04');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'web', '2026-02-09 02:30:37', '2026-02-09 02:30:37'),
(2, 'editor', 'web', '2026-02-09 02:30:37', '2026-02-09 02:30:37'),
(3, 'Super Admin', 'web', '2026-02-09 04:59:03', '2026-02-09 04:59:03');

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_has_permissions`
--

INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
(1, 1),
(1, 2),
(1, 3),
(2, 1),
(2, 2),
(2, 3),
(3, 1),
(3, 2),
(3, 3),
(4, 1),
(4, 2),
(4, 3),
(5, 1),
(5, 2),
(5, 3),
(6, 1),
(6, 2),
(6, 3),
(7, 1),
(7, 2),
(7, 3),
(8, 1),
(8, 2),
(8, 3),
(9, 1),
(9, 2),
(9, 3),
(10, 1),
(10, 2),
(10, 3),
(11, 1),
(11, 2),
(11, 3),
(12, 1),
(12, 2),
(12, 3),
(13, 3),
(14, 3),
(15, 3),
(16, 3),
(17, 3),
(18, 3),
(19, 3),
(20, 3),
(21, 3),
(22, 3),
(23, 3);

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
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
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('VYE2TFJBIVH8gu60ghoXmbMffzQWRugUIQklYcpu', 2, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiTG1USnc0cUh3cURlbHRUVTAxNGRIckhHMGJEeWxNSW5BbGtoUDZINCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzU6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbi93YWxsZXRzIjtzOjU6InJvdXRlIjtzOjE5OiJhZG1pbi53YWxsZXRzLmluZGV4Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6Mjt9', 1770811417);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(2, 'Super Admin', 'admin@gmail.com', NULL, '$2y$12$z2p6m1eTedCUzTfRt3jQp.kMicQixGPoQwReVPDmgvbVuifN/zcE.', NULL, '2026-02-09 05:33:26', '2026-02-09 06:03:39'),
(3, 'sonu', 'sonu@gmail.com', NULL, '$2y$12$.XhD44vZ9EKECvKvaHdb7uDiBc5gLQUL8t47HA0MPqc5z9YjXvQz6', NULL, '2026-02-09 05:58:59', '2026-02-09 06:12:12');

-- --------------------------------------------------------

--
-- Table structure for table `wallet_transactions`
--

CREATE TABLE `wallet_transactions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `wallet_id` bigint(20) UNSIGNED NOT NULL,
  `type` enum('credit','debit','refund') NOT NULL,
  `amount` decimal(12,2) NOT NULL,
  `description` text DEFAULT NULL,
  `reference_type` varchar(255) DEFAULT NULL,
  `reference_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_expiration_index` (`expiration`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_locks_expiration_index` (`expiration`);

--
-- Indexes for table `candidates`
--
ALTER TABLE `candidates`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `candidates_mobile_unique` (`mobile`),
  ADD UNIQUE KEY `candidates_passport_number_unique` (`passport_number`);

--
-- Indexes for table `candidate_addresses`
--
ALTER TABLE `candidate_addresses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `candidate_addresses_candidate_id_foreign` (`candidate_id`);

--
-- Indexes for table `candidate_documents`
--
ALTER TABLE `candidate_documents`
  ADD PRIMARY KEY (`id`),
  ADD KEY `candidate_documents_candidate_id_foreign` (`candidate_id`);

--
-- Indexes for table `candidate_educations`
--
ALTER TABLE `candidate_educations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `candidate_educations_candidate_id_foreign` (`candidate_id`);

--
-- Indexes for table `candidate_wallets`
--
ALTER TABLE `candidate_wallets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `candidate_wallets_candidate_id_foreign` (`candidate_id`);

--
-- Indexes for table `document_verification_histories`
--
ALTER TABLE `document_verification_histories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `document_verification_histories_document_id_foreign` (`document_id`),
  ADD KEY `document_verification_histories_action_by_foreign` (`action_by`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  ADD KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  ADD KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `wallet_transactions`
--
ALTER TABLE `wallet_transactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `wallet_transactions_wallet_id_foreign` (`wallet_id`),
  ADD KEY `wallet_transactions_created_by_foreign` (`created_by`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `candidates`
--
ALTER TABLE `candidates`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `candidate_addresses`
--
ALTER TABLE `candidate_addresses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `candidate_documents`
--
ALTER TABLE `candidate_documents`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `candidate_educations`
--
ALTER TABLE `candidate_educations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `candidate_wallets`
--
ALTER TABLE `candidate_wallets`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `document_verification_histories`
--
ALTER TABLE `document_verification_histories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `wallet_transactions`
--
ALTER TABLE `wallet_transactions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `candidate_addresses`
--
ALTER TABLE `candidate_addresses`
  ADD CONSTRAINT `candidate_addresses_candidate_id_foreign` FOREIGN KEY (`candidate_id`) REFERENCES `candidates` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `candidate_documents`
--
ALTER TABLE `candidate_documents`
  ADD CONSTRAINT `candidate_documents_candidate_id_foreign` FOREIGN KEY (`candidate_id`) REFERENCES `candidates` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `candidate_educations`
--
ALTER TABLE `candidate_educations`
  ADD CONSTRAINT `candidate_educations_candidate_id_foreign` FOREIGN KEY (`candidate_id`) REFERENCES `candidates` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `candidate_wallets`
--
ALTER TABLE `candidate_wallets`
  ADD CONSTRAINT `candidate_wallets_candidate_id_foreign` FOREIGN KEY (`candidate_id`) REFERENCES `candidates` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `document_verification_histories`
--
ALTER TABLE `document_verification_histories`
  ADD CONSTRAINT `document_verification_histories_action_by_foreign` FOREIGN KEY (`action_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `document_verification_histories_document_id_foreign` FOREIGN KEY (`document_id`) REFERENCES `candidate_documents` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `wallet_transactions`
--
ALTER TABLE `wallet_transactions`
  ADD CONSTRAINT `wallet_transactions_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `wallet_transactions_wallet_id_foreign` FOREIGN KEY (`wallet_id`) REFERENCES `candidate_wallets` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
