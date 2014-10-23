<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @author      OA Wu <comdan66@gmail.com>
 * @copyright   Copyright (c) 2014 OA Wu Design
 */
class React extends Site_controller {
  public function __construct () {
    parent::__construct ();
  }

  public function index () {
    $this->add_javascript (base_url (utilitySameLevelPath (REL_PATH_JS, 'react_v0.11.2', 'react.js')))
         ->add_javascript (base_url (utilitySameLevelPath (REL_PATH_JS, 'JSXTransformer_v0.11.2', 'JSXTransformer.js')))
         ->load_view ();
  }

}
