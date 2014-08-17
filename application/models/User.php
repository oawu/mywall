<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @author      OA Wu <comdan66@gmail.com>
 * @copyright   Copyright (c) 2014 OA Wu Design
 */
class User extends OaModel {

  static $table_name = 'users';
  static $before_save = array ('strip_tags');

  static $has_many = array (
    array ('banner_pictures', 'class_name' => 'Picture', 'limit' => 7, 'order' => 'year_week DESC, pageview DESC'),
  );

  public function __construct ($attributes = array (), $guard_attributes = TRUE, $instantiating_via_find = FALSE, $new_record = TRUE) {
    parent::__construct ($attributes, $guard_attributes, $instantiating_via_find, $new_record);
    OrmImageUploader::bind ('file_name');
    // OrmImageUploader::bind ('file_name');
  }

  public function avatar_url ($width = null, $height = null) {
    return $this->register_from == 'facebook' ? 'https://graph.facebook.com/' . $this->uid . '/picture?width=' . ($width ? $width : 50) . '&height=' . ($height ? $height : 50) : (($url = $this->file_name->url ($width . 'x' . $height)) ? $url : $this->file_name->url ());
  }

  public function strip_tags () {
    isset ($this->email) ? $this->email = $this->email ? strip_tags ($this->email) : '' : '';
    isset ($this->name) ? $this->name = $this->name ? strip_tags ($this->name) : '' : '';
  }
}