<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @author      OA Wu <comdan66@gmail.com>
 * @copyright   Copyright (c) 2014 OA Wu Design
 */
class Errors extends Delay_controller {
  public function __construct () {
    parent::__construct ();
  }

  public function record () {
    if (verifyString ($message = $this->input_post ('message'))) {
      $object_id = verifyNumber ($object_id = $this->input_post ('object_id'), 1) ? $object_id : 0;
      $object_name = verifyString ($object_name = $this->input_post ('object_name')) ? $object_name : '';
      Error::create (array ('message' => $message, 'object_id' => $object_id, 'object_name' => $object_name, 'is_read' => '0'));
    }
  }
}
