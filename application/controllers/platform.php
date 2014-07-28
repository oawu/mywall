<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @author      OA Wu <comdan66@gmail.com>
 * @copyright   Copyright (c) 2014 OA Wu Design
 */
class Platform extends Site_controller {
  public function __construct () {
    parent::__construct ();
  }

  public function fb_sing_in ($page = '') {
    if (verifyString ($uid = $this->fb->getUser ()) && verifyString ($token = $this->fb->getAccessToken ())) {
      if (verifyObject ($user = User::find ('one', array ('conditions' => array ('uid = ?', $uid))))) {
        $this->identity->set_session ('user_id', $user->id);
        $this->identity->set_session ('fb_uid', $user->uid);
        $this->identity->set_session ('fb_name', $user->name);
        $this->identity->set_session ('fb_email', $user->email);

      } else if (verifyArray ($fb_user = $this->fb->fql ('SELECT email, name FROM user WHERE uid=' . $uid)) && verifyArray ($fb_user = array_shift ($fb_user)) && verifyCreateObject ($user = User::create (array ('uid' => $uid, 'name' => $fb_user['name'], 'email' => $fb_user['email'], 'register_from' => 'facebook')))) {
        $this->identity->set_session ('user_id', $user->id);
        $this->identity->set_session ('fb_uid', $user->uid);
        $this->identity->set_session ('fb_name', $user->name);
        $this->identity->set_session ('fb_email', $user->email);

      } else { redirect (array ('error', 'facebook_sing_in')); }
    } else { redirect (array ('error', 'facebook_sing_in')); }

    redirect (verifyArray ($pages = explode ('|', rawurldecode ($page))) ? $pages : 'main_index');
  }

  public function sign_out () {
    $this->identity->set_identity ('sign_out');
    redirect (array ('main_index'));
  }

  public function temp_sing_in () {
    $this->identity->set_session ('user_id', '1');
    $this->identity->set_session ('fb_uid', '100006789307672');
    $this->identity->set_session ('fb_name', '吳政賢');
    $this->identity->set_session ('fb_email', 'oa@fashionguide.com.tw');
  }
}
