-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 31, 2017 at 04:58 PM
-- Server version: 10.1.21-MariaDB
-- PHP Version: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `redem`
--

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `type` int(11) NOT NULL,
  `name` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`type`, `name`) VALUES
(1, 'Flat'),
(2, 'Tenament'),
(3, 'Bunglow');

-- --------------------------------------------------------

--
-- Table structure for table `property`
--

CREATE TABLE `property` (
  `id` int(11) NOT NULL,
  `username` varchar(20) NOT NULL,
  `type` int(11) NOT NULL,
  `bhk` int(11) NOT NULL,
  `address` varchar(100) NOT NULL,
  `description` varchar(100) NOT NULL,
  `area` varchar(20) NOT NULL,
  `city` varchar(20) NOT NULL,
  `price` bigint(20) NOT NULL,
  `image` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `property`
--

INSERT INTO `property` (`id`, `username`, `type`, `bhk`, `address`, `description`, `area`, `city`, `price`, `image`) VALUES
(2, 'prit2596', 1, 1, '', '', 'skjk', 'kjdjk', 7500, NULL),
(3, 'prit2596', 2, 33, '', '', 'hhh', 'dmd', 888, NULL),
(4, 'prit2596', 2, 33, '', 'jh', 'hhh', 'dmd', 888, NULL),
(5, 'prit2596', 1, 2, '', 'jcnmskjdjd', 'Chikhli', 'Navsari', 880, NULL),
(6, 'prit2596', 1, 2, '', 'jcnmskjdjd', 'Chikhli', 'Navsari', 880, NULL),
(7, 'prit2596', 1, 2, '', 'cnkjcs', 'Bayad', 'Aravalli', 5566, NULL),
(8, 'prit2596', 1, 2, '', 'llfisdfosdhf', 'Chikhli', 'Navsari', 1230, NULL),
(9, 'prit2596', 1, 2, '', 'jssjkdkjdjk', 'Bhavnagar', 'Bhavnagar', 999, NULL),
(10, 'prit2596', 1, 2, '', 'jssjkdkjdjk', 'Bhavnagar', 'Bhavnagar', 999, NULL),
(11, 'prit2596', 1, 2, '', 'hkjdsakd', 'Bayad', 'Aravalli', 56, NULL),
(12, 'prit2596', 2, 3, '', 'woderful house with front view and awesome stream', 'Jalalpore', 'Navsari', 8000, NULL),
(13, 'prit2596', 2, 4, '', 'kdjdjk', 'Jalalpore', 'Navsari', 8000, NULL),
(14, 'prit2596', 3, 3, '', 'Nice view', 'Hansot', 'Bharuch', 8000, NULL),
(15, 'prit2596', 1, 4, 'E/102 Earth Ambroasia,opp. McDonald,sama', 'Front view flat with awweome air circulation', 'Savli', 'Vadodara', 11000, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `username` varchar(20) NOT NULL,
  `firstname` varchar(20) NOT NULL,
  `lastname` varchar(20) NOT NULL,
  `password` varchar(20) NOT NULL,
  `address` varchar(100) NOT NULL,
  `city` varchar(20) NOT NULL,
  `state` varchar(20) NOT NULL,
  `zipcode` int(11) NOT NULL,
  `contact` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`username`, `firstname`, `lastname`, `password`, `address`, `city`, `state`, `zipcode`, `contact`) VALUES
('arth573', 'arth', 'patel', 'arth@2596', 'anand', 'anand', 'gujrat', 333333, 9586484097),
('dhruv454', 'dhruv', 'patel', 'dhruv@2596', 'amitnagar karelibaug,vadodara', 'vadodara', 'gujrat', 390018, 8469905736),
('meet7119', 'meet', 'thakkar', 'meet@2596', 'subhanpura', 'vadodara', 'gujrat', 390022, 9825050728),
('niki12', 'Niki', 'Thakkar', 'niki@2596', 'E/102 rajeshwar gold flats bh.vallam hall,harni road.', 'vadodara', 'gujrat', 390022, 8905729846),
('prit2596', 'Prit', 'Thakkar', 'prit@2596', 'E/102 Rajeshwar gold flats,bh.vallam hall,harni road', 'vadoadara', 'gujrat', 390022, 7043613882),
('ronit123', 'ronit', 'patel', 'ronit@2596', 'vasna road', 'vadodara', 'gujrat', 323332, 9409400284),
('shail1996', 'shail', 'shah', 'shail@1996', 'sector 21', 'gandhinagar', 'gujrat', 333333, 9429388005);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`type`);

--
-- Indexes for table `property`
--
ALTER TABLE `property`
  ADD PRIMARY KEY (`id`),
  ADD KEY `type` (`type`),
  ADD KEY `username` (`username`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `property`
--
ALTER TABLE `property`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `property`
--
ALTER TABLE `property`
  ADD CONSTRAINT `property_category_fk` FOREIGN KEY (`type`) REFERENCES `category` (`type`),
  ADD CONSTRAINT `property_users_fk` FOREIGN KEY (`username`) REFERENCES `users` (`username`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
