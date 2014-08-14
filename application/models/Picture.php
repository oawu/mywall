<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @author      OA Wu <comdan66@gmail.com>
 * @copyright   Copyright (c) 2014 OA Wu Design
 */
class Picture extends OaModel {

  static $table_name = 'pictures';

  static $belongs_to = array (
    array ('user', 'class_name' => 'User'),
  );
  
  static $has_many = array (
    array ('tag_mappings', 'class_name' => 'PictureTagMapping'),
    array ('tags', 'class_name' => 'PictureTag', 'through' => 'picture_mappings', 'order'=> 'RAND()'),
    array ('star_details', 'select' => 'COUNT(*) AS count, value', 'class_name' => 'PictureScore', 'order' => 'value DESC', 'group' => 'value'),
  );
  
  static $before_create = array ('add_year_week');

  public function __construct ($attributes = array (), $guard_attributes = TRUE, $instantiating_via_find = FALSE, $new_record = TRUE) {
    parent::__construct ($attributes, $guard_attributes, $instantiating_via_find, $new_record);

    OrmImageUploader::bind ('file_name');
  }

  public function add_year_week () {
    return !$this->year_week ? $this->year_week = date ('YW') : $this->year_week;
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

    $unit_scores = array_map (function ($unit_score) use (&$max, &$array) { $max = $unit_score->count > $max ? $unit_score->count : $max; if ($array && (($key = array_search ($unit_score->value, $array))) !== false) unset ($array[$key]); return array ('score' => $unit_score->value, 'count' => $unit_score->count); }, $unit_scores);
    $unit_scores = array_map (function ($unit_score) use ($max) { return array ('score' => $unit_score['score'], 'count' => $unit_score['count'], 'percent' => $unit_score['count'] / $max); }, $unit_scores); 
    $unit_scores = array_merge ($unit_scores, array_map (function ($item) { return array ('score' => $item, 'count' => 0, 'percent' => 0); }, $array));

    usort ($unit_scores, function ($a, $b) { return $a['score'] < $b['score']; });
    return $unit_scores;
  }
  public function user_score ($user_id, $select = 'id') {
    return $user_id && ($unit_score = PictureScore::find ('one', array ('select' => $select, 'conditions' => array ('user_id = ? AND picture_id = ?', $user_id, $this->id)))) ? $unit_score : null;
  }
}