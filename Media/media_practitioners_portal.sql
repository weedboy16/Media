-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 08, 2024 at 11:21 AM
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
-- Database: `media_practitioners_portal`
--

-- --------------------------------------------------------

--
-- Table structure for table `agencies`
--

CREATE TABLE `agencies` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `contact_info` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `agencies`
--

INSERT INTO `agencies` (`id`, `name`, `contact_info`, `created_at`) VALUES
(1, 'Ministry of Information and Communication Technology', '123 Main St, Windhoek, Namibia, +264 61 283 9111', '2024-09-07 10:28:54'),
(2, 'Ministry of Finance', '456 Finance Rd, Windhoek, Namibia, +264 61 209 2700', '2024-09-07 10:28:54'),
(3, 'Ministry of Health and Social Services', '789 Health Ave, Windhoek, Namibia, +264 61 203 9111', '2024-09-07 10:28:54');

-- --------------------------------------------------------

--
-- Table structure for table `expertise_areas`
--

CREATE TABLE `expertise_areas` (
  `id` int(11) NOT NULL,
  `expertise_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `id` int(11) NOT NULL,
  `pro_id` int(11) DEFAULT NULL,
  `feedback_text` text DEFAULT NULL,
  `rating` int(11) DEFAULT NULL CHECK (`rating` between 1 and 5),
  `sentiment_score` float DEFAULT 0,
  `submitted_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `feedback`
--

INSERT INTO `feedback` (`id`, `pro_id`, `feedback_text`, `rating`, `sentiment_score`, `submitted_at`) VALUES
(1, 1, 'Very professional and responsive.', 5, 0.95, '2024-09-07 10:28:54'),
(2, 2, 'Could improve on response time.', 3, 0.5, '2024-09-07 10:28:54'),
(3, 3, 'Excellent communication skills and very helpful.', 4, 0.8, '2024-09-07 10:28:54'),
(4, 2, 'This is not nice...', 4, 0, '2024-09-07 13:47:42'),
(5, 2, 'Another thest review...', 1, 0, '2024-09-07 13:48:17'),
(6, 3, 'ythn cigudiujb cugibmdbmb', 1, 0, '2024-09-07 13:49:17'),
(7, 2, 'I am not even going to give you a star...', 4, 0, '2024-09-07 14:00:57'),
(8, 2, 'Another star...', 1, 0, '2024-09-07 14:01:25'),
(9, 2, 'What...', 4, 0, '2024-09-07 14:01:58'),
(10, 2, 'this', 4, 0, '2024-09-07 14:13:47'),
(11, 2, 'that', 1, 0, '2024-09-07 14:13:57'),
(12, 2, 'that', 5, 0, '2024-09-07 14:14:09'),
(13, 2, 'This', 4, 0, '2024-09-07 14:21:18'),
(14, 2, 'This is stressful...', 2, 0, '2024-09-07 14:21:46'),
(15, 2, 'gh54uhtrdfcx oim  sd la drfvujdsncx biewfg dsnv  fwe4y3uio6i ,jhbn', 3, 0, '2024-09-07 14:38:24'),
(16, 2, '123rtyghnm', 2, 0, '2024-09-07 14:47:45'),
(17, 2, '54ytyhjn', 3, 0, '2024-09-07 14:50:14'),
(18, 2, '244cxm', 3, 0, '2024-09-07 14:51:15'),
(19, 2, 'tiuigdjbmgb', 2, 0, '2024-09-07 14:52:40'),
(20, 2, 'weoihdlcn,.', 1, 0, '2024-09-07 14:52:50'),
(21, 2, '54utymhj', 2, 0, '2024-09-07 14:53:24'),
(22, 2, 'Thusbsj chewlryf hihibbhbbigk', 5, 0, '2024-09-07 14:56:05'),
(23, 1, 'I like this guy', 4, 0, '2024-09-08 09:10:03');

-- --------------------------------------------------------

--
-- Table structure for table `location`
--

CREATE TABLE `location` (
  `id` int(11) NOT NULL,
  `media_practitioner_id` int(11) NOT NULL,
  `street_address` varchar(255) DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `region` varchar(100) DEFAULT NULL,
  `postal_code` varchar(20) DEFAULT NULL,
  `country` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `media_practitioners`
--

CREATE TABLE `media_practitioners` (
  `id` int(11) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone_number` varchar(50) DEFAULT NULL,
  `credentials` text DEFAULT NULL,
  `verified_status` tinyint(1) DEFAULT 0,
  `card_delivery_method` enum('office','courier') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `profile_image` varchar(255) DEFAULT NULL,
  `courier_tracking_number` varchar(255) DEFAULT NULL,
  `estimated_delivery_date` date DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `media_practitioners`
--

INSERT INTO `media_practitioners` (`id`, `first_name`, `last_name`, `email`, `phone_number`, `credentials`, `verified_status`, `card_delivery_method`, `created_at`, `updated_at`, `profile_image`, `courier_tracking_number`, `estimated_delivery_date`, `date_of_birth`) VALUES
(1, 'John', 'Doe', 'john.doe@example.com', '+264 81 123 4567', 'Certified Journalist', 1, 'courier', '2024-09-07 10:28:54', '2024-09-07 10:28:54', NULL, NULL, NULL, NULL),
(2, 'Jane', 'Smith', 'jane.smith@example.com', '+264 81 987 6543', 'Freelance Reporter', 0, 'office', '2024-09-07 10:28:54', '2024-09-07 10:28:54', NULL, NULL, NULL, NULL),
(3, 'Michael', 'Brown', 'michael.brown@example.com', '+264 81 234 5678', 'Radio Presenter', 1, 'office', '2024-09-07 10:28:54', '2024-09-07 10:28:54', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `media_practitioner_documents`
--

CREATE TABLE `media_practitioner_documents` (
  `id` int(11) NOT NULL,
  `practitioner_id` int(11) DEFAULT NULL,
  `document_type` enum('profile_pic','id_license','other') NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `uploaded_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `media_practitioner_expertise`
--

CREATE TABLE `media_practitioner_expertise` (
  `practitioner_id` int(11) NOT NULL,
  `expertise_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `media_practitioner_media_types`
--

CREATE TABLE `media_practitioner_media_types` (
  `practitioner_id` int(11) NOT NULL,
  `media_type_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `media_practitioner_social_media`
--

CREATE TABLE `media_practitioner_social_media` (
  `practitioner_id` int(11) NOT NULL,
  `platform_id` int(11) NOT NULL,
  `profile_link` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `media_register`
--

CREATE TABLE `media_register` (
  `id` int(11) NOT NULL,
  `practitioner_id` int(11) DEFAULT NULL,
  `status` enum('certified','pending','revoked') DEFAULT 'pending',
  `media_card_number` varchar(255) DEFAULT NULL,
  `registered_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `media_register`
--

INSERT INTO `media_register` (`id`, `practitioner_id`, `status`, `media_card_number`, `registered_at`) VALUES
(1, 1, 'certified', 'MC-001', '2024-09-07 10:28:54'),
(2, 2, 'pending', 'MC-002', '2024-09-07 10:28:54'),
(3, 3, 'certified', 'MC-003', '2024-09-07 10:28:54');

-- --------------------------------------------------------

--
-- Table structure for table `media_types`
--

CREATE TABLE `media_types` (
  `id` int(11) NOT NULL,
  `type_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `portfolio_links`
--

CREATE TABLE `portfolio_links` (
  `id` int(11) NOT NULL,
  `practitioner_id` int(11) DEFAULT NULL,
  `portfolio_url` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pro_register`
--

CREATE TABLE `pro_register` (
  `id` int(11) NOT NULL,
  `pro_id` int(11) DEFAULT NULL,
  `status` enum('active','inactive') DEFAULT 'active',
  `engagement_rate` int(11) DEFAULT 0,
  `quarterly_reports` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pro_register`
--

INSERT INTO `pro_register` (`id`, `pro_id`, `status`, `engagement_rate`, `quarterly_reports`) VALUES
(1, 1, 'active', 80, 'Quarterly Report Q1 2024'),
(2, 2, 'inactive', 60, 'Quarterly Report Q1 2024'),
(3, 3, 'active', 75, 'Quarterly Report Q1 2024');

-- --------------------------------------------------------

--
-- Table structure for table `public_relations_officers`
--

CREATE TABLE `public_relations_officers` (
  `id` int(11) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone_number` varchar(50) DEFAULT NULL,
  `agency_id` int(11) DEFAULT NULL,
  `credentials` text DEFAULT NULL,
  `professional_history` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `profile_image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `public_relations_officers`
--

INSERT INTO `public_relations_officers` (`id`, `first_name`, `last_name`, `email`, `phone_number`, `agency_id`, `credentials`, `professional_history`, `created_at`, `updated_at`, `profile_image`) VALUES
(1, 'Alice', 'Johnson', 'alice.johnson@mict.gov.na', '+264 81 543 2100', 1, 'Master of Public Relations', 'Served as a PRO for 5 years at MICT', '2024-09-07 10:28:54', '2024-09-07 11:59:08', '1.png'),
(2, 'Bob', 'Williams', 'bob.williams@finance.gov.na', '+264 81 654 3210', 2, 'Bachelor of Communications', 'PRO at Ministry of Finance for 3 years', '2024-09-07 10:28:54', '2024-09-07 11:59:16', '2.png'),
(3, 'Emma', 'Thompson', 'emma.thompson@health.gov.na', '+264 81 765 4321', 3, 'Public Health Communications Specialist', 'Worked at Ministry of Health for 7 years', '2024-09-07 10:28:54', '2024-09-07 11:59:22', '3.png');

-- --------------------------------------------------------

--
-- Table structure for table `public_reports`
--

CREATE TABLE `public_reports` (
  `id` int(11) NOT NULL,
  `reporter_name` varchar(255) DEFAULT NULL,
  `pro_id` int(11) DEFAULT NULL,
  `agency_id` int(11) DEFAULT NULL,
  `report_details` text DEFAULT NULL,
  `submitted_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` enum('open','in_progress','resolved') DEFAULT 'open'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `public_reports`
--

INSERT INTO `public_reports` (`id`, `reporter_name`, `pro_id`, `agency_id`, `report_details`, `submitted_at`, `status`) VALUES
(1, 'David Stevens', 1, 1, 'Complaint about delayed press release on public health matters.', '2024-09-07 10:28:54', 'open'),
(2, 'Maria Lopez', 2, 2, 'Request for financial clarity not addressed in time.', '2024-09-07 10:28:54', 'resolved'),
(3, NULL, 3, 3, 'Anonymous complaint on lack of response from PRO.', '2024-09-07 10:28:54', 'in_progress'),
(4, 'Fillemon  Meki', 2, 2, 'This person has no professionalism at all....', '2024-09-07 15:49:25', 'open'),
(5, 'Fillemon  Meki', 2, 2, 'This person has no professionalism at all....', '2024-09-07 15:51:34', 'open');

-- --------------------------------------------------------

--
-- Table structure for table `social_media_platforms`
--

CREATE TABLE `social_media_platforms` (
  `id` int(11) NOT NULL,
  `platform_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `agencies`
--
ALTER TABLE `agencies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `expertise_areas`
--
ALTER TABLE `expertise_areas`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `expertise_name` (`expertise_name`);

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pro_id` (`pro_id`);

--
-- Indexes for table `location`
--
ALTER TABLE `location`
  ADD PRIMARY KEY (`id`),
  ADD KEY `media_practitioner_id` (`media_practitioner_id`);

--
-- Indexes for table `media_practitioners`
--
ALTER TABLE `media_practitioners`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `media_practitioner_documents`
--
ALTER TABLE `media_practitioner_documents`
  ADD PRIMARY KEY (`id`),
  ADD KEY `practitioner_id` (`practitioner_id`);

--
-- Indexes for table `media_practitioner_expertise`
--
ALTER TABLE `media_practitioner_expertise`
  ADD PRIMARY KEY (`practitioner_id`,`expertise_id`),
  ADD KEY `expertise_id` (`expertise_id`);

--
-- Indexes for table `media_practitioner_media_types`
--
ALTER TABLE `media_practitioner_media_types`
  ADD PRIMARY KEY (`practitioner_id`,`media_type_id`),
  ADD KEY `media_type_id` (`media_type_id`);

--
-- Indexes for table `media_practitioner_social_media`
--
ALTER TABLE `media_practitioner_social_media`
  ADD PRIMARY KEY (`practitioner_id`,`platform_id`),
  ADD KEY `platform_id` (`platform_id`);

--
-- Indexes for table `media_register`
--
ALTER TABLE `media_register`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `media_card_number` (`media_card_number`),
  ADD KEY `practitioner_id` (`practitioner_id`);

--
-- Indexes for table `media_types`
--
ALTER TABLE `media_types`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `type_name` (`type_name`);

--
-- Indexes for table `portfolio_links`
--
ALTER TABLE `portfolio_links`
  ADD PRIMARY KEY (`id`),
  ADD KEY `practitioner_id` (`practitioner_id`);

--
-- Indexes for table `pro_register`
--
ALTER TABLE `pro_register`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pro_id` (`pro_id`);

--
-- Indexes for table `public_relations_officers`
--
ALTER TABLE `public_relations_officers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `fk_agency` (`agency_id`);

--
-- Indexes for table `public_reports`
--
ALTER TABLE `public_reports`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pro_id` (`pro_id`),
  ADD KEY `agency_id` (`agency_id`);

--
-- Indexes for table `social_media_platforms`
--
ALTER TABLE `social_media_platforms`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `platform_name` (`platform_name`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `agencies`
--
ALTER TABLE `agencies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `expertise_areas`
--
ALTER TABLE `expertise_areas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `location`
--
ALTER TABLE `location`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `media_practitioners`
--
ALTER TABLE `media_practitioners`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `media_practitioner_documents`
--
ALTER TABLE `media_practitioner_documents`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `media_register`
--
ALTER TABLE `media_register`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `media_types`
--
ALTER TABLE `media_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `portfolio_links`
--
ALTER TABLE `portfolio_links`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pro_register`
--
ALTER TABLE `pro_register`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `public_relations_officers`
--
ALTER TABLE `public_relations_officers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `public_reports`
--
ALTER TABLE `public_reports`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `social_media_platforms`
--
ALTER TABLE `social_media_platforms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `feedback`
--
ALTER TABLE `feedback`
  ADD CONSTRAINT `feedback_ibfk_1` FOREIGN KEY (`pro_id`) REFERENCES `public_relations_officers` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `location`
--
ALTER TABLE `location`
  ADD CONSTRAINT `location_ibfk_1` FOREIGN KEY (`media_practitioner_id`) REFERENCES `media_practitioners` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `media_practitioner_documents`
--
ALTER TABLE `media_practitioner_documents`
  ADD CONSTRAINT `media_practitioner_documents_ibfk_1` FOREIGN KEY (`practitioner_id`) REFERENCES `media_practitioners` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `media_practitioner_expertise`
--
ALTER TABLE `media_practitioner_expertise`
  ADD CONSTRAINT `media_practitioner_expertise_ibfk_1` FOREIGN KEY (`practitioner_id`) REFERENCES `media_practitioners` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `media_practitioner_expertise_ibfk_2` FOREIGN KEY (`expertise_id`) REFERENCES `expertise_areas` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `media_practitioner_media_types`
--
ALTER TABLE `media_practitioner_media_types`
  ADD CONSTRAINT `media_practitioner_media_types_ibfk_1` FOREIGN KEY (`practitioner_id`) REFERENCES `media_practitioners` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `media_practitioner_media_types_ibfk_2` FOREIGN KEY (`media_type_id`) REFERENCES `media_types` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `media_practitioner_social_media`
--
ALTER TABLE `media_practitioner_social_media`
  ADD CONSTRAINT `media_practitioner_social_media_ibfk_1` FOREIGN KEY (`practitioner_id`) REFERENCES `media_practitioners` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `media_practitioner_social_media_ibfk_2` FOREIGN KEY (`platform_id`) REFERENCES `social_media_platforms` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `media_register`
--
ALTER TABLE `media_register`
  ADD CONSTRAINT `media_register_ibfk_1` FOREIGN KEY (`practitioner_id`) REFERENCES `media_practitioners` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `portfolio_links`
--
ALTER TABLE `portfolio_links`
  ADD CONSTRAINT `portfolio_links_ibfk_1` FOREIGN KEY (`practitioner_id`) REFERENCES `media_practitioners` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `pro_register`
--
ALTER TABLE `pro_register`
  ADD CONSTRAINT `pro_register_ibfk_1` FOREIGN KEY (`pro_id`) REFERENCES `public_relations_officers` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `public_relations_officers`
--
ALTER TABLE `public_relations_officers`
  ADD CONSTRAINT `fk_agency` FOREIGN KEY (`agency_id`) REFERENCES `agencies` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `public_reports`
--
ALTER TABLE `public_reports`
  ADD CONSTRAINT `public_reports_ibfk_1` FOREIGN KEY (`pro_id`) REFERENCES `public_relations_officers` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `public_reports_ibfk_2` FOREIGN KEY (`agency_id`) REFERENCES `agencies` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
