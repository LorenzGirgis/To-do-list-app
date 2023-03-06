DROP DATABASE IF EXISTS `todolist`;

CREATE DATABASE `todolist`;

USE `todolist`;

create table `todo` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `naam` varchar(255) NOT NULL,
        `tijd` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (`id`),
        `status` varchar(255) NOT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

  CREATE TABLE `users` (
    id INT(11) AUTO_INCREMENT PRIMARY KEY NOT NULL,
    username TINYTEXT NOT NULL,
    email TINYTEXT NOT NULL,
    password LONGTEXT NOT NULL,
    last_seen varchar(100) NOT NULL
    );
