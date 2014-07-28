<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @author      OA Wu <comdan66@gmail.com>
 * @copyright   Copyright (c) 2014 OA Wu Design
 */
class Unit extends OaModel {

  static $table_name = 'units';

  static $belongs_to = array (
    array ('user', 'class_name' => 'User'),
  );

  static $has_many = array (
    array ('tag_mappings', 'class_name' => 'UnitTagMapping'),
    array ('tags' , 'class_name' => 'UnitTag', 'through' => 'unit_mappings', 'order'=> 'RAND()'),
    array ('comments' , 'class_name' => 'UnitComment'),
    array ('pictures' , 'class_name' => 'UnitPicture'),
    array ('star_details', 'select' => 'COUNT(*) AS count, value', 'class_name' => 'UnitScore', 'order' => 'value DESC', 'group' => 'value'),
  );
  static $has_one = array (
    array ('rand_picture', 'class_name' => 'UnitPicture', 'order' => 'RAND()'),
    array ('view', 'class_name' => 'UnitView', 'conditions' => array ('latitude is not null AND longitude is not null AND heading is not null AND pitch is not null AND latitude != "" AND longitude != "" AND heading != "" AND pitch != ""')),
  );

  public function __construct ($attributes = array (), $guard_attributes = TRUE, $instantiating_via_find = FALSE, $new_record = TRUE) {
    parent::__construct ($attributes, $guard_attributes, $instantiating_via_find, $new_record);
  }

  public function first_picture ($size = '', $use_auto = true) {
    $url = verifyObject ($this->rand_picture) ? $this->rand_picture->picture_url ($size) : '';
    if ($url != '') { return $url; }
    else if ($use_auto) {
      if (($size = substr ($size, 0, -1)) != '') {
        return verifyObject ($this->view) ? $this->view->picture_url ($size) : ("http://maps.googleapis.com/maps/api/staticmap?center=" . $this->latitude . "," . $this->longitude . "&zoom=16&size=" . strtolower ($size) . "&sensor=false");
      } else {
        return config ('d4_config', 'unit', 'picture_url');
      }
    } else { return ''; }
    return $url;
  }
  
  public function score_star ($star_count = 5) {
    $score = $this->score * 20;

    $unit_score = 100 / $star_count;
    $count = floor ($score / $unit_score);
    $detail = ($score / $unit_score) - floor ($score / $unit_score);
    
    if ($detail < 0.25) { $detail = 0; }
    else if ($detail < 0.75) { $detail = 1; }
    else { $detail = 0; $count++; }
    
    $array = array (); for ($i = 0; $i < $star_count; $i++) array_push ($array, $count-- > 0 ? 2 : ($detail-- > 0 ? 1 : 0));
    
    return $array;
  }

  public function star_details () {
    $max = 0;
    $array = array (5, 4, 3, 2, 1);
    $unit_scores = $this->star_details;

    $unit_scores = array_map (function ($unit_score) use (&$max, &$array) { $max = $unit_score->count > $max ? $unit_score->count : $max; if (verifyArray ($array) && (($key = array_search ($unit_score->value, $array))) !== false) unset ($array[$key]); return array ('score' => $unit_score->value, 'count' => $unit_score->count); }, $unit_scores);
    $unit_scores = array_map (function ($unit_score) use ($max) { return array ('score' => $unit_score['score'], 'count' => $unit_score['count'], 'percent' => $unit_score['count'] / $max); }, $unit_scores); 
    $unit_scores = array_merge ($unit_scores, array_map (function ($item) { return array ('score' => $item, 'count' => 0, 'percent' => 0); }, $array));

    usort ($unit_scores, function ($a, $b) { return $a['score'] < $b['score']; });
    return $unit_scores;
  }

  public function user_score ($user_id, $select = 'id') {
    return ($user_id !== 0) && verifyObject ($unit_score = UnitScore::find ('one', array ('select' => $select, 'conditions' => array ('user_id = ? AND unit_id = ?', verifyNumber ($user_id) ? $user_id : (verifyObject ($user_id) ? $user_id->id : 0), $this->id)))) ? $unit_score : null;
  }
  

  // verifying
  // certified
  // delete
  // 
}