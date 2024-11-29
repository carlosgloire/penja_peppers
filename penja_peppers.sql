-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 29, 2024 at 09:22 AM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `penja_peppers`
--

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `comment` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `post_id`, `user_id`, `comment`, `created_at`) VALUES
(1, 2, 1, 'I really like this fruit', '2024-11-28 16:24:21'),
(2, 2, 1, 'yes it\'s good', '2024-11-28 16:25:27'),
(3, 2, 1, 'good', '2024-11-28 16:27:12'),
(4, 2, 1, 'Amazing', '2024-11-28 16:33:52');

-- --------------------------------------------------------

--
-- Table structure for table `likes`
--

CREATE TABLE `likes` (
  `id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `user_ip` varchar(45) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `likes`
--

INSERT INTO `likes` (`id`, `post_id`, `user_ip`, `created_at`) VALUES
(5, 2, '::1', '2024-11-28 17:44:46'),
(6, 1, '::1', '2024-11-28 17:44:48');

-- --------------------------------------------------------

--
-- Table structure for table `mailnewsletter`
--

CREATE TABLE `mailnewsletter` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `mailnewsletter`
--

INSERT INTO `mailnewsletter` (`id`, `email`) VALUES
(1, 'ndayisabagloire96@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `order_date` datetime NOT NULL DEFAULT current_timestamp(),
  `total_amount` decimal(10,2) NOT NULL,
  `status` enum('pending','completed','cancelled') NOT NULL DEFAULT 'pending',
  `delivered` varchar(20) DEFAULT 'Not Delivered'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `user_id`, `order_date`, `total_amount`, `status`, `delivered`) VALUES
(8, 1, '2024-11-27 17:40:57', 20.00, 'completed', 'Not Delivered'),
(9, 1, '2024-11-27 18:42:18', 30.00, 'completed', 'Not Delivered'),
(10, 1, '2024-11-27 18:52:25', 10.00, 'completed', 'Not Delivered'),
(11, 1, '2024-11-28 08:11:09', 6.00, 'completed', 'Not Delivered'),
(12, 1, '2024-11-28 08:25:57', 11.00, 'pending', 'Not Delivered'),
(13, 1, '2024-11-28 11:28:31', 2.00, 'completed', 'Not Delivered'),
(14, 2, '2024-11-28 16:10:43', 14.00, 'pending', 'Not Delivered');

-- --------------------------------------------------------

--
-- Table structure for table `order_item`
--

CREATE TABLE `order_item` (
  `order_item_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `total_price` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `order_item`
--

INSERT INTO `order_item` (`order_item_id`, `order_id`, `product_id`, `quantity`, `total_price`) VALUES
(13, 8, 14, 1, 10),
(14, 8, 7, 1, 10),
(15, 9, 11, 1, 20),
(16, 9, 9, 1, 10),
(17, 10, 16, 5, 10),
(18, 11, 16, 3, 6),
(19, 12, 10, 2, 4),
(20, 12, 9, 1, 5),
(21, 12, 7, 1, 2),
(22, 13, 7, 1, 2),
(23, 14, 10, 3, 6),
(24, 14, 3, 2, 8);

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `payment_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `payment_date` datetime NOT NULL,
  `payment_method` varchar(100) NOT NULL,
  `status` varchar(20) NOT NULL,
  `amount` float NOT NULL,
  `address` text NOT NULL,
  `whatsapp_number` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `payment`
--

INSERT INTO `payment` (`payment_id`, `order_id`, `payment_date`, `payment_method`, `status`, `amount`, `address`, `whatsapp_number`) VALUES
(1, 8, '2024-11-27 18:32:01', 'Flutterwave', 'completed', 27600, '', ''),
(2, 9, '2024-11-27 18:44:47', 'Flutterwave', 'completed', 41400, 'Kigali,Rwanda,gisozi KN 537st', '+250791460743'),
(3, 10, '2024-11-27 18:53:11', 'Flutterwave', 'completed', 13800, '', ''),
(4, 11, '2024-11-28 08:32:39', 'Flutterwave', 'completed', 8280, '', ''),
(5, 13, '2024-11-28 11:30:12', 'Flutterwave', 'completed', 2760, 'Kigali,Rwanda,gisozi KN 537st', '+243970859070');

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `post_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `content` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `post` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`post_id`, `title`, `image`, `content`, `created_at`, `post`) VALUES
(1, 'What you need to know about tomatoes', '9.png', 'Lorem ipsum, dolor sit amet consectetur adipisicing elit. Nulla non ullam voluptates quis unde natus repudiandae sequi aliquid consectetur accusamus, rerum voluptatum aspernatur saepe, architecto reiciendis quos libero ea tempora!\r\n', '2024-11-28 11:57:20', 'l-039-histoire-de-penja-peppers'),
(2, 'The great importance of oranges', '4.png', 'Lorem ipsum, dolor sit amet consectetur adipisicing elit. Nulla non ullam voluptates quis unde natus repudiandae sequi aliquid consectetur accusamus, rerum voluptatum aspernatur saepe, architecto reiciendis quos libero ea tempora!', '2024-11-28 13:53:50', 'la-grande-importance-des-orange');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `product_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `category` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `stock` int(11) NOT NULL CHECK (`stock` >= 0),
  `price` float NOT NULL,
  `photo` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `product` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `name`, `category`, `description`, `stock`, `price`, `photo`, `created_at`, `updated_at`, `product`) VALUES
(3, 'Ok Ginger', 'Other', 'Lorem, ipsum dolor sit amet consectetur adipisicing elit. Nobis, doloremque? Alias quia dolores architecto temporibus quae quaerat hic rerum, est magni repellendus quasi quisquam. Aspernatur excepturi accusamus commodi cupiditate repudiandae..?', 150, 4, '10.png', '2024-11-25 16:34:37', '2024-11-28 06:24:34', 'ok-ginger'),
(6, 'Black peppers', 'Peppers', 'Lorem, ipsum dolor sit amet consectetur adipisicing elit. Nobis, doloremque? Alias quia dolores architecto temporibus quae quaerat hic rerum, est magni repellendus quasi quisquam. Aspernatur excepturi accusamus commodi cupiditate repudiandae..?', 300, 200, '001.png', '2024-11-25 20:48:25', '2024-11-26 06:49:26', 'black-peppers'),
(7, 'Kola', 'Other', 'Lorem, ipsum dolor sit amet consectetur adipisicing elit. Nobis, doloremque? Alias quia dolores architecto temporibus quae quaerat hic rerum, est magni repellendus quasi quisquam. Aspernatur excepturi accusamus commodi cupiditate repudiandae..?', 48, 2, '11.png', '2024-11-25 20:49:33', '2024-11-28 09:30:12', 'kola'),
(8, 'Mixed Peppers', 'Peppers', 'Lorem, ipsum dolor sit amet consectetur adipisicing elit. Nobis, doloremque? Alias quia dolores architecto temporibus quae quaerat hic rerum, est magni repellendus quasi quisquam. Aspernatur excepturi accusamus commodi cupiditate repudiandae..?', 300, 10, 'cool1.jpeg', '2024-11-25 20:50:14', '2024-11-26 14:26:11', 'mixed-peppers'),
(9, 'Matinal chocolate', 'Chocolates', 'Lorem, ipsum dolor sit amet consectetur adipisicing elit. Nobis, doloremque? Alias quia dolores architecto temporibus quae quaerat hic rerum, est magni repellendus quasi quisquam. Aspernatur excepturi accusamus commodi cupiditate repudiandae..?', 4, 10, '8.1.png', '2024-11-25 20:51:03', '2024-11-29 08:18:08', 'matinal-chocolate'),
(10, 'Mambo Chocolate', 'Chocolates', 'Lorem, ipsum dolor sit amet consectetur adipisicing elit. Nobis, doloremque? Alias quia dolores architecto temporibus quae quaerat hic rerum, est magni repellendus quasi quisquam. Aspernatur excepturi accusamus commodi cupiditate repudiandae..?', 200, 2, '2.jpg', '2024-11-25 20:51:50', '2024-11-28 06:24:12', 'mambo-chocolate'),
(11, 'Tartina', 'Chocolates', 'Lorem, ipsum dolor sit amet consectetur adipisicing elit. Nobis, doloremque? Alias quia dolores architecto temporibus quae quaerat hic rerum, est magni repellendus quasi quisquam. Aspernatur excepturi accusamus commodi cupiditate repudiandae..?', 199, 20, '5.1.jpg', '2024-11-25 20:52:26', '2024-11-27 16:44:48', 'tartina'),
(12, 'Black Cigar', 'Cigars', 'Lorem, ipsum dolor sit amet consectetur adipisicing elit. Nobis, doloremque? Alias quia dolores architecto temporibus quae quaerat hic rerum, est magni repellendus quasi quisquam. Aspernatur excepturi accusamus commodi cupiditate repudiandae..?', 200, 10, 'black.jpg', '2024-11-25 20:52:51', '2024-11-25 20:52:51', 'black-cigar'),
(14, 'Blue Cigar', 'Cigars', 'Lorem, ipsum dolor sit amet consectetur adipisicing elit. Nobis, doloremque? Alias quia dolores architecto temporibus quae quaerat hic rerum, est magni repellendus quasi quisquam. Aspernatur excepturi accusamus commodi cupiditate repudiandae..?', 499, 10, 'blue.jpg', '2024-11-26 06:07:38', '2024-11-27 16:32:02', 'blue-cigar'),
(16, 'Mambo', 'Chocolates', 'Lorem ipsum dolor sit amet consectetur, adipisicing elit. Neque voluptatem amet fugiat tenetur laudantium consectetur laboriosam, molestiae quaerat consequuntur sit est iure enim ducimus ad id voluptates. Quibusdam, vero in!\r\n', 42, 2, '3.png', '2024-11-26 12:52:53', '2024-11-28 06:32:42', 'mambo'),
(17, 'Matinal', 'Chocolates', '   Lorem ipsum dolor, sit amet consectetur adipisicing elit. Atque excepturi accusamus eveniet corporis. Temporibus ducimus minus, et praesentium rem eveniet! Nulla beatae rerum obcaecati, temporibus cupiditate reprehenderit necessitatibus qui. Quam!\r\n', 50, 10, '4.1.jpg', '2024-11-26 13:02:10', '2024-11-26 13:02:10', 'matinal'),
(18, 'Mambo Dark chocolate', 'Chocolates', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Asperiores natus enim, repellat temporibus modi quisquam similique blanditiis perferendis recusandae reprehenderit. Culpa suscipit necessitatibus provident corporis, rem omnis consequuntur nostrum illo!', 200, 3, '6.jpg', '2024-11-26 15:21:30', '2024-11-28 06:23:50', 'mambo-dark-chocolate');

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `rating` tinyint(4) NOT NULL CHECK (`rating` between 1 and 5),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`id`, `product_id`, `user_id`, `rating`, `created_at`) VALUES
(1, 10, 2, 5, '2024-11-26 10:53:36'),
(2, 10, 1, 4, '2024-11-26 11:07:38'),
(4, 6, 1, 5, '2024-11-26 14:27:13'),
(5, 6, 2, 4, '2024-11-26 14:36:18'),
(6, 7, 2, 5, '2024-11-26 15:01:56'),
(7, 7, 1, 4, '2024-11-26 15:03:49'),
(8, 12, 2, 1, '2024-11-28 14:21:57');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `location` varchar(255) NOT NULL,
  `password` varchar(64) NOT NULL,
  `photo` text NOT NULL,
  `role` varchar(10) DEFAULT NULL,
  `reset_token_hash` varchar(64) NOT NULL,
  `reset_token_expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `firstname`, `lastname`, `email`, `phone`, `location`, `password`, `photo`, `role`, `reset_token_hash`, `reset_token_expires_at`) VALUES
(1, 'NDAYISABA', 'Gloire', 'ndayisabarenzaho@gmail.com', '+250791460743', 'Kigali, Rwanda,576St', '$2y$10$5ViqLE9VXRZOOsninVYJveWOynxh61Cf2D1zPlK1Hl4hiMbT97G0a', 'Gloire.png', 'admin', '', NULL),
(2, 'GLOIRE', 'Jean-Carlos', 'ndayisabagloire96@gmail.com', '+243970859070', 'Kigali,Rwanda , KN 372St', '$2y$10$hGiSUHMl4XbpOoUIDoz87OpDoqM29jV2pMMobtewkNTL5s7eUMJG2', 'IMG-20221220-WA0025.jpg', NULL, '', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `post_id` (`post_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `likes`
--
ALTER TABLE `likes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `post_id` (`post_id`,`user_ip`);

--
-- Indexes for table `mailnewsletter`
--
ALTER TABLE `mailnewsletter`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `order_item`
--
ALTER TABLE `order_item`
  ADD PRIMARY KEY (`order_item_id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`payment_id`),
  ADD KEY `order_id` (`order_id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`post_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `likes`
--
ALTER TABLE `likes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `mailnewsletter`
--
ALTER TABLE `mailnewsletter`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `order_item`
--
ALTER TABLE `order_item`
  MODIFY `order_item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `post_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `posts` (`post_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `likes`
--
ALTER TABLE `likes`
  ADD CONSTRAINT `likes_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `posts` (`post_id`) ON DELETE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `order_item`
--
ALTER TABLE `order_item`
  ADD CONSTRAINT `order_item_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`),
  ADD CONSTRAINT `order_item_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`);

--
-- Constraints for table `payment`
--
ALTER TABLE `payment`
  ADD CONSTRAINT `payment_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`);

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reviews_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
