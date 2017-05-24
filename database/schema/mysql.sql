SET NAMES utf8;
DROP DATABASE /*!32312 IF EXISTS*/ `demo`;
CREATE DATABASE /*!32312 IF NOT EXISTS*/ `demo` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `demo`;

--
-- Table structure for table `member`
--

DROP TABLE IF EXISTS `member`;
CREATE TABLE `member` (
  `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `member_uuid` CHAR(36) NOT NULL,
  `username` CHAR(80) NOT NULL,
  `password` CHAR(255) NOT NULL,
  `avatar_filename` CHAR(255) NOT NULL DEFAULT '',
  `role` CHAR(24) NOT NULL DEFAULT 'member' COMMENT "member, admin",
  `access_token` CHAR(255) NOT NULL DEFAULT '',
  `data_from` CHAR(36) NOT NULL DEFAULT '',
  `data_from_uuid` CHAR(255) NOT NULL DEFAULT '',
  `is_showed` BOOLEAN NOT NULL DEFAULT 1 comment '0: unshowed, 1: showed',
  `is_locked` BOOLEAN NOT NULL DEFAULT 0 comment '0: unlocked, 1: locked',
  `is_authed` BOOLEAN NOT NULL DEFAULT 1 comment '0: unauthed, 1: authed',
  `is_verified` BOOLEAN NOT NULL DEFAULT 1 comment '0: unverified, 1: verified',
  `last_login_at` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_at` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_by` CHAR(36) NOT NULL DEFAULT '',
  `updated_at` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_by` CHAR(36) NOT NULL DEFAULT '',
  `deleted_at` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted_by` CHAR(36) NOT NULL DEFAULT '',
  `enabled_at` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
  `expired_at` DATETIME NOT NULL DEFAULT '9999-12-30 23:59:59',
  PRIMARY KEY (`id`),
  KEY (`member_uuid`),
  KEY (`role`),
  KEY (`data_from_uuid`),
  KEY (`is_locked`),
  KEY (`created_by`),
  KEY (`updated_by`),
  KEY (`deleted_by`),
  KEY (`enabled_at`),
  KEY (`expired_at`)
) ENGINE=InnoDB AUTO_INCREMENT=1 ROW_FORMAT=COMPRESSED KEY_BLOCK_SIZE=16 CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Table structure for table `api`
--

DROP TABLE IF EXISTS `api`;
CREATE TABLE `api` (
  `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `member_uuid` CHAR(36) NOT NULL,
  `apikey` CHAR(128) NOT NULL DEFAULT '',
  `shared_key` CHAR(128) NOT NULL DEFAULT '',
  `is_locked` BOOLEAN NOT NULL DEFAULT 0 comment '0: unlocked, 1: locked',
  `is_authed` BOOLEAN NOT NULL DEFAULT 1 comment '0: unauthed, 1: authed',
  `is_verified` BOOLEAN NOT NULL DEFAULT 1 comment '0: unverified, 1: verified',
  `created_at` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_by` CHAR(36) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY (`member_uuid`),
  KEY (`is_locked`),
  KEY (`created_by`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `api` WRITE;
INSERT INTO `api` (`member_uuid`, `apikey`, `shared_key`, `is_locked`, `is_authed`, `is_verified`) VALUES
( '358fba8a-4451-4a29-afc1-297ab7a35881' , '123456789012345678901234567890', '', 0, 1, 1 ),
( '84f8abf1-dbd8-4088-94f3-23def3d186c6' , '098765432105432109321098765432', '', 0, 1, 1 );
UNLOCK TABLES;

