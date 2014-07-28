<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class UserLogRecord extends OaModel {

  static  $table_name = 'user_log_records';

  public function __construct ($attributes = array (), $guard_attributes = TRUE, $instantiating_via_find = FALSE, $new_record = TRUE) {
    parent::__construct ($attributes, $guard_attributes, $instantiating_via_find, $new_record);
  }

  public static function sign_in ($id) {
    $sql = array ('kind' => 'sign_in', 'user_id' => $id, 'message' => '', 'ip' => get_instance ()->input->ip_address());
    UserLogRecord::create ($sql);
  }
  
  public static function sign_out ($id) {
    $sql = array ('kind' => 'sign_out', 'user_id' => $id, 'message' => '', 'ip' => get_instance ()->input->ip_address());
    UserLogRecord::create ($sql);
  }

  public static function error ($message) {
    $sql = array ('kind' => 'error', 'user_id' => 0, 'ip' => get_instance ()->input->ip_address(), 'message' => $message);
    UserLogRecord::create ($sql);
  }
}
