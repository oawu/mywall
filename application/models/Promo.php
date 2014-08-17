<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @author      OA Wu <comdan66@gmail.com>
 * @copyright   Copyright (c) 2014 OA Wu Design
 */
class Promo extends OaModel {

  static $table_name = 'promos';
  static $before_save = array ('strip_tags');

  public function __construct ($attributes = array (), $guard_attributes = TRUE, $instantiating_via_find = FALSE, $new_record = TRUE) {
    parent::__construct ($attributes, $guard_attributes, $instantiating_via_find, $new_record);
    
    OrmImageUploader::bind ('file_name');
  }
  public function strip_tags () {
    isset ($this->link) ? $this->link = $this->link ? strip_tags ($this->link) : '' : '';
    isset ($this->text) ? $this->text = $this->text ? strip_tags ($this->text) : '' : '';
    isset ($this->title) ? $this->title = $this->title ? strip_tags ($this->title) : '' : '';
  }
}