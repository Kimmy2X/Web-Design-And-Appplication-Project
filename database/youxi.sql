-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 03, 2024 at 07:17 AM
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
-- Database: `youxi`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `cartID` int(15) NOT NULL,
  `userID` int(15) NOT NULL,
  `gameID` int(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`cartID`, `userID`, `gameID`) VALUES
(7, 7, 13),
(8, 7, 12);

-- --------------------------------------------------------

--
-- Table structure for table `gamecatalog`
--

CREATE TABLE `gamecatalog` (
  `gameID` int(4) NOT NULL,
  `gameName` varchar(50) NOT NULL,
  `cover` varchar(150) NOT NULL,
  `logo` varchar(150) NOT NULL,
  `vid` varchar(150) NOT NULL,
  `img1` varchar(150) NOT NULL,
  `img2` varchar(150) NOT NULL,
  `backImg` varchar(150) NOT NULL,
  `mp3` varchar(150) NOT NULL,
  `descript` varchar(1000) NOT NULL,
  `price` double NOT NULL,
  `developer` varchar(150) NOT NULL,
  `publisher` varchar(150) NOT NULL,
  `releasedDate` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `gamecatalog`
--

INSERT INTO `gamecatalog` (`gameID`, `gameName`, `cover`, `logo`, `vid`, `img1`, `img2`, `backImg`, `mp3`, `descript`, `price`, `developer`, `publisher`, `releasedDate`) VALUES
(10, 'Arknights', 'covers/coverAK.jpg', 'logos/logoAK.png', 'videos/vidAK.webm', 'images/img1AK.webp', 'images/img2AK.webp', 'images/backAK.jpg', 'audio/themeAK.mp3', 'Arknights is a free-to-play tactical RPG/tower defense mobile game developed by Chinese developer Hypergryph. It was released in China on 1 May 2019, in other countries on 16 January 2020, and in Taiwan on 29 June 2020. Arknights is available on Android and iOS platforms and features gacha game mechanics.', 0, 'Hypergryph', 'YoStars', '1 May 2019'),
(11, 'Lethal Company', 'covers/coverLC.jpg', 'logos/logoLC.webp', 'videos/vidLC.mp4', 'images/img1LC.jpg', 'images/img2LC.jpg', 'images/backLC.webp', 'audio/audioLC.mp3', 'A co-op horror about scavenging at abandoned moons to sell scrap to the Company.', 26.75, 'Zeekers', 'Zeekers', '24 Oct 2023'),
(12, 'Rival of Aether', 'covers/coverRoA.jpg', 'logos/logoRoA.png', 'videos/vidRoA.mp4', 'images/img1RoA.jpg', 'images/img2Roa.jpg', 'images/backRoA.jpg', 'audio/audioRoA.mp3', 'RIVALS OF AETHER is an indie fighting game where warring civilizations summon the power of Fire, Water, Air, and Earth. Play with up to four players either locally or online.', 72, 'Aether Studios', 'Aether Studios', '29 Mar 2017'),
(13, 'Pico Park', 'covers/coverPP.jpg', 'logos/logoPP.png', 'videos/vidPP.mp4', 'images/img1PP.jpg', 'images/img2PP.jpg', 'images/backPP.png', 'audio/themePP.mp3', 'PICO PARK is a cooperative local/online multiplay action puzzle game for 2-8 players.', 12.5, 'TECOPARK', 'TECOPARK', '7 May 2021'),
(23, 'Slime Rancher 2', 'covers/coverSR2.jpeg', 'logos/logoSR2.png', 'videos/vidSR2.mp4', 'images/img1SR2.jpg', 'images/img2SR2.jpg', 'images/backSR2.png', 'audio/ostSR2.mp3', 'Continue the adventures of Beatrix LeBeau as she journeys across the Slime Sea to Rainbow Island, a land brimming with ancient mysteries, and bursting with wiggly, new slimes to wrangle in this sequel to the smash-hit, Slime Rancher.', 81, 'Monomi Park', 'Monomi Park', '22 Sep 2022');

-- --------------------------------------------------------

--
-- Table structure for table `purchases`
--

CREATE TABLE `purchases` (
  `purchaseID` int(11) NOT NULL,
  `userID` int(11) DEFAULT NULL,
  `gameID` int(11) DEFAULT NULL,
  `proofOfPurchase` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `purchases`
--

INSERT INTO `purchases` (`purchaseID`, `userID`, `gameID`, `proofOfPurchase`) VALUES
(12, 7, 23, 'proofs/Group Cutie Patootie.pdf'),
(13, 7, 11, 'proofs/Group Cutie Patootie.pdf');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `userID` int(4) NOT NULL,
  `userPassword` varchar(15) NOT NULL,
  `userName` varchar(15) NOT NULL,
  `userPhoneNo` varchar(15) NOT NULL,
  `userEmail` varchar(50) NOT NULL,
  `userBday` varchar(15) NOT NULL,
  `userAdmin` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`userID`, `userPassword`, `userName`, `userPhoneNo`, `userEmail`, `userBday`, `userAdmin`) VALUES
(1, 'Hakimi040213', 'Hakimi', '011-23440283', 'hakimi_rmt@yahoo.com', '2004-02-13', 'Yes'),
(7, 'KimmyHime12', 'Kimmy2X', '011-23440283', 'quadrapheonix@gmail.com', '28/11/2004', 'No');

-- --------------------------------------------------------

--
-- Table structure for table `wishlist`
--

CREATE TABLE `wishlist` (
  `wishlistID` int(11) NOT NULL,
  `userID` int(11) NOT NULL,
  `gameID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `wishlist`
--

INSERT INTO `wishlist` (`wishlistID`, `userID`, `gameID`) VALUES
(4, 7, 13);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`cartID`);

--
-- Indexes for table `gamecatalog`
--
ALTER TABLE `gamecatalog`
  ADD PRIMARY KEY (`gameID`);

--
-- Indexes for table `purchases`
--
ALTER TABLE `purchases`
  ADD PRIMARY KEY (`purchaseID`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`userID`);

--
-- Indexes for table `wishlist`
--
ALTER TABLE `wishlist`
  ADD PRIMARY KEY (`wishlistID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `cartID` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `gamecatalog`
--
ALTER TABLE `gamecatalog`
  MODIFY `gameID` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `purchases`
--
ALTER TABLE `purchases`
  MODIFY `purchaseID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `userID` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `wishlist`
--
ALTER TABLE `wishlist`
  MODIFY `wishlistID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
