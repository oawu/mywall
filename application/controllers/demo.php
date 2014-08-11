<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @author      OA Wu <comdan66@gmail.com>
 * @copyright   Copyright (c) 2014 OA Wu Design
 */
class Demo extends Site_controller {
  public function __construct () {
    parent::__construct ();
  }


  public function index () {
    $pics = Picture::find ('all', array ('limit' => '10'));

    $temp_files = array ();
    if (count ($pics) > 8)
      foreach ($pics as $i => $pic)
        if (!$temp_files)
          array_push ($temp_files, $pic->file_name->save_as ('380', array ('adaptiveResizeQuadrant', 130, 130, 't')));
        else 
          array_push ($temp_files, $pic->file_name->save_as ('63', array ('adaptiveResizeQuadrant', 64, 64, 't')));
    
      $this->load->library ('ImageUtility');
      // require_once FCPATH . APPPATH . 'libraries/ImageBaseUtility.php';

      ImageUtility::make_block9 ($temp_files, FCPATH . 'upload/a.jpg');
echo '<meta http-equiv="Content-type" content="text/html; charset=utf-8" /><pre>';
var_dump ();
exit ();
  }

  public function x () {
    $this->load->library ('phpQuery');

    $get_html_str = str_replace ('&amp;', '&', urldecode (file_get_contents ('http://style.fashionguide.com.tw/')));

    $php_query = phpQuery::newDocument ($get_html_str);
    $blocks = pq ("#masonry .box", $php_query);

    for ($i = 0; $i < $blocks->length; $i++) { 
      $block = $blocks->eq ($i);
      $src = $block->find ('.box-img img')->attr ('src');
      $text = preg_replace ('/\s*(.*)\s*/', '$1', $block->find ('.message')->text ());
      
      $pic = Picture::create (array ('user_id' => '1', 'text' => $text, 'file_name' => ''));
      $pic->file_name->put_url ($src);
    }
    exit ();
  }
}
