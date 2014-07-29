<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @author      OA Wu <comdan66@gmail.com>
 * @copyright   Copyright (c) 2014 OA Wu Design
 */
class User extends OaModel {

  static $table_name = 'users';

  public function __construct ($attributes = array (), $guard_attributes = TRUE, $instantiating_via_find = FALSE, $new_record = TRUE) {
    parent::__construct ($attributes, $guard_attributes, $instantiating_via_find, $new_record);
  }

  public function avatar_url ($width, $height) {
    return 'https://graph.facebook.com/' . $this->uid . '/picture?width=' . $width . '&height=' . $height;
  }
}