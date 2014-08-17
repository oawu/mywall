<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @author      OA Wu <comdan66@gmail.com>
 * @copyright   Copyright (c) 2014 OA Wu Design
 */
class User_actives extends Delay_controller {
  public function __construct () {
    parent::__construct ();
  }

  public function create_actives () {
    $user_id = $this->input_post ('user_id');
    $kind = $this->input_post ('kind');
    $model_name = $this->input_post ('model_name');
    $model_id = $this->input_post ('model_id');
    UserActive::create_active ($user_id, $kind, $model_name, $model_id);
    clean_cell ('users_cells', 'actives' ,'user_id_' . $user_id . '/*');
  }
}
