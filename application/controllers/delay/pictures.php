<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @author      OA Wu <comdan66@gmail.com>
 * @copyright   Copyright (c) 2014 OA Wu Design
 */
class Pictures extends Delay_controller {
  public function __construct () {
    parent::__construct ();
  }

  public function set_score () {
    $picture_id = $this->input_post ('picture_id');
    $user_id = $this->input_post ('user_id');
    $score   = $this->input_post ('score');

    if (($score > 0) && ($score < 6) && ($user = User::find ('one', array ('conditions' => array ('id = ?', $user_id)))) && ($picture = Picture::find ('one', array ('select' => 'id, score, updated_at', 'conditions' => array ('id = ?', $picture_id))))) {
      if ($picture_score = PictureScore::create (array ('picture_id' => $picture->id, 'user_id' => $user->id, 'value' => $score))) {
        if ($picture_score = PictureScore::find ('one', array ('select' => 'SUM(value) AS sum, COUNT(id) as count', 'conditions' => array ('picture_id = ?', $picture->id)))) {
          $picture->score = round ($picture_score->sum / $picture_score->count, 2);
          $picture->save ();
          clear_cell ('pictures_cells', 'score_star', $picture->id);
          clear_cell ('pictures_cells', 'star_details', $picture->id);
        }
      }
    }
  }
}
