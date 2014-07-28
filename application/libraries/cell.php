<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @author      OA Wu <comdan66@gmail.com>
 * @copyright   Copyright (c) 2014 OA Wu Design
 */
class Cell {
  private $CI = null;
  private $is_enabled = null;
  private $controller_folder = null;
  private $cache_folder = null;

  public function __construct ($configs = array ()) {
    $this->CI =& get_instance ();
    
    $this->CI->load->helper ('config');
    $this->CI->load->driver ('cache', array ('adapter' => 'apc', 'backup' => 'file'));
    $this->is_enabled = config ('cell_config', 'is_enabled');
    $this->controller_folder = utilitySameLevelPath (FCPATH . config ('cell_config', 'controller_folder'));
    $this->cache_folder = utilitySameLevelPath (config ('cell_config', 'cache_folder'));

    $this->cache_prefix = strlen ($cache_prefix = config ('cell_config', 'method_prefix')) ? $cache_prefix : null;
  }

  private function get_cache_options ($class, $method, $params = array ()) {
    if ($this->is_enabled && strlen ($cache_prefix)) {
      if (verifyFileReadable ($file = utilitySameLevelPath ($this->controller_folder . DIRECTORY_SEPARATOR . ($class = strtolower ($class)) . EXT))) {
        require_once ($file);
        $class = ucfirst ($class);
        $object = new $class ();
        $method = $cache_prefix . $method;

        if (method_exists ($object, $method)) return $data = call_user_func_array (array ($object, $method), $params);
        return null;
      } else { showError ("The Cell's controllers is not exist or can't read! File: " . $file); }
    } else { return null; }
  }

  public function render_cell ($class, $method, $params = array ()) {
    if (preg_match_all ('/(' . config ('cell_config', 'class_suffix') . ')$/', $class) == 1) {
      if (verifyFileReadable ($file = utilitySameLevelPath ($this->controller_folder . DIRECTORY_SEPARATOR . ($class = strtolower ($class)) . EXT))) {
        require_once ($file);
        $class = ucfirst ($class);
        $object = new $class ();
        
        if (method_exists ($object, $method)) {
          $option = array ();
          if ($this->is_enabled && ($this->cache_prefix !== null) && method_exists ($object, $cache_method = $this->cache_prefix . $method) && verifyArrayFormat ($option = call_user_func_array (array ($object, $cache_method), $params), array ('time', 'key'))) {
            if (!verifyNumber ($option['time'], 1)) $option['time'] = config ('cell_config', 'd4_time');
            $option['key'] = config ('cell_config', 'file_prefix') . '_|_' . $class . '_|_' . $method . (isset ($option['key']) ? '_|_' . $option['key'] : '');
            $option['key'] = strtolower ($option['key']);
          }
          if (!count ($option) || !($view = $this->CI->cache->file->get ($option['key'], $this->cache_folder))) {
            $view = call_user_func_array (array ($object, $method), $params);
            if (count ($option))
            $res = $this->CI->cache->file->save ($option['key'], $view, $option['time'], $this->cache_folder);
          }
          return $view;
        } else showError ("The class: " . $file . " not exist method: " . $method);
      } else { showError ("The Cell's controllers is not exist or can't read! File: " . $file); }
    } else { showError ("The class name doesn't have suffix, class name: " . $class . ", suffix: " . config ('cell_config', 'class_suffix')); }
  }

  public function clear_cell ($class, $method, $key = null) {
    $key = config ('cell_config', 'file_prefix') . '_|_' . $class . '_|_' . $method . (isset ($key) ? '_|_' . $key : '');
    @$this->CI->cache->file->delete ($key, $this->cache_folder);
  }

  public function clean_cell () {
    @$this->CI->cache->file->clean ($this->cache_folder);
  }
}

class Cell_Controller {
  private $view_folder = null;

  public function __construct () {
    $this->view_folder = utilitySameLevelPath (FCPATH . config ('cell_config', 'view_folder'));
  }

  protected function load_view ($data = array ()) {
    $trace = debug_backtrace (DEBUG_BACKTRACE_PROVIDE_OBJECT);
    if (isset ($trace) && count ($trace) > 1 && isset ($trace[1]) && isset ($trace[1]['class']) && isset ($trace[1]['function']) && is_string ($class = strtolower ($trace[1]['class'])) && is_string ($method = strtolower ($trace[1]['function'])) && strlen ($class) && strlen ($method)) {
      if (verifyFileReadable ($_ci_path = utilitySameLevelPath ($this->view_folder . DIRECTORY_SEPARATOR . $class . DIRECTORY_SEPARATOR . $method . EXT))) {
        extract ($data);
        ob_start();

        if (((bool)@ini_get('short_open_tag') === FALSE) && (config_item('rewrite_short_tags') == TRUE)) {
          echo eval('?>'.preg_replace("/;*\s*\?>/", "; ?>", str_replace('<?=', '<?php echo ', file_get_contents($_ci_path))));
        } else {
          include ($_ci_path);
        }

        $buffer = ob_get_contents ();
        @ob_end_clean ();
        return $buffer;
      } else { showError ("The Cell's controllers is not exist or can't read! File: " . $file); }
    } else { showError ('The debug_backtrace Error!'); }
  }
}