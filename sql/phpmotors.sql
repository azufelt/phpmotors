-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Dec 11, 2021 at 12:02 AM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `phpmotors`
--

-- --------------------------------------------------------

--
-- Table structure for table `carclassification`
--

CREATE TABLE `carclassification` (
  `classificationId` int(11) NOT NULL,
  `classificationName` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `carclassification`
--

INSERT INTO `carclassification` (`classificationId`, `classificationName`) VALUES
(1, 'SUV'),
(2, 'Classic'),
(3, 'Sports'),
(4, 'Trucks'),
(5, 'Used');

-- --------------------------------------------------------

--
-- Table structure for table `clients`
--

CREATE TABLE `clients` (
  `clientId` int(10) UNSIGNED NOT NULL,
  `clientFirstname` varchar(15) NOT NULL,
  `clientLastname` varchar(25) NOT NULL,
  `clientEmail` varchar(40) NOT NULL,
  `clientPassword` varchar(255) NOT NULL,
  `clientLevel` enum('1','2','3') NOT NULL DEFAULT '1',
  `comment` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `clients`
--

INSERT INTO `clients` (`clientId`, `clientFirstname`, `clientLastname`, `clientEmail`, `clientPassword`, `clientLevel`, `comment`) VALUES
(18, 'Admin', 'User', 'admin@cse340.net', '$2y$10$vPlWJjsu6D8XzOU/zLgruuDJ0tvHMr7i1592Ex7G4YeexWOHlB4cO', '3', NULL),
(19, 'Ashley', 'Zufelt', 'zuf20001@byui.edu', '$2y$10$Hgnp2QiHQYisXkm8337XJ.eM0SnRDT9v1Ca9xqReLXKdXnKb78A76', '1', NULL),
(20, 'Ashley', 'Zufelt', 'ashley.zufelt@gmail.com', '$2y$10$Gb4XolTMFXW08Bbz7dT2JeWzbBMp8XttG8t0bzSxALkpvEZASeLgu', '1', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `images`
--

CREATE TABLE `images` (
  `imgId` int(10) UNSIGNED NOT NULL,
  `invId` int(10) UNSIGNED NOT NULL,
  `imgName` varchar(100) NOT NULL,
  `imgPath` varchar(150) NOT NULL,
  `imgDate` timestamp NOT NULL DEFAULT current_timestamp(),
  `imgPrimary` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `images`
--

INSERT INTO `images` (`imgId`, `invId`, `imgName`, `imgPath`, `imgDate`, `imgPrimary`) VALUES
(13, 1, 'wrangler.jpg', '/phpmotors/images/vehicles/wrangler.jpg', '2021-11-23 02:59:02', 1),
(14, 1, 'wrangler-tn.jpg', '/phpmotors/images/vehicles/wrangler-tn.jpg', '2021-11-23 02:59:02', 1),
(15, 2, 'model-t.jpg', '/phpmotors/images/vehicles/model-t.jpg', '2021-11-23 02:59:25', 1),
(16, 2, 'model-t-tn.jpg', '/phpmotors/images/vehicles/model-t-tn.jpg', '2021-11-23 02:59:25', 1),
(17, 4, 'monster-truck.jpg', '/phpmotors/images/vehicles/monster-truck.jpg', '2021-11-23 03:00:24', 1),
(18, 4, 'monster-truck-tn.jpg', '/phpmotors/images/vehicles/monster-truck-tn.jpg', '2021-11-23 03:00:24', 1),
(19, 5, 'mechanic.jpg', '/phpmotors/images/vehicles/mechanic.jpg', '2021-11-23 03:00:43', 1),
(20, 5, 'mechanic-tn.jpg', '/phpmotors/images/vehicles/mechanic-tn.jpg', '2021-11-23 03:00:43', 1),
(21, 6, 'batmobile.jpg', '/phpmotors/images/vehicles/batmobile.jpg', '2021-11-23 03:00:57', 1),
(22, 6, 'batmobile-tn.jpg', '/phpmotors/images/vehicles/batmobile-tn.jpg', '2021-11-23 03:00:57', 1),
(23, 7, 'mystery-van.jpg', '/phpmotors/images/vehicles/mystery-van.jpg', '2021-11-23 03:01:18', 1),
(24, 7, 'mystery-van-tn.jpg', '/phpmotors/images/vehicles/mystery-van-tn.jpg', '2021-11-23 03:01:18', 1),
(25, 8, 'fire-truck.jpg', '/phpmotors/images/vehicles/fire-truck.jpg', '2021-11-23 03:01:28', 1),
(26, 8, 'fire-truck-tn.jpg', '/phpmotors/images/vehicles/fire-truck-tn.jpg', '2021-11-23 03:01:28', 1),
(27, 9, 'crwn-vic.jpg', '/phpmotors/images/vehicles/crwn-vic.jpg', '2021-11-23 03:01:46', 1),
(28, 9, 'crwn-vic-tn.jpg', '/phpmotors/images/vehicles/crwn-vic-tn.jpg', '2021-11-23 03:01:46', 1),
(29, 10, 'camaro.jpg', '/phpmotors/images/vehicles/camaro.jpg', '2021-11-23 03:02:05', 1),
(30, 10, 'camaro-tn.jpg', '/phpmotors/images/vehicles/camaro-tn.jpg', '2021-11-23 03:02:05', 1),
(31, 11, 'escalade.jpg', '/phpmotors/images/vehicles/escalade.jpg', '2021-11-23 03:02:28', 1),
(32, 11, 'escalade-tn.jpg', '/phpmotors/images/vehicles/escalade-tn.jpg', '2021-11-23 03:02:28', 1),
(33, 12, 'hummer.jpg', '/phpmotors/images/vehicles/hummer.jpg', '2021-11-23 03:02:46', 1),
(34, 12, 'hummer-tn.jpg', '/phpmotors/images/vehicles/hummer-tn.jpg', '2021-11-23 03:02:46', 1),
(35, 13, 'aerocar.jpg', '/phpmotors/images/vehicles/aerocar.jpg', '2021-11-23 03:03:04', 1),
(36, 13, 'aerocar-tn.jpg', '/phpmotors/images/vehicles/aerocar-tn.jpg', '2021-11-23 03:03:04', 1),
(37, 14, 'van.jpg', '/phpmotors/images/vehicles/van.jpg', '2021-11-23 03:03:38', 1),
(38, 14, 'van-tn.jpg', '/phpmotors/images/vehicles/van-tn.jpg', '2021-11-23 03:03:38', 1),
(41, 24, 'delorean.jpg', '/phpmotors/images/vehicles/delorean.jpg', '2021-11-23 03:13:04', 1),
(42, 24, 'delorean-tn.jpg', '/phpmotors/images/vehicles/delorean-tn.jpg', '2021-11-23 03:13:04', 1),
(43, 15, 'furry-dog-car.jpg', '/phpmotors/images/vehicles/furry-dog-car.jpg', '2021-11-23 04:07:00', 1),
(44, 15, 'furry-dog-car-tn.jpg', '/phpmotors/images/vehicles/furry-dog-car-tn.jpg', '2021-11-23 04:07:00', 1),
(49, 14, 'images.jpeg', '/phpmotors/images/vehicles/images.jpeg', '2021-11-24 19:54:47', 0),
(50, 14, 'images-tn.jpeg', '/phpmotors/images/vehicles/images-tn.jpeg', '2021-11-24 19:54:47', 0),
(53, 14, 'fbi-ups-van.jpg', '/phpmotors/images/vehicles/fbi-ups-van.jpg', '2021-11-25 15:34:04', 0),
(54, 14, 'fbi-ups-van-tn.jpg', '/phpmotors/images/vehicles/fbi-ups-van-tn.jpg', '2021-11-25 15:34:04', 0),
(55, 15, 'dog-car2.png', '/phpmotors/images/vehicles/dog-car2.png', '2021-11-25 19:51:47', 0),
(56, 15, 'dog-car2-tn.png', '/phpmotors/images/vehicles/dog-car2-tn.png', '2021-11-25 19:51:47', 0),
(57, 15, 'shaggy-dog-car.jpg', '/phpmotors/images/vehicles/shaggy-dog-car.jpg', '2021-11-25 19:56:01', 0),
(58, 15, 'shaggy-dog-car-tn.jpg', '/phpmotors/images/vehicles/shaggy-dog-car-tn.jpg', '2021-11-25 19:56:01', 0),
(59, 15, 'maxresdefault.jpg', '/phpmotors/images/vehicles/maxresdefault.jpg', '2021-11-25 19:56:20', 0),
(60, 15, 'maxresdefault-tn.jpg', '/phpmotors/images/vehicles/maxresdefault-tn.jpg', '2021-11-25 19:56:20', 0),
(61, 4, 'monster-monster-truck.jpg', '/phpmotors/images/vehicles/monster-monster-truck.jpg', '2021-11-28 05:31:58', 0),
(62, 4, 'monster-monster-truck-tn.jpg', '/phpmotors/images/vehicles/monster-monster-truck-tn.jpg', '2021-11-28 05:31:58', 0);

-- --------------------------------------------------------

--
-- Table structure for table `inventory`
--

CREATE TABLE `inventory` (
  `invId` int(10) UNSIGNED NOT NULL,
  `invMake` varchar(30) NOT NULL,
  `invModel` varchar(30) NOT NULL,
  `invDescription` text NOT NULL,
  `invImage` varchar(50) NOT NULL,
  `invThumbnail` varchar(50) NOT NULL,
  `invPrice` decimal(10,0) NOT NULL,
  `invStock` smallint(6) NOT NULL,
  `invColor` varchar(20) NOT NULL,
  `classificationId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `inventory`
--

INSERT INTO `inventory` (`invId`, `invMake`, `invModel`, `invDescription`, `invImage`, `invThumbnail`, `invPrice`, `invStock`, `invColor`, `classificationId`) VALUES
(1, 'Jeep ', 'Wrangler', 'The Jeep Wrangler is small and compact with enough power to get you where you want to go. It is great for everyday driving as well as off-roading whether that be on the rocks or in the mud!', '/images/jeep-wrangler.jpg', '/images/jeep-wrangler-tn.jpg', '28045', 4, 'Orange', 1),
(2, 'Ford', 'Model T', 'The Ford Model T can be a bit tricky to drive. It was the first car to be put into production. You can get it in any color you want if it is black.', 'model-t.jpg', 'model-t-tn.jpg', '30000', 2, '#000000', 2),
(3, 'Lamborghini', 'Adventador', 'This V-12 engine packs a punch in this sporty car. Make sure you wear your seatbelt and obey all traffic laws.', '/images/lambo-Adve.jpg', '/images/lambo-Adve-tn.jpg', '417650', 1, 'Blue', 3),
(4, 'Monster', 'Truck', 'Most trucks are for working, this one is for fun. This beast comes with 60 inch tires giving you the traction needed to jump and roll in the mud.', 'monster-truck.jpg', 'monster-truck-tn.jpg', '150000', 3, '#000000', 4),
(5, 'Mechanic', 'Special', 'Not sure where this car came from. However, with a little tender loving care it will run as good a new.', '/images/ms.jpg', '/images/ms-tn.jpg', '100', 1, 'Rust', 5),
(6, 'Batmobile', 'Custom', 'Ever want to be a superhero? Now you can with the bat mobile. This car allows you to switch to bike mode allowing for easy maneuvering through traffic during rush hour.', 'batmobile.jpg', 'batmobile-tn.jpg', '65000', 1, '#000000', 3),
(7, 'Mystery', 'Machine', 'Scooby and the gang always found luck in solving their mysteries because of their 4 wheel drive Mystery Machine. This Van will help you do whatever job you are required to with a success rate of 100%.', '/images/mm.jpg', '/images/mm-tn.jpg', '10000', 12, 'Green', 1),
(8, 'Spartan', 'Fire Truck', 'Emergencies happen often. Be prepared with this Spartan fire truck. Comes complete with 1000 ft. of hose and a 1000-gallon tank.', '/images/fire-truck.jpg', '/images/fire-truck-tn.jpg', '50000', 1, 'Red', 4),
(9, 'Ford', 'Crown Victoria', 'After the police force updated their fleet these cars are now available to the public! These cars come equipped with the siren which is convenient for college students running late to class.', '/images/crown-vic.jpg', '/images/crown-vic-tn.jpg', '10000', 5, 'White', 5),
(10, 'Chevy', 'Camaro', 'If you want to look cool this is the car you need! This car has great performance at an affordable price. Own it today!', '/images/camaro.jpg', '/images/camaro-tn.jpg', '25000', 10, 'Silver', 3),
(11, 'Cadillac', 'Escalade', 'This styling car is great for any occasion from going to the beach to meeting the president. The luxurious inside makes this car a home away from home.', '/images/escalade.jpg', '/images/escalade-tn.jpg', '75195', 4, 'Black', 1),
(12, 'GM', 'Hummer', 'Do you have 6 kids and like to go off-roading? The Hummer gives you the small interiors with an engine to get you out of any muddy or rocky situation.', '/images/hummer.jpg', '/images/hummer-tn.jpg', '58800', 5, 'Yellow', 5),
(13, 'Aerocar ', 'International', 'Are you sick of rush hour traffic? This car converts into an airplane to get you where you are going fast. Only 6 of these were made, get this one while it lasts!', 'aerocar.jpg', 'aerocar-tn.jpg', '1000000', 1, '#000000', 2),
(14, 'FBI', 'Surveillance Van', 'Do you like police shows? You will feel right at home driving this van. Comes complete with surveillance equipment for an extra fee of $2,000 a month. ', '/images/fbi.jpg', '/images/fbi-tn.jpg', '20000', 1, 'Green', 1),
(15, 'Dog ', 'Car', 'Do you like dogs? Well, this car is for you straight from the 90s from Aspen, Colorado we have the original Dog Car complete with fluffy ears.', 'dog-car.png', 'dog-car.png', '35000', 1, '#000000', 2),
(24, 'DMC', 'DeLorean', 'In the Back to the Future franchise, the DeLorean time machine is a time travel device made by retrofitting a DMC DeLorean vehicle with a flux capacitor. The car requires 1.21 gigawatts of power and needs to travel 88 miles per hour (142 km/h) to initiate time travel.', 'delorean.jpg', 'no-image.png', '100000', 1, '#b5b5b5', 2);

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `reviewId` int(10) UNSIGNED NOT NULL,
  `reviewText` text CHARACTER SET latin1 NOT NULL,
  `reviewDate` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `invId` int(10) UNSIGNED NOT NULL,
  `clientId` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`reviewId`, `reviewText`, `reviewDate`, `invId`, `clientId`) VALUES
(3, 'I hated owning this car. Smelled musty.', '2021-12-10 03:21:35', 2, 18),
(5, 'Super Comfy, you&#39;ll love it! No, really, you&#39;ll LOVE IT', '2021-12-08 15:16:07', 2, 18),
(7, ' This is the FASTEST way to get to work! ', '2021-12-07 01:27:10', 13, 18),
(9, 'This car is excellent, everyone should have one of these! You&#39;ll never be late for anything when you drive one of these. ', '2021-12-08 23:22:16', 24, 18),
(10, 'Personally I prefer the Chevy version of this car... nobody needs to be *that* bougie to have an Escalade!', '2021-12-08 17:55:49', 11, 20),
(11, ' This truck is a MUST HAVE if you live in the South!!!!!!! ', '2021-12-08 23:33:09', 4, 20),
(12, 'Love this car, have one in orange! I love the new car smell it has!', '2021-12-10 02:59:50', 10, 18);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `carclassification`
--
ALTER TABLE `carclassification`
  ADD PRIMARY KEY (`classificationId`);

--
-- Indexes for table `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`clientId`),
  ADD UNIQUE KEY `clientEmail` (`clientEmail`);

--
-- Indexes for table `images`
--
ALTER TABLE `images`
  ADD PRIMARY KEY (`imgId`),
  ADD KEY `FK_inv_images` (`invId`);

--
-- Indexes for table `inventory`
--
ALTER TABLE `inventory`
  ADD PRIMARY KEY (`invId`),
  ADD KEY `classificationId` (`classificationId`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`reviewId`),
  ADD KEY `FK_reviews_clients` (`clientId`),
  ADD KEY `FK_reviews_inventory` (`invId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `carclassification`
--
ALTER TABLE `carclassification`
  MODIFY `classificationId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `clients`
--
ALTER TABLE `clients`
  MODIFY `clientId` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `images`
--
ALTER TABLE `images`
  MODIFY `imgId` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- AUTO_INCREMENT for table `inventory`
--
ALTER TABLE `inventory`
  MODIFY `invId` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `reviewId` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `images`
--
ALTER TABLE `images`
  ADD CONSTRAINT `FK_inv_images` FOREIGN KEY (`invId`) REFERENCES `inventory` (`invId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `inventory`
--
ALTER TABLE `inventory`
  ADD CONSTRAINT `inventory_ibfk_1` FOREIGN KEY (`classificationId`) REFERENCES `carclassification` (`classificationId`);

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `FK_reviews_clients` FOREIGN KEY (`clientId`) REFERENCES `clients` (`clientId`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_reviews_inventory` FOREIGN KEY (`invId`) REFERENCES `inventory` (`invId`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
