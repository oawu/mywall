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
    if (!($id && is_numeric ($id) && ($user = User::find ('one', array ('conditions' => array ('id = ?', $id))))))
      redirect ();
    
    $this->add_hidden (array ('id' => 'get_scroll_range', 'value' => config ('users_controller_config', 'scroll_range')))
         ->add_hidden (array ('id' => 'get_actives_url', 'value' => base_url (array ($this->get_class (), 'get_actives'))))
         ->load_view (array ('user' => $user));
  }

  public function get_actives ($id = 0) {
    if (!$this->is_ajax ())
      show_error ("It's not Ajax request!<br/>Please confirm your program again.");
    if ($this->input_post ('id') && ($this->input_post ('next_id') >= 0) && ($actives_info = render_cell ('users_cells', 'actives', $this->input_post ('id'), $this->input_post ('next_id'))))
      $this->output_json (array ('status' => true, 'next_id' => $actives_info['next_id'], 'contents' => $actives_info['actives']));
    else 
      $this->output_json (array ('status' => false));
  }
}
