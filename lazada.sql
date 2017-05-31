-- phpMyAdmin SQL Dump
-- version 4.6.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: May 31, 2017 at 12:25 PM
-- Server version: 5.7.18
-- PHP Version: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `lazada`
--

-- --------------------------------------------------------

--
-- Table structure for table `address`
--

CREATE TABLE `address` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `address` varchar(255) NOT NULL,
  `postal_code` int(11) NOT NULL,
  `is_default` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `address`
--

INSERT INTO `address` (`id`, `user_id`, `address`, `postal_code`, `is_default`) VALUES
(1, 1, 'New York', 10000, 1),
(2, 1, 'Houston', 77001, 0);

-- --------------------------------------------------------

--
-- Table structure for table `carts`
--

CREATE TABLE `carts` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `cart_id` varchar(100) NOT NULL,
  `item_id` int(11) NOT NULL,
  `quantity` tinyint(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `carts`
--

INSERT INTO `carts` (`id`, `user_id`, `cart_id`, `item_id`, `quantity`) VALUES
(1, 1, 'cart1234', 1, 0),
(2, 1, 'cart1234', 2, 0),
(3, 1, 'cart1234', 3, 0),
(4, 1, 'cart1234', 4, 0),
(6, 1, 'cart1234', 5, 0),
(7, 1, 'cart1234', 6, 0),
(8, 1, 'cart1234', 7, 0),
(9, 1, 'cart1234', 8, 0);

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `id` int(11) NOT NULL,
  `item_name` varchar(255) NOT NULL,
  `weight` decimal(10,2) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`id`, `item_name`, `weight`, `price`, `image`) VALUES
(1, 'SteelSeries Mouse', '0.50', '10.00', 'http://vn-live-03.slatic.net/p/2/chuot-steelseries-rival-300-hyperbeast-2436-3125582-918d31bdb27602d74795655dd7a4af9a-webp-catalog_233.jpg'),
(2, 'Corsair Platinum K95 Keyboard', '1.75', '15.00', 'http://vn-live-01.slatic.net/p/2/ban-phim-co-corsair-k95-platinum-rgb-gunmental-mx-speedden-4368-2036575-c63f2f83fb0afb382ead795023fa8339-webp-catalog_233.jpg'),
(3, 'ASUS X99 Motherboards', '1.25', '23.00', 'http://vn-live-03.slatic.net/p/2/mainboard-asus-maximus-ix-hero-6410-0624595-ef5ca89134ee45d23b913bc3c11dc469-webp-catalog_233.jpg'),
(4, 'Seasonic 1000W Power Supply', '3.55', '5.35', 'http://vn-live-02.slatic.net/p/2/fsp-power-supply-ax-series-400atx-model-ax350-51yln-active-pfc-1224-4569506-892c0e528037a05a6188c2db6b288a7c-webp-catalog_233.jpg'),
(5, 'EVGA 1080ti VGA', '2.25', '7.00', 'http://vn-live-03.slatic.net/p/2/card-man-hinh-vga-colorful-geforce-gtx-1080-ti-11gb-igame-vulcan-ad-0645-0803906-76910307555c562093a2cbcac072dd22-webp-catalog_233.jpg'),
(6, 'Intel Core i7 6950X CPU', '0.25', '3.00', 'http://vn-live-01.slatic.net/p/2/cpu-intel-core-i7-7700k-42-ghz-8mb-hd-630-series-graphics-socket-1151-kabylake-1671-2861975-9b678871a2146b03fea39c94e1818dd5-webp-catalog_233.jpg'),
(7, 'Corsair DDR4 Dominator Platinum 32GB RAM', '0.75', '4.25', 'http://vn-live-01.slatic.net/p/2/ram-4-corsair-16gb2666-4x4gb-cmd16gx4m4a2666c16-dominatorplatinum-den-1231-8504131-4ee3a7fa3876c83067bbc635c17a7f84-webp-catalog_233.jpg'),
(8, 'Samsung NVME 960 500GB SSD', '0.40', '12.75', 'http://vn-live-02.slatic.net/p/2/o-cung-ssd-samsung-960-evo-pcie-nvme-m2-250gb-0507-0561625-cf9ff950ec1d6f5ea529cfb96836a8f4-webp-catalog_233.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `shipping`
--

CREATE TABLE `shipping` (
  `id` int(11) NOT NULL,
  `supplier_id` int(11) NOT NULL,
  `source` int(11) NOT NULL,
  `delivered_to` int(11) NOT NULL,
  `fee` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `shipping`
--

INSERT INTO `shipping` (`id`, `supplier_id`, `source`, `delivered_to`, `fee`) VALUES
(1, 1, 700000, 10000, '1.00'),
(2, 2, 700423, 10000, '2.00'),
(3, 3, 700540, 10000, '5.00'),
(4, 4, 700346, 10000, '1.00'),
(5, 1, 700000, 77001, '2.00'),
(6, 2, 700423, 77001, '6.00'),
(7, 3, 700540, 77001, '12.00'),
(8, 4, 700346, 77001, '10.00');

-- --------------------------------------------------------

--
-- Table structure for table `supplier`
--

CREATE TABLE `supplier` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `supplier`
--

INSERT INTO `supplier` (`id`, `name`) VALUES
(1, 'Arakuhg'),
(2, 'Manafuhe'),
(3, 'Koehtage'),
(4, 'Hokehabg');

-- --------------------------------------------------------

--
-- Table structure for table `supplier_items`
--

CREATE TABLE `supplier_items` (
  `id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `supplier_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `supplier_items`
--

INSERT INTO `supplier_items` (`id`, `item_id`, `supplier_id`) VALUES
(1, 1, 1),
(2, 1, 2),
(3, 2, 3),
(4, 2, 4),
(5, 3, 4),
(6, 3, 1),
(7, 4, 1),
(8, 4, 3),
(9, 5, 2),
(10, 5, 4),
(11, 6, 1),
(12, 6, 2),
(13, 7, 1),
(14, 7, 2),
(15, 7, 3),
(16, 8, 2),
(17, 8, 3),
(18, 8, 4);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(16) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`) VALUES
(1, 'admin', '03024dfbc43c9d3c1dca288d87d6717b');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `address`
--
ALTER TABLE `address`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `id_2` (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `carts`
--
ALTER TABLE `carts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `cart_id` (`cart_id`),
  ADD KEY `item_id` (`item_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `shipping`
--
ALTER TABLE `shipping`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `supplier_id` (`supplier_id`),
  ADD KEY `source` (`source`);

--
-- Indexes for table `supplier`
--
ALTER TABLE `supplier`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `supplier_items`
--
ALTER TABLE `supplier_items`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `item_id` (`item_id`),
  ADD KEY `supplier_id` (`supplier_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_2` (`id`),
  ADD KEY `id` (`id`),
  ADD KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `address`
--
ALTER TABLE `address`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `carts`
--
ALTER TABLE `carts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `shipping`
--
ALTER TABLE `shipping`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `supplier`
--
ALTER TABLE `supplier`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `supplier_items`
--
ALTER TABLE `supplier_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `address`
--
ALTER TABLE `address`
  ADD CONSTRAINT `address_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `carts`
--
ALTER TABLE `carts`
  ADD CONSTRAINT `carts_ibfk_1` FOREIGN KEY (`item_id`) REFERENCES `items` (`id`),
  ADD CONSTRAINT `carts_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `shipping`
--
ALTER TABLE `shipping`
  ADD CONSTRAINT `shipping_ibfk_1` FOREIGN KEY (`supplier_id`) REFERENCES `supplier` (`id`);

--
-- Constraints for table `supplier_items`
--
ALTER TABLE `supplier_items`
  ADD CONSTRAINT `supplier_items_ibfk_1` FOREIGN KEY (`item_id`) REFERENCES `items` (`id`),
  ADD CONSTRAINT `supplier_items_ibfk_2` FOREIGN KEY (`supplier_id`) REFERENCES `supplier` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
