<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @author      OA Wu <comdan66@gmail.com>
 * @copyright   Copyright (c) 2014 OA Wu Design
 */
class Test extends Site_controller {
  public function __construct () {
    parent::__construct ();
  }

  public function index () {
    // load view (包含 frame)
    // 內容頁面位置
    // 此頁面相關 css js 為以下兩隻
      // application/views/content/site/test/index/content.css
      // application/views/content/site/test/index/content.js
    // 此頁面內容為以下
      // application/views/content/site/test/index/content.php
    $this->load_view ();
  }

  public function submit_page () {
    echo "submit_page!!";
  }

  public function fancybox_page () {

    // 加入
    // 此頁面相關 css js 為以下兩隻
    // application/views/content/site/test/fancybox_page/content.css
    // application/views/content/site/test/fancybox_page/content.js

    $this
      ->add_css (base_url (utilitySameLevelPath (implode (DIRECTORY_SEPARATOR, array_merge (array (APPPATH), $this->get_views_path (), $this->get_content_path (), array ($this->get_class (), $this->get_method (), 'content.css'))))))
      ->add_javascript (base_url (utilitySameLevelPath (implode (DIRECTORY_SEPARATOR, array_merge (array (APPPATH), $this->get_views_path (), $this->get_content_path (), array ($this->get_class (), $this->get_method (), 'content.js'))))));
    
    // 取得 components
    $components = $this->load_components ('css', 'javascript', 'hidden');

    // load view (純內容)
    $this->load_content (array ('components' => $components));
  }
}
