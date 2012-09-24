/*
 Navicat Premium Data Transfer

 Source Server         : local
 Source Server Type    : MySQL
 Source Server Version : 50527
 Source Host           : localhost
 Source Database       : laravelbootstrap

 Target Server Type    : MySQL
 Target Server Version : 50527
 File Encoding         : utf-8

 Date: 09/24/2012 09:25:24 AM
*/

/*

    This is a database dump of the framework
    To login:
    /admin
    Username: administrator
    Password: password
    Email Address: example@example.com

*/

SET NAMES utf8;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
--  Table structure for `gallery`
-- ----------------------------
DROP TABLE IF EXISTS `gallery`;
CREATE TABLE `gallery` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `default_image` varchar(255) NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `gallery_id_index` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `gallery_images`
-- ----------------------------
DROP TABLE IF EXISTS `gallery_images`;
CREATE TABLE `gallery_images` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `order` int(11) NOT NULL,
  `gallery_id` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `gallery_images_id_index` (`id`),
  KEY `gallery_images_gallery_id_index` (`gallery_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `news`
-- ----------------------------
DROP TABLE IF EXISTS `news`;
CREATE TABLE `news` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `url_title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `news_id_index` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `pages`
-- ----------------------------
DROP TABLE IF EXISTS `pages`;
CREATE TABLE `pages` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `meta_title` varchar(255) NOT NULL,
  `meta_description` varchar(255) NOT NULL,
  `meta_keywords` varchar(255) NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `pages_id_index` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `role_user`
-- ----------------------------
DROP TABLE IF EXISTS `role_user`;
CREATE TABLE `role_user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `role_user_user_id_index` (`user_id`),
  KEY `role_user_role_id_index` (`role_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `roles`
-- ----------------------------
DROP TABLE IF EXISTS `roles`;
CREATE TABLE `roles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `slug` varchar(200) NOT NULL,
  `name` varchar(200) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `roles_id_index` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `sections`
-- ----------------------------
DROP TABLE IF EXISTS `sections`;
CREATE TABLE `sections` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `order` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `page_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sections_page_id_index` (`page_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `uploads`
-- ----------------------------
DROP TABLE IF EXISTS `uploads`;
CREATE TABLE `uploads` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `link_type` varchar(50) NOT NULL,
  `link_id` int(11) NOT NULL,
  `filename` varchar(255) NOT NULL,
  `small_filename` varchar(255) NOT NULL,
  `thumb_filename` varchar(255) NOT NULL,
  `extension` varchar(10) NOT NULL,
  `user_id` int(11) NOT NULL,
  `image` int(11) NOT NULL,
  `order` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `uploads_link_type_index` (`link_type`),
  KEY `uploads_link_id_index` (`link_id`),
  KEY `uploads_user_id_index` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `users`
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(200) NOT NULL,
  `email` varchar(200) NOT NULL,
  `first_name` varchar(200) NOT NULL,
  `last_name` varchar(200) NOT NULL,
  `password` varchar(200) NOT NULL,
  `last_login` datetime NOT NULL,
  `active` int(11) NOT NULL,
  `admin` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `users_id_index` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Records of `users`
-- ----------------------------
BEGIN;
INSERT INTO `users` VALUES ('1', 'administrator', 'example@example.com', 'Sir Admin', 'Istrator', '$2a$08$LB2BD2vut3J0NBNrUEE9zuE6wZAFM5KR7.O16f5.aoKv4HEIILtA.', '0000-00-00 00:00:00', '1', '1', '2012-09-24 08:22:24', '2012-09-24 08:22:24');
COMMIT;

SET FOREIGN_KEY_CHECKS = 1;
