-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 18, 2023 at 04:34 PM
-- Server version: 10.1.38-MariaDB
-- PHP Version: 7.3.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `journalistday`
--

-- --------------------------------------------------------

--
-- Table structure for table `tab_gift`
--

CREATE TABLE `tab_gift` (
  `gift_id` int(11) NOT NULL,
  `gift_name` varchar(255) NOT NULL,
  `gift_file` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tab_gift`
--

INSERT INTO `tab_gift` (`gift_id`, `gift_name`, `gift_file`) VALUES
(1, 'HADIAH 1', 'gift1.png'),
(2, 'HADIAH 2', 'gift2.png'),
(3, 'HADIAH 3', 'gift3.png'),
(4, 'HADIAH 4', 'gift4.png'),
(5, 'HADIAH 5', 'gift1.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `tab_participants`
--

CREATE TABLE `tab_participants` (
  `participant_id` int(11) NOT NULL,
  `participant_name` varchar(255) NOT NULL,
  `participant_div` varchar(255) NOT NULL,
  `participant_pic` varchar(255) NOT NULL,
  `participant_wa` varchar(255) NOT NULL,
  `addon` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tab_user`
--

CREATE TABLE `tab_user` (
  `user_id` int(11) NOT NULL,
  `user_name` varchar(255) NOT NULL,
  `user_pass` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tab_user`
--

INSERT INTO `tab_user` (`user_id`, `user_name`, `user_pass`) VALUES
(1, 'admin', 'd54e5ae10222d681124b795096598b65'),
(2, 'developer', '92ffac9bb4cf1f872bfb8dafb3a44864');

-- --------------------------------------------------------

--
-- Table structure for table `tr_doorprize`
--

CREATE TABLE `tr_doorprize` (
  `doorprize_id` int(11) NOT NULL,
  `participant_id` int(11) NOT NULL,
  `addon` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Stand-in structure for view `view_allow_doorprize`
-- (See below for the actual view)
--
CREATE TABLE `view_allow_doorprize` (
`participant_id` int(11)
,`participant_name` varchar(255)
,`participant_div` varchar(255)
,`participant_pic` varchar(255)
,`participant_wa` varchar(255)
,`addon` datetime
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `view_participant`
-- (See below for the actual view)
--
CREATE TABLE `view_participant` (
`participant_id` int(11)
,`participant_name` varchar(255)
,`participant_div` varchar(255)
,`participant_pic` varchar(255)
,`participant_wa` varchar(255)
,`addon` datetime
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `view_report_doorprize`
-- (See below for the actual view)
--
CREATE TABLE `view_report_doorprize` (
`doorprize_id` int(11)
,`participant_id` int(11)
,`addon` datetime
,`participant_name` varchar(255)
,`participant_div` varchar(255)
,`participant_pic` varchar(255)
,`participant_wa` varchar(255)
);

-- --------------------------------------------------------

--
-- Structure for view `view_allow_doorprize`
--
DROP TABLE IF EXISTS `view_allow_doorprize`;

CREATE ALGORITHM=UNDEFINED DEFINER=`dev`@`localhost` SQL SECURITY DEFINER VIEW `view_allow_doorprize`  AS  select `tab_participants`.`participant_id` AS `participant_id`,`tab_participants`.`participant_name` AS `participant_name`,`tab_participants`.`participant_div` AS `participant_div`,`tab_participants`.`participant_pic` AS `participant_pic`,`tab_participants`.`participant_wa` AS `participant_wa`,`tab_participants`.`addon` AS `addon` from `tab_participants` where (not(`tab_participants`.`participant_id` in (select `tr_doorprize`.`participant_id` from `tr_doorprize`))) ;

-- --------------------------------------------------------

--
-- Structure for view `view_participant`
--
DROP TABLE IF EXISTS `view_participant`;

CREATE ALGORITHM=UNDEFINED DEFINER=`dev`@`localhost` SQL SECURITY DEFINER VIEW `view_participant`  AS  select `tab_participants`.`participant_id` AS `participant_id`,`tab_participants`.`participant_name` AS `participant_name`,`tab_participants`.`participant_div` AS `participant_div`,`tab_participants`.`participant_pic` AS `participant_pic`,`tab_participants`.`participant_wa` AS `participant_wa`,`tab_participants`.`addon` AS `addon` from `tab_participants` ;

-- --------------------------------------------------------

--
-- Structure for view `view_report_doorprize`
--
DROP TABLE IF EXISTS `view_report_doorprize`;

CREATE ALGORITHM=UNDEFINED DEFINER=`dev`@`localhost` SQL SECURITY DEFINER VIEW `view_report_doorprize`  AS  select `a`.`doorprize_id` AS `doorprize_id`,`a`.`participant_id` AS `participant_id`,`a`.`addon` AS `addon`,`b`.`participant_name` AS `participant_name`,`b`.`participant_div` AS `participant_div`,`b`.`participant_pic` AS `participant_pic`,`b`.`participant_wa` AS `participant_wa` from (`tr_doorprize` `a` left join `tab_participants` `b` on((`a`.`participant_id` = `b`.`participant_id`))) ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tab_gift`
--
ALTER TABLE `tab_gift`
  ADD PRIMARY KEY (`gift_id`);

--
-- Indexes for table `tab_participants`
--
ALTER TABLE `tab_participants`
  ADD PRIMARY KEY (`participant_id`);

--
-- Indexes for table `tab_user`
--
ALTER TABLE `tab_user`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `tr_doorprize`
--
ALTER TABLE `tr_doorprize`
  ADD PRIMARY KEY (`doorprize_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tab_gift`
--
ALTER TABLE `tab_gift`
  MODIFY `gift_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tab_participants`
--
ALTER TABLE `tab_participants`
  MODIFY `participant_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tab_user`
--
ALTER TABLE `tab_user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tr_doorprize`
--
ALTER TABLE `tr_doorprize`
  MODIFY `doorprize_id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
