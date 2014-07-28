<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @author      OA Wu <comdan66@gmail.com>
 * @copyright   Copyright (c) 2014 OA Wu Design
 */
class AlbumPicture extends OaModel {

  static  $table_name = 'album_pictures';

  public function __construct ($attributes = array (), $guard_attributes = TRUE, $instantiating_via_find = FALSE, $new_record = TRUE) {
    parent::__construct ($attributes, $guard_attributes, $instantiating_via_find, $new_record);
    ModelUploader::bind ('file_name', 'AlbumPictureUpload');
  }

  public function delete () {
    // $this->file_name->deleteOldFiles ();
    // parent::delete ();
    $this->is_enabled = 0;
    $this->save ();
  }
}
