<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @author      OA Wu <comdan66@gmail.com>
 * @copyright   Copyright (c) 2014 OA Wu Design
 */
class Follow extends OaModel {

  static $table_name = 'follows';

  static $validates_uniqueness_of = array (
    array (array ('user_id', 'be_user_id'), 'message' => 'user_id + be_user_id repeated!')
  );
  static $belongs_to = array (
    array ('user', 'class_name' => 'User'),
    array ('be_user', 'class_name' => 'User', 'foreign_key' => 'be_user_id'),
  );
  public function __construct ($attributes = array (), $guard_attributes = TRUE, $instantiating_via_find = FALSE, $new_record = TRUE) {
    parent::__construct ($attributes, $guard_attributes, $instantiating_via_find, $new_record);
  }
}