<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @author      OA Wu <comdan66@gmail.com>
 * @copyright   Copyright (c) 2014 OA Wu Design
 */
class Migration_Add_albums extends CI_Migration {
  public function up () {
    $sql = "CREATE TABLE `albums` (
              `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
              `title` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
              `cover` int(11) NOT NULL DEFAULT '0',
              `description` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
              `sort` int(11) NOT NULL,
              `is_enabled` int(11) NOT NULL DEFAULT '1',
              `created_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
              `updated_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
              PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;";

    $this->db->query ($sql);
  }
}
