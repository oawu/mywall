<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once 'TypeVerify.php';

class ImageUtility extends TypeVerify {
  private $d4_classes_formate = null;
  private $d4_classes_class = null;
  private $d4_library_folder_path = null;
  private $obj = null;
  
  public function __construct ($fileName = null, $class = null, $options = array ()) {
    if ($this->verifyFileReadable ($fileName) && $this->verifyString ($class) && $this->verifyArray ($options, 0)) {
      $this->_initD4Variable ();
      
      if ($this->verifyItemInArray ($class, $this->d4_classes_formate)) {
        $class = $this->d4_classes_class[$class];
        $classPath = $this->utilitySameLevelPath ($this->d4_library_folder_path . '/' . $class . EXT);

        if (!$this->verifyFileReadable ($classPath)) $this->showError("<fr>Error!</fr> The image utility class not found or not readable!\nPath : " . $classPath . "\nPlease confirm your program again.");
        require_once $classPath;
        $this->obj = new $class ($fileName, $options);
      } else {
        $this->showError ("<fr>Error!</fr> The image utility class array format is error!\nIt must be 'gd' or 'imgk'!\nPlease confirm your program again.");
      }
    } else if ($this->verifyString ($fileName)) {
      $this->showError("<fr>Error!</fr> The image file : " . $fileName . " not found or not readable!\nPlease confirm your program again.");
    }
  }

  private function _initD4Variable () {
    $this->d4_classes_formate = array ('gd', 'imgk');
    $this->d4_classes_class = array ('gd' => 'ImageGdUtility', 'imgk' => 'ImageImagickUtility');
    $this->d4_library_folder_path = $this->utilitySameLevelPath (FCPATH . '/' . APPPATH . '/' . 'libraries' . '/');
  }

  public static function create ($fileName, $class, $options =  array ()) {
    $uti = new ImageUtility ($fileName, $class, $options);
    if (TypeVerify::verifyObject ($obj = $uti->getObj ())) return $obj;
    else TypeVerify::showError ("<fr>Error!</fr> The create object happen unknown error...\nPlease confirm your program again.");
  }

  public function getObj () { return $this->obj; }
}
