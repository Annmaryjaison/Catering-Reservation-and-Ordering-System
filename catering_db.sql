-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 20, 2025 at 04:52 PM
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
-- Database: `catering_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `food_items`
--

CREATE TABLE `food_items` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `image_path` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `food_items`
--

INSERT INTO `food_items` (`id`, `name`, `description`, `price`, `image_path`) VALUES
(2, 'Chicken Biriyani', 'Chicken biriyani is a fragrant, layered rice dish made with marinated chicken, basmati rice, and a blend of aromatic spices, slow-cooked to perfection. Each bite bursts with flavor, making it a festive favorite across South Asia.\r\n', 450.00, 'chickenbiriyani.png'),
(3, 'Chapati ', 'Chapati is a soft, unleavened Indian flatbread made from whole wheat flour, water, and a touch of oil, cooked on a hot griddle. It’s a staple across South Asia, often served with curries, vegetables, or lentils for a wholesome meal.\r\n', 40.00, 'chapatti.png'),
(4, 'Vegetable Kurma', 'Vegetable Kurma is a flavorful South Indian curry made with mixed vegetables simmered in a spiced coconut and cashew-based gravy. It’s creamy, aromatic, and pairs perfectly with chapati, parotta, or rice.', 60.00, 'Vegkuruma.png'),
(5, 'Fried Rice', 'Vegetable Kurma is a flavorful South Indian curry made with mixed vegetables simmered in a spiced coconut and cashew-based gravy. It’s creamy, aromatic, and pairs perfectly with chapati, parotta, or rice.', 90.00, 'friedrice.png'),
(6, 'Chilli Chicken', 'Chilli Chicken is a bold Indo-Chinese dish featuring crispy fried chicken tossed in a spicy, tangy sauce with garlic, soy, and green chilies. Served dry or with gravy, it’s a fiery favorite that pairs perfectly with fried rice or noodles.', 90.00, 'Chillichicken.png'),
(7, 'Chocolate Ice Cream', 'Indulge in velvety chocolate ice cream, crafted with rich cocoa and creamy milk for a decadent treat. Perfectly smooth, irresistibly chocolaty—pure bliss in every scoop.', 20.00, 'chocolatecream.png'),
(8, 'Espresso Martini', 'A rich, creamy cocktail blending vodka, coffee liqueur, and fresh espresso—perfect for late-night celebrations. Garnished with coffee beans, it’s elegance in a glass.\r\n\r\n', 30.00, 'espresso.png');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `order_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` varchar(50) DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `total_price`, `order_date`, `status`) VALUES
(1, 2, 450.00, '2025-08-17 14:28:36', 'completed'),
(2, 2, 90.00, '2025-08-17 14:39:06', 'processing'),
(3, 2, 60.00, '2025-09-14 07:33:43', 'pending');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `food_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price_at_order` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `food_id`, `quantity`, `price_at_order`) VALUES
(1, 1, 2, 1, 450.00),
(2, 2, 5, 1, 90.00),
(3, 3, 4, 1, 60.00);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `is_admin` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`, `is_admin`) VALUES
(1, 'admin', '$2y$10$pnIgXs8GQ15tE6C03bspZOqtAxrjYw3hUcDBSRAZIBpwI1J/RiSGC', 'admin@gmail.com', 1),
(2, 'Anitha Nair', '$2y$10$bgwC762I/StUQCzzfP3G0uEgErPWLD8RDN.Kf0xwCAfCxUylLI4Im', 'anithanair@gmail.com', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `food_items`
--
ALTER TABLE `food_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `food_id` (`food_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `food_items`
--
ALTER TABLE `food_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`),
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`food_id`) REFERENCES `food_items` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
