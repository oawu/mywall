<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @author      OA Wu <comdan66@gmail.com>
 * @copyright   Copyright (c) 2014 OA Wu Design
 */
class Output extends Site_controller {
  public function __construct () {
    parent::__construct ();
  }

  public function del_list () {
    $tags = DeleteTag::find ('all');
    $this->load_view (array ('tags' => $tags));
  }
  public function index () {
    $tags = array_map (function ($group) {
        return $group->main;
    }, Group::find ('all', array ('select' => 'main_id', 'include' => array ('main'), 'group' => 'main_id')));

    $this//->add_hidden (array ('id' => 'get_swf_url', 'value' => base_url (REL_PATH_FLASH . 'jquery.zclip_v1.1.1' . DIRECTORY_SEPARATOR . 'ZeroClipboard.swf')))
         // ->add_javascript (base_url (utilitySameLevelPath (REL_PATH_JS, 'jquery.zclip_v1.1.1', 'jquery.zclip.js')))
         // ->add_javascript (base_url (utilitySameLevelPath (REL_PATH_JS, 'jquery.ZeroClipboard_v2.1.6', 'ZeroClipboard.min.js')))
         ->load_view (array ('tags' => $tags));
  }
}
