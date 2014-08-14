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
}