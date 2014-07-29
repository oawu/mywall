<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @author      OA Wu <comdan66@gmail.com>
 * @copyright   Copyright (c) 2014 OA Wu Design
 */
class Migration_Add_album_pictures extends CI_Migration {
  public function up () {
    $sql = "CREATE TABLE `album_pictures` (
              `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
              `album_id` int(11) NOT NULL,
              `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
              `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
              `sort` int(11) NOT NULL,
              `src` text,
              `file_name` varchar(255) NOT NULL DEFAULT '',
              `is_enabled` int(11) NOT NULL DEFAULT '1',
              `created_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
              `updated_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
              PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;";

    $this->db->query ($sql);
  }
}
