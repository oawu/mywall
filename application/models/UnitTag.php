<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @author      OA Wu <comdan66@gmail.com>
 * @copyright   Copyright (c) 2014 OA Wu Design
 */
class UnitTag extends OaModel {

  static $table_name = 'unit_tags';

  static $has_many = array (
    array ('unit_mappings', 'class_name' => 'UnitTagMapping'),
    array ('units' , 'class_name' => 'Unit', 'through' => 'tag_mappings', 'order'=> 'pageview DESC', 'conditions' => array ('status = ?', 'certified')),
  );

  static $has_one = array (
    array ('units_count_obj', 'class_name' => 'Unit', 'through' => 'tag_mappings', 'select' => 'COUNT(*) AS count', 'conditions' => array ('status = ?', 'certified')),
  );  

  public function __construct ($attributes = array (), $guard_attributes = TRUE, $instantiating_via_find = FALSE, $new_record = TRUE) {
    parent::__construct ($attributes, $guard_attributes, $instantiating_via_find, $new_record);
  }

  public function recycle () {
    array_map (function ($unit_mapping) { $unit_mapping->recycle (); }, $this->unit_mappings);
    return parent::recycle ();
  }

  public static function __callStatic ($method, $args) {
    switch (substr ($method, 11, 7)) {
      case 'all': return SpecialTag::all (); break;
      case 'find_by':
        switch (substr ($method, 19)) {
          case 'id': case 'name': return call_user_func_array ('SpecialTag::find', array_merge (array ('id'), $args)); break;
          default: showError ('Call to undefined attribute: ' . substr ($method, 19)); break;
        }
        break;
      default: return parent::__callStatic ($method, $args); break;
    }
  }
}

class SpecialTag extends stdClass {
  public $id   = null;
  public $name = null;
  public $sql  = null;

  public function __construct ($id, $name, $sql) {
    $this->id   = $id;
    $this->name = $name;
    $this->sql  = $sql;
  }

  public static function all () {
    $special_tags = array ();
    array_push ($special_tags, new self (-2, '人氣前 10', array ('limit' => 10, 'order' => 'pageview DESC', 'conditions' => array ('status = ?', 'certified'))));
    array_push ($special_tags, new self ( 0, '最新前 10', array ('limit' => 10, 'order' => 'id DESC', 'conditions' => array ('status = ?', 'certified'))));
    array_push ($special_tags, new self (-1, '分數前 10', array ('limit' => 10, 'order' => 'score DESC', 'conditions' => array ('status = ?', 'certified'))));
    array_push ($special_tags, new self (-3, '留言前 10', array ('limit' => 10, 'order' => 'comments_count DESC', 'conditions' => array ('status = ?', 'certified'))));
    return $special_tags;
  }

  public static function find ($attribute, $value, $kind = 'one') {
    if (in_array ($attribute, array ('id', 'name'))) {
      if ($kind != 'one')
      return array_filter (array_map (function ($special_tag) use ($attribute, $value, $kind) { return $special_tag->$attribute == $value ? $special_tag : null; }, SpecialTag::all ()));
      else if (count ($special_tags = self::all ())) foreach ($special_tags as $special_tag) if ($special_tag->$attribute == $value) return $special_tag;
    }
    return $kind != 'one' ? array () : null;
  }

  public function unit_count ($sql = null) { return Unit::count (verifyArray ($sql) ? $sql : $this->sql); }

  public function units ($sql = null) { return Unit::find ('all', verifyArray ($sql) ? $sql : $this->sql); }
}