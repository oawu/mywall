<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @author      OA Wu <comdan66@gmail.com>
 * @copyright   Copyright (c) 2014 OA Wu Design
 */
class Albums extends Admin_controller {
  private $feature_name_1 = null;
  private $object_name_1  = null;

  private $feature_name_2 = null;
  private $object_name_2  = null;

  public function __construct () {
    parent::__construct ();

    $this->feature_name_1 = '相簿';
    $this->object_name_1  = 'Album';

    $this->feature_name_2 = '照片';
    $this->object_name_2  = 'AlbumPicture';
  }

  public function index ($submenu_num = 0) {
    $object_name = $this->object_name_1;

    $this->set_per_page ($submenu_num);
    
    $sql = array ('order'  => 'sort DESC, id DESC',
                  'limit'  => $this->get_list_limit (),
                  'offset' => ($this->get_per_page () / $this->get_list_limit ()) * $this->get_list_limit ());

    $data["id"]          = $this->append_search_condition ($sql, 'Number', 'id', trim ($this->input_post ('id')));
    $data["title"]       = $this->append_search_condition ($sql, 'String', 'title', trim ($this->input_post ('title')));
    $data["description"] = $this->append_search_condition ($sql, 'String', 'description', trim ($this->input_post ('description')));

    $data["objects"] = $object_name::find ('all', $sql);

    unset ($sql['order'], $sql['limit'], $sql['offset']);
    $data['total_rows'] = $total_rows = $object_name::count ($sql);

    $data['run_time'] = $this->get_run_time ();
    $data['pagination'] = $this->set_pagination_config ('total_rows', $total_rows)->init_pagination ();
    
    $data['search_url'] = base_url (array ('admin', $this->get_class (), $this->get_method ()));
    $data['create_url'] = base_url (array ('admin', $this->get_class (), 'create'));
    $data['detail_url'] = base_url (array ('admin', $this->get_class (), 'detail'));
    $data['delete_url'] = base_url (array ('admin', $this->get_class (), 'delete'));
    $data['update_url'] = base_url (array ('admin', $this->get_class (), 'update'));

    $data['create_picture_url'] = base_url (array ('admin', $this->get_class (), 'create_picture'));

    $data['has_append_condition'] = $this->get_has_append_condition ();
    $data['feature_name_1'] = $this->feature_name_1;
    $data['feature_name_2'] = $this->feature_name_2;

    $this->add_hidden ('sort_url', 'sort_url', base_url (array ('admin', $this->get_class (), 'sort')))
         ->load_view ($data);
  }

  public function create () {
    $object_name = $this->object_name_1;

    $title = trim ($this->input_post ("title", true));
    $description = trim ($this->input_post ("description", true));

    if (verifyString ($title) && verifyString ($description)) {

      $sql = array (
        'title'       => $title,
        'description' => $description,
        'sort'        => (verifyObject ($last_object = $object_name::find ('one', array ('order' => 'sort DESC', 'conditions' => array ()))) ? $last_object->sort : 0) + 1
      );
      if (verifyCreateObject ($object = $object_name::create ($sql))) {

        // delay_request ('delay_jobs', 'delete_cache_about');

        $this->message ('成功', '新增成功!', base_url (array ('admin', $this->get_class (), 'index')));
      } else {
        $this->message ('失敗', '新增失敗!', base_url (array ('admin', $this->get_class (), 'index')));
      }
    } else {
      $data['feature_name_1'] = $this->feature_name_1;
      $data['create_url']   = base_url (array ('admin', $this->get_class (), $this->get_method ()));
      $data['back_url']     = base_url (array ('admin', $this->get_class (), 'index'));
      
      $this->load_view ($data);
    }
  }
  public function update ($id) {
    $object_name = $this->object_name_1;

    if (verifyNumber ($id) && verifyObject ($object = $object_name::find ('one', array ('conditions' => array ('id = ?', $id))))) {
      $title       = trim ($this->input_post ("title", true));
      $description = trim ($this->input_post ("description", true));

      if (verifyString ($title) && verifyString ($description)) {
        $object->title = $title;
        $object->description = $description;
        $object->save ();

        // delay_request ('delay_jobs', 'delete_cache_about');
    
        $this->message ('成功', '修改成功!', base_url (array ('admin', $this->get_class (), 'index')));
      } else { 
        $data['object'] = $object;
        $data['update_url'] = base_url (array ('admin', $this->get_class (), $this->get_method (), $id));
        $data['feature_name_1'] = $this->feature_name_1;
        $data['back_url'] = base_url (array ('admin', $this->get_class (), 'index'));
        $this->load_view ($data);
      }
    } else { redirect (array ('admin', $this->get_class (), 'index')); }
  }

  public function delete ($id) {
    $object_name = $this->object_name_1;

    if (verifyNumber ($id) && verifyObject ($object = $object_name::find ('one', array ('conditions' => array ('id = ?', $id))))) {
      if ($this->is_ajax (false)) {
        $object->delete ();
        $this->output_json (array ('status' => true, 'title' => '成功', 'message' => '刪除成功!', 'action' => 'function(){window.location.assign ("' . base_url (array ('admin', $this->get_class (), 'index')) . '");}'));
      } else { 
        $this->load_view (array ('delete_url' => base_url (array ('admin', $this->get_class (), $this->get_method (), $id))));
      }
    } else { redirect (array ('admin', $this->get_class (), 'index')); }
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
  public function sort () {
    $object_name = $this->object_name_1;

    if ($this->is_ajax (false)) {
      $sorts = $this->input_post ('sorts');
      if (verifyArray ($sorts)) {
        array_map (function ($sort) use ($object_name) { if (verifyArray ($data = explode ('_', $sort), 2, 2) && verifyObject ($object = $object_name::find ('one', array ('conditions' => array ('id = ?', $data[0]))))) { $object->sort = $data[1]; $object->save (); }}, $sorts);
        $this->output_json (array ('status' => true));
      } else { redirect (array ('error', 'params_error')); }
    } else { redirect (array ('error', 'not_ajax')); }
  }

  public function detail ($id, $submenu_num = 0) {
    $object_name = $this->object_name_1;

    if (verifyNumber ($id) && verifyObject ($object = $object_name::find ('one', array ('conditions' => array ('id = ?', $id))))) {
      $object_name = $this->object_name_2;
      $this->set_per_page ($submenu_num);

      $sql = array ('order'  => 'sort ASC, id ASC',
                    'limit'  => $this->get_list_limit (),
                    'offset' => $this->get_per_page (),
                    'conditions' => array ('album_id = ?', $object->id));

      $data["id"]          = $this->append_search_condition ($sql, 'Number', 'id', trim ($this->input_post ('id')));
      $data["title"]       = $this->append_search_condition ($sql, 'String', 'title', trim ($this->input_post ('title')));
      $data["src"]         = $this->append_search_condition ($sql, 'String', 'src', trim ($this->input_post ('src')));
      $data["description"] = $this->append_search_condition ($sql, 'String', 'description', trim ($this->input_post ('description')));
      
      $data["objects"] = $object_name::find ('all', $sql);
      
      unset ($sql['order'], $sql['limit'], $sql['offset']);
      $data['total_rows'] = $total_rows = $object_name::count ($sql);

      $data['run_time'] = $this->get_run_time ();

      $this->set_pagination_config ('base_url', base_url (array ('admin', $this->get_class (), $this->get_method (), $object->id)))
           ->set_pagination_config ('uri_segment', 5);
      $data['pagination'] = $this->set_pagination_config ('total_rows', $total_rows)->init_pagination ();
      $data['has_append_condition'] = $this->get_has_append_condition ();

      $data['object'] = $object;

      $data['search_url'] = base_url (array ('admin', $this->get_class (), $this->get_method (), $object->id));
      $data['update_url'] = base_url (array ('admin', $this->get_class (), 'update', $object->id));
      $data['back_url']   = base_url (array ('admin', $this->get_class (), 'index'));
      
      $data['create_picture_url'] = base_url (array ('admin', $this->get_class (), 'create_picture', $object->id));
      $data['update_picture_url'] = base_url (array ('admin', $this->get_class (), 'update_picture'));
      $data['delete_picture_url'] = base_url (array ('admin', $this->get_class (), 'delete_picture'));
      
      $data['feature_name_1'] = $this->feature_name_1;
      $data['feature_name_2'] = $this->feature_name_2;
      $this->add_hidden ('sort_url', 'sort_url', base_url (array ('admin', $this->get_class (), 'sort_picture')))
           ->load_view ($data);
    } else { redirect (array ('admin', $this->get_class (), 'index')); }
  }
  public function create_picture ($id) {
    $object_name = $this->object_name_1;

    if (verifyNumber ($id) && verifyObject ($object = $object_name::find ('one', array ('conditions' => array ('id = ?', $id))))) {
      $object_name = $this->object_name_2;

      $title       = trim ($this->input_post ("title", true));
      $description = trim ($this->input_post ("description", true));
      $src         = trim ($this->input_post ("src", true));
      $picture     = $this->input_post ('picture', true, true);

      if (verifyUploadFormat ($picture) && verifyString ($title) && verifyString ($description) && verifyString ($src)) {
        $sql = array (
          'title'       => $title,
          'description' => $description,
          'album_id'    => $object->id,
          'file_name'   => '',
          'src'         => $src,
          'is_enabled'  => 0,
          'sort'        => (verifyObject ($last_object = $object_name::find ('one', array ('order' => 'sort DESC', 'conditions' => array ('album_id = ?', $object->id)))) ? $last_object->sort : 0) + 1
        );
        if (verifyCreateObject ($object = $object_name::create ($sql)) && $object->file_name->put ($picture)) {
          $object->is_enabled = 1;
          $object->save ();
          $this->message ('成功', '新增成功!', base_url (array ('admin', $this->get_class (), 'detail', $id)));
        } else {
          $this->message ('失敗', '新增失敗!', base_url (array ('admin', $this->get_class (), 'detail', $id)));
        }
      } else {
        $data['feature_name_1'] = $this->feature_name_1;
        $data['feature_name_2'] = $this->feature_name_2;

        $data['create_url']   = base_url (array ('admin', $this->get_class (), $this->get_method (), $object->id));
        $data['back_url']     = base_url (array ('admin', $this->get_class (), 'detail', $object->id));
        
        $this->load_view ($data);
      }
    } else { redirect (array ('admin', $this->get_class (), 'index')); }
  }
  public function update_picture ($id) {
    $object_name = $this->object_name_2;

    if (verifyNumber ($id) && verifyObject ($object = $object_name::find ('one', array ('conditions' => array ('id = ?', $id))))) {
      
      $title        = trim ($this->input_post ("title", true));
      $description  = trim ($this->input_post ("description", true));
      $src          = trim ($this->input_post ("src", true));
      $picture      = $this->input_post ('picture', true, true);

      if (verifyUpdateUpload ($picture, $object->file_name) && verifyString ($title) && verifyString ($description) && verifyString ($src)) {
     
        $object->title = $title;
        $object->description = $description;
        $object->src = $src;
        $object->save ();
        
        if (verifyUploadFormat ($picture)) $object->file_name->put ($picture);
        $this->message ('成功', '修改成功!', base_url (array ('admin', $this->get_class (), 'detail', $object->album_id)));
      } else { 
        $data['object'] = $object;
        $data['update_url'] = base_url (array ('admin', $this->get_class (), $this->get_method (), $object->id));
        $data['back_url'] = base_url (array ('admin', $this->get_class (), 'detail', $object->album_id));
        
        $data['feature_name_1'] = $this->feature_name_1;
        $data['feature_name_2'] = $this->feature_name_2;
        $this->load_view ($data);
      }
    } else { redirect (array ('admin', $this->get_class (), 'index')); }
  }
  public function delete_picture ($id) {
    $object_name = $this->object_name_2;

    if (verifyNumber ($id) && verifyObject ($object = $object_name::find ('one', array ('conditions' => array ('id = ?', $id))))) {
      if ($this->is_ajax (false)) {
        $object->delete ();
        $this->output_json (array ('status' => true, 'title' => '成功', 'message' => '刪除成功!', 'action' => 'function(){window.location.assign ("' . base_url (array ('admin', $this->get_class (), 'detail', $object->album_id)) . '");}'));
      } else { 
        $this->load_view (array ('delete_url' => base_url (array ('admin', $this->get_class (), $this->get_method (), $object->id))));
      }
    } else { redirect (array ('admin', $this->get_class (), 'index')); }
  }
  public function sort_picture () {
    $object_name = $this->object_name_2;

    if ($this->is_ajax ()) {
      $sorts = $this->input_post ('sorts');
      if (verifyArray ($sorts)) {
        array_map (function ($sort) use ($object_name) { if (verifyArray ($data = explode ('_', $sort), 2, 2) && verifyObject ($object = $object_name::find ('one', array ('conditions' => array ('id = ?', $data[0]))))) { $object->sort = $data[1]; $object->save (); }}, $sorts);
        // delay_request ('delay_jobs', 'delete_cache_about');
        $this->output_json (array ('status' => true));
      } else { redirect (array ('error', 'params_error')); }
    } else { redirect (array ('error', 'not_ajax')); }
  }
}
