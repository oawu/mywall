<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class ActiveRecordModel extends ActiveRecord\Model {
  private $CI = null;

  protected $type = null;
  
  public function __construct ($attributes = array (), $guard_attributes = TRUE, $instantiating_via_find = FALSE, $new_record = TRUE) {
    parent::__construct ($attributes, $guard_attributes, $instantiating_via_find, $new_record);

    $this->CI =& get_instance ();
    // $this->CI->load->library ('session');
    // $this->CI->load->library ('ModelUploader');
    // $this->CI->load->library ('TypeVerify');
    // $this->CI->load->helper ('phpactiverecord_object_utility');
    // $this->CI->load->helper ('my');
    // $this->type = $this->CI->typeverify;
  }

  protected function set_session ($key, $value, $is_flashdata = false) {
    if (!$is_flashdata) $this->CI->session->set_userdata ($key, $value);
    else $this->CI->session->set_flashdata ($key, $value);

    return $this;
  }

  protected function get_session ($key, $is_flashdata = false) {
    $value = !$is_flashdata ? $this->CI->session->userdata ($key) : $this->CI->session->flashdata ($key);
    return $this->type->verifyBase ($value) ? $value : null;
  }

  protected function config () {
    $levels = array ('d4_config', 'delay', 'model'); for ($i = 0; $i < func_num_args (); $i++) array_push ($levels, func_get_arg ($i));
    return call_user_func_array (array ($this->CI, 'get_config'), $levels);
  }
}
