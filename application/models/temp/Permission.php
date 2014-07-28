<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Permission extends OaModel {

  static $table_name = 'permissions';

  static $has_many = array (
    array ('user_permissions', 'class_name' => 'UserPermission')
  );

  public function __construct ($attributes = array (), $guard_attributes = TRUE, $instantiating_via_find = FALSE, $new_record = TRUE) {
    parent::__construct ($attributes, $guard_attributes, $instantiating_via_find, $new_record);
  }

  public static function value ($role, $decimal = 'dec') {
    return in_array ($decimal, array ('bin', 'dec', 'hex')) && ($permission = self::find ('one', array ('select' => $decimal . '_value AS value', 'conditions' => array ('role = ?', $role)))) && isset ($permission) ? $permission->value : 0; 
  }
}
