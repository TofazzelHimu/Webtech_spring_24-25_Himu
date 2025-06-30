-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 30, 2025 at 08:32 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `job_portal`
--

-- --------------------------------------------------------

--
-- Table structure for table `applications`
--

CREATE TABLE `applications` (
  `id` int(11) NOT NULL,
  `job_id` int(11) NOT NULL,
  `seeker_id` int(11) NOT NULL,
  `status` enum('applied','accepted','rejected') DEFAULT 'applied',
  `applied_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `applications`
--

INSERT INTO `applications` (`id`, `job_id`, `seeker_id`, `status`, `applied_at`) VALUES
(1, 1, 2, 'applied', '2025-06-23 21:17:15'),
(2, 2, 3, 'applied', '2025-06-23 21:17:15'),
(3, 3, 4, 'applied', '2025-06-23 21:17:15'),
(4, 4, 2, '', '2025-06-23 21:17:15'),
(5, 5, 3, '', '2025-06-23 21:17:15'),
(6, 6, 2, 'applied', '2025-06-23 21:17:15'),
(7, 7, 4, 'applied', '2025-06-23 21:17:15'),
(8, 8, 3, 'applied', '2025-06-23 21:17:15'),
(9, 9, 2, '', '2025-06-23 21:17:15'),
(10, 10, 4, 'rejected', '2025-06-23 21:17:15'),
(14, 16, 2, 'rejected', '2025-06-29 18:25:26'),
(16, 16, 9, 'applied', '2025-06-30 05:13:02');

-- --------------------------------------------------------

--
-- Table structure for table `follow_ups`
--

CREATE TABLE `follow_ups` (
  `id` int(11) NOT NULL,
  `application_id` int(11) NOT NULL,
  `reminder` text DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `follow_ups`
--

INSERT INTO `follow_ups` (`id`, `application_id`, `reminder`, `updated_at`) VALUES
(1, 1, 'Remind Me ', '2025-06-29 16:03:30');

-- --------------------------------------------------------

--
-- Table structure for table `interviews`
--

CREATE TABLE `interviews` (
  `id` int(11) NOT NULL,
  `application_id` int(11) NOT NULL,
  `employer_id` int(11) NOT NULL,
  `interview_time` datetime NOT NULL,
  `location` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `interviews`
--

INSERT INTO `interviews` (`id`, `application_id`, `employer_id`, `interview_time`, `location`) VALUES
(1, 1, 1, '2025-06-25 10:00:00', 'Zoom'),
(2, 2, 1, '2025-06-25 14:00:00', 'Office'),
(3, 4, 5, '2025-06-26 09:30:00', 'Google Meet'),
(4, 5, 5, '2025-06-26 15:00:00', 'Skype'),
(8, 9, 1, '2025-06-28 14:00:00', 'Skype'),
(11, 10, 5, '2025-06-03 06:36:00', 'qefwefwef'),
(12, 10, 5, '2025-06-03 06:36:00', 'qefwefwef'),
(16, 14, 8, '2025-06-20 03:45:00', 'adawdawd');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` int(11) NOT NULL,
  `employer_id` int(11) NOT NULL,
  `title` varchar(150) NOT NULL,
  `description` text NOT NULL,
  `location` varchar(100) DEFAULT NULL,
  `salary` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `jobs`
--

INSERT INTO `jobs` (`id`, `employer_id`, `title`, `description`, `location`, `salary`, `created_at`) VALUES
(1, 1, 'Junior PHP Developer', 'Assist in developing PHP-based systems.', 'Dhaka', '30,000 BDT', '2025-06-23 21:17:15'),
(2, 1, 'Frontend Intern', 'Support in frontend UI implementation.', 'Dhaka', '20,000 BDT', '2025-06-23 21:17:15'),
(3, 1, 'Laravel Developer', 'Work on Laravel backend APIs.', 'Remote', '40,000 BDT', '2025-06-23 21:17:15'),
(4, 5, 'React JS Intern', 'Entry level React internship.', 'Remote', '18,000 BDT', '2025-06-23 21:17:15'),
(5, 5, 'QA Tester', 'Test platform features.', 'Remote', '28,000 BDT', '2025-06-23 21:17:15'),
(6, 1, 'Backend Engineer', 'Develop backend systems.', 'Dhaka', '45,000 BDT', '2025-06-23 21:17:15'),
(7, 1, 'UI/UX Designer', 'Design mockups and prototypes.', 'Dhaka', '35,000 BDT', '2025-06-23 21:17:15'),
(8, 5, 'DevOps Intern', 'Manage CI/CD pipelines.', 'Remote', '22,000 BDT', '2025-06-23 21:17:15'),
(9, 1, 'Mobile App Dev', 'Build Flutter apps.', 'Dhaka', '50,000 BDT', '2025-06-23 21:17:15'),
(10, 5, 'Content Writer', 'Write blog & product docs.', 'Remote', '15,000 BDT', '2025-06-23 21:17:15'),
(16, 8, 'QA', 'QA Description', 'QA', 'QA BDT', '2025-06-29 18:21:14'),
(17, 8, '3dwefg', 'fwefw', 'sefw', 'wwefw', '2025-06-29 18:44:42');

-- --------------------------------------------------------

--
-- Table structure for table `job_alerts`
--

CREATE TABLE `job_alerts` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `keywords` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `job_alerts`
--

INSERT INTO `job_alerts` (`id`, `user_id`, `keywords`, `created_at`) VALUES
(1, 2, 'PHP', '2025-06-23 21:17:15'),
(2, 2, 'Backend', '2025-06-23 21:17:15'),
(3, 3, 'Frontend', '2025-06-23 21:17:15'),
(4, 3, 'Internship', '2025-06-23 21:17:15'),
(5, 4, 'Laravel', '2025-06-23 21:17:15'),
(6, 4, 'React', '2025-06-23 21:17:15'),
(7, 2, 'Remote', '2025-06-23 21:17:15'),
(8, 3, 'Tester', '2025-06-23 21:17:15'),
(9, 4, 'Flutter', '2025-06-23 21:17:15'),
(10, 2, 'QA', '2025-06-23 21:17:15'),
(14, 9, 'QA', '2025-06-29 18:42:33');

-- --------------------------------------------------------

--
-- Table structure for table `resumes`
--

CREATE TABLE `resumes` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `filename` varchar(255) NOT NULL,
  `filepath` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `resumes`
--

INSERT INTO `resumes` (`id`, `user_id`, `filename`, `filepath`, `created_at`) VALUES
(1, 2, 'Chris_CV.pdf', 'uploads/resumes/Chris_CV.pdf', '2025-06-23 21:17:15'),
(2, 3, 'George_CV.pdf', 'uploads/resumes/George_CV.pdf', '2025-06-23 21:17:15'),
(3, 4, 'Meem_CV.pdf', 'uploads/resumes/Meem_CV.pdf', '2025-06-23 21:17:15'),
(4, 2, 'Chris_Updated.pdf', 'uploads/resumes/Chris_Updated.pdf', '2025-06-23 21:17:15'),
(5, 3, 'George_Dev.pdf', 'uploads/resumes/George_Dev.pdf', '2025-06-23 21:17:15'),
(6, 4, 'Meem_Design.pdf', 'uploads/resumes/Meem_Design.pdf', '2025-06-23 21:17:15'),
(7, 2, 'Chris_Resume.pdf', 'uploads/resumes/Chris_Resume.pdf', '2025-06-23 21:17:15'),
(8, 3, 'George_Backend.pdf', 'uploads/resumes/George_Backend.pdf', '2025-06-23 21:17:15'),
(9, 4, 'Meem_Tester.pdf', 'uploads/resumes/Meem_Tester.pdf', '2025-06-23 21:17:15'),
(10, 2, 'Chris_QA.pdf', 'uploads/resumes/Chris_QA.pdf', '2025-06-23 21:17:15'),
(11, 1, 'JobPortalCV.pdf', '../uploads/resumes/JobPortalCV.pdf', '2025-06-29 15:48:06'),
(12, 1, 'JobPortalCV.pdf', '../uploads/resumes/JobPortalCV.pdf', '2025-06-29 15:50:17'),
(16, 9, 'JobPortalCV.pdf', 'uploads/resumes/JobPortalCV.pdf', '2025-06-30 05:12:45');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `user_type` enum('seeker','employer') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `user_type`, `created_at`) VALUES
(1, 'Doom Guy', 'Employee@gmail.com', '$2y$10$H4O0AxytbI.3qCRuOlV6TeNQn3PNVpXtHpvWtBeZbOCnPD2yo34wG', 'employer', '2025-06-23 20:53:53'),
(2, 'Chris Martin', 'Seeker@gmail.com', '$2y$10$pZb3fc2Hdz8PJtxEIVeW8upjol6U6Zbxr1HnDSZ6g.2BEEO.U4e.e', 'seeker', '2025-06-23 20:54:14'),
(3, 'George Martin', 'Seeker2@gmail.com', '$2y$10$0XEeTz/y1USt2oURKv0e1OpausjGcszxS3F5QhSx2QpCoM4KXREam', 'seeker', '2025-06-23 21:05:01'),
(4, 'Meem Aktar', 'Seeker3@Gmail.com', '$2y$10$xw2yz4TI51mgiWaqdvw0veeeee0LdRgtY77zL/zZlmpnReUWfRPQe', 'seeker', '2025-06-23 21:05:26'),
(5, 'Blake Lively', 'Employee2@gmail.com', '$2y$10$lkT6ifgrTyVo64kE20akoujKrTnPB7jdZmGcFPSFi9TIJ29O/dmjC', 'employer', '2025-06-23 21:06:05'),
(8, 'QualityTestingEmployee', 'QualityTestingEmployee@gmail.com', '$2y$10$9e9ybeqVVSWFsxYDWqgsS.PsLMabjG7M/9lOTP9hm1oiknViK1epq', 'employer', '2025-06-29 16:27:16'),
(9, 'QualityTestingSeeker', 'QualityTestingSeeker@gmail.com', '$2y$10$V83IYrD/EEGUE27HAymCUuAf9fU4alptu3Hf8ZRafDX8kQ7kPGM7.', 'seeker', '2025-06-29 16:41:42'),
(10, 'QA Employer', 'QAEmployer@gmail.com', '$2y$10$jguOsgZAo5QhGznkiA.iZucKeJH7Fp3Gdpgvpj2P1tq5zVHSgdvre', 'employer', '2025-06-29 18:36:47');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `applications`
--
ALTER TABLE `applications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `job_id` (`job_id`),
  ADD KEY `seeker_id` (`seeker_id`);

--
-- Indexes for table `follow_ups`
--
ALTER TABLE `follow_ups`
  ADD PRIMARY KEY (`id`),
  ADD KEY `application_id` (`application_id`);

--
-- Indexes for table `interviews`
--
ALTER TABLE `interviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `application_id` (`application_id`),
  ADD KEY `employer_id` (`employer_id`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `employer_id` (`employer_id`);

--
-- Indexes for table `job_alerts`
--
ALTER TABLE `job_alerts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `resumes`
--
ALTER TABLE `resumes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `applications`
--
ALTER TABLE `applications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `follow_ups`
--
ALTER TABLE `follow_ups`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `interviews`
--
ALTER TABLE `interviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `job_alerts`
--
ALTER TABLE `job_alerts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `resumes`
--
ALTER TABLE `resumes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `applications`
--
ALTER TABLE `applications`
  ADD CONSTRAINT `applications_ibfk_1` FOREIGN KEY (`job_id`) REFERENCES `jobs` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `applications_ibfk_2` FOREIGN KEY (`seeker_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `follow_ups`
--
ALTER TABLE `follow_ups`
  ADD CONSTRAINT `follow_ups_ibfk_1` FOREIGN KEY (`application_id`) REFERENCES `applications` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `interviews`
--
ALTER TABLE `interviews`
  ADD CONSTRAINT `interviews_ibfk_1` FOREIGN KEY (`application_id`) REFERENCES `applications` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `interviews_ibfk_2` FOREIGN KEY (`employer_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `jobs`
--
ALTER TABLE `jobs`
  ADD CONSTRAINT `jobs_ibfk_1` FOREIGN KEY (`employer_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `job_alerts`
--
ALTER TABLE `job_alerts`
  ADD CONSTRAINT `job_alerts_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `resumes`
--
ALTER TABLE `resumes`
  ADD CONSTRAINT `resumes_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
