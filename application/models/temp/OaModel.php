<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class OaModel extends ActiveRecordModel {

  public function __construct ($attributes = array (), $guard_attributes = TRUE, $instantiating_via_find = FALSE, $new_record = TRUE) {
    parent::__construct ($attributes, $guard_attributes, $instantiating_via_find, $new_record);
  }

  

  protected function delay ($class, $method, $params = array ()) {
  	$params = array_merge ($params, array ($this->config ('request_code_key') => md5 ($this->config ('request_code_value'))));
  	send_post ($this->config ('url') . '/' . strtolower ($class) . '/' . strtolower ($method), $params);
  }
}