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
    //->add_css ('http://code.jquery.com/mobile/1.4.4/jquery.mobile-1.4.4.min.css')
         // ->add_css (base_url (utilitySameLevelPath (REL_PATH_CSS, 'jquery.mobile.custom_v1.4.4', 'jquery.mobile.custom.theme.css')))
         // ->add_javascript ('http://demos.jquerymobile.com/1.4.4/_assets/js/index.js')
         // ->add_javascript ('http://code.jquery.com/mobile/1.4.4/jquery.mobile-1.4.4.min.js')
         // ->add_javascript (base_url (utilitySameLevelPath (REL_PATH_JS, 'headroom_v0.7.0', 'headroom.min.js')))
         // ->add_javascript ('https://raw.githubusercontent.com/WickyNilliams/headroom.js/v0.7.0/dist/headroom.min.js')
    $this->add_hidden (array ('id' => 'get_pictures_url', 'value' => base_url (array ($this->get_class (), 'get_pictures'))))
         ->add_javascript (base_url (utilitySameLevelPath (REL_PATH_JS, 'salvattore_v1.0.5', 'salvattore.js')))
         ->load_view ();
  }
  public function get_pictures () {
    if (!$this->is_ajax ())
      show_error ("It's not Ajax request!<br/>Please confirm your program again.");
    if (($next_id = $this->input_post ('next_id')) < 0)
      $this->output_json (array ('status' => false));

    $length = 5;
    $conditions = $next_id ? array ('id <= ?', $next_id) : array ();
    $pics = Picture::find ('all', array ('order' => 'id DESC', 'include' => array ('user'), 'limit' => $length + 1, 'conditions' => $conditions));
    $pictures = array ();
    foreach (array_slice ($pics, 0, $length) as $picture)
      array_push ($pictures, $this->set_method ('get_picture')->load_content (array ('picture' => $picture), true));

    $next_id = ($pics = ($pics = array_slice ($pics, $length, 1)) ? $pics[0] : null) ? $pics->id : -1;

    $this->output_json (array ('status' => true, 'next_id' => $next_id, 'contents' => $pictures));
  }
}
