-- ************************
-- ***** DATABASE PJS *****
-- ************************



-- !! You need to change the admin data to match your project



-- Drops the old database before creates a new one
DROP DATABASE IF EXISTS pjs;


-- Creates the database
CREATE DATABASE pjs CHARACTER SET 'utf8';


-- Uses the database
USE pjs;



-- **********************
-- Creates the table User
CREATE TABLE IF NOT EXISTS User
(
  id            SMALLINT      UNSIGNED  PRIMARY KEY AUTO_INCREMENT,
  first_name    VARCHAR(20)   NOT NULL,
  last_name     VARCHAR(20)   NOT NULL,
  image         VARCHAR(50),
  zipcode       MEDIUMINT     UNSIGNED,
  country       VARCHAR(20)   NOT NULL,
  email         VARCHAR(100)  NOT NULL  UNIQUE,
  pass          VARCHAR(100)  NOT NULL,
  created_date  DATETIME      NOT NULL,
  updated_date  DATETIME      NOT NULL
)
ENGINE=INNODB DEFAULT CHARSET=utf8;


-- Inserts the User data
INSERT INTO User
(first_name,  last_name,  image,      zipcode,  country,    email,            pass,           created_date,           updated_date)
VALUES
('Admin',     'Pjs',      'pjs.svg',  13660,    'France',   'admin@pjs.com',  '$2y$10$XZ.UnrqdCSkpxzyJUD8JXO3BL3X8vG2AlCXQjST0Prol.kropm1mO',     '2018-01-23 9:00:00',   '2018-01-23 10:00:00');
