<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @author      OA Wu <comdan66@gmail.com>
 * @copyright   Copyright (c) 2014 OA Wu Design
 */
class Tag extends OaModel {

  private $group_tags = null;
  static $table_name = 'tags';

  static $has_many = array (
    array ('groups', 'class_name' => 'Group', 'foreign_key' => 'main_id', 'include' => array ('tag')),
  );
  static $has_one = array (
  );
  public function __construct ($attributes = array (), $guard_attributes = TRUE, $instantiating_via_find = FALSE, $new_record = TRUE) {
    parent::__construct ($attributes, $guard_attributes, $instantiating_via_find, $new_record);
  }
  public function group_tags ($sql = array (), $new_record = false) {
    if ($this->group_tags !== null && !$new_record)
      return $this->group_tags;
    return $this->group_tags = (!$tag_ids = field_array ($this->groups, 'tag_id')) ? array () : self::find ('all', array_merge ($sql, array ('conditions' => array ('id IN (?)', $tag_ids))));
  }
}