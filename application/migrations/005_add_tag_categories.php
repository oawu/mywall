<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @author      OA Wu <comdan66@gmail.com>
 * @copyright   Copyright (c) 2014 OA Wu Design
 */
class Migration_Add_tag_categories extends CI_Migration {
  public function up () {
    $sql = "CREATE TABLE `tag_categories` (
              `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
              `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
              `kind` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
              `file_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
              `memo` text,
              `created_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
              `updated_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
              PRIMARY KEY (`id`),
              KEY `kind_index` (`kind`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;";
    $this->db->query ($sql);

    $sql = "CREATE TABLE `delete_tag_categories` (
              `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
              `origin_id` int(11) NOT NULL,
              `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
              `kind` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
              `file_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
              `memo` text,
              `created_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
              `updated_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
              PRIMARY KEY (`id`),
              KEY `kind_index` (`kind`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;";
    $this->db->query ($sql);
  }
}
