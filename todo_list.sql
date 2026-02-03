-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 03, 2026 at 05:23 AM
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
-- Database: `todo_list`
--

-- --------------------------------------------------------

--
-- Table structure for table `task`
--

CREATE TABLE `task` (
  `id` int(255) NOT NULL,
  `taskname` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `priority` varchar(255) NOT NULL,
  `duedate` date NOT NULL,
  `status` tinyint(255) NOT NULL,
  `user_id` int(255) NOT NULL,
  `created_at` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `task`
--

INSERT INTO `task` (`id`, `taskname`, `description`, `priority`, `duedate`, `status`, `user_id`, `created_at`) VALUES
(13, 'hello ko bau', 'gu kha', '', '0000-00-00', 0, 3, '0000-00-00'),
(15, 'rashik', 'helloho', '', '2025-12-16', 1, 4, '0000-00-00'),
(16, 'Cookie Clicker', '', 'medium', '2025-12-24', 0, 4, '0000-00-00'),
(17, 'as', 'asdada', 'high', '2025-12-10', 1, 5, '0000-00-00'),
(19, 'rashik', '1234', 'medium', '2025-12-19', 0, 3, '0000-00-00'),
(21, 'Rashik Paudel', 'oooo', 'medium', '0000-00-00', 0, 5, '0000-00-00'),
(22, 'Cookie Clicker', 'koo', 'high', '2025-12-19', 0, 5, '0000-00-00'),
(23, 'as', 'hora', 'Medium', '2025-12-05', 0, 5, '0000-00-00'),
(24, 'Cookie Clicker', 'aaaaaaaaaaaa', 'Medium', '2025-12-05', 1, 6, '0000-00-00'),
(25, 'php project', 'to do list', 'High', '2025-12-05', 0, 8, '0000-00-00'),
(26, 'NPL', 'saturday game', 'Medium', '2025-12-06', 0, 8, '0000-00-00'),
(27, 'khana khane', 'tanna bhat khane', 'High', '2025-12-05', 1, 8, '0000-00-00'),
(28, 'Hotel Management System', 'php to code hotel management system', 'high', '2025-12-12', 0, 9, '0000-00-00'),
(29, 'Upload Shorts', 'Valo ko shorts\r\nSazon getting trolled on insta', 'Medium', '2025-12-09', 1, 9, '0000-00-00'),
(30, 'Thumbnail for live belka', 'belka ko live lai thumbnail', 'Low', '2025-12-09', 1, 9, '0000-00-00'),
(31, 'rashik', 'zXX', 'High', '2026-01-31', 1, 10, '0000-00-00'),
(32, 'sss', 'ssssssss', 'Medium', '2026-02-02', 0, 10, '0000-00-00'),
(33, 'as', 'sadad', 'Low', '2026-02-02', 1, 10, '0000-00-00');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(255) NOT NULL,
  `username` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `email`, `password`) VALUES
(1, 'hello', 'ram@prasad', '123'),
(2, 'ac', 'ram@prasad', '111'),
(3, 'hello', 'hellohi@123.com', '1212'),
(4, 'hi', 'ram@prasad', '111'),
(5, 'Destr0yer', 'rashik.pasa456@gmail.com', '1'),
(6, '', '', ''),
(7, '', '', ''),
(8, 'rashik', 'rashik.pasa456@gmail.com', '1122'),
(9, 'rashik', 'marashikho123@gmail.com', '999'),
(10, 'hello', 'as@gmail.com', '111');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `task`
--
ALTER TABLE `task`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `task`
--
ALTER TABLE `task`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
