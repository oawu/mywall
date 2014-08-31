<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @author      OA Wu <comdan66@gmail.com>
 * @copyright   Copyright (c) 2014 OA Wu Design
 */
class Oaci extends Site_controller {
  public function __construct () {
    parent::__construct ();
  }

  public function struct () {
    $this->load_view ();
  }
  public function quick () {
    $this->load_view ();
  }
  public function root () {
    $this->load_view ();
  }
}
