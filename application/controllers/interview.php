<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @author      OA Wu <comdan66@gmail.com>
 * @copyright   Copyright (c) 2014 OA Wu Design
 */
class Interview extends Site_controller {
  public function __construct () {
    parent::__construct ();
  }

  public function index () {
    $submit_url = base_url (array ($this->get_class (), 'submit'));
    $this->load_view (array ('submit_url' => $submit_url));
  }

  public function submit () {
    // $pic = $this->input_post ('pic_1', true, true);
    // $temp = TempPicture::create (array ('file_name' => '', 'message' => '', 'model_name' => '', 'model_id' => 0));
    // $temp->file_name->put ($pic);
    // $temp = TempPicture::find ('one', array ('conditions' => array ('id = 2')));
    // $temp->file_name->save_as ('aaa', array ('resize', 100, 100, 'width'));


// echo '<meta http-equiv="Content-type" content="text/html; charset=utf-8" /><pre>';
// echo $temp->file_name->url ('50x50');
// exit ();

    echo '<meta http-equiv="Content-type" content="text/html; charset=utf-8" /><pre>';
    var_dump ($this->input_post ('pic_1', true, true));
    var_dump ($this->input_post ('pic_2[]', true, true));

    echo '<meta http-equiv="Content-type" content="text/html; charset=utf-8" /><pre>';
    var_dump ($_FILES['pic_2']);
    exit ();
  }
  public function d1 () {
    $temp = TempPicture::find ('one', array ('conditions' => array ('id = 3')));
    echo $temp->file_name->url ();
    // $temp->file_name->save_as ('aaa', array ('resize', 100, 100, 'width'));
  }



}
