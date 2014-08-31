# ************************************************************
# Sequel Pro SQL dump
# Version 4096
#
# http://www.sequelpro.com/
# http://code.google.com/p/sequel-pro/
#
# Host: ibeautytwdb.cvxygpm3rrds.ap-northeast-1.rds.amazonaws.com (MySQL 5.5.27-log)
# Database: fgplay_rails
# Generation Time: 2014-09-02 02:30:11 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table _authorizations
# ------------------------------------------------------------

DROP TABLE IF EXISTS `_authorizations`;

CREATE TABLE `_authorizations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `provider` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `uid` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `memo` text COLLATE utf8_unicode_ci,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `user_id_token` (`user_id`,`token`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



# Dump of table api_logs
# ------------------------------------------------------------

DROP TABLE IF EXISTS `api_logs`;

CREATE TABLE `api_logs` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `method` varchar(50) DEFAULT NULL,
  `uri` text,
  `get_data` text,
  `post_data` text,
  `ip` varchar(20) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table beauties
# ------------------------------------------------------------

DROP TABLE IF EXISTS `beauties`;

CREATE TABLE `beauties` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `label` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `avatar` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `is_stick` tinyint(1) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `status` int(11) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



# Dump of table black_users
# ------------------------------------------------------------

DROP TABLE IF EXISTS `black_users`;

CREATE TABLE `black_users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `country` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table brands
# ------------------------------------------------------------

DROP TABLE IF EXISTS `brands`;

CREATE TABLE `brands` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `link` text,
  `sort` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `country` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `index_brands_on_sort` (`sort`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table categories
# ------------------------------------------------------------

DROP TABLE IF EXISTS `categories`;

CREATE TABLE `categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `sort` int(11) DEFAULT NULL,
  `is_enabled` tinyint(1) DEFAULT '0',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `country` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



# Dump of table category_maps
# ------------------------------------------------------------

DROP TABLE IF EXISTS `category_maps`;

CREATE TABLE `category_maps` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `category_id` int(11) DEFAULT NULL,
  `category_tag_id` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `sort` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table category_tags
# ------------------------------------------------------------

DROP TABLE IF EXISTS `category_tags`;

CREATE TABLE `category_tags` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `sort` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `country` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



# Dump of table click_counts
# ------------------------------------------------------------

DROP TABLE IF EXISTS `click_counts`;

CREATE TABLE `click_counts` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `object` varchar(50) DEFAULT NULL,
  `object_id` int(11) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `count` int(11) DEFAULT '1',
  `url` varchar(500) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `country` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `object` (`object`,`object_id`,`date`),
  KEY `date_object_count` (`object`,`object_id`,`date`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table crawl_site_items
# ------------------------------------------------------------

DROP TABLE IF EXISTS `crawl_site_items`;

CREATE TABLE `crawl_site_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `url` text COLLATE utf8_unicode_ci,
  `hash` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `crawled` tinyint(1) DEFAULT '0',
  `category_id` int(11) DEFAULT NULL,
  `assign_user_id` int(11) DEFAULT NULL,
  `assign_tag` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `priority` int(11) DEFAULT '0',
  `keywords` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `status` int(11) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



# Dump of table crontab_logs
# ------------------------------------------------------------

DROP TABLE IF EXISTS `crontab_logs`;

CREATE TABLE `crontab_logs` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `class_name` varchar(30) DEFAULT NULL,
  `method_name` varchar(80) DEFAULT NULL,
  `is_finish` int(11) NOT NULL DEFAULT '0',
  `start_at` varchar(30) DEFAULT NULL,
  `run_time` varchar(80) NOT NULL DEFAULT '0',
  `finish_at` varchar(30) DEFAULT NULL,
  `comment` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table day_pageviews
# ------------------------------------------------------------

DROP TABLE IF EXISTS `day_pageviews`;

CREATE TABLE `day_pageviews` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `object` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `object_id` int(11) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `counts` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `object_date` (`object`,`object_id`,`date`),
  KEY `average` (`object_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



# Dump of table del_searches
# ------------------------------------------------------------

DROP TABLE IF EXISTS `del_searches`;

CREATE TABLE `del_searches` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `path` text,
  `share_ids` text,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table delayed_jobs
# ------------------------------------------------------------

DROP TABLE IF EXISTS `delayed_jobs`;

CREATE TABLE `delayed_jobs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `priority` int(11) DEFAULT '0',
  `attempts` int(11) DEFAULT '0',
  `handler` text,
  `last_error` text,
  `run_at` datetime DEFAULT NULL,
  `locked_at` datetime DEFAULT NULL,
  `failed_at` datetime DEFAULT NULL,
  `locked_by` varchar(255) DEFAULT NULL,
  `queue` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `delayed_jobs_priority` (`priority`,`run_at`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table facebook_friends
# ------------------------------------------------------------

DROP TABLE IF EXISTS `facebook_friends`;

CREATE TABLE `facebook_friends` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `facebook_id` varchar(256) DEFAULT NULL,
  `style_id` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `is_readed` int(11) DEFAULT NULL,
  `facebook_name` varchar(256) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id_facebook_id_index` (`user_id`,`facebook_id`(255))
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table facebook_uuids
# ------------------------------------------------------------

DROP TABLE IF EXISTS `facebook_uuids`;

CREATE TABLE `facebook_uuids` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `uu_type` varchar(20) NOT NULL,
  `uu_id` varchar(100) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table fake_likes
# ------------------------------------------------------------

DROP TABLE IF EXISTS `fake_likes`;

CREATE TABLE `fake_likes` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `share_id` int(11) DEFAULT NULL,
  `date` varchar(20) DEFAULT NULL,
  `is_finish` tinyint(1) DEFAULT '0',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `date` (`date`,`is_finish`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table fake_product_urls
# ------------------------------------------------------------

DROP TABLE IF EXISTS `fake_product_urls`;

CREATE TABLE `fake_product_urls` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `url` text COLLATE utf8_unicode_ci,
  `postnum` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `status` int(11) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



# Dump of table fashion_editors
# ------------------------------------------------------------

DROP TABLE IF EXISTS `fashion_editors`;

CREATE TABLE `fashion_editors` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `type` varchar(50) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `link` text,
  `sort` int(11) DEFAULT '0',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `country` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table fashion_guide_coins
# ------------------------------------------------------------

DROP TABLE IF EXISTS `fashion_guide_coins`;

CREATE TABLE `fashion_guide_coins` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `message` varchar(255) DEFAULT NULL,
  `coinable_type` varchar(255) DEFAULT NULL,
  `coinable_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `bonus` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table fashion_peoples
# ------------------------------------------------------------

DROP TABLE IF EXISTS `fashion_peoples`;

CREATE TABLE `fashion_peoples` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `link` text,
  `sort` int(11) DEFAULT '0',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table ftv_bloggers
# ------------------------------------------------------------

DROP TABLE IF EXISTS `ftv_bloggers`;

CREATE TABLE `ftv_bloggers` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `blog_id` int(11) DEFAULT NULL,
  `cover_url` varchar(256) DEFAULT NULL,
  `title` varchar(256) DEFAULT NULL,
  `description` varchar(256) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `is_enabled` int(11) DEFAULT '1',
  `blog_url` varchar(256) DEFAULT NULL,
  `user_picture_url` varchar(256) DEFAULT '',
  `cate` varchar(256) DEFAULT NULL,
  `blog_nickname` varchar(256) DEFAULT NULL,
  `user_url` varchar(256) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table ftv_discussions
# ------------------------------------------------------------

DROP TABLE IF EXISTS `ftv_discussions`;

CREATE TABLE `ftv_discussions` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `topic_id` int(11) NOT NULL,
  `is_enabled` int(11) DEFAULT '1',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table ftv_likes
# ------------------------------------------------------------

DROP TABLE IF EXISTS `ftv_likes`;

CREATE TABLE `ftv_likes` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `share_id` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table ftv_magazines
# ------------------------------------------------------------

DROP TABLE IF EXISTS `ftv_magazines`;

CREATE TABLE `ftv_magazines` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `is_enabled` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `title` varchar(256) DEFAULT NULL,
  `picture` text,
  `year` int(11) DEFAULT NULL,
  `month` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table ftv_pk_magazines
# ------------------------------------------------------------

DROP TABLE IF EXISTS `ftv_pk_magazines`;

CREATE TABLE `ftv_pk_magazines` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `title` varchar(256) DEFAULT NULL,
  `is_enabled` int(11) DEFAULT '1',
  `start_time` datetime DEFAULT NULL,
  `end_time` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table ftv_pk_pictures
# ------------------------------------------------------------

DROP TABLE IF EXISTS `ftv_pk_pictures`;

CREATE TABLE `ftv_pk_pictures` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `ftv_pk_magazine_id` int(11) DEFAULT NULL,
  `title` varchar(256) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `picture` varchar(256) DEFAULT NULL,
  `adjust_votes` int(11) DEFAULT '0',
  `votes` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table ftv_pk_votes
# ------------------------------------------------------------

DROP TABLE IF EXISTS `ftv_pk_votes`;

CREATE TABLE `ftv_pk_votes` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `ftv_pk_picture_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `date` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table ftv_previews
# ------------------------------------------------------------

DROP TABLE IF EXISTS `ftv_previews`;

CREATE TABLE `ftv_previews` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(256) DEFAULT NULL,
  `url` varchar(256) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `is_enabled` int(11) DEFAULT '1',
  `is_visible` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table ftv_replays
# ------------------------------------------------------------

DROP TABLE IF EXISTS `ftv_replays`;

CREATE TABLE `ftv_replays` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `is_enabled` int(11) DEFAULT '1',
  `title` varchar(256) DEFAULT NULL,
  `url` varchar(256) DEFAULT NULL,
  `picture` varchar(256) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `date` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table ftv_share_likes
# ------------------------------------------------------------

DROP TABLE IF EXISTS `ftv_share_likes`;

CREATE TABLE `ftv_share_likes` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `share1_id` int(11) DEFAULT NULL,
  `share2_id` int(11) DEFAULT NULL,
  `is_enabled` int(11) DEFAULT '1',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  `title` varchar(256) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table ftv_super_models
# ------------------------------------------------------------

DROP TABLE IF EXISTS `ftv_super_models`;

CREATE TABLE `ftv_super_models` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `is_enabled` int(11) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table ftv_topics
# ------------------------------------------------------------

DROP TABLE IF EXISTS `ftv_topics`;

CREATE TABLE `ftv_topics` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `date` date DEFAULT NULL,
  `title` varchar(256) DEFAULT NULL,
  `content` text,
  `picture` varchar(256) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `is_enabled` int(11) DEFAULT '1',
  `url` varchar(256) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table groups
# ------------------------------------------------------------

DROP TABLE IF EXISTS `groups`;

CREATE TABLE `groups` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `description` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table hot_tags
# ------------------------------------------------------------

DROP TABLE IF EXISTS `hot_tags`;

CREATE TABLE `hot_tags` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `link` text,
  `sort` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `category_id_and_sort` (`category_id`,`sort`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table img10x10
# ------------------------------------------------------------

DROP TABLE IF EXISTS `img10x10`;

CREATE TABLE `img10x10` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `img_link` varchar(255) DEFAULT NULL COMMENT '內容連結頁',
  `img_url` varchar(255) DEFAULT NULL COMMENT '圖片位址',
  `img_content` varchar(255) DEFAULT NULL COMMENT '圖片內容',
  `insert_time` datetime DEFAULT NULL COMMENT '新增時間',
  `page` int(11) DEFAULT NULL,
  `is_enabled` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table index_banners
# ------------------------------------------------------------

DROP TABLE IF EXISTS `index_banners`;

CREATE TABLE `index_banners` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `link` varchar(500) DEFAULT '',
  `file` varchar(255) NOT NULL DEFAULT '',
  `datetime_from` datetime DEFAULT NULL,
  `datetime_end` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `country` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `allow_time` (`datetime_from`,`datetime_end`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table jobs
# ------------------------------------------------------------

DROP TABLE IF EXISTS `jobs`;

CREATE TABLE `jobs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



# Dump of table login_attempts
# ------------------------------------------------------------

DROP TABLE IF EXISTS `login_attempts`;

CREATE TABLE `login_attempts` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `ip_address` varbinary(16) NOT NULL,
  `login` varchar(100) NOT NULL,
  `time` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `ip_address` (`ip_address`),
  KEY `login` (`login`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table magazine_promos
# ------------------------------------------------------------

DROP TABLE IF EXISTS `magazine_promos`;

CREATE TABLE `magazine_promos` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `desc` varchar(255) DEFAULT NULL,
  `magazine_ids` varchar(155) DEFAULT NULL,
  `sort` int(11) DEFAULT '0',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `country` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table magazine_shares
# ------------------------------------------------------------

DROP TABLE IF EXISTS `magazine_shares`;

CREATE TABLE `magazine_shares` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `magazine_id` int(11) DEFAULT NULL,
  `share_id` int(11) DEFAULT NULL,
  `cover_sort` int(11) DEFAULT '0',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `text` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `magazine_shares_magazine_id_index` (`magazine_id`),
  KEY `magazines_cover_index_using_filesort` (`cover_sort`,`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table magazine_subscriptions
# ------------------------------------------------------------

DROP TABLE IF EXISTS `magazine_subscriptions`;

CREATE TABLE `magazine_subscriptions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `magazine_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table magazine_weights
# ------------------------------------------------------------

DROP TABLE IF EXISTS `magazine_weights`;

CREATE TABLE `magazine_weights` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `magazine_id` int(11) DEFAULT NULL,
  `weight` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `country` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



# Dump of table magazines
# ------------------------------------------------------------

DROP TABLE IF EXISTS `magazines`;

CREATE TABLE `magazines` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` int(11) DEFAULT NULL,
  `cover_picture` varchar(255) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `description` text,
  `is_enabled` tinyint(1) DEFAULT '1',
  `magazine_shares_count` int(11) DEFAULT '0',
  `user_id` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `magazine_subscriptions_count` int(11) DEFAULT '0',
  `views_count` int(11) DEFAULT '0',
  `keywords` varchar(255) DEFAULT NULL,
  `new_cover_picture` varchar(255) DEFAULT NULL,
  `is_pick` int(11) DEFAULT NULL,
  `add_picked_at` datetime DEFAULT NULL,
  `memo` text,
  `country` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `magazines_user_id_index` (`user_id`),
  KEY `magazines_is_enabled_index` (`is_enabled`),
  KEY `magazines_updated_list_index` (`is_enabled`,`magazine_shares_count`,`updated_at`),
  KEY `magazines_updated_list_index_using_filesort` (`is_enabled`,`updated_at`),
  KEY `is_pick` (`magazine_shares_count`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table mapi_logs
# ------------------------------------------------------------

DROP TABLE IF EXISTS `mapi_logs`;

CREATE TABLE `mapi_logs` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `token` varchar(55) DEFAULT NULL,
  `method` varchar(50) DEFAULT NULL,
  `uri` text,
  `get_data` text,
  `post_data` text,
  `ip` varchar(20) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table migrations
# ------------------------------------------------------------

DROP TABLE IF EXISTS `migrations`;

CREATE TABLE `migrations` (
  `version` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table mobile_devices
# ------------------------------------------------------------

DROP TABLE IF EXISTS `mobile_devices`;

CREATE TABLE `mobile_devices` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `device_id` varchar(255) DEFAULT NULL,
  `user_id` int(11) NOT NULL DEFAULT '0',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `device` varchar(50) DEFAULT NULL,
  `device_name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table nav_categories
# ------------------------------------------------------------

DROP TABLE IF EXISTS `nav_categories`;

CREATE TABLE `nav_categories` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) DEFAULT NULL COMMENT '父 ID',
  `name` varchar(255) DEFAULT NULL COMMENT '分類名稱',
  `ename` varchar(255) DEFAULT NULL COMMENT '分類English name',
  `sort` int(11) DEFAULT NULL COMMENT '排序',
  `block` varchar(255) DEFAULT NULL COMMENT '顯示區塊',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `pic` varchar(255) DEFAULT NULL,
  `memo` text,
  `country` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table new_categories
# ------------------------------------------------------------

DROP TABLE IF EXISTS `new_categories`;

CREATE TABLE `new_categories` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) DEFAULT NULL COMMENT '父id',
  `name` varchar(255) DEFAULT NULL COMMENT '分類名稱',
  `e_name` varchar(255) DEFAULT NULL,
  `sort` int(11) DEFAULT NULL,
  `status` tinyint(3) DEFAULT '1',
  `is_enabled` tinyint(1) DEFAULT '1',
  `meta_keywords` varchar(255) DEFAULT NULL,
  `meta_description` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `score` int(11) DEFAULT '0',
  `style_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `name` (`name`),
  KEY `parent_id` (`parent_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table new_notices
# ------------------------------------------------------------

DROP TABLE IF EXISTS `new_notices`;

CREATE TABLE `new_notices` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `target_user_id` int(11) DEFAULT NULL COMMENT 'share發文者',
  `from_user` text CHARACTER SET latin1 NOT NULL COMMENT '留言、喜歡、收藏、關注者',
  `total_count` int(11) DEFAULT '1' COMMENT '總人數',
  `read_status` tinyint(1) DEFAULT '0' COMMENT '讀取狀態;0:未讀、1:已讀',
  `notice_type` int(11) DEFAULT NULL COMMENT '訊息類型;1 = like喜歡、2 = collect收藏、3 = comment回應、4 = follow關注、5 = system系統站方',
  `noticeable_type` varchar(50) CHARACTER SET latin1 DEFAULT NULL COMMENT '訊息object',
  `noticeable_id` int(11) DEFAULT NULL COMMENT 'share系統編號',
  `remarks` varchar(255) DEFAULT NULL COMMENT '記錄最新一筆留言內容',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `notice_search` (`target_user_id`,`notice_type`,`noticeable_type`,`noticeable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table noticer_lists
# ------------------------------------------------------------

DROP TABLE IF EXISTS `noticer_lists`;

CREATE TABLE `noticer_lists` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `notice_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `remarks` varchar(255) DEFAULT NULL,
  `read_time` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `noticer_lists_notice_id_user_id_created_at_index` (`notice_id`,`user_id`,`created_at`),
  KEY `noticer_lists_notice_id_user_id_updated_at_created_at_index` (`notice_id`,`user_id`,`updated_at`,`created_at`),
  KEY `notice_id_index` (`notice_id`),
  KEY `user_id_index` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table noticer_lists_copy
# ------------------------------------------------------------

DROP TABLE IF EXISTS `noticer_lists_copy`;

CREATE TABLE `noticer_lists_copy` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `notice_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `remarks` varchar(255) DEFAULT NULL,
  `read_time` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `noticer_lists_notice_id_user_id_created_at_index` (`notice_id`,`user_id`,`created_at`),
  KEY `noticer_lists_notice_id_user_id_updated_at_created_at_index` (`notice_id`,`user_id`,`updated_at`,`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table notices
# ------------------------------------------------------------

DROP TABLE IF EXISTS `notices`;

CREATE TABLE `notices` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `read_status` tinyint(1) DEFAULT '0',
  `notice_type` int(11) DEFAULT NULL,
  `noticer_lists_count` int(11) DEFAULT NULL,
  `noticeable_type` varchar(255) DEFAULT NULL,
  `noticeable_id` int(11) DEFAULT NULL,
  `remarks` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `notices_user_id_updated_at_index` (`user_id`,`updated_at`),
  KEY `notices_user_id_notice_type_index` (`user_id`,`notice_type`),
  KEY `user_id_status_index` (`read_status`,`user_id`),
  KEY `user_id_index` (`user_id`),
  KEY `created_index` (`created_at`),
  KEY `user_id_created_at_index` (`user_id`,`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table notices_copy
# ------------------------------------------------------------

DROP TABLE IF EXISTS `notices_copy`;

CREATE TABLE `notices_copy` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `read_status` tinyint(1) DEFAULT '0',
  `notice_type` int(11) DEFAULT NULL,
  `noticer_lists_count` int(11) DEFAULT NULL,
  `noticeable_type` varchar(255) DEFAULT NULL,
  `noticeable_id` int(11) DEFAULT NULL,
  `remarks` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `notices_user_id_updated_at_index` (`user_id`,`updated_at`),
  KEY `notices_user_id_notice_type_index` (`user_id`,`notice_type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table outdoor_choices
# ------------------------------------------------------------

DROP TABLE IF EXISTS `outdoor_choices`;

CREATE TABLE `outdoor_choices` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `share_id` int(11) DEFAULT NULL,
  `user_name` varchar(255) DEFAULT NULL,
  `country` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table outdoors
# ------------------------------------------------------------

DROP TABLE IF EXISTS `outdoors`;

CREATE TABLE `outdoors` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `share_id` int(11) DEFAULT NULL,
  `user_name` varchar(255) DEFAULT NULL,
  `country` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table pictures
# ------------------------------------------------------------

DROP TABLE IF EXISTS `pictures`;

CREATE TABLE `pictures` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `picture` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `status` int(11) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



# Dump of table post_topic_references
# ------------------------------------------------------------

DROP TABLE IF EXISTS `post_topic_references`;

CREATE TABLE `post_topic_references` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `post_id` int(11) DEFAULT NULL,
  `topic_id` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



# Dump of table posts
# ------------------------------------------------------------

DROP TABLE IF EXISTS `posts`;

CREATE TABLE `posts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `text` text COLLATE utf8_unicode_ci,
  `parent_id` int(11) DEFAULT NULL,
  `share_id` int(11) DEFAULT NULL,
  `group_id` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `status` int(11) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



# Dump of table privileges
# ------------------------------------------------------------

DROP TABLE IF EXISTS `privileges`;

CREATE TABLE `privileges` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `label` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `locked` tinyint(1) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `status` int(11) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



# Dump of table products
# ------------------------------------------------------------

DROP TABLE IF EXISTS `products`;

CREATE TABLE `products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `label` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `text` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `link` text COLLATE utf8_unicode_ci,
  `title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `share_id` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `status` int(11) DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `products_share_id_index` (`share_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



# Dump of table promos
# ------------------------------------------------------------

DROP TABLE IF EXISTS `promos`;

CREATE TABLE `promos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `block` varchar(255) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `content` text,
  `link` text,
  `picture` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `country` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table share_comment_syncs
# ------------------------------------------------------------

DROP TABLE IF EXISTS `share_comment_syncs`;

CREATE TABLE `share_comment_syncs` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `cn_share_comment_id` int(11) DEFAULT NULL,
  `in_share_comment_id` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



# Dump of table share_comments
# ------------------------------------------------------------

DROP TABLE IF EXISTS `share_comments`;

CREATE TABLE `share_comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `text` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `share_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `status` int(11) DEFAULT '1',
  `country` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `share_comments_share_id_index` (`share_id`),
  KEY `share_id_status_inex` (`share_id`,`status`),
  KEY `user_id_status_index` (`user_id`,`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



# Dump of table share_likes
# ------------------------------------------------------------

DROP TABLE IF EXISTS `share_likes`;

CREATE TABLE `share_likes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `share_id` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `status` int(11) DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `share_likes_share_id_index` (`share_id`),
  KEY `share_likes_user_id_index` (`user_id`),
  KEY `share_likes_user_id_share_id_index` (`user_id`,`share_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



# Dump of table share_syncs
# ------------------------------------------------------------

DROP TABLE IF EXISTS `share_syncs`;

CREATE TABLE `share_syncs` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `cn_share_id` int(11) DEFAULT NULL,
  `in_share_id` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



# Dump of table share_tag_references
# ------------------------------------------------------------

DROP TABLE IF EXISTS `share_tag_references`;

CREATE TABLE `share_tag_references` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `share_id` int(11) DEFAULT NULL,
  `tag_id` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `status` int(11) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



# Dump of table share_weights
# ------------------------------------------------------------

DROP TABLE IF EXISTS `share_weights`;

CREATE TABLE `share_weights` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `share_id` int(11) DEFAULT NULL,
  `weight` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `country` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



# Dump of table shares
# ------------------------------------------------------------

DROP TABLE IF EXISTS `shares`;

CREATE TABLE `shares` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `text` text COLLATE utf8_unicode_ci,
  `likes_weekly` int(11) DEFAULT '0',
  `user_id` int(11) DEFAULT NULL,
  `uid` int(11) DEFAULT '0',
  `snp_id` int(11) DEFAULT NULL COMMENT 'snapeee id',
  `link` text COLLATE utf8_unicode_ci,
  `link_title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `link_description` text COLLATE utf8_unicode_ci,
  `keywords` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `group_id` int(11) DEFAULT NULL,
  `share_comments_count` int(11) DEFAULT '0',
  `category_id` int(11) DEFAULT NULL,
  `picture` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `picture_height` int(11) DEFAULT '0',
  `picture_width` int(11) DEFAULT '0',
  `topic_id` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `status` int(11) DEFAULT '1',
  `geolocation` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `place` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `share_likes_count` int(11) DEFAULT '0',
  `magazine_shares_count` int(11) DEFAULT '0',
  `shop_url` tinyint(2) DEFAULT '0',
  `system_keywords` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `upload_from` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'website',
  `weight` int(11) DEFAULT '1',
  `weight_at` datetime DEFAULT NULL,
  `country` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `temp_pic_url` varchar(255) COLLATE utf8_unicode_ci DEFAULT '',
  `year_week` int(11) DEFAULT '0',
  `pageviews` int(11) DEFAULT '0',
  `pv` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `shares_hotlist_index` (`status`,`picture`,`category_id`,`likes_weekly`,`created_at`),
  KEY `shares_hotlist_index_using_filesort` (`likes_weekly`,`created_at`),
  KEY `shares_list_of_user_index` (`user_id`,`status`,`picture`,`created_at`),
  KEY `shares_list_of_user_index_using_filesort` (`user_id`,`created_at`),
  KEY `shares_created_at_index` (`created_at`),
  KEY `shares_status_user_id_created_at_index` (`status`,`user_id`,`created_at`),
  KEY `shares_status_created_at_index_using_filesort` (`status`,`created_at`),
  KEY `shares_weight_index_using_filesort` (`status`,`created_at`),
  KEY `weight_index` (`created_at`),
  KEY `upload_from` (`upload_from`),
  KEY `category_id_index` (`category_id`),
  KEY `picture_index` (`picture`),
  KEY `user_id_index` (`user_id`),
  KEY `keywords_system_keywords_index` (`keywords`,`system_keywords`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



# Dump of table shop_urls
# ------------------------------------------------------------

DROP TABLE IF EXISTS `shop_urls`;

CREATE TABLE `shop_urls` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `url` varchar(100) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `country` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table snap_asia_choices
# ------------------------------------------------------------

DROP TABLE IF EXISTS `snap_asia_choices`;

CREATE TABLE `snap_asia_choices` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `snap_asia_id` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table snap_asias
# ------------------------------------------------------------

DROP TABLE IF EXISTS `snap_asias`;

CREATE TABLE `snap_asias` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `share_id` int(11) DEFAULT NULL,
  `like_count` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `country` varchar(255) DEFAULT NULL,
  `text` text,
  `rank` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table stores
# ------------------------------------------------------------

DROP TABLE IF EXISTS `stores`;

CREATE TABLE `stores` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `label` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `sort` int(11) DEFAULT NULL,
  `url` text COLLATE utf8_unicode_ci,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `status` int(11) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



# Dump of table styles
# ------------------------------------------------------------

DROP TABLE IF EXISTS `styles`;

CREATE TABLE `styles` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `meta_keywords` varchar(255) DEFAULT NULL,
  `meta_description` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table suggest_followers
# ------------------------------------------------------------

DROP TABLE IF EXISTS `suggest_followers`;

CREATE TABLE `suggest_followers` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `type` varchar(50) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `country` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `type` (`type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table sync_records
# ------------------------------------------------------------

DROP TABLE IF EXISTS `sync_records`;

CREATE TABLE `sync_records` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `object` varchar(256) COLLATE utf8_unicode_ci DEFAULT NULL,
  `object_id` int(11) DEFAULT NULL,
  `action` varchar(256) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` int(11) DEFAULT '0',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



# Dump of table system_mobile_push_records
# ------------------------------------------------------------

DROP TABLE IF EXISTS `system_mobile_push_records`;

CREATE TABLE `system_mobile_push_records` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `mobile_device_id` int(11) DEFAULT NULL,
  `system_mobile_push_id` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table system_mobile_pushs
# ------------------------------------------------------------

DROP TABLE IF EXISTS `system_mobile_pushs`;

CREATE TABLE `system_mobile_pushs` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `device` varchar(255) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `content` text,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `is_finish` int(11) NOT NULL DEFAULT '0',
  `picture` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table system_notices
# ------------------------------------------------------------

DROP TABLE IF EXISTS `system_notices`;

CREATE TABLE `system_notices` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `content` text,
  `top` tinyint(1) DEFAULT '0',
  `user_id` int(11) DEFAULT NULL,
  `is_enabled` tinyint(1) DEFAULT '0',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `noticer_lists_top_created_at_index` (`top`,`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table tag_clicks
# ------------------------------------------------------------

DROP TABLE IF EXISTS `tag_clicks`;

CREATE TABLE `tag_clicks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tag_id` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `click_num` int(11) DEFAULT '1',
  `date` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `date` (`date`),
  KEY `tag_id_date_index` (`tag_id`,`date`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table tag_references
# ------------------------------------------------------------

DROP TABLE IF EXISTS `tag_references`;

CREATE TABLE `tag_references` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) DEFAULT NULL,
  `child_id` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `status` int(11) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



# Dump of table taggings
# ------------------------------------------------------------

DROP TABLE IF EXISTS `taggings`;

CREATE TABLE `taggings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tag_id` int(11) DEFAULT NULL,
  `taggable_id` int(11) DEFAULT NULL,
  `taggable_type` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `tagger_id` int(11) DEFAULT NULL,
  `tagger_type` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `context` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `index_taggings_on_tag_id` (`tag_id`),
  KEY `taggings_tag_id_taggable_id_taggable_type_index` (`tag_id`,`taggable_id`,`taggable_type`),
  KEY `taggings_taggable_type_taggable_id_context_index` (`taggable_type`,`taggable_id`,`context`),
  KEY `taggings_taggable_id_taggable_type_context_tagger_id_index` (`taggable_id`,`taggable_type`,`context`,`tagger_id`),
  KEY `taggings_taggable_type_tag_id_index` (`taggable_type`,`tag_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



# Dump of table tags
# ------------------------------------------------------------

DROP TABLE IF EXISTS `tags`;

CREATE TABLE `tags` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `for_search` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `tags_name_index` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



# Dump of table tags_mapping
# ------------------------------------------------------------

DROP TABLE IF EXISTS `tags_mapping`;

CREATE TABLE `tags_mapping` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '系統流水號',
  `category_id` int(11) DEFAULT NULL COMMENT '分類編號',
  `tag_id` int(11) DEFAULT NULL COMMENT 'tags編號',
  `top_status` tinyint(4) DEFAULT '1' COMMENT '上方顯示狀態(1:顯示;0:不顯示)',
  `bottom_status` tinyint(4) DEFAULT '1' COMMENT '下方顯示狀態(1:顯示;0:不顯示)',
  `sort` int(11) DEFAULT NULL COMMENT '排序',
  PRIMARY KEY (`id`),
  KEY `tag_id` (`tag_id`),
  KEY `category_id` (`category_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='標籤分類對照';



# Dump of table temp_pics
# ------------------------------------------------------------

DROP TABLE IF EXISTS `temp_pics`;

CREATE TABLE `temp_pics` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `filename` varchar(500) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table temp_users
# ------------------------------------------------------------

DROP TABLE IF EXISTS `temp_users`;

CREATE TABLE `temp_users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `is_enabled` int(1) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `uid` varchar(255) DEFAULT NULL,
  `token` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table topics
# ------------------------------------------------------------

DROP TABLE IF EXISTS `topics`;

CREATE TABLE `topics` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `label` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `first_post_id` int(11) DEFAULT NULL,
  `last_post_id` int(11) DEFAULT NULL,
  `post_topic_references_count` int(11) DEFAULT NULL,
  `view_counts` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `status` int(11) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



# Dump of table user_references
# ------------------------------------------------------------

DROP TABLE IF EXISTS `user_references`;

CREATE TABLE `user_references` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `follower_user_id` int(11) DEFAULT NULL,
  `target_user_id` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `status` int(11) DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `user_references_target_user_id_index` (`target_user_id`),
  KEY `user_references_follower_user_id_index` (`follower_user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



# Dump of table user_stat_shares
# ------------------------------------------------------------

DROP TABLE IF EXISTS `user_stat_shares`;

CREATE TABLE `user_stat_shares` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `count` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `status` int(11) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



# Dump of table user_syncs
# ------------------------------------------------------------

DROP TABLE IF EXISTS `user_syncs`;

CREATE TABLE `user_syncs` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `cn_user_id` int(11) DEFAULT NULL,
  `in_user_id` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



# Dump of table users
# ------------------------------------------------------------

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `sign_in_count` int(11) DEFAULT '0',
  `last_sign_in_at` datetime DEFAULT NULL,
  `last_sign_in_ip` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `salt` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `gender` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `birthday` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `interest` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `job_id` int(11) DEFAULT '81',
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `keywords` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `avatar` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `banner` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `status` int(11) DEFAULT '1',
  `admin` tinyint(1) DEFAULT '0',
  `notices_count` int(11) DEFAULT '0',
  `magazine_subscriptions_count` int(11) DEFAULT '0',
  `shares_count` int(11) DEFAULT '0',
  `share_likes_count` int(11) DEFAULT '0',
  `share_likeds_count` int(11) DEFAULT '0',
  `share_comments_count` int(11) DEFAULT '0',
  `share_commenteds_count` int(11) DEFAULT '0',
  `idols_counter` int(11) DEFAULT '0',
  `fans_counter` int(11) DEFAULT '0',
  `remember_code` varchar(40) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_on` int(11) unsigned NOT NULL,
  `last_login` int(11) unsigned DEFAULT NULL,
  `magazines_count` int(11) DEFAULT '0',
  `memo` text COLLATE utf8_unicode_ci,
  `country` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `oauth_from` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `pageviews` int(11) NOT NULL DEFAULT '0',
  `share_sum_pv` int(11) NOT NULL DEFAULT '0',
  `share_average_pv` float NOT NULL DEFAULT '0',
  `uid` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `uid_index` (`uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



# Dump of table users_groups
# ------------------------------------------------------------

DROP TABLE IF EXISTS `users_groups`;

CREATE TABLE `users_groups` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` mediumint(8) unsigned NOT NULL,
  `group_id` mediumint(8) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table view_notice
# ------------------------------------------------------------

DROP VIEW IF EXISTS `view_notice`;

CREATE TABLE `view_notice` (
   `user_id` INT(11) NULL DEFAULT NULL,
   `noticeable_type` VARCHAR(255) NULL DEFAULT NULL,
   `noticeable_id` INT(11) NULL DEFAULT NULL,
   `read_status` TINYINT(1) NULL DEFAULT '0',
   `noticer_lists_count` INT(11) NULL DEFAULT NULL,
   `notice_id` INT(11) NULL DEFAULT NULL,
   `notice_type` INT(11) NULL DEFAULT NULL,
   `created_at` DATETIME NULL DEFAULT NULL
) ENGINE=MyISAM;





# Replace placeholder table for view_notice with correct view syntax
# ------------------------------------------------------------

DROP TABLE `view_notice`;

CREATE ALGORITHM=UNDEFINED DEFINER=`ibeautytwdbroot`@`%` SQL SECURITY DEFINER VIEW `view_notice`
AS SELECT
   `notices`.`user_id` AS `user_id`,
   `notices`.`noticeable_type` AS `noticeable_type`,
   `notices`.`noticeable_id` AS `noticeable_id`,
   `notices`.`read_status` AS `read_status`,
   `notices`.`noticer_lists_count` AS `noticer_lists_count`,
   `noticer_lists`.`notice_id` AS `notice_id`,
   `notices`.`notice_type` AS `notice_type`,max(`noticer_lists`.`created_at`) AS `created_at`
FROM (`notices` join `noticer_lists` on((`noticer_lists`.`notice_id` = `notices`.`id`))) where ((date_format((now() - interval 1 month),'%Y%m%d') <= date_format(`noticer_lists`.`created_at`,'%Y%m%d')) and (`notices`.`notice_type` <> '10')) group by `noticer_lists`.`notice_id` order by `noticer_lists`.`created_at` desc;

/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
