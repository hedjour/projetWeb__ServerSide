DROP DATABASE app_db;
CREATE DATABASE app_db;
USE app_db;
CREATE TABLE `user` (
    `id` integer PRIMARY KEY AUTO_INCREMENT,
    `username` varchar(150) UNIQUE NOT NULL,
    `firstname` varchar(150),
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
    `name` varchar(150) NOT NULL
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
# create debug users
INSERT INTO user (username, password)
VALUES ('user1', '$2y$10$2o9ZtmWevHrMFFn1g9BYSOnpUyq6PxcL8GFl6DQpTy8uNssgaUEeq');

INSERT INTO user (username, password)
VALUES ('user2', '$2y$10$2o9ZtmWevHrMFFn1g9BYSOnpUyq6PxcL8GFl6DQpTy8uNssgaUEeq');

INSERT INTO user (username, password)
VALUES ('user3', '$2y$10$2o9ZtmWevHrMFFn1g9BYSOnpUyq6PxcL8GFl6DQpTy8uNssgaUEeq');

INSERT INTO user (username, password)
VALUES ('user4', '$2y$10$2o9ZtmWevHrMFFn1g9BYSOnpUyq6PxcL8GFl6DQpTy8uNssgaUEeq');


# create debug chat rooms
INSERT INTO chat_room (name)
VALUES ('chat_room1');
INSERT INTO chat_room (name)
VALUES ('chat_room2');
INSERT INTO chat_room (name)
VALUES ('chat_room3');
# create debug chatroom relations
# chat_room1 has user1, user2, user3
INSERT INTO chat_room_user (chat_room_id, user_id)
VALUES (1, 1);
INSERT INTO chat_room_user (chat_room_id, user_id)
VALUES (1, 2);
INSERT INTO chat_room_user (chat_room_id, user_id)
VALUES (1, 3);
# chat_room2 has user1, user2
INSERT INTO chat_room_user (chat_room_id, user_id)
VALUES (2, 1);
INSERT INTO chat_room_user (chat_room_id, user_id)
VALUES (2, 2);
# chat_room3 has user3, user2, user4
INSERT INTO chat_room_user (chat_room_id, user_id)
VALUES (3, 3);
INSERT INTO chat_room_user (chat_room_id, user_id)
VALUES (3, 2);
INSERT INTO chat_room_user (chat_room_id, user_id)
VALUES (3, 4);
# debug messages
INSERT INTO message (user_id, chat_room_id, content, sent_date)
VALUES (1, 1, 'Hello world!', '2016-01-01 00:00:00');
INSERT INTO message (user_id, chat_room_id, content, sent_date)
VALUES (2, 1, 'HELLO BACK', '2016-01-01 00:00:01');
INSERT INTO message (user_id, chat_room_id, content, sent_date)
VALUES (4, 2, 'HELLO 1!', '2016-01-01 00:00:01');
INSERT INTO message (user_id, chat_room_id, content, sent_date)
VALUES (3, 2, 'HELLO 2!', '2016-01-01 00:00:01');
SELECT message.id,
    message.id,
    message.user_id,
    message.chat_room_id,
    message.content,
    message.sent_date
FROM message
    INNER JOIN user ON message.user_id = user.id
WHERE message.chat_room_id = 1
ORDER BY message.sent_date