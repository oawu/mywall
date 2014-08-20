<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @author      OA Wu <comdan66@gmail.com>
 * @copyright   Copyright (c) 2014 OA Wu Design
 */
class Crontabs extends Site_controller {
  public function __construct () {
    parent::__construct ();
  }

  public function index () {

  }

  public function set_users_score () {
    array_map (function () { $user->score_set (); }, User::find ('all'));
  }
}
