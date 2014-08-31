<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @author      OA Wu <comdan66@gmail.com>
 * @copyright   Copyright (c) 2014 OA Wu Design
 */
class Php extends Site_controller {
  public function __construct () {
    parent::__construct ();
  }

  public function ture_false () {
    $this->load_view ();
  }
  public function use_isset () {
    $this->load_view ();
  }
  public function use_array () {
    $this->load_view ();
  }
}
