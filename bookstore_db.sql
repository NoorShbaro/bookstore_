-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 29, 2024 at 09:03 PM
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
-- Database: `bookstore_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` varchar(20) NOT NULL,
  `user_id` varchar(20) NOT NULL,
  `product_id` varchar(20) NOT NULL,
  `price` int(50) NOT NULL,
  `qty` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `message`
--

CREATE TABLE `message` (
  `id` varchar(20) NOT NULL,
  `user_id` varchar(20) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `subject` varchar(100) NOT NULL,
  `message` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` varchar(20) NOT NULL,
  `user_id` varchar(20) NOT NULL,
  `seller_id` varchar(20) NOT NULL,
  `name` varchar(50) NOT NULL,
  `number` varchar(10) NOT NULL,
  `email` varchar(50) NOT NULL,
  `address` varchar(200) NOT NULL,
  `address_type` varchar(10) NOT NULL,
  `method` varchar(50) NOT NULL,
  `product_id` varchar(20) NOT NULL,
  `price` int(10) NOT NULL,
  `qty` int(2) NOT NULL,
  `date` date NOT NULL DEFAULT current_timestamp(),
  `status` varchar(50) NOT NULL DEFAULT 'in progress',
  `payment_status` varchar(100) NOT NULL DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` varchar(20) NOT NULL,
  `seller_id` varchar(20) NOT NULL,
  `name` varchar(50) NOT NULL,
  `price` int(10) NOT NULL,
  `image` varchar(100) NOT NULL,
  `stock` int(100) NOT NULL,
  `product_detail` varchar(1000) NOT NULL,
  `status` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `seller_id`, `name`, `price`, `image`, `stock`, `product_detail`, `status`) VALUES
('X5KcNujzzEDcCaEkKgzS', 'tgaOV9E2aQjbbNXkoHPY', 'technical', 15, 'technical.jpg', 20, 'Descriptive technical writing uses a combination of visuals and text to both “show” and “tell” the reader about the information being conveyed. Like more creative descriptions, technical descriptions sometimes draw on the “five senses” and metaphorical comparisons (analogies) to allow the reader to fully conceptualize what is being described. More often, however, they rely on concrete, measurable descriptors. Technical descriptions can take many forms, depending on purpose and audience. Descriptions can range from a brief sentence, to a paragraph, a whole section of a report, or an entire manual. Poorly written technical descriptions can cause confusion, waste time, and even result in catastrophe! Technical product descriptions are often legally required to ensure safety and compliance. Attention to detail is critical.', 'active'),
('ITPgDbvinxiDVIOxUGu6', 'tgaOV9E2aQjbbNXkoHPY', 'travel', 10, 'travel.jpg', 10, 'A guide book or travel guide is &#34;a book of information about a place designed for the use of visitors or tourists&#34;.[1] It will usually include information about sights, accommodation, restaurants, transportation, and activities. Maps of varying detail and historical and cultural information are often included. Different kinds of guide books exist, focusing on different aspects of travel, from adventure travel to relaxation, or aimed at travelers with different incomes, or focusing on sexual orientation or types of diet. ', 'active'),
('Gz9W9QNI7mRlNenlGffq', 'tgaOV9E2aQjbbNXkoHPY', 'technology', 20, 'technology.jpg', 10, '&#13;&#10;A new-generation reference book about the cool technology of our world, for kids used to surfing and swiping.&#13;&#10;&#13;&#10;Our world is full of funky gadgets and technological gizmos. Within the next hour, you will probably use a computer, the internet, a hand-held game, or a cell phone. Technology is not only playing an ever-increasing role in our everyday lives, but also in the way we explore the world around us. Cool technology is useful, but what do we know about how it works? This book investigates the science behind technology, taking readers on a journey of discovery that they will never forget. It uncovers the smart tech of mobile phones, wi-fi, and GPS, as well as the inner workings of game consoles. It examines the world of movement--how cars, airplanes, and other vehicles run. It delves into nanotechnology, spy gadgets, cyborgs, building in space, and the eco house. Explore the pages of this book to discover how the coolest technology of today really works! ', 'active'),
('owV7QYxuSwj9VfysINVT', 'tgaOV9E2aQjbbNXkoHPY', 'food', 5, 'food.jpg', 30, ' Discover the origins, traditions, and use of the everyday foods served on our plates, from salt to sushi and rice to ravioli.&#13;&#10;&#13;&#10;A true celebration of food in all its forms, The Food Book follows the human quest for sustenance through the stories of individual ingredients. It examines our millennia-long relationship with nearly 200 foods - from nuts and seeds to noodles and meat - with the help of sumptuous illustrations and tales from all over the world.&#13;&#10;&#13;&#10;Food is the cornerstone of daily life, culture, and even religion. Staples like bread, beans, and cereal crops are part of our culinary history and are used in many different ways around the world.&#13;&#10;&#13;&#10;This fascinating reference covers:&#13;&#10;&#13;&#10;    All food groups, including nuts and grains, fruit and vegetables, meat and fish, herbs and spices.&#13;&#10;    Information on every aspect of food’s origin, history, and place in world cuisine.&#13;&#10;    Photographs which sho', 'active');

-- --------------------------------------------------------

--
-- Table structure for table `sellers`
--

CREATE TABLE `sellers` (
  `id` varchar(20) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `image` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sellers`
--

INSERT INTO `sellers` (`id`, `name`, `email`, `password`, `image`) VALUES
('tgaOV9E2aQjbbNXkoHPY', 'seller name', 'seller@gmail.com', 'admin', 'a5V4sCYNdrbSOYLANKAv.png'),
('Qw0OljXXSafOhStGzScF', 'name', 'name@gmail.com', 'name', 'E5m4iRzpuaK5ZP1e4XAZ.png');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` varchar(20) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `image` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `wishlist`
--

CREATE TABLE `wishlist` (
  `id` varchar(20) NOT NULL,
  `user_id` varchar(20) NOT NULL,
  `product_id` varchar(20) NOT NULL,
  `price` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
