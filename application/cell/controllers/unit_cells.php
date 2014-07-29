<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @author      OA Wu <comdan66@gmail.com>
 * @copyright   Copyright (c) 2014 OA Wu Design
 */
class Unit_cells extends Cell_Controller {

  public function _cache_more_tags ($more_tags, $unit) {
    return array ('time' => 60 * 60, 'key' => $unit->id);
  }
  public function more_tags ($more_tags, $unit) {
    return $this->load_view (array ('more_tags' => $more_tags, 'unit' => $unit));
  }

  public function _cache_star_details ($unit) {
    return array ('time' => 60 * 60, 'key' => $unit->id);
  }
  public function star_details ($unit) {
    return $this->load_view (array ('unit' => $unit));
  }

  public function _cache_score_star ($unit) {
    return array ('time' => 60 * 60, 'key' => $unit->id);
  }
  public function score_star ($unit) {
    return $this->load_view (array ('unit' => $unit));
  }

  public function _cache_comments ($unit, $next_id = 'null') {
    return array ('time' => 60 * 60, 'key' => 'unit_id_' . $unit->id . '/' . $next_id);
  }
  public function comments ($unit, $next_id = null) {
    $conditions = verifyNumber ($next_id) ? array ('unit_id = ? AND id <= ?', $unit->id, $next_id) : array ('unit_id = ?', $unit->id);
    $unit_comments = UnitComment::find ('all', array ('order' => 'id DESC', 'include' => array ('user'), 'limit' => config ('unit_config', 'comment', 'd4_length') + 1, 'conditions' => $conditions));

    $comments = array ();
    foreach (array_slice ($unit_comments, 0, config ('unit_config', 'comment', 'd4_length')) as $unit_comment) array_push ($comments, $this->load_view (array ('unit_comment' => $unit_comment)));
    $next_id = verifyObject ($next_unit_comment = verifyArray ($next_unit_comment = array_slice ($unit_comments, config ('unit_config', 'comment', 'd4_length'), 1)) ? $next_unit_comment[0] : null) ? $next_unit_comment->id : 0;

    return array ('comments' => $comments, 'comment_list' => implode ('', $comments), 'next_id' => $next_id);
  }

}