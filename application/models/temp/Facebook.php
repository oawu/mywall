<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Facebook extends OaModel {

  static  $table_name = 'facebooks';

  static $belongs_to = array (
    array ('user', 'class_name' => 'User')
  );
  
  public function __construct ($attributes = array (), $guard_attributes = TRUE, $instantiating_via_find = FALSE, $new_record = TRUE) {
    parent::__construct ($attributes, $guard_attributes, $instantiating_via_find, $new_record); 
  }
}
