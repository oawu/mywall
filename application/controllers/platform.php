<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @author      OA Wu <comdan66@gmail.com>
 * @copyright   Copyright (c) 2014 OA Wu Design
 */
class Platform extends Site_controller {
  public function __construct () {
    parent::__construct ();
  }

  public function fb_sing_in () {
    if (($uid = facebook ()->getUser ()) && ($token = facebook ()->getAccessToken ()) && ($fb_user = $this->fb->fql ('SELECT email, name FROM user WHERE uid=' . $uid)) && ($fb_user = array_shift ($fb_user)) && isset ($fb_user['name']) && isset ($fb_user['email']) && $fb_user['name'] && $fb_user['email'] && ((($user = User::find ('one', array ('conditions' => array ('uid = ?', $uid)))) && ($user->name = $fb_user['name']) && ($user->email = $fb_user['email']) && $user->save ()) || verifyCreateOrm ($user = User::create (array ('uid' => $uid, 'name' => $fb_user['name'], 'email' => $fb_user['email'], 'register_from' => 'facebook')))))
      identity ()->set_session ('user_id', $user->id)->set_session ('fb_uid', $user->uid)->set_session ('fb_name', $user->name)->set_session ('fb_email', $user->email)->set_session ('_fb_sing_in_message', '使用 Facebook 登入成功!', true);
    else
      identity ()->set_session ('_fb_sing_in_message', 'Facebook 登入錯誤，請通知程式設計人員!', true);
    redirect (func_get_args (), 'refresh');
  }

  public function sign_out () {
    identity ()->set_identity ('sign_out')->set_session ('_fb_sing_in_message', '登出成功!', true);
    redirect (func_get_args (), 'refresh');
  }

  public function temp_sing_in () {
    $this->identity->set_session ('user_id', '1');
    $this->identity->set_session ('fb_uid', '100006789307672');
    $this->identity->set_session ('fb_name', '吳政賢');
    $this->identity->set_session ('fb_email', 'oa@fashionguide.com.tw');
  }
}
