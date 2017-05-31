-- phpMyAdmin SQL Dump
-- version 4.3.11
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 30-05-2017 a las 18:12:09
-- Versión del servidor: 5.6.24
-- Versión de PHP: 5.6.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


--
-- Base de datos: `projectjbxp`
--
--DROP DATABASE `ProjectJBXP`;
--CREATE DATABASE `ProjectJBXP`;
--USE `ProjectJBXP`;
-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `access`
--

CREATE TABLE IF NOT EXISTS `access` (
  `id_user` int(10) NOT NULL DEFAULT '0',
  `id_group` int(10) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `assists`
--

CREATE TABLE IF NOT EXISTS `assists` (
  `id_event` int(10) NOT NULL DEFAULT '0',
  `id_user` int(10) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `assists`
--

INSERT INTO `assists` (`id_event`, `id_user`) VALUES
(1, 1),
(1, 2),
(2, 1),
(2, 4),
(3, 4),
(4, 3),
(5, 1),
(6, 1),
(19, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `chats`
--

CREATE TABLE IF NOT EXISTS `chats` (
  `id_chat` int(10) NOT NULL,
  `from_user` int(11) NOT NULL,
  `to_user` int(11) NOT NULL,
  `message` text NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `events`
--

CREATE TABLE IF NOT EXISTS `events` (
  `id_event` int(10) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `max_assistants` int(100) DEFAULT NULL,
  `event_date` date DEFAULT NULL,
  `id_user` int(10) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `events`
--

INSERT INTO `events` (`id_event`, `name`, `max_assistants`, `event_date`, `id_user`) VALUES
(1, 'Event 1', 10, '2017-03-10', 2),
(2, 'Event 2', 50, '2017-03-20', 4),
(3, 'Event 3', 20, '2017-02-10', 4),
(4, 'Event 4', 50, '2017-02-25', 3),
(5, 'Event 5', 30, '2017-02-11', 1),
(6, 'Event 6', 50, '2017-02-15', 1),
(19, 'new event', 23, '2017-04-12', 1),
(20, 'new event', 34, '2017-01-10', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `friends`
--

CREATE TABLE IF NOT EXISTS `friends` (
  `id_user` int(11) NOT NULL,
  `id_friend` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `friends`
--

INSERT INTO `friends` (`id_user`, `id_friend`) VALUES
(2, 1),
(3, 1),
(4, 1),
(1, 2),
(1, 3),
(2, 3),
(1, 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `groups`
--

CREATE TABLE IF NOT EXISTS `groups` (
  `id_group` int(10) NOT NULL,
  `name` varchar(50) NOT NULL,
  `max_members` int(100) NOT NULL,
  `fundation_date` date DEFAULT NULL,
  `id_user` int(10) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `groups`
--

INSERT INTO `groups` (`id_group`, `name`, `max_members`, `fundation_date`, `id_user`) VALUES
(1, 'Group1', 10, '2017-02-02', 4),
(2, 'Group1', 15, '2017-03-20', 2),
(3, 'Group3', 5, '2017-04-03', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id_user` int(10) NOT NULL,
  `nickname` varchar(30) DEFAULT NULL,
  `password` varchar(30) DEFAULT NULL,
  `email` varchar(70) DEFAULT NULL,
  `name` varchar(20) DEFAULT NULL,
  `surname` varchar(40) DEFAULT NULL,
  `birth_date` date DEFAULT NULL,
  `register_date` date DEFAULT NULL,
  `user_type` int(2) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id_user`, `nickname`, `password`, `email`, `name`, `surname`, `birth_date`, `register_date`, `user_type`) VALUES
(1, 'javier1', 'javier123', 'javier_123@gmail.com', 'javier', 'bueno', '1996-05-03', '2017-04-08', 1),
(2, 'xavier123', 'xavier001', 'xavier456@gmail.com', 'xavier', 'perez', '1995-10-04', '2017-04-08', 1),
(3, 'berto001', 'user001', 'bromero@gmail.com', 'berto', 'romero', '1992-03-12', '2017-04-08', 1),
(4, 'pvilla2', 'user002', 'villa_2@gmail.com', 'pol', 'villa', '2001-06-07', '2017-04-08', 1),
(5, 'admin001', 'admin001', 'admin001@gmail.com', 'null', 'null', '1994-01-20', '2017-04-08', 0),
(6, 'admin002', 'admin002', 'admin002@gmail.com', 'null', 'null', '1992-10-06', '2017-04-08', 0);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `access`
--
ALTER TABLE `access`
  ADD PRIMARY KEY (`id_user`,`id_group`), ADD KEY `id_user` (`id_user`), ADD KEY `id_group` (`id_group`);

--
-- Indices de la tabla `assists`
--
ALTER TABLE `assists`
  ADD PRIMARY KEY (`id_user`,`id_event`), ADD KEY `FK_eventAs` (`id_event`), ADD KEY `id_user` (`id_user`);

--
-- Indices de la tabla `chats`
--
ALTER TABLE `chats`
  ADD PRIMARY KEY (`id_chat`), ADD KEY `from_user` (`from_user`,`to_user`), ADD KEY `to_user` (`to_user`);

--
-- Indices de la tabla `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id_event`), ADD KEY `FK_userEv` (`id_user`);

--
-- Indices de la tabla `friends`
--
ALTER TABLE `friends`
  ADD PRIMARY KEY (`id_user`,`id_friend`), ADD KEY `id_friend` (`id_friend`);

--
-- Indices de la tabla `groups`
--
ALTER TABLE `groups`
  ADD PRIMARY KEY (`id_group`), ADD KEY `FK_userGr` (`id_user`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`), ADD UNIQUE KEY `nickname` (`nickname`), ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `events`
--
ALTER TABLE `events`
  MODIFY `id_event` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=22;
--
-- AUTO_INCREMENT de la tabla `groups`
--
ALTER TABLE `groups`
  MODIFY `id_group` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `access`
--
ALTER TABLE `access`
ADD CONSTRAINT `FK_userAc` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON DELETE CASCADE,
ADD CONSTRAINT `access_ibfk_1` FOREIGN KEY (`id_group`) REFERENCES `groups` (`id_group`) ON DELETE CASCADE;

--
-- Filtros para la tabla `assists`
--
ALTER TABLE `assists`
ADD CONSTRAINT `FK_eventAs` FOREIGN KEY (`id_event`) REFERENCES `events` (`id_event`) ON DELETE CASCADE,
ADD CONSTRAINT `FK_userAs` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON DELETE CASCADE;

--
-- Filtros para la tabla `chats`
--
ALTER TABLE `chats`
ADD CONSTRAINT `chats_ibfk_1` FOREIGN KEY (`from_user`) REFERENCES `users` (`id_user`),
ADD CONSTRAINT `chats_ibfk_2` FOREIGN KEY (`to_user`) REFERENCES `users` (`id_user`);

--
-- Filtros para la tabla `events`
--
ALTER TABLE `events`
ADD CONSTRAINT `FK_userEv` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON DELETE CASCADE;

--
-- Filtros para la tabla `friends`
--
ALTER TABLE `friends`
ADD CONSTRAINT `friends_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`),
ADD CONSTRAINT `friends_ibfk_2` FOREIGN KEY (`id_friend`) REFERENCES `users` (`id_user`);

--
-- Filtros para la tabla `groups`
--
ALTER TABLE `groups`
ADD CONSTRAINT `FK_userGr` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON DELETE CASCADE;

  ADD CONSTRAINT `FK_userGr` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`);
