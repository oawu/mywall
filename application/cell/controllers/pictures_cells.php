<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @author      OA Wu <comdan66@gmail.com>
 * @copyright   Copyright (c) 2014 OA Wu Design
 */
class Pictures_cells extends Cell_Controller {

  public function _cache_score_star ($picture) {
    return array ('time' => 60 * 60, 'key' => $picture->id);
  }
  public function score_star ($picture) {
    return $this->load_view (array ('picture' => $picture));
  }
  public function _cache_star_details ($picture) {
    return array ('time' => 60 * 60, 'key' => $picture->id);
  }
  public function star_details ($picture) {
    return $this->load_view (array ('picture' => $picture));
  }
  public function _cache_more_tags ($more_tags, $picture) {
    return array ('time' => 60 * 60, 'key' => $picture->id);
  }
  public function more_tags ($more_tags, $picture) {
    return $this->load_view (array ('more_tags' => $more_tags, 'picture' => $picture));
  }
  // public function _cache_main ($picture) {
  //   return array ('time' => 60 * 60, 'key' => $picture->id);
  // }
  public function main ($picture) {
    return $this->load_view (array ('picture' => $picture));
  }
  
  // public function _cache_to_comment ($picture) {
  //   return array ('time' => 60 * 60, 'key' => $picture->id);
  // }
  public function to_comment ($picture) {
    return $this->load_view (array ('picture' => $picture));
  }

  public function comment ($picture_comment) {
    return $this->load_view (array ('comment' => $picture_comment));
  }
  // public function _cache_comments ($picture_id, $next_id) {
  //   return array ('time' => 60 * 60, 'key' => 'picture_id_' . $picture_id . '/next_id_' . $next_id);
  // }
  public function comments ($picture_id, $next_id) {
    $conditions = $next_id ? array ('picture_id = ? AND id <= ?', $picture_id, $next_id) : array ('picture_id = ?', $picture_id);
    $pic_comments = PictureComment::find ('all', array ('order' => 'id DESC', 'include' => array ('user'), 'limit' => config ('pictures_controller_config', 'comments_length') + 1, 'conditions' => $conditions));
    $comments = array ();
    foreach (array_slice ($pic_comments, 0, config ('pictures_controller_config', 'comments_length')) as $comment)
      array_push ($comments, $this->load_view (array ('comment' => $comment), 'comment'));

    $next_id = ($pic_comments = ($pic_comments = array_slice ($pic_comments, config ('pictures_controller_config', 'comments_length'), 1)) ? $pic_comments[0] : null) ? $pic_comments->id : -1;
    return array ('comments' => $comments, 'next_id' => $next_id);
  }
}