<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @author      OA Wu <comdan66@gmail.com>
 * @copyright   Copyright (c) 2014 OA Wu Design
 */
class Users extends Delay_controller {
  public function __construct () {
    parent::__construct ();
  }

  public function update_follows_count () {
    if (($user_id = $this->input_post ('user_id')) && ($be_user_id = $this->input_post ('be_user_id')) && ($user = User::find ('one', array ('select' => 'id, follows_count, updated_at', 'conditions' => array ('id = ?', $user_id)))) && ($be_user = User::find ('one', array ('select' => 'id, be_follows_count, updated_at', 'conditions' => array ('id = ?', $be_user_id))))) {
      clear_cell ('users_cells', 'user_score', $be_user->id);
      clear_cell ('users_cells', 'banner', $be_user->id);
      $be_user->be_follows_count = Follow::count (array ('conditions' => array ('be_user_id = ?', $be_user->id)));
      $be_user->save ();
      
      clean_cell ('main_cells', 'pictures', 'user_id_' . $user->id . '/*');
      clear_cell ('users_cells', 'user_score', $user->id);
      clear_cell ('users_cells', 'banner', $user->id);
      $user->follows_count = Follow::count (array ('conditions' => array ('user_id = ?', $user->id)));
      $user->save ();
    }
  }

  public function update_to_comments_count () {
    $user_id = $this->input_post ('user_id');
    if ($user = User::find ('one', array ('select' => 'id, to_picture_comments_count, updated_at', 'conditions' => array ('id = ?', $user_id)))) {
      $user->to_picture_comments_count = PictureComment::count (array ('conditions' => array ('user_id = ?', $user->id)));
      $user->save ();
      clear_cell ('users_cells', 'user_score', $user->id);
      clear_cell ('users_cells', 'banner', $user->id);
    }
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
