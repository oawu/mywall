<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @author      OA Wu <comdan66@gmail.com>
 * @copyright   Copyright (c) 2014 OA Wu Design
 */
class Main extends Site_controller {
  public function __construct () {
    parent::__construct ();
  }

  public function index () {
    $this->add_hidden (array ('id' => 'get_tags_url', 'value' => base_url (array ($this->get_class (), 'get_tags'))))
         ->add_hidden (array ('id' => 'del_tag_url', 'value' => base_url (array ($this->get_class (), 'del_tag'))))
         ->load_view ();
  }

  public function get_tags () {
    if (!$this->is_ajax ())
      show_error ("It's not Ajax request!<br/>Please confirm your program again.");
    
    if (($next_id = $this->input_post ('next_id')) >= 0) {
      $length = 100;
      $tags = Tag::find ('all', array ('order' => 'id ASC', 'limit' => $length + 1, 'conditions' => array ('id >= ? AND enable = ?', $next_id, 1)));
      $tagss = array ();

      foreach (array_slice ($tags, 0, $length) as $tag)
        array_push ($tagss, $this->set_method ('get_tag')->load_content (array ('tag' => $tag), true));
      $next_id = ($tags = ($tags = array_slice ($tags, $length, 1)) ? $tags[0] : null) ? $tags->id : -1;

      $this->output_json (array ('status' => true, 'next_id' => $next_id, 'contents' => $tagss));
    }
    else 
      $this->output_json (array ('status' => false));
  }

  public function del_tag () {
    if (!$this->is_ajax ())
      show_error ("It's not Ajax request!<br/>Please confirm your program again.");

    if (($id = $this->input_post ('id')) <= 0)
      return $this->output_json (array ('status' => false));

    $tag = Tag::find ('one', array ('conditions' => array ('id = ?', $id)));
    $tag->recycle ();
    return $this->output_json (array ('status' => true));
  }

  public function trash () {
    $this->add_hidden (array ('id' => 'get_trashs_url', 'value' => base_url (array ($this->get_class (), 'get_trashs'))))
         ->add_hidden (array ('id' => 'del_trash_url', 'value' => base_url (array ($this->get_class (), 'del_trash'))))
         ->load_view ();
  }

  public function get_trashs () {
    if (!$this->is_ajax ())
      show_error ("It's not Ajax request!<br/>Please confirm your program again.");
    
    if (($next_id = $this->input_post ('next_id')) >= 0) {
      $length = 100;
      $tags = DeleteTag::find ('all', array ('order' => 'id ASC', 'limit' => $length + 1, 'conditions' => array ('id >= ?', $next_id)));
      $tagss = array ();

      foreach (array_slice ($tags, 0, $length) as $tag)
        array_push ($tagss, $this->set_method ('get_trash')->load_content (array ('tag' => $tag), true));
      $next_id = ($tags = ($tags = array_slice ($tags, $length, 1)) ? $tags[0] : null) ? $tags->id : -1;

      $this->output_json (array ('status' => true, 'next_id' => $next_id, 'contents' => $tagss));
    }
    else 
      $this->output_json (array ('status' => false));
  }

  public function del_trash () {
    if (!$this->is_ajax ())
      show_error ("It's not Ajax request!<br/>Please confirm your program again.");

    if (($id = $this->input_post ('id')) <= 0)
      return $this->output_json (array ('status' => false));

    $tag = Tag::recover ('one', array ('conditions' => array ('id = ?', $id)));
    return $this->output_json (array ('status' => true));
  }

  // public function file () {
  //   $file_id = FCPATH . 'resource' . DIRECTORY_SEPARATOR . 'file' . DIRECTORY_SEPARATOR . 'id';
  //   $file_name = FCPATH . 'resource' . DIRECTORY_SEPARATOR . 'file' . DIRECTORY_SEPARATOR . 'name';

  //   $ids = array ();
  //   $handle = fopen($file_id, "r");
  //   if ($handle) {
  //       while (($line = fgets($handle)) !== false) {
  //           array_push ($ids, preg_replace("/(\n)$/", "", $line));
  //       }
  //   }
  //   fclose($handle);

  //   $names = array ();
  //   $handle = fopen($file_name, "r");
  //   if ($handle) {
  //       while (($line = fgets($handle)) !== false) {
  //           array_push ($names, preg_replace("/(\n)$/", "", $line));
  //       }
  //   }
  //   fclose($handle);

  //   $list = array_combine ($ids, $names);
  //   foreach ($list as $id => $name) {
  //     // Tag::create (array ('db_id' => $id, 'name' => $name, 'enable' => 1));
  //   }
  //   echo "OK";
  // }

  // public function del_list () {
  //   $tags = Tag::find ('all', array ('conditions' => array ('enable = ?', 0)));
  //   $this->load_view (array ('tags' => $tags));
  // }

}
