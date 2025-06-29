-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 29, 2025 at 08:32 PM
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
(9, 'QualityTestingSeeker', 'QualityTestingSeeker@gmail.com', '$2y$10$V83IYrD/EEGUE27HAymCUuAf9fU4alptu3Hf8ZRafDX8kQ7kPGM7.', 'seeker', '2025-06-29 16:41:42');

--
-- Indexes for dumped tables
--

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
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
