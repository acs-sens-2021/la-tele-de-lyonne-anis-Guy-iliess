CREATE TABLE `users` (
  `id` integer PRIMARY KEY,
  `user_name` varchar(25),
  `firstname` varchar(50),
  `lastname` varchar(50),
  `mail` varchar(255),
  `password` varchar(4096),
  `roles` json
);

CREATE TABLE `articles` (
  `id` integer PRIMARY KEY,
  `category` varchar(75),
  `created_date` date,
  `update_date` date,
  `title` varchar(50),
  `description` longtext,
  `picture` varchar(250),
  `link` varchar(500),
  `video` longtext,
  `user_id` integer
);

CREATE TABLE `contacts` (
  `id` integer PRIMARY KEY,
  `name` varchar(50),
  `mail` varchar(255),
  `subject` varchar(500),
  `message` longtext,
  `file` varchar(250)
);

CREATE TABLE `newsletters` (
  `id` integer PRIMARY KEY,
  `mail` varchar(255),
  `created_date` date,
  `update_date` date,
  `verified` bool
);

ALTER TABLE `articles` ADD FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
