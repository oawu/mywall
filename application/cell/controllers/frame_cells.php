<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @author      OA Wu <comdan66@gmail.com>
 * @copyright   Copyright (c) 2014 OA Wu Design
 */
class Frame_cells extends Cell_Controller {

  public function top_bar () {
    return $this->load_view ();
  }
}