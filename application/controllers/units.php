<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @author      OA Wu <comdan66@gmail.com>
 * @copyright   Copyright (c) 2014 OA Wu Design
 */
class Units extends Site_controller {
  public function __construct () {
    parent::__construct ();
    $this->set_title ('北港地圖');

    $this->add_visit_menu ('地圖故事', array ($this->get_class ()))
         ->add_visit_menu ('推薦地點', array ($this->get_class (), 'recommend'))
         ;
  }

  public function index () {
    redirect (array ($this->get_class (), 'map'));
  }

  public function tags ($names = '') {





    // $u = Unit::find ('one', array ('conditions' => array ('id = ?', 1)));
    // $u->recycle ();
    // Unit::recover ('one', array ('conditions' => array ('origin_id = ?', 1)));

    // Unit::recycle_all (array ('conditions' => array ('id < ?', 15)));
    // Unit::recover ('all', array ('conditions' => array ('origin_id < ?', 15)));

    // Unit::recycle_all ();
    // Unit::recover ('all');


    // echo '<meta http-equiv="Content-type" content="text/html; charset=utf-8" /><pre>';
    // Unit::record_delete_all ();
    // Unit::record_recover ('one', array ('conditions' => array ('origin_id = ?', 1)));


    // $us = Unit::find ('all');
    // array_map(function ($u) {$u->record_delete ();}, $us);
    
    // Unit::recover ('all');






//     $names = array_filter (explode (' ', rawurldecode ($names)));
    // echo '<meta http-equiv="Content-type" content="text/html; charset=utf-8" /><pre>';
    // var_dump ($u);
    // exit ();
    // $u->record_delete ();
    // echo '<meta http-equiv="Content-type" content="text/html; charset=utf-8" /><pre>';
    // var_dump ($u);
    // exit ();


//       delay_request ('errors', 'record', array ('message' => '使用 Facebook 登入失敗! IP: ' . $this->input->ip_address (), 'object_id' => 0, 'object_name' => ''));

// echo '<meta http-equiv="Content-type" content="text/html; charset=utf-8" /><pre>';
// var_dump ($names);
// exit ();
    // if (!verifyString ($names)) redirect (array ($this->get_class (), 'index'));
    
    // count ($names = array_map ('rawurldecode', func_get_args ())) ? array_map (array ($this, 'return_share'), Share::find ('all', array ('conditions' => array ('id IN (?)', $share_ids)))) : array ()));
  }

  public function read_more_comment () {
    if (!$this->is_ajax ()) redirect (array ('error', 'not_ajax'));
    
    $that = $this;
    $unit_id = $this->input_post ("unit_id");
    $next_id = $this->input_post ("next_id");

    if (verifyNumber ($unit_id) && verifyNumber ($next_id) && verifyObject ($unit = Unit::find ('one', array ('conditions' => array ('id = ? AND status = ?', $unit_id, 'certified'))))) {
      $unit_comments = UnitComment::find ('all', array ('order' => 'id DESC', 'include' => array ('user'), 'limit' => config ('unit_config', 'comment', 'load_length') + 1, 'conditions' => array ('unit_id = ? AND id <= ?', $unit->id, $next_id)));
      $contents = array_map (function ($unit_comment) use ($that) { return $that->set_method ('comment')->load_content (array ('unit_comment' => $unit_comment, 'that' => $that), true); }, array_slice ($unit_comments, 0, config ('unit_config', 'comment', 'load_length')));
      $next_id = verifyObject ($next_unit_comment = verifyArray ($next_unit_comment = array_slice ($unit_comments, config ('unit_config', 'comment', 'load_length'), 1)) ? $next_unit_comment[0] : null) ? $next_unit_comment->id : 0;
      $this->output_json (array ('status' => true, 'next_id' => $next_id, 'contents' => $contents));
    } else { redirect (array ('error', 'not_ajax')); }
  }

  public function delete_unit () {
    if (!$this->is_ajax ()) redirect (array ('error', 'not_ajax'));

    $unit_id = $this->input_post ("unit_id");

    if ($this->identity->get_identity ('sign_in') && $this->identity->get_identity ('admins')) {
      if (verifyNumber ($unit_id) && verifyObject ($unit = Unit::find ('one', array ('select' => 'id', 'conditions' => array ('id = ? AND status = ?', $unit_id, 'certified'))))) {
          $unit->recycle ();
          $this->output_json (array ('status' => true, 'title' => '成功', 'message' => '刪除成功!', 'action' => 'function(){window.location.assign ("' . base_url (array ($this->get_class (), 'index')) . '");}'));
      } else { redirect (array ('error', 'not_ajax')); }
    } else { $this->output_json (array ('status' => false, 'title' => '失敗', 'message' => '刪除失敗! 您沒有權限刪除!', 'action' => 'function(){$(this).OA_Dialog ("close");}')); }
  }

  public function delete_unit_comment () {
    if (!$this->is_ajax ()) redirect (array ('error', 'not_ajax'));

    $unit_comment_id = $this->input_post ("unit_comment_id");

    if (verifyNumber ($unit_comment_id) && verifyObject ($unit_comment = UnitComment::find ('one', array ('select' => 'id, unit_id, user_id', 'conditions' => array ('id = ?', $unit_comment_id))))) {
      if ($this->identity->get_identity ('sign_in') && (($this->identity->get_session ('user_id') == $unit_comment->user_id) || $this->identity->get_identity ('admins'))) {
          delay_request ('units', 'update_unit_comments_count', array ('unit_id' => $unit_comment->unit_id));
          $unit_comment->recycle ();
          $this->output_json (array ('status' => true, 'title' => '成功', 'message' => '刪除成功!', 'action' => 'function(){$that.parents (".comment").hide ("blind", function () {$(this).remove ();}); $(this).OA_Dialog ("close");}'));
      } else { $this->output_json (array ('status' => false, 'title' => '失敗', 'message' => '刪除失敗! 您沒有權限刪除!', 'action' => 'function(){$(this).OA_Dialog ("close");}')); }
    } else { redirect (array ('error', 'not_ajax')); }
  }

  public function advice_unit () {
    if (!$this->is_ajax ()) redirect (array ('error', 'not_ajax'));

    $unit_id = $this->input_post ("unit_id");

    if (verifyNumber ($unit_id) && verifyObject ($unit = Unit::find ('one', array ('select' => 'id', 'conditions' => array ('id = ? AND status = ?', $unit_id, 'certified'))))) {
      if (verifyCreateObject ($unit_advice = UnitAdvice::create (array ('unit_id' => $unit->id, 'user_id' => $this->identity->get_identity ('sign_in') ? $this->identity->get_session ('user_id') : '0', 'message' => '建議刪除景點ID: ' . $unit->id, 'ip' => $this->input->ip_address (), 'is_read' => '0'))))
        $this->output_json (array ('status' => true, 'title' => '建議成功', 'message' => '已經建議管理人員再次審核了!<br/>可以的話請提供您的參考建議吧!<textarea id="advice_textarea"></textarea>', 'action' => 'function(){ push_advice_message ($("#advice_textarea").val (), ' . $unit_advice->id . '); $(this).OA_Dialog ("close"); }'));
      else {
        delay_request ('errors', 'record', array ('message' => '建議刪除失敗!', 'object_id' => $unit->id, 'object_name' => $unit->table ()->table));
        $this->output_json (array ('status' => true, 'title' => '建議失敗', 'message' => '建議刪除失敗，請稍候再試，或請通知程式設計人員!', 'action' => 'function(){ $(this).OA_Dialog ("close"); }'));
      }
    } else { redirect (array ('error', 'not_ajax')); }
  }

  public function push_advice_message () {
    if (!$this->is_ajax ()) redirect (array ('error', 'not_ajax'));

    $unit_advice_id = $this->input_post ("unit_advice_id");
    $message = trim ($this->input_post ("message"));

    if (verifyNumber ($unit_advice_id) && verifyString ($message) && verifyObject ($unit_advice = UnitAdvice::find ('one', array ('select' => 'id, message, updated_at', 'conditions' => array ('id = ?', $unit_advice_id))))) {
      $unit_advice->message = $message;
      $unit_advice->save (); 
      $this->output_json (array ('status' => true, 'title' => '成功', 'message' => '謝謝您的建議，我們會儘快審核!', 'action' => 'function(){}'));
    } else { redirect (array ('error', 'not_ajax')); }
  }

  public function id ($id_or_name) {
    if ((verifyNumber ($id_or_name) && verifyObject ($unit = Unit::find ('one', array ('conditions' => array ('id = ? AND status = ?', $id_or_name, 'certified'))))) || (verifyString ($id_or_name = rawurldecode ($id_or_name)) && verifyObject ($unit = Unit::find ('one', array ('order' => 'pageview DESC', 'conditions' => array ('name = ? AND status = ?', $id_or_name, 'certified')))))) {

    $this->set_title ($unit->name . ' - 北港地圖故事')
         ->add_meta ('og:title', $unit->name . ' - 北港地圖故事', 'property')
         ->add_meta ('og:description', mb_strimwidth (strip_tags ($unit->introduction), 0, 100, '', 'UTF-8') . ' - 北港地圖故事，一個屬於在地人都知道的地圖故事，隱藏版的古蹟、名勝、美食...等景點，通通都在北港地圖故事!', 'property')
         ->add_meta ('og:image', $unit->first_picture ('500x300C'), 'property')
         ->add_meta ('og:url', current_url (), 'property')
         ->add_meta ('description', mb_strimwidth (strip_tags ($unit->introduction), 0, 100, '', 'UTF-8') . ' - 北港地圖故事，一個屬於在地人都知道的地圖故事，隱藏版的古蹟、名勝、美食...等景點，通通都在北港地圖故事!')
         ->add_meta ('keywords', $unit->name . '|北港地圖故事|北港媽祖|北港景點|北港廟會');

      delay_request ('units', 'add_pageview', array ('unit_id' => $unit->id));
      $that = $this;

      $this->add_javascript ('https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false&language=zh-TW');
      $this->add_hidden ('submit_comment_url', 'submit_comment_url', base_url (array ($this->get_class (), 'submit_comment')));
      $this->add_hidden ('read_more_comment_url', 'read_more_comment_url', base_url (array ($this->get_class (), 'read_more_comment')));
      $this->add_hidden ('set_score_url', 'set_score_url', base_url (array ($this->get_class (), 'set_score')));
      $this->add_hidden ('delete_unit_url', 'delete_unit_url', base_url (array ($this->get_class (), 'delete_unit')));
      $this->add_hidden ('delete_unit_comment_url', 'delete_unit_comment_url', base_url (array ($this->get_class (), 'delete_unit_comment')));
      $this->add_hidden ('advice_unit_url', 'advice_unit_url', base_url (array ($this->get_class (), 'advice_unit')));
      $this->add_hidden ('push_advice_message_url', 'push_advice_message_url', base_url (array ($this->get_class (), 'push_advice_message')));
      
      $unit_comments = UnitComment::find ('all', array ('order' => 'id DESC', 'include' => array ('user'), 'limit' => config ('unit_config', 'comment', 'd4_length') + 1, 'conditions' => array ('unit_id = ?', $unit->id)));
      $comment_list = implode ('', array_map (function ($unit_comment) use ($that) { return $that->set_method ('comment')->load_content (array ('unit_comment' => $unit_comment, 'that' => $that), true); }, array_slice ($unit_comments, 0, config ('unit_config', 'comment', 'd4_length'))));
      $next_unit_comment_id = verifyObject ($next_unit_comment = verifyArray ($next_unit_comment = array_slice ($unit_comments, config ('unit_config', 'comment', 'd4_length'), 1)) ? $next_unit_comment[0] : null) ? $next_unit_comment->id : 0;
      $fb_sing_in_url = $this->fb->getLoginUrl (array ('redirect_uri' => base_url (array ('platform', 'fb_sing_in', implode ('|', array ($this->get_class (), 'id', $unit->id))))));

      $pictures = UnitPicture::find ('all', array ('order' => 'id ASC', 'offset' => 0, 'limit' => config ('unit_config', 'id', 'pictures', 'max_count'), 'conditions' => array ('unit_id = ?', $unit->id)));
      $banner_type = verifyObject ($view = $unit->view) ? 'view' : (count ($pictures) ? 'pic' : 'map');

      $more_tags = ($count_tags = count ($unit->tags)) ? $count_tags < config ('unit_config', 'id', 'more_tags_max_length') ? array_merge ($unit->tags, UnitTag::find ('all', array ('order' => 'RAND()', 'limit' => config ('unit_config', 'id', 'more_tags_max_length') - $count_tags, 'conditions' => array ('id NOT IN (?)', objects_field_array ($unit->tags, 'id'))))) : array_slice ($unit->tags, 0, config ('unit_config', 'id', 'more_tags_max_length')) : UnitTag::find ('all', array ('order' => 'RAND()', 'limit' => config ('unit_config', 'id', 'more_tags_max_length')));

      $this->set_method ('id')->load_view (array ('unit' => $unit, 'view' => $unit->view, 'tags' => $unit->tags, 'more_tags' => $more_tags, 'banner_type' => $banner_type, 'comment_list' => $comment_list, 'pictures' => $pictures, 'fb_sing_in_url' => $fb_sing_in_url, 'next_unit_comment_id' => $next_unit_comment_id));
    } else { redirect (array ($this->get_class ())); }
  }


  public function set_score () {
    if (!$this->is_ajax ()) redirect (array ('error', 'not_ajax'));

    $unit_id = $this->input_post ("unit_id");
    $user_id = $this->input_post ("user_id");
    $score   = $this->input_post ("score");

    if (verifyNumber ($unit_id) && verifyNumber ($user_id) && $this->identity->get_identity ('sign_in') && ($user_id == $this->identity->get_session ('user_id')) && verifyObject ($user = User::find ('one', array ('conditions' => array ('id = ?', $user_id))))) {
      if (verifyObject ($unit = Unit::find ('one', array ('conditions' => array ('id = ? AND status = ?', $unit_id, 'certified'))))) {
        if (!verifyObject ($unit_score = $unit->user_score ($user->id))) {
          if (verifyNumber ($score, 1, 5)) {
            delay_request ('units', 'set_score', array ('unit_id' => $unit->id, 'score' => $score, 'user_id' => $user->id));
            $this->output_json (array ('status' => true, 'message' => '成功給分!!'));
          } else { $this->output_json (array ('status' => false, 'message' => '打分數失敗(S)!')); }
        } else { $this->output_json (array ('status' => false, 'message' => '你打過分數囉!')); }
      } else { $this->output_json (array ('status' => false, 'message' => '打分數失敗!(A)')); }
    } else { $this->output_json (array ('status' => false, 'message' => '請用 Facebook 登入')); }
  }

  public function submit_comment () {
    if (!$this->is_ajax ()) redirect (array ('error', 'not_ajax'));

    $user_id = $this->input_post ("user_id");
    $unit_id = $this->input_post ("unit_id");
    $message = trim ($this->input_post ("message"));
    $sync_fb = (verifyString ($sync_fb = $this->input_post ("sync_fb")) && ($sync_fb == 'true')) || ($sync_fb === true) ? true : false;

    if ($this->identity->get_identity ('sign_in') && verifyNumber ($user_id) && ($user_id == $this->identity->get_session ('user_id')) && verifyObject ($user = User::find ('one', array ('conditions' => array ('id = ?', $user_id))))) {
      if (verifyNumber ($unit_id) && verifyString ($message) && verifyObject ($unit = Unit::find ('one', array ('conditions' => array ('id = ? AND status = ?', $unit_id, 'certified'))))) {
        if (verifyCreateObject ($unit_comment = UnitComment::create (array ('user_id' => $user->id, 'unit_id' => $unit->id, 'message' => $message, 'is_sync' => $sync_fb ? 1 : 0)))) {

          delay_request ('units', 'update_unit_comments_count', array ('unit_id' => $unit->id));

          if ($sync_fb) {
            // try {
            //   if ($this->fb->getUser ()) {
            //     $res = $this->fb->api ('/me/feed', 'POST', array(
            //       'message' => $message,
            //     ));
            //   }
            // } catch (FacebookApiException $e) { delay_request ('errors', 'record', array ('message' => '同步至 facebook 失敗! message: ' . (string)$e, 'object_id' => $unit_comment->id, 'object_name' => $unit_comment->table ()->table)); }
          }
          $this->output_json (array ('status' => true, 'message' => '留言成功!', 'content' => $this->set_method ('comment')->load_content (array ('unit_comment' => $unit_comment, 'that' => $this), true)));
        } else { $this->output_json (array ('status' => false, 'message' => '留言失敗，請通知程式設計人員!')); }
      } else { redirect (array ('error', 'not_ajax')); }
    } else { $this->output_json (array ('status' => false, 'message' => '請確認有使用 Facebook 登入，若登入後仍然有此狀況，請通知程式設計人員!')); }
  }

// ===================================================== list ========

  public function get_units () {
    if (!$this->is_ajax ()) redirect (array ('error', 'not_ajax'));

    $unit_tag_id = $this->input_post ("id");

    if (verifyNumber ($unit_tag_id, 1) && verifyObject ($unit_tag = UnitTag::find ('one', array ('conditions' => array ('id = ?', $unit_tag_id))))) {
      $contents = array ();

      if (count ($unit_tag->units)) foreach ($unit_tag->units as $unit) array_push ($contents, array ('content' => $this->set_method ('get_unit')->load_content (array ('unit' => $unit), true), 'infowindow' => $this->set_method ('get_infowindow')->load_content (array ('unit' => $unit), true)));
      else $content = $this->set_method ('get_unit')->load_content (null, true);
      
      $this->output_json (array ('status' => true, 'contents' => $contents, 'content' => isset ($content) ? $content : ''));
    } else if (verifyNumber ($unit_tag_id, null) && verifyObject ($unit_tag = UnitTag::SpecialTag_find_by_id ($unit_tag_id, 'one'))) {
      
      $contents = array ();
      if (count ($units = $unit_tag->units ())) foreach ($units as $unit) array_push ($contents, array ('content' => $this->set_method ('get_unit')->load_content (array ('unit' => $unit), true), 'infowindow' => $this->set_method ('get_infowindow')->load_content (array ('unit' => $unit), true)));
      else $content = $this->set_method ('get_unit')->load_content (null, true);
      $this->output_json (array ('status' => true, 'contents' => $contents, 'content' => isset ($content) ? $content : ''));
    } else { redirect (array ('error', 'not_ajax')); }
  }

  public function map () {
    $this->set_title ('北港地圖故事')
         ->add_meta ('og:title', '北港地圖故事', 'property')
         ->add_meta ('og:description', '北港地圖故事，一個屬於在地人都知道的地圖故事，隱藏版的古蹟、名勝、美食...等景點，通通都在北港地圖故事!', 'property')
         ->add_meta ('og:image', base_url (array ('resource', 'image', 'og', 'image4.jpg')), 'property')
         ->add_meta ('og:url', current_url (), 'property')
         ->add_meta ('description', '北港地圖故事，一個屬於在地人都知道的地圖故事，隱藏版的古蹟、名勝、美食...等景點，通通都在北港地圖故事!')
         ->add_meta ('keywords', '北港地圖故事|北港媽祖|北港景點|北港廟會');

    $this->add_hidden ('get_units_url', 'get_units_url', base_url (array ($this->get_class (), 'get_units')));
    $this->add_hidden ('get_map_panel_url', 'get_map_panel_url', base_url (array ($this->get_class (), 'get_map_panel')));
    $this->add_javascript ('https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false&language=zh-TW');
    $this->load_view ();
  }

  public function get_map_panel () {
    if (!$this->is_ajax (false)) redirect (array ('error', 'not_ajax'));
    $unit_tags = UnitTag::find ('all');
    $special_tags = UnitTag::SpecialTag_all ();
    $this->output_json (array ('status' => true, 'content' => $this->load_content (array ('unit_tags' => $unit_tags, 'special_tags' => $special_tags), true)));
  }


// ===================================================== recommend ========
  
  public function recommend () {
    if (!$this->identity->get_identity ('sign_in')) redirect ($this->fb->getLoginUrl (array ('redirect_uri' => base_url (array ('platform', 'fb_sing_in', 'units|recommend')))));

    $this->set_title ('推薦!北港地圖故事')
         ->add_meta ('og:title', '推薦!北港地圖故事', 'property')
         ->add_meta ('og:description', '我要推薦一個屬於在地人都知道的地圖故事，隱藏版的古蹟、名勝、美食...等景點，通通都在北港地圖故事!', 'property')
         ->add_meta ('og:image', base_url (array ('resource', 'image', 'og', 'image4.jpg')), 'property')
         ->add_meta ('og:url', current_url (), 'property')
         ->add_meta ('description', '我要推薦一個屬於在地人都知道的地圖故事，隱藏版的古蹟、名勝、美食...等景點，通通都在北港地圖故事!')
         ->add_meta ('keywords', '推薦!北港地圖故事|北港媽祖|北港景點|北港廟會');

    $this->add_hidden ('get_recommend_panel_url', 'get_recommend_panel_url', base_url (array ($this->get_class (), 'get_recommend_panel')));
    $this->add_javascript ('https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false&language=zh-TW');
    $this->load_view ();
  }

  public function get_recommend_panel () {
    if (!$this->is_ajax (false)) redirect (array ('error', 'not_ajax'));
    $unit_tags = UnitTag::find ('all');
    $this->output_json (array ('status' => true, 'content' => $this->load_content (array ('that' => $this, 'unit_tags' => $unit_tags, 'recommend_submit_url' => base_url (array ($this->get_class (), 'recommend_submit'))), true)));
  }

  public function recommend_submit () {
    if (!$this->is_post ()) redirect (array ('error', 'not_post'));

    $user_id      = $this->input_post ('user_id');
    $latitude     = $this->input_post ('latitude');
    $longitude    = $this->input_post ('longitude');

    $name         = $this->input_post ('name');
    $introduction = $this->input_post ('introduction');
    $open_time    = $this->input_post ('open_time');
    $address      = $this->input_post ('address');
    $pictures     = $this->input_post ('pictures[]', true, true);
    $tags         = $this->input_post ('tags');

    if ($this->identity->get_identity ('sign_in') && verifyNumber ($user_id) && verifyObject ($user = User::find ('one', array ('conditions' => array ('id = ?', $user_id))))) {
      if (verifyString ($latitude) && verifyString ($longitude)) {
        if (verifyString ($name)) {
          if (mb_strlen ($name, "utf-8") <= config ('unit_config', 'recommend', 'name_max_length')) {
            if (verifyString ($introduction) && mb_strlen ($name, "utf-8") > config ('unit_config', 'recommend', 'introduction_max_length')) {
              return $this->message ('新增失敗', '景點簡介長度請小於' . config ('unit_config', 'recommend', 'introduction_max_length') . '個字!', base_url (array ($this->get_class (), 'recommend')));
            } else {
              // if (verifyString ($open_time)) {
                if (mb_strlen ($open_time, "utf-8") <= config ('unit_config', 'recommend', 'open_time_max_length')) {
                  if (verifyString ($address)) {
                    if (mb_strlen ($address, "utf-8") <= config ('unit_config', 'recommend', 'address_max_length')) {
                      
                      $temp_picture_ids = array ();

                      if (verifyArray ($pictures)) {
                        foreach ($pictures as $picture) {
                          if (verifyUploadFormat ($picture) && ($picture['size'] >= config ('unit_config', 'recommend', 'upload_picture', 'max_size'))) {
                            return $this->message ('新增失敗', '照片大小不符合規定!', base_url (array ($this->get_class (), 'recommend')));
                          }
                        }
                        $temp_picture_ids = array_filter (array_map (function ($picture) {
                          if (verifyUploadFormat ($picture) && verifyCreateObject ($temp_picture = TempPicture::create (array ('file_name' => '', 'for_object' => ''))) && $temp_picture->file_name->put ($picture)) {
                            $temp_picture->save ();
                            return $temp_picture->id;
                          } else { return false; }
                        }, $pictures));
                      }

                      delay_request ('units', 'create', array ('user_id' => $user->id, 'latitude' => $latitude, 'longitude' => $longitude, 'name' => $name, 'introduction' => $introduction, 'open_time' => $open_time, 'address' => $address, 'temp_picture_ids' => $temp_picture_ids, 'tags' => $tags));
                      return $this->message ('成功', '已經成功推薦給網站管理者，等待審核通過後就可以分享給大家囉!', base_url (array ($this->get_class ())));
                    } else { return $this->message ('新增失敗', '景點住址長度請小於' . config ('unit_config', 'recommend', 'address_max_length') . '個字!', base_url (array ($this->get_class (), 'recommend'))); }
                  } else { return $this->message ('新增失敗', '您沒有填寫景點住址!', base_url (array ($this->get_class (), 'recommend'))); }
                } else { return $this->message ('新增失敗', '營業時間說明長度請小於' . config ('unit_config', 'recommend', 'open_time_max_length') . '個字!', base_url (array ($this->get_class (), 'recommend'))); }
              // } else { return $this->message ('新增失敗', '您沒有填寫營業時間!', base_url (array ($this->get_class (), 'recommend'))); }                
            }
          } else { return $this->message ('新增失敗', '景點名稱長度請小於' . config ('unit_config', 'recommend', 'name_max_length') . '個字!', base_url (array ($this->get_class (), 'recommend'))); }
        } else { return $this->message ('新增失敗', '您沒有填寫景點名稱!', base_url (array ($this->get_class (), 'recommend'))); }
      } else {
        delay_request ('errors', 'record', array ('message' => '取得經緯度失敗!', 'object_id' => $user->id, 'object_name' => $user->table ()->table));
        return $this->message ('新增失敗', '取得經緯度失敗，請通知程式設計人員!', base_url (array ($this->get_class (), 'recommend'))); }
    } else {
      delay_request ('errors', 'record', array ('message' => '使用 Facebook 登入失敗! IP: ' . $this->input->ip_address (), 'object_id' => 0, 'object_name' => ''));
      return $this->message ('新增失敗', '請確認有使用 Facebook 登入，若登入後仍然有此狀況，請通知程式設計人員!', base_url (array ($this->get_class (), 'recommend'))); }      
  }

// ===================================================== message ========

  public function message ($title, $message, $redirect) {
    if (verifyString ($title) && verifyString ($message) && verifyString ($redirect)) {
      $this->add_hidden ('title', 'title', $title)
           ->add_hidden ('message', 'message', $message)
           ->add_hidden ('redirect', 'redirect', $redirect)
           ->set_method ('message')
           ->load_view ();
    } else { redirect (array ('admin', $this->get_class (), 'index')); }
  }

}
