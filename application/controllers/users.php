<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @author      OA Wu <comdan66@gmail.com>
 * @copyright   Copyright (c) 2014 OA Wu Design
 */
class Users extends Site_controller {
  public function __construct () {
    parent::__construct ();
    $this->add_javascript (base_url (utilitySameLevelPath (REL_PATH_JS . 'tween_max_v1.13.1', 'TweenMax.min.js')));
  }

  public function index ($id = 0) {
    if (!($id && is_numeric ($id) && ($picture = Picture::find ('one', array ('conditions' => array ('id = ?', $id))))))
      redirect ();
    $this->load_view ();
  }
}
