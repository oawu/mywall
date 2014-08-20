<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @author      OA Wu <comdan66@gmail.com>
 * @copyright   Copyright (c) 2014 OA Wu Design
 */
class Main extends Site_controller {
  public function __construct () {
    parent::__construct ();
  }

  public function x () {
    $user = User::find ('one', array ('conditions' => array ('id = 10')));
    $user->score_set ();
    echo '<meta http-equiv="Content-type" content="text/html; charset=utf-8" /><pre>';
    var_dump ($user->score);
    exit ();
    // $user->set_score ();
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
