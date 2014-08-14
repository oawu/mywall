<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @author      OA Wu <comdan66@gmail.com>
 * @copyright   Copyright (c) 2014 OA Wu Design
 */
class User extends OaModel {

  static $table_name = 'users';

  public function __construct ($attributes = array (), $guard_attributes = TRUE, $instantiating_via_find = FALSE, $new_record = TRUE) {
    parent::__construct ($attributes, $guard_attributes, $instantiating_via_find, $new_record);
    OrmImageUploader::bind ('file_name');
  }

  public function avatar_url ($width = null, $height = null) {
    return $this->register_from == 'facebook' ? 'https://graph.facebook.com/' . $this->uid . '/picture?width=' . ($width ? $width : 50) . '&height=' . ($height ? $height : 50) : (($url = $this->file_name->url ($width . 'x' . $height)) ? $url : $this->file_name->url ());
  }
}