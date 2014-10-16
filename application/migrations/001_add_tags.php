<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @author      OA Wu <comdan66@gmail.com>
 * @copyright   Copyright (c) 2014 OA Wu Design
 */
class Migration_Add_tags extends CI_Migration {
  public function up () {
    $sql = "CREATE TABLE `tags` (
              `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
              `db_id` int(11) NOT NULL DEFAULT '0',
              `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
              `enable` int(11) NOT NULL DEFAULT '0',
              `created_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
              `updated_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
              PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;";
    $this->db->query ($sql);

    $sql = "CREATE TABLE `delete_tags` (
              `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
              `origin_id` int(11) NOT NULL,
              `db_id` int(11) NOT NULL DEFAULT '0',
              `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
              `enable` int(11) NOT NULL DEFAULT '0',
              `created_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
              `updated_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
              PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;";
    $this->db->query ($sql);
  }
}