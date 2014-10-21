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
    // echo '<meta http-equiv="Content-type" content="text/html; charset=utf-8" /><pre>';
    // var_dump (base_url (utilitySameLevelPath (REL_PATH_FONT, 'bloominggrove', 'bgrove.ttf')));
    // exit ();
    $this//->add_css ('http://code.jquery.com/mobile/1.4.4/jquery.mobile-1.4.4.min.css')
         // ->add_css (base_url (utilitySameLevelPath (REL_PATH_CSS, 'jquery.mobile.custom_v1.4.4', 'jquery.mobile.custom.theme.css')))
         // ->add_javascript ('http://demos.jquerymobile.com/1.4.4/_assets/js/index.js')
         // ->add_javascript ('http://code.jquery.com/mobile/1.4.4/jquery.mobile-1.4.4.min.js')
         // ->add_javascript (base_url (utilitySameLevelPath (REL_PATH_JS, 'headroom_v0.7.0', 'headroom.min.js')))
         ->add_javascript (base_url (utilitySameLevelPath (REL_PATH_JS, 'salvattore_v1.0.5', 'salvattore.js')))
         // ->add_javascript ('https://raw.githubusercontent.com/WickyNilliams/headroom.js/v0.7.0/dist/headroom.min.js')
         ->load_view ();
  }
}
