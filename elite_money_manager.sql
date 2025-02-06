-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 06, 2025 at 09:17 AM
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
-- Database: `elite_money_manager`
--

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

CREATE TABLE `accounts` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL,
  `account_uuid` text NOT NULL,
  `current_balance` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `accounts`
--

INSERT INTO `accounts` (`id`, `name`, `account_uuid`, `current_balance`, `user_id`, `deleted`) VALUES
(1, 'House Rent', '677302cb8b0ddad29cbdef8fb2738b77', 0, 1, 0),
(2, 'Office Rent', '67730350d4eee31c4bc195602dc71ad7', 0, 1, 0),
(3, 'Postal Rent', '6773035a075946977b34081af516e757', 0, 1, 0),
(4, 'Helb', '6773037f742365fadda629e4315a8018', 0, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `automations`
--

CREATE TABLE `automations` (
  `id` int(11) NOT NULL,
  `name` tinytext NOT NULL,
  `automation_type_id` int(11) NOT NULL DEFAULT 1,
  `payment_method_id` int(11) NOT NULL,
  `mpesa_phone_number` tinytext NOT NULL,
  `target_amount` int(11) NOT NULL,
  `account_uuid` text NOT NULL,
  `regular_deposit_amount` int(11) NOT NULL,
  `time_of_the_day` time NOT NULL,
  `user_id` int(11) NOT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `automations`
--

INSERT INTO `automations` (`id`, `name`, `automation_type_id`, `payment_method_id`, `mpesa_phone_number`, `target_amount`, `account_uuid`, `regular_deposit_amount`, `time_of_the_day`, `user_id`, `deleted`) VALUES
(1, 'House Rent Automation', 1, 1, '254717551542', 20000, '677302cb8b0ddad29cbdef8fb2738b77', 2000, '12:00:00', 1, 0),
(2, 'Office Rent Automation', 1, 1, '254717551542', 2000, '67730350d4eee31c4bc195602dc71ad7', 200, '11:00:00', 1, 0),
(3, 'Postal Rent Automation', 1, 0, '254717551542', 20000, '6773035a075946977b34081af516e757', 2000, '10:00:00', 1, 0),
(4, 'Helb Automation', 1, 0, '254717551542', 20000, '6773037f742365fadda629e4315a8018', 2000, '10:00:00', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `automation_types`
--

CREATE TABLE `automation_types` (
  `id` int(11) NOT NULL,
  `name` tinytext NOT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `automation_types`
--

INSERT INTO `automation_types` (`id`, `name`, `deleted`) VALUES
(1, 'deposit', 0),
(2, 'payment', 0),
(3, 'withdrawal', 0);

-- --------------------------------------------------------

--
-- Table structure for table `daily_automations`
--

CREATE TABLE `daily_automations` (
  `id` int(11) NOT NULL,
  `day_id` int(11) NOT NULL,
  `automation_id` int(11) NOT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `daily_automations`
--

INSERT INTO `daily_automations` (`id`, `day_id`, `automation_id`, `deleted`) VALUES
(1, 1, 2, 1),
(2, 3, 2, 1),
(3, 5, 2, 1),
(4, 1, 2, 1),
(5, 3, 2, 1),
(6, 5, 2, 1),
(7, 1, 2, 1),
(8, 3, 2, 1),
(9, 5, 2, 1),
(10, 1, 1, 1),
(11, 1, 2, 1),
(12, 3, 2, 1),
(13, 5, 2, 1),
(14, 1, 2, 1),
(15, 3, 2, 1),
(16, 5, 2, 1),
(17, 1, 2, 1),
(18, 3, 2, 1),
(19, 5, 2, 1),
(20, 1, 2, 1),
(21, 3, 2, 1),
(22, 5, 2, 1),
(23, 1, 2, 1),
(24, 3, 2, 1),
(25, 5, 2, 1),
(26, 1, 2, 1),
(27, 3, 2, 1),
(28, 5, 2, 1),
(29, 1, 2, 1),
(30, 3, 2, 1),
(31, 5, 2, 1),
(32, 1, 2, 1),
(33, 3, 2, 1),
(34, 5, 2, 1),
(35, 1, 2, 1),
(36, 3, 2, 1),
(37, 5, 2, 1),
(38, 1, 2, 1),
(39, 3, 2, 1),
(40, 5, 2, 1),
(41, 1, 2, 1),
(42, 3, 2, 1),
(43, 5, 2, 1),
(44, 1, 2, 1),
(45, 3, 2, 1),
(46, 5, 2, 1),
(47, 1, 2, 1),
(48, 3, 2, 1),
(49, 5, 2, 1),
(50, 1, 2, 0),
(51, 3, 2, 0),
(52, 5, 2, 0),
(53, 1, 3, 0),
(54, 4, 3, 0),
(55, 1, 4, 0),
(56, 3, 4, 0);

-- --------------------------------------------------------

--
-- Table structure for table `initiated_automations`
--

CREATE TABLE `initiated_automations` (
  `id` int(11) NOT NULL,
  `automation_id` int(11) NOT NULL,
  `monthly_automation_id` int(11) NOT NULL,
  `daily_automation_id` int(11) NOT NULL,
  `mpesa_transaction_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `initiated_automations`
--

INSERT INTO `initiated_automations` (`id`, `automation_id`, `monthly_automation_id`, `daily_automation_id`, `mpesa_transaction_id`) VALUES
(1, 1, 70, 0, 1),
(2, 1, 72, 0, 2),
(3, 1, 70, 0, 3),
(4, 1, 71, 0, 4),
(5, 1, 72, 0, 5),
(6, 1, 70, 0, 0),
(7, 1, 71, 0, 0),
(8, 1, 72, 0, 0),
(9, 1, 70, 0, 9),
(10, 1, 71, 0, 10),
(11, 1, 72, 0, 11),
(12, 2, 0, 0, 12),
(13, 2, 0, 0, 13),
(14, 2, 0, 0, 14),
(15, 2, 0, 0, 15),
(16, 2, 0, 50, 16),
(17, 2, 0, 51, 17),
(18, 2, 0, 51, 18),
(19, 2, 0, 52, 19),
(20, 2, 0, 50, 20),
(21, 2, 0, 51, 21),
(22, 2, 0, 51, 22),
(23, 2, 0, 52, 23);

-- --------------------------------------------------------

--
-- Table structure for table `monthly_automations`
--

CREATE TABLE `monthly_automations` (
  `id` int(11) NOT NULL,
  `date` int(11) NOT NULL,
  `automation_id` int(11) NOT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `monthly_automations`
--

INSERT INTO `monthly_automations` (`id`, `date`, `automation_id`, `deleted`) VALUES
(1, 1, 1, 1),
(2, 2, 1, 1),
(3, 3, 1, 1),
(4, 1, 1, 1),
(5, 2, 1, 1),
(6, 3, 1, 1),
(7, 1, 1, 1),
(8, 2, 1, 1),
(9, 3, 1, 1),
(10, 1, 1, 1),
(11, 2, 1, 1),
(12, 3, 1, 1),
(13, 1, 1, 1),
(14, 2, 1, 1),
(15, 3, 1, 1),
(16, 1, 1, 1),
(17, 2, 1, 1),
(18, 3, 1, 1),
(19, 1, 1, 1),
(20, 2, 1, 1),
(21, 3, 1, 1),
(22, 1, 1, 1),
(23, 2, 1, 1),
(24, 3, 1, 1),
(25, 4, 1, 1),
(26, 2, 1, 1),
(27, 3, 1, 1),
(28, 4, 1, 1),
(29, 2, 1, 1),
(30, 4, 1, 1),
(31, 2, 1, 1),
(32, 4, 1, 1),
(33, 6, 1, 1),
(34, 2, 1, 1),
(35, 4, 1, 1),
(36, 6, 1, 1),
(37, 2, 1, 1),
(38, 4, 1, 1),
(39, 6, 1, 1),
(40, 2, 1, 1),
(41, 4, 1, 1),
(42, 6, 1, 1),
(43, 2, 1, 1),
(44, 4, 1, 1),
(45, 6, 1, 1),
(46, 2, 1, 1),
(47, 4, 1, 1),
(48, 6, 1, 1),
(49, 2, 1, 1),
(50, 4, 1, 1),
(51, 6, 1, 1),
(52, 2, 1, 1),
(53, 4, 1, 1),
(54, 6, 1, 1),
(55, 2, 1, 1),
(56, 4, 1, 1),
(57, 6, 1, 1),
(58, 2, 1, 1),
(59, 4, 1, 1),
(60, 6, 1, 1),
(61, 2, 1, 1),
(62, 4, 1, 1),
(63, 6, 1, 1),
(64, 2, 1, 1),
(65, 4, 1, 1),
(66, 6, 1, 1),
(67, 2, 1, 1),
(68, 4, 1, 1),
(69, 6, 1, 1),
(70, 2, 1, 0),
(71, 4, 1, 0),
(72, 6, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `mpesa_transactions`
--

CREATE TABLE `mpesa_transactions` (
  `id` int(11) NOT NULL,
  `stk_push_merchant_request_id` tinytext NOT NULL,
  `stk_push_checkout_request_id` tinytext NOT NULL,
  `stk_push_response_code` int(11) NOT NULL,
  `stk_push_response_description` text NOT NULL,
  `stk_push_customer_message` text NOT NULL,
  `stk_push_error_code` tinytext NOT NULL,
  `stk_push_error_message` text NOT NULL,
  `merchant_request_id` tinytext NOT NULL,
  `checkout_request_id` tinytext NOT NULL,
  `result_id` int(11) NOT NULL,
  `amount` int(11) NOT NULL,
  `mpesa_receipt_number` tinytext NOT NULL,
  `phone_number` tinytext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `mpesa_transactions`
--

INSERT INTO `mpesa_transactions` (`id`, `stk_push_merchant_request_id`, `stk_push_checkout_request_id`, `stk_push_response_code`, `stk_push_response_description`, `stk_push_customer_message`, `stk_push_error_code`, `stk_push_error_message`, `merchant_request_id`, `checkout_request_id`, `result_id`, `amount`, `mpesa_receipt_number`, `phone_number`) VALUES
(1, 'c62b-4e23-a479-5f74de8082a1893686', 'ws_CO_06022025103412745717551542', 0, 'Success. Request accepted for processing', 'Success. Request accepted for processing', '', '', '', '', 0, 0, '', ''),
(2, 'bbcd-4a89-bd1a-6ecdc639893b2377914', 'ws_CO_06022025103423947717551542', 0, 'Success. Request accepted for processing', 'Success. Request accepted for processing', '', '', '', '', 0, 0, '', ''),
(3, '6543-425e-a177-2e84b1462ecd892768', 'ws_CO_06022025103851167717551542', 0, 'Success. Request accepted for processing', 'Success. Request accepted for processing', '', '', '', '', 0, 0, '', ''),
(4, 'b54f-471d-93d9-f7f3bf3f7c0e2380253', 'ws_CO_06022025103902247717551542', 0, 'Success. Request accepted for processing', 'Success. Request accepted for processing', '', '', '', '', 0, 0, '', ''),
(5, 'bbcd-4a89-bd1a-6ecdc639893b2378044', '', 0, '', '', '500.001.1001', 'Unable to lock subscriber, a transaction is already in process for the current subscriber', '', '', 0, 0, '', ''),
(6, 'b54f-471d-93d9-f7f3bf3f7c0e2380813', 'ws_CO_06022025105745399717551542', 0, 'Success. Request accepted for processing', 'Success. Request accepted for processing', '', '', '', '', 0, 0, '', ''),
(7, 'c62b-4e23-a479-5f74de8082a1894445', 'ws_CO_06022025105906137717551542', 0, 'Success. Request accepted for processing', 'Success. Request accepted for processing', '', '', '', '', 0, 0, '', ''),
(8, '5fe8-4261-87f6-6d7d41adc6c3582184', '', 0, '', '', '500.001.1001', 'Unable to lock subscriber, a transaction is already in process for the current subscriber', '', '', 0, 0, '', ''),
(9, '6543-425e-a177-2e84b1462ecd893467', 'ws_CO_06022025110027285717551542', 0, 'Success. Request accepted for processing', 'Success. Request accepted for processing', '', '', '', '', 0, 0, '', ''),
(10, 'c62b-4e23-a479-5f74de8082a1894498', 'ws_CO_06022025105919567717551542', 0, 'Success. Request accepted for processing', 'Success. Request accepted for processing', '', '', '', '', 0, 0, '', ''),
(11, 'c62b-4e23-a479-5f74de8082a1894500', '', 0, '', '', '500.003.02', 'System is busy. Please try again in few minutes.', '', '', 0, 0, '', ''),
(12, '6543-425e-a177-2e84b1462ecd893818', 'ws_CO_06022025111051550717551542', 0, 'Success. Request accepted for processing', 'Success. Request accepted for processing', '', '', '', '', 0, 0, '', ''),
(13, 'c62b-4e23-a479-5f74de8082a1894835', '', 0, '', '', '500.001.1001', 'Unable to lock subscriber, a transaction is already in process for the current subscriber', '', '', 0, 0, '', ''),
(14, '6543-425e-a177-2e84b1462ecd893821', '', 0, '', '', '500.003.02', 'System is busy. Please try again in few minutes.', '', '', 0, 0, '', ''),
(15, 'bbcd-4a89-bd1a-6ecdc639893b2378935', 'ws_CO_06022025111107041717551542', 0, 'Success. Request accepted for processing', 'Success. Request accepted for processing', '', '', '', '', 0, 0, '', ''),
(16, '6543-425e-a177-2e84b1462ecd893852', 'ws_CO_06022025111055901717551542', 0, 'Success. Request accepted for processing', 'Success. Request accepted for processing', '', '', '', '', 0, 0, '', ''),
(17, 'c62b-4e23-a479-5f74de8082a1894869', '', 0, '', '', '500.001.1001', 'Unable to lock subscriber, a transaction is already in process for the current subscriber', '', '', 0, 0, '', ''),
(18, 'c62b-4e23-a479-5f74de8082a1894878', '', 0, '', '', '500.003.02', 'System is busy. Please try again in few minutes.', '', '', 0, 0, '', ''),
(19, 'c62b-4e23-a479-5f74de8082a1894883', '', 0, '', '', '500.003.02', 'System is busy. Please try again in few minutes.', '', '', 0, 0, '', ''),
(20, 'c62b-4e23-a479-5f74de8082a1894940', 'ws_CO_06022025111417426717551542', 0, 'Success. Request accepted for processing', 'Success. Request accepted for processing', '', '', '', '', 0, 0, '', ''),
(21, '5fe8-4261-87f6-6d7d41adc6c3582613', '', 0, '', '', '500.001.1001', 'Unable to lock subscriber, a transaction is already in process for the current subscriber', '', '', 0, 0, '', ''),
(22, 'b54f-471d-93d9-f7f3bf3f7c0e2381236', 'ws_CO_06022025111428098717551542', 0, 'Success. Request accepted for processing', 'Success. Request accepted for processing', '', '', '', '', 0, 0, '', ''),
(23, 'c62b-4e23-a479-5f74de8082a1894964', 'ws_CO_06022025111433742717551542', 0, 'Success. Request accepted for processing', 'Success. Request accepted for processing', '', '', '', '', 0, 0, '', '');

-- --------------------------------------------------------

--
-- Table structure for table `payment_methods`
--

CREATE TABLE `payment_methods` (
  `id` int(11) NOT NULL,
  `name` tinytext NOT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payment_methods`
--

INSERT INTO `payment_methods` (`id`, `name`, `deleted`) VALUES
(1, 'mpesa', 0),
(2, 'visa', 0);

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` int(11) NOT NULL,
  `sender_account_id` int(11) NOT NULL,
  `receiver_account_id` int(11) NOT NULL,
  `amount` int(11) NOT NULL,
  `datetime` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `automations`
--
ALTER TABLE `automations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `automation_types`
--
ALTER TABLE `automation_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `daily_automations`
--
ALTER TABLE `daily_automations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `initiated_automations`
--
ALTER TABLE `initiated_automations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `monthly_automations`
--
ALTER TABLE `monthly_automations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mpesa_transactions`
--
ALTER TABLE `mpesa_transactions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payment_methods`
--
ALTER TABLE `payment_methods`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accounts`
--
ALTER TABLE `accounts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `automations`
--
ALTER TABLE `automations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `automation_types`
--
ALTER TABLE `automation_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `daily_automations`
--
ALTER TABLE `daily_automations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT for table `initiated_automations`
--
ALTER TABLE `initiated_automations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `monthly_automations`
--
ALTER TABLE `monthly_automations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;

--
-- AUTO_INCREMENT for table `mpesa_transactions`
--
ALTER TABLE `mpesa_transactions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `payment_methods`
--
ALTER TABLE `payment_methods`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
