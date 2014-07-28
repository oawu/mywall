<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once 'TypeVerify.php';

class WebStreamUtility extends TypeVerify {
  private $d4_options   = null;
  private $obj          = null;
  private $fileUrl      = null;
  private $isError      = true;

  public function __construct ($fileUrl = null, $options = array ()) {
    if ($this->verifyString ($fileUrl) && $this->verifyArray ($options, 0)) {
      $this->_initD4Variable ();
      $this->_setOptions ($options);
      $this->_setSavePath ();
      
      if (!$this->verifyFolderWriteable ($this->options['temp_folder'])) $this->showError ("<fr>Error!</fr> The temp folder path is not exist or not folder or can not be <fr>write</fr>!\nFolder path : " . $this->options['absolute_path'] . "\nPlease confirm your program again.");
      if (!$this->verifyFolderWriteable ($this->options['absolute_path'])) $this->showError ("<fr>Error!</fr> The save folder base path is not exist or not folder or can not be <fr>write</fr>!\nFolder path : " . $this->options['absolute_path'] . "\nPlease confirm your program again.");

      $this->fileUrl = $fileUrl;
      $this->isError = false;
      $this->obj = $this;
    }
  }
  
  public function download ($fileName = null, $is_path = false, $is_use_reffer = false, $cainfo = null) {
    if ($this->isError) $this->showError ("<fr>Error!</fr> This object not yet fully initialized!\nPlease confirm your program again.");

    $temp_file = null;
    set_time_limit ($this->options['time_limit']);

    if ($this->isExist ($cainfo)) {
      $this->fileUrl  = str_replace (' ', '%20', $this->fileUrl);

      $options = array (
        CURLOPT_URL            => $this->fileUrl,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HEADER         => false,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_USERAGENT      => "Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/32.0.1700.76 Safari/537.36", // who am i
        CURLOPT_AUTOREFERER    => true,
        CURLOPT_CONNECTTIMEOUT => $this->options['time_limit'],
        CURLOPT_TIMEOUT        => 120,
        CURLOPT_MAXREDIRS      => 10
      );

      if ($this->verifyFileReadable ($cainfo)) $options[CURLOPT_CAINFO] = $cainfo;

      if ($is_use_reffer) $options[CURLOPT_REFERER] = $this->fileUrl;

      $ch = curl_init ($this->fileUrl);
      curl_setopt_array ($ch, $options);
      $data = curl_exec ($ch);
      curl_close ($ch);

      $temp_file = tempnam ($this->options['temp_folder'], $this->options['temp_prefix']);
      $write = fopen ($temp_file, "w");
      fwrite ($write, $data);
      fclose ($write);

      if (!(filesize ($temp_file) > 0)) $temp_file = null;
    }

    if ($this->verifyString ($temp_file) && $this->verifyString ($fileName)) {
      if (!$is_path) $fileName = $this->utilitySameLevelPath ($this->options['absolute_path'] . '/' . $fileName);

      if (@rename ($temp_file, $fileName)) {
        @chmod ($fileName, 0777);
        $temp_file = $fileName;
      }
    }

    return $temp_file;    
  }

  public function isExist ($cainfo = null) {
    if ($this->isError) $this->showError ("<fr>Error!</fr> This object not yet fully initialized!\nPlease confirm your program again.");
    
    $options = array (
      CURLOPT_URL            => $this->fileUrl,
      CURLOPT_NOBODY         => 1,
      CURLOPT_FAILONERROR    => 1,
      CURLOPT_RETURNTRANSFER => 1
    );
    if ($this->verifyFileReadable ($cainfo)) $options[CURLOPT_CAINFO] = $cainfo;

    $ch = curl_init ($this->fileUrl);
    curl_setopt_array ($ch = curl_init ($this->fileUrl), $options);

    return (curl_exec ($ch) === false) ? false : true;
  }

  private function _setSavePath () {
    $this->options['save_path'] = $this->utilityPath ($this->options['save_path']);
    $this->options['save_path'] = $this->verifyString ($this->options['save_path']) ? ($this->options['save_path'] . '/') : '';
    $this->options['absolute_path'] = $this->utilitySameLevelPath ($this->options['absolute_path'] . '/' . $this->options['save_path']);
  }

  private function _initD4Variable () {
    if ($this->verifyObject ($CI =& get_instance ())) {
      $this->d4_options = array ( 'time_limit'    => $CI->get_config ('d4_config', 'web_stream_utility', 'time_limit'),
                                  'temp_folder'   => $CI->get_config ('d4_config', 'web_stream_utility', 'temp_folder'),
                                  'temp_prefix'   => $CI->get_config ('d4_config', 'web_stream_utility', 'temp_prefix'),
                                  'save_path'     => $CI->get_config ('d4_config', 'web_stream_utility', 'save_path'),
                                  'absolute_path' => $CI->get_config ('d4_config', 'web_stream_utility', 'absolute_path'));
    } else {
      $this->d4_options = array ( 'time_limit'    => 30,
                                  'temp_folder'   => sys_get_temp_dir (),
                                  'temp_prefix'   => 'WSU_',
                                  'save_path'     => 'temp',
                                  'absolute_path' => FCPATH,
                                  'base_url'      => base_url ());
    }
  }

  private function _setOptions ($options = array()) {
    $this->options = array_merge ($this->d4_options, $options);
  }
  
  public function getObj () { return $this->obj; }

  public static function create ($url, $options = array ()) {
    $wsu = new self ($url, $options);
    if (TypeVerify::verifyObject ($obj = $wsu->getObj ())) return $obj;
    else TypeVerify::showError ("<fr>Error!</fr> The create object happen unknown error...\nPlease confirm your program again.");
  }

  public static function getUrlFileInfo ($url, $options = PATHINFO_EXTENSION) {
    // PATHINFO_DIRNAME | PATHINFO_BASENAME | PATHINFO_EXTENSION | PATHINFO_FILENAME
    $qpos = strpos ($url, "?");
    if ($qpos !== false) $url = substr ($url, 0, $qpos); 
    $info = strtolower (pathinfo ($url, $options));
    return TypeVerify::verifyString ($info) ? $info : null; 
  }
}