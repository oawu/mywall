<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MessageLike extends OaModel {

  static $table_name = 'message_likes';
  
  static $after_create = array ('create_notice');

  static $belongs_to = array (
    array ('owner', 'class_name' => 'User'),
    array ('message', 'class_name' => 'Message'),
  );

  public function __construct ($attributes = array (), $guard_attributes = TRUE, $instantiating_via_find = FALSE, $new_record = TRUE) {
    parent::__construct ($attributes, $guard_attributes, $instantiating_via_find, $new_record);
  }

  public function create_notice () {
    if ($this->type->verifyNumber ($id = $this->get_session ('id'))) {
      $this->delay ('notices', 'message_like', array ('myself_id' => $id, 'model_name' => get_class ($this), 'this_id' => $this->id));
    }
  }
}
