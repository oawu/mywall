<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @author      OA Wu <comdan66@gmail.com>
 * @copyright   Copyright (c) 2014 OA Wu Design
 */
class Frame_cells extends Cell_Controller {

  public function user_bar () {
    return $this->load_view ();
  }

  public function main_banner () {
    return $this->load_view ();
  }

  public function feature_bar () {
    return $this->load_view ();
  }

  public function _cache_tag_category_top () {
    return array ('time' => 60 * 60, 'key' => null);
  }
  public function tag_category_top () {
    $categories = ($limit = config ('site_frame_config', 'tag_category_top', 'limit')) ? TagCategory::find ('all', array ('order' => 'id DESC', 'limit' => $limit, 'conditions' => array ('kind = ?', 'top'))) : array ();
    return $this->load_view (array ('categories' => $categories));
  }
  
}