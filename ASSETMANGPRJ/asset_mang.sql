-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 06, 2026 at 02:45 PM
-- Server version: 10.4.25-MariaDB
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `asset_mang`
--

-- --------------------------------------------------------

--
-- Table structure for table `assets`
--

CREATE TABLE `assets` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT 'Industrial Asset',
  `age` int(11) DEFAULT 0,
  `breakdown_count` int(11) DEFAULT 0,
  `repair_cost` decimal(10,2) DEFAULT 0.00,
  `risk_level` varchar(50) DEFAULT 'Low'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `assets`
--

INSERT INTO `assets` (`id`, `name`, `age`, `breakdown_count`, `repair_cost`, `risk_level`) VALUES
(1, 'Gateway HVAC', 5, 2, '1200.00', 'Low'),
(2, 'Coastal Generator', 2, 0, '50.00', 'Low'),
(3, 'Fan Coolant', 8, 4, '15000.00', 'Medium'),
(4, 'Generator', 1, 0, '0.00', 'Low');

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

CREATE TABLE `projects` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `status` varchar(50) DEFAULT 'Active',
  `health` int(11) DEFAULT 100,
  `duration` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `projects`
--

INSERT INTO `projects` (`id`, `name`, `status`, `health`, `duration`) VALUES
(1, 'Prestige Hillside Gateway', 'Active', 85, ''),
(2, 'Chellanam Coastal', 'Active', 98, ''),
(3, 'Genie Manlift Z-45', 'Deactivated', 45, ''),
(4, 'Construction Site A', 'Active', 0, ''),
(5, 'Warehouse Equipment Upgrade', 'Active', 0, ''),
(6, 'Tower Crane Installation', 'Active', 0, ''),
(7, 'Roadwork Machinery Rental', 'Active', 0, ''),
(8, 'Industrial Tools Deployment', 'Deactivated', 0, ''),
(10, 'warehouse maintenance', 'Active', 100, '6 months');

-- --------------------------------------------------------

--
-- Table structure for table `tickets`
--

CREATE TABLE `tickets` (
  `id` int(11) NOT NULL,
  `asset_id` int(11) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `priority` varchar(50) DEFAULT 'Normal',
  `status` varchar(50) DEFAULT 'Open',
  `project_id` int(11) DEFAULT NULL,
  `age` int(11) DEFAULT 0,
  `breakdown_count` int(11) DEFAULT 0,
  `repair_cost` decimal(10,2) DEFAULT 0.00,
  `downtime_hours` int(11) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tickets`
--

INSERT INTO `tickets` (`id`, `asset_id`, `description`, `priority`, `status`, `project_id`, `age`, `breakdown_count`, `repair_cost`, `downtime_hours`, `created_at`, `updated_at`) VALUES
(1, 3, 'Sensor Calibration Failure', 'High', 'Resolved', NULL, 0, 0, '0.00', 0, '2026-04-06 11:57:07', '2026-04-06 11:57:07'),
(2, 1, 'Motor Bearing Replacement', 'Critical', 'Open', NULL, 0, 0, '0.00', 0, '2026-04-06 11:57:07', '2026-04-06 11:57:07'),
(5, 4, '[Params: Age 1, Breakdowns 0, Cost $0.00, Downtime 2hrs] - test', 'Normal', 'Open', 3, 0, 0, '0.00', 0, '2026-04-06 11:57:07', '2026-04-06 11:57:07'),
(6, 4, '[AUTO-DISPATCH] ML Predicted High Risk. Age: 1, Breakdowns: 400', 'High', 'Resolved', 0, 0, 0, '100.00', 0, '2026-04-06 11:57:07', '2026-04-06 12:39:58');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `role` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`) VALUES
(1, 'System Admin', 'admin@example.com', 'admin123', 'Admin'),
(2, 'PMO Manager', 'pmo@example.com', 'pmo123', 'PMO'),
(3, 'Field Technician', 'tech@example.com', 'tech123', 'Technician');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `assets`
--
ALTER TABLE `assets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tickets`
--
ALTER TABLE `tickets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `assets`
--
ALTER TABLE `assets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `projects`
--
ALTER TABLE `projects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `tickets`
--
ALTER TABLE `tickets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
