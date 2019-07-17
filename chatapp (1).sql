-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 16, 2019 at 05:49 PM
-- Server version: 10.1.40-MariaDB
-- PHP Version: 7.3.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `chatapp`
--

-- --------------------------------------------------------

--
-- Table structure for table `agents`
--

CREATE TABLE `agents` (
  `agent_id` int(11) NOT NULL,
  `tenant` varchar(255) DEFAULT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `username` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `is_master` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `agents`
--

INSERT INTO `agents` (`agent_id`, `tenant`, `first_name`, `last_name`, `username`, `password`, `email`, `is_master`) VALUES
(1, 'admin', 'first', 'last', 'admin', '21232f297a57a5a743894a0e4a801fc3', 'admin@admin.com', 1);

-- --------------------------------------------------------

--
-- Table structure for table `chats`
--

CREATE TABLE `chats` (
  `chat_id` int(255) NOT NULL,
  `message` varchar(4000) DEFAULT NULL,
  `system` varchar(255) DEFAULT '',
  `participants` varchar(255) DEFAULT NULL,
  `user_ids` varchar(255) NOT NULL,
  `from` varchar(255) DEFAULT NULL,
  `agent_id` varchar(255) DEFAULT NULL,
  `date_created` datetime DEFAULT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `room_id` varchar(255) DEFAULT NULL,
  `agent` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `chats`
--

INSERT INTO `chats` (`chat_id`, `message`, `system`, `participants`, `user_ids`, `from`, `agent_id`, `date_created`, `avatar`, `room_id`, `agent`) VALUES
(1, 'Im admin', '', '7653eeba-bd06-a5fd-49a5-2f2b2f8d412c', '1,2,3', 'Admin', '', '2019-06-20 07:34:07', 'http://talk2.it369.offline/storage/avatars/hKEaVBSfGyvy1dF6ItGcLQNNOR3v4WT3RQDHalq0.jpeg', 'IjMi', 'user_or_group_name'),
(2, 'im amya', '', '399b90c8-808d-5320-0d05-4df73d2c99af,7653eeba-bd06-a5fd-49a5-2f2b2f8d412c', '1,2,3', 'amaya', '', '2019-06-20 07:34:22', 'http://talk2.it369.offline/storage/avatars/sDZWSkCWUzYRWL5YwmAaA4b0bwSpvHVlFKTzrRyv.jpeg', 'IjMi', 'user_or_group_name'),
(3, 'Ah nangu', '', '7653eeba-bd06-a5fd-49a5-2f2b2f8d412c,399b90c8-808d-5320-0d05-4df73d2c99af', '3,1', 'Admin', '', '2019-06-20 07:34:48', 'http://talk2.it369.offline/storage/avatars/hKEaVBSfGyvy1dF6ItGcLQNNOR3v4WT3RQDHalq0.jpeg', '62f8a352417ccaf3ec61a3b369fffdf4', 'user_or_group_name'),
(4, 'Kohmd', '', '7653eeba-bd06-a5fd-49a5-2f2b2f8d412c,399b90c8-808d-5320-0d05-4df73d2c99af', '3,1', 'Admin', '', '2019-06-20 07:34:52', 'http://talk2.it369.offline/storage/avatars/hKEaVBSfGyvy1dF6ItGcLQNNOR3v4WT3RQDHalq0.jpeg', '62f8a352417ccaf3ec61a3b369fffdf4', 'user_or_group_name'),
(5, 'innwa ayya', '', '399b90c8-808d-5320-0d05-4df73d2c99af,7653eeba-bd06-a5fd-49a5-2f2b2f8d412c', '1,3', 'amaya', '', '2019-06-20 07:34:59', 'http://talk2.it369.offline/storage/avatars/sDZWSkCWUzYRWL5YwmAaA4b0bwSpvHVlFKTzrRyv.jpeg', '62f8a352417ccaf3ec61a3b369fffdf4', 'user_or_group_name'),
(6, 'Mm', '', '7653eeba-bd06-a5fd-49a5-2f2b2f8d412c,399b90c8-808d-5320-0d05-4df73d2c99af', '3,1', 'Admin', '', '2019-06-20 07:54:19', 'http://talk2.it369.offline/storage/avatars/hKEaVBSfGyvy1dF6ItGcLQNNOR3v4WT3RQDHalq0.jpeg', '62f8a352417ccaf3ec61a3b369fffdf4', 'user_or_group_name'),
(7, 'Mm', '', '7653eeba-bd06-a5fd-49a5-2f2b2f8d412c,38a11ccc-2631-e0fb-216d-239db893c65c', '2,1', 'Admin', '', '2019-06-20 08:02:41', 'http://talk2.it369.offline/storage/avatars/hKEaVBSfGyvy1dF6ItGcLQNNOR3v4WT3RQDHalq0.jpeg', '252ea9ee6a16c32b08ec639d57837cfd', 'user_or_group_name'),
(8, 'ow', '', '38a11ccc-2631-e0fb-216d-239db893c65c,7653eeba-bd06-a5fd-49a5-2f2b2f8d412c', '1,2', 'chanaka', '', '2019-06-20 08:02:46', 'http://talk2.it369.offline/storage/avatars/lrtJaHIoMJ5rtGw6Iz9low7T2P7jf6OFkRVlLZfg.jpeg', '252ea9ee6a16c32b08ec639d57837cfd', 'user_or_group_name'),
(9, 'Mama admin', '', '7653eeba-bd06-a5fd-49a5-2f2b2f8d412c,38a11ccc-2631-e0fb-216d-239db893c65c,399b90c8-808d-5320-0d05-4df73d2c99af', '1,2,3', 'Admin', '', '2019-06-20 08:05:25', 'http://talk2.it369.offline/storage/avatars/hKEaVBSfGyvy1dF6ItGcLQNNOR3v4WT3RQDHalq0.jpeg', 'IjIi', 'user_or_group_name'),
(10, 'mama chnkaa', '', '38a11ccc-2631-e0fb-216d-239db893c65c,7653eeba-bd06-a5fd-49a5-2f2b2f8d412c,399b90c8-808d-5320-0d05-4df73d2c99af', '1,2,3', 'chanaka', '', '2019-06-20 08:05:36', 'http://talk2.it369.offline/storage/avatars/lrtJaHIoMJ5rtGw6Iz9low7T2P7jf6OFkRVlLZfg.jpeg', 'IjIi', 'user_or_group_name'),
(11, 'mama amaya', '', '399b90c8-808d-5320-0d05-4df73d2c99af,38a11ccc-2631-e0fb-216d-239db893c65c,7653eeba-bd06-a5fd-49a5-2f2b2f8d412c', '1,2,3', 'amaya', '', '2019-06-20 08:05:48', 'http://talk2.it369.offline/storage/avatars/sDZWSkCWUzYRWL5YwmAaA4b0bwSpvHVlFKTzrRyv.jpeg', 'IjIi', 'user_or_group_name'),
(12, '55', '', '399b90c8-808d-5320-0d05-4df73d2c99af,38a11ccc-2631-e0fb-216d-239db893c65c,7653eeba-bd06-a5fd-49a5-2f2b2f8d412c', '1,2,3', 'amaya', '', '2019-06-20 08:10:11', 'http://talk2.it369.offline/storage/avatars/sDZWSkCWUzYRWL5YwmAaA4b0bwSpvHVlFKTzrRyv.jpeg', 'IjIi', 'user_or_group_name'),
(13, 'amaya is sending eye_pupil_closeup_121651_1440x900.jpg', 'acceptReject', '38a11ccc-2631-e0fb-216d-239db893c65c,7653eeba-bd06-a5fd-49a5-2f2b2f8d412c,399b90c8-808d-5320-0d05-4df73d2c99af', '1,2,3', '', '', '2019-06-20 08:12:45', '', 'IjIi', 'user_or_group_name'),
(14, 'Receiving file eye_pupil_closeup_121651_1440x900.jpg', 'fileTransfer', '38a11ccc-2631-e0fb-216d-239db893c65c,7653eeba-bd06-a5fd-49a5-2f2b2f8d412c,399b90c8-808d-5320-0d05-4df73d2c99af', '1,2,3', '', '', '2019-06-20 08:12:54', '', 'IjIi', 'user_or_group_name'),
(15, '2', '', '399b90c8-808d-5320-0d05-4df73d2c99af,38a11ccc-2631-e0fb-216d-239db893c65c', '1,2,3', 'amaya', '', '2019-06-20 08:22:27', 'http://talk2.it369.offline/storage/avatars/sDZWSkCWUzYRWL5YwmAaA4b0bwSpvHVlFKTzrRyv.jpeg', 'IjIi', 'user_or_group_name'),
(16, 'Mm', '', '7653eeba-bd06-a5fd-49a5-2f2b2f8d412c', '1,2,3', 'Admin', '', '2019-06-20 09:45:03', 'http://talk2.it369.offline/storage/avatars/hKEaVBSfGyvy1dF6ItGcLQNNOR3v4WT3RQDHalq0.jpeg', 'IjIi', 'user_or_group_name'),
(17, 'as', '', 'c34d69c1-c98e-7040-cc26-e7995d213946', '2,1', 'Admin', '', '2019-06-20 19:43:40', 'http://talk2.it369.offline/storage/avatars/hKEaVBSfGyvy1dF6ItGcLQNNOR3v4WT3RQDHalq0.jpeg', '252ea9ee6a16c32b08ec639d57837cfd', 'user_or_group_name'),
(18, 'mmmm', '', 'c34d69c1-c98e-7040-cc26-e7995d213946', '1,2', 'Admin', '', '2019-06-20 19:43:51', 'http://talk2.it369.offline/storage/avatars/hKEaVBSfGyvy1dF6ItGcLQNNOR3v4WT3RQDHalq0.jpeg', 'IjEi', 'user_or_group_name'),
(19, 'oals djas djas', '', 'c34d69c1-c98e-7040-cc26-e7995d213946', '1,2,3', 'Admin', '', '2019-06-20 19:44:13', 'http://talk2.it369.offline/storage/avatars/hKEaVBSfGyvy1dF6ItGcLQNNOR3v4WT3RQDHalq0.jpeg', 'IjQi', 'user_or_group_name'),
(20, 'as', '', 'c3671f07-a390-ddaa-ef13-49d946c4d2ca', '1,3', 'amaya', '', '2019-06-21 05:38:13', 'http://talk2.it369.offline/storage/avatars/sDZWSkCWUzYRWL5YwmAaA4b0bwSpvHVlFKTzrRyv.jpeg', '62f8a352417ccaf3ec61a3b369fffdf4', 'user_or_group_name'),
(21, 'as', '', 'c3671f07-a390-ddaa-ef13-49d946c4d2ca', '1,3', 'amaya', '', '2019-06-21 05:38:20', 'http://talk2.it369.offline/storage/avatars/sDZWSkCWUzYRWL5YwmAaA4b0bwSpvHVlFKTzrRyv.jpeg', '62f8a352417ccaf3ec61a3b369fffdf4', 'user_or_group_name'),
(22, 'as', '', 'c3671f07-a390-ddaa-ef13-49d946c4d2ca', '1,3', 'amaya', '', '2019-06-21 05:38:22', 'http://talk2.it369.offline/storage/avatars/sDZWSkCWUzYRWL5YwmAaA4b0bwSpvHVlFKTzrRyv.jpeg', '62f8a352417ccaf3ec61a3b369fffdf4', 'user_or_group_name'),
(23, 'asd', '', 'c3671f07-a390-ddaa-ef13-49d946c4d2ca,e4d98ad8-ebf4-8ea5-13c8-637cf421b508', '1,3', 'amaya', '', '2019-06-21 05:42:09', 'http://talk2.it369.offline/storage/avatars/sDZWSkCWUzYRWL5YwmAaA4b0bwSpvHVlFKTzrRyv.jpeg', '62f8a352417ccaf3ec61a3b369fffdf4', 'user_or_group_name'),
(24, 'asd', '', 'e4d98ad8-ebf4-8ea5-13c8-637cf421b508,c3671f07-a390-ddaa-ef13-49d946c4d2ca', '3,1', 'Admin', '', '2019-06-21 05:42:11', 'http://talk2.it369.offline/storage/avatars/hKEaVBSfGyvy1dF6ItGcLQNNOR3v4WT3RQDHalq0.jpeg', '62f8a352417ccaf3ec61a3b369fffdf4', 'user_or_group_name'),
(25, 'asd', '', 'e4d98ad8-ebf4-8ea5-13c8-637cf421b508,c3671f07-a390-ddaa-ef13-49d946c4d2ca', '3,1', 'Admin', '', '2019-06-21 05:42:28', 'http://talk2.it369.offline/storage/avatars/hKEaVBSfGyvy1dF6ItGcLQNNOR3v4WT3RQDHalq0.jpeg', '62f8a352417ccaf3ec61a3b369fffdf4', 'user_or_group_name'),
(26, 'as', '', 'c3671f07-a390-ddaa-ef13-49d946c4d2ca,e4d98ad8-ebf4-8ea5-13c8-637cf421b508', '1,3', 'amaya', '', '2019-06-21 05:42:32', 'http://talk2.it369.offline/storage/avatars/sDZWSkCWUzYRWL5YwmAaA4b0bwSpvHVlFKTzrRyv.jpeg', '62f8a352417ccaf3ec61a3b369fffdf4', 'user_or_group_name'),
(27, 'sdf', '', 'c3671f07-a390-ddaa-ef13-49d946c4d2ca', '1,3', 'amaya', '', '2019-06-21 07:06:20', 'http://talk2.it369.offline/storage/avatars/sDZWSkCWUzYRWL5YwmAaA4b0bwSpvHVlFKTzrRyv.jpeg', '62f8a352417ccaf3ec61a3b369fffdf4', 'user_or_group_name'),
(28, '1', '', 'c3671f07-a390-ddaa-ef13-49d946c4d2ca,e4d98ad8-ebf4-8ea5-13c8-637cf421b508', '1,3', 'amaya', '', '2019-06-21 07:32:58', 'http://talk2.it369.offline/storage/avatars/sDZWSkCWUzYRWL5YwmAaA4b0bwSpvHVlFKTzrRyv.jpeg', '62f8a352417ccaf3ec61a3b369fffdf4', 'user_or_group_name'),
(29, 'm', '', 'c3671f07-a390-ddaa-ef13-49d946c4d2ca,e4d98ad8-ebf4-8ea5-13c8-637cf421b508', '1,3', 'amaya', '', '2019-06-21 07:33:20', 'http://talk2.it369.offline/storage/avatars/sDZWSkCWUzYRWL5YwmAaA4b0bwSpvHVlFKTzrRyv.jpeg', '62f8a352417ccaf3ec61a3b369fffdf4', 'user_or_group_name'),
(30, 'dfds', '', 'c3671f07-a390-ddaa-ef13-49d946c4d2ca', '1,3', 'amaya', '', '2019-06-21 07:50:57', 'http://talk2.it369.offline/storage/avatars/sDZWSkCWUzYRWL5YwmAaA4b0bwSpvHVlFKTzrRyv.jpeg', '62f8a352417ccaf3ec61a3b369fffdf4', 'user_or_group_name'),
(31, 'fd', '', 'c3671f07-a390-ddaa-ef13-49d946c4d2ca', '1,3', 'amaya', '', '2019-06-21 07:50:58', 'http://talk2.it369.offline/storage/avatars/sDZWSkCWUzYRWL5YwmAaA4b0bwSpvHVlFKTzrRyv.jpeg', '62f8a352417ccaf3ec61a3b369fffdf4', 'user_or_group_name'),
(32, 'dfg', '', 'e4d98ad8-ebf4-8ea5-13c8-637cf421b508,c3671f07-a390-ddaa-ef13-49d946c4d2ca', '3,1', 'Admin', '', '2019-06-21 07:51:05', 'http://talk2.it369.offline/storage/avatars/hKEaVBSfGyvy1dF6ItGcLQNNOR3v4WT3RQDHalq0.jpeg', '62f8a352417ccaf3ec61a3b369fffdf4', 'user_or_group_name'),
(33, 'dfgdx', '', 'c3671f07-a390-ddaa-ef13-49d946c4d2ca,e4d98ad8-ebf4-8ea5-13c8-637cf421b508', '1,3', 'amaya', '', '2019-06-21 07:56:58', 'http://talk2.it369.offline/storage/avatars/sDZWSkCWUzYRWL5YwmAaA4b0bwSpvHVlFKTzrRyv.jpeg', '62f8a352417ccaf3ec61a3b369fffdf4', 'user_or_group_name'),
(34, 'x', '', 'c3671f07-a390-ddaa-ef13-49d946c4d2ca,e4d98ad8-ebf4-8ea5-13c8-637cf421b508', '1,3', 'amaya', '', '2019-06-21 07:57:03', 'http://talk2.it369.offline/storage/avatars/sDZWSkCWUzYRWL5YwmAaA4b0bwSpvHVlFKTzrRyv.jpeg', '62f8a352417ccaf3ec61a3b369fffdf4', 'user_or_group_name'),
(35, 'asa', '', 'e4d98ad8-ebf4-8ea5-13c8-637cf421b508', '3,1', 'Admin', '', '2019-06-21 07:57:49', 'http://talk2.it369.offline/storage/avatars/hKEaVBSfGyvy1dF6ItGcLQNNOR3v4WT3RQDHalq0.jpeg', '62f8a352417ccaf3ec61a3b369fffdf4', 'user_or_group_name'),
(36, 'zxcz', '', 'e4d98ad8-ebf4-8ea5-13c8-637cf421b508', '3,1', 'Admin', '', '2019-06-21 07:57:55', 'http://talk2.it369.offline/storage/avatars/hKEaVBSfGyvy1dF6ItGcLQNNOR3v4WT3RQDHalq0.jpeg', '62f8a352417ccaf3ec61a3b369fffdf4', 'user_or_group_name'),
(37, 's', '', 'e4d98ad8-ebf4-8ea5-13c8-637cf421b508', '3,1', 'Admin', '', '2019-06-21 07:59:23', 'http://talk2.it369.offline/storage/avatars/hKEaVBSfGyvy1dF6ItGcLQNNOR3v4WT3RQDHalq0.jpeg', '62f8a352417ccaf3ec61a3b369fffdf4', 'user_or_group_name'),
(38, 's', '', 'e4d98ad8-ebf4-8ea5-13c8-637cf421b508,c3671f07-a390-ddaa-ef13-49d946c4d2ca', '3,1', 'Admin', '', '2019-06-21 07:59:31', 'http://talk2.it369.offline/storage/avatars/hKEaVBSfGyvy1dF6ItGcLQNNOR3v4WT3RQDHalq0.jpeg', '62f8a352417ccaf3ec61a3b369fffdf4', 'user_or_group_name'),
(39, 's', '', 'e4d98ad8-ebf4-8ea5-13c8-637cf421b508,c3671f07-a390-ddaa-ef13-49d946c4d2ca', '3,1', 'Admin', '', '2019-06-21 07:59:33', 'http://talk2.it369.offline/storage/avatars/hKEaVBSfGyvy1dF6ItGcLQNNOR3v4WT3RQDHalq0.jpeg', '62f8a352417ccaf3ec61a3b369fffdf4', 'user_or_group_name'),
(40, 's', '', 'c3671f07-a390-ddaa-ef13-49d946c4d2ca,e4d98ad8-ebf4-8ea5-13c8-637cf421b508', '1,3', 'amaya', '', '2019-06-21 07:59:40', 'http://talk2.it369.offline/storage/avatars/sDZWSkCWUzYRWL5YwmAaA4b0bwSpvHVlFKTzrRyv.jpeg', '62f8a352417ccaf3ec61a3b369fffdf4', 'user_or_group_name'),
(41, 's', '', 'e4d98ad8-ebf4-8ea5-13c8-637cf421b508,c3671f07-a390-ddaa-ef13-49d946c4d2ca', '3,1', 'Admin', '', '2019-06-21 07:59:46', 'http://talk2.it369.offline/storage/avatars/hKEaVBSfGyvy1dF6ItGcLQNNOR3v4WT3RQDHalq0.jpeg', '62f8a352417ccaf3ec61a3b369fffdf4', 'user_or_group_name'),
(42, 'a', '', 'c3671f07-a390-ddaa-ef13-49d946c4d2ca,e4d98ad8-ebf4-8ea5-13c8-637cf421b508', '1,3', 'amaya', '', '2019-06-21 07:59:54', 'http://talk2.it369.offline/storage/avatars/sDZWSkCWUzYRWL5YwmAaA4b0bwSpvHVlFKTzrRyv.jpeg', '62f8a352417ccaf3ec61a3b369fffdf4', 'user_or_group_name'),
(43, 'a', '', 'e4d98ad8-ebf4-8ea5-13c8-637cf421b508,c3671f07-a390-ddaa-ef13-49d946c4d2ca', '3,1', 'Admin', '', '2019-06-21 08:00:02', 'http://talk2.it369.offline/storage/avatars/hKEaVBSfGyvy1dF6ItGcLQNNOR3v4WT3RQDHalq0.jpeg', '62f8a352417ccaf3ec61a3b369fffdf4', 'user_or_group_name'),
(44, 'a', '', 'c3671f07-a390-ddaa-ef13-49d946c4d2ca', '1,3', 'amaya', '', '2019-06-21 08:00:25', 'http://talk2.it369.offline/storage/avatars/sDZWSkCWUzYRWL5YwmAaA4b0bwSpvHVlFKTzrRyv.jpeg', '62f8a352417ccaf3ec61a3b369fffdf4', 'user_or_group_name'),
(45, 'a', '', 'c3671f07-a390-ddaa-ef13-49d946c4d2ca', '1,3', 'amaya', '', '2019-06-21 08:00:56', 'http://talk2.it369.offline/storage/avatars/sDZWSkCWUzYRWL5YwmAaA4b0bwSpvHVlFKTzrRyv.jpeg', '62f8a352417ccaf3ec61a3b369fffdf4', 'user_or_group_name'),
(46, 'a', '', 'e4d98ad8-ebf4-8ea5-13c8-637cf421b508', '3,1', 'Admin', '', '2019-06-21 08:01:07', 'http://talk2.it369.offline/storage/avatars/hKEaVBSfGyvy1dF6ItGcLQNNOR3v4WT3RQDHalq0.jpeg', '62f8a352417ccaf3ec61a3b369fffdf4', 'user_or_group_name'),
(47, 's', '', 'e4d98ad8-ebf4-8ea5-13c8-637cf421b508', '3,1', 'Admin', '', '2019-06-21 08:05:02', 'http://talk2.it369.offline/storage/avatars/hKEaVBSfGyvy1dF6ItGcLQNNOR3v4WT3RQDHalq0.jpeg', '62f8a352417ccaf3ec61a3b369fffdf4', 'user_or_group_name'),
(48, 'd', '', 'e4d98ad8-ebf4-8ea5-13c8-637cf421b508', '3,1', 'Admin', '', '2019-06-21 08:08:16', 'http://talk2.it369.offline/storage/avatars/hKEaVBSfGyvy1dF6ItGcLQNNOR3v4WT3RQDHalq0.jpeg', '62f8a352417ccaf3ec61a3b369fffdf4', 'user_or_group_name'),
(49, 'd', '', 'e4d98ad8-ebf4-8ea5-13c8-637cf421b508', '3,1', 'Admin', '', '2019-06-21 08:08:27', 'http://talk2.it369.offline/storage/avatars/hKEaVBSfGyvy1dF6ItGcLQNNOR3v4WT3RQDHalq0.jpeg', '62f8a352417ccaf3ec61a3b369fffdf4', 'user_or_group_name'),
(50, 's', '', 'e4d98ad8-ebf4-8ea5-13c8-637cf421b508,c3671f07-a390-ddaa-ef13-49d946c4d2ca', '3,1', 'Admin', '', '2019-06-21 08:09:13', 'http://talk2.it369.offline/storage/avatars/hKEaVBSfGyvy1dF6ItGcLQNNOR3v4WT3RQDHalq0.jpeg', '62f8a352417ccaf3ec61a3b369fffdf4', 'user_or_group_name'),
(51, 'asd', '', 'e4d98ad8-ebf4-8ea5-13c8-637cf421b508,c3671f07-a390-ddaa-ef13-49d946c4d2ca', '3,1', 'Admin', '', '2019-06-21 08:09:21', 'http://talk2.it369.offline/storage/avatars/hKEaVBSfGyvy1dF6ItGcLQNNOR3v4WT3RQDHalq0.jpeg', '62f8a352417ccaf3ec61a3b369fffdf4', 'user_or_group_name'),
(52, 'w', '', 'c3671f07-a390-ddaa-ef13-49d946c4d2ca', '1,3', 'amaya', '', '2019-06-21 08:12:04', 'http://talk2.it369.offline/storage/avatars/sDZWSkCWUzYRWL5YwmAaA4b0bwSpvHVlFKTzrRyv.jpeg', '62f8a352417ccaf3ec61a3b369fffdf4', 'user_or_group_name'),
(53, 'w', '', 'c3671f07-a390-ddaa-ef13-49d946c4d2ca,e4d98ad8-ebf4-8ea5-13c8-637cf421b508', '1,3', 'amaya', '', '2019-06-21 08:12:28', 'http://talk2.it369.offline/storage/avatars/sDZWSkCWUzYRWL5YwmAaA4b0bwSpvHVlFKTzrRyv.jpeg', '62f8a352417ccaf3ec61a3b369fffdf4', 'user_or_group_name'),
(54, 'f', '', 'c3671f07-a390-ddaa-ef13-49d946c4d2ca,e4d98ad8-ebf4-8ea5-13c8-637cf421b508', '1,3', 'amaya', '', '2019-06-21 08:12:55', 'http://talk2.it369.offline/storage/avatars/sDZWSkCWUzYRWL5YwmAaA4b0bwSpvHVlFKTzrRyv.jpeg', '62f8a352417ccaf3ec61a3b369fffdf4', 'user_or_group_name'),
(55, '/', '', 'c3671f07-a390-ddaa-ef13-49d946c4d2ca,e4d98ad8-ebf4-8ea5-13c8-637cf421b508', '1,3', 'amaya', '', '2019-06-21 08:15:21', 'http://talk2.it369.offline/storage/avatars/sDZWSkCWUzYRWL5YwmAaA4b0bwSpvHVlFKTzrRyv.jpeg', '62f8a352417ccaf3ec61a3b369fffdf4', 'user_or_group_name'),
(56, 'j', '', 'e4d98ad8-ebf4-8ea5-13c8-637cf421b508,c3671f07-a390-ddaa-ef13-49d946c4d2ca', '3,1', 'Admin', '', '2019-06-21 08:15:28', 'http://talk2.it369.offline/storage/avatars/hKEaVBSfGyvy1dF6ItGcLQNNOR3v4WT3RQDHalq0.jpeg', '62f8a352417ccaf3ec61a3b369fffdf4', 'user_or_group_name'),
(57, 's', '', 'c3671f07-a390-ddaa-ef13-49d946c4d2ca', '1,3', 'amaya', '', '2019-06-21 08:17:53', 'http://talk2.it369.offline/storage/avatars/sDZWSkCWUzYRWL5YwmAaA4b0bwSpvHVlFKTzrRyv.jpeg', '62f8a352417ccaf3ec61a3b369fffdf4', 'user_or_group_name'),
(58, 's', '', 'c3671f07-a390-ddaa-ef13-49d946c4d2ca', '1,3', 'amaya', '', '2019-06-21 08:17:56', 'http://talk2.it369.offline/storage/avatars/sDZWSkCWUzYRWL5YwmAaA4b0bwSpvHVlFKTzrRyv.jpeg', '62f8a352417ccaf3ec61a3b369fffdf4', 'user_or_group_name'),
(59, 'd', '', 'c3671f07-a390-ddaa-ef13-49d946c4d2ca', '1,3', 'amaya', '', '2019-06-21 08:20:42', 'http://talk2.it369.offline/storage/avatars/sDZWSkCWUzYRWL5YwmAaA4b0bwSpvHVlFKTzrRyv.jpeg', '62f8a352417ccaf3ec61a3b369fffdf4', 'user_or_group_name'),
(60, 'dfd', '', 'c3671f07-a390-ddaa-ef13-49d946c4d2ca', '1,3', 'amaya', '', '2019-06-21 08:20:46', 'http://talk2.it369.offline/storage/avatars/sDZWSkCWUzYRWL5YwmAaA4b0bwSpvHVlFKTzrRyv.jpeg', '62f8a352417ccaf3ec61a3b369fffdf4', 'user_or_group_name'),
(61, 's', '', 'c3671f07-a390-ddaa-ef13-49d946c4d2ca', '1,3', 'amaya', '', '2019-06-21 08:28:46', 'http://talk2.it369.offline/storage/avatars/sDZWSkCWUzYRWL5YwmAaA4b0bwSpvHVlFKTzrRyv.jpeg', '62f8a352417ccaf3ec61a3b369fffdf4', 'user_or_group_name'),
(62, 's', '', 'c3671f07-a390-ddaa-ef13-49d946c4d2ca', '1,3', 'amaya', '', '2019-06-21 08:30:14', 'http://talk2.it369.offline/storage/avatars/sDZWSkCWUzYRWL5YwmAaA4b0bwSpvHVlFKTzrRyv.jpeg', '62f8a352417ccaf3ec61a3b369fffdf4', 'user_or_group_name'),
(63, 'a', '', 'c3671f07-a390-ddaa-ef13-49d946c4d2ca', '1,3', 'amaya', '', '2019-06-21 08:30:17', 'http://talk2.it369.offline/storage/avatars/sDZWSkCWUzYRWL5YwmAaA4b0bwSpvHVlFKTzrRyv.jpeg', '62f8a352417ccaf3ec61a3b369fffdf4', 'user_or_group_name'),
(64, 's', '', 'e4d98ad8-ebf4-8ea5-13c8-637cf421b508,c3671f07-a390-ddaa-ef13-49d946c4d2ca', '3,1', 'Admin', '', '2019-06-21 08:30:45', 'http://talk2.it369.offline/storage/avatars/hKEaVBSfGyvy1dF6ItGcLQNNOR3v4WT3RQDHalq0.jpeg', '62f8a352417ccaf3ec61a3b369fffdf4', 'user_or_group_name'),
(65, 'd', '', 'c3671f07-a390-ddaa-ef13-49d946c4d2ca', '1,3', 'amaya', '', '2019-06-21 08:33:01', 'http://talk2.it369.offline/storage/avatars/sDZWSkCWUzYRWL5YwmAaA4b0bwSpvHVlFKTzrRyv.jpeg', '62f8a352417ccaf3ec61a3b369fffdf4', 'user_or_group_name'),
(66, 'd', '', 'c3671f07-a390-ddaa-ef13-49d946c4d2ca', '1,3', 'amaya', '', '2019-06-21 08:33:05', 'http://talk2.it369.offline/storage/avatars/sDZWSkCWUzYRWL5YwmAaA4b0bwSpvHVlFKTzrRyv.jpeg', '62f8a352417ccaf3ec61a3b369fffdf4', 'user_or_group_name'),
(67, 'as', '', 'c3671f07-a390-ddaa-ef13-49d946c4d2ca', '1,3', 'amaya', '', '2019-06-21 08:35:09', 'http://talk2.it369.offline/storage/avatars/sDZWSkCWUzYRWL5YwmAaA4b0bwSpvHVlFKTzrRyv.jpeg', '62f8a352417ccaf3ec61a3b369fffdf4', 'user_or_group_name'),
(68, 'asd', '', 'c3671f07-a390-ddaa-ef13-49d946c4d2ca', '1,3', 'amaya', '', '2019-06-21 08:35:24', 'http://talk2.it369.offline/storage/avatars/sDZWSkCWUzYRWL5YwmAaA4b0bwSpvHVlFKTzrRyv.jpeg', '62f8a352417ccaf3ec61a3b369fffdf4', 'user_or_group_name'),
(69, 'as', '', 'c3671f07-a390-ddaa-ef13-49d946c4d2ca', '1,3', 'amaya', '', '2019-06-21 08:35:39', 'http://talk2.it369.offline/storage/avatars/sDZWSkCWUzYRWL5YwmAaA4b0bwSpvHVlFKTzrRyv.jpeg', '62f8a352417ccaf3ec61a3b369fffdf4', 'user_or_group_name'),
(70, 'as', '', 'c3671f07-a390-ddaa-ef13-49d946c4d2ca,e4d98ad8-ebf4-8ea5-13c8-637cf421b508', '1,3', 'amaya', '', '2019-06-21 08:35:49', 'http://talk2.it369.offline/storage/avatars/sDZWSkCWUzYRWL5YwmAaA4b0bwSpvHVlFKTzrRyv.jpeg', '62f8a352417ccaf3ec61a3b369fffdf4', 'user_or_group_name'),
(71, 'as', '', 'e4d98ad8-ebf4-8ea5-13c8-637cf421b508,c3671f07-a390-ddaa-ef13-49d946c4d2ca', '3,1', 'Admin', '', '2019-06-21 08:35:52', 'http://talk2.it369.offline/storage/avatars/hKEaVBSfGyvy1dF6ItGcLQNNOR3v4WT3RQDHalq0.jpeg', '62f8a352417ccaf3ec61a3b369fffdf4', 'user_or_group_name'),
(72, 'fds', '', 'c3671f07-a390-ddaa-ef13-49d946c4d2ca', '1,3', 'amaya', '', '2019-06-21 08:36:50', 'http://talk2.it369.offline/storage/avatars/sDZWSkCWUzYRWL5YwmAaA4b0bwSpvHVlFKTzrRyv.jpeg', '62f8a352417ccaf3ec61a3b369fffdf4', 'user_or_group_name'),
(73, 's', '', 'c3671f07-a390-ddaa-ef13-49d946c4d2ca', '1,3', 'amaya', '', '2019-06-21 08:37:42', 'http://talk2.it369.offline/storage/avatars/sDZWSkCWUzYRWL5YwmAaA4b0bwSpvHVlFKTzrRyv.jpeg', '62f8a352417ccaf3ec61a3b369fffdf4', 'user_or_group_name'),
(74, 'asd', '', 'c3671f07-a390-ddaa-ef13-49d946c4d2ca', '1,3', 'amaya', '', '2019-06-21 08:37:53', 'http://talk2.it369.offline/storage/avatars/sDZWSkCWUzYRWL5YwmAaA4b0bwSpvHVlFKTzrRyv.jpeg', '62f8a352417ccaf3ec61a3b369fffdf4', 'user_or_group_name'),
(75, 's', '', 'c3671f07-a390-ddaa-ef13-49d946c4d2ca', '1,3', 'amaya', '', '2019-06-21 08:44:30', 'http://talk2.it369.offline/storage/avatars/sDZWSkCWUzYRWL5YwmAaA4b0bwSpvHVlFKTzrRyv.jpeg', '62f8a352417ccaf3ec61a3b369fffdf4', 'user_or_group_name'),
(76, 'as', '', 'c3671f07-a390-ddaa-ef13-49d946c4d2ca', '1,3', 'amaya', '', '2019-06-21 08:45:16', 'http://talk2.it369.offline/storage/avatars/sDZWSkCWUzYRWL5YwmAaA4b0bwSpvHVlFKTzrRyv.jpeg', '62f8a352417ccaf3ec61a3b369fffdf4', 'user_or_group_name'),
(77, 'as', '', 'c3671f07-a390-ddaa-ef13-49d946c4d2ca,e4d98ad8-ebf4-8ea5-13c8-637cf421b508', '1,3', 'amaya', '', '2019-06-21 08:45:29', 'http://talk2.it369.offline/storage/avatars/sDZWSkCWUzYRWL5YwmAaA4b0bwSpvHVlFKTzrRyv.jpeg', '62f8a352417ccaf3ec61a3b369fffdf4', 'user_or_group_name'),
(78, '33', '', 'c3671f07-a390-ddaa-ef13-49d946c4d2ca', '1,3', 'amaya', '', '2019-06-21 08:54:13', 'http://talk2.it369.offline/storage/avatars/sDZWSkCWUzYRWL5YwmAaA4b0bwSpvHVlFKTzrRyv.jpeg', '62f8a352417ccaf3ec61a3b369fffdf4', 'user_or_group_name'),
(79, '1', '', 'c3671f07-a390-ddaa-ef13-49d946c4d2ca', '1,3', 'amaya', '', '2019-06-21 08:54:28', 'http://talk2.it369.offline/storage/avatars/sDZWSkCWUzYRWL5YwmAaA4b0bwSpvHVlFKTzrRyv.jpeg', '62f8a352417ccaf3ec61a3b369fffdf4', 'user_or_group_name'),
(80, 'Man&nbsp; nam mkata connect una', '', '29f15a9e-d2bb-3010-9647-9917d923ac6d', '1,2,3', 'amaya', '', '2019-06-21 09:29:26', 'http://talk2.it369.offline/storage/avatars/sDZWSkCWUzYRWL5YwmAaA4b0bwSpvHVlFKTzrRyv.jpeg', 'IjIi', 'user_or_group_name'),
(81, '_ðŸ™‚', '', '29f15a9e-d2bb-3010-9647-9917d923ac6d,e4d98ad8-ebf4-8ea5-13c8-637cf421b508', '1,2,3', 'amaya', '', '2019-06-21 09:30:06', 'http://talk2.it369.offline/storage/avatars/sDZWSkCWUzYRWL5YwmAaA4b0bwSpvHVlFKTzrRyv.jpeg', 'IjIi', 'user_or_group_name'),
(82, 'ðŸ˜', '', '29f15a9e-d2bb-3010-9647-9917d923ac6d,e4d98ad8-ebf4-8ea5-13c8-637cf421b508', '1,2,3', 'amaya', '', '2019-06-21 09:30:20', 'http://talk2.it369.offline/storage/avatars/sDZWSkCWUzYRWL5YwmAaA4b0bwSpvHVlFKTzrRyv.jpeg', 'IjIi', 'user_or_group_name'),
(83, 'Mmm', '', '29f15a9e-d2bb-3010-9647-9917d923ac6d,e4d98ad8-ebf4-8ea5-13c8-637cf421b508,a4cdb4a5-e966-e5a1-98e1-7636441268a2', '1,2,3', 'amaya', '', '2019-06-21 09:32:14', 'http://talk2.it369.offline/storage/avatars/sDZWSkCWUzYRWL5YwmAaA4b0bwSpvHVlFKTzrRyv.jpeg', 'IjIi', 'user_or_group_name'),
(84, 'Jddd', '', '29f15a9e-d2bb-3010-9647-9917d923ac6d', '1,3', 'amaya', '', '2019-06-21 09:40:35', 'http://talk2.it369.offline/storage/avatars/sDZWSkCWUzYRWL5YwmAaA4b0bwSpvHVlFKTzrRyv.jpeg', '62f8a352417ccaf3ec61a3b369fffdf4', 'user_or_group_name'),
(85, 'kmpm', '', 'e4d98ad8-ebf4-8ea5-13c8-637cf421b508,29f15a9e-d2bb-3010-9647-9917d923ac6d', '3,1', 'Admin', '', '2019-06-21 09:40:42', 'http://talk2.it369.offline/storage/avatars/hKEaVBSfGyvy1dF6ItGcLQNNOR3v4WT3RQDHalq0.jpeg', '62f8a352417ccaf3ec61a3b369fffdf4', 'user_or_group_name'),
(86, 'klm;', '', 'e4d98ad8-ebf4-8ea5-13c8-637cf421b508,29f15a9e-d2bb-3010-9647-9917d923ac6d', '3,1', 'Admin', '', '2019-06-21 09:40:44', 'http://talk2.it369.offline/storage/avatars/hKEaVBSfGyvy1dF6ItGcLQNNOR3v4WT3RQDHalq0.jpeg', '62f8a352417ccaf3ec61a3b369fffdf4', 'user_or_group_name'),
(87, 'nl', '', 'e4d98ad8-ebf4-8ea5-13c8-637cf421b508,29f15a9e-d2bb-3010-9647-9917d923ac6d', '3,1', 'Admin', '', '2019-06-21 09:40:44', 'http://talk2.it369.offline/storage/avatars/hKEaVBSfGyvy1dF6ItGcLQNNOR3v4WT3RQDHalq0.jpeg', '62f8a352417ccaf3ec61a3b369fffdf4', 'user_or_group_name'),
(88, 'Hahhaha', '', '29f15a9e-d2bb-3010-9647-9917d923ac6d,e4d98ad8-ebf4-8ea5-13c8-637cf421b508', '1,3', 'amaya', '', '2019-06-21 09:40:52', 'http://talk2.it369.offline/storage/avatars/sDZWSkCWUzYRWL5YwmAaA4b0bwSpvHVlFKTzrRyv.jpeg', '62f8a352417ccaf3ec61a3b369fffdf4', 'user_or_group_name'),
(89, 'Haha', '', '29f15a9e-d2bb-3010-9647-9917d923ac6d,e4d98ad8-ebf4-8ea5-13c8-637cf421b508', '1,3', 'amaya', '', '2019-06-21 09:42:47', 'http://talk2.it369.offline/storage/avatars/sDZWSkCWUzYRWL5YwmAaA4b0bwSpvHVlFKTzrRyv.jpeg', '62f8a352417ccaf3ec61a3b369fffdf4', 'user_or_group_name'),
(90, 'sdf', '', 'e4d98ad8-ebf4-8ea5-13c8-637cf421b508', '3,1', 'Admin', '', '2019-06-21 09:57:48', 'http://talk2.it369.offline/storage/avatars/hKEaVBSfGyvy1dF6ItGcLQNNOR3v4WT3RQDHalq0.jpeg', '62f8a352417ccaf3ec61a3b369fffdf4', 'user_or_group_name'),
(91, 'sdf', '', 'e4d98ad8-ebf4-8ea5-13c8-637cf421b508,500b0cf1-418e-f836-98f9-7c3998a1c37f', '3,1', 'Admin', '', '2019-06-21 09:57:58', 'http://talk2.it369.offline/storage/avatars/hKEaVBSfGyvy1dF6ItGcLQNNOR3v4WT3RQDHalq0.jpeg', '62f8a352417ccaf3ec61a3b369fffdf4', 'user_or_group_name'),
(92, 'g', '', 'e4d98ad8-ebf4-8ea5-13c8-637cf421b508,500b0cf1-418e-f836-98f9-7c3998a1c37f', '3,1', 'Admin', '', '2019-06-21 10:00:19', 'http://talk2.it369.offline/storage/avatars/hKEaVBSfGyvy1dF6ItGcLQNNOR3v4WT3RQDHalq0.jpeg', '62f8a352417ccaf3ec61a3b369fffdf4', 'user_or_group_name'),
(93, 'd', '', '500b0cf1-418e-f836-98f9-7c3998a1c37f,e4d98ad8-ebf4-8ea5-13c8-637cf421b508', '1,3', 'amaya', '', '2019-06-21 10:00:21', 'http://talk2.it369.offline/storage/avatars/sDZWSkCWUzYRWL5YwmAaA4b0bwSpvHVlFKTzrRyv.jpeg', '62f8a352417ccaf3ec61a3b369fffdf4', 'user_or_group_name'),
(94, 'f', '', 'e4d98ad8-ebf4-8ea5-13c8-637cf421b508,500b0cf1-418e-f836-98f9-7c3998a1c37f', '1,2,3', 'Admin', '', '2019-06-21 10:02:35', 'http://talk2.it369.offline/storage/avatars/hKEaVBSfGyvy1dF6ItGcLQNNOR3v4WT3RQDHalq0.jpeg', 'IjMi', 'user_or_group_name');

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE `groups` (
  `id` int(10) UNSIGNED NOT NULL,
  `group_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `group_avatar` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(4) NOT NULL COMMENT '1=delete,0=active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `groups`
--

INSERT INTO `groups` (`id`, `group_name`, `group_avatar`, `status`, `created_at`, `updated_at`) VALUES
(1, 'IT369', 'groups_avatars/P6IIEefuIlG7vW97fPauWAFzWrWRR67OkRO1Ajmg.png', 0, '2019-05-27 00:07:27', '2019-06-20 10:51:03'),
(2, 'venus It', 'groups_avatars/VsD9Fb1vPHzrsSoQJondl2HX0Q7NJcervrY8qG6j.jpeg', 0, '2019-05-27 00:07:31', '2019-06-20 11:55:45'),
(3, 'sample', 'groups_avatars/V7AitSPhbcxKRasNiKgEXfP5BWSuAPObDNkgvnaH.jpeg', 0, '2019-05-29 23:54:35', '2019-06-20 10:50:12'),
(4, 'dfdg', 'groups_avatars/3ugJtUqyV5vB2h3tTKTB7HZymgx3je6g1aK2wQBK.jpeg', 0, '2019-05-31 01:44:03', '2019-06-20 11:57:34');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_05_09_060845_create_groups_table', 1),
(4, '2019_05_09_061335_create_user_in_groups_table', 1),
(5, '2019_05_14_062236_create_role_user_pivot_table', 1),
(6, '2019_05_14_062414_create_roles_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Admin', '2019-05-27 00:06:33', '2019-05-27 00:06:33'),
(2, 'Employee', '2019-05-27 00:06:33', '2019-05-27 00:06:33'),
(3, 'Default', '2019-05-27 00:06:33', '2019-05-27 00:06:33');

-- --------------------------------------------------------

--
-- Table structure for table `role_user`
--

CREATE TABLE `role_user` (
  `role_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_user`
--

INSERT INTO `role_user` (`role_id`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 1, '2019-05-27 00:06:33', '2019-05-27 00:06:33'),
(3, 2, NULL, NULL),
(3, 3, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `avatar` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '1=delete,0=active',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `avatar`, `email_verified_at`, `password`, `status`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'admin@admin.com', 'avatars/hKEaVBSfGyvy1dF6ItGcLQNNOR3v4WT3RQDHalq0.jpeg', '2019-05-27 00:06:33', '$2y$10$PktY1FJEC/qe2zArT9YVKOqCTaQTj/3EzUXq8AtiN4jgAmAA4ZWIm', 0, NULL, '2019-05-27 00:06:33', '2019-06-19 05:42:12'),
(2, 'chanaka', 'chanaka@gmail.com', 'avatars/lrtJaHIoMJ5rtGw6Iz9low7T2P7jf6OFkRVlLZfg.jpeg', NULL, '$2y$10$saOPAsc2uXUoYD8YdKntV.QTz.wZDkVl.Xp74Z5L0z39veuZpo6TC', 0, NULL, '2019-05-27 00:54:04', '2019-06-19 23:19:53'),
(3, 'amaya', 'amaya@gmail.com', 'avatars/sDZWSkCWUzYRWL5YwmAaA4b0bwSpvHVlFKTzrRyv.jpeg', NULL, '$2y$10$PktY1FJEC/qe2zArT9YVKOqCTaQTj/3EzUXq8AtiN4jgAmAA4ZWIm', 0, NULL, '2019-05-27 00:54:37', '2019-05-30 12:28:55');

-- --------------------------------------------------------

--
-- Table structure for table `user_in_groups`
--

CREATE TABLE `user_in_groups` (
  `id` int(10) UNSIGNED NOT NULL,
  `group_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `status` tinyint(4) NOT NULL COMMENT '1=delete,0=active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_in_groups`
--

INSERT INTO `user_in_groups` (`id`, `group_id`, `user_id`, `status`, `created_at`, `updated_at`) VALUES
(1, 2, 1, 0, '2019-05-29 23:52:08', '2019-06-20 10:40:36'),
(2, 3, 1, 0, '2019-06-19 02:06:42', '2019-06-20 10:40:36'),
(3, 1, 1, 0, '2019-06-19 02:06:43', '2019-06-20 10:40:36'),
(4, 4, 1, 0, '2019-06-19 02:06:44', '2019-06-20 10:40:36'),
(5, 1, 2, 0, '2019-06-19 02:06:45', '2019-06-19 02:06:49'),
(6, 2, 2, 0, '2019-06-19 02:06:46', '2019-06-19 02:06:49'),
(7, 3, 2, 0, '2019-06-19 02:06:46', '2019-06-19 02:06:49'),
(8, 4, 2, 0, '2019-06-19 02:06:47', '2019-06-19 02:06:49'),
(9, 2, 3, 0, '2019-06-19 02:06:51', '2019-06-19 02:06:58'),
(10, 1, 3, 1, '2019-06-19 02:06:52', '2019-06-19 02:06:58'),
(11, 3, 3, 0, '2019-06-19 02:06:57', '2019-06-19 02:06:58'),
(12, 4, 3, 0, '2019-06-19 02:06:58', '2019-06-19 02:06:58');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `agents`
--
ALTER TABLE `agents`
  ADD PRIMARY KEY (`agent_id`);

--
-- Indexes for table `chats`
--
ALTER TABLE `chats`
  ADD PRIMARY KEY (`chat_id`);

--
-- Indexes for table `groups`
--
ALTER TABLE `groups`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_unique` (`name`);

--
-- Indexes for table `role_user`
--
ALTER TABLE `role_user`
  ADD PRIMARY KEY (`role_id`,`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `user_in_groups`
--
ALTER TABLE `user_in_groups`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_in_groups_group_id_foreign` (`group_id`),
  ADD KEY `user_in_groups_user_id_foreign` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `agents`
--
ALTER TABLE `agents`
  MODIFY `agent_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `chats`
--
ALTER TABLE `chats`
  MODIFY `chat_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=95;

--
-- AUTO_INCREMENT for table `groups`
--
ALTER TABLE `groups`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `user_in_groups`
--
ALTER TABLE `user_in_groups`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `user_in_groups`
--
ALTER TABLE `user_in_groups`
  ADD CONSTRAINT `user_in_groups_group_id_foreign` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_in_groups_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
