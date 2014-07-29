<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @author      OA Wu <comdan66@gmail.com>
 * @copyright   Copyright (c) 2014 OA Wu Design
 */
class UnitPicture extends OaModel {

  static  $table_name = 'unit_pictures';

  public function __construct ($attributes = array (), $guard_attributes = TRUE, $instantiating_via_find = FALSE, $new_record = TRUE) {
    parent::__construct ($attributes, $guard_attributes, $instantiating_via_find, $new_record);
    ModelUploader::bind ('file_name', 'UnitPictureUpload');
  }

  public function picture_url ($size = '') {
    return $this->file_name->url ($size);
  }
}
