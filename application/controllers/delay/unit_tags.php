<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @author      OA Wu <comdan66@gmail.com>
 * @copyright   Copyright (c) 2014 OA Wu Design
 */
class Unit_tags extends Delay_controller {
  public function __construct () {
    parent::__construct ();
  }

  public function update_units_count () {
    $unit_tag_ids = $this->input_post ('unit_tag_ids');
    if (count ($unit_tag_ids)) {
      $tags = UnitTag::find ('all', array ('select' => 'id, units_count, updated_at', 'conditions' => array ('id IN (?)', $unit_tag_ids)));
      array_map (function ($tag) {
        $tag->units_count = $tag->units_count_obj->count;
        $tag->save ();
      }, $tags);
    }
  }
}
