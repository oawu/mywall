<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @author      OA Wu <comdan66@gmail.com>
 * @copyright   Copyright (c) 2014 OA Wu Design
 */
class Users_cells extends Cell_Controller {

  public function _cache_user_score ($user) {
    return array ('time' => 60 * 60, 'key' => $user->id);
  }
  public function user_score ($user) {
    return $this->load_view (array ('user' => $user));
  }
  public function _cache_actives ($user_id, $next_id) {
    return array ('time' => 60 * 60, 'key' => 'user_id_' . $user_id . '/next_id_' . $next_id);
  }
  public function actives ($user_id, $next_id) {
    $conditions = $next_id ? array ('user_id = ? AND id <= ?', $user_id, $next_id) : array ('user_id = ?', $user_id);
    $user_actives = UserActive::find ('all', array ('order' => 'id DESC', 'include' => array ('user'), 'limit' => config ('users_controller_config', 'actives_length') + 1, 'conditions' => $conditions));
    $actives = array ();
    foreach (array_slice ($user_actives, 0, config ('users_controller_config', 'actives_length')) as $active)
      array_push ($actives, $this->load_view (array ('active' => $active), 'active'));
    $next_id = ($user_actives = ($user_actives = array_slice ($user_actives, config ('users_controller_config', 'actives_length'), 1)) ? $user_actives[0] : null) ? $user_actives->id : -1;
    return array ('actives' => $actives, 'next_id' => $next_id);
  }

  public function _cache_my_follow ($user) {
    return array ('time' => 60 * 60, 'key' => $user->id);
  }
  public function my_follow ($user) {
    return $this->load_view (array ('user' => $user));
  }
  public function _cache_follow_me ($user) {
    return array ('time' => 60 * 60, 'key' => $user->id);
  }
  public function follow_me ($user) {
    return $this->load_view (array ('user' => $user));
  }
  // public function _cache_user_feature ($user) {
  //   return array ('time' => 60 * 60, 'key' => $user->id);
  // }
  public function user_feature ($user) {
    return $this->load_view (array ('user' => $user));
  }
  public function _cache_pictures ($user_id, $next_id = 0) {
    return array ('time' => 60 * 5, 'key' => 'user_id_' . $user_id . '/next_id_' . $next_id);
  }
  public function pictures ($user_id, $next_id = 0) {
    $conditions = $next_id ? array ('user_id = ? AND id <= ?', $user_id, $next_id) : array ('user_id = ?', $user_id);
    $pics = Picture::find ('all', array ('order' => 'id DESC', 'include' => array ('user'), 'limit' => config ('users_controller_config', 'pictures_length') + 1, 'conditions' => $conditions));
    $pictures = array ();
    foreach (array_slice ($pics, 0, config ('users_controller_config', 'pictures_length')) as $picture)
      array_push ($pictures, $this->load_view (array ('picture' => $picture)));
    $next_id = ($pics = ($pics = array_slice ($pics, config ('users_controller_config', 'pictures_length'), 1)) ? $pics[0] : null) ? $pics->id : -1;

    return array ('pictures' => $pictures, 'next_id' => $next_id);
  }
}