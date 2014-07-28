<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Message extends OaModel {

  static  $table_name = 'messages';

  static $belongs_to = array (
    array ('owner', 'class_name' => 'User'),
    array ('type', 'class_name' => 'MessageType')
  );
  
  static $has_many = array (
    array ('replies', 'class_name' => 'MessageReply', 'conditions' => array ('is_enabled = ?', '1'), 'order' => 'created_at ASC'),
    array ('likes', 'class_name' => 'MessageLike', 'conditions' => array ('is_enabled = ?', '1')),
    array ('feels', 'class_name' => 'MessageFeel', 'conditions' => array ('is_enabled = ?', '1')),
    array ('reply_auto_loads', 'class_name' => 'MessageReplyAutoLoad', 'conditions' => array ('is_enabled = ?', '1'))
  );
  
  static $has_one = array (
    array ('link', 'class_name' => 'MessageLink'),
    array ('picture', 'class_name' => 'MessagePicture', 'conditions' => array ('is_enabled = ?', '1')),
  );

  public function __construct ($attributes = array (), $guard_attributes = TRUE, $instantiating_via_find = FALSE, $new_record = TRUE) {
    parent::__construct ($attributes, $guard_attributes, $instantiating_via_find, $new_record);
  }

  public function all_reply_count () { return $reply_all_count = MessageReply::count (array ('conditions' => array ('is_enabled = ? AND message_id = ?', '1', $this->id))); }
  public function all_not_blacklist_reply_count () { return $reply_all_count = MessageReply::count (array ('conditions' => array ('is_enabled = ? AND message_id = ? AND user_id NOT IN (?)', '1', $this->id, $this->type->verifyArray ($blacklist = User::blacklist ()) && $this->type->verifyArray ($blacklist = objects_field_array ($blacklist, 'id')) ? $blacklist : array (0)))); }
  public function all_not_blacklist_except_reader_reply_count ($reader) { return $reply_all_count = MessageReply::count (array ('conditions' => array ('is_enabled = ? AND message_id = ? AND (user_id NOT IN (?) OR user_id = ?)', '1', $this->id, $this->type->verifyArray ($blacklist = User::blacklist ()) && $this->type->verifyArray ($blacklist = objects_field_array ($blacklist, 'id')) ? $blacklist : array (0), $reader->id))); }
  
  public function get_feels_count ($feel_id) { return MessageFeel::count (array ('conditions' => array ('message_id = ? AND feel_id = ?', $this->id, $feel_id))); }

  public function get_first_feel_columns ($key) {
    $first_feel_columns = array ();
    if (count ($message_feels = MessageFeel::find ('all', array ('select' => 'count(id) AS votes, ' . $key, 'group' => 'feel_id', 'order' => 'votes DESC', 'conditions' => array ('message_id = ? AND is_enabled = 1', $this->id))))) foreach ($message_feels as $i => $message_feel) if (($i == 0) || ($message_feels[$i-1]->votes == $message_feel->votes)) array_push ($first_feel_columns, $message_feel->$key);
    return $first_feel_columns;
  }

  public function is_first_feel ($feel_id) {
    $feel_ids = $this->get_first_feel_columns ('feel_id');
    return $this->type->verifyItemInArray ($feel_id, $feel_ids);
  }
}
