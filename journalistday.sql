-- phpMyAdmin SQL Dump
-- version 4.7.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Feb 17, 2023 at 08:51 AM
-- Server version: 5.5.56-MariaDB
-- PHP Version: 7.0.30

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
  `participant_pic` varchar(255) NOT NULL,
  `participant_wa` varchar(255) NOT NULL,
  `addon` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tab_participants`
--

INSERT INTO `tab_participants` (`participant_id`, `participant_name`, `participant_pic`, `participant_wa`, `addon`) VALUES
(1, 'Varuna', '', '085358632070', '2023-02-17 10:14:09');

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
-- Table structure for table `tr_grandprize`
--

CREATE TABLE `tr_grandprize` (
  `grandprize_id` int(11) NOT NULL,
  `registration_id` int(11) NOT NULL,
  `gift_id` int(11) NOT NULL,
  `addon` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tr_registration`
--

CREATE TABLE `tr_registration` (
  `registration_id` int(11) NOT NULL,
  `participant_id` int(11) NOT NULL,
  `is_antigen` int(11) NOT NULL DEFAULT '1',
  `antigen_datetime` datetime DEFAULT NULL,
  `is_verify` int(11) NOT NULL,
  `verify_datetime` datetime DEFAULT NULL,
  `is_taken_doorprize` int(11) NOT NULL,
  `taken_doorprize_datetime` datetime DEFAULT NULL,
  `addon` datetime NOT NULL,
  `modion` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Stand-in structure for view `view_allow_grandprize`
-- (See below for the actual view)
--
CREATE TABLE `view_allow_grandprize` (
`registration_id` int(11)
,`participant_id` int(11)
,`addon` datetime
,`modion` datetime
,`participant_name` varchar(255)
,`participant_wa` varchar(255)
,`participant_pic` varchar(255)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `view_participants`
-- (See below for the actual view)
--
CREATE TABLE `view_participants` (
`participant_id` int(11)
,`participant_name` varchar(255)
,`participant_wa` varchar(255)
,`participant_pic` varchar(255)
,`addon` datetime
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `view_registration`
-- (See below for the actual view)
--
CREATE TABLE `view_registration` (
`registration_id` int(11)
,`participant_id` int(11)
,`addon` datetime
,`modion` datetime
,`participant_name` varchar(255)
,`participant_pic` varchar(255)
,`participant_wa` varchar(255)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `view_report_grandprize`
-- (See below for the actual view)
--
CREATE TABLE `view_report_grandprize` (
`grandprize_id` int(11)
,`registration_id` int(11)
,`gift_id` int(11)
,`addon` datetime
,`participant_id` int(11)
,`gift_name` varchar(255)
,`gift_file` varchar(255)
,`participant_name` varchar(255)
,`participant_pic` varchar(255)
,`participant_wa` varchar(255)
);

-- --------------------------------------------------------

--
-- Structure for view `view_allow_grandprize`
--
DROP TABLE IF EXISTS `view_allow_grandprize`;

CREATE ALGORITHM=UNDEFINED DEFINER=`mis`@`localhost` SQL SECURITY DEFINER VIEW `view_allow_grandprize`  AS  select `a`.`registration_id` AS `registration_id`,`a`.`participant_id` AS `participant_id`,`a`.`addon` AS `addon`,`a`.`modion` AS `modion`,`b`.`participant_name` AS `participant_name`,`b`.`participant_wa` AS `participant_wa`,`b`.`participant_pic` AS `participant_pic` from (`tr_registration` `a` left join `tab_participants` `b` on((`a`.`participant_id` = `b`.`participant_id`))) where (not(`a`.`registration_id` in (select distinct `tr_grandprize`.`registration_id` from `tr_grandprize`))) ;

-- --------------------------------------------------------

--
-- Structure for view `view_participants`
--
DROP TABLE IF EXISTS `view_participants`;

CREATE ALGORITHM=UNDEFINED DEFINER=`mis`@`localhost` SQL SECURITY DEFINER VIEW `view_participants`  AS  select `tab_participants`.`participant_id` AS `participant_id`,`tab_participants`.`participant_name` AS `participant_name`,`tab_participants`.`participant_wa` AS `participant_wa`,`tab_participants`.`participant_pic` AS `participant_pic`,`tab_participants`.`addon` AS `addon` from `tab_participants` ;

-- --------------------------------------------------------

--
-- Structure for view `view_registration`
--
DROP TABLE IF EXISTS `view_registration`;

CREATE ALGORITHM=UNDEFINED DEFINER=`mis`@`localhost` SQL SECURITY DEFINER VIEW `view_registration`  AS  select `a`.`registration_id` AS `registration_id`,`a`.`participant_id` AS `participant_id`,`a`.`addon` AS `addon`,`a`.`modion` AS `modion`,`b`.`participant_name` AS `participant_name`,`b`.`participant_pic` AS `participant_pic`,`b`.`participant_wa` AS `participant_wa` from (`tr_registration` `a` left join `tab_participants` `b` on((`a`.`participant_id` = `b`.`participant_id`))) ;

-- --------------------------------------------------------

--
-- Structure for view `view_report_grandprize`
--
DROP TABLE IF EXISTS `view_report_grandprize`;

CREATE ALGORITHM=UNDEFINED DEFINER=`mis`@`localhost` SQL SECURITY DEFINER VIEW `view_report_grandprize`  AS  select `a`.`grandprize_id` AS `grandprize_id`,`a`.`registration_id` AS `registration_id`,`a`.`gift_id` AS `gift_id`,`a`.`addon` AS `addon`,`b`.`participant_id` AS `participant_id`,`c`.`gift_name` AS `gift_name`,`c`.`gift_file` AS `gift_file`,`d`.`participant_name` AS `participant_name`,`d`.`participant_pic` AS `participant_pic`,`d`.`participant_wa` AS `participant_wa` from (((`tr_grandprize` `a` left join `tr_registration` `b` on((`a`.`registration_id` = `b`.`registration_id`))) left join `tab_gift` `c` on((`a`.`gift_id` = `c`.`gift_id`))) left join `tab_participants` `d` on((`b`.`participant_id` = `d`.`participant_id`))) ;

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
-- Indexes for table `tr_grandprize`
--
ALTER TABLE `tr_grandprize`
  ADD PRIMARY KEY (`grandprize_id`);

--
-- Indexes for table `tr_registration`
--
ALTER TABLE `tr_registration`
  ADD PRIMARY KEY (`registration_id`);

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
  MODIFY `participant_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tab_user`
--
ALTER TABLE `tab_user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tr_grandprize`
--
ALTER TABLE `tr_grandprize`
  MODIFY `grandprize_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tr_registration`
--
ALTER TABLE `tr_registration`
  MODIFY `registration_id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
