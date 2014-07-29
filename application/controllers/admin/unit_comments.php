<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @author      OA Wu <comdan66@gmail.com>
 * @copyright   Copyright (c) 2014 OA Wu Design
 */
class Unit_comments extends Admin_controller {
  private $object_name  = 'UnitComment';
  private $feature_name = '景點留言';

  public function __construct () {
    parent::__construct ();
  }

  public function index ($per_page = 0) {
    $object_name = $this->object_name;
    $sql = array ('order'   => 'id DESC',
                  'include' => array ('user', 'unit'),
                  'limit'   => $this->get_pagination_list_limit (),
                  'offset'  => $per_page);

    $data["unit_id"] = $this->append_search_condition ($sql, 'Number', 'unit_id', trim ($this->input_post ('unit_id')));
    $data["user_id"] = $this->append_search_condition ($sql, 'Number', 'user_id', trim ($this->input_post ('user_id')));
    $data["message"] = $this->append_search_condition ($sql, 'LikeString', 'message', trim ($this->input_post ('message')));
    $data["is_sync"] = $this->append_search_condition ($sql, 'Number', 'is_sync', trim ($this->input_post ('is_sync')));

    $data["objects"] = $object_name::find ('all', $sql);

    unset ($sql['order'], $sql['limit'], $sql['offset'], $sql['include']);
    $data['total_rows'] = $total_rows = $object_name::count ($sql);

    $data['run_time'] = $this->get_run_time ();
    $data['pagination'] = $this->set_pagination_config ('total_rows', $total_rows)->init_pagination ();

    $data['has_append_condition'] = $this->get_has_append_condition ();
    $data['feature_name'] = $this->feature_name;

    $data['search_url'] = base_url (array ('admin', $this->get_class (), $this->get_method ()));
    $data['delete_url'] = base_url (array ('admin', $this->get_class (), 'delete'));
    
    $this->add_hidden ('update_url', 'update_url', base_url (array ('admin', $this->get_class (), 'update')))
         ->load_view ($data);
  }
  public function delete ($id) {
    $object_name = $this->object_name;

    if (verifyNumber ($id) && verifyObject ($object = $object_name::find ('one', array ('select' => 'id', 'conditions' => array ('id = ?', $id))))) {
      if ($this->is_ajax (false)) {
        $object->recycle ();
        $this->output_json (array ('status' => true, 'title' => '成功', 'message' => '刪除成功!', 'action' => 'function(){window.location.assign ("' . base_url (array ('admin', $this->get_class (), 'index')) . '");}'));
      } else { 
        $this->load_view (array ('delete_url' => base_url (array ('admin', $this->get_class (), $this->get_method (), $id))));
      }
    } else { redirect (array ('admin', $this->get_class (), 'index')); }
  }
}
