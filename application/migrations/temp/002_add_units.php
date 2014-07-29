<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @author      OA Wu <comdan66@gmail.com>
 * @copyright   Copyright (c) 2014 OA Wu Design
 */
class Migration_Add_units extends CI_Migration {
  public function up () {
    $sql = "CREATE TABLE `units` (
              `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
              `user_id` int(11) NOT NULL,
              `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
              `introduction` text,
              `open_time` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
              `address` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
              `status` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
              `latitude` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
              `longitude` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
              `score` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
              `comments_count` int(11) NOT NULL DEFAULT '0',
              `pageview` int(11) NOT NULL DEFAULT '0',
              `created_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
              `updated_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
              PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;";
    $this->db->query ($sql);
    
    $sql = "CREATE TABLE `delete_units` (
              `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
              `origin_id` int(11) NOT NULL,
              `user_id` int(11) NOT NULL,
              `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
              `introduction` text,
              `open_time` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
              `address` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
              `status` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
              `latitude` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
              `longitude` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
              `score` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
              `comments_count` int(11) NOT NULL DEFAULT '0',
              `pageview` int(11) NOT NULL DEFAULT '0',
              `created_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
              `updated_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
              PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;";
    $this->db->query ($sql);
  }
}
