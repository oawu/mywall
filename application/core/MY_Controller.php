<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @author      OA Wu <comdan66@gmail.com>
 * @copyright   Copyright (c) 2014 OA Wu Design
 */
class Root_controller extends CI_controller {
  private $componemt_path = array ();
  private $frame_path     = array ();
  private $content_path   = array ();
  private $public_path    = array ();

  private $class  = '';
  private $method = '';
  private $title  = '';

  private $component_lists = array ();

  private $controllers_path = array ();
  private $views_path = array ();
  private $libraries_path = array ();

  public function __construct () {
    parent::__construct ();
    $this->load->driver ('cache', array ('adapter' => 'apc', 'backup' => 'file'));
    
    $this->load->helper ('url');
    $this->load->helper ('html');
    $this->load->helper ('oa');
    $this->load->helper ('upload_file');
    $this->load->helper ('cell');

    $this->set_controllers_path ('controllers')
         ->set_libraries_path ('libraries')
         ->set_views_path ('views')
         ->set_class ($this->router->fetch_class ())
         ->set_method ($this->router->fetch_method ())
         ->init_component_lists ('meta', 'css', 'javascript', 'hidden')
         ->add_meta (array ('http-equiv' => 'Content-type', "content" => "text/html; charset=utf-8"));
  }

  protected function init_component_lists () {
    if (!$this->component_lists)
      $this->component_lists = array ();
    if ($components = func_get_args ())
      foreach ($components as $component)
        if (!isset ($this->component_lists[$component]))
          $this->component_lists[$component] = array ();
    return $this;
  }

  protected function clean_component_lists () {
    if (($args = array_filter (func_get_args ())) || ($args = array_keys ($this->component_lists)))
      foreach ($args as $arg)
        unset ($this->component_lists[$arg]);
    return $this;
  }

  protected function set_componemt_path () {
    $this->componemt_path = array_filter (func_get_args ());
    return $this;
  }

  protected function set_frame_path () {
    $this->frame_path = array_filter (func_get_args ());
    return $this;
  }

  protected function set_content_path () {
    $this->content_path = array_filter (func_get_args ());
    return $this;
  }

  protected function set_public_path () {
    $this->public_path = array_filter (func_get_args ());
    return $this;
  }

  protected function set_class ($class) {
    $this->class = strtolower (trim ($class));
    return $this;
  }

  protected function set_method ($method) {
    $this->method = strtolower (trim ($method));
    return $this;
  }

  protected function set_title ($title) {
    $this->title = $title;
    return $this;
  }

  protected function set_controllers_path () {
    $this->controllers_path = array_filter (func_get_args ());
    return $this;
  }

  protected function set_views_path () {
    $this->views_path = array_filter (func_get_args ());
    return $this;
  }

  protected function set_libraries_path () {
    $this->libraries_path = array_filter (func_get_args ());
    return $this;
  }

  protected function add_component_list ($key, $value) {
    if (isset ($this->component_lists[$key]))
      array_push ($this->component_lists[$key], $value);
    return $this;
  }

  public function add_javascript () {
    if ($path = array_filter (func_get_args ()))
      $this->add_component_list ('javascript', implode (DIRECTORY_SEPARATOR, $path));
    return $this;
  }

  public function add_css () {
    if ($path = array_filter (func_get_args ()))
      $this->add_component_list ('css', implode (DIRECTORY_SEPARATOR, $path));
    return $this;
  }

  protected function add_hidden ($attributes = array ()) {
    if ($attributes)
      $this->add_component_list ('hidden', $attributes);
    return $this;
  }

  protected function add_meta ($attributes = array ()) {
    if ($attributes)
      $this->add_component_list ('meta', $attributes);
    return $this;
  }

  public function get_componemt_path () {
    return $this->componemt_path;
  }

  public function get_frame_path () {
    return $this->frame_path; 
  }

  public function get_content_path () {
    return $this->content_path;
  }

  public function get_public_path () {
    return $this->public_path;
  }

  public function get_class () {
    return $this->class;
  }

  public function get_method () {
    return $this->method;
  }

  public function get_title () {
    return $this->title;
  }

  public function get_component_lists () {
    return $this->component_lists;
  }

  public function get_controllers_path () {
    return $this->controllers_path;
  }
  public function get_libraries_path () {
    return $this->libraries_path;
  }

  public function get_views_path () {
    return $this->views_path;
  }

  protected function is_post () {
    return ($this->input->post () === false) || !count ($_POST);
  }

  protected function is_ajax ($is_post = true) {
    return $this->input->is_ajax_request () && (!$is_post || $this->is_post ());
  }

  protected function input_get ($index = null, $xss_clean = true) {
    return $index = trim ($index) && ($gets = $this->input->get ()) && isset ($gets[$index]) ? $xss_clean ? $this->security->xss_clean ($gets[$index]) : $gets[$index] : null;
  }

  protected function input_post ($index = null, $xss_clean = true, $is_files = false) {
    return !$is_files ? $index = trim ($index) && ($posts = $this->input->post ()) && isset ($posts[$index]) ? $xss_clean ? $this->security->xss_clean ($posts[$index]) : $posts[$index] : null : $this->_getPostFiles (trim ($index));
  }

  private function _getPostFiles ($index) {
    if ($index && $_FILES) {
      preg_match_all ('/^(?P<var>\w+)(\s?\[\s?\]\s?)$/', $index, $matches);
      return ($matches = $matches['var'] ? $matches['var'][0] : null) ? get_upload_file ($matches) : get_upload_file ($index, 'one');
    } else {
      return null;
    }
  }

  protected function output_json ($data, $cache = 0) {
    $this->output->set_content_type ('application/json')->set_output (json_encode ($data))->cache ($cache);
  }

  protected function load_components () {
    $frame_data = array ();
    if ($components = !($components = array_filter (func_get_args ())) ? $component_lists_keys = array_keys ($component_lists = $this->get_component_lists ()) : array_filter ($components, function ($component) use ($component_lists_keys) { return in_array ($component, $component_lists_keys); }))
      foreach ($components as $component)
        if (is_readable (utilitySameLevelPath (FCPATH . APPPATH . DIRECTORY_SEPARATOR . implode (DIRECTORY_SEPARATOR, $this->get_views_path ()) . DIRECTORY_SEPARATOR . ($path = utilitySameLevelPath (implode (DIRECTORY_SEPARATOR, $this->get_componemt_path ()) . DIRECTORY_SEPARATOR . $component . EXT)))))
          $frame_data[$component] = $this->load->view ($path, array ($component . '_list' => $this->component_lists[$component]), true);
    return $frame_data;
  }
  
  protected function load_content ($data = '', $return = false) {
    if (is_readable ($abs_path = utilitySameLevelPath (FCPATH . APPPATH . DIRECTORY_SEPARATOR . implode (DIRECTORY_SEPARATOR, $this->get_views_path ()) . DIRECTORY_SEPARATOR . ($path = utilitySameLevelPath (implode (DIRECTORY_SEPARATOR, array_merge ($this->get_content_path (), array ($this->get_class (), $this->get_method (), 'content.php'))))))))
      if ($return) return $this->load->view ($path, $data, $return);
      else $this->load->view ($path, $data, $return);
    else
      show_error ('Can not find content file. path: ' . $abs_path);
  }

  protected function load_view ($data = '', $return = false, $cache_time = 0) {
    if (is_readable ($abs_path = utilitySameLevelPath (FCPATH . APPPATH . DIRECTORY_SEPARATOR . implode (DIRECTORY_SEPARATOR, $this->get_views_path ()) . DIRECTORY_SEPARATOR . ($path = utilitySameLevelPath (implode (DIRECTORY_SEPARATOR, array_merge ($this->get_frame_path (), array ('frame.php')))))))) {
      if ($this->get_class () && $this->get_method ()) {

        $this->add_css (base_url (utilitySameLevelPath (implode (DIRECTORY_SEPARATOR, array_merge (array (APPPATH), $this->get_views_path (), $this->get_public_path (), array ('public.css'))))))
             ->add_css (base_url (utilitySameLevelPath (implode (DIRECTORY_SEPARATOR, array_merge (array (APPPATH), $this->get_views_path (), $this->get_frame_path (), array ('frame.css'))))))
             ->add_css (base_url (utilitySameLevelPath (implode (DIRECTORY_SEPARATOR, array_merge (array (APPPATH), $this->get_views_path (), $this->get_content_path (), array ($this->get_class (), $this->get_method (), 'content.css'))))))

             ->add_javascript (base_url (utilitySameLevelPath (implode (DIRECTORY_SEPARATOR, array_merge (array (APPPATH), $this->get_views_path (), $this->get_public_path (), array ('public.js'))))))
             ->add_javascript (base_url (utilitySameLevelPath (implode (DIRECTORY_SEPARATOR, array_merge (array (APPPATH), $this->get_views_path (), $this->get_frame_path (), array ('frame.js'))))))
             ->add_javascript (base_url (utilitySameLevelPath (implode (DIRECTORY_SEPARATOR, array_merge (array (APPPATH), $this->get_views_path (), $this->get_content_path (), array ($this->get_class (), $this->get_method (), 'content.js'))))));
        
        $frame_data = array ();
        $frame_data = array_merge ($frame_data, $this->load_components ());
        $frame_data['title']   = $this->get_title ();
        $frame_data['content'] = $this->load_content ($data, true);

        if ($return) return $this->load->view ($path, $frame_data, $return);
        else $this->load->view ($path, $frame_data, $return)->cache ($cache_time);
      } else {
        show_error ('The controller lack of necessary resources!!  Please confirm your program again.');
      }
    } else {
      show_error ('Can not find frame file. path: ' . $abs_path);
    }
  }
}

class Site_controller extends Root_controller {
  public function __construct () {
    parent::__construct ();

    $this->set_componemt_path ('component', 'site')
         ->set_frame_path ('frame', 'site')
         ->set_content_path ('content', 'site')
         ->set_public_path ('public')
         ->set_title ('')
         ;

  }
}

class Admin_controller extends Root_controller {
  public function __construct () {
    parent::__construct ();
  
    $this->set_componemt_path ('component', 'admin')
         ->set_frame_path ('frame', 'admin')
         ->set_content_path ('content', 'admin')
         ->set_public_path ('public')
         ->set_title ('')
         ;
  }
}

// class OA_controller extends CI_controller {
//   private $view_paths = null;
//   private $components = null;

//   private $favicon = null;
//   private $title  = null;
//   private $class  = null;
//   private $method = null;

//   private $use_cache = null;
//   private $cache_prefix = null;
//   private $cache_options = null;

//   private $d4_redirect_method = null;

//   public function __construct ($view_paths) {
//     parent::__construct ();

//     $this->load->driver ('cache', array ('adapter' => 'apc', 'backup' => 'file'));

//     $this->load->helper ('form');
//     $this->load->helper ('url');
//     $this->load->helper ('html');
//     $this->load->helper ('file');
//     $this->load->helper ('view');
//     $this->load->helper ('cell');
//     $this->load->helper ('identity');

//     $this->load->helper ('type');
//     $this->load->helper ('error');
//     $this->load->helper ('path');
//     $this->load->helper ('upload_file');
//     $this->load->helper ('php_active');
//     $this->load->helper ('request');
//     $this->load->helper ('config');
//     $this->load->helper ('image');

//     $this->load->library ('identity');
//     $this->load->library ('OpenGraph');

//     $this->set_class ($this->router->fetch_class ());
//     $this->set_method ($this->router->fetch_method ());
//     $this->set_use_cache (false);
//     $this->set_cache_prefix ('_cache_');
//     $this->set_cache_options (array ('cache_sec' => 300, 'cache_key' => $this->class . '_' . $this->method));
//     $this->set_title ('');
//     $this->set_favicon ('');
//     $this->_initPaths ($view_paths);
//     $this->_initComponents ('javascript', 'css', 'meta', 'hidden', 'visit_menu', 'sidebar', 'topbar', 'footer');

//   }

//   protected function add_footer ($title = null, $submenus = array ()) {
//     if (!isset ($this->components['footer'][$key = verifyString ($title) ? $title : '']) || !verifyArray ($this->components['footer'][$key], null)) $this->components['footer'][$key] = array ();
//     if (verifyArray ($submenus)) foreach ($submenus as $submenu) array_push ($this->components['footer'][$key], array ('name' => $submenu[0], 'src' => verifyString ($submenu[1]) ? $submenu[1] : (verifyArray ($submenu[1]) ? base_url ($submenu[1]): null)));
//     return $this;
//   }

//   protected function add_navheader ($name, $path) {
//     if (verifyString ($name) && (verifyArray($path) || verifyString($path))) array_push ($this->components['topbar']['header'], array ('name' => $name, 'url' => verifyArray ($path) ? base_url ($path) : $path));
//     return $this;
//   }

//   protected function _utility_navitem ($items) {
//     if (verifyArray ($items, null)) {
//       $info = array_shift ($items);
//       $dropdowns = array ();
//       if (count ($items)) foreach ($items as $item) if (verifyArray ($utility_navitem = $this->_utility_navitem ($item))) array_push ($dropdowns, $utility_navitem);
//       return array ('name' => $info['name'], 'title' => isset ($info['title']) ? $info['title'] : null, 'target' => isset ($info['target']) ? $info['target'] : null, 'url' => isset ($info['url']) ? (verifyString ($info['url'], null) ? ($info['url'] == '' ? /*'#'*/null : $info['url']) : (verifyArray ($info['url'], null) ? (!count ($info['url']) ? /*'#'*/null : base_url ($info['url'])): null) ) : null, 'dropdowns' => $dropdowns);
//     } else { return null; }
//   }

//   protected function add_left_navitem ($info = null) {
//     if (verifyArrayFormat ($info, array ('name')) && (($num_args = func_num_args ()) > 0)) {
//       $items = array (); for ($i = 1; $i < $num_args; $i++) array_push ($items, func_get_arg ($i));
      
//       if (count ($items)) array_unshift ($items, $info);
//       else array_push ($items, $info);

//       if (count ($items) && verifyArray ($utility_navitem = $this->_utility_navitem ($items))) {
//         if (!isset ($this->components['topbar']['left'])) $this->components['topbar']['left'] = array ();
//         array_push ($this->components['topbar']['left'], $utility_navitem);
//       }
//     }
//     return $this;
//   }

//   protected function add_right_navitem ($info = null) {
//     if (verifyArrayFormat ($info, array ('name')) && (($num_args = func_num_args ()) > 0)) {
//       $items = array (); for ($i = 1; $i < $num_args; $i++) array_push ($items, func_get_arg ($i));
      
//       if (count ($items)) array_unshift ($items, $info);
//       else array_push ($items, $info);

//       if (count ($items) && verifyArray ($utility_navitem = $this->_utility_navitem ($items))) {
//         if (!isset ($this->components['topbar']['right'])) $this->components['topbar']['right'] = array ();
//         array_unshift ($this->components['topbar']['right'], $utility_navitem);
//       }
//     }
//     return $this;
//   }

//   protected function load_components () {
//     $frame_data = array ();
//     $params = array (); for ($i = 1; ($i < func_num_args ()) && verifyString ($param = func_get_arg ($i)); $i++) array_push ($params, $param);
//     if (!verifyArray ($params)) $params = array_keys ($this->components);
//     if (count ($params)) foreach ($params as $param) $frame_data[$param] = $this->load->view ($this->view_paths['component'] . DIRECTORY_SEPARATOR . $param, array ($param . '_list' => $this->get_component ($param)), true);
//     return $frame_data;
//   }

//   protected function load_content ($data = '', $return = false, $content_name = 'content') {
//     $view_path = $this->view_paths['content'] . DIRECTORY_SEPARATOR . $this->get_class () . DIRECTORY_SEPARATOR . $this->get_method () . DIRECTORY_SEPARATOR . $content_name . EXT;
//     if (!$return) $this->load->view ($view_path, $data, $return);
//     else return $this->load->view ($view_path, $data, $return);
//   }

//   protected function load_view ($data = '', $return = false, $cache_time = 0, $cache_append_path = null, $content_name = 'content', $frame_name = 'frame', $public_name = 'public') {
//     if (verifyString ($this->class) && verifyString ($this->method)) {
    
//     $this->add_css ('application', 'views', $this->view_paths['public'], $public_name . '.css')
//          ->add_javascript ('application', 'views', $this->view_paths['public'], $public_name . '.js')
//          ->add_css ('application', 'views', $this->view_paths['frame'], 'frame' . '.css')
//          ->add_javascript ('application', 'views', $this->view_paths['frame'], 'frame' . '.js')
//          ->add_css ('application', 'views', $this->view_paths['content'], $this->get_class (), $this->get_method (), $content_name . '.css')
//          ->add_javascript ('application', 'views', $this->view_paths['content'], $this->get_class (), $this->get_method (), $content_name . '.js');

//       $frame_data = array ();
//       $frame_data = array_merge ($frame_data, $this->load_components ());
//       $frame_data['title']   = $this->title;
//       $frame_data['favicon'] = $this->favicon;
//       $frame_data['content'] = $this->load_content ($data, true, $content_name);

//       if (!$return) {
//         $this->load->view ($this->view_paths['frame'] . DIRECTORY_SEPARATOR . $frame_name, $frame_data, $return);
//         if (verifyNumber ($cache_time, 1)) $this->output->cache ($cache_time, $cache_append_path);
//       }
//       else {
//         return $this->load->view ($this->view_paths['frame'] . DIRECTORY_SEPARATOR . $frame_name, $frame_data, $return);
//       }
//     } else {
//       showError ('The OA_Controller lack of necessary resources!!  Please confirm your program again.');
//     }
//   }

//   protected function set_favicon ($favicon) { if (verifyString ($favicon)) $this->favicon = $favicon; return $this; }
//   protected function get_favicon () { return $this->favicon; }
//   protected function set_title ($title) { if (verifyString ($title)) $this->title = $title; return $this; }
//   protected function get_title () { return $this->title; }
//   public function set_class ($class) { if (verifyString ($class)) $this->class = strtolower ($class); return $this; }
//   public function get_class () { return strtolower ($this->class); }
//   public function set_method ($method) { if (verifyString ($method)) $this->method = strtolower ($method); return $this; }
//   public function get_method () { return strtolower ($this->method); }

//   protected function input_get ($index = null, $xss_clean = true) { return (verifyString ($index) && verifyBoolean ($xss_clean)) ? $this->input->get ($index, $xss_clean) : null; }
//   protected function input_post ($index = null, $xss_clean = true, $is_files = false) { return (verifyString ($index) && verifyBoolean ($xss_clean) && verifyBoolean ($is_files)) ? ($is_files ? $this->_getPostFiles ($index) : $this->input->post ($index, $xss_clean)) : null; }

//   protected function is_post () { return ($this->input->post () === false) || verifyArray ($_POST, 0, 0) ? false : true; }
//   protected function is_ajax ($is_post = true) { return $this->input->is_ajax_request () && (!$is_post || ($is_post && $this->is_post ())) ? true : false; }
  
//   protected function file_url ($fileName, $is_auto = true) { return $is_auto ? base_url (array_map (function ($f) { return trim ($f, '/'); }, verifyArray ($fileName) ? (array_unshift ($fileName, RESOURCE_FILE_REL_PATH) ? $fileName : array ()): array (RESOURCE_FILE_REL_PATH, $this->class, $fileName))) : (verifyArray ($fileName) ? base_url (array_map (function ($f) { return trim ($f, '/'); }, $fileName)) : $fileName); }

//   public function set_use_cache ($use_cache) { if (verifyBoolean ($use_cache)) $this->use_cache = $use_cache; return $this; }
//   public function get_use_cache () { return $this->use_cache; }

//   public function get_d4_redirect_method () { return strtolower ($this->d4_redirect_method); }
//   public function set_d4_redirect_method ($d4_redirect_method) { if (verifyString ($d4_redirect_method)) $this->d4_redirect_method = strtolower ($d4_redirect_method); return $this; }

//   public function get_cache_prefix () { return $this->cache_prefix; }
//   public function set_cache_prefix ($cache_prefix) { if (verifyString ($cache_prefix)) $this->cache_prefix = $cache_prefix; return $this; }

//   public function get_cache_options () { return $this->cache_options; }
//   public function set_cache_options ($cache_options) { if (verifyArrayFormat ($cache_options, array ('cache_sec', 'cache_key'))) $this->cache_options = $cache_options; return $this; }

//   public function set_cache ($use_cache, $cache_prefix = '_cache_') {
//     if (!verifyBoolean ($use_cache)) showError ("The 'use_cache' must be boolean variable! Please confirm your program again.");
//     if (!verifyString ($cache_prefix)) showError ("The 'cache_prefix' must be string variable! Please confirm your program again.");
    
//     $this->use_cache = $use_cache;
//     $this->cache_prefix = $cache_prefix;
//     return $this;
//   }

//   private function _getPostFiles ($index) {
//     if (verifyString ($index)) {
//       preg_match_all ('/^(?P<var>\w+)(\s?\[\s?\]\s?)$/', $index, $matches);
//       $matches = count ($matches['var']) ? $matches['var'][0] : null;
//       return (verifyString ($matches)) ? get_upload_file ($matches) : get_upload_file ($index, 'one');
//     } else { return null; }
//   }

//   protected function get_component ($key) { return verifyArrayFormat ($this->components, array ($key)) ? $this->components[$key] : array (); }

//   protected function add_sidebar ($title = null, $submenus = array ()) {
//     if (!isset ($this->components['sidebar'][$key = verifyString ($title) ? $title : '']) || !verifyArray ($this->components['sidebar'][$key], null)) $this->components['sidebar'][$key] = array ();
//     if (verifyArray ($submenus)) foreach ($submenus as $submenu) array_push ($this->components['sidebar'][$key], array ('name' => $submenu[0], 'src' => verifyString ($submenu[1]) ? $submenu[1] : (verifyArray ($submenu[1]) ? base_url ($submenu[1]): null)));
//     return $this;
//   }

//   protected function add_visit_menu ($name, $src = null, $class = null) {
//     if (verifyString ($name)) array_push ($this->components['visit_menu'], array ('name' => $name, 'src' => ((verifyArray ($src) && verifyArray (array_map ('utilityPath', $src)) && verifyString ($src = implode ('/', $src))) || verifyString ($src)) && (preg_match_all ("/^(https?:\/\/?)/", $src = utilityPath ($src), $matches) || verifyString ($src = base_url (array ($src = utilityPath ($src))))) ? $src : null, 'class' => verifyString ($class) ? $class : null));
//     return $this;
//   }

//   protected function add_hidden ($name, $id, $value, $class = null) {
//     if (verifyString ($name) && verifyString ($id) && verifyNotNull ($value)) array_push ($this->components['hidden'], array ('name' => $name, 'id' => $id, 'value' => $value, 'class' => verifyString ($class) ? $class : null));
//     return $this;
//   }

//   protected function add_meta ($name, $content, $type = 'name', $newline = true) {
//     if (verifyString ($name) && verifyString ($content) && verifyString ($type) && verifyBoolean ($newline)) {
//       if (verifyArray ($this->components['meta'])) foreach ($this->components['meta'] as $i => $value) if ($value['name'] == $name) ($this->components['meta'][$i]['content'] = $content) && !($content = null);
//       if ($content) array_push ($this->components['meta'], array ('name' => $name, 'content' => $content, 'type' => $type, 'newline' => $newline));
//     }
//     return $this;
//   }

//   protected function add_javascript () {
//     $src = array (); for ($i = 0; ($i < func_num_args ()) && verifyString ($param = func_get_arg ($i)); $i++) array_push ($src, $param);
//     if (verifyString ($src = implode ('/', $src))) array_push ($this->components['javascript'], array ('exist' => preg_match_all ("/^(https?:\/\/?)/", $src = utilityPath ($src), $matches) || (verifyString ($src = utilityPath ($src)) && verifyFileReadable (FCPATH . $src) && verifyString ($src = base_url (array ($src)))) ? true : false, 'src' => $src));
//     return $this;
//   }

//   protected function add_css () {
//     $src = array (); for ($i = 0; ($i < func_num_args ()) && verifyString ($param = func_get_arg ($i)); $i++) array_push ($src, $param);
//     if (verifyString ($src = implode ('/', $src))) array_push ($this->components['css'], array ('exist' => preg_match_all ("/^(https?:\/\/?)/", $src = utilityPath ($src), $matches) || (verifyString ($src = utilityPath ($src)) && verifyFileReadable (FCPATH . $src) && verifyString ($src = base_url (array ($src)))) ? true : false, 'src' => $src));
//     return $this;
//   }

//   protected function clear_component () {
//     $params = array (); for ($i = 0; ($i < func_num_args ()) && verifyString ($param = func_get_arg ($i)); $i++) array_push ($params, $param);
//     if (verifyArray ($params)) foreach ($params as $param) if (verifyItemInArray ($param, array_keys ($this->components))) $this->components[$param] = array ();
//     return $this;
//   }

//   private function _initComponents () {
//     $params = array ();
//     for ($i = 0; ($i < func_num_args ()) && verifyString ($param = func_get_arg ($i)); $i++)
//       !verifyArray ($now_vars = array_keys (get_object_vars ($this))) || !verifyItemInArray ($param, $now_vars) ? array_push ($params, $param) : showError ('Component 變數名稱有重複 或與 物件內變數重複!');

//     $this->components = array ();
//     if (verifyArray ($params))
//       foreach ($params as $param)
//         if (verifyFileReadable (FCPATH . APPPATH . 'views' . DIRECTORY_SEPARATOR . $this->view_paths['component'] . DIRECTORY_SEPARATOR . $param . EXT)) $this->components[$param] = array ();
//         else showError ('Component 檔案不存在 或 不可讀取! Path: ' . FCPATH . APPPATH . 'views' . DIRECTORY_SEPARATOR . $this->view_paths['component'] . DIRECTORY_SEPARATOR . $param . EXT);

//     return $this->clear_component ();
//   }

//   private function _initPaths ($view_paths) {
//     if (!verifyArrayFormat ($view_paths = array_map ('utilityPath', $view_paths), array ('frame', 'component', 'content', 'public'))) showError ('view 各項路徑陣列格式有誤!');
//     array_walk ($view_paths, function ($key, $path) { if (!verifyFolderReadable ( FCPATH . APPPATH . 'views' . DIRECTORY_SEPARATOR . utilityPath ($path))) showError ('view 下的 ' . $key . ' 路徑有誤 或 不可讀取! Path: ' . FCPATH . APPPATH . 'view' . DIRECTORY_SEPARATOR . $path); });
//     $this->view_paths = $view_paths;

//     return $this;
//   }

//   protected function output_json ($data, $cache = 0, $path = null) {
//     $this->output->set_content_type ('application/json')->set_output (json_encode (verifyArray ($data) ? $data : array ('status' => false, 'message' => 'Warning! No Output Json Data!!')))->cache ($cache, $path);
//   }
  
//   protected function delete_output_cache () {
//     $params = func_get_args ();
//     return $this->output->delete_cache (verifyArray ($params) ? implode ('/', $params) : '');
//   }
  
//   protected function delete_all_cache () {
//     return $this->output->delete_all_cache ();
//   }


//   public function _remap ($method, $params) {
//     if (!verifyString ($method) || !verifyArray ($params, null) || (strtolower ($method) != strtolower ($this->method))) 
//       showError ("The Controller happen unknown error... Please confirm your program again.");

//     if (!in_array (strtolower ($method), array_map ('strtolower', get_class_methods ($this)))) {
//       if (verifyString ($d4_redirect_method = $this->get_d4_redirect_method ()) && in_array ($d4_redirect_method, array_map ('strtolower', get_class_methods ($this)))) {
//         array_unshift ($params, $method); $method = $d4_redirect_method;
//       } else { show_404 (); }
//     }

//     if (verifyBoolean ($this->use_cache, true) && verifyString ($this->cache_prefix) && verifyString ($cache_method = $this->cache_prefix . $method) && in_array (strtolower ($cache_method), array_map ('strtolower', get_class_methods ($this))) && verifyArrayFormat ($cache_options = array_merge ($this->cache_options, call_user_func_array (array ($this, $cache_method), $params)), array ('cache_sec', 'cache_key'))) {
//       if (!($view = $this->cache->file->get ($cache_options['cache_key']))) {
//         ob_start ();
//         call_user_func_array (array ($this, $method), $params);
//         $view = ob_get_contents ();
//         ob_end_clean ();
//         $res = $this->cache->file->save ($cache_options['cache_key'], $view, $cache_options['cache_sec']);
//       }
//       echo $view;
//     } else {
//       call_user_func_array (array ($this, $method), array_slice ($params, 0));
//     }
//   }

// }

// class Delay_controller extends OA_controller {
//   public function __construct ($view_paths = array ('frame' => 'frame/site', 'component' => 'component/site', 'content' => 'content/site', 'public' => 'public')) {
//     parent::__construct ($view_paths);
//     if (!$this->_initAuthenticate ()) showError ('驗證錯誤！！');
//   }

//   private function _initAuthenticate () {
//     return md5 (config ('d4_config', 'delay_request', 'request_code_value')) == $this->input_post (config ('d4_config', 'delay_request', 'request_code_key')) ? true : false;
//   }
// }

// class Site_controller extends OA_controller {
//   private $pagination_config = null;
//   private $run_time_start = null;
//   private $list_limit = null;
  
//   public function __construct ($view_paths = array ('frame' => 'frame/site', 'component' => 'component/site', 'content' => 'content/site', 'public' => 'public')) {
//     parent::__construct ($view_paths);
//     $this->load->library ('fb');

//     $this->_initTitle ('')
//          ->_initMeta ()
//          ->_initCss ()
//          ->_initJavascript ()
//          ->_initHidden ()

//          ->_initTopbar ()
//          ->_initVisitMenu ()
//          ->_initFooter ();

//   }
//   private function _initTitle ($title = '') {
//     return $this->set_title ($title);
//   }

//   private function _initMeta () {
//     return $this->add_meta ('Content-type', 'text/html; charset=utf-8', 'http-equiv')
//                 ->add_meta ('fb:admins', config ('facebook_config', 'admins'), 'property')
//                 ->add_meta ('fb:app_id', config ('facebook_config', 'appId'), 'property')

//                 ->add_meta ('og:title', '北港媽祖', 'property')
//                 ->add_meta ('og:description', '北港媽祖', 'property')
//                 ->add_meta ('og:site_name', '北港媽祖', 'property')

//                 ->add_meta ('og:image', base_url (array ('resource', 'image', 'og', 'image1.jpg')), 'property')
//                 ->add_meta ('og:locale', 'zh_TW', 'property')
//                 ->add_meta ('og:type', 'website', 'property')
//                 ->add_meta ('og:url', current_url (), 'property')

//                 ->add_meta ('description', '北港媽祖')
//                 ->add_meta ('keywords', '北港媽祖|北港三月十九|北港藝閣|北港廟會')
//          ;
//   }
//   private function _initCss () {
//     return $this->add_css (RESOURCE_CSS_REL_PATH, 'bootstrap_v3.0.0', 'bootstrap.css')
//                 ->add_css (RESOURCE_CSS_REL_PATH, 'bootstrap_v3.0.0', 'bootstrap-glyphicons.min.css')

//                 ->add_css (RESOURCE_CSS_REL_PATH, 'icomoon_d20140128', 'icomoon.css')
//                 ->add_css (RESOURCE_CSS_REL_PATH, 'jquery-ui-1.10.3.custom', 'redmond', 'jquery-ui-1.10.3.custom.min.css')
//                 ->add_css (RESOURCE_CSS_REL_PATH, 'OA-ui_v1.3', 'OA-ui.css')
//                 ->add_css (RESOURCE_CSS_REL_PATH, 'timepicker', 'jquery-ui-timepicker-addon.css')

//                 ->add_css (RESOURCE_CSS_REL_PATH, 'fancyBox_v2.1.5', 'jquery.fancybox.css')
//                 ->add_css (RESOURCE_CSS_REL_PATH, 'fancyBox_v2.1.5', 'jquery.fancybox-buttons.css')
//                 ->add_css (RESOURCE_CSS_REL_PATH, 'fancyBox_v2.1.5', 'jquery.fancybox-thumbs.css')
//                 ->add_css (RESOURCE_CSS_REL_PATH, 'jquery.jgrowl', 'jquery.jgrowl.css')
                
//                 // ->add_css (RESOURCE_CSS_REL_PATH, 'jstarbox', 'jstarbox.css')

//                 ;
//   }
//   private function _initJavascript () {
//     return $this->add_javascript (RESOURCE_JS_REL_PATH, 'jquery_v1.10.2', 'jquery-1.10.2.min.js')
//                 ->add_javascript (RESOURCE_JS_REL_PATH, 'jquery-ui-1.10.3.custom', 'jquery-ui-1.10.3.custom.min.js')
//                 ->add_javascript (RESOURCE_JS_REL_PATH . 'timepicker', 'jquery-ui-timepicker-addon.js')

//                 ->add_javascript (RESOURCE_JS_REL_PATH, 'OA-ui_v1.3', 'OA-ui.js')
//                 ->add_javascript (RESOURCE_JS_REL_PATH, 'bootstrap_v3.0.0', 'bootstrap.min.js')
//                 ->add_javascript (RESOURCE_JS_REL_PATH, 'imgLiquid_v0.9.944', 'imgLiquid-min.js')

//                 ->add_javascript (RESOURCE_JS_REL_PATH, 'jquery-timeago_v1.3.1', 'jquery.timeago.js')
//                 ->add_javascript (RESOURCE_JS_REL_PATH, 'jquery-timeago_v1.3.1', 'locales', 'jquery.timeago.zh-TW.js')

//                 ->add_javascript (RESOURCE_JS_REL_PATH . 'fancyBox_v2.1.5', 'jquery.fancybox.js')
//                 ->add_javascript (RESOURCE_JS_REL_PATH . 'fancyBox_v2.1.5', 'jquery.fancybox-buttons.js')
//                 ->add_javascript (RESOURCE_JS_REL_PATH . 'fancyBox_v2.1.5', 'jquery.fancybox-thumbs.js')
//                 ->add_javascript (RESOURCE_JS_REL_PATH . 'fancyBox_v2.1.5', 'jquery.fancybox-media.js')

//                 ->add_javascript (RESOURCE_JS_REL_PATH . 'masonry_v3.1.2', 'masonry.pkgd.min.js')
//                 ->add_javascript (RESOURCE_JS_REL_PATH . 'infobubble-v3', 'infobubble-compiled.js')
//                 ->add_javascript (RESOURCE_JS_REL_PATH . 'jquery.jgrowl', 'jquery.jgrowl.js')
                
//                 // ->add_javascript (RESOURCE_JS_REL_PATH . 'jstarbox', 'jstarbox.js')
//                 ;
//   }

//   private function _initHidden () {
//     return $this;
//   }

//   private function _initTopbar () {
//     $this->add_left_navitem (array ('name' => '<span class="icon-home"></span> 網站首頁', 'title' => '網站首頁', 'url' => base_url ()));
//     $this->add_left_navitem (array ('name' => null));
//     $this->add_left_navitem (array ('name' => '<span class=" icon-pin-alt"></span> 地圖', 'title' => '地圖', 'url' => array ('units')));
//     // $this->add_left_navitem (array ('name' => null));
//     // $this->add_left_navitem (array ('name' => '<span class="icon-map5"></span> 三月十九 繞境地圖', 'title' => '三月十九 Google Map 版本！', 'url' => array ('google_map', 'beigang_319')));
//     // $this->add_left_navitem (array ('name' => null));
//     // $this->add_left_navitem (array ('name' => '<span class="icon-map5"></span> 三月二十 繞境地圖', 'title' => '三月二十 Google Map 版本！', 'url' => array ('google_map', 'beigang_320')));
//     // $this->add_left_navitem (array ('name' => null));
//     // $this->add_left_navitem (array ('name' => '<span class="icon-info-large-outline"></span> 使用說明', 'title' => '關於本網站使用說明以及相關介紹！', 'url' => array ('main_index', 'others')));
//     // $this->add_left_navitem (array ('name' => null));

//     $this->add_right_navitem (array ('name' => '<span class="icon-exit"></span>', 'title' => '', 'url' => array ('platform', 'sign_out')));
//     $this->add_right_navitem (array ('name' => '<span class="icon-facebook22"></span>', 'title' => 'Facebook 登入', 'url' => $this->fb->getLoginUrl (array ('redirect_uri' => base_url (array ('platform', 'fb_sign_in', 'main_index|index'))))));
//     // $this->add_right_navitem (array ('name' => null));
//     // $this->add_right_navitem (array ('name' => '<span id="reciprocal" data-duration="' . (strtotime ('2014-04-18 00:00:00') - strtotime (date ('Y-m-d H:i:s'))) . '" data-format="歲次 甲午年 三月十九日 還有 %s" data-message="就是現在，北港廟會開始囉！"></span>', 'title' => '大家快一起來倒數吧！', 'url' => ''));
    
//     return $this;
//   }

//   private function _initVisitMenu () {
//     return $this;
//   }
 
//   private function _initFooter () {
//     return $this
//             ;
//   }

//   protected function set_pagination () {
//     return $this->set_pagination_list_limit (15)->set_pagination_config ('page_query_string', true)->set_pagination_config ('query_string_segment', 'per_page')->set_pagination_config ('num_links', 5)->set_pagination_config ('base_url', base_url (array ($this->get_class (), $this->get_method ())))->set_pagination_config ('first_link', '第一頁')->set_pagination_config ('last_link', '最後頁')->set_pagination_config ('prev_link', '上一頁')->set_pagination_config ('next_link', '下一頁')->set_pagination_config ('uri_segment', 3)->set_pagination_config ('full_tag_open', '<ul class="pagination">')->set_pagination_config ('full_tag_close', '</ul>')->set_pagination_config ('first_tag_open', '<li>')->set_pagination_config ('first_tag_close', '</li>')->set_pagination_config ('prev_tag_open', '<li>')->set_pagination_config ('prev_tag_close', '</li>')->set_pagination_config ('num_tag_open', '<li>')->set_pagination_config ('num_tag_close', '</li>')->set_pagination_config ('cur_tag_open', '<li class="active"><a href="#">')->set_pagination_config ('cur_tag_close', '<span class="sr-only">(current)</span></a></li>')->set_pagination_config ('next_tag_open', '<li>')->set_pagination_config ('next_tag_close', '</li>')->set_pagination_config ('last_tag_open', '<li>')->set_pagination_config ('last_tag_close', '</li>')->set_pagination_config ('page_query_string', false);
//   }

//   protected function init_pagination () {
//     if ($this->get_pagination_config ()) {
//       if (!(isset ($this->pagination) && is_object ($this->pagination))) $this->load->library ('pagination');
//       $this->pagination->initialize ($this->get_pagination_config ());
//       return $this->pagination->create_links ();
//     } else { return ''; }
//   }

//   protected function get_pagination_config () {
//     return is_array ($this->pagination_config) ? $this->pagination_config : null;
//   }

//   protected function set_pagination_config ($key, $value) {
//     if ($this->pagination_config == null) $this->pagination_config = array ();
//     $this->pagination_config[$key] = $value;
//     return $this;
//   }

//   protected function set_run_time_start () {
//     $this->run_time_start = microtime (true);
//     return $this;
//   }
//   protected function get_run_time () {
//     return '耗時: ' . (isset ($this->run_time_start) ? (microtime (true) - $this->run_time_start) < 1 ? microtime (true) - $this->run_time_start : gmdate ("H小時 i分鐘 s", microtime (true) - $this->run_time_start) : 0) . '秒';
//   }

//   protected function set_pagination_list_limit ($list_limit = 30) {
//     $this->set_pagination_config ('per_page', $list_limit)->list_limit = $list_limit;
//     return $this;
//   }
//   protected function get_pagination_list_limit ($list_limit = 30) {
//     return isset ($this->list_limit) && $this->list_limit > 0 ? $this->list_limit : 30;
//   }
// }

// class Admin_controller extends Site_controller {
//   private $has_append_condition = null;

//   public function __construct ($view_paths = array ('frame' => 'frame/admin', 'component' => 'component/admin', 'content' => 'content/admin', 'public' => 'public')) {
//     parent::__construct ($view_paths);

//     if (!$this->identity->get_identity ('admins')) { redirect (array ('main_index')); }

//     $this->set_run_time_start ()
//          ->set_pagination ()
//          ->set_pagination_config ('base_url', base_url (array ('admin', $this->get_class (), $this->get_method ())))
//          ->set_pagination_config ('uri_segment', 4)
         
//          ->add_sidebar ('景點', array (
//                   array ('景點列表', array ('admin', 'units')),
//                   array ('留言列表', array ('admin', 'unit_comments')),
//                   array ('建議列表', array ('admin', 'unit_advices')),
//                   array ('標籤列表', array ('admin', 'unit_tags')),
//                   )
//              )
//          ->add_sidebar ('紀錄', array (
//                   array ('錯誤列表', array ('admin', 'errors')),
//                   )
//              )
//              ;
//   }

//   protected function get_has_append_condition () { return $this->has_append_condition; }
//   protected function set_has_append_condition ($value) { $this->has_append_condition = $value; return $this; }
  
//   protected function append_condition ($has_append_condition, $sql, $conditions, $value) {
//     if ($has_append_condition) $this->set_has_append_condition (true);

//     if (!isset ($sql['conditions'])) { $sql['conditions'] = array (); }
//     if (!isset ($sql['conditions'][0])) { $sql['conditions'][0] = ''; }
//     $sql['conditions'][0] .= (verifyString ($sql['conditions'][0]) ? ' AND ' : '') . $conditions;
//     for ($i = 3; $i < func_num_args (); $i++) { array_push ($sql['conditions'], func_get_arg ($i)); }
//     return $sql;
//   }
//   protected function append_search_condition (&$sql, $type, $column_name, $value, $has_append_condition = true) {
//     switch ($type) {
//       case 'Number': case 'number': if (verifyNumber ($value)) { $sql = $this->append_condition ($has_append_condition, $sql, $column_name . ' = ?', $value); } else { $value = null; } break;
//       case 'LikeString': case 'like_string': if (verifyString ($value)) { $sql = $this->append_condition ($has_append_condition, $sql, $column_name . ' like CONCAT("%", ? ,"%")', $value); } else { $value = null; } break;
//       case 'String': case 'string': if (verifyString ($value)) { $sql = $this->append_condition ($has_append_condition, $sql, $column_name . ' = ?', $value); } else { $value = null; } break;
//       case 'NotInArray': case 'not_in_array': if (verifyArray ($value)) { $sql = $this->append_condition ($has_append_condition, $sql, $column_name . ' not in (?)', $value); } else { $value = null; } break;
//       case 'InArray': case 'in_array': if (verifyArray ($value)) { $sql = $this->append_condition ($has_append_condition, $sql, $column_name . ' in (?)', $value); } else { $value = null; } break;
//       case 'NotString': case 'not_string': if (verifyString ($value, null)) { $sql = $this->append_condition ($has_append_condition, $sql, $column_name . ' != ?', $value); } else { $value = null; } break;
//       case 'IsNot': case 'is_not': $sql = $this->append_condition ($has_append_condition, $sql, $column_name . ' IS NOT ?', $value); break;
      
//       default: $value = null; break;
//     }
//     return $value;
//   }
// }
