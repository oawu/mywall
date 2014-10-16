<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @author      OA Wu <comdan66@gmail.com>
 * @copyright   Copyright (c) 2014 OA Wu Design
 */
class Table extends Site_controller {
  public function __construct () {
    parent::__construct ();
  }

  public function del_list () {
    $tags = DeleteTag::find ('all');
    $this->load_view (array ('tags' => $tags));
  }
  public function group_list () {
    $tags = array_map (function ($group) {
        return $group->main;
    }, Group::find ('all', array ('select' => 'main_id', 'include' => array ('main'), 'group' => 'main_id')));
    $this->load_view (array ('tags' => $tags));
    // Group::trace ('----------------');
    // foreach ($tags[0]->group_tags () as $key => $tag) {
    //     echo $tag->id;
    // }
  }
}
