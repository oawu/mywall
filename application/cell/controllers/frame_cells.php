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

  public function tag_category_top () {
    return $this->load_view ();
  }
  
}