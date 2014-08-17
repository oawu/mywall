<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @author      OA Wu <comdan66@gmail.com>
 * @copyright   Copyright (c) 2014 OA Wu Design
 */
class Migration_Add_user_actives extends CI_Migration {
  public function up () {
    $sql = "CREATE TABLE `user_actives` (
              `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
              `user_id` int(11) NOT NULL,
              `kind` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
              `model_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
              `model_ids` text,
              `created_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
              `updated_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
              PRIMARY KEY (`id`),
              KEY `user_id_index` (`user_id`),
              KEY `user_id_model_name_index` (`user_id`, `model_name`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;";
    $this->db->query ($sql);

    $sql = "CREATE TABLE `delete_user_actives` (
              `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
              `origin_id` int(11) NOT NULL,
              `user_id` int(11) NOT NULL,
              `kind` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
              `model_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
              `model_ids` text,
              `created_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
              `updated_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
              PRIMARY KEY (`id`),
              KEY `user_id_index` (`user_id`),
              KEY `user_id_model_name_index` (`user_id`, `model_name`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;";
    $this->db->query ($sql);
  }
}