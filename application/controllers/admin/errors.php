<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @author      OA Wu <comdan66@gmail.com>
 * @copyright   Copyright (c) 2014 OA Wu Design
 */
class Errors extends Admin_controller {
  private $object_name  = 'Error';
  private $feature_name = '錯誤';

  public function __construct () {
    parent::__construct ();
  }

  public function index ($per_page = 0) {
    $object_name = $this->object_name;

    $sql = array ('order'   => 'id DESC',
                  'limit'   => $this->get_pagination_list_limit (),
                  'offset'  => $per_page);

    $data["object_id"] = $this->append_search_condition ($sql, 'Number', 'object_id', trim ($this->input_post ('object_id')));
    $data["object_name"] = $this->append_search_condition ($sql, 'LikeString', 'object_name', trim ($this->input_post ('object_name')));
    $data["message"] = $this->append_search_condition ($sql, 'LikeString', 'message', trim ($this->input_post ('message')));

    $data["objects"] = $object_name::find ('all', $sql);

    unset ($sql['order'], $sql['limit'], $sql['offset']);
    $data['total_rows'] = $total_rows = $object_name::count ($sql);

    $data['run_time'] = $this->get_run_time ();
    $data['pagination'] = $this->set_pagination_config ('total_rows', $total_rows)->init_pagination ();

    $data['has_append_condition'] = $this->get_has_append_condition ();
    $data['feature_name'] = $this->feature_name;

    $data['search_url'] = base_url (array ('admin', $this->get_class (), $this->get_method ()));
    
    $this->add_hidden ('update_url', 'update_url', base_url (array ('admin', $this->get_class (), 'update')))
         ->load_view ($data);
  }
  public function update () {
    if (!$this->is_ajax ()) return $this->output_json (array ('status' => false, 'message' => '設定失敗!'));

    $object_name = $this->object_name;
    $object_id   = trim ($this->input_post ("object_id", true));
    $is_read     = trim ($this->input_post ("is_read", true));

    if (verifyNumber ($object_id) && verifyNumber ($is_read) && verifyObject ($object = $object_name::find ('one', array ('select' => 'id, is_read, updated_at', 'conditions' => array ('id = ?', $object_id))))) {
      $object->is_read = $is_read;
      $object->save ();
      return $this->output_json (array ('status' => true, 'message' => '修改成功!'));
    } else { return $this->output_json (array ('status' => false, 'message' => 'post 參數錯誤!')); }
  }
}
