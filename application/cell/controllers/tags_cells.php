<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @author      OA Wu <comdan66@gmail.com>
 * @copyright   Copyright (c) 2014 OA Wu Design
 */
class Tags_cells extends Cell_Controller {

  public function _cache_pictures ($next_id = 0, $tags = array ()) {
    return array ('time' => 60 * 60, 'key' => $tags ? 'tags/' . implode ('_|_', $tags) . '/id_' . $next_id : null);
  }
  public function pictures ($next_id = 0, $tags = array ()) {
    if (!$tags || !($tag_ids = field_array (PictureTag::find ('all', array ('select' => 'id', 'conditions' => array ('name IN (?)', $tags))), 'id')))
      return false;

    if (!($picture_ids = field_array (PictureTagMapping::find ('all', array ('select' => 'picture_id', 'order' => 'id DESC', 'limit' => config ('tags_controller_config', 'pictures_length') + 1, 'conditions' => $next_id ? array ('id <= ? AND picture_tag_id IN (?)', $next_id, $tag_ids) : array ('picture_tag_id IN (?)', $tag_ids))), 'picture_id')))
      return false;

    $pics = Picture::find ('all', array ('order' => 'year_week DESC, score DESC', 'include' => array ('user'), 'conditions' => array ('id IN (?)', array_slice ($picture_ids, 0, config ('tags_controller_config', 'pictures_length')))));
    $pictures = array ();
    foreach (array_slice ($pics, 0, config ('main_controller_config', 'pictures_length')) as $picture)
      array_push ($pictures, $this->load_view (array ('picture' => $picture)));

    $next_id = ($next_id = array_slice ($picture_ids, config ('tags_controller_config', 'pictures_length'), 1)) ? $next_id[0] : -1;
    return array ('pictures' => $pictures, 'next_id' => $next_id);
  }
}