<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @author      OA Wu <comdan66@gmail.com>
 * @copyright   Copyright (c) 2014 OA Wu Design
 */
class Menu_cells extends Cell_Controller {
  public function index ($now = 'index') {
    return $this->load_view (array ('now' => $now));
  }
}