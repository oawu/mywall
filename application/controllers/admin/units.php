<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @author      OA Wu <comdan66@gmail.com>
 * @copyright   Copyright (c) 2014 OA Wu Design
 */
class Units extends Admin_controller {
  private $object_name  = 'Unit';
  private $object_name_2  = 'UnitComment';
  private $feature_name = '景點';
  private $feature_name_2 = '留言';

  public function __construct () {
    parent::__construct ();
  }

  public function index ($per_page = 0) {
    $object_name = $this->object_name;

    $data['status_list'] = config ('unit_config', 'status');

    $sql = array ('order'   => 'id DESC',
                  'include' => array ('user', 'pictures', 'view'),
                  'limit'   => $this->get_pagination_list_limit (),
                  'offset'  => $per_page);

    $data["name"] = $this->append_search_condition ($sql, 'LikeString', 'name', trim ($this->input_post ('name')));
    $data["introduction"] = $this->append_search_condition ($sql, 'LikeString', 'introduction', trim ($this->input_post ('introduction')));
    $data["address"] = $this->append_search_condition ($sql, 'LikeString', 'address', trim ($this->input_post ('address')));
    $data["status"] = $this->append_search_condition ($sql, 'LikeString', 'status', trim ($this->input_post ('status')));

    $data["objects"] = $object_name::find ('all', $sql);

    unset ($sql['order'], $sql['limit'], $sql['offset'], $sql['include']);
    $data['total_rows'] = $total_rows = $object_name::count ($sql);

    $data['run_time'] = $this->get_run_time ();
    $data['pagination'] = $this->set_pagination_config ('total_rows', $total_rows)->init_pagination ();

    $data['has_append_condition'] = $this->get_has_append_condition ();
    $data['feature_name'] = $this->feature_name;

    $data['update_url'] = base_url (array ('admin', $this->get_class (), 'update'));
    $data['create_view_url'] = base_url (array ('admin', $this->get_class (), 'create_view'));
    $data['delete_url'] = base_url (array ('admin', $this->get_class (), 'delete'));
    $data['comments_url'] = base_url (array ('admin', $this->get_class (), 'comments'));
    $data['search_url'] = base_url (array ('admin', $this->get_class (), $this->get_method ()));
    
    $this->add_hidden ('delete_view_url', 'delete_view_url', base_url (array ('admin', $this->get_class (), 'delete_view')))
         ->add_hidden ('update_status_url', 'update_status_url', base_url (array ('admin', $this->get_class (), 'update_status')))
         ->load_view ($data);
  }

  public function comments ($object_id, $per_page = 0) {
    $object_name = $this->object_name;
    $object_name_2 = $this->object_name_2;

    if (verifyNumber ($object_id) && verifyObject ($object = $object_name::find ('one', array ('conditions' => array ('id = ?', $object_id))))) {
      $sql = array ('order'   => 'id DESC',
                    'include' => array ('user'),
                    'limit'   => $this->get_pagination_list_limit (),
                    'offset'  => $per_page);

      $data["user_id"] = $this->append_search_condition ($sql, 'Number', 'user_id', trim ($this->input_post ('user_id')));
      $data["message"] = $this->append_search_condition ($sql, 'LikeString', 'message', trim ($this->input_post ('message')));
      $data["is_sync"] = $this->append_search_condition ($sql, 'Number', 'is_sync', trim ($this->input_post ('is_sync')));
      $this->append_search_condition ($sql, 'Number', 'unit_id', $object->id, false);

      $data["objects"] = $object_name_2::find ('all', $sql);

      unset ($sql['order'], $sql['limit'], $sql['offset'], $sql['include']);
      $data['total_rows'] = $total_rows = $object_name_2::count ($sql);

      $data['run_time'] = $this->get_run_time ();
      $data['pagination'] = $this->set_pagination_config ('base_url', base_url (array ('admin', $this->get_class (), $this->get_method (), $object->id)))
                                 ->set_pagination_config ('uri_segment', 5)
                                 ->set_pagination_config ('total_rows', $total_rows)->init_pagination ();

      $data['has_append_condition'] = $this->get_has_append_condition ();
      $data['feature_name'] = $this->feature_name;
      $data['feature_name_2'] = $this->feature_name_2;

      $data['delete_url'] = base_url (array ('admin', $this->get_class (), 'delete_comment', $object->id));
      $data['search_url'] = base_url (array ('admin', $this->get_class (), $this->get_method (), $object->id));
      $data['back_url'] = base_url (array ('admin', $this->get_class (), 'index'));
      
      $this->load_view ($data);
    } else { redirect (array ('admin', $this->get_class (), 'index')); }
  }
  public function delete_comment ($object_id, $id) {
    $object_name_2 = $this->object_name_2;

    if (verifyNumber ($object_id) && verifyNumber ($id) && verifyObject ($object = $object_name_2::find ('one', array ('select' => 'id, unit_id', 'conditions' => array ('id = ? AND unit_id = ?', $id, $object_id))))) {
      if ($this->is_ajax (false)) {
          delay_request ('units', 'update_unit_comments_count', array ('unit_id' => $unit_comment->unit_id));
          $object->recycle ();
        $this->output_json (array ('status' => true, 'title' => '成功', 'message' => '刪除成功!', 'action' => 'function(){window.location.assign ("' . base_url (array ('admin', $this->get_class (), 'comments', $object->unit_id)) . '");}'));
      } else { 
        $this->set_method ('delete')->load_view (array ('delete_url' => base_url (array ('admin', $this->get_class (), $this->get_method (), $id))));
      }
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

  public function update ($object_id = 0) {
    $object_name = $this->object_name;

    if (verifyNumber ($object_id) && verifyObject ($object = $object_name::find ('one', array ('conditions' => array ('id = ?', $object_id))))) {
      if ($this->is_post ()) {
        $name = $this->input_post ('name', true);
        $introduction = $this->input_post ('introduction', true);
        $address = $this->input_post ('address', true);
        $open_time = $this->input_post ('open_time', true);
        $tags = ($tags = $this->input_post ('tags', true)) ? $tags : array ();
        $delete_imgs = ($delete_imgs = $this->input_post ('delete_imgs', true)) ? $delete_imgs : array ();
        $pictures = $this->input_post ('pictures[]', true, true);

        if (verifyString ($name) && verifyString ($introduction) && verifyString ($address)) {
          $object->name = $name;
          $object->introduction = $introduction;
          $object->address = $address;
          $object->open_time = $open_time;

          $tag_ids = array_map (function ($tag) { return $tag->id; }, $object->tags);
          if (verifyArray ($delete_tag_ids = array_diff ($tag_ids, $tags)))
            UnitTagMapping::recycle_all (array ('conditions' => array ('unit_id = ? AND unit_tag_id IN (?)', $object->id, $delete_tag_ids)));
          
          if (verifyArray ($create_tag_ids = array_diff ($tags, $tag_ids))) 
            array_map (function ($tag_id) use ($object) {
              if (verifyObject ($unit_tag = UnitTag::find ('one', array ('conditions' => array ('id = ?', $tag_id)))))
                if (!UnitTagMapping::recover ('all', array ('conditions' => array ('unit_id = ? AND unit_tag_id =?', $object->id, $unit_tag->id)))) {
                  UnitTagMapping::create (array ('unit_id' => $object->id, 'unit_tag_id' => $unit_tag->id));
                }
            }, $create_tag_ids);

          if (verifyArray ($delete_imgs))
            UnitPicture::recycle_all (array ('conditions' => array ('unit_id = ? AND id IN (?)', $object->id, $delete_imgs)));

          $temp_picture_ids = array ();
          if (verifyArray ($pictures)) {
            foreach ($pictures as $picture) {
              if (verifyUploadFormat ($picture) && ($picture['size'] >= config ('unit_config', 'recommend', 'upload_picture', 'max_size'))) {
                return $this->message ('新增失敗', '照片大小不符合規定!', base_url (array ('admin', $this->get_class (), 'index')));
              }
            }
            $temp_picture_ids = array_filter (array_map (function ($picture) {
              if (verifyUploadFormat ($picture) && verifyCreateObject ($temp_picture = TempPicture::create (array ('file_name' => '', 'for_object' => ''))) && $temp_picture->file_name->put ($picture)) {
                return $temp_picture->id;
              } else { return false; }
            }, $pictures));
          }

          if (verifyArray ($temp_picture_ids)) {
            foreach ($temp_picture_ids as $temp_picture_id) {
              if (verifyNumber ($temp_picture_id, 1) && verifyObject ($temp_picture = TempPicture::find ('one', array ('conditions' => array ('id = ?', $temp_picture_id)))) && verifyCreateObject ($unit_picture = UnitPicture::create (array ('unit_id' => $object->id, 'file_name' => ''))) && $unit_picture->file_name->put_url ($temp_picture->file_name->url ())) {
                $temp_picture->for_object = 'unit_picture_' . $unit_picture->id;
                $temp_picture->save ();
                $temp_picture->recycle ();
              }
            }
          }
          $object->save ();
          delay_request ('unit_tags', 'update_units_count', array ('unit_tag_ids' => $tag_ids));

          return $this->message ('成功', '修改成功!', base_url (array ('admin', $this->get_class (), 'index')));
        } else { return $this->message ('失敗', '修改失敗! 有標示 ※ 的欄位資料不完整!', base_url (array ('admin', $this->get_class (), 'index'))); }
      } else { 
        $data['object'] = $object;
        $data['update_url'] = base_url (array ('admin', $this->get_class (), $this->get_method (), $object->id));
        $data['feature_name'] = $this->feature_name;
        $data['back_url'] = base_url (array ('admin', $this->get_class (), 'index'));
        $data['tag_ids'] = array_map (function ($tag) { return $tag->id; }, $data['object']->tags);
        $data['unit_tags'] = UnitTag::find ('all');

        $this->load_view ($data);
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

  public function create_view ($object_id = 0) {
    $object_name = $this->object_name;

    if ($this->is_ajax ()) {
      if (!(verifyNumber ($object_id) && verifyObject ($object = $object_name::find ('one', array ('conditions' => array ('id = ?', $object_id)))))) return $this->output_json (array ('status' => false, 'message' => '設定失敗!'));
      $latitude = trim ($this->input_post ("latitude", true));
      $longitude = trim ($this->input_post ("longitude", true));
      $heading = trim ($this->input_post ("heading", true));
      $pitch = trim ($this->input_post ("pitch", true));
      $zoom = trim ($this->input_post ("zoom", true));
      
      if (verifyString ($zoom) && verifyString ($pitch) && verifyString ($heading) && verifyString ($longitude) && verifyString ($latitude)) {
        if (verifyObject ($object->view)) {
          $object->view->latitude = $latitude;
          $object->view->longitude = $longitude;
          $object->view->heading = $heading;
          $object->view->pitch = $pitch;
          $object->view->zoom = $zoom;
          $object->view->save ();
          return $this->output_json (array ('status' => true, 'message' => '修改成功!'));
        } else {
          if (verifyCreateObject ($view = UnitView::create (array ('unit_id' => $object->id, 'latitude' => $latitude, 'longitude' => $longitude, 'heading' => $heading, 'pitch' => $pitch, 'zoom' => $zoom)))) {
            return $this->output_json (array ('status' => true, 'message' => '修改成功!'));
          } else {
            return $this->output_json (array ('status' => false, 'message' => '設定失敗!'));
          }
        }
      }
    } else {
      if (!(verifyNumber ($object_id) && verifyObject ($object = $object_name::find ('one', array ('conditions' => array ('id = ?', $object_id)))))) redirect (array ('admin', $this->get_class (), 'index'));

      $data['object'] = $object;
      if (verifyObject ($data['view'] = $object->view)) {
        $data['view_latitude'] = $data['view']->latitude;
        $data['view_longitude'] = $data['view']->longitude;
        $data['view_heading'] = $data['view']->heading;
        $data['view_pitch'] = $data['view']->pitch;
        $data['view_zoom'] = $data['view']->zoom;
      } else {
        $data['view_latitude'] = $object->latitude;
        $data['view_longitude'] = $object->longitude;
        $data['view_heading'] = 0;
        $data['view_pitch'] = 0;
        $data['view_zoom'] = 0;
      }
      $data['create_view_url'] = base_url (array ('admin', $this->get_class (), 'create_view', $object_id));
      $data['feature_name'] = '街景';
      $data['back_url']     = base_url (array ('admin', $this->get_class (), 'index'));
      $this->add_javascript ('https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false&language=zh-TW');
      $this->load_view ($data);
    }
  }

  public function delete_view () {
    if (!$this->is_ajax ()) return $this->output_json (array ('status' => false, 'message' => '設定失敗!'));

    $view_id = trim ($this->input_post ("view_id", true));

    if (verifyNumber ($view_id) && verifyObject ($view = UnitView::find ('one', array ('select' => 'id', 'conditions' => array ('id = ?', $view_id))))) {
      $view->recycle ();
      return $this->output_json (array ('status' => true, 'message' => '修改成功!'));
    } else { return $this->output_json (array ('status' => false, 'message' => 'post 參數錯誤!')); }
  }

  public function update_status () {
    if (!$this->is_ajax ()) return $this->output_json (array ('status' => false, 'message' => '設定失敗!'));

    $object_name = $this->object_name;
    $object_id   = trim ($this->input_post ("object_id", true));
    $status      = trim ($this->input_post ("status", true));

    if (verifyNumber ($object_id) && verifyString ($status) && verifyItemInArray ($status, array_keys (config ('unit_config', 'status'))) && verifyObject ($object = $object_name::find ('one', array ('select' => 'id, status, updated_at', 'conditions' => array ('id = ?', $object_id))))) {
      $object->status = $status;
      $object->save ();
      delay_request ('unit_tags', 'update_units_count', array ('unit_tag_ids' => array_map (function ($tag) { return $tag->id; }, $object->tags)));
      return $this->output_json (array ('status' => true, 'message' => '修改成功!'));
    } else { return $this->output_json (array ('status' => false, 'message' => 'post 參數錯誤!')); }
  }
}
