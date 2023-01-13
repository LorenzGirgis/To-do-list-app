DROP DATABASE IF EXISTS `todolist`;

CREATE DATABASE `todolist`;

USE `todolist`;

create table
    `todo` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `todo` varchar(255) NOT NULL,
        `status` tinyint(1) NOT NULL DEFAULT '0',
        `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
        `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
    
    CREATE TABLE `users` (
    id INT(11) AUTO_INCREMENT PRIMARY KEY NOT NULL,
    username TINYTEXT NOT NULL,
    email TINYTEXT NOT NULL,
    password LONGTEXT NOT NULL,
    last_seen varchar(100) NOT NULL
);
