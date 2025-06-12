-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 12, 2025 at 09:44 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `blood_treatment_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `allotted_users_center`
--

CREATE TABLE `allotted_users_center` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `blood_center_id` int(11) NOT NULL,
  `treatment_center_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `allotted_users_center`
--

INSERT INTO `allotted_users_center` (`id`, `user_id`, `blood_center_id`, `treatment_center_id`, `created_at`) VALUES
(1, 2, 2, 3, '2025-05-16 08:56:54'),
(2, 5, 2, 2, '2025-05-16 09:33:05'),
(5, 7, 4, 1, '2025-05-16 12:12:26'),
(6, 3, 4, 1, '2025-05-19 05:30:03'),
(7, 8, 4, 1, '2025-05-19 11:20:06');

-- --------------------------------------------------------

--
-- Table structure for table `blocks`
--

CREATE TABLE `blocks` (
  `id` int(11) NOT NULL,
  `treatment_center_id` int(11) DEFAULT NULL,
  `block_name` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `blocks`
--

INSERT INTO `blocks` (`id`, `treatment_center_id`, `block_name`) VALUES
(1, 1, 'Block A'),
(2, 4, 'Block B'),
(3, 2, 'Main Wing'),
(4, 1, 'West Wing'),
(5, 5, 'BLOCK LEVEL 1'),
(6, 7, 'BLOCK Z'),
(7, 3, 'BLOCK HOPE B');

-- --------------------------------------------------------

--
-- Table structure for table `bloodgroup`
--

CREATE TABLE `bloodgroup` (
  `id` int(11) NOT NULL,
  `BloodGroup` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bloodgroup`
--

INSERT INTO `bloodgroup` (`id`, `BloodGroup`) VALUES
(1, 'A+'),
(2, 'A-'),
(3, 'B+'),
(4, 'B-'),
(5, 'AB+'),
(6, 'AB-'),
(7, 'O+'),
(8, 'O-');

-- --------------------------------------------------------

--
-- Table structure for table `blood_centers`
--

CREATE TABLE `blood_centers` (
  `id` int(11) NOT NULL,
  `district_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `address` varchar(255) DEFAULT NULL,
  `contact_number` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `blood_centers`
--

INSERT INTO `blood_centers` (`id`, `district_id`, `name`, `address`, `contact_number`) VALUES
(1, 1, 'Blood Center A', '123 Street, City', '123-456-7890'),
(2, 4, 'Blood Center B', '456 Avenue, City', '987-654-3210'),
(3, 2, 'Blood Center C', '789 Road, Town', '555-123-4567'),
(4, 6, 'Blood Center D', '1011 Lane, Town', '444-789-0123'),
(5, 6, 'Blood Center E', '1213 Boulevard, Village', '222-333-4444'),
(6, 9, 'Blood Center F', '1415 Path, Village', '111-555-6666'),
(7, 4, 'Blood Center K', '1415 Path, K Village', '111-555-6666');

-- --------------------------------------------------------

--
-- Table structure for table `consents`
--

CREATE TABLE `consents` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `blood_center_id` int(11) NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `uploaded_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `consents`
--

INSERT INTO `consents` (`id`, `user_id`, `blood_center_id`, `file_path`, `uploaded_at`) VALUES
(1, 2, 4, '../uploads/consents/1747295023_Daily_Spiritual_Growth_Chart.pdf', '2025-05-15 13:13:43'),
(3, 4, 7, '../uploads/consents/1747306599_Daily_Spiritual_Growth_Chart.pdf', '2025-05-15 16:26:39'),
(4, 5, 2, '../uploads/consents/1747375451_Consent_Form.pdf', '2025-05-16 11:34:11'),
(6, 7, 4, '../uploads/consents/1747397194_Consent_Form (3).pdf', '2025-05-16 17:36:34');

-- --------------------------------------------------------

--
-- Table structure for table `districts`
--

CREATE TABLE `districts` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `division_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `districts`
--

INSERT INTO `districts` (`id`, `name`, `division_id`) VALUES
(1, 'Agra', 1),
(2, 'Aligarh', 2),
(3, 'Bareilly', 3),
(4, 'Jhansi', 4),
(5, 'Kanpur', 5),
(6, 'Lucknow', 6),
(7, 'Meerut', 7),
(8, 'Varanasi', 8),
(9, 'Hardoi', 6);

-- --------------------------------------------------------

--
-- Table structure for table `divisions`
--

CREATE TABLE `divisions` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `state` varchar(255) DEFAULT 'Uttar Pradesh'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `divisions`
--

INSERT INTO `divisions` (`id`, `name`, `state`) VALUES
(1, 'Agra', 'Uttar Pradesh'),
(2, 'Aligarh', 'Uttar Pradesh'),
(3, 'Bareilly', 'Uttar Pradesh'),
(4, 'Jhansi', 'Uttar Pradesh'),
(5, 'Kanpur', 'Uttar Pradesh'),
(6, 'Lucknow', 'Uttar Pradesh'),
(7, 'Meerut', 'Uttar Pradesh'),
(8, 'Varanasi', 'Uttar Pradesh');

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `role` enum('user','admin','blood_center','treatment_center') DEFAULT NULL,
  `is_read` tinyint(1) DEFAULT 0,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `user_id`, `message`, `role`, `is_read`, `created_at`) VALUES
(1, 2, 'Consent uploaded and submitted to Blood Center.', 'user', 0, '2025-05-15 02:02:32'),
(2, 2, 'User has given his Blood, Waiting for the Results.', 'user', 0, '2025-05-15 02:27:47'),
(3, 3, 'User has given his Blood, Waiting for the Results.', 'user', 0, '2025-05-15 13:37:16'),
(5, 3, 'User has given his Blood, Waiting for the Results.', 'user', 0, '2025-05-15 15:03:57'),
(6, 2, 'User has given his Blood, Waiting for the Results.', 'user', 0, '2025-05-15 15:05:07'),
(7, 3, 'User has given his Blood, Waiting for the Results.', 'user', 0, '2025-05-15 15:16:16'),
(8, 3, 'User has given his Blood, Waiting for the Results.', 'user', 0, '2025-05-15 15:17:02'),
(9, 2, 'User has given his Blood, Waiting for the Results.', 'user', 0, '2025-05-15 15:19:08'),
(10, 2, 'User has given his Blood, Waiting for the Results.', 'user', 0, '2025-05-15 15:39:26'),
(11, 4, 'User has given his Blood, Waiting for the Results.', 'user', 0, '2025-05-15 16:20:26'),
(12, 5, 'User has given his Blood, Waiting for the Results.', 'user', 0, '2025-05-15 16:34:40'),
(13, 5, 'User has given his Blood, Waiting for the Results.', 'user', 0, '2025-05-15 16:39:17'),
(14, 5, 'User has given his Blood, Waiting for the Results.', 'user', 0, '2025-05-15 16:43:14'),
(15, 7, 'User has given his Blood, Waiting for the Results.', 'user', 0, '2025-05-16 17:12:36');

-- --------------------------------------------------------

--
-- Table structure for table `rooms`
--

CREATE TABLE `rooms` (
  `id` int(11) NOT NULL,
  `room_name` varchar(100) DEFAULT NULL,
  `block_id` int(11) DEFAULT NULL,
  `doctor_name` varchar(100) DEFAULT NULL,
  `doctor_contact` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rooms`
--

INSERT INTO `rooms` (`id`, `room_name`, `block_id`, `doctor_name`, `doctor_contact`) VALUES
(1, 'Room 101', 1, 'Dr. Anil Sharma', '9345678902'),
(2, 'Room 102', 1, 'Dr. Ritu Mehra', '9234567891'),
(3, 'Room 201', 2, 'Dr. Manish Gupta', '9678901235'),
(4, 'Room 301', 3, 'Dr. Sneha Yadav', '9012345678'),
(5, 'Room 401', 4, 'Dr. Rajeev Khanna', '9123456780'),
(6, 'Room 301', 5, 'Dr. Harshit Gupta', '9890123457'),
(7, 'Room 545', 6, 'Dr. Kirti Saran', '9123456790'),
(8, 'Room 880', 7, 'Dr. Mary Jane', '7923456790');

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE `staff` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `role` enum('admin','blood_center','treatment_center') NOT NULL,
  `division_id` int(11) DEFAULT NULL,
  `district_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `staff`
--

INSERT INTO `staff` (`id`, `name`, `email`, `password`, `role`, `division_id`, `district_id`) VALUES
(1, 'Admin User', 'admin@example.com', '0192023a7bbd73250516f069df18b500', 'admin', NULL, NULL),
(2, 'Blood Center D', 'bloodcenter1@example.com', '46efafcefe369e9b73b8e214dc072ec2', 'blood_center', 6, 6),
(3, 'Sunrise Treatment Center', 'treatment@example.com', '173845260d33965f835ef1fb81a2c1eb', 'treatment_center', 6, 9),
(4, 'Blood Center E', 'bloodcenter2@example.com', '46efafcefe369e9b73b8e214dc072ec2', 'blood_center', 6, 6),
(5, 'Blood Center B', 'bloodcenter3@example.com', '46efafcefe369e9b73b8e214dc072ec2', 'blood_center', 4, 4),
(6, 'Blood Center K', 'bloodcenter4@example.com', '46efafcefe369e9b73b8e214dc072ec2', 'blood_center', 4, 4),
(7, 'Lifecare Treatment Hub', 'lifecare@example.com', '173845260d33965f835ef1fb81a2c1eb', 'treatment_center', 4, 4),
(10, 'Blood Center F', 'bloodcenter5@example.com', '46efafcefe369e9b73b8e214dc072ec2', 'blood_center', 6, 9),
(11, 'Blood Center A', 'bloodcenter6@example.com', '46efafcefe369e9b73b8e214dc072ec2', 'blood_center', 1, 1),
(12, 'Best Hospital Center', 'best@example.com', '173845260d33965f835ef1fb81a2c1eb', 'treatment_center', 6, 9),
(13, 'Blood Center C', 'bloodcenter7@example.com', '46efafcefe369e9b73b8e214dc072ec2', 'blood_center', 2, 2),
(14, 'Era Center', 'era@example.com', '173845260d33965f835ef1fb81a2c1eb', 'treatment_center', 2, 2),
(15, 'King George Wellness Center', 'king@example.com', '173845260d33965f835ef1fb81a2c1eb', 'treatment_center', 4, 4),
(16, 'Hope Wellness Center', 'hope@example.com', '173845260d33965f835ef1fb81a2c1eb', 'treatment_center', 2, 2);

-- --------------------------------------------------------

--
-- Table structure for table `treatments`
--

CREATE TABLE `treatments` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `treatment_center_id` int(11) NOT NULL,
  `blood_center_id` int(11) NOT NULL,
  `district_id` int(11) NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `room_no` varchar(20) DEFAULT NULL,
  `block` varchar(50) DEFAULT NULL,
  `doctor_name` varchar(100) DEFAULT NULL,
  `doctor_contact` varchar(15) NOT NULL,
  `status` enum('Started','Not Started') DEFAULT 'Not Started',
  `started_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `treatments`
--

INSERT INTO `treatments` (`id`, `user_id`, `treatment_center_id`, `blood_center_id`, `district_id`, `file_path`, `room_no`, `block`, `doctor_name`, `doctor_contact`, `status`, `started_at`) VALUES
(5, 8, 1, 4, 0, '../uploads/consents/1747678256_Consent_Form (9).pdf', 'Room 401', 'West Wing', 'Dr. Rajeev Khanna', '', '', '2025-05-20 09:28:18'),
(8, 10, 1, 4, 0, '../uploads/consents/1747712471_Consent_Form (15).pdf', 'Room 101', 'Block A', 'Dr. Anil Sharma', '', 'Started', '2025-05-20 09:28:36'),
(9, 9, 4, 7, 0, '../uploads/consents/1747713286_Consent_Form (16).pdf', 'Room 201', 'Block B', 'Dr. Manish Gupta', '', NULL, NULL),
(11, 11, 5, 6, 0, '../uploads/consents/1747721349_Consent_Form (21).pdf', 'Room 301', 'BLOCK LEVEL 1', 'Dr. Harshit Gupta', '', '', '2025-05-20 11:40:20'),
(12, 14, 7, 3, 0, '../uploads/consents/1747722307_Consent_Form (22).pdf', 'Room 545', 'BLOCK Z', 'Dr. Kirti Saran', '', '', '2025-05-20 11:59:36'),
(15, 20, 1, 4, 0, '../uploads/consents/1747742427_Consent_Form (33).pdf', 'Room 401', 'West Wing', 'Dr. Rajeev Khanna', '', 'Started', '2025-05-20 17:40:44'),
(21, 21, 7, 4, 3, '../uploads/consents/1747808184_Consent_Form (53).pdf', 'Room 545', 'BLOCK Z', 'Dr. Kirti Saran', '', 'Started', '2025-05-21 12:08:06'),
(22, 24, 7, 4, 3, '../uploads/consents/1747810363_Consent_Form (54).pdf', 'Room 545', 'BLOCK Z', 'Dr. Kirti Saran', '', 'Started', '2025-05-21 12:25:46'),
(23, 25, 2, 4, 3, '../uploads/consents/1747812051_Consent_Form (55).pdf', 'Room 301', 'Main Wing', 'Dr. Sneha Yadav', '', 'Started', '2025-05-21 12:53:01'),
(26, 26, 5, 4, 6, '../uploads/consents/1747814360_Consent_Form (59).pdf', 'Room 301', 'BLOCK LEVEL 1', 'Dr. Harshit Gupta', '9890123457', 'Started', '2025-05-21 13:31:25'),
(27, 27, 3, 3, 2, '../uploads/consents/1747895693_Consent_Form (60).pdf', 'Room 880', 'BLOCK HOPE B', 'Dr. Mary Jane', '7923456790', 'Started', '2025-05-22 12:06:38'),
(28, 28, 3, 3, 2, '../uploads/consents/1748856371_Consent_Form (4).pdf', 'Room 880', 'BLOCK HOPE B', 'Dr. Mary Jane', '7923456790', 'Started', '2025-06-02 14:57:11');

-- --------------------------------------------------------

--
-- Table structure for table `treatment_centers`
--

CREATE TABLE `treatment_centers` (
  `id` int(11) NOT NULL,
  `district_id` int(11) DEFAULT NULL,
  `center_name` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `treatment_centers`
--

INSERT INTO `treatment_centers` (`id`, `district_id`, `center_name`, `created_at`) VALUES
(1, 4, 'Sunrise Treatment Center', '2025-05-16 07:37:32'),
(2, 3, 'Lifecare Treatment Hub', '2025-05-16 07:37:32'),
(3, 2, 'Hope Wellness Center', '2025-05-16 07:37:32'),
(4, 7, 'King George Wellness Center', '2025-05-19 07:37:32'),
(5, 6, 'Best Hospital Center', '2025-05-19 07:37:32'),
(7, 3, 'Era Center', '2025-05-19 07:37:32');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `mobile_number` varchar(15) NOT NULL,
  `email` varchar(100) NOT NULL,
  `dob` date DEFAULT NULL,
  `age` int(11) NOT NULL,
  `gender` enum('Male','Female') NOT NULL,
  `blood_group` varchar(5) NOT NULL,
  `address` text NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `blood_center_id` int(11) DEFAULT NULL,
  `referred_blood_center` int(11) DEFAULT NULL,
  `role` enum('user') NOT NULL DEFAULT 'user',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `mobile_number`, `email`, `dob`, `age`, `gender`, `blood_group`, `address`, `status`, `blood_center_id`, `referred_blood_center`, `role`, `created_at`, `updated_at`) VALUES
(2, 'John', '1234567892', 'john@gmail.com', NULL, 45, 'Male', 'A+', 'Las Vegas', 1, 2, NULL, 'user', '2025-05-14 22:19:38', '2025-05-16 08:53:13'),
(3, 'Jyoti ', '1234567908', 'jyoti@gmail.com', NULL, 23, 'Female', 'B+', 'sdhgasdghasd', 1, 4, NULL, 'user', '2025-05-15 08:00:11', '2025-05-15 09:47:02'),
(4, 'Sagar Singh', '1234567894', 'sagarsingh@gmail.com', NULL, 24, 'Male', 'A+', 'Las Vegas', 1, 7, NULL, 'user', '2025-05-15 10:49:27', '2025-05-16 05:33:56'),
(5, 'Sachin Singh', '1234567890', 'sachin@gmail.com', NULL, 25, 'Male', 'A+', 'Las Vegas', 1, 2, NULL, 'user', '2025-05-15 11:04:05', '2025-05-16 06:04:11'),
(7, 'Tarzan Zing', '9956486174', 'tjsing3@gmail.com', NULL, 25, 'Male', 'B+', 'Lucknow', 1, 4, NULL, 'user', '2025-05-16 11:42:07', '2025-05-16 11:42:36'),
(8, 'Riya Gupta', '6670912313', 'riya@gmail.com', '2000-02-05', 24, 'Female', 'B+', 'Charbagh Lucknow', 1, 4, NULL, 'user', '2025-05-19 09:18:08', '2025-05-20 11:55:53'),
(9, 'Rinku Singh', '1234567822', 'rinku@gmail.com', NULL, 29, 'Male', 'AB+', 'asdssad', 1, 4, 7, 'user', '2025-05-19 09:30:11', '2025-05-19 09:30:11'),
(10, 'KAZIR KHAN', '8899223342', 'kazir@gmail.com', NULL, 24, 'Male', 'A+', 'asd', 1, 4, NULL, 'user', '2025-05-19 20:04:20', '2025-05-19 20:04:20'),
(11, 'Soniya Singh', '3344773388', 'soniya@gmail.com', NULL, 28, 'Female', 'B+', 'Toronto', 1, 4, 6, 'user', '2025-05-20 05:14:34', '2025-05-20 05:14:34'),
(14, 'KARAN', '6677488444', 'karan@gmail.com', NULL, 33, 'Male', 'AB+', 'asdas', 1, 6, 3, 'user', '2025-05-20 06:13:33', '2025-05-20 06:13:33'),
(15, 'BANU PRATAP', '7454454345', 'banu@gmail.com', NULL, 45, 'Male', 'B+', 'sadasdsad', 1, 4, 6, 'user', '2025-05-20 07:49:14', '2025-05-20 07:49:14'),
(20, 'Yashpal Singh', '7473454375', 'yashpal@gmail.com', '2025-05-07', 77, 'Male', 'B-', 'dfghjk', 1, 4, NULL, 'user', '2025-05-20 08:42:19', '2025-05-20 08:42:19'),
(21, 'AP Singh', '2131265367', 'ap@gmail.com', '2025-05-06', 1, 'Male', 'B-', 'sdaasdasd', 1, 4, NULL, 'user', '2025-05-20 12:13:43', '2025-05-20 12:13:43'),
(22, 'TESTING 1', '2343423424', 'testing@gmail.com', '2025-05-08', 2, 'Male', 'AB-', 'asdasd', 1, 4, 7, 'user', '2025-05-20 12:21:43', '2025-05-20 12:21:43'),
(24, 'HARSH VARDHAN', '4711236123', 'harshraj@gmail.com', '1997-05-06', 26, 'Male', 'B+', 'dfghjk', 1, 4, NULL, 'user', '2025-05-21 06:51:26', '2025-05-21 06:51:26'),
(25, 'TJ SINGH', '7993242342', 'tjsingh@gmail.com', '2000-02-04', 25, 'Male', 'B+', 'LUCKNOW', 1, 4, NULL, 'user', '2025-05-21 07:19:18', '2025-05-21 07:19:18'),
(26, 'JASPAL SINGH', '8345634536', 'jaspal@gmail.com', '2011-02-02', 14, 'Male', 'B+', 'asdjahsda', 1, 4, NULL, 'user', '2025-05-21 07:26:02', '2025-05-21 07:26:02'),
(27, 'JAZZY', '7723423642', 'jazzy@gmail.com', '1976-05-06', 49, 'Male', 'AB+', 'ashdahdadhasd', 1, 4, 3, 'user', '2025-05-22 06:28:49', '2025-05-22 06:28:49'),
(28, 'TESTING TODAY ', '1233333333', 'tjsi@gmail.com', '2015-06-03', 9, 'Male', 'AB+', 'hsaahsdhashd', 1, 4, 3, 'user', '2025-06-02 09:23:49', '2025-06-02 09:23:49');

-- --------------------------------------------------------

--
-- Table structure for table `user_test_results`
--

CREATE TABLE `user_test_results` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `blood_center_id` int(11) NOT NULL,
  `status` enum('positive','negative') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_test_results`
--

INSERT INTO `user_test_results` (`id`, `user_id`, `blood_center_id`, `status`) VALUES
(8, 3, 4, 'positive'),
(10, 2, 2, 'positive'),
(14, 5, 2, 'positive'),
(16, 7, 4, 'positive'),
(23, 8, 4, 'positive'),
(24, 4, 7, 'positive'),
(25, 9, 7, 'positive'),
(26, 10, 4, 'positive'),
(27, 11, 6, 'positive'),
(28, 14, 3, 'positive'),
(29, 15, 6, 'positive'),
(30, 20, 4, 'positive'),
(31, 21, 4, 'positive'),
(32, 22, 7, 'positive'),
(33, 23, 4, 'positive'),
(34, 24, 4, 'positive'),
(35, 25, 4, 'positive'),
(36, 26, 4, 'positive'),
(37, 27, 3, 'positive'),
(38, 28, 3, 'positive');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `allotted_users_center`
--
ALTER TABLE `allotted_users_center`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_id` (`user_id`);

--
-- Indexes for table `blocks`
--
ALTER TABLE `blocks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `treatment_center_id` (`treatment_center_id`);

--
-- Indexes for table `bloodgroup`
--
ALTER TABLE `bloodgroup`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `blood_centers`
--
ALTER TABLE `blood_centers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `district_id` (`district_id`);

--
-- Indexes for table `consents`
--
ALTER TABLE `consents`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_id` (`user_id`);

--
-- Indexes for table `districts`
--
ALTER TABLE `districts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `division_id` (`division_id`);

--
-- Indexes for table `divisions`
--
ALTER TABLE `divisions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rooms`
--
ALTER TABLE `rooms`
  ADD PRIMARY KEY (`id`),
  ADD KEY `block_id` (`block_id`);

--
-- Indexes for table `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `email_2` (`email`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `treatments`
--
ALTER TABLE `treatments`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_id` (`user_id`);

--
-- Indexes for table `treatment_centers`
--
ALTER TABLE `treatment_centers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `blood_center_id` (`district_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `email_2` (`email`),
  ADD UNIQUE KEY `mobile_number` (`mobile_number`);

--
-- Indexes for table `user_test_results`
--
ALTER TABLE `user_test_results`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_id` (`user_id`),
  ADD KEY `blood_center_id` (`blood_center_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `allotted_users_center`
--
ALTER TABLE `allotted_users_center`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `blocks`
--
ALTER TABLE `blocks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `bloodgroup`
--
ALTER TABLE `bloodgroup`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `blood_centers`
--
ALTER TABLE `blood_centers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `consents`
--
ALTER TABLE `consents`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `districts`
--
ALTER TABLE `districts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `divisions`
--
ALTER TABLE `divisions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `rooms`
--
ALTER TABLE `rooms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `staff`
--
ALTER TABLE `staff`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `treatments`
--
ALTER TABLE `treatments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `treatment_centers`
--
ALTER TABLE `treatment_centers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `user_test_results`
--
ALTER TABLE `user_test_results`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `blocks`
--
ALTER TABLE `blocks`
  ADD CONSTRAINT `blocks_ibfk_1` FOREIGN KEY (`treatment_center_id`) REFERENCES `treatment_centers` (`id`);

--
-- Constraints for table `blood_centers`
--
ALTER TABLE `blood_centers`
  ADD CONSTRAINT `blood_centers_ibfk_1` FOREIGN KEY (`district_id`) REFERENCES `districts` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `districts`
--
ALTER TABLE `districts`
  ADD CONSTRAINT `districts_ibfk_1` FOREIGN KEY (`division_id`) REFERENCES `divisions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `rooms`
--
ALTER TABLE `rooms`
  ADD CONSTRAINT `rooms_ibfk_1` FOREIGN KEY (`block_id`) REFERENCES `blocks` (`id`);

--
-- Constraints for table `treatment_centers`
--
ALTER TABLE `treatment_centers`
  ADD CONSTRAINT `treatment_centers_ibfk_1` FOREIGN KEY (`district_id`) REFERENCES `blood_centers` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
