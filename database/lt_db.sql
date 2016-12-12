-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Dec 12, 2016 at 10:59 AM
-- Server version: 10.1.13-MariaDB
-- PHP Version: 5.5.37

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `lt_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `users_booking`
--

CREATE TABLE `users_booking` (
  `id` int(250) NOT NULL,
  `name_event` varchar(50) NOT NULL,
  `lt_selected` int(50) NOT NULL,
  `message` varchar(500) NOT NULL,
  `bookingID_name` text NOT NULL,
  `club_name` varchar(50) NOT NULL,
  `start_time` time NOT NULL DEFAULT '17:00:00',
  `end_time` time NOT NULL,
  `date` date NOT NULL,
  `name_superviser` text NOT NULL,
  `reference_number` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `users_profile`
--

CREATE TABLE `users_profile` (
  `id` int(11) NOT NULL,
  `user_name` varchar(50) NOT NULL,
  `password` varchar(200) NOT NULL,
  `email` varchar(50) NOT NULL,
  `position` varchar(50) NOT NULL,
  `privilage` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users_profile`
--

INSERT INTO `users_profile` (`id`, `user_name`, `password`, `email`, `position`, `privilage`) VALUES
(2, 'Dhruvraj Singh Rawat', '$2y$11$OuqetlI6o2z2gVw4W5Qsgu3sBxI7fS7gyzWKeuXz2lugNo4brjTqG', 'dhruv@gmail.com', 'Backend Developer', 2),
(18, 'Test   ', '$2y$11$ueVM4sYQ0GoJFxdTE1wiZ.OPRtz.vkkwwlIPAD6M5DiN8LBr979DG', 'test@abc.com', 'N/A ', 2);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `users_booking`
--
ALTER TABLE `users_booking`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users_profile`
--
ALTER TABLE `users_profile`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `users_booking`
--
ALTER TABLE `users_booking`
  MODIFY `id` int(250) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=166;
--
-- AUTO_INCREMENT for table `users_profile`
--
ALTER TABLE `users_profile`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
