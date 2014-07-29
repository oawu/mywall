<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @author      OA Wu <comdan66@gmail.com>
 * @copyright   Copyright (c) 2014 OA Wu Design
 */
class Unit_tags extends Admin_controller {
  private $object_name  = 'UnitTag';
  private $feature_name = '景點標籤';

  public function __construct () {
    parent::__construct ();
  }

  public function index ($per_page = 0) {
    $object_name = $this->object_name;

    $sql = array ('order'   => 'id DESC',
                  'limit'   => $this->get_pagination_list_limit (),
                  'offset'  => $per_page);

    $data["name"] = $this->append_search_condition ($sql, 'LikeString', 'name', trim ($this->input_post ('name')));

    $data["objects"] = $object_name::find ('all', $sql);

    unset ($sql['order'], $sql['limit'], $sql['offset']);
    $data['total_rows'] = $total_rows = $object_name::count ($sql);

    $data['run_time'] = $this->get_run_time ();
    $data['pagination'] = $this->set_pagination_config ('total_rows', $total_rows)->init_pagination ();

    $data['has_append_condition'] = $this->get_has_append_condition ();
    $data['feature_name'] = $this->feature_name;

    $data['create_url'] = base_url (array ('admin', $this->get_class (), 'create'));
    $data['search_url'] = base_url (array ('admin', $this->get_class (), $this->get_method ()));
    $data['delete_url'] = base_url (array ('admin', $this->get_class (), 'delete'));
    
    $this->add_hidden ('update_url', 'update_url', base_url (array ('admin', $this->get_class (), 'update')))
         ->load_view ($data);
  }
  public function create () {
    $object_name = $this->object_name;

    $name = trim ($this->input_post ('name', true));

    if (verifyString ($name)) {
      if (verifyCreateObject ($object = $object_name::create (array ('name' => $name, 'units_count' => 0)))) {
        return $this->message ('成功', '新增成功!', base_url (array ('admin', $this->get_class (), 'index')));
      } else { return $this->message ('失敗', '新增失敗!', base_url (array ('admin', $this->get_class (), 'index'))); }
    } else {
      $data['feature_name'] = $this->feature_name;
      $data['create_url']   = base_url (array ('admin', $this->get_class (), $this->get_method ()));
      $data['back_url']     = base_url (array ('admin', $this->get_class (), 'index'));
      $this->load_view ($data);
    }
  }
  public function message ($title, $message, $redirect) {
    if (verifyString ($title) && verifyString ($message) && verifyString ($redirect)) {
      $this->add_hidden ('title', 'title', $title)
           ->add_hidden ('message', 'message', $message)
           ->add_hidden ('redirect', 'redirect', $redirect)
           ->set_method ('message')
           ->load_view ();
    } else { redirect (array ('admin', $this->get_class (), 'index')); }
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
