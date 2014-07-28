<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @author      OA Wu <comdan66@gmail.com>
 * @copyright   Copyright (c) 2014 OA Wu Design
 */
class UnitTagMapping extends OaModel {

  static $table_name = 'unit_tag_mappings';

  static $belongs_to = array (
    array ('tags' , 'class_name' => 'UnitTag'),
    array ('units' , 'class_name' => 'Unit', 'conditions' => array ('status = ?', 'certified')),
  );

  public function __construct ($attributes = array (), $guard_attributes = TRUE, $instantiating_via_find = FALSE, $new_record = TRUE) {
    parent::__construct ($attributes, $guard_attributes, $instantiating_via_find, $new_record);
  }
}