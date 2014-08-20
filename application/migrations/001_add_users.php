<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @author      OA Wu <comdan66@gmail.com>
 * @copyright   Copyright (c) 2014 OA Wu Design
 */
class Migration_Add_users extends CI_Migration {
  public function up () {
    $sql = "CREATE TABLE `users` (
              `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
              `uid` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
              `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
              `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
              `register_from` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
              `avatar` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
              `banner` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
              `pictures_count` int(11) NOT NULL DEFAULT '0',
              `to_picture_comments_count` int(11) NOT NULL DEFAULT '0',
              `follows_count` int(11) NOT NULL DEFAULT '0',
              `be_follows_count` int(11) NOT NULL DEFAULT '0',
              `sign_in_count` int(11) NOT NULL DEFAULT '0',
              `score` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
              `sign_in_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
              `created_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
              `updated_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
              PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;";
    $this->db->query ($sql);

    $sql = "CREATE TABLE `delete_users` (
              `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
              `origin_id` int(11) NOT NULL,
              `uid` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
              `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
              `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
              `register_from` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
              `avatar` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
              `banner` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
              `pictures_count` int(11) NOT NULL DEFAULT '0',
              `to_picture_comments_count` int(11) NOT NULL DEFAULT '0',
              `follows_count` int(11) NOT NULL DEFAULT '0',
              `be_follows_count` int(11) NOT NULL DEFAULT '0',
              `sign_in_count` int(11) NOT NULL DEFAULT '0',
              `score` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
              `sign_in_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
              `created_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
              `updated_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
              PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;";
    $this->db->query ($sql);
  }
}