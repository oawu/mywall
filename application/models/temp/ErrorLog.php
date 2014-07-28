<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class ErrorLog extends OaModel {

  static $table_name = 'error_logs';

  public function __construct ($attributes = array (), $guard_attributes = TRUE, $instantiating_via_find = FALSE, $new_record = TRUE) {
    parent::__construct ($attributes, $guard_attributes, $instantiating_via_find, $new_record);
  }

  public static function log ($message) {
    ErrorLog::create (array ('message' => $message));
  }
}
