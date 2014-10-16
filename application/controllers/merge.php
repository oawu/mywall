<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @author      OA Wu <comdan66@gmail.com>
 * @copyright   Copyright (c) 2014 OA Wu Design
 */
function array_2d_to_1d ($input_array) {
  $output_array = array ();
  for ($i = 0; $i < count ($input_array); $i++)
    for ($j = 0; $j < count ($input_array[$i]); $j++)
      $output_array[] = $input_array[$i][$j];
  return $output_array;
}

function utf8_str_split ($str, $split_len = 1) {
  if (!preg_match ('/^[0-9]+$/', $split_len) || $split_len < 1)
      return FALSE;
  $len = mb_strlen ($str, 'UTF-8');
  if ($len <= $split_len)
      return array ($str);
  preg_match_all ('/.{'.$split_len.'}|[^\x00]{1,'.$split_len.'}$/us', $str, $ar);
  return $ar[0];
}
function like_string ($key, $names) {
  return implode (' OR ', array_map (function ($name) use ($key) {
      return '(' . $key . ' LIKE "%' . $name . '%")';
    }, $names));
}

class Merge extends Site_controller {
  public function __construct () {
    parent::__construct ();
  }
  public function index () {
    $db_id = $this->input_get ('db_id');

    $this->add_hidden (array ('id' => 'get_likes_url', 'value' => base_url (array ($this->get_class (), 'get_likes'))))
         ->add_hidden (array ('id' => 'get_tags_url', 'value' => base_url (array ($this->get_class (), 'get_tags'))))
         ->add_hidden (array ('id' => 'get_cho_url', 'value' => base_url (array ($this->get_class (), 'get_cho'))))
         ->add_hidden (array ('id' => 'sub_cho_url', 'value' => base_url (array ($this->get_class (), 'sub_cho'))))
         ->load_view (array ('db_id' => $db_id));
  
  }
  public function sub_cho () {
    if (!$this->is_ajax ())
      show_error ("It's not Ajax request!<br/>Please confirm your program again.");

    if ((($group_id = $this->input_post ('group_id')) <= 0) || !($group = Group::find ('one', array ('conditions' => array ('id = ?', $group_id)))))
      return $this->output_json (array ('status' => false));
    
    $group->tag->enable = 1;
    $group->tag->save ();
    $group->delete ();
    return $this->output_json (array ('status' => true, 'content1' => $this->set_method ('get_like')->load_content (array ('main' => $group->main, 'tag' => $group->tag), true), 'content2' => $this->set_method ('get_tag')->load_content (array ('tag' => $group->tag), true)));
  }

  public function get_cho () {
    if (!$this->is_ajax ())
      show_error ("It's not Ajax request!<br/>Please confirm your program again.");

    if ((($id = $this->input_post ('id')) <= 0) || (($main_id = $this->input_post ('main_id')) <= 0) || !($tag = Tag::find ('one', array ('conditions' => array ('id = ?', $id)))) || !($main = Tag::find ('one', array ('conditions' => array ('id = ?', $main_id)))))
      return $this->output_json (array ('status' => false));

    $group = Group::create (array ('main_id' => $main->id,'tag_id' => $tag->id));
    $contents = array ();
    array_push ($contents, $this->load_content (array ('group'=> $group), true));
    foreach (Group::find ('all', array ('include' => array ('tag'), 'conditions' => array ('main_id = ?', $tag->id))) as $group) {
      $group->main_id = $main->id;
      $group->save ();
      array_push ($contents, $this->load_content (array ('group'=> $group), true));
    };
    $tag->enable = 0;
    $tag->save ();
    return $this->output_json (array ('status' => true, 'contents' => $contents));
  }
  public function get_likes () {
    if (!$this->is_ajax ())
      show_error ("It's not Ajax request!<br/>Please confirm your program again.");

    if ((($id = $this->input_post ('id')) <= 0) || !($tag = Tag::find ('one', array ('conditions' => array ('id = ?', $id)))))
      return $this->output_json (array ('status' => false));

    preg_match_all("/[\x{4e00}-\x{9fa5}]+/u", $tag->name, $cn_names);
    $cn_names = array_unique (array_2d_to_1d (array_map (function ($cn_name) { return utf8_str_split ($cn_name); }, isset ($cn_names[0]) ? $cn_names[0] : array ())));
    $en_names = array_filter (preg_split ("/[\x{4e00}-\x{9fa5} ]+/u", $tag->name), function ($name) { return strlen ($name) > 1; });
    $names = like_string ('name', array_unique (array_merge ($en_names, $cn_names)));

    $content1s = array ();
    foreach (Tag::find ('all', array ('order' => 'id ASC', 'conditions' => array (($names ? '(' . $names . ') AND ': '') .  'id NOT IN (?) AND enable = ?', array ($tag->id), 1))) as $tag_) {
      array_push ($content1s, $this->set_method ('get_like')->load_content (array ('main' => $tag, 'tag' => $tag_), true));
    }

    $content2s = array ();
    foreach ($tag->groups as $group) {
      array_push ($content2s, $this->set_method ('get_cho')->load_content (array ('group' => $group), true));
    }

    $this->output_json (array ('status' => true, 'content1s' => $content1s, 'content2s' => $content2s));
  }

  public function get_tags () {
    if (!$this->is_ajax ())
      show_error ("It's not Ajax request!<br/>Please confirm your program again.");
    
    if (($next_id = $this->input_post ('next_id')) >= 0) {
      
      $db_id = $this->input_post ('db_id');
      $length = 100;
      $tags = Tag::find ('all', array ('order' => 'id ASC', 'limit' => $length + 1, 'conditions' => $db_id ? array ('db_id = ? AND enable = ?', $db_id, 1) : array ('id >= ? AND enable = ?', $next_id, 1)));
      $tagss = array ();

      foreach (array_slice ($tags, 0, $length) as $tag)
        array_push ($tagss, $this->set_method ('get_tag')->load_content (array ('tag' => $tag), true));
      $next_id = ($tags = ($tags = array_slice ($tags, $length, 1)) ? $tags[0] : null) ? $tags->id : -1;

      $this->output_json (array ('status' => true, 'next_id' => $next_id, 'contents' => $tagss));
    }
    else 
      $this->output_json (array ('status' => false));
  }
  function x  () {
    $g = Group::find ('all', array ('include' => array ('tag'), 'conditions' => array ('main_id = ?', 1)));
    foreach ($g as $key => $value) {
        $value->tag;
    }
  }
}
