<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @author      OA Wu <comdan66@gmail.com>
 * @copyright   Copyright (c) 2014 OA Wu Design
 */
class Units extends Delay_controller {
  public function __construct () {
    parent::__construct ();
  }

  public function set_score () {
    $user_id = $this->input_post ('user_id');
    $unit_id = $this->input_post ('unit_id');
    $score   = $this->input_post ('score');

    if (verifyNumber ($score, 1, 5) && verifyObject ($user = User::find ('one', array ('conditions' => array ('id = ?', $user_id)))) && verifyObject ($unit = Unit::find ('one', array ('conditions' => array ('id = ?', $unit_id))))) {
      if (verifyCreateObject ($unit_score = UnitScore::create (array ('unit_id' => $unit->id, 'user_id' => $user->id, 'value' => $score)))) {
        if (verifyObject ($unit_score = UnitScore::find ('one', array ('select' => 'SUM(value) AS sum, COUNT(id) as count', 'conditions' => array ('unit_id = ?', $unit->id))))) {
          $unit->score = round ($unit_score->sum / $unit_score->count, 2);
          $unit->save ();
        }
      }
    }
  }

  public function update_unit_comments_count () {
    $unit_id = $this->input_post ('unit_id');
    if (verifyObject ($unit = Unit::find ('one', array ('select' => 'id, comments_count, updated_at', 'conditions' => array ('id = ?', $unit_id)))) && verifyObject ($unit_comment = UnitComment::find ('one', array ('select' => 'COUNT(id) AS count', 'conditions' => array ('unit_id = ?', $unit_id))))) {
      $unit->comments_count = $unit_comment->count;
      $unit->save ();
      clean_cell ('unit_cells', 'comments', 'unit_id_' . $unit->id . '/ ');
    }
  }

  public function add_pageview () {
    $unit_id = $this->input_post ('unit_id');

    if (verifyObject ($unit = Unit::find ('one', array ('conditions' => array ('id = ?', $unit_id))))) {
      Pageview::add_count ($unit, 'pageview', 1);
    }
  }

  public function create () {
    $user_id          = $this->input_post ('user_id');
    $latitude         = $this->input_post ('latitude');
    $longitude        = $this->input_post ('longitude');
    $name             = $this->input_post ('name');
    $introduction     = $this->input_post ('introduction');
    $open_time        = $this->input_post ('open_time');
    $address          = $this->input_post ('address');
    $temp_picture_ids = $this->input_post ('temp_picture_ids');
    $tags             = $this->input_post ('tags');

    $sql = array ('user_id' => $user_id, 'name' => $name, 'introduction' => $introduction, 'open_time' => $open_time, 'address' => $address, 'status' => 'verifying', 'latitude' => $latitude, 'longitude' => $longitude, 'score' => '0', 'pageview' => '0');
    if (verifyCreateObject ($unit = Unit::create ($sql))) {
      if (verifyArray ($temp_picture_ids)) {
        foreach ($temp_picture_ids as $temp_picture_id) {
          if (verifyNumber ($temp_picture_id, 1) && verifyObject ($temp_picture = TempPicture::find ('one', array ('conditions' => array ('id = ?', $temp_picture_id)))) && verifyCreateObject ($unit_picture = UnitPicture::create (array ('unit_id' => $unit->id, 'file_name' => ''))) && $unit_picture->file_name->put_url ($temp_picture->file_name->url ())) {
              $temp_picture->for_object = 'unit_picture_' . $unit_picture->id;
              $temp_picture->save ();
              $temp_picture->recycle ();
          } else if (verifyObject ($unit_picture)) {
            $unit_picture->recycle ();
          }
        }
      }

      array_map (function ($tag) use ($unit) { if (verifyObject ($unit_tag = UnitTag::find ('one', array ('conditions' => array ('id = ?', $tag))))) UnitTagMapping::create (array ('unit_id' => $unit->id, 'unit_tag_id' => $unit_tag->id)); }, $tags);

      $unit->save ();
    }
  }
}
