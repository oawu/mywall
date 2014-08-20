<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @author      OA Wu <comdan66@gmail.com>
 * @copyright   Copyright (c) 2014 OA Wu Design
 */
class UserActive extends OaModel {

  static $table_name = 'user_actives';

  static $belongs_to = array (
    array ('user', 'class_name' => 'User'),
  );

  public function __construct ($attributes = array (), $guard_attributes = TRUE, $instantiating_via_find = FALSE, $new_record = TRUE) {
    parent::__construct ($attributes, $guard_attributes, $instantiating_via_find, $new_record);
    JsonBind::bind ('memo');
  }

  public static function create_active ($user_id, $kind, $object_name, $object_ids) {
    $need_merge_kinds = array ('add_picture_comment' => 12, 'po_picture' => 3, 'to_follow' => 12, 'be_follow' => 12);
    if (in_array ($kind, array_keys ($need_merge_kinds)) && ($last = self::find ('one', array ('order' => 'id DESC', 'conditions' => array ('user_id = ? AND model_name = ?', is_object ($user_id) ? $user_id->id : $user_id, $object_name)))) && ($last->kind == $kind) && ((strtotime (date ('Y-m-d H:i:s')) - strtotime ($last->created_at)) <= config ('db_table_config', 'user_actives', 'merge_time_range')) && ($model_ids = array_unique (array_filter (explode (',', $last->model_ids)))) && (count ($model_ids) < $need_merge_kinds[$kind]) && (is_array ($object_ids) ? $model_ids = array_merge ($model_ids, $object_ids) : array_push ($model_ids, $object_ids))) {
      $last->model_ids = implode (',', $model_ids);
      $last->save ();
    } else {
      self::create (array ('user_id' => is_object ($user_id) ? $user_id->id : $user_id, 'kind' => $kind, 'model_name' => $object_name, 'model_ids' => is_array ($object_ids) ? implode (',', $object_ids) : $object_ids));
    }
  }
}