SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+05:30";

CREATE TABLE `messages` (
  `msg_id` int(11) NOT NULL AUTO_INCREMENT,
  `incoming_msg_id` int(255) NOT NULL,
  `outgoing_msg_id` int(255) NOT NULL,
  `msg` varchar(65535),
  `path` varchar(65535),
  `type` ENUM('text', 'image', 'video', 'audio') NOT NULL,
  `timestamp` timestamp NOT NULL,
  `session_id` int(11) NOT NULL,
  PRIMARY KEY (`msg_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `unique_id` int(255) NOT NULL,
  `fname` varchar(255) NOT NULL,
  `lname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `img` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `lastseen` timestamp NOT NULL,
  `role` ENUM('Admin', 'User') NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `activity` (
  `activity_id` int(11) NOT NULL AUTO_INCREMENT,
  `session_id` int(11) NOT NULL,
  `timestamp` timestamp NULL DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `activity_description` mediumtext NOT NULL,
  PRIMARY KEY (`activity_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `users` (`user_id`, `unique_id`, `fname`, `lname`, `email`, `password`, `img`, `status`, `lastseen`, `role`) 
VALUES (NULL, '134451108', 'Manvendra', 'Singh', 'msingh4@baskethunt.in', '8bbdc640ad83fe10b589af830cc5f6cf', '1686739850IMG_20221218_184509.png', 'Active now', '2023-06-20 18:38:37', 'Admin')

CREATE TABLE `homepage` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `display` enum('Yes','No','','') NOT NULL DEFAULT 'Yes'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `sessions` (
  `session_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(255) NOT NULL,
  `logintime` timestamp NULL,
  `logouttime` timestamp NULL,
  PRIMARY KEY (`session_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `homepage` (`id`, `title`, `display`) VALUES
(0, 'ChatApp', 'No');
