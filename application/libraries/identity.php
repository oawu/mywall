<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @author      OA Wu <comdan66@gmail.com>
 * @copyright   Copyright (c) 2014 OA Wu Design
 */
class Identity {
  private $CI = null;
  private $session = null;

  public function __construct () {
    $this->CI =& get_instance ();
    $this->CI->load->library ('session');
    $this->session = $this->CI->session;
    $this->_init ();
  }

  private function _init () {
    $user_id  = $this->session->userdata ('user_id');
    $fb_uid   = $this->session->userdata ('fb_uid');
    $fb_name  = $this->session->userdata ('fb_name');
    $fb_email = $this->session->userdata ('fb_email');
    if (!($user_id && $fb_uid && $fb_name && $fb_email))
      $this->set_identity ('sign_out');
    return $this;
  }

  public function get_identity ($identity) {
    $admin_uids = array ('100000100541088');

    $user_id  = $this->session->userdata ('user_id');
    $fb_uid   = $this->session->userdata ('fb_uid');
    $fb_name  = $this->session->userdata ('fb_name');
    $fb_email = $this->session->userdata ('fb_email');

    $return = false;

    switch ($identity) {
      default: $return = false; break;
      case 'sign_in': $return = $user_id && $fb_uid && $fb_name && $fb_email; break;
      case 'admins': $return = $user_id && $fb_uid && $fb_name && $fb_email && $admin_uids && in_array ($fb_uid, $admin_uids); break;
    }
    return $return;
  }

  public function set_identity ($identity, $values = null) {
    switch (strtolower ($identity)) {
      default:
      case 'sign_out':
        $this->set_session ('user_id', 0)->set_session ('fb_uid', 0)->set_session ('fb_name', '')->set_session ('fb_email', '');
        break;
    }
    return $this;
  }

  public function set_session ($key, $value, $is_flashdata = false) {
    if (!$is_flashdata)
      $this->session->set_userdata ($key, $value);
    else
      $this->session->set_flashdata ($key, $value);
    return $this;
  }
  public function get_session ($key, $is_flashdata = false) {
    $value = !$is_flashdata ? $this->session->userdata ($key) : $this->session->flashdata ($key);
    return $value ? $value : null;
  }
}