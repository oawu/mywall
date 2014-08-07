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
    // sleep(1);
    TempPicture::trace ('-------------------------' . $this->input_post ('msg'));
    echo "---";
    // exit();
  }
}
