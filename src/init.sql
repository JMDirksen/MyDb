-- Adminer 4.8.1 MySQL 5.5.5-10.7.3-MariaDB-1:10.7.3+maria~focal dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

SET NAMES utf8mb4;

DROP TABLE IF EXISTS `s_column`;
CREATE TABLE `s_column` (
  `table` varchar(25) NOT NULL,
  `name` varchar(25) NOT NULL,
  `display_name` varchar(25) NOT NULL,
  `type` varchar(10) NOT NULL,
  PRIMARY KEY (`table`,`name`),
  CONSTRAINT `fk_table` FOREIGN KEY (`table`) REFERENCES `s_table` (`name`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


DROP TABLE IF EXISTS `s_table`;
CREATE TABLE `s_table` (
  `name` varchar(25) NOT NULL,
  `display_name` varchar(25) NOT NULL,
  `hidden` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


DROP TABLE IF EXISTS `s_user`;
CREATE TABLE `s_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(25) NOT NULL,
  `password` varchar(255) NOT NULL,
  `type` enum('admin','user','viewer') NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `s_user` (`id`, `username`, `password`, `type`) VALUES
(1,	'admin',	'$2y$10$zYcvggp5d9OS/nwDM/dwxuhjx6VvjR6kQftxSFsTju.eEFjpUGrq.',	'admin');

-- 2022-05-22 09:41:30
