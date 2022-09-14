CREATE DATABASE IF NOT EXISTS task_force_no_spooks_allowed
  DEFAULT CHARACTER SET UTF8
  DEFAULT COLLATE utf8_general_ci;

USE task_force_no_spooks_allowed;

CREATE TABLE IF NOT EXISTS users
(
  id                INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
  name              VARCHAR(128) NOT NULL,
  email             VARCHAR(255) NOT NULL,
  password          VARCHAR(60)  NOT NULL,
  creation_time DATETIME     NOT NULL,
  phone             VARCHAR(20),
  telegram          VARCHAR(128),
  birthday     DATE,
  about             TEXT,
  city_id           INT UNSIGNED NOT NULL,
  avatar_file_id    INT UNSIGNED,
  UNIQUE KEY unique_email (email),
  UNIQUE KEY unique_phone (phone),
  UNIQUE KEY unique_telegram (telegram)
);

CREATE TABLE IF NOT EXISTS reviews
(
  id            INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
  description   VARCHAR(255)    NOT NULL,
  creation_time DATETIME        NOT NULL DEFAULT CURRENT_TIMESTAMP,
  grade         TINYINT UNSIGNED NOT NULL,
  task_id       INT UNSIGNED    NOT NULL
);

CREATE TABLE IF NOT EXISTS tasks
(
  id              INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
  name            VARCHAR(128)            NOT NULL,
  description     TEXT                    NOT NULL,
  status          ENUM('new', 'cancelled', 'work_in_progress', 'finished', 'failed') DEFAULT 'new',
  category_id     INT UNSIGNED            NOT NULL,
  city_id         INT UNSIGNED            NOT NULL,
  price           DECIMAL(10, 2) UNSIGNED NOT NULL,
  start_date      DATETIME                NOT NULL,
  expiration_date DATETIME                NOT NULL,
  customer_id     INT UNSIGNED            NOT NULL,
  worker_id       INT UNSIGNED
);

CREATE TABLE IF NOT EXISTS cities
(
  id       INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
  name     VARCHAR(128) NOT NULL,
  position POINT        NOT NULL SRID 0
);

CREATE TABLE IF NOT EXISTS categories
(
  id   INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
  name VARCHAR(128) NOT NULL,
  file_id INT UNSIGNED
);

CREATE TABLE IF NOT EXISTS users_categories
(
  id INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
  user_id     INT UNSIGNED NOT NULL,
  category_id INT UNSIGNED NOT NULL
);

CREATE TABLE IF NOT EXISTS files
(
  id        INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
  path      VARCHAR(500) NOT NULL,
  mime_type VARCHAR(255) NOT NULL DEFAULT ''
);

CREATE TABLE IF NOT EXISTS tasks_files
(
  task_id INT UNSIGNED NOT NULL,
  file_id INT UNSIGNED NOT NULL

);

CREATE TABLE IF NOT EXISTS responses
(
  id            INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  message       VARCHAR(255),
  price         DECIMAL(10, 2) NOT NULL,
  creation_time DATETIME       NOT NULL DEFAULT CURRENT_TIMESTAMP,
  task_id       INT UNSIGNED   NOT NULL,
  user_id       INT UNSIGNED   NOT NULL,
  is_declined   BOOLEAN NOT NULL
);

ALTER TABLE users
  ADD
    (
    FOREIGN KEY (city_id) REFERENCES cities (id),
    FOREIGN KEY (avatar_file_id) REFERENCES files(id)
    );

ALTER TABLE reviews
  ADD
    (
    FOREIGN KEY (task_id) REFERENCES tasks (id)
    );

ALTER TABLE tasks
  ADD
    (
    FOREIGN KEY (category_id) REFERENCES categories (id),
    FOREIGN KEY (city_id) REFERENCES cities (id),
    FOREIGN KEY (customer_id) REFERENCES users (id),
    FOREIGN KEY (worker_id) REFERENCES users (id)
    );

ALTER TABLE users_categories
  ADD
    (
    FOREIGN KEY (user_id) REFERENCES users (id),
    FOREIGN KEY (category_id) REFERENCES categories (id)
    );

ALTER TABLE tasks_files
  ADD
    (
    FOREIGN KEY (task_id) REFERENCES tasks (id),
    FOREIGN KEY (file_id) REFERENCES files (id)
    );

ALTER TABLE responses
  ADD
    (
    FOREIGN KEY (task_id) REFERENCES tasks (id),
    FOREIGN KEY (user_id) REFERENCES users (id)
    );

ALTER TABLE categories
  ADD
    (
    FOREIGN KEY (file_id) REFERENCES files (id)
    );
