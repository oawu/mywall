<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @author      OA Wu <comdan66@gmail.com>
 * @copyright   Copyright (c) 2014 OA Wu Design
 */
class Error extends Site_controller {
  public function __construct () {
    parent::__construct ();
    
  }

  public function not_post ($message = '') {
    $data = array ('status' => false, 'title' => '錯誤!', 'message' => '此為非 Post 請求，請勿任意破壞網站!', 'action' => 'function(){location.reload();}');
    if ($this->is_ajax (false)) $this->output_json ($data, config ('d4_config', 'static_page_cache_time'));
    else $this->set_method ('index')->load_view ($data, false, config ('d4_config', 'static_page_cache_time'));
  }

  public function not_ajax ($message = '') {
    $data = array ('status' => false, 'title' => '錯誤!', 'message' => '此為非 Ajax 請求，請勿任意破壞網站!', 'action' => 'function(){location.reload();}');
    if ($this->is_ajax (false)) $this->output_json ($data, config ('d4_config', 'static_page_cache_time'));
    else $this->set_method ('index')->load_view ($data, false, config ('d4_config', 'static_page_cache_time'));
  }

  public function index ($message = '') {
    $data = array ('status' => false, 'title' => '錯誤!', 'message' => '不明原因錯誤，請通知程式設計人員!', 'action' => 'function(){location.reload();}');
    if ($this->is_ajax (false)) $this->output_json ($data, config ('d4_config', 'static_page_cache_time'));
    else $this->set_method ('index')->load_view ($data, false, config ('d4_config', 'static_page_cache_time'));
  }

  public function facebook_sing_in ($message = '') {
    $data = array ('status' => false, 'title' => '錯誤!', 'message' => 'Facebook 登入錯誤，請通知程式設計人員!', 'action' => 'function(){location.reload();}');
    if ($this->is_ajax (false)) $this->output_json ($data, config ('d4_config', 'static_page_cache_time'));
    else $this->set_method ('index')->load_view ($data, false, config ('d4_config', 'static_page_cache_time'));
  }
}
