DROP DATABASE app_db;
CREATE DATABASE app_db;
USE app_db;
CREATE TABLE `user` (
    `id` integer PRIMARY KEY AUTO_INCREMENT,
    `username` varchar(150) UNIQUE NOT NULL,
    `first_name` varchar(150),
    `email` varchar(300) UNIQUE,
    `surname` varchar(150),
    `password` char(128) NOT NULL,
    `date_joined` datetime,
    `last_login` datetime,
    `is_active` boolean,
    `profile_picture` varchar(300),
    `pixels_placed` int,
    `next_time_pixel` datetime
);
CREATE TABLE `chat_room` (
    `id` integer PRIMARY KEY AUTO_INCREMENT,
    `Name` varchar(150) NOT NULL
);
CREATE TABLE `chat_room_user` (
    `id` integer PRIMARY KEY AUTO_INCREMENT,
    `chat_room_id` integer NOT NULL,
    `user_id` integer NOT NULL
);
CREATE TABLE `message` (
    `id` integer PRIMARY KEY AUTO_INCREMENT,
    `user_id` integer NOT NULL,
    `chat_room_id` integer NOT NULL,
    `content` varchar(500) NOT NULL,
    `sent_date` datetime
);
CREATE TABLE `pixel` (
    `id` int PRIMARY KEY AUTO_INCREMENT,
    `x_position` integer,
    `y_position` integer,
    `color_id` int NOT NULL,
    `user_id` int NOT NULL,
    `time_placed` datetime,
    `number_of_time_placed` int
);
CREATE TABLE `color` (
    `id` integer PRIMARY KEY AUTO_INCREMENT,
    `red` int,
    `green` int,
    `blue` int
);
ALTER TABLE `chat_room_user`
ADD FOREIGN KEY (`chat_room_id`) REFERENCES `chat_room` (`id`);
ALTER TABLE `chat_room_user`
ADD FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);
ALTER TABLE `message`
ADD FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);
ALTER TABLE `message`
ADD FOREIGN KEY (`chat_room_id`) REFERENCES `chat_room` (`id`);
ALTER TABLE `pixel`
ADD FOREIGN KEY (`color_id`) REFERENCES `color` (`id`);
ALTER TABLE `pixel`
ADD FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);