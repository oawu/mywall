<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MessageReplyAutoLoad extends OaModel {

  static $table_name = 'message_reply_auto_loads';
  
  static $belongs_to = array (
    array ('owner', 'class_name' => 'User'),
    array ('message', 'class_name' => 'Message', 'conditions' => array ('is_enabled = ?', '1')),
  );

  public function __construct ($attributes = array (), $guard_attributes = TRUE, $instantiating_via_find = FALSE, $new_record = TRUE) {
    parent::__construct ($attributes, $guard_attributes, $instantiating_via_find, $new_record);
  }
}

