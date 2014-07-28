<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MessagePicture extends OaModel {

  static $table_name = 'message_pictures';
  
  static $belongs_to = array (
    array ('message', 'class_name' => 'Message'),
  );

  public function __construct ($attributes = array (), $guard_attributes = TRUE, $instantiating_via_find = FALSE, $new_record = TRUE) {
    parent::__construct ($attributes, $guard_attributes, $instantiating_via_find, $new_record);
    
    ModelUploader::bind ($this, 'file_name', 'MessagePictureUpload');
  }
}
