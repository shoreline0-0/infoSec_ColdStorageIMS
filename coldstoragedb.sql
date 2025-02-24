-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 24, 2025 at 12:39 PM
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
-- Database: `coldstoragedb`
--

-- --------------------------------------------------------

--
-- Table structure for table `alerts`
--

CREATE TABLE `alerts` (
  `AlertID` int(11) NOT NULL,
  `ProductID` int(11) NOT NULL,
  `StorageID` int(11) NOT NULL,
  `AlertName` varchar(255) NOT NULL,
  `AlertTime` datetime NOT NULL DEFAULT current_timestamp(),
  `Status` enum('Unresolved','Resolved') NOT NULL DEFAULT 'Unresolved',
  `ResolvedTime` datetime DEFAULT NULL,
  `ResolvedBy` int(11) DEFAULT NULL,
  `Notes` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `alerts`
--

INSERT INTO `alerts` (`AlertID`, `ProductID`, `StorageID`, `AlertName`, `AlertTime`, `Status`, `ResolvedTime`, `ResolvedBy`, `Notes`) VALUES
(1, 1, 1, 'Expiration Warning - Vanilla Ice Cream', '2025-06-25 10:00:00', 'Unresolved', NULL, NULL, 'Vanilla Ice Cream nearing expiry date'),
(2, 2, 2, 'Expiration Warning - Chocolate Mousse', '2024-12-10 10:00:00', 'Unresolved', NULL, NULL, 'Chocolate Mousse nearing expiry date'),
(3, 3, 2, 'Expiration Warning - Strawberry Cheesecake', '2024-11-20 14:00:00', 'Unresolved', NULL, NULL, 'Strawberry Cheesecake nearing expiry date'),
(4, 5, 5, 'Storage Warning - Tiramisu', '2024-10-01 08:00:00', 'Unresolved', NULL, NULL, 'Tiramisu should be stored properly to avoid spoilage');

-- --------------------------------------------------------

--
-- Table structure for table `batch`
--

CREATE TABLE `batch` (
  `BatchID` int(11) NOT NULL,
  `BatchDate` date NOT NULL,
  `ProductTotal` int(11) NOT NULL DEFAULT 0,
  `ProductAvailable` int(11) NOT NULL DEFAULT 0,
  `Status` enum('Active','Empty') NOT NULL DEFAULT 'Active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `batch`
--

INSERT INTO `batch` (`BatchID`, `BatchDate`, `ProductTotal`, `ProductAvailable`, `Status`) VALUES
(1, '2024-06-01', 50, 50, 'Active'),
(2, '2024-06-02', 30, 30, 'Active'),
(3, '2024-06-03', 20, 20, 'Active'),
(4, '2024-06-04', 40, 40, 'Active'),
(5, '2024-06-05', 25, 25, 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `inventory`
--

CREATE TABLE `inventory` (
  `InventoryID` int(11) NOT NULL,
  `ProductID` int(11) NOT NULL,
  `StorageID` int(11) NOT NULL,
  `BatchID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `inventory`
--

INSERT INTO `inventory` (`InventoryID`, `ProductID`, `StorageID`, `BatchID`) VALUES
(1, 1, 1, 1),
(2, 4, 1, 4),
(3, 2, 2, 2),
(4, 3, 2, 3),
(5, 5, 2, 5);

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `ProductID` int(11) NOT NULL,
  `ProductName` varchar(255) NOT NULL,
  `CurrentStock` int(11) NOT NULL DEFAULT 0,
  `ProductExpiryDate` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`ProductID`, `ProductName`, `CurrentStock`, `ProductExpiryDate`) VALUES
(1, 'Vanilla Ice Cream', 50, '2025-06-30'),
(2, 'Chocolate Mousse', 30, '2024-12-15'),
(3, 'Strawberry Cheesecake', 20, '2024-11-25'),
(4, 'Mango Sorbet', 40, '2025-07-10'),
(5, 'Tiramisu', 25, '2024-10-05');

-- --------------------------------------------------------

--
-- Table structure for table `storage`
--

CREATE TABLE `storage` (
  `StorageID` int(11) NOT NULL,
  `StorageName` varchar(255) NOT NULL,
  `StorageCapacity` int(11) NOT NULL,
  `StorageTemperature` decimal(5,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `storage`
--

INSERT INTO `storage` (`StorageID`, `StorageName`, `StorageCapacity`, `StorageTemperature`) VALUES
(1, 'Storage A', 500, -18.00),
(2, 'Storage B', 300, 4.00),
(3, 'Storage C', 200, 2.00),
(4, 'Storage D', 400, -5.00),
(5, 'Storage E', 250, 8.00);

-- --------------------------------------------------------

--
-- Table structure for table `transactionlog`
--

CREATE TABLE `transactionlog` (
  `TransactionID` int(11) NOT NULL,
  `TransactionType` enum('Add','Remove') NOT NULL,
  `ProductID` int(11) NOT NULL,
  `UserID` int(11) NOT NULL,
  `TransactionDate` datetime NOT NULL DEFAULT current_timestamp(),
  `Notes` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `UserID` int(11) NOT NULL,
  `FirstName` varchar(100) NOT NULL,
  `LastName` varchar(100) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `Status` enum('Active','Inactive') NOT NULL DEFAULT 'Active',
  `Role` enum('Admin','Super Admin') NOT NULL DEFAULT 'Admin'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`UserID`, `FirstName`, `LastName`, `Email`, `Password`, `Status`, `Role`) VALUES
(1, 'John', 'Doe', 'admin@example.com', 'e86f78a8a3caf0b60d8e74e5942aa6d86dc150cd3c03338aef25b7d2d7e3acc7', 'Active', 'Admin'),
(2, 'Jane', 'Smith', 'superadmin@example.com', 'd3535b78e24867f3c850fec1c8591b7a469b8f8683be64d835057cb9fd204aa1', 'Active', 'Super Admin');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `alerts`
--
ALTER TABLE `alerts`
  ADD PRIMARY KEY (`AlertID`),
  ADD KEY `ProductID` (`ProductID`),
  ADD KEY `StorageID` (`StorageID`);

--
-- Indexes for table `batch`
--
ALTER TABLE `batch`
  ADD PRIMARY KEY (`BatchID`);

--
-- Indexes for table `inventory`
--
ALTER TABLE `inventory`
  ADD PRIMARY KEY (`InventoryID`),
  ADD KEY `ProductID` (`ProductID`),
  ADD KEY `StorageID` (`StorageID`),
  ADD KEY `BatchID` (`BatchID`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`ProductID`);

--
-- Indexes for table `storage`
--
ALTER TABLE `storage`
  ADD PRIMARY KEY (`StorageID`);

--
-- Indexes for table `transactionlog`
--
ALTER TABLE `transactionlog`
  ADD PRIMARY KEY (`TransactionID`),
  ADD KEY `ProductID` (`ProductID`),
  ADD KEY `UserID` (`UserID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`UserID`),
  ADD UNIQUE KEY `Email` (`Email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `alerts`
--
ALTER TABLE `alerts`
  MODIFY `AlertID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `batch`
--
ALTER TABLE `batch`
  MODIFY `BatchID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `inventory`
--
ALTER TABLE `inventory`
  MODIFY `InventoryID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `ProductID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `storage`
--
ALTER TABLE `storage`
  MODIFY `StorageID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `transactionlog`
--
ALTER TABLE `transactionlog`
  MODIFY `TransactionID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `UserID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `alerts`
--
ALTER TABLE `alerts`
  ADD CONSTRAINT `alerts_ibfk_1` FOREIGN KEY (`ProductID`) REFERENCES `product` (`ProductID`) ON DELETE CASCADE,
  ADD CONSTRAINT `alerts_ibfk_2` FOREIGN KEY (`StorageID`) REFERENCES `storage` (`StorageID`) ON DELETE CASCADE;

--
-- Constraints for table `inventory`
--
ALTER TABLE `inventory`
  ADD CONSTRAINT `inventory_ibfk_1` FOREIGN KEY (`ProductID`) REFERENCES `product` (`ProductID`) ON DELETE CASCADE,
  ADD CONSTRAINT `inventory_ibfk_2` FOREIGN KEY (`StorageID`) REFERENCES `storage` (`StorageID`) ON DELETE CASCADE,
  ADD CONSTRAINT `inventory_ibfk_3` FOREIGN KEY (`BatchID`) REFERENCES `batch` (`BatchID`) ON DELETE CASCADE;

--
-- Constraints for table `transactionlog`
--
ALTER TABLE `transactionlog`
  ADD CONSTRAINT `transactionlog_ibfk_1` FOREIGN KEY (`ProductID`) REFERENCES `product` (`ProductID`) ON DELETE CASCADE,
  ADD CONSTRAINT `transactionlog_ibfk_2` FOREIGN KEY (`UserID`) REFERENCES `users` (`UserID`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
