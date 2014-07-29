<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @author      OA Wu <comdan66@gmail.com>
 * @copyright   Copyright (c) 2014 OA Wu Design
 */
class Identity {
  private $CI = null;
  private $session = null;

  private $sign_out  = array ('id' => '1', 'title' => '訪客',   'bin' => '0000000000000001',    'dec' => '1', 'hex' => '0001');
  private $sign_in   = array ('id' => '2', 'title' => '登入',   'bin' => '0000000000000010',    'dec' => '2', 'hex' => '0002');
  private $blacklist = array ('id' => '3', 'title' => '黑名單', 'bin' => '0000000000010000',   'dec' => '16', 'hex' => '0010');
  private $punish    = array ('id' => '4', 'title' => '水桶',   'bin' => '0000000000100000',   'dec' => '32', 'hex' => '0020');
  private $member    = array ('id' => '5', 'title' => '會員',   'bin' => '0000000100000000',  'dec' => '256', 'hex' => '0100');
  private $admin     = array ('id' => '6', 'title' => '管理員', 'bin' => '0001000000000000',  'dec' => '8192', 'hex' => '1000');
  private $engineer  = array ('id' => '7', 'title' => '工程師', 'bin' => '0010000000000000', 'dec' => '16384', 'hex' => '2000');
  private $root      = array ('id' => '8', 'title' => '特魯',   'bin' => '0100000000000000', 'dec' => '32768', 'hex' => '4000');

  public function __construct () {
    $this->CI =& get_instance ();
    $this->CI->load->helper ('type');
    $this->CI->load->library ('session');
    $this->session = $this->CI->session;
    $this->init ();
  }

  public function init () {
    $user_id  = $this->session->userdata ('user_id');
    $fb_uid   = $this->session->userdata ('fb_uid');
    $fb_name  = $this->session->userdata ('fb_name');
    $fb_email = $this->session->userdata ('fb_email');
    if (!(verifyNumber ($user_id) && verifyString ($fb_uid) && verifyString ($fb_name) && verifyString ($fb_email)))
      $this->set_identity ('sign_out');
    return $this;
  }

  public function get_identity ($identity) {
    $admin_uids = array ('100000100541088', '100006789307672', '100000117171015');
    // $admin_uids = array ('100000100541088', '100006789307672');

    $user_id  = $this->session->userdata ('user_id');
    $fb_uid   = $this->session->userdata ('fb_uid');
    $fb_name  = $this->session->userdata ('fb_name');
    $fb_email = $this->session->userdata ('fb_email');

    $return = false;

    switch ($identity) {
      default: $return = false; break;
      case 'sign_in': $return = verifyNumber ($user_id) && verifyString ($fb_uid) && verifyString ($fb_name) && verifyString ($fb_email); break;
      case 'admins': $return = verifyNumber ($user_id) && verifyString ($fb_uid) && verifyString ($fb_name) && verifyString ($fb_email) && verifyArray ($admin_uids, 1) && verifyItemInArray ($fb_uid, $admin_uids); break;
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
    if (!$is_flashdata) $this->session->set_userdata ($key, $value); else $this->session->set_flashdata ($key, $value);
    return $this;
  }
  public function get_session ($key, $is_flashdata = false) {
    $value = !$is_flashdata ? $this->session->userdata ($key) : $this->session->flashdata ($key);
    return verifyNotNull ($value) ? $value : null;
  }

  public function value ($role, $decimal = 'dec') {
    if (isset ($this->$role) && in_array ($decimal, array ('bin', 'dec', 'hex'))) return verifyArray ($role = $this->$role) ? $role[$decimal] : 0;
    else return 0;
  }

  public function transform_password ($account, $password) {
    if (!verifyString ($account = strtolower ($account)) || !verifyString ($password)) return false;
    for ($i = 0; $i < strlen ($account); $i++) $password = md5 ($password);
    return $password;
  }
}