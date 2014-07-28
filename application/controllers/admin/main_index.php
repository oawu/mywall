<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @author      OA Wu <comdan66@gmail.com>
 * @copyright   Copyright (c) 2014 OA Wu Design
 */
class Main_index extends Admin_controller {
  public function __construct () {
    parent::__construct ();
  }

  public function index ($per_page = 0) {
    $this->load_view ();
  }
}
