<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @author      OA Wu <comdan66@gmail.com>
 * @copyright   Copyright (c) 2014 OA Wu Design
 */
class Album extends OaModel {

  static $table_name = 'albums';

  static $has_many = array (
    array ('pictures', 'class_name' => 'AlbumPicture', 'order' => 'sort ASC, id ASC')
  );
  
  public function __construct ($attributes = array (), $guard_attributes = TRUE, $instantiating_via_find = FALSE, $new_record = TRUE) {
    parent::__construct ($attributes, $guard_attributes, $instantiating_via_find, $new_record);
  }
  
  public function delete () {
    array_map (function ($picture) { $picture->delete (); }, $this->pictures);
    $this->is_enabled = 0;
    $this->save ();
  }
}