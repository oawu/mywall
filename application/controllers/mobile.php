<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @author      OA Wu <comdan66@gmail.com>
 * @copyright   Copyright (c) 2014 OA Wu Design
 */
class Mobile extends Mobile_controller {
  public function __construct () {
    parent::__construct ();
  }

  public function index () {
    $this->add_css (base_url (utilitySameLevelPath (REL_PATH_CSS, 'jquery.mobile.custom_v1.4.4', 'jquery.mobile.custom.structure.css')))
         // ->add_css (base_url (utilitySameLevelPath (REL_PATH_CSS, 'jquery.mobile.custom_v1.4.4', 'jquery.mobile.custom.theme.css')))
         ->add_javascript (base_url (utilitySameLevelPath (REL_PATH_JS, 'jquery.mobile.custom_v1.4.4', 'jquery.mobile.custom.min.js')))
         ->load_view ();
  }
}
