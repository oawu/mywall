<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @author      OA Wu <comdan66@gmail.com>
 * @copyright   Copyright (c) 2014 OA Wu Design
 */
class Main_cells extends Cell_Controller {

  public function _cache_demo () {
    return array ('time' => 60 * 60, 'key' => null);
  }

  public function index () {
    return $this->load_view ();
  }

  public function promos () {
    return $this->load_view ();
  }

  public function _cache_tag_category_block9s () {
    return array ('time' => 60 * 60, 'key' => null);
  }
  public function tag_category_block9s () {
    if ((config ('main_controller_config', 'block9s_count') && ($categories = TagCategory::find ('all', array ('order' => 'id DESC', 'limit' => config ('main_controller_config', 'block9s_count'), 'conditions' => array ('kind = ?', 'block9'))))) || ($categories = array ()))
      foreach ($categories as $category)
        $category->make_block9 ();

    return $this->load_view (array ('categories' => $categories));
  }

  public function pictures_order () {
    return $this->load_view ();
  }

  public function _cache_pictures ($next_id = 0) {
    return array ('time' => 60 * 60, 'key' => 'pictures/id_' . $next_id);
  }
  public function pictures ($next_id = 0) {
    $conditions = $next_id ? array ('id <= ?', $next_id) : array ();
    $pics = Picture::find ('all', array ('order' => 'id DESC', 'include' => array ('user'), 'limit' => config ('main_controller_config', 'pictures_length') + 1, 'conditions' => $conditions));
    $pictures = array ();
    foreach (array_slice ($pics, 0, config ('main_controller_config', 'pictures_length')) as $picture)
      array_push ($pictures, $this->load_view (array ('picture' => $picture)));

    $next_id = ($pics = ($pics = array_slice ($pics, config ('main_controller_config', 'pictures_length'), 1)) ? $pics[0] : null) ? $pics->id : -1;
    return array ('pictures' => $pictures, 'next_id' => $next_id);
  }
}