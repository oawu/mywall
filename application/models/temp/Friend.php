<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Friend extends OaModel {

  static $table_name = 'users';

  static $has_many = array (
    array ('has_friends', 'class_name' => "Friendship"),
    array ('permissions', 'class_name' => 'Permission', 'through' => 'user_permissions', 'foreign_key' => 'user_id'),
  );

  public function __construct ($attributes = array (), $guard_attributes = TRUE, $instantiating_via_find = FALSE, $new_record = TRUE) {
    parent::__construct ($attributes, $guard_attributes, $instantiating_via_find, $new_record);
  }

  public function in_blacklist () {
    return in_objects_by_value ('blacklist', $this->permissions, 'role');
  }
}
