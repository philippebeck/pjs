-- ***** DATABASE PJS *****

-- !! This is a database example, allowing to start the CMS...
-- !! You need to change the admin datas (in the User table) to match your project
-- To begin, the admin password is set to = "12345678" (for security : don't forget to change the password)

DROP DATABASE IF EXISTS pjs;
CREATE DATABASE pjs CHARACTER SET 'utf8';

USE pjs;

CREATE TABLE Article
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

CREATE TABLE User
(
  id            SMALLINT        UNSIGNED  PRIMARY KEY AUTO_INCREMENT,
  name          VARCHAR(50)     NOT NULL,
  image         VARCHAR(50)     UNIQUE,
  email         VARCHAR(100)    NOT NULL  UNIQUE,
  pass          VARCHAR(100)    NOT NULL
)
ENGINE=INNODB DEFAULT CHARSET=utf8;

CREATE TABLE Comment
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

INSERT INTO Article
(title,                 image,      created_date,           updated_date,           link,                                     content)
VALUES
('Article exemple !',   'pjs.png',  '2018-01-23 15:30:00',  '2018-01-23 17:30:00',  'https://packagist.org/packages/pjs/pjs', 'This is an article example ! Pjs helps you to create articles very easily : go to the administration to clic on the "create a new article" green button, then complete the fields of the "create article" page to submit it !');
