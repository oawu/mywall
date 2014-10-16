<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @author      OA Wu <comdan66@gmail.com>
 * @copyright   Copyright (c) 2014 OA Wu Design
 */
class Test extends Site_controller {
  public function __construct () {
    parent::__construct ();
  }

  public function index () {
    $this->add_javascript (base_url (utilitySameLevelPath (REL_PATH_JS, 'underscore_v1.7.0', 'underscore-min.js')))
         ->load_view ();
  }
}
