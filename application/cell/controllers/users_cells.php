<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @author      OA Wu <comdan66@gmail.com>
 * @copyright   Copyright (c) 2014 OA Wu Design
 */
class Users_cells extends Cell_Controller {

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
}