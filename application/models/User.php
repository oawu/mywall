<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @author      OA Wu <comdan66@gmail.com>
 * @copyright   Copyright (c) 2014 OA Wu Design
 */
class User extends OaModel {

  static $table_name = 'users';
  static $before_save = array ('strip_tags');

  static $has_many = array (
    array ('banner_pictures', 'class_name' => 'Picture', 'limit' => 7, 'order' => 'year_week DESC, pageview DESC'),
    array ('be_follows', 'class_name' => 'Follow', 'select' => 'be_user_id', 'order' => 'id DESC'),
    array ('follows', 'class_name' => 'Follow', 'select' => 'user_id', 'order' => 'id DESC', 'foreign_key' => 'be_user_id'),
  );
  static $has_one = array (
    array ('rand_picture', 'class_name' => 'Picture', 'order' => 'RAND()'),
  );

  private $be_follow_users = null;
  private $follow_me_users = null;
  
  public function __construct ($attributes = array (), $guard_attributes = TRUE, $instantiating_via_find = FALSE, $new_record = TRUE) {
    parent::__construct ($attributes, $guard_attributes, $instantiating_via_find, $new_record);
    OrmImageUploader::bind ('avatar');
    OrmImageUploader::bind ('banner', 'UserUploaderBanner');
  }

  // 我 follow 的使用者
  public function be_follow_users ($sql = array (), $new_record = false) {
    if ($this->be_follow_users !== null && !$new_record)
      return $this->be_follow_users;
    return $this->be_follow_users = (!$be_user_ids = field_array ($this->be_follows, 'be_user_id')) ? array () : self::find ('all', array_merge ($sql, array ('conditions' => array ('id IN (?)', $be_user_ids))));
  }

  // follow 我 的使用者
  public function follow_me_users ($sql = array (), $new_record = false) {
    if ($this->follow_me_users !== null && !$new_record)
      return $this->follow_me_users;
    return $this->follow_me_users = (!$user_ids = field_array ($this->follows, 'user_id')) ? array () : self::find ('all', array_merge ($sql, array ('conditions' => array ('id IN (?)', $user_ids))));
  }

  // 個人頭像 method
  public function avatar_url ($width = null, $height = null) {
    return $this->register_from == 'facebook' ? 'https://graph.facebook.com/' . $this->uid . '/picture?width=' . ($width ? $width : 50) . '&height=' . ($height ? $height : 50) : (($url = $this->avatar->url ($width . 'x' . $height)) ? $url : $this->avatar->url ());
  }

  // 儲存前清除 html tag
  public function strip_tags () {
    isset ($this->email) ? $this->email = $this->email ? strip_tags ($this->email) : '' : '';
    isset ($this->name) ? $this->name = $this->name ? strip_tags ($this->name) : '' : '';
  }

  public function score_set () {
    $add_quota = abs (sqrt (100 - ($this->score < 100 ? $this->score > 0 ? $this->score : 0 : 100)));
    $sub_quota = abs (sqrt ($this->score < 100 ? $this->score > 0 ? $this->score : 0 : 100));

    if ((floor ((strtotime (date ('Y-m-d H:i:s')) - strtotime ($this->sign_in_at)) / 86400)) > config ('db_table_config', 'users', 'set_score', 'sign_in_range')) {
      $this->score = ($this->score = $this->score - ($sub_quota / 3)) < 100 ? $this->score > 0 ? $this->score : 0 : 100;
      $this->save ();
      return $this;
    }
    $start = date ('Y-m-d', strtotime ('-1 day'));
    $end   = date ('Y-m-d', strtotime ('+1 day'));

    if ($pic_count = Picture::count (array ('conditions' => array ('user_id = ? AND created_at BETWEEN ? AND ?', $this->id, $start, $end)))) {
      $this->score = ($this->score = $this->score + (($add_quota / 10) * ($pic_count > 5 ? 5 : $pic_count))) < 100 ? $this->score > 0 ? $this->score : 0 : 100;
    } else {
      $this->score = ($this->score = $this->score - ($sub_quota / 8)) < 100 ? $this->score > 0 ? $this->score : 0 : 100;
    }

    if ($comment_count = PictureComment::count (array ('conditions' => array ('user_id = ? AND created_at BETWEEN ? AND ?', $this->id, $start, $end)))) {
      $this->score = ($this->score = $this->score + (($add_quota / 10) * ($comment_count > 5 ? 5 : $comment_count))) < 100 ? $this->score > 0 ? $this->score : 0 : 100;
    } else {
      $this->score = ($this->score = $this->score - ($sub_quota / 20)) < 100 ? $this->score > 0 ? $this->score : 0 : 100;
    }

    if ($score_count = PictureScore::count (array ('conditions' => array ('user_id = ? AND created_at BETWEEN ? AND ?', $this->id, $start, $end)))) {
      $this->score = ($this->score = $this->score + (($add_quota / 7) * ($score_count > 5 ? 5 : $score_count))) < 100 ? $this->score > 0 ? $this->score : 0 : 100;
    }

    if ($follow_count = Follow::count (array ('conditions' => array ('user_id = ? AND created_at BETWEEN ? AND ?', $this->id, $start, $end)))) {
      $this->score = ($this->score = $this->score + (($add_quota / 10) * ($follow_count > 5 ? 5 : $score_count))) < 100 ? $this->score > 0 ? $this->score : 0 : 100;
    }

    $this->score = $this->score < 100 ? $this->score > 0 ? $this->score : 0 : 100;
    $this->save ();

    return $this;
  }
}