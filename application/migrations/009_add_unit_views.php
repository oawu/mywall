<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @author      OA Wu <comdan66@gmail.com>
 * @copyright   Copyright (c) 2014 OA Wu Design
 */
class Migration_Add_unit_views extends CI_Migration {
  public function up () {
    $sql = "CREATE TABLE `unit_views` (
              `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
              `unit_id` int(11) NOT NULL,
              `latitude` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
              `longitude` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
              `heading` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
              `pitch` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
              `zoom` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
              `created_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
              `updated_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
              PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;";
    $this->db->query ($sql);
    
    $sql = "CREATE TABLE `delete_unit_views` (
              `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
              `origin_id` int(11) NOT NULL,
              `unit_id` int(11) NOT NULL,
              `latitude` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
              `longitude` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
              `heading` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
              `pitch` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
              `zoom` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
              `created_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
              `updated_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
              PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;";
    $this->db->query ($sql);
  }
}
