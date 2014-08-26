<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @author      OA Wu <comdan66@gmail.com>
 * @copyright   Copyright (c) 2014 OA Wu Design
 */
class Postform extends Site_controller {

  public function __construct () {
    parent::__construct ();
  }

  public function sign_in () {
    if (!$this->is_ajax (false))
      return show_error ("It's not Ajax request!<br/>Please confirm your program again.");
    
    $this
      ->add_meta (array ('http-equiv' => 'Content-type', "content" => "text/html; charset=utf-8"))
      ->add_css (base_url (utilitySameLevelPath (implode (DIRECTORY_SEPARATOR, array_merge (array (APPPATH), $this->get_views_path (), $this->get_content_path (), array ($this->get_class (), $this->get_method (), 'content.css'))))))
      ->add_javascript (base_url (utilitySameLevelPath (implode (DIRECTORY_SEPARATOR, array_merge (array (APPPATH), $this->get_views_path (), $this->get_content_path (), array ($this->get_class (), $this->get_method (), 'content.js'))))))
      ;

    $components = $this->load_components ('meta', 'css', 'javascript', 'hidden');
    $this->load_content (array ('components' => $components, 'current_uri' => func_get_args ()));
  }

  public function upload_picture () {
    if (!$this->is_ajax ())
      show_error ("It's not Ajax request!<br/>Please confirm your program again.");

    $current_uri = ($current_uri = $this->input_post ('current_uri')) ? array_filter (explode ('/', $current_uri)) : array ();

    if (!identity ()->get_identity ('sign_in'))
      call_user_func ('redirect', array_merge (array ($this->get_class (), 'sign_in'), $current_uri));

    $this
      ->add_meta (array ('http-equiv' => 'Content-type', "content" => "text/html; charset=utf-8"))
      ->add_hidden (array ('id' => 'postform_submit_temp_picture_url', 'value' => base_url (array ('postform', 'submit_temp_picture'))))
      ->add_hidden (array ('id' => 'submit_picture_url', 'value' => base_url (array ('postform', 'submit_picture'))))
      ->add_hidden (array ('id' => 'postform_picture_ori_url', 'value' => ''))
      ->add_hidden (array ('id' => 'postform_temp_id', 'value' => ''))
      ->add_css (base_url (utilitySameLevelPath (REL_PATH_CSS, 'jquery-file-upload_v3.1.0', 'uploadfile.css')))
      ->add_css (base_url (utilitySameLevelPath (implode (DIRECTORY_SEPARATOR, array_merge (array (APPPATH), $this->get_views_path (), $this->get_content_path (), array ($this->get_class (), $this->get_method (), 'content.css'))))))
      ->add_javascript (base_url (utilitySameLevelPath (REL_PATH_JS, 'jquery-file-upload_v3.1.0', 'jquery.uploadfile.js')))
      ->add_javascript (base_url (utilitySameLevelPath (implode (DIRECTORY_SEPARATOR, array_merge (array (APPPATH), $this->get_views_path (), $this->get_content_path (), array ($this->get_class (), $this->get_method (), 'content.js'))))))
      ;

    $components = $this->load_components ('meta', 'css', 'javascript', 'hidden');
    $this->load_content (array ('components' => $components, 'current_uri' => $current_uri));
  }

  public function submit_temp_picture () {
    if (!$this->has_post ())
      return show_error ("It's not post request!<br/>Please confirm your program again.");

    if (!identity ()->get_identity ('sign_in'))
      return $this->output_json (array ('status' => false, 'message' => '失敗! 您沒有還沒有登入!'));
    
    if (($picture = $this->input_post ('picture', true, true)) && verifyCreateOrm ($temp_picture = TempPicture::create (array ('file_name' => '', 'model_name' => '', 'model_id' => 0))) && $temp_picture->file_name->put ($picture))
      $this->output_json (array ('status' => true, 'url' => $temp_picture->file_name->url (), 'temp_id' => $temp_picture->id));
    else
      $this->output_json (array ('status' => false, 'message' => '產生預覽圖失敗，請通知程式設計人員!'));
  }

  public function submit_picture () {
    if (!$this->is_ajax ())
      return show_error ("It's not post request!<br/>Please confirm your program again.");
    
    if (!identity ()->get_identity ('sign_in'))
      return $this->output_json (array ('status' => false, 'message' => '失敗! 您沒有還沒有登入!'));
    
      $temp_id = $this->input_post ('temp_id');
      $text = $this->input_post ('text');
      $tags = array_filter (array_unique (array_map ('trim', $this->input_post ('tags'))));
      $sync_fb = $this->input_post ('sync_fb') == 'true' ? 1 : 0;

      if (!($temp_id && $text && $tags && ($temp_picture = TempPicture::find ('one', array ('select' => 'id, file_name', 'conditions' => array ('id = ?', $temp_id))))))
        return $this->output_json (array ('status' => false, 'message' => '上傳圖片失敗，請通知程式設計人員!'));

      delay_job ('pictures', 'create', array ('temp_id' => $temp_picture->id, 'user_id' => identity ()->get_session ('user_id'), 'text' => $text, 'tags' => $tags, 'is_sync' => $sync_fb));
      
      if ($sync_fb) {
        // 
      }
      return $this->output_json (array ('status' => true, 'message' => '上傳圖片成功!', 'url' => base_url (array ('users', identity ()->get_session ('user_id')))));
  }
}
