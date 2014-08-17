<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @author      OA Wu <comdan66@gmail.com>
 * @copyright   Copyright (c) 2014 OA Wu Design
 */
class PictureTag extends OaModel {

  static $table_name = 'picture_tags';

  static $has_many = array (
    array ('picture_mappings', 'class_name' => 'PictureTagMapping'),
    array ('pictures', 'class_name' => 'Picture', 'through' => 'tag_mappings', 'order'=> 'pageview DESC'),
    array ('more_tag_pictures', 'class_name' => 'Picture', 'through' => 'tag_mappings', 'order'=> 'RAND()', 'limit' => 9),
  );

  static $validates_uniqueness_of = array (
    array (array ('name'), 'message' => 'name repeated!')
  );

  static $before_save = array ('strip_tags');


  public function __construct ($attributes = array (), $guard_attributes = TRUE, $instantiating_via_find = FALSE, $new_record = TRUE) {
    parent::__construct ($attributes, $guard_attributes, $instantiating_via_find, $new_record);
  }

  public function strip_tags () {
    isset ($this->name) ? $this->name = $this->name ? strip_tags ($this->name) : '' : '';
  }
}
