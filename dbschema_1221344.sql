-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jan 15, 2025 at 05:59 PM
-- Server version: 8.0.40
-- PHP Version: 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `web1221344_tap`
--

-- --------------------------------------------------------

--
-- Table structure for table `address`
--

CREATE TABLE `address` (
  `user_id` int NOT NULL,
  `country` mediumtext NOT NULL,
  `city` mediumtext NOT NULL,
  `street` mediumtext NOT NULL,
  `flat` mediumtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `address`
--

INSERT INTO `address` (`user_id`, `country`, `city`, `street`, `flat`) VALUES
(1, 'Saudi Arabia', 'Riyadh', 'King Fahd Road', '101'),
(2, 'UAE', 'Dubai', 'Sheikh Zayed Road', '202'),
(3, 'Qatar', 'Doha', 'Al Corniche Street', '303'),
(4, 'Kuwait', 'Kuwait City', 'Gulf Road', '404'),
(5, 'Oman', 'Muscat', 'Sultan Qaboos Street', '505'),
(6, 'Saudi Arabia', 'Jeddah', 'Prince Sultan Road', '606'),
(7, 'UAE', 'Abu Dhabi', 'Khalifa Street', '707'),
(8, 'Qatar', 'Doha', 'Al Sadd Street', '808'),
(9, 'Bahrain', 'Manama', 'Exhibition Avenue', '909'),
(10, 'Oman', 'Salalah', 'Al Haffa Street', '1010'),
(11, 'Saudi Arabia', 'Medina', 'Al Haram Street', '111'),
(12, 'UAE', 'Sharjah', 'Al Wahda Street', '222'),
(13, 'Qatar', 'Al Khor', 'Al Bayt Street', '333'),
(14, 'Kuwait', 'Hawalli', 'Beirut Street', '444'),
(15, 'Oman', 'Sohar', 'Al Batinah Street', '555'),
(16, 'Saudi Arabia', 'Taif', 'Al Rudaf Street', '666'),
(17, 'UAE', 'Ajman', 'Sheikh Rashid Street', '777'),
(18, 'Qatar', 'Al Wakrah', 'Al Wukair Street', '888'),
(19, 'Bahrain', 'Riffa', 'Al Fateh Street', '999'),
(20, 'Oman', 'Nizwa', 'Al Aqr Street', '1000');

-- --------------------------------------------------------

--
-- Table structure for table `document`
--

CREATE TABLE `document` (
  `project_id` char(10) NOT NULL,
  `title` mediumtext NOT NULL,
  `document_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `project`
--

CREATE TABLE `project` (
  `id` char(10) NOT NULL,
  `title` mediumtext NOT NULL,
  `description` mediumtext NOT NULL,
  `customer` mediumtext NOT NULL,
  `budget` decimal(10,0) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `manager` int DEFAULT NULL,
  `team_leader` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `project`
--

INSERT INTO `project` (`id`, `title`, `description`, `customer`, `budget`, `start_date`, `end_date`, `manager`, `team_leader`) VALUES
('PROJ-10001', 'E-Commerce Platform', 'Develop a scalable e-commerce platform', 'ABC Company', 50000, '2025-01-01', '2025-06-30', 1, 6),
('PROJ-10002', 'Health Tracking App', 'Create a health tracking mobile app', 'XYZ Hospital', 30000, '2025-02-15', '2025-08-15', 2, 7),
('PROJ-10003', 'AI Chatbot', 'Build an AI-powered chatbot for customer service', 'DEF Corporation', 40000, '2025-03-01', '2025-09-30', 3, 8),
('PROJ-10004', 'ERP System', 'Implement an ERP system for a manufacturing company', 'GHI Industries', 60000, '2025-04-01', '2025-10-31', 4, 9),
('PROJ-10005', 'Online Learning Platform', 'Develop an online learning platform for schools', 'JKL Education', 45000, '2025-05-01', '2025-11-30', 5, 10),
('PROJ-10006', 'Smart Home System', 'Develop a smart home automation system', 'MNO Tech', 55000, '2025-06-01', '2025-12-31', 1, 6),
('PROJ-10007', 'Blockchain Payment Gateway', 'Build a blockchain-based payment gateway', 'PQR Fintech', 70000, '2025-07-01', '2026-01-31', 2, 7),
('PROJ-10008', 'AI-Powered Analytics', 'Create an AI-powered analytics platform', 'STU Analytics', 48000, '2025-08-01', '2026-02-28', 3, 8),
('PROJ-10009', 'Virtual Reality Training', 'Develop a VR training platform for employees', 'VWX Enterprises', 52000, '2025-09-01', '2026-03-31', 4, 9),
('PROJ-10010', 'Cybersecurity Suite', 'Build a comprehensive cybersecurity suite', 'YZ Security', 65000, '2025-10-01', '2026-04-30', 5, 10);

-- --------------------------------------------------------

--
-- Table structure for table `skill`
--

CREATE TABLE `skill` (
  `user_id` int NOT NULL,
  `skill_id` int NOT NULL,
  `skill` mediumtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `skill`
--

INSERT INTO `skill` (`user_id`, `skill_id`, `skill`) VALUES
(1, 1, 'Strategic Management'),
(1, 2, 'Business Development'),
(2, 3, 'Financial Analysis'),
(2, 4, 'Leadership'),
(3, 5, 'Marketing Strategy'),
(3, 6, 'Brand Management'),
(4, 7, 'Project Management'),
(4, 8, 'Risk Management'),
(5, 9, 'Human Resources Management'),
(5, 10, 'Organizational Behavior'),
(6, 11, 'Software Architecture'),
(6, 12, 'DevOps'),
(7, 13, 'Agile Methodology'),
(7, 14, 'Scrum Master'),
(8, 15, 'Data Science'),
(8, 16, 'Machine Learning'),
(9, 17, 'Cybersecurity'),
(9, 18, 'Network Security'),
(10, 19, 'Cloud Computing'),
(10, 20, 'AWS'),
(11, 21, 'Frontend Development'),
(11, 22, 'React.js'),
(12, 23, 'Backend Development'),
(12, 24, 'Node.js'),
(13, 25, 'Data Analysis'),
(13, 26, 'Python'),
(14, 27, 'Mobile App Development'),
(14, 28, 'Flutter'),
(15, 29, 'Database Management'),
(15, 30, 'SQL'),
(16, 31, 'UI/UX Design'),
(16, 32, 'Figma'),
(17, 33, 'Testing'),
(17, 34, 'Automation Testing'),
(18, 35, 'AI Development'),
(18, 36, 'TensorFlow'),
(19, 37, 'Blockchain'),
(19, 38, 'Smart Contracts'),
(20, 39, 'Game Development'),
(20, 40, 'Unity');

-- --------------------------------------------------------

--
-- Table structure for table `task`
--

CREATE TABLE `task` (
  `id` int NOT NULL,
  `name` mediumtext NOT NULL,
  `description` mediumtext NOT NULL,
  `project_id` char(10) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `effort` decimal(10,0) NOT NULL,
  `status` enum('Pending','In Progress','Completed') NOT NULL DEFAULT 'Pending',
  `priority` enum('Low','Medium','High') NOT NULL,
  `progress` decimal(10,0) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `task`
--

INSERT INTO `task` (`id`, `name`, `description`, `project_id`, `start_date`, `end_date`, `effort`, `status`, `priority`, `progress`) VALUES
(1, 'Design UI', 'Design user interface for e-commerce platform', 'PROJ-10001', '2025-01-01', '2025-01-15', 11, 'Completed', 'High', 100),
(2, 'Develop Backend', 'Implement backend functionality', 'PROJ-10001', '2025-01-16', '2025-02-28', 20, 'In Progress', 'Medium', 75),
(3, 'Test Application', 'Perform testing for the e-commerce platform', 'PROJ-10001', '2025-03-01', '2025-03-15', 15, 'Pending', 'High', 0),
(4, 'Deploy Platform', 'Deploy the platform to production', 'PROJ-10001', '2025-03-16', '2025-03-31', 5, 'Pending', 'Medium', 0),
(5, 'Monitor Performance', 'Monitor platform performance post-launch', 'PROJ-10001', '2025-04-01', '2025-04-15', 10, 'Pending', 'Low', 0),
(6, 'Optimize Database', 'Optimize database queries for better performance', 'PROJ-10001', '2025-04-16', '2025-04-30', 12, 'Pending', 'Medium', 0),
(7, 'Implement Payment Gateway', 'Integrate payment gateway for transactions', 'PROJ-10001', '2025-05-01', '2025-05-15', 18, 'Pending', 'High', 0),
(8, 'Add Search Functionality', 'Implement search functionality for products', 'PROJ-10001', '2025-05-16', '2025-05-31', 14, 'Pending', 'Medium', 0),
(9, 'Create Admin Panel', 'Develop an admin panel for managing the platform', 'PROJ-10001', '2025-06-01', '2025-06-15', 16, 'Pending', 'High', 0),
(10, 'Final Testing', 'Perform final testing before launch', 'PROJ-10001', '2025-06-16', '2025-06-30', 20, 'Pending', 'High', 0),
(11, 'Design App UI', 'Design user interface for health app', 'PROJ-10002', '2025-02-15', '2025-03-01', 12, 'Completed', 'High', 100),
(12, 'Develop Backend', 'Implement backend functionality', 'PROJ-10002', '2025-03-02', '2025-04-15', 25, 'In Progress', 'Medium', 60),
(13, 'Test App', 'Perform testing for the health app', 'PROJ-10002', '2025-04-16', '2025-05-01', 18, 'Pending', 'High', 0),
(14, 'Deploy App', 'Deploy the app to production', 'PROJ-10002', '2025-05-02', '2025-05-15', 6, 'Pending', 'Medium', 0),
(15, 'Monitor Usage', 'Monitor app usage post-launch', 'PROJ-10002', '2025-05-16', '2025-06-01', 10, 'Pending', 'Low', 0),
(16, 'Integrate Wearables', 'Integrate wearable device data into the app', 'PROJ-10002', '2025-06-02', '2025-06-15', 15, 'Pending', 'Medium', 0),
(17, 'Add Health Metrics', 'Implement tracking for health metrics', 'PROJ-10002', '2025-06-16', '2025-06-30', 14, 'Pending', 'High', 0),
(18, 'Create Dashboard', 'Develop a dashboard for users to view health data', 'PROJ-10002', '2025-07-01', '2025-07-15', 16, 'Pending', 'Medium', 0),
(19, 'Implement Notifications', 'Add push notifications for reminders', 'PROJ-10002', '2025-07-16', '2025-07-31', 12, 'Pending', 'High', 0),
(20, 'Final Testing', 'Perform final testing before launch', 'PROJ-10002', '2025-08-01', '2025-08-15', 20, 'Pending', 'High', 0),
(21, 'Design Chatbot Flow', 'Design conversation flow for chatbot', 'PROJ-10003', '2025-03-01', '2025-03-15', 10, 'Completed', 'High', 100),
(22, 'Develop NLP Model', 'Implement NLP model for chatbot', 'PROJ-10003', '2025-03-16', '2025-05-01', 30, 'In Progress', 'Medium', 50),
(23, 'Test Chatbot', 'Perform testing for the chatbot', 'PROJ-10003', '2025-05-02', '2025-05-15', 15, 'Pending', 'High', 0),
(24, 'Deploy Chatbot', 'Deploy the chatbot to production', 'PROJ-10003', '2025-05-16', '2025-05-31', 5, 'Pending', 'Medium', 0),
(25, 'Monitor Chatbot', 'Monitor chatbot performance post-launch', 'PROJ-10003', '2025-06-01', '2025-06-15', 10, 'Pending', 'Low', 0),
(26, 'Integrate APIs', 'Integrate third-party APIs for chatbot functionality', 'PROJ-10003', '2025-06-16', '2025-06-30', 18, 'Pending', 'Medium', 0),
(27, 'Add Multilingual Support', 'Implement multilingual support for the chatbot', 'PROJ-10003', '2025-07-01', '2025-07-15', 14, 'Pending', 'High', 0),
(28, 'Create Admin Panel', 'Develop an admin panel for managing the chatbot', 'PROJ-10003', '2025-07-16', '2025-07-31', 16, 'Pending', 'Medium', 0),
(29, 'Implement Analytics', 'Add analytics to track chatbot usage', 'PROJ-10003', '2025-08-01', '2025-08-15', 12, 'Pending', 'High', 0),
(30, 'Final Testing', 'Perform final testing before launch', 'PROJ-10003', '2025-08-16', '2025-08-31', 20, 'Pending', 'High', 0),
(31, 'Analyze Requirements', 'Analyze requirements for ERP system', 'PROJ-10004', '2025-04-01', '2025-04-15', 15, 'Completed', 'High', 100),
(32, 'Develop Modules', 'Implement ERP system modules', 'PROJ-10004', '2025-04-16', '2025-07-15', 40, 'In Progress', 'Medium', 40),
(33, 'Test System', 'Perform testing for the ERP system', 'PROJ-10004', '2025-07-16', '2025-08-01', 20, 'Pending', 'High', 0),
(34, 'Deploy System', 'Deploy the ERP system to production', 'PROJ-10004', '2025-08-02', '2025-08-15', 10, 'Pending', 'Medium', 0),
(35, 'Monitor System', 'Monitor ERP system performance post-launch', 'PROJ-10004', '2025-08-16', '2025-09-01', 15, 'Pending', 'Low', 0),
(36, 'Integrate Accounting', 'Integrate accounting module into ERP system', 'PROJ-10004', '2025-09-02', '2025-09-15', 18, 'Pending', 'Medium', 0),
(37, 'Add Inventory Management', 'Implement inventory management module', 'PROJ-10004', '2025-09-16', '2025-09-30', 14, 'Pending', 'High', 0),
(38, 'Create Reporting Tools', 'Develop reporting tools for ERP system', 'PROJ-10004', '2025-10-01', '2025-10-15', 16, 'Pending', 'Medium', 0),
(39, 'Implement Security', 'Add security features to ERP system', 'PROJ-10004', '2025-10-16', '2025-10-31', 12, 'Pending', 'High', 0),
(40, 'Final Testing', 'Perform final testing before launch', 'PROJ-10004', '2025-11-01', '2025-11-15', 20, 'Pending', 'High', 0),
(41, 'Design Platform UI', 'Design user interface for learning platform', 'PROJ-10005', '2025-05-01', '2025-05-15', 12, 'Completed', 'High', 100),
(42, 'Develop Backend', 'Implement backend functionality', 'PROJ-10005', '2025-05-16', '2025-07-15', 35, 'In Progress', 'Medium', 50),
(43, 'Test Platform', 'Perform testing for the learning platform', 'PROJ-10005', '2025-07-16', '2025-08-01', 18, 'Pending', 'High', 0),
(44, 'Deploy Platform', 'Deploy the platform to production', 'PROJ-10005', '2025-08-02', '2025-08-15', 8, 'Pending', 'Medium', 0),
(45, 'Monitor Usage', 'Monitor platform usage post-launch', 'PROJ-10005', '2025-08-16', '2025-09-01', 12, 'Pending', 'Low', 0),
(46, 'Add Course Management', 'Implement course management functionality', 'PROJ-10005', '2025-09-02', '2025-09-15', 15, 'Pending', 'Medium', 0),
(47, 'Integrate Payment System', 'Add payment system for course purchases', 'PROJ-10005', '2025-09-16', '2025-09-30', 14, 'Pending', 'High', 0),
(48, 'Create Admin Panel', 'Develop an admin panel for managing the platform', 'PROJ-10005', '2025-10-01', '2025-10-15', 16, 'Pending', 'Medium', 0),
(49, 'Implement Analytics', 'Add analytics to track platform usage', 'PROJ-10005', '2025-10-16', '2025-10-31', 12, 'Pending', 'High', 0),
(50, 'Final Testing', 'Perform final testing before launch', 'PROJ-10005', '2025-11-01', '2025-11-15', 20, 'Pending', 'High', 0),
(51, 'Design System Architecture', 'Design architecture for smart home system', 'PROJ-10006', '2025-06-01', '2025-06-15', 12, 'Completed', 'High', 100),
(52, 'Develop Backend', 'Implement backend functionality', 'PROJ-10006', '2025-06-16', '2025-08-15', 25, 'In Progress', 'Medium', 60),
(53, 'Test System', 'Perform testing for the smart home system', 'PROJ-10006', '2025-08-16', '2025-09-01', 18, 'Pending', 'High', 0),
(54, 'Deploy System', 'Deploy the system to production', 'PROJ-10006', '2025-09-02', '2025-09-15', 6, 'Pending', 'Medium', 0),
(55, 'Monitor Performance', 'Monitor system performance post-launch', 'PROJ-10006', '2025-09-16', '2025-10-01', 10, 'Pending', 'Low', 0),
(56, 'Integrate IoT Devices', 'Integrate IoT devices into the system', 'PROJ-10006', '2025-10-02', '2025-10-15', 15, 'Pending', 'Medium', 0),
(57, 'Add Voice Control', 'Implement voice control functionality', 'PROJ-10006', '2025-10-16', '2025-10-31', 14, 'Pending', 'High', 0),
(58, 'Create Mobile App', 'Develop a mobile app for controlling the system', 'PROJ-10006', '2025-11-01', '2025-11-15', 16, 'Pending', 'Medium', 0),
(59, 'Implement Security', 'Add security features to the system', 'PROJ-10006', '2025-11-16', '2025-11-30', 12, 'Pending', 'High', 0),
(60, 'Final Testing', 'Perform final testing before launch', 'PROJ-10006', '2025-12-01', '2025-12-15', 20, 'Pending', 'High', 0),
(61, 'Design System Architecture', 'Design architecture for blockchain payment gateway', 'PROJ-10007', '2025-07-01', '2025-07-15', 12, 'Completed', 'High', 100),
(62, 'Develop Smart Contracts', 'Implement smart contracts for payments', 'PROJ-10007', '2025-07-16', '2025-09-15', 25, 'In Progress', 'Medium', 60),
(63, 'Test System', 'Perform testing for the payment gateway', 'PROJ-10007', '2025-09-16', '2025-10-01', 18, 'Pending', 'High', 0),
(64, 'Deploy System', 'Deploy the system to production', 'PROJ-10007', '2025-10-02', '2025-10-15', 6, 'Pending', 'Medium', 0),
(65, 'Monitor Performance', 'Monitor system performance post-launch', 'PROJ-10007', '2025-10-16', '2025-11-01', 10, 'Pending', 'Low', 0),
(66, 'Integrate Wallets', 'Integrate cryptocurrency wallets into the system', 'PROJ-10007', '2025-11-02', '2025-11-15', 15, 'Pending', 'Medium', 0),
(67, 'Add Fraud Detection', 'Implement fraud detection mechanisms', 'PROJ-10007', '2025-11-16', '2025-11-30', 14, 'Pending', 'High', 0),
(68, 'Create Admin Panel', 'Develop an admin panel for managing the system', 'PROJ-10007', '2025-12-01', '2025-12-15', 16, 'Pending', 'Medium', 0),
(69, 'Implement Analytics', 'Add analytics to track system usage', 'PROJ-10007', '2025-12-16', '2025-12-31', 12, 'Pending', 'High', 0),
(70, 'Final Testing', 'Perform final testing before launch', 'PROJ-10007', '2026-01-01', '2026-01-15', 20, 'Pending', 'High', 0),
(71, 'Design System Architecture', 'Design architecture for AI-powered analytics platform', 'PROJ-10008', '2025-08-01', '2025-08-15', 12, 'Completed', 'High', 100),
(72, 'Develop AI Models', 'Implement AI models for analytics', 'PROJ-10008', '2025-08-16', '2025-10-15', 25, 'In Progress', 'Medium', 60),
(73, 'Test System', 'Perform testing for the analytics platform', 'PROJ-10008', '2025-10-16', '2025-11-01', 18, 'Pending', 'High', 0),
(74, 'Deploy System', 'Deploy the system to production', 'PROJ-10008', '2025-11-02', '2025-11-15', 6, 'Pending', 'Medium', 0),
(75, 'Monitor Performance', 'Monitor system performance post-launch', 'PROJ-10008', '2025-11-16', '2025-12-01', 10, 'Pending', 'Low', 0),
(76, 'Integrate Data Sources', 'Integrate data sources into the platform', 'PROJ-10008', '2025-12-02', '2025-12-15', 15, 'Pending', 'Medium', 0),
(77, 'Add Visualization Tools', 'Implement data visualization tools', 'PROJ-10008', '2025-12-16', '2025-12-31', 14, 'Pending', 'High', 0),
(78, 'Create Admin Panel', 'Develop an admin panel for managing the platform', 'PROJ-10008', '2026-01-01', '2026-01-15', 16, 'Pending', 'Medium', 0),
(79, 'Implement Security', 'Add security features to the platform', 'PROJ-10008', '2026-01-16', '2026-01-31', 12, 'Pending', 'High', 0),
(80, 'Final Testing', 'Perform final testing before launch', 'PROJ-10008', '2026-02-01', '2026-02-15', 20, 'Pending', 'High', 0),
(81, 'Design VR Environment', 'Design virtual reality environment for training', 'PROJ-10009', '2025-09-01', '2025-09-15', 12, 'Completed', 'High', 100),
(82, 'Develop VR Modules', 'Implement VR training modules', 'PROJ-10009', '2025-09-16', '2025-11-15', 25, 'In Progress', 'Medium', 60),
(83, 'Test System', 'Perform testing for the VR training platform', 'PROJ-10009', '2025-11-16', '2025-12-01', 18, 'Pending', 'High', 0),
(84, 'Deploy System', 'Deploy the system to production', 'PROJ-10009', '2025-12-02', '2025-12-15', 6, 'Pending', 'Medium', 0),
(85, 'Monitor Performance', 'Monitor system performance post-launch', 'PROJ-10009', '2025-12-16', '2026-01-01', 10, 'Pending', 'Low', 0),
(86, 'Integrate Training Content', 'Integrate training content into the platform', 'PROJ-10009', '2026-01-02', '2026-01-15', 15, 'Pending', 'Medium', 0),
(87, 'Add Multiplayer Support', 'Implement multiplayer support for training', 'PROJ-10009', '2026-01-16', '2026-01-31', 14, 'Pending', 'High', 0),
(88, 'Create Admin Panel', 'Develop an admin panel for managing the platform', 'PROJ-10009', '2026-02-01', '2026-02-15', 16, 'Pending', 'Medium', 0),
(89, 'Implement Analytics', 'Add analytics to track platform usage', 'PROJ-10009', '2026-02-16', '2026-02-28', 12, 'Pending', 'High', 0),
(90, 'Final Testing', 'Perform final testing before launch', 'PROJ-10009', '2026-03-01', '2026-03-15', 20, 'Pending', 'High', 0),
(91, 'Design System Architecture', 'Design architecture for cybersecurity suite', 'PROJ-10010', '2025-10-01', '2025-10-15', 12, 'Completed', 'High', 100),
(92, 'Develop Security Modules', 'Implement security modules for the suite', 'PROJ-10010', '2025-10-16', '2025-12-15', 25, 'In Progress', 'Medium', 60),
(93, 'Test System', 'Perform testing for the cybersecurity suite', 'PROJ-10010', '2025-12-16', '2026-01-01', 18, 'Pending', 'High', 0),
(94, 'Deploy System', 'Deploy the system to production', 'PROJ-10010', '2026-01-02', '2026-01-15', 6, 'Pending', 'Medium', 0),
(95, 'Monitor Performance', 'Monitor system performance post-launch', 'PROJ-10010', '2026-01-16', '2026-02-01', 10, 'Pending', 'Low', 0),
(96, 'Integrate Threat Detection', 'Integrate threat detection mechanisms', 'PROJ-10010', '2026-02-02', '2026-02-15', 15, 'Pending', 'Medium', 0),
(97, 'Add Firewall', 'Implement firewall functionality', 'PROJ-10010', '2026-02-16', '2026-02-28', 14, 'Pending', 'High', 0),
(98, 'Create Admin Panel', 'Develop an admin panel for managing the suite', 'PROJ-10010', '2026-03-01', '2026-03-15', 16, 'Pending', 'Medium', 0),
(99, 'Implement Analytics', 'Add analytics to track system usage', 'PROJ-10010', '2026-03-16', '2026-03-31', 12, 'Pending', 'High', 0),
(100, 'Final Testing', 'Perform final testing before launch', 'PROJ-10010', '2026-04-01', '2026-04-15', 20, 'Pending', 'High', 0);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int NOT NULL,
  `name` mediumtext NOT NULL,
  `dob` date NOT NULL,
  `email` mediumtext NOT NULL,
  `phone` char(10) NOT NULL,
  `role` enum('Manager','Project Leader','Team Member') NOT NULL DEFAULT 'Team Member',
  `qualification` mediumtext NOT NULL,
  `username` char(13) NOT NULL,
  `password` mediumtext NOT NULL,
  `image` varchar(30) NOT NULL DEFAULT 'user_profile.jpg',
  `ssn` mediumtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `name`, `dob`, `email`, `phone`, `role`, `qualification`, `username`, `password`, `image`, `ssn`) VALUES
(1, 'Mohammed Ahmed', '1980-10-10', 'mohammed.ahmed@example.com', '1231231234', 'Manager', 'PhD in Business Administration', 'manager', 'manager1111', 'user_profile.jpg', '111-22-3333'),
(2, 'Ali Hassan', '1985-05-15', 'ali.hassan@example.com', '2342342345', 'Manager', 'MBA in Finance', 'ali_mgr', 'manager2222', 'user_profile.jpg', '222-33-4444'),
(3, 'Fatima Khalid', '1978-03-20', 'fatima.khalid@example.com', '3453453456', 'Manager', 'PhD in Marketing', 'fatima_mgr', 'manager3333', 'user_profile.jpg', '333-44-5555'),
(4, 'Omar Saleh', '1982-07-25', 'omar.saleh@example.com', '4564564567', 'Manager', 'MSc in Project Management', 'omar_mgr', 'manager4444', 'user_profile.jpg', '444-55-6666'),
(5, 'Layla Abdullah', '1975-12-30', 'layla.abdullah@example.com', '5675675678', 'Manager', 'PhD in Human Resources', 'layla_mgr', 'manager5555', 'user_profile.jpg', '555-66-7777'),
(6, 'Sami Hassan', '1987-07-07', 'sami.hassan@example.com', '6786786789', 'Project Leader', 'MSc in Software Engineering', 'leader', 'leader1111', 'user_profile.jpg', '666-77-8888'),
(7, 'Yousef Ahmed', '1990-09-12', 'yousef.ahmed@example.com', '7897897890', 'Project Leader', 'BSc in Computer Science', 'yousef_ldr', 'leader2222', 'user_profile.jpg', '777-88-9999'),
(8, 'Noura Ali', '1988-04-18', 'noura.ali@example.com', '8908908901', 'Project Leader', 'MSc in Data Science', 'noura_ldr', 'leader3333', 'user_profile.jpg', '888-99-0000'),
(9, 'Khalid Mahmoud', '1992-11-05', 'khalid.mahmoud@example.com', '9019019012', 'Project Leader', 'BSc in Information Technology', 'khalid_ldr', 'leader4444', 'user_profile.jpg', '999-00-1111'),
(10, 'Huda Salem', '1991-06-22', 'huda.salem@example.com', '0120120123', 'Project Leader', 'MSc in Cybersecurity', 'huda_ldr', 'leader5555', 'user_profile.jpg', '000-11-2222'),
(11, 'Rana Khalid', '1999-12-12', 'rana.khalid@example.com', '1231231234', 'Team Member', 'BSc in Computer Science', 'member1', 'member1111', 'user_profile.jpg', '111-22-3333'),
(12, 'Ahmed Samir', '1995-08-14', 'ahmed.samir@example.com', '2342342345', 'Team Member', 'BSc in Software Engineering', 'member2', 'member2222', 'user_profile.jpg', '222-33-4444'),
(13, 'Sara Omar', '1998-02-28', 'sara.omar@example.com', '3453453456', 'Team Member', 'BSc in Data Science', 'member3', 'member3333', 'user_profile.jpg', '333-44-5555'),
(14, 'Faisal Ibrahim', '1996-07-19', 'faisal.ibrahim@example.com', '4564564567', 'Team Member', 'BSc in Information Technology', 'faisal_mem', 'member4444', 'user_profile.jpg', '444-55-6666'),
(15, 'Lina Tariq', '1997-05-10', 'lina.tariq@example.com', '5675675678', 'Team Member', 'BSc in Cybersecurity', 'lina_mem', 'member5555', 'user_profile.jpg', '555-66-7777'),
(16, 'Kareem Adel', '1994-09-03', 'kareem.adel@example.com', '6786786789', 'Team Member', 'BSc in Computer Science', 'kareem_mem', 'member6666', 'user_profile.jpg', '666-77-8888'),
(17, 'Nada Hisham', '1993-03-17', 'nada.hisham@example.com', '7897897890', 'Team Member', 'BSc in Software Engineering', 'nada_mem', 'member7777', 'user_profile.jpg', '777-88-9999'),
(18, 'Tariq Fahad', '1992-11-25', 'tariq.fahad@example.com', '8908908901', 'Team Member', 'BSc in Data Science', 'tariq_mem', 'member8888', 'user_profile.jpg', '888-99-0000'),
(19, 'Maha Salim', '1991-06-30', 'maha.salim@example.com', '9019019012', 'Team Member', 'BSc in Information Technology', 'maha_mem', 'member9999', 'user_profile.jpg', '999-00-1111'),
(20, 'Yara Faisal', '1990-04-12', 'yara.faisal@example.com', '0120120123', 'Team Member', 'BSc in Cybersecurity', 'yara_mem', 'member0000', 'user_profile.jpg', '000-11-2222');

-- --------------------------------------------------------

--
-- Table structure for table `user_task`
--

CREATE TABLE `user_task` (
  `user_id` int NOT NULL,
  `task_id` int NOT NULL,
  `role` enum('Developer','Tester','Analyst','Designer') NOT NULL,
  `contribution` decimal(10,0) NOT NULL,
  `accepted` tinyint(1) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `user_task`
--

INSERT INTO `user_task` (`user_id`, `task_id`, `role`, `contribution`, `accepted`, `start_date`, `end_date`) VALUES
(11, 1, 'Designer', 50, 1, '2025-01-01', '2025-01-15'),
(11, 9, 'Designer', 50, 1, '2025-02-15', '2025-03-01'),
(11, 17, 'Designer', 50, 1, '2025-03-01', '2025-03-15'),
(11, 25, 'Designer', 50, 1, '2025-04-01', '2025-04-15'),
(11, 33, 'Designer', 50, 1, '2025-05-01', '2025-05-15'),
(11, 41, 'Designer', 50, 1, '2025-06-01', '2025-06-15'),
(11, 49, 'Designer', 50, 1, '2025-07-01', '2025-07-15'),
(11, 57, 'Designer', 50, 1, '2025-08-01', '2025-08-15'),
(11, 65, 'Designer', 50, 1, '2025-09-01', '2025-09-15'),
(11, 73, 'Designer', 50, 1, '2025-10-01', '2025-10-15'),
(12, 1, 'Developer', 50, 1, '2025-01-01', '2025-01-15'),
(12, 9, 'Developer', 50, 1, '2025-02-15', '2025-03-01'),
(12, 17, 'Developer', 50, 1, '2025-03-01', '2025-03-15'),
(12, 25, 'Developer', 50, 1, '2025-04-01', '2025-04-15'),
(12, 33, 'Developer', 50, 1, '2025-05-01', '2025-05-15'),
(12, 41, 'Developer', 50, 1, '2025-06-01', '2025-06-15'),
(12, 49, 'Developer', 50, 1, '2025-07-01', '2025-07-15'),
(12, 57, 'Developer', 50, 1, '2025-08-01', '2025-08-15'),
(12, 65, 'Developer', 50, 1, '2025-09-01', '2025-09-15'),
(12, 73, 'Developer', 50, 1, '2025-10-01', '2025-10-15'),
(13, 2, 'Developer', 70, 1, '2025-01-16', '2025-02-28'),
(13, 10, 'Developer', 70, 1, '2025-03-02', '2025-04-15'),
(13, 18, 'Developer', 70, 1, '2025-03-16', '2025-05-01'),
(13, 26, 'Developer', 70, 1, '2025-04-16', '2025-07-15'),
(13, 34, 'Developer', 70, 1, '2025-05-16', '2025-07-15'),
(13, 42, 'Developer', 70, 1, '2025-06-16', '2025-08-15'),
(13, 50, 'Developer', 70, 1, '2025-07-16', '2025-09-15'),
(13, 58, 'Developer', 70, 1, '2025-08-16', '2025-10-15'),
(13, 66, 'Developer', 70, 1, '2025-09-16', '2025-11-15'),
(13, 74, 'Developer', 70, 1, '2025-10-16', '2025-12-15'),
(14, 2, 'Tester', 30, 1, '2025-01-16', '2025-02-28'),
(14, 10, 'Tester', 30, 1, '2025-03-02', '2025-04-15'),
(14, 18, 'Tester', 30, 1, '2025-03-16', '2025-05-01'),
(14, 26, 'Tester', 30, 1, '2025-04-16', '2025-07-15'),
(14, 34, 'Tester', 30, 1, '2025-05-16', '2025-07-15'),
(14, 42, 'Tester', 30, 1, '2025-06-16', '2025-08-15'),
(14, 50, 'Tester', 30, 1, '2025-07-16', '2025-09-15'),
(14, 58, 'Tester', 30, 1, '2025-08-16', '2025-10-15'),
(14, 66, 'Tester', 30, 1, '2025-09-16', '2025-11-15'),
(14, 74, 'Tester', 30, 1, '2025-10-16', '2025-12-15'),
(15, 3, 'Tester', 100, 1, '2025-03-01', '2025-03-15'),
(15, 11, 'Tester', 100, 1, '2025-04-16', '2025-05-01'),
(15, 19, 'Tester', 100, 1, '2025-05-02', '2025-05-15'),
(15, 27, 'Tester', 100, 1, '2025-07-16', '2025-08-01'),
(15, 35, 'Tester', 100, 1, '2025-07-16', '2025-08-01'),
(15, 43, 'Tester', 100, 1, '2025-08-16', '2025-09-01'),
(15, 51, 'Tester', 100, 1, '2025-09-16', '2025-10-01'),
(15, 59, 'Tester', 100, 1, '2025-10-16', '2025-11-01'),
(15, 67, 'Tester', 100, 1, '2025-11-16', '2025-12-01'),
(15, 75, 'Tester', 100, 1, '2025-12-16', '2026-01-01'),
(16, 4, 'Developer', 100, 1, '2025-03-16', '2025-03-31'),
(16, 12, 'Developer', 100, 1, '2025-05-02', '2025-05-15'),
(16, 20, 'Developer', 100, 1, '2025-05-16', '2025-05-31'),
(16, 28, 'Developer', 100, 1, '2025-08-02', '2025-08-15'),
(16, 36, 'Developer', 100, 1, '2025-08-02', '2025-08-15'),
(16, 44, 'Developer', 100, 1, '2025-09-02', '2025-09-15'),
(16, 52, 'Developer', 100, 1, '2025-10-02', '2025-10-15'),
(16, 60, 'Developer', 100, 1, '2025-11-02', '2025-11-15'),
(16, 68, 'Developer', 100, 1, '2025-12-02', '2025-12-15'),
(16, 76, 'Developer', 100, 1, '2026-01-02', '2026-01-15'),
(17, 5, 'Developer', 100, 1, '2025-04-01', '2025-04-15'),
(17, 13, 'Developer', 100, 1, '2025-05-16', '2025-06-01'),
(17, 21, 'Developer', 100, 1, '2025-06-01', '2025-06-15'),
(17, 29, 'Developer', 100, 1, '2025-08-16', '2025-09-01'),
(17, 37, 'Developer', 100, 1, '2025-08-16', '2025-09-01'),
(17, 45, 'Developer', 100, 1, '2025-09-16', '2025-10-01'),
(17, 53, 'Developer', 100, 1, '2025-10-16', '2025-11-01'),
(17, 61, 'Developer', 100, 1, '2025-11-16', '2026-01-01'),
(17, 69, 'Developer', 100, 1, '2025-12-16', '2026-01-01'),
(17, 77, 'Developer', 100, 1, '2026-01-16', '2026-02-01'),
(18, 6, 'Developer', 100, 1, '2025-04-16', '2025-04-30'),
(18, 14, 'Developer', 100, 1, '2025-06-02', '2025-06-15'),
(18, 22, 'Developer', 100, 1, '2025-06-16', '2025-06-30'),
(18, 30, 'Developer', 100, 1, '2025-09-02', '2025-09-15'),
(18, 38, 'Developer', 100, 1, '2025-09-02', '2025-09-15'),
(18, 46, 'Developer', 100, 1, '2025-10-02', '2025-10-15'),
(18, 54, 'Developer', 100, 1, '2025-11-02', '2025-11-15'),
(18, 62, 'Developer', 100, 1, '2026-01-02', '2026-01-15'),
(18, 70, 'Developer', 100, 1, '2026-01-02', '2026-01-15'),
(18, 78, 'Developer', 100, 1, '2026-02-02', '2026-02-15'),
(19, 7, 'Developer', 100, 1, '2025-05-01', '2025-05-15'),
(19, 15, 'Developer', 100, 1, '2025-06-16', '2025-06-30'),
(19, 23, 'Developer', 100, 1, '2025-07-01', '2025-07-15'),
(19, 31, 'Developer', 100, 1, '2025-09-16', '2025-09-30'),
(19, 39, 'Developer', 100, 1, '2025-09-16', '2025-09-30'),
(19, 47, 'Developer', 100, 1, '2025-10-16', '2025-10-31'),
(19, 55, 'Developer', 100, 1, '2025-11-16', '2025-11-30'),
(19, 63, 'Developer', 100, 1, '2026-01-16', '2026-01-31'),
(19, 71, 'Developer', 100, 1, '2026-01-16', '2026-01-31'),
(19, 79, 'Developer', 100, 1, '2026-02-16', '2026-02-28'),
(20, 8, 'Developer', 100, 1, '2025-05-16', '2025-05-31'),
(20, 16, 'Developer', 100, 1, '2025-07-01', '2025-07-15'),
(20, 24, 'Developer', 100, 1, '2025-07-16', '2025-07-31'),
(20, 32, 'Developer', 100, 1, '2025-10-01', '2025-10-15'),
(20, 40, 'Developer', 100, 1, '2025-10-01', '2025-10-15'),
(20, 48, 'Developer', 100, 1, '2025-11-01', '2025-11-15'),
(20, 56, 'Developer', 100, 1, '2025-12-01', '2025-12-15'),
(20, 64, 'Developer', 100, 1, '2026-02-01', '2026-02-15'),
(20, 72, 'Developer', 100, 1, '2026-02-01', '2026-02-15'),
(20, 80, 'Developer', 100, 1, '2026-03-01', '2026-03-15');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `address`
--
ALTER TABLE `address`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `document`
--
ALTER TABLE `document`
  ADD PRIMARY KEY (`document_id`),
  ADD KEY `project_id` (`project_id`);

--
-- Indexes for table `project`
--
ALTER TABLE `project`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `manager` (`manager`),
  ADD KEY `team_leader` (`team_leader`);

--
-- Indexes for table `skill`
--
ALTER TABLE `skill`
  ADD PRIMARY KEY (`skill_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `task`
--
ALTER TABLE `task`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `project_id` (`project_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `user_task`
--
ALTER TABLE `user_task`
  ADD PRIMARY KEY (`user_id`,`task_id`),
  ADD KEY `task_id` (`task_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `document`
--
ALTER TABLE `document`
  MODIFY `document_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `skill`
--
ALTER TABLE `skill`
  MODIFY `skill_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `task`
--
ALTER TABLE `task`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=101;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `address`
--
ALTER TABLE `address`
  ADD CONSTRAINT `address_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `document`
--
ALTER TABLE `document`
  ADD CONSTRAINT `document_ibfk_1` FOREIGN KEY (`project_id`) REFERENCES `project` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `project`
--
ALTER TABLE `project`
  ADD CONSTRAINT `project_ibfk_1` FOREIGN KEY (`manager`) REFERENCES `user` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `project_ibfk_2` FOREIGN KEY (`team_leader`) REFERENCES `user` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `skill`
--
ALTER TABLE `skill`
  ADD CONSTRAINT `skill_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `task`
--
ALTER TABLE `task`
  ADD CONSTRAINT `task_ibfk_1` FOREIGN KEY (`project_id`) REFERENCES `project` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user_task`
--
ALTER TABLE `user_task`
  ADD CONSTRAINT `user_task_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_task_ibfk_2` FOREIGN KEY (`task_id`) REFERENCES `task` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
