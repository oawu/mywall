<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @author      OA Wu <comdan66@gmail.com>
 * @copyright   Copyright (c) 2014 OA Wu Design
 */
class Users extends Site_controller {

  public function __construct () {
    parent::__construct ();
    $this->add_javascript (base_url (utilitySameLevelPath (REL_PATH_JS . 'tween_max_v1.13.1', 'TweenMax.min.js')));
  }

  public function index ($id = 0) {
    if (!($id && is_numeric ($id) && ($user = User::find ('one', array ('conditions' => array ('id = ?', $id))))))
      redirect ();
    
    $this->add_hidden (array ('id' => 'get_scroll_range', 'value' => config ('users_controller_config', 'scroll_range')))
         ->add_hidden (array ('id' => 'get_actives_url', 'value' => base_url (array ($this->get_class (), 'get_actives'))))
         ->add_hidden (array ('id' => 'set_follow_url', 'value' => base_url (array ($this->get_class (), 'set_follow'))))
         ->load_view (array ('user' => $user));
  }

  public function pictures ($id = 0) {
    if (!($id && is_numeric ($id) && ($user = User::find ('one', array ('conditions' => array ('id = ?', $id))))))
      redirect ();

    $this->add_hidden (array ('id' => 'get_pictures_url', 'value' => base_url (array ($this->get_class (), 'get_pictures'))))
         ->add_hidden (array ('id' => 'set_follow_url', 'value' => base_url (array ($this->get_class (), 'set_follow'))))
         ->load_view (array ('user' => $user));
  }

  public function get_pictures () {
    if (!$this->is_ajax ())
      show_error ("It's not Ajax request!<br/>Please confirm your program again.");

    if ($this->input_post ('user_id') && ($this->input_post ('next_id') >= 0) && ($pictures_info = render_cell ('users_cells', 'pictures', $this->input_post ('user_id'), $this->input_post ('next_id'))))
      $this->output_json (array ('status' => true, 'next_id' => $pictures_info['next_id'], 'contents' => $pictures_info['pictures']));
    else 
      $this->output_json (array ('status' => false));
  }
  public function get_actives ($id = 0) {
    if (!$this->is_ajax ())
      show_error ("It's not Ajax request!<br/>Please confirm your program again.");
    if ($this->input_post ('id') && ($this->input_post ('next_id') >= 0) && ($actives_info = render_cell ('users_cells', 'actives', $this->input_post ('id'), $this->input_post ('next_id'))))
      return $this->output_json (array ('status' => true, 'next_id' => $actives_info['next_id'], 'contents' => $actives_info['actives']));
    else 
      return $this->output_json (array ('status' => false));
  }

  public function set_follow () {
    if (!$this->is_ajax ())
      show_error ("It's not Ajax request!<br/>Please confirm your program again.");

    $action = $this->input_post ('action');
    $user_id = $this->input_post ('user_id');
    $be_user_id = $this->input_post ('be_user_id');

    if (!(identity ()->get_identity ('sign_in') && (identity ()->get_session ('user_id') == $user_id) && ($user_id != $be_user_id)))
      return $this->output_json (array ('status' => false, 'message' => '身份錯誤！'));

    switch ($action) {
      case 'add':
        if ($follow = Follow::find ('one', array ('conditions' => array ('user_id = ? AND be_user_id = ?', $user_id, $be_user_id))))
          return $this->output_json (array ('status' => false, 'message' => '你已經有 Follow ' . $follow->be_user->name . ' 了！'));
        else if (($follow = Follow::recover ('one', array ('conditions' => array ('user_id = ? AND be_user_id = ?', identity ()->user ()->id, $be_user_id)))) || verifyCreateOrm ($follow = Follow::create (array ('user_id' => identity ()->user ()->id, 'be_user_id' => $be_user_id)))) {
          clear_cell ('users_cells', 'follow_me', $follow->be_user_id);
          clear_cell ('users_cells', 'my_follow', $follow->user_id);
          delay_job ('user_actives', 'create_actives', array ('user_id' => $follow->user_id, 'kind' => 'to_follow', 'model_name' => get_class ($follow), 'model_id' => $follow->be_user_id));
          delay_job ('user_actives', 'create_actives', array ('user_id' => $follow->be_user_id, 'kind' => 'be_follow', 'model_name' => get_class ($follow), 'model_id' => $follow->user_id));
          delay_job ('users', 'update_follows_count', array ('user_id' => $follow->user_id, 'be_user_id' => $follow->be_user_id));

          return $this->output_json (array ('status' => true, 'message' => '你已經開始 Follow ' . $follow->be_user->name . '！', 'info' => array ('id' => identity ()->user ()->id, 'url' => base_url (array ('users', identity ()->user ()->id)), 'avatar' => identity ()->user ()->avatar_url (100, 100), 'name' => identity ()->user ()->name)));
        } else
          return $this->output_json (array ('status' => false, 'message' => '設定 Follow 失敗！'));
        break;

      case 'del':
        if (!$follow = Follow::find ('one', array ('conditions' => array ('user_id = ? AND be_user_id = ?', $user_id, $be_user_id))))
          return $this->output_json (array ('status' => false, 'message' => '你尚未 Follow 他！'));
        else if ($follow->recycle ()) {
          clear_cell ('users_cells', 'follow_me', $follow->be_user_id);
          clear_cell ('users_cells', 'my_follow', $follow->user_id);
          delay_job ('users', 'update_follows_count', array ('user_id' => $follow->user_id, 'be_user_id' => $follow->be_user_id));
          return $this->output_json (array ('status' => true, 'message' => '你已經取消 Follow ' . $follow->be_user->name . ' 了！', 'info' => array ('id' => identity ()->user ()->id)));
        } else {
          $this->output_json (array ('status' => false, 'message' => '設定 Follow 失敗！'));
        }
        break;
      
      default:
        return $this->output_json (array ('status' => false, 'message' => '設定 Follow 失敗！'));
        break;
    }
  }
}
