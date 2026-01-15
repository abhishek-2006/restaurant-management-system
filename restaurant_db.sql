-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jan 15, 2026 at 12:34 PM
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
-- Database: `restaurant_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `favorites`
--

CREATE TABLE `favorites` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `menu_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `menu`
--

CREATE TABLE `menu` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `category` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `menu`
--

INSERT INTO `menu` (`id`, `name`, `description`, `price`, `category`, `created_at`) VALUES
(1, 'Paneer Butter Masala', 'Soft paneer cubes cooked in creamy tomato gravy', 280.00, 'Main Curries', '2026-01-15 09:30:45'),
(2, 'Veg Biryani', 'Aromatic basmati rice cooked with mixed vegetables and spices', 250.00, 'Rice & Sides', '2026-01-15 09:30:45'),
(3, 'Dal Tadka', 'Yellow lentils tempered with garlic and ghee', 180.00, 'Main Curries', '2026-01-15 09:30:45'),
(4, 'Veggie Burger', 'Grilled vegetable patty with lettuce, tomato, and cheese in a bun', 220.00, 'Fast Food', '2026-01-15 09:30:45'),
(5, 'Masala Dosa', 'Crispy South Indian crepe stuffed with spiced mashed potatoes', 160.00, 'Starters & Street Food', '2026-01-15 09:30:45'),
(6, 'Palak Paneer', 'Cottage cheese cooked with spinach puree', 260.00, 'Main Curries', '2026-01-15 09:30:45'),
(7, 'Chole Bhature', 'Spicy chickpeas served with fried bread', 220.00, 'Starters & Street Food', '2026-01-15 09:30:45'),
(8, 'Veg Manchurian', 'Indo-Chinese dish with fried vegetable balls in spicy sauce', 240.00, 'Starters & Street Food', '2026-01-15 09:30:45'),
(9, 'Paneer Tikka', 'Grilled paneer cubes marinated in Indian spices', 270.00, 'Starters & Street Food', '2026-01-15 09:30:45'),
(10, 'Gulab Jamun', 'Sweet milk dumplings soaked in sugar syrup', 90.00, 'Desserts', '2026-01-15 09:30:45'),
(11, 'Margherita Pizza', 'Classic pizza topped with tomato sauce, mozzarella, and basil', 300.00, 'International Dishes', '2026-01-15 09:30:45'),
(12, 'Pasta Alfredo', 'Creamy white sauce pasta with cheese and herbs', 280.00, 'International Dishes', '2026-01-15 09:30:45'),
(13, 'Pasta Arrabbiata', 'Penne pasta tossed in spicy tomato sauce', 260.00, 'International Dishes', '2026-01-15 09:30:45'),
(14, 'Veg Lasagna', 'Layered pasta baked with vegetables, cheese, and tomato sauce', 320.00, 'International Dishes', '2026-01-15 09:30:45'),
(15, 'Bruschetta', 'Grilled bread with tomato, garlic, olive oil, and basil', 180.00, 'Soups & Salads', '2026-01-15 09:30:45'),
(16, 'Minestrone Soup', 'Hearty Italian vegetable soup with beans and pasta', 150.00, 'Soups & Salads', '2026-01-15 09:30:45'),
(17, 'Risotto Primavera', 'Creamy Italian rice dish with mixed vegetables', 290.00, 'International Dishes', '2026-01-15 09:30:45'),
(18, 'Garlic Bread', 'Toasted bread with garlic butter and herbs', 120.00, 'Italian', '2026-01-15 09:30:45'),
(19, 'Tiramisu (Eggless)', 'Classic Italian dessert made with mascarpone and coffee', 200.00, 'Desserts', '2026-01-15 09:30:45'),
(20, 'Caesar Salad', 'Crisp romaine lettuce with Caesar dressing, croutons, and parmesan', 200.00, 'Soups & Salads', '2026-01-15 09:30:45'),
(21, 'Mushroom Soup', 'Creamy soup made with fresh mushrooms and herbs', 160.00, 'Soups & Salads', '2026-01-15 09:30:45'),
(22, 'Caprese Salad', 'Fresh mozzarella, tomatoes, and basil drizzled with balsamic glaze', 210.00, 'Soups & Salads', '2026-01-15 09:30:45'),
(23, 'Fettuccine Alfredo', 'Fettuccine pasta in a rich and creamy Alfredo sauce', 300.00, 'International Dishes', '2026-01-15 09:30:45'),
(24, 'Vegetable Stir Fry', 'Mixed vegetables sautéed in a savory sauce', 250.00, 'International Dishes', '2026-01-15 09:30:45'),
(25, 'Spring Rolls', 'Crispy rolls filled with mixed vegetables and served with dipping sauce', 180.00, 'Starters & Street Food', '2026-01-15 09:30:45'),
(26, 'Hakka Noodles', 'Stir-fried noodles tossed with veggies and soy-based seasoning', 220.00, 'Starters & Street Food', '2026-01-15 09:30:45'),
(27, 'Thai Green Curry', 'Coconut-based curry cooked with vegetables and aromatic herbs', 320.00, 'International Dishes', '2026-01-15 09:30:45'),
(28, 'Sushi Veg Roll', 'Japanese-style rice rolls filled with fresh vegetables', 350.00, 'International Dishes', '2026-01-15 09:30:45'),
(29, 'Mexican Burrito', 'Tortilla stuffed with beans, rice, veggies, and cheese', 280.00, 'International Dishes', '2026-01-15 09:30:45'),
(30, 'Nachos with Cheese Dip', 'Crispy nachos served with melted cheese and salsa', 200.00, 'Fast Food', '2026-01-15 09:30:45'),
(31, 'Falafel Wrap', 'Middle Eastern wrap filled with crispy falafel and tahini sauce', 210.00, 'International Dishes', '2026-01-15 09:30:45'),
(32, 'Hummus Platter', 'Creamy chickpea spread served with pita bread and veggies', 240.00, 'International Dishes', '2026-01-15 09:30:45'),
(33, 'Paneer Shawarma', 'Indian-style shawarma stuffed with marinated paneer and veggies', 260.00, 'International Dishes', '2026-01-15 09:30:45'),
(34, 'Ramen (Veg)', 'Japanese noodle soup with veggies and flavorful broth', 300.00, 'International Dishes', '2026-01-15 09:30:45'),
(35, 'Quesadilla', 'Grilled tortilla stuffed with cheese and sautéed vegetables', 230.00, 'International Dishes', '2026-01-15 09:30:45'),
(36, 'Chocolate Brownie', 'Rich chocolate brownie served warm', 150.00, 'Desserts', '2026-01-15 09:30:45'),
(37, 'Blueberry Cheesecake', 'Creamy cheesecake topped with blueberry compote', 250.00, 'Desserts', '2026-01-15 09:30:45'),
(38, 'Cold Coffee Frappe', 'Blended iced coffee with cream and sugar', 140.00, 'Drinks', '2026-01-15 09:30:45'),
(39, 'Virgin Mojito', 'Refreshing drink with mint, lime, and soda', 120.00, 'Drinks', '2026-01-15 09:30:45'),
(40, 'Tom Yum Soup', 'Hot and sour Thai soup with herbs and veggies', 180.00, 'Soups & Salads', '2026-01-15 09:30:45'),
(41, 'Veg Kebab Platter', 'Assortment of grilled vegetarian kebabs with chutney', 300.00, 'Starters & Street Food', '2026-01-15 09:30:45'),
(42, 'Peri Peri Fries', 'Crispy fries tossed in peri peri seasoning', 130.00, 'Starters & Street Food', '2026-01-15 09:30:45'),
(43, 'BBQ Paneer Pizza', 'Pizza topped with smoky BBQ paneer and veggies', 330.00, 'Italian', '2026-01-15 09:30:45'),
(44, 'Rasmalai', 'Soft paneer discs soaked in sweetened saffron milk', 160.00, 'Desserts', '2026-01-15 09:30:45'),
(45, 'Malai Kofta', 'Creamy curry with soft paneer-potato dumplings', 260.00, 'Main Curries', '2026-01-15 09:30:45'),
(46, 'Pav Bhaji', 'Smooth mashed vegetable curry served with buttered pav', 180.00, 'Fast Food', '2026-01-15 09:30:45'),
(47, 'Aloo Paratha', 'Stuffed flatbread with spiced potato filling', 140.00, 'Rice & Sides', '2026-01-15 09:30:45'),
(48, 'Veg Spring Roll', 'Crispy rolls filled with mixed vegetables', 170.00, 'Starters & Street Food', '2026-01-15 09:30:45'),
(49, 'Lemonade', 'Freshly squeezed lemon juice with sugar and water', 100.00, 'Drinks', '2026-01-15 09:30:45'),
(50, 'Mango Lassi', 'Sweet mango yogurt drink with a hint of cardamom', 130.00, 'Drinks', '2026-01-15 09:30:45');

-- --------------------------------------------------------

--
-- Table structure for table `reservations`
--

CREATE TABLE `reservations` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `guests` int(11) NOT NULL,
  `reservation_date` date NOT NULL,
  `reservation_time` varchar(5) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `status` enum('pending','ongoing','completed','cancelled') DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reservations`
--

INSERT INTO `reservations` (`id`, `name`, `email`, `phone`, `guests`, `reservation_date`, `reservation_time`, `user_id`, `created_at`, `status`) VALUES
(5, 'Abhishek', 'test@gmail.com', '1234567890', 2, '2026-01-15', '16:30', 1, '2026-01-15 11:05:53', 'ongoing');

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int(11) NOT NULL,
  `total_tables` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `total_tables`, `created_at`) VALUES
(1, 20, '2026-01-15 10:31:58');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('guest','admin','banned') DEFAULT 'guest',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `full_name`, `email`, `phone`, `password`, `role`, `created_at`) VALUES
(1, 'Abhishek', 'test@gmail.com', '1234567890', '$2y$10$Hg6q8tFQdeUIIU2OcaH.quk6DXzJPJnv9vzJ8y34s8Ez.WyaWgpIe', 'guest', '2026-01-13 10:41:34'),
(2, 'System Admin', 'admin@greenleaf.com', '9876543210', '$2y$10$BArOzIHGHvZiVIseJ/lokuWLkG5VJ0Yjnw0v/xqgx6X7xhn.5vUjS', 'admin', '2026-01-14 03:25:45'),
(3, 'Test', 'test1@gmail.com', '0123456789', '$2y$10$Hg6q8tFQdeUIIU2OcaH.quk6DXzJPJnv9vzJ8y34s8Ez.WyaWgpIe', 'banned', '2026-01-15 11:23:22');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `favorites`
--
ALTER TABLE `favorites`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `menu_id` (`menu_id`);

--
-- Indexes for table `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_food_in_category` (`name`,`category`);

--
-- Indexes for table `reservations`
--
ALTER TABLE `reservations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`,`phone`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `phone` (`phone`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `favorites`
--
ALTER TABLE `favorites`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `menu`
--
ALTER TABLE `menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `reservations`
--
ALTER TABLE `reservations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `favorites`
--
ALTER TABLE `favorites`
  ADD CONSTRAINT `favorites_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `favorites_ibfk_2` FOREIGN KEY (`menu_id`) REFERENCES `menu` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `reservations`
--
ALTER TABLE `reservations`
  ADD CONSTRAINT `reservations_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE SET NULL,
  ADD CONSTRAINT `reservations_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
