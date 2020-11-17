-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 21, 2020 at 04:25 PM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.2.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `online_exam`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_table`
--

CREATE TABLE `admin_table` (
  `admin_id` int(11) NOT NULL,
  `admin_email_address` varchar(150) CHARACTER SET latin1 NOT NULL,
  `admin_password` varchar(250) CHARACTER SET latin1 NOT NULL,
  `admin_verification_code` varchar(150) CHARACTER SET latin1 NOT NULL,
  `admin_type` enum('master','sub_master') CHARACTER SET latin1 NOT NULL,
  `admin_created_on` datetime NOT NULL,
  `email_verified` enum('no','yes') CHARACTER SET latin1 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admin_table`
--

INSERT INTO `admin_table` (`admin_id`, `admin_email_address`, `admin_password`, `admin_verification_code`, `admin_type`, `admin_created_on`, `email_verified`) VALUES
(1, 'oregsgraphix@gmail.com', '$2y$10$Ew7cQGB9ZDUA/ejaTxZcZeCqazMSZ6updv8yDKDmQ4bvKT.sC7dRa', 'e80fd6050c969f7ee00fb268f84d6577', 'sub_master', '2020-02-03 22:59:52', 'yes'),
(2, 'oregs@gmail.com', '$2y$10$tTLfxjgpHaf/BwrIN6OKF.G0XFPH5v9trc.7jFDA2Bd1SsKBWAWyC', '0e45d568b585a15bc6ef5b55890c2c46', 'sub_master', '2020-02-08 11:41:18', 'no');

-- --------------------------------------------------------

--
-- Table structure for table `online_exam_table`
--

CREATE TABLE `online_exam_table` (
  `online_exam_id` int(11) NOT NULL,
  `admin_id` int(11) NOT NULL,
  `online_exam_title` varchar(250) CHARACTER SET latin1 NOT NULL,
  `online_exam_datetime` datetime NOT NULL,
  `online_exam_duration` varchar(30) CHARACTER SET latin1 NOT NULL,
  `total_question` int(5) NOT NULL,
  `marks_per_right_answer` varchar(30) CHARACTER SET latin1 NOT NULL,
  `marks_per_wrong_answer` varchar(30) CHARACTER SET latin1 NOT NULL,
  `online_exam_created_on` datetime NOT NULL,
  `online_exam_status` enum('Pending','Created','Started','Completed') CHARACTER SET latin1 NOT NULL,
  `online_exam_code` varchar(100) CHARACTER SET latin1 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `online_exam_table`
--

INSERT INTO `online_exam_table` (`online_exam_id`, `admin_id`, `online_exam_title`, `online_exam_datetime`, `online_exam_duration`, `total_question`, `marks_per_right_answer`, `marks_per_wrong_answer`, `online_exam_created_on`, `online_exam_status`, `online_exam_code`) VALUES
(1, 1, 'PHP Online Exam 1', '2020-03-17 11:25:00', '5', 5, '1', '1', '2020-02-03 23:03:24', 'Completed', 'fcfa28033fa3e797a152ccaa6bb46dd1'),
(2, 1, 'Java Script Exam 1', '2020-03-26 15:45:00', '5', 5, '1', '1', '2020-03-16 14:49:50', 'Pending', 'a6ff5a9344f0d12b74337f71acd3641e');

-- --------------------------------------------------------

--
-- Table structure for table `option_table`
--

CREATE TABLE `option_table` (
  `option_id` int(11) NOT NULL,
  `question_id` int(11) NOT NULL,
  `option_number` int(4) NOT NULL,
  `option_title` varchar(250) CHARACTER SET latin1 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `option_table`
--

INSERT INTO `option_table` (`option_id`, `question_id`, `option_number`, `option_title`) VALUES
(1, 1, 1, 'var m = 0;'),
(2, 1, 2, 'm var = red;'),
(3, 1, 3, 'var red = ;m'),
(4, 1, 4, '0 = m; red'),
(5, 2, 1, 'red$ = \'new\';'),
(6, 2, 2, 'var red = \'new\';'),
(7, 2, 3, '$red = \'new\';'),
(8, 2, 4, 'let red = \'new\';'),
(9, 3, 1, 'if(argument){}'),
(10, 3, 2, 'if(argument):'),
(11, 3, 3, 'if(argument);'),
(12, 3, 4, 'if{(argument)};'),
(13, 4, 1, 'phpMyAdmin is a free software tool written in Python that is intended to handle the administration of a MySQL or MariaDB database server.'),
(14, 4, 2, 'to handle the administration of a MySQL or MariaDB database servphpMyAdmin is a free hardware tool coupled together that is intended er.'),
(15, 4, 3, 'phpMyAdmin is a free software tool written in Java that is intended to handle the administration of a MySQL or MariaDB database server.'),
(16, 4, 4, 'phpMyAdmin is a free software tool written in PHP that is intended to handle the administration of a MySQL or MariaDB database server.'),
(17, 5, 1, 'a web browser with cookies and JavaScript'),
(18, 5, 2, 'a web browser and compiler'),
(19, 5, 3, 'python programming language and JavaScript'),
(20, 5, 4, 'cookies and JavaScript');

-- --------------------------------------------------------

--
-- Table structure for table `question_table`
--

CREATE TABLE `question_table` (
  `question_id` int(11) NOT NULL,
  `online_exam_id` int(11) NOT NULL,
  `question_title` text CHARACTER SET latin1 NOT NULL,
  `answer_option` enum('1','2','3','4') CHARACTER SET latin1 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `question_table`
--

INSERT INTO `question_table` (`question_id`, `online_exam_id`, `question_title`, `answer_option`) VALUES
(1, 1, 'How to declare a variable in php', '1'),
(2, 1, 'which of the options is right on global variable declaration in PHP', '3'),
(3, 1, 'Which statement is correct?', '1'),
(4, 1, 'What is phpMyAdmin?', '4'),
(5, 1, 'To access phpMyAdmin you need _______ and _______ enabled.', '1');

-- --------------------------------------------------------

--
-- Table structure for table `user_exam_enroll_table`
--

CREATE TABLE `user_exam_enroll_table` (
  `user_exam_enroll_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `exam_id` int(11) NOT NULL,
  `attendance_status` enum('Absent','Present') CHARACTER SET latin1 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user_exam_enroll_table`
--

INSERT INTO `user_exam_enroll_table` (`user_exam_enroll_id`, `user_id`, `exam_id`, `attendance_status`) VALUES
(5, 1, 1, 'Present');

-- --------------------------------------------------------

--
-- Table structure for table `user_exam_question_answer`
--

CREATE TABLE `user_exam_question_answer` (
  `user_exam_question_answer_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `exam_id` int(11) NOT NULL,
  `question_id` int(11) NOT NULL,
  `user_answer_option` enum('1','2','3','4') CHARACTER SET latin1 NOT NULL,
  `marks` varchar(10) CHARACTER SET latin1 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user_exam_question_answer`
--

INSERT INTO `user_exam_question_answer` (`user_exam_question_answer_id`, `user_id`, `exam_id`, `question_id`, `user_answer_option`, `marks`) VALUES
(21, 1, 1, 1, '1', '+1'),
(22, 1, 1, 2, '3', '+1'),
(23, 1, 1, 3, '1', '+1'),
(24, 1, 1, 4, '4', '+1'),
(25, 1, 1, 5, '4', '-1');

-- --------------------------------------------------------

--
-- Table structure for table `user_table`
--

CREATE TABLE `user_table` (
  `user_id` int(11) NOT NULL,
  `user_email_address` varchar(250) CHARACTER SET latin1 NOT NULL,
  `user_password` varchar(150) CHARACTER SET latin1 NOT NULL,
  `user_verification_code` varchar(100) CHARACTER SET latin1 NOT NULL,
  `user_name` varchar(150) CHARACTER SET latin1 NOT NULL,
  `user_gender` enum('Male','Female') CHARACTER SET latin1 NOT NULL,
  `user_address` text CHARACTER SET latin1 NOT NULL,
  `user_mobile_no` varchar(15) CHARACTER SET latin1 NOT NULL,
  `user_image` varchar(150) CHARACTER SET latin1 NOT NULL,
  `user_created_on` datetime NOT NULL,
  `user_email_verified` enum('no','yes') CHARACTER SET latin1 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user_table`
--

INSERT INTO `user_table` (`user_id`, `user_email_address`, `user_password`, `user_verification_code`, `user_name`, `user_gender`, `user_address`, `user_mobile_no`, `user_image`, `user_created_on`, `user_email_verified`) VALUES
(1, 'oregs4life@gmail.com', '$2y$10$Z.YMkaPgRDMlgUWdgdMTye/oWpHwaIAA3SeFDDx7qFZrSS6GJ1FOa', 'c11504eb145e6bb3b8b9296a8c5f8c2f', 'Oregunwa Segun', 'Male', 'FCE(T), Opp. St. Finbarr\'s college, Akoka, Lagos State.', '08105444538', '5e45ecb3e2929.jpg', '2020-02-08 16:02:37', 'yes'),
(2, 'bamiduro@gmail.com', '$2y$10$3k7wUMyRW.8UN0mXS6yme.rbmj.Bkz/ZzbwqhnoQwjx7VVKn7Jyoe', '9467f8797057e161feca414b72f84fa6', 'Bamiduro Mercy', 'Female', 'FCE(T), Opp. St. Finbarr\'s college, Akoka', '08105444538', '5e3ece019efa0.jpg', '2020-02-08 16:04:33', 'no');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_table`
--
ALTER TABLE `admin_table`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `online_exam_table`
--
ALTER TABLE `online_exam_table`
  ADD PRIMARY KEY (`online_exam_id`);

--
-- Indexes for table `option_table`
--
ALTER TABLE `option_table`
  ADD PRIMARY KEY (`option_id`);

--
-- Indexes for table `question_table`
--
ALTER TABLE `question_table`
  ADD PRIMARY KEY (`question_id`);

--
-- Indexes for table `user_exam_enroll_table`
--
ALTER TABLE `user_exam_enroll_table`
  ADD PRIMARY KEY (`user_exam_enroll_id`);

--
-- Indexes for table `user_exam_question_answer`
--
ALTER TABLE `user_exam_question_answer`
  ADD PRIMARY KEY (`user_exam_question_answer_id`);

--
-- Indexes for table `user_table`
--
ALTER TABLE `user_table`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_table`
--
ALTER TABLE `admin_table`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `online_exam_table`
--
ALTER TABLE `online_exam_table`
  MODIFY `online_exam_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `option_table`
--
ALTER TABLE `option_table`
  MODIFY `option_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `question_table`
--
ALTER TABLE `question_table`
  MODIFY `question_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `user_exam_enroll_table`
--
ALTER TABLE `user_exam_enroll_table`
  MODIFY `user_exam_enroll_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `user_exam_question_answer`
--
ALTER TABLE `user_exam_question_answer`
  MODIFY `user_exam_question_answer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `user_table`
--
ALTER TABLE `user_table`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
