SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;


DROP TABLE IF EXISTS `s_column`;
CREATE TABLE `s_column` (
  `table` varchar(25) NOT NULL,
  `name` varchar(25) NOT NULL,
  `display_name` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

DROP TABLE IF EXISTS `s_table`;
CREATE TABLE `s_table` (
  `name` varchar(25) NOT NULL,
  `display_name` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

DROP TABLE IF EXISTS `s_user`;
CREATE TABLE `s_user` (
  `id` int(11) NOT NULL,
  `username` varchar(25) NOT NULL,
  `password` varchar(255) NOT NULL,
  `type` enum('admin','user','viewer') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `s_user` (`id`, `username`, `password`, `type`) VALUES
(1, 'admin', '$2y$10$zYcvggp5d9OS/nwDM/dwxuhjx6VvjR6kQftxSFsTju.eEFjpUGrq.', 'admin');


ALTER TABLE `s_column`
  ADD PRIMARY KEY (`table`,`name`);

ALTER TABLE `s_table`
  ADD PRIMARY KEY (`name`);

ALTER TABLE `s_user`
  ADD PRIMARY KEY (`id`);


ALTER TABLE `s_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;


ALTER TABLE `s_column`
  ADD CONSTRAINT `fk_table` FOREIGN KEY (`table`) REFERENCES `s_table` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
