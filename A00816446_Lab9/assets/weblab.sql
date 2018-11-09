-- phpMyAdmin SQL Dump
-- version 4.8.2
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 09-11-2018 a las 11:38:48
-- Versión del servidor: 10.1.34-MariaDB
-- Versión de PHP: 7.2.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `weblab`
--
CREATE DATABASE IF NOT EXISTS `weblab` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `weblab`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `friendrelations`
--

DROP TABLE IF EXISTS `friendrelations`;
CREATE TABLE `friendrelations` (
  `user1` smallint(5) UNSIGNED NOT NULL,
  `user2` smallint(5) UNSIGNED NOT NULL,
  `areFriends` char(1) NOT NULL DEFAULT 'U' COMMENT 'This value will change from Y yes, U unconfirmed and N for no.'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Table to have all the users that are friends.';

--
-- Volcado de datos para la tabla `friendrelations`
--

INSERT INTO `friendrelations` (`user1`, `user2`, `areFriends`) VALUES
(18, 17, 'Y'),
(18, 19, 'Y'),
(20, 17, 'U');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `useraccounts`
--

DROP TABLE IF EXISTS `useraccounts`;
CREATE TABLE `useraccounts` (
  `userId` smallint(5) UNSIGNED NOT NULL COMMENT 'User Id given in increasing order to allow for relations between tables',
  `username` char(40) NOT NULL COMMENT 'Username for each user.',
  `userProfilePic` text COMMENT 'Path to the image in the filesystem',
  `userFiName` char(50) DEFAULT NULL,
  `userLaName` char(50) DEFAULT NULL,
  `userEmail` char(50) DEFAULT NULL,
  `userPwd` char(255) NOT NULL COMMENT 'We store the hashed password',
  `userSalt` char(255) NOT NULL COMMENT 'Here we store the salt of each password',
  `userGender` tinyint(1) NOT NULL DEFAULT '0',
  `userCountry` char(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Table to keep data of all the registered users.';

--
-- Volcado de datos para la tabla `useraccounts`
--

INSERT INTO `useraccounts` (`userId`, `username`, `userProfilePic`, `userFiName`, `userLaName`, `userEmail`, `userPwd`, `userSalt`, `userGender`, `userCountry`) VALUES
(18, 'Alfredo08', NULL, 'Alfredo', 'Salazar', 'alfredo@gmail.com', '$2y$10$jO6tL3MnliaalbBINp4lpe8RQ4B5cLfJkiY0rgywaPYtKTZHLfW7i', '', 1, 'mex'),
(20, 'Bob', NULL, 'Bob', 'Popeye', 'bob@gmail.com', '$2y$10$2tNDH5W4vRHyNLAjJoUZ8eqCVxSOjZjjq5qQ/NDSFnQnqPDon84pu', '', 1, 'sou'),
(19, 'Dave', NULL, 'Dave', 'Jimenez', 'dave@gmail.com', '$2y$10$2mUjAt2UpaN.Wlfm2RZbdudzNwJEpQjJga9Q2d948DAkFztEm6zAa', '', 1, 'mon'),
(21, 'Emily', NULL, 'Emily', 'Peaterson', 'emily@gmail.com', '$2y$10$.DBtcgOavunNmYMmFW2VmuQ931.T25oQmuGb.SVqe.N8zVGyfwMFq', '', 0, 'ger'),
(17, 'Torec', NULL, 'Hector', 'Hernandez', 'hectorhm1596@gmail.com', '$2y$10$71XXyYr.mOxoARLm.XqpFeVXIvIKJjiej.OMyRmXL495qPSj7g4yi', '', 1, 'mex');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usercomments`
--

DROP TABLE IF EXISTS `usercomments`;
CREATE TABLE `usercomments` (
  `postPosterId` smallint(5) UNSIGNED NOT NULL,
  `postDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `comentId` smallint(5) UNSIGNED NOT NULL COMMENT 'This value will be calculated via PHP so as to keep an order on every post, starting from 1 onwards, since 0 is the actual post. Making 1 top comments and 2 the children of 1 and so on.',
  `text` text NOT NULL COMMENT 'Comment text',
  `commentReplyLevel` tinyint(3) UNSIGNED NOT NULL COMMENT 'This value will be used to determine the style that must be used for the reply comment.',
  `commentReplyingTo` smallint(5) UNSIGNED DEFAULT NULL COMMENT 'Comment to which the current comment is acting as a reply.'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Table to keep record of replies.';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `userposts`
--

DROP TABLE IF EXISTS `userposts`;
CREATE TABLE `userposts` (
  `postPosterId` smallint(5) UNSIGNED NOT NULL COMMENT 'Id of the user who made the post',
  `postDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Date on which the post was made',
  `postText` text COMMENT 'Text of the post',
  `postImage` text NOT NULL COMMENT 'Path to the image in the file system'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Table to have the information of every post.';

--
-- Volcado de datos para la tabla `userposts`
--

INSERT INTO `userposts` (`postPosterId`, `postDate`, `postText`, `postImage`) VALUES
(17, '2018-11-09 10:22:34', 'Hi', ''),
(17, '2018-11-09 10:23:06', 'Hi', ''),
(17, '2018-11-09 10:23:13', 'Hi', ''),
(17, '2018-11-09 10:24:09', 'Hi', ''),
(17, '2018-11-09 10:24:11', 'Hi', ''),
(17, '2018-11-09 10:24:36', 'Hi', ''),
(17, '2018-11-09 10:24:39', 'Hi', ''),
(17, '2018-11-09 10:25:42', 'hello', ''),
(17, '2018-11-09 10:26:03', 'hello', ''),
(17, '2018-11-09 10:27:03', 'bye', ''),
(18, '2018-11-09 10:32:25', 'Hi there torec', ''),
(20, '2018-11-09 10:37:26', 'Is anyone there?', '');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `friendrelations`
--
ALTER TABLE `friendrelations`
  ADD PRIMARY KEY (`user1`,`user2`),
  ADD KEY `user2` (`user2`),
  ADD KEY `user1` (`user1`);

--
-- Indices de la tabla `useraccounts`
--
ALTER TABLE `useraccounts`
  ADD PRIMARY KEY (`username`),
  ADD UNIQUE KEY `userId` (`userId`);

--
-- Indices de la tabla `usercomments`
--
ALTER TABLE `usercomments`
  ADD PRIMARY KEY (`comentId`),
  ADD KEY `postPosterId` (`postPosterId`),
  ADD KEY `postDate` (`postDate`),
  ADD KEY `commentReplyingTo` (`commentReplyingTo`);

--
-- Indices de la tabla `userposts`
--
ALTER TABLE `userposts`
  ADD PRIMARY KEY (`postPosterId`,`postDate`),
  ADD KEY `postPosterId` (`postPosterId`),
  ADD KEY `postDate` (`postDate`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `useraccounts`
--
ALTER TABLE `useraccounts`
  MODIFY `userId` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'User Id given in increasing order to allow for relations between tables', AUTO_INCREMENT=22;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `friendrelations`
--
ALTER TABLE `friendrelations`
  ADD CONSTRAINT `friendrelations_ibfk_1` FOREIGN KEY (`user1`) REFERENCES `useraccounts` (`userId`),
  ADD CONSTRAINT `friendrelations_ibfk_2` FOREIGN KEY (`user2`) REFERENCES `useraccounts` (`userId`);

--
-- Filtros para la tabla `usercomments`
--
ALTER TABLE `usercomments`
  ADD CONSTRAINT `usercomments_ibfk_1` FOREIGN KEY (`postPosterId`) REFERENCES `userposts` (`postPosterId`),
  ADD CONSTRAINT `usercomments_ibfk_2` FOREIGN KEY (`commentReplyingTo`) REFERENCES `usercomments` (`comentId`);

--
-- Filtros para la tabla `userposts`
--
ALTER TABLE `userposts`
  ADD CONSTRAINT `userposts_ibfk_1` FOREIGN KEY (`postPosterId`) REFERENCES `useraccounts` (`userId`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
