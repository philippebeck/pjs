-- ************************
-- ***** DATABASE PJS *****
-- ************************



-- !! This is a database example, allowing to start the CMS...
-- !! You need to change the admin datas (in the User table) to match your project
-- To begin, the admin password is set to = "12345678" (for security : don't forget to change the password)



-- Drops the old database before creates a new one
DROP DATABASE IF EXISTS pjs;


-- Creates the database
CREATE DATABASE pjs CHARACTER SET 'utf8';


-- Uses the database
USE pjs;



-- *************************
-- Creates the table Article
CREATE TABLE IF NOT EXISTS Article
(
  id            SMALLINT      UNSIGNED  PRIMARY KEY AUTO_INCREMENT,
  title         VARCHAR(50)   NOT NULL  UNIQUE,
  image         VARCHAR(50)   NOT NULL  UNIQUE,
  created_date  DATETIME      NOT NULL,
  updated_date  DATETIME      NOT NULL,
  link          VARCHAR(255)  NOT NULL  UNIQUE,
  content       TEXT          NOT NULL
)
ENGINE=INNODB DEFAULT CHARSET=utf8;


-- Inserts the Article data
INSERT INTO Article
(title,                 image,      created_date,           updated_date,           link,                                     content)
VALUES
('Article exemple !',   'pjs.svg',  '2018-01-23 15:30:00',  '2018-01-23 17:30:00',  'https://packagist.org/packages/pjs/pjs', 'This is an article example ! Pjs helps you to create articles very easily : go to the administration to clic on the "create a new article" green button, then complete the fields of the "create article" page & submit it !');



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



-- *************************
-- Creates the table Comment
CREATE TABLE IF NOT EXISTS Comment
(
  id            SMALLINT        UNSIGNED      PRIMARY KEY   AUTO_INCREMENT,
  content       TEXT            NOT NULL,
  created_date  DATETIME        NOT NULL,
  article_id    SMALLINT        UNSIGNED      NOT NULL,
  user_id       SMALLINT        UNSIGNED      NOT NULL,
  CONSTRAINT    fk_article_id   FOREIGN KEY   (article_id)  REFERENCES      Article(id),
  CONSTRAINT    fk_user_id      FOREIGN KEY   (user_id)     REFERENCES      User(id)
)
ENGINE=INNODB DEFAULT CHARSET=utf8;
