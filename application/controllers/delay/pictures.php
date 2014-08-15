<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @author      OA Wu <comdan66@gmail.com>
 * @copyright   Copyright (c) 2014 OA Wu Design
 */
class Pictures extends Delay_controller {
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
  public function update_comments_count () {
    $picture_id = $this->input_post ('picture_id');
    if (($picture = Picture::find ('one', array ('select' => 'id, comments_count, updated_at', 'conditions' => array ('id = ?', $picture_id)))) && ($picture_comment = PictureComment::find ('one', array ('select' => 'COUNT(id) AS count', 'conditions' => array ('picture_id = ?', $picture->id))))) {
      $picture->comments_count = $picture_comment->count;
      $picture->save ();
      clean_cell ('pictures_cells', 'comments', 'picture_id_' . $picture->id . '/*');
    }
  }
  public function add_pageview () {
    $id = $this->input_post ('id');
    if ($picture = Picture::find ('one', array ('select' => 'id, pageview, updated_at', 'conditions' => array ('id = ?', $id))))
      Pageview::add_count ($picture, 'pageview', 1);
  }
}
