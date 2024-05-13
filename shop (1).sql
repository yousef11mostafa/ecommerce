-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 14, 2024 at 12:33 AM
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
-- Database: `shop`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(30) NOT NULL,
  `description` text NOT NULL,
  `ordering` int(11) NOT NULL,
  `visibility` smallint(6) NOT NULL,
  `allow_comment` smallint(6) NOT NULL,
  `allow_adds` smallint(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `description`, `ordering`, `visibility`, `allow_comment`, `allow_adds`) VALUES
(13, 'clothes', 'sdfsdaf', 0, 0, 0, 0),
(17, 'computers', 'computers categories', 2, 0, 0, 0),
(18, 'Hand made', 'it is a simple categories', 6, 0, 0, 0),
(20, 'wood', 'perfect wood', 5, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `c_id` int(11) NOT NULL,
  `comment` text NOT NULL,
  `status` int(11) NOT NULL,
  `comment_date` date NOT NULL,
  `item_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`c_id`, `comment`, `status`, `comment_date`, `item_id`, `user_id`) VALUES
(1, 'it is good', 0, '0000-00-00', 27, 40),
(2, 'it is good game', 0, '0000-00-00', 20, 35);

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `item_id` int(11) NOT NULL,
  `name` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `description` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `price` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `add_date` date NOT NULL,
  `country_made` varchar(40) NOT NULL,
  `image` varchar(130) NOT NULL,
  `approve` int(11) DEFAULT NULL,
  `status` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `rating` int(11) NOT NULL,
  `cat_id` int(11) NOT NULL,
  `member_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`item_id`, `name`, `description`, `price`, `add_date`, `country_made`, `image`, `approve`, `status`, `rating`, `cat_id`, `member_id`) VALUES
(20, 'game', 'test game for item', '20', '2024-03-25', 'egypt', '0', 1, '2', 0, 17, 35),
(21, 'network ', 'cet g network cable', '25', '2024-03-25', 'egypt', '0', 1, '1', 0, 17, 33),
(22, 'yeti blue mic', 'this is good microfon', '35', '2024-03-25', 'china', '0', 0, '1', 0, 17, 23),
(23, 'magic mouse', 'it is a good mouse', '77', '2024-03-25', 'china', '0', 1, '2', 0, 17, 23),
(24, 'mouse', 'test game for item', '25', '2024-03-25', 'egypt', '0', 0, '1', 0, 17, 35),
(25, 't-shirt', 'red t-shirt', '25', '2024-03-25', 'egypt', '0', 1, '2', 0, 13, 33),
(26, 'chair', 'wooden chair', '344', '2024-03-25', 'egypt', '0', 0, '2', 0, 18, 35),
(27, 'belezer', 'classic belezer', '800', '2024-03-25', 'Egypt', '0', 0, '2', 0, 13, 39),
(28, 'shoes', 'italic shoose', '120', '2024-03-25', 'italy', '0', 1, '2', 0, 13, 35),
(29, 'sock', 'long sock', '4', '2024-03-25', 'Egypt', '0', 0, '2', 0, 13, 35),
(30, 'dress', 'medium blue dress', '43', '2024-03-25', 'Egypt', '0', 1, '2', 0, 13, 35),
(32, 'pens', 'blue pens', '1', '2024-03-26', 'Egypt', '0', 0, '2', 0, 18, 39);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(100) NOT NULL,
  `email` varchar(50) NOT NULL,
  `fullname` varchar(40) NOT NULL,
  `groupid` int(11) NOT NULL,
  `truststatus` int(11) NOT NULL,
  `regstatus` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `password`, `email`, `fullname`, `groupid`, `truststatus`, `regstatus`) VALUES
(23, 'ali', '8cb2237d0679ca88db6464eac60da96345513964', 'ali@gmail.com', 'ali ashraf', 0, 4, 1),
(33, 'ahmed', '8cb2237d0679ca88db6464eac60da96345513964', 'a@gmail.com', 'ahmedddd', 0, 5, 0),
(35, 'yousef', '8cb2237d0679ca88db6464eac60da96345513964', 'yousefmostafanawar@gmail.com', '', 0, 0, 0),
(39, 'tarek', '8cb2237d0679ca88db6464eac60da96345513964', 'tarek@gmail.com', '', 0, 0, 0),
(40, 'islam', '8cb2237d0679ca88db6464eac60da96345513964', 'islam@gmail.com', '', 0, 0, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`c_id`),
  ADD KEY `items_comments_fk` (`item_id`),
  ADD KEY `users_comments_fk` (`user_id`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`item_id`),
  ADD KEY `categories_items_fk` (`cat_id`),
  ADD KEY `users_items_fk` (`member_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `c_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `items_comments_fk` FOREIGN KEY (`item_id`) REFERENCES `items` (`item_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `users_comments_fk` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `items`
--
ALTER TABLE `items`
  ADD CONSTRAINT `categories_items_fk` FOREIGN KEY (`cat_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `users_items_fk` FOREIGN KEY (`member_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
