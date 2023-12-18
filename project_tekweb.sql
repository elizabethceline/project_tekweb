-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 18, 2023 at 02:05 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `project_tekweb`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`) VALUES
(3, 'admin', '*4ACFE3202A5FF5CF467898FC58AAB1D615029441'),
(5, 'tes', '*C50DB90032812780F21E802F0D4438F8B4545024');

-- --------------------------------------------------------

--
-- Table structure for table `airport`
--

CREATE TABLE `airport` (
  `id` int(11) NOT NULL,
  `name` varchar(64) NOT NULL,
  `city` varchar(32) NOT NULL,
  `country` varchar(32) NOT NULL,
  `code` varchar(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `airport`
--

INSERT INTO `airport` (`id`, `name`, `city`, `country`, `code`) VALUES
(1, 'Bandara Juanda', 'Surabaya', 'Indonesia', 'SUB'),
(2, 'Bandara Soekarno-Hatta', 'Jakarta', 'Indonesia', 'CGK'),
(3, 'Singapore Changi International Airport', 'Singapore', 'Singapore', 'SIN'),
(4, 'Incheon International Airport', 'Seoul', 'Korea Selatan', 'ICN'),
(5, 'Istanbul Airport', 'Istanbul', 'Turki', 'IST'),
(6, 'Beijing Capital International Airport', 'Beijing', 'China', 'PEK'),
(7, 'John F. Kennedy International Airport', 'New York', 'Amerika', 'JFK'),
(8, 'Kuala Lumpur International Airport', 'Kuala Lumpur', 'Malaysia', 'KUL'),
(9, 'London Heathrow Airport', 'London', 'Inggris', 'LHR'),
(10, 'Amsterdam Schiphol Airport', 'Amsterdam', 'Belanda', 'AMS');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_food` int(11) NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `id` int(11) NOT NULL,
  `topik` varchar(30) NOT NULL,
  `feedback` varchar(255) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `feedback`
--

INSERT INTO `feedback` (`id`, `topik`, `feedback`, `timestamp`) VALUES
(82, 'Kenyamanan pesawat', 'Ada bekas tissue di bangku pesawat ', '2023-12-17 12:51:15'),
(83, 'Rasa makanan', 'Rasa soto yang saya beli terlalu asin', '2023-12-17 12:51:30'),
(84, 'Kenyamanan pesawat', 'halo', '2023-12-18 03:07:03');

-- --------------------------------------------------------

--
-- Table structure for table `flight`
--

CREATE TABLE `flight` (
  `id` int(11) NOT NULL,
  `code` varchar(8) NOT NULL,
  `from` int(11) NOT NULL,
  `to` int(11) NOT NULL,
  `departure_date` date NOT NULL,
  `departure_time` time NOT NULL,
  `arrive_time` time NOT NULL,
  `flight_time` varchar(7) NOT NULL,
  `price` int(11) NOT NULL,
  `status` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `flight`
--

INSERT INTO `flight` (`id`, `code`, `from`, `to`, `departure_date`, `departure_time`, `arrive_time`, `flight_time`, `price`, `status`) VALUES
(3, 'A123', 1, 2, '2023-12-22', '13:00:00', '15:30:00', '2h 30m', 150000, 0),
(4, 'B345', 1, 2, '2023-11-30', '16:00:00', '18:00:00', '2h', 180000, 1),
(5, 'C234', 1, 2, '2023-12-22', '16:00:00', '18:00:00', '2h', 180000, 0),
(6, 'D123', 2, 1, '2023-12-22', '20:00:00', '21:20:00', '1h 20m', 350000, 0),
(7, 'E456', 1, 6, '2023-12-05', '08:00:00', '11:00:00', '3h', 500000, 1),
(8, 'F234', 4, 8, '2023-12-20', '15:00:00', '18:30:00', '3h 30m', 600000, 0),
(9, 'G456', 5, 3, '2023-12-25', '21:00:00', '23:00:00', '2h', 350000, 0),
(10, 'H123', 7, 9, '2023-12-15', '10:00:00', '14:00:00', '4h', 600000, 1),
(11, 'I234', 3, 6, '2023-12-28', '20:00:00', '21:30:00', '1h 30m', 250000, 0),
(12, 'J789', 8, 2, '2023-12-18', '07:00:00', '08:00:00', '1h', 250000, 0),
(13, 'K567', 9, 10, '2023-12-16', '05:00:00', '07:10:00', '2h 10m', 450000, 1),
(14, 'L123', 7, 9, '2023-12-03', '23:00:00', '03:40:00', '4h 40m', 650000, 1),
(27, 'P324', 6, 1, '2023-12-20', '06:32:00', '23:30:00', '7h 2m', 980000, 0);

-- --------------------------------------------------------

--
-- Table structure for table `flight_transaction`
--

CREATE TABLE `flight_transaction` (
  `id` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_flight` int(11) NOT NULL,
  `seat` varchar(3) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `flight_transaction`
--

INSERT INTO `flight_transaction` (`id`, `id_user`, `id_flight`, `seat`, `timestamp`) VALUES
(13, 4, 3, '16D', '2023-12-17 06:46:06'),
(14, 8, 8, '8D', '2023-12-17 12:54:42'),
(15, 4, 12, '9B', '2023-12-17 13:07:23'),
(24, 8, 27, '9C', '2023-12-18 02:53:40'),
(25, 8, 9, '8D', '2023-12-18 03:05:51'),
(26, 4, 27, '5D', '2023-12-18 12:55:48');

-- --------------------------------------------------------

--
-- Table structure for table `food`
--

CREATE TABLE `food` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `photo` blob NOT NULL,
  `price` int(11) NOT NULL,
  `status` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `food`
--

INSERT INTO `food` (`id`, `name`, `description`, `photo`, `price`, `status`) VALUES
(25, 'Burger', 'Burger dengan topping keju, tomat, selada, mustard, dan daging wagyu A5.', 0x6275726765722e6a7067, 180000, 0),
(37, 'Pizza', 'Pizza dengan topping pepperoni, sosis, roasted chicken, beef, dan keju di atasnya.', 0x70697a7a612e6a7067, 230000, 0),
(40, 'Soto Daging', 'Menu makanan khas Indonesia dengan kuah kuning dan potongan daging lezat.', 0x736f746f2e6a7067, 85000, 0),
(42, 'Tenderloin Steak', 'Beef tenderloin dengan seasoning yang pas dan potongan sesuai keinginan Anda.', 0x737465616b2e6a7067, 450000, 0),
(43, 'Ayam Geprek', 'Ayam geprek: Gurih, pedas, lezat, dan menggoda selera dengan cita rasa unik.', 0x67657072656b2e6a7067, 80000, 0),
(44, 'Sushi Platter', 'Sushi dengan potongan ikan segar, nasi lembut, dan cita rasa eksklusif.', 0x73757368692e6a7067, 240000, 0);

-- --------------------------------------------------------

--
-- Table structure for table `food_transaction`
--

CREATE TABLE `food_transaction` (
  `id` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_flight` int(11) NOT NULL,
  `total` int(11) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `food_transaction`
--

INSERT INTO `food_transaction` (`id`, `id_user`, `id_flight`, `total`, `timestamp`) VALUES
(14, 4, 3, 540000, '2023-12-17 07:54:48'),
(15, 4, 3, 180000, '2023-12-17 07:56:11'),
(16, 8, 8, 235000, '2023-12-17 12:57:26'),
(17, 4, 12, 695000, '2023-12-17 13:07:42'),
(18, 4, 12, 710000, '2023-12-17 14:04:23'),
(19, 4, 12, 545000, '2023-12-18 02:55:26'),
(20, 8, 27, 545000, '2023-12-18 03:06:42');

-- --------------------------------------------------------

--
-- Table structure for table `food_transaction_details`
--

CREATE TABLE `food_transaction_details` (
  `id` int(11) NOT NULL,
  `id_food_transaction` int(11) NOT NULL,
  `id_food` int(11) NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `food_transaction_details`
--

INSERT INTO `food_transaction_details` (`id`, `id_food_transaction`, `id_food`, `quantity`) VALUES
(18, 14, 25, 3),
(19, 15, 25, 1),
(20, 16, 43, 2),
(21, 16, 40, 1),
(22, 17, 37, 2),
(23, 17, 40, 1),
(24, 17, 43, 2),
(25, 18, 37, 1),
(26, 18, 44, 2),
(27, 19, 37, 2),
(28, 19, 40, 1),
(29, 20, 37, 2),
(30, 20, 40, 1);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` text NOT NULL,
  `nama` varchar(64) NOT NULL,
  `no_passport` varchar(8) NOT NULL,
  `no_telp` varchar(13) NOT NULL,
  `email` varchar(36) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `password`, `nama`, `no_passport`, `no_telp`, `email`) VALUES
(4, 'user', '*D5D9F81F5542DE067FFF5FF7A4CA4BDD322C578F', 'user', 'E1208322', '081297341821', 'user@gmail.com'),
(5, 'elizabethceline', '*51B83BF9CEE547791D465E3A65DAB0C5EDBEA35D', 'Elizabeth Celine Liong', 'C1728176', '082125251199', 'elizabethceline04@gmail.com'),
(7, 'dargo78', '*2386342F5F12D7D744E309C6671BC4CAB08DD1CF', 'Stefanus WIlliam Sudargo', 'E2682372', '082931792132', 'dargo78@gmail.com'),
(8, 'cathoen', '*2B659089815FA88346F238A99977F1A428C83B01', 'Catherine Oentoro', 'G1273123', '0829347234733', 'cathoen@gmail.com');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `airport`
--
ALTER TABLE `airport`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user_cart` (`id_user`),
  ADD KEY `fk_food_cart` (`id_food`);

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `flight`
--
ALTER TABLE `flight`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_bandara_from` (`from`),
  ADD KEY `fk_bandara_to` (`to`);

--
-- Indexes for table `flight_transaction`
--
ALTER TABLE `flight_transaction`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_flight` (`id_flight`),
  ADD KEY `fk_userr` (`id_user`);

--
-- Indexes for table `food`
--
ALTER TABLE `food`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `food_transaction`
--
ALTER TABLE `food_transaction`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_flightt` (`id_flight`),
  ADD KEY `fk_user` (`id_user`);

--
-- Indexes for table `food_transaction_details`
--
ALTER TABLE `food_transaction_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_food` (`id_food`),
  ADD KEY `fk_food_transaction` (`id_food_transaction`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `airport`
--
ALTER TABLE `airport`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=85;

--
-- AUTO_INCREMENT for table `flight`
--
ALTER TABLE `flight`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `flight_transaction`
--
ALTER TABLE `flight_transaction`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `food`
--
ALTER TABLE `food`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `food_transaction`
--
ALTER TABLE `food_transaction`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `food_transaction_details`
--
ALTER TABLE `food_transaction_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `fk_food_cart` FOREIGN KEY (`id_food`) REFERENCES `food` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_user_cart` FOREIGN KEY (`id_user`) REFERENCES `user` (`id`);

--
-- Constraints for table `flight`
--
ALTER TABLE `flight`
  ADD CONSTRAINT `fk_bandara_from` FOREIGN KEY (`from`) REFERENCES `airport` (`id`),
  ADD CONSTRAINT `fk_bandara_to` FOREIGN KEY (`to`) REFERENCES `airport` (`id`);

--
-- Constraints for table `flight_transaction`
--
ALTER TABLE `flight_transaction`
  ADD CONSTRAINT `fk_flight` FOREIGN KEY (`id_flight`) REFERENCES `flight` (`id`),
  ADD CONSTRAINT `fk_userr` FOREIGN KEY (`id_user`) REFERENCES `user` (`id`);

--
-- Constraints for table `food_transaction`
--
ALTER TABLE `food_transaction`
  ADD CONSTRAINT `fk_flightt` FOREIGN KEY (`id_flight`) REFERENCES `flight` (`id`),
  ADD CONSTRAINT `fk_user` FOREIGN KEY (`id_user`) REFERENCES `user` (`id`);

--
-- Constraints for table `food_transaction_details`
--
ALTER TABLE `food_transaction_details`
  ADD CONSTRAINT `fk_food` FOREIGN KEY (`id_food`) REFERENCES `food` (`id`),
  ADD CONSTRAINT `fk_food_transaction` FOREIGN KEY (`id_food_transaction`) REFERENCES `food_transaction` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
