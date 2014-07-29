<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function a () {
  $args = func_get_args ();
  return implode (',', $args);
}

function b ($a, $b, $c, $d, $e) {
  return implode (',', array ($a, $b, $c, $d, $e));
}

function c ($a) {
  return implode (',', $a);
}


/**
 * @author      OA Wu <comdan66@gmail.com>
 * @copyright   Copyright (c) 2014 OA Wu Design
 */
class Main extends Site_controller {
  public function __construct () {
    parent::__construct ();

  }

  public function index () {

    // // echo '<meta http-equiv="Content-type" content="text/html; charset=utf-8" /><pre>';
    // // var_dump (is_readable (FCPATH . APPPATH . 'views/component/site/css.php'));
    // // exit ();
    //   $s_time = microtime (true);
    //   // for ($i = 0; $i < 100; $i++) { 
    //   //   // a ('123', 'qwe', 'zxc', 'uyt', '3213');
    //   //   b ('123', 'qwe', 'zxc', 'uyt', '3213');
    //   //   // c (array ('123', 'qwe', 'zxc', 'uyt', '3213'));
    //   // }
    //   // for ($i = 0; $i < 10000; $i++) { 
    //   //   $a = array ();
    //   //   if (count ($a));
    //   // }

    //   $e_time = microtime (true);

    //   echo $e_time - $s_time;

    //   echo '<meta http-equiv="Content-type" content="text/html; charset=utf-8" /><pre>';
    //   var_dump ($this->input_get ('a'));
    //   exit ();
    // echo "<form name='fm' method='POST' action='" . base_url ( array ($this->get_class (), 'xxx')) . "' enctype='multipart/form-data'>
    //         <input type='hidden' name='user_id' value='17845'/>
    //         <input type='hidden' name='user_token' value='d757c45d63d9c1cb2f3d004f3530dc04'/>
    //         <input type='hidden' name='uid' value='0'/><input type='hidden' name='text' value='text'/>
    //         <input type='hidden' name='category_id' value='20'/>
    //         <input type='hidden' name='magazine_ids' value=''/>
    //         <input type='file' name='files[]' value=''/>
    //         <input type='file' name='files[]' value=''/>
    //         <input type='submit' value='submit'/>
    //       </form>";

    // $this->load_view ();

    echo '<meta http-equiv="Content-type" content="text/html; charset=utf-8" /><pre>';
    var_dump (config ('search_config', 'types', 'share'));
    exit ();

  }

  public function xxx () {
    echo '<meta http-equiv="Content-type" content="text/html; charset=utf-8" /><pre>';
    var_dump ($this->input_post ('files', true, true));
    exit ();
  }


}
