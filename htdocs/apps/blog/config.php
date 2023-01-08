<?php
return array(
    "name" => "blog",
    "title" => "Blog",
    "params" => array(
    ),

    "db_id" => array(
        "host" => "localhost",
        "name" => "swdf_testblog",
        "user" => "swdf_testblog",
        "password" => "swdf_testblog",
    ),

    "special_actions" => array(
        "default" => array("blog", "guest/home.show", ""),
        "not_found" => array("blog", "common/not_found.show", ""),
    ),

    "meta_table" => "option",
    "sql" => "DROP TABLE IF EXISTS `article`;
CREATE TABLE `article` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `slug` varchar(128) NOT NULL,
  `date` datetime /* mariadb-5.3 */ NOT NULL,
  `title` varchar(128) NOT NULL,
  `keywords` text NOT NULL,
  `description` text NOT NULL,
  `content` longtext NOT NULL,
  `category_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `article_file`;
CREATE TABLE `article_file` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `article_id` int(11) NOT NULL,
  `file_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB CHARSET=utf8;


DROP TABLE IF EXISTS `article_tag`;
CREATE TABLE `article_tag` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `article_id` int(11) NOT NULL,
  `tag_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `category`;
CREATE TABLE `category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `slug` varchar(64) NOT NULL,
  `name` varchar(64) NOT NULL,
  `description` text DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `comment`;
CREATE TABLE `comment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` datetime /* mariadb-5.3 */ NOT NULL,
  `number` int(11) DEFAULT NULL,
  `user` varchar(32) NOT NULL,
  `mail` varchar(256) NOT NULL,
  `site` varchar(256) DEFAULT NULL,
  `content` text NOT NULL,
  `author` tinyint(1) DEFAULT 0,
  `target_id` int(11) DEFAULT NULL,
  `article_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `file`;
CREATE TABLE `file` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` datetime /* mariadb-5.3 */ NOT NULL,
  `name` varchar(128) NOT NULL,
  `host` varchar(128) NOT NULL,
  `folder` varchar(128) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `option`;
CREATE TABLE `option` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(32) NOT NULL,
  `value` longtext DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `page`;
CREATE TABLE `page` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `slug` varchar(128) NOT NULL,
  `date` datetime /* mariadb-5.3 */ NOT NULL,
  `content` longtext NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `tag`;
CREATE TABLE `tag` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `slug` varchar(64) NOT NULL,
  `name` varchar(64) NOT NULL,
  `description` text DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(32) NOT NULL,
  `password_hash` varchar(256) NOT NULL,
  `serial` varchar(256) NOT NULL,
  `stamp` varchar(256) NOT NULL,
  `session_time_stamp` varchar(256) NOT NULL,
  `last_session_id` varchar(256) NOT NULL,
  `form_stamp` varchar(256) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;",
);
?>
