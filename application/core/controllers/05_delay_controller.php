<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @author      OA Wu <comdan66@gmail.com>
 * @copyright   Copyright (c) 2014 OA Wu Design
 */
class Delay_controller extends Root_controller {
  public function __construct () {
    parent::__construct ();
    if (!config ('delay_job_config', 'is_check') || !((($value = $this->input_post (config ('delay_job_config', 'key'))) !== null) && ($value == md5 (config ('delay_job_config', 'value')))))
      show_error ('The delay job key or value error! Please confirm your program again.');
  }
}