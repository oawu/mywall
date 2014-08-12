<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @author      OA Wu <comdan66@gmail.com>
 * @copyright   Copyright (c) 2014 OA Wu Design
 */
class Demo extends Site_controller {
  public function __construct () {
    parent::__construct ();
  }
  public function g_p () {
    $this->load->library ('phpQuery');

    $get_html_str = str_replace ('&amp;', '&', urldecode (file_get_contents ('http://style.fashionguide.com.tw/')));

    $php_query = phpQuery::newDocument ($get_html_str);
    $blocks = pq ("#masonry .box", $php_query);

    for ($i = 0; $i < $blocks->length; $i++) { 
      $block = $blocks->eq ($i);
      $src = $block->find ('.box-img img')->attr ('src');
      $text = preg_replace ('/\s*(.*)\s*/', '$1', $block->find ('.message')->text ());
      
      $pic = Picture::create (array ('user_id' => '1', 'pageview' => 0, 'like_count' => 0, 'text' => $text, 'file_name' => ''));
      $pic->file_name->put_url ($src);
    }
    exit ();
  }

  public function o () {
    $tc = TagCategory::find_by_id (18);
    $tc->tags = 'dasdasd';
    // $tc->tags->save ();
    echo '<meta http-equiv="Content-type" content="text/html; charset=utf-8" /><pre>';
  }

  public function x () {
    $this->load->library ('phpQuery');

    $get_html_str = str_replace ('&amp;', '&', urldecode (file_get_contents ('http://style.fashionguide.com.tw')));

    $php_query = phpQuery::newDocument ($get_html_str);
    $blocks = pq ("#masonry .box", $php_query);
      echo '<meta http-equiv="Content-type" content="text/html; charset=utf-8" /><pre>';

    for ($i = 0; $i < $blocks->length; $i++) { 
      $block = $blocks->eq ($i);
      $src = $block->find ('.box-img img')->attr ('src');
      $tag = trim (preg_replace ('/\s*(.*)\s*/', '$1', $block->find ('.user-name')->text ()));
      $tag = trim (preg_replace ('/(.*)分享到(.*)的(.*)/', '$3', $tag));
      $text = preg_replace ('/\s*(.*)\s*/', '$1', $block->find ('.message')->text ());


      $pic = Picture::create (array ('user_id' => '1', 'pageview' => 0, 'like_count' => 0, 'text' => $text, 'file_name' => ''));
      $pic->file_name->put_url ($src);


      if ($tag && !($pic_tag = PictureTag::find ('one', array ('conditions' => array ('name = ?', $tag))))) {
        $pic_tag = PictureTag::create (array ('name' => $tag, 'picture_count' => '0'));
      }

      if (isset ($pic_tag)) {
        PictureTagMapping::create (array ('picture_id' => $pic->id, 'picture_tag_id' => $pic_tag->id));
      }
    }

    if ($pts = PictureTag::find ('all'))
      foreach ($pts as $pt) {
        $pt->picture_count = PictureTagMapping::count (array ('conditions' => array ('picture_tag_id = ?', $pt->id)));
        $pt->save ();
      }
    exit ();
  }



















  public function form () {
    echo "
    <form method='post' action='" . base_url (array ('demo', 'submit')) . "' enctype='multipart/form-data'>
      account: <input type='text' name='account' value='oa' />
      <hr/>

      books: <input type='text' name='books[]' value='a' />
      books: <input type='text' name='books[]' value='b' />
      books: <input type='text' name='books[]' value='c' />
      <hr/>

      pic: <input type='file' name='pic' value='' />
      <hr/>

      pics: <input type='file' name='pics[]' value='' />
      pics: <input type='file' name='pics[]' value='' />
      <hr/>

      <input type='submit' value='submit' />
    <form>";
  }

  public function submit () {
    // echo "<pre>";
    // $account = $this->input_post ('account');
    // echo "account: " . $account . '<br/>';
    
    // $books = $this->input_post ('books');
    // echo "books count : " . count ($books) . '<br/>';

    // $pic = $this->input_post ('pic', true, true);
    // echo "pic info : ";
    // print_r ($pic);
    // echo '<br/>';

    // $pics = $this->input_post ('pics[]', true, true);
    // echo "pics info : ";
    // print_r ($pics);
    // echo '<br/>';

    // if ($pic) {
    //   $picture = Picture::create (array (
    //     'user_id' => '1',
    //     'like_count' => 0,
    //     'pageview' => 0,
    //     'text' => 'xxx',
    //     'file_name' => ''));

    //   $picture->file_name->put ($pic);
    // }

      // $picture = Picture::create (array (
      //   'user_id' => '1',
      //   'like_count' => 0,
      //   'pageview' => 0,
      //   'text' => 'xxx',
      //   'file_name' => ''));
      // $picture->file_name->put_url ('http://front-pic.style.fashionguide.com.tw/uploads/share/picture/927654/thumb_middle_share_picture_53e7141ef0538.jpg');

    // $pic = Picture::find_by_id (1);
    // echo "<img src='".$pic->file_name->url ()."'/>";

    // $pic = Picture::find_by_id (1);
    echo "<img src='".$pic->file_name->url ('228xW')."'/>";

    // $pic = Picture::find_by_id (1);
    // echo $pic->file_name->save_as ('xx', array ('resize', 50, 50));


    echo "<hr/><a href='" . base_url (array ('demo', 'form')) . "'>Back</a>";
  }


  public function a () {
    $pics = Picture::find ('all', array ('limit' => '10'));

    $temp_files = array ();
    if (count ($pics) > 8)
      foreach ($pics as $i => $pic)
        if (!$temp_files)
          array_push ($temp_files, $pic->file_name->save_as ('380', array ('adaptiveResizeQuadrant', 130, 130, 't')));
        else 
          array_push ($temp_files, $pic->file_name->save_as ('63', array ('adaptiveResizeQuadrant', 64, 64, 't')));
    
      $this->load->library ('ImageUtility');

      ImageUtility::make_block9 ($temp_files, FCPATH . 'upload/a.jpg');
  }
  public function b () {
    // $pic = Picture::find ('one', array ('conditions' => array ('id = 2')));
    // $pic->recycle ();

    // $is_ok = Picture::recover ('one', array ('conditions' => array ('origin_id = 2')));

    // Picture::recycle_all (array ('conditions' => array ('id > 2')));
    // $is_ok = Picture::recover ('all', array ('conditions' => array ('origin_id > 2')));
  }


  public function c () {
    $appId = config ('facebook_config', 'appId');
    $gd = config ('image_utility_config', 'gd');
    
    echo '<meta http-equiv="Content-type" content="text/html; charset=utf-8" /><pre>';
    var_dump ($gd);
    exit ();
  }

















  public function index () {
    $ps = Picture::find ('all', array ('conditions' => array ('id = 1')));
    echo '<meta http-equiv="Content-type" content="text/html; charset=utf-8" /><pre>';
    foreach ($ps as $p) {
      echo $p->id;
      foreach ($p->tags as $tag) {
        echo $tag->name;
      }
      echo "<hr/>";
    }
    var_dump ();
    exit ();
  }

}
