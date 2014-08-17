<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @author      OA Wu <comdan66@gmail.com>
 * @copyright   Copyright (c) 2014 OA Wu Design
 */
class Users extends Delay_controller {
  public function __construct () {
    parent::__construct ();
  }

  public function update_pictures_count () {
    $user_id = $this->input_post ('user_id');
    if (($user = User::find ('one', array ('select' => 'id, pictures_count, updated_at', 'conditions' => array ('id = ?', $user_id)))) && ($picture = Picture::find ('one', array ('select' => 'COUNT(id) AS count', 'conditions' => array ('user_id = ?', $user->id))))) {
      $user->pictures_count = $picture->count;
      $user->save ();
      clean_cell ();
    }
  }
}
