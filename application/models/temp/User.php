<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends OaModel {

  static  $table_name = 'users';

  static $has_many = array (
    array ('has_friends',    'class_name' => "Friendship"),
    array ('login_records',  'class_name' => 'UserLogRecord', 'conditions' => array ('kind = ?', 'sign_in'), 'group' => 'DATE(created_at)'),
    array ('logout_records', 'class_name' => 'UserLogRecord', 'conditions' => array ('kind = ?', 'sign_out'), 'group' => 'DATE(created_at)'),
    array ('friends',        'class_name' => "Friend", 'through' => 'has_friends'),
    array ('permissions',    'class_name' => 'Permission', 'through' => 'user_permissions'),
    array ('be_friends',     'class_name' => "User", 'through' => 'has_friends' , 'foreign_key' => 'friend_id'),
  );
  
  static $has_one  = array (
    array ('message_type', 'class_name' => 'UserHabit', 'conditions' => array ('kind = ?', 'message_type')),
    array ('message_limit', 'class_name' => 'UserHabit', 'conditions' => array ('kind = ?', 'message_limit')),
    array ('message_reply_limit', 'class_name' => 'UserHabit', 'conditions' => array ('kind = ?', 'message_reply_limit')),
    array ('auto_load_pixel', 'class_name' => 'UserHabit', 'conditions' => array ('kind = ?', 'auto_load_pixel')),
    array ('message_background', 'class_name' => 'UserHabit', 'conditions' => array ('kind = ?', 'message_background')),
    array ('fetch_notice_count_time', 'class_name' => 'UserHabit', 'conditions' => array ('kind = ?', 'fetch_notice_count_time')),
    array ('fetch_notices_length', 'class_name' => 'UserHabit', 'conditions' => array ('kind = ?', 'fetch_notices_length')),
    array ('facebook', 'class_name' => 'Facebook'),
  );

  static $validates_uniqueness_of = array (
    // array ('email', 'message' => 'Repeat E-mail!'),
    // array ('account', 'message' => 'Repeat Account!'),
  );

  public function __construct ($attributes = array (), $guard_attributes = TRUE, $instantiating_via_find = FALSE, $new_record = TRUE) {
    parent::__construct ($attributes, $guard_attributes, $instantiating_via_find, $new_record);
    
    // ModelUploader::bind ($this, 'picture', 'UserUpload');
  }
  
  public static function blacklist () { return array_map (function ($user_permission) { return $user_permission->user; }, UserPermission::find ('all', array ('order' => 'user_id ASC', 'group' => 'user_id', 'conditions' => array ('permission_id = ?', 3)))); }

  public function not_blacklist_friends () { return array_filter (array_map (function ($friend) { return !$friend->in_blacklist () ? $friend : null; }, $this->friends)); }
  public function not_blacklist_be_friends () { return array_filter (array_map (function ($be_friend) { return !$be_friend->in_blacklist () ? $be_friend : null; }, $this->be_friends)); }
  public function not_blacklist_both_friends () { return same_object_in_objects ('id', $this->not_blacklist_friends (), $this->not_blacklist_be_friends ()); }
  public function in_blacklist () { return in_objects_by_value ('blacklist', $this->permissions, 'role'); }


  public function be_guest_read_messages ($limit = null, $next_id = null, $message_id = 0) {
    $not_blacklist_friends = $this->type->verifyArray ($not_blacklist_friends = $this->not_blacklist_friends ()) && $this->type->verifyArray ($not_blacklist_friends = objects_field_array ($not_blacklist_friends, 'id')) ? $not_blacklist_friends : array ($this->id);
    
    $conditions = array ('order' => 'created_at DESC, id DESC', 'conditions' => 
      array ('((user_id = ? AND message_type_id = 1) 
              OR (to_user_id = ? AND user_id NOT IN (?) AND message_type_id = 1)) AND is_enabled = 1', 
        $this->id, 
        $this->id, $not_blacklist_friends
      ));

    if ($this->type->verifyNumber ($message_id, 1)) {
      $conditions['conditions'][0] .= ' AND id = ?';
      array_push ($conditions['conditions'], $message_id);
    }

    if ($this->type->verifyNumber ($limit, 0)) $conditions['limit'] = $limit;
    if ($this->type->verifyNumber ($next_id, 1)) {
      $conditions['conditions'][0] .= ' AND id <= ?';
      array_push ($conditions['conditions'], $next_id);
    }

    return $messages = Message::find ('all', $conditions);
  }
  public function get_be_guest_read_message ($message_id) { return $this->type->verifyArray ($messages = $this->be_guest_read_messages (1, null, $message_id), 1, 1) ? array_shift ($messages) : null; }
  public function get_be_guest_write_message ($message_id, $reader) { return null; }


  public function be_sign_in_read_messages ($limit = null, $next_id = null, $message_id = 0, $reader) {
    $not_blacklist_friends      = $this->type->verifyArray ($not_blacklist_friends = $this->not_blacklist_friends ()) && $this->type->verifyArray ($not_blacklist_friends = objects_field_array ($not_blacklist_friends, 'id')) ? $not_blacklist_friends : array ($this->id);
    $not_blacklist_both_friends = $this->type->verifyArray ($not_blacklist_both_friends = $this->not_blacklist_both_friends ()) && $this->type->verifyArray ($not_blacklist_both_friends = objects_field_array ($not_blacklist_both_friends, 'id')) ? $not_blacklist_both_friends : array ($this->id);
    $is_his_friend              = in_objects_by_object ($reader, $this->friends, 'id') ? true : false;
    
    $conditions = array ('order' => 'created_at DESC, id DESC', 'conditions' => array ('(
      (user_id = ? AND message_type_id = 1)
       OR (user_id = ? AND to_user_id = ?)
        OR (user_id = ? AND message_type_id = 3 AND ?)
         OR (to_user_id = ? AND user_id NOT IN (?) AND message_type_id = 1)
          OR (to_user_id = ? AND user_id NOT IN (?) AND message_type_id = 3 AND ?)
           OR (user_id = ? AND to_user_id = ?)
           ) AND is_enabled = 1', $this->id, $this->id, $reader->id, $this->id, $is_his_friend, $this->id, $not_blacklist_friends, $this->id, $not_blacklist_both_friends, $is_his_friend, $reader->id, $this->id));

    if ($this->type->verifyNumber ($message_id, 1)) {
      $conditions['conditions'][0] .= ' AND id = ?';
      array_push ($conditions['conditions'], $message_id);
    }

    if ($this->type->verifyNumber ($limit, 0)) $conditions['limit'] = $limit;
    if ($this->type->verifyNumber ($next_id, 1)) {
      $conditions['conditions'][0] .= ' AND id <= ?';
      array_push ($conditions['conditions'], $next_id);
    }

    return $messages = Message::find ('all', $conditions);
  }
  public function get_be_sign_in_read_message ($message_id, $reader) { return $this->type->verifyArray ($messages = $this->be_sign_in_read_messages (1, null, $message_id, $reader), 1, 1) ? array_shift ($messages) : null; }
  public function get_be_sign_in_write_message ($message_id, $reader) { return ($this->type->verifyObject ($message = $this->get_be_sign_in_read_message ($message_id, $reader)) && (($message->user_id == $reader->id) || ($message->to_user_id == $reader->id))) ? $message : null; }


  public function can_read_messages ($limit = null, $next_id = null, $message_id = 0) {
    $not_blacklist_friends      = $this->type->verifyArray ($not_blacklist_friends = $this->not_blacklist_friends ()) && $this->type->verifyArray ($not_blacklist_friends = objects_field_array ($not_blacklist_friends, 'id')) ? $not_blacklist_friends : array ($this->id);
    $not_blacklist_both_friends = $this->type->verifyArray ($not_blacklist_both_friends = $this->not_blacklist_both_friends ()) && $this->type->verifyArray ($not_blacklist_both_friends = objects_field_array ($not_blacklist_both_friends, 'id')) ?  : array ($this->id);
    $blacklist                  = $this->type->verifyArray ($blacklist = User::blacklist ()) && $this->type->verifyArray ($blacklist = objects_field_array ($blacklist, 'id')) ? $blacklist : array (0);

    $conditions = array ('order' => 'created_at DESC, id DESC', 'conditions' => array ('(
      (user_id = ?) 
      OR (user_id IN (?) AND message_type_id = 1) 
      OR (user_id IN (?) AND message_type_id = 3) 
      OR (to_user_id = ? AND user_id NOT IN (?)) 
      OR (to_user_id IN (?) AND message_type_id = 1 AND user_id NOT IN (?)) 
      OR (to_user_id IN (?) AND message_type_id = 3 AND user_id NOT IN (?))) AND is_enabled = 1', 
    $this->id, 
    $not_blacklist_friends, 
    $not_blacklist_both_friends, 
    $this->id, $blacklist, 
    $not_blacklist_friends, $blacklist, 
    $not_blacklist_both_friends, $blacklist));

    if ($this->type->verifyNumber ($message_id, 1)) {
      $conditions['conditions'][0] .= ' AND id = ?';
      array_push ($conditions['conditions'], $message_id);
    }

    if ($this->type->verifyNumber ($limit, 0)) $conditions['limit'] = $limit;
    if ($this->type->verifyNumber ($next_id, 1)) {
      $conditions['conditions'][0] .= ' AND id <= ?';
      array_push ($conditions['conditions'], $next_id);
    }

    return $messages = Message::find ('all', $conditions);
  }
  public function get_can_read_message ($message_id) {return $this->type->verifyArray ($messages = $this->can_read_messages (1, null, $message_id), 1, 1) ? array_shift ($messages) : null; }
  public function get_can_write_message ($message_id) {return ($this->type->verifyObject ($message = $this->get_can_read_message ($message_id)) && (($message->user_id == $this->id) || ($message->to_user_id == $this->id))) ? $message : null;}
}
