<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @author      OA Wu <comdan66@gmail.com>
 * @copyright   Copyright (c) 2014 OA Wu Design
 */
class Main extends Site_controller {
  public function __construct () {
    parent::__construct ();
  }

  public function index () {
    $this->add_hidden (array ('id' => 'get_pictures_url', 'value' => base_url (array ($this->get_class (), 'get_pictures'))))
         ->load_view ();
  }

  public function get_pictures () {
    if (!$this->is_ajax ())
      show_error ("It's not Ajax request!<br/>Please confirm your program again.");
    if (($this->input_post ('next_id') >= 0) && ($pictures_info = render_cell ('main_cells', 'pictures', identity ()->user (), $this->input_post ('next_id'))))
      $this->output_json (array ('status' => true, 'next_id' => $pictures_info['next_id'], 'contents' => $pictures_info['pictures']));
    else 
      $this->output_json (array ('status' => false));
  }
}
