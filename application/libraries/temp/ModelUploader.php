<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once 'TypeVerify.php';
require_once 'ImageUtility.php';
require_once 'WebStreamUtility.php';

class ModelUploader extends TypeVerify {
  private $d4_options   = null;
  private $d4_versions  = null;
  private $ar_obj       = null;
  private $column_name  = null;
  private $column_value = null;
  private $isError      = true;

  public function __construct ($ar_obj = null, $column_name = null, $options = array ()) {
    if ($this->verifyObject ($ar_obj) && $this->verifyString ($column_name) && $this->verifyArray ($options, null)) {
      $this->_initD4Variable ();
      $this->_setOptions ($options);

      $this->_setSavePath ();
      if (!$this->verifyFolderWriteable ($this->options['absolute_path'])) $this->showError ("<fr>Error!</fr> The save folder base path is not exist or not folder or can not be <fr>write</fr>!\nFolder path : " . $this->options['absolute_path'] . "\nPlease confirm your program again.");
      if (!$this->verifyString ($this->options['separate_symbol'])) $this->showError ("<fr>Error!</fr> The 'separate_symbol' format error.\nIt must be a non-empty string.\nPlease confirm your program again.");

      $this->_xchgColumn ($ar_obj, $column_name);
    }
  }
  
  public function put_url ($url) {
    if ($this->isError) $this->showError ("<fr>Error!</fr> This object not yet fully initialized!\nPlease confirm your program again.");
    
    $savePath = $this->utilityPath ($this->getSavePath ());
    $savePath = $this->utilitySameLevelPath ($this->options['absolute_path'] . '/' . ($this->verifyString ($savePath) ? ($savePath . '/') : ''));
    
    if ($this->options['auto_create_save_path']) $this->_createSavePath ($savePath);
    if (!$this->verifyFolderWriteable ($savePath)) $this->showError ("<fr>Error!</fr> The save folder path can not be <fr>write</fr>!\nFolder path : " . $savePath . "\nPlease confirm your program again.");
    
    $ws_file = WebStreamUtility::create ($url)->download ($this->getFileName () . ($this->verifyString ($file_format = WebStreamUtility::getUrlFileInfo ($url, PATHINFO_EXTENSION)) ? ('.' . $file_format) : ''), false, true, dirname(__FILE__) . DIRECTORY_SEPARATOR . 'fb_ca_chain_bundle.crt');
 
    if ($is_success = $this->verifyFileWriteable ($ws_file)) {

      $ar_obj       = $this->ar_obj;
      $column_name  = $this->column_name;
      $column_value = (string)$ar_obj->$column_name;

      $column_value = $this->getFileName () . ($this->options['auto_add_file_format'] ? ('.' . strtolower (pathinfo ($ws_file, PATHINFO_EXTENSION))):'');
      $original_filePath = $savePath . $column_value;

      $is_success &= @rename ($ws_file, $original_filePath);

      if ($is_success && $this->verifyFileExist ($original_filePath)) {
        $varsions = array_merge ($this->d4_versions, $this->getVarsions ());
        if (count ($varsions)) {
          foreach ($varsions as $varsion_key => $varsion) {
            $filePath = $savePath . $varsion_key . $this->options['separate_symbol'] . $column_value;
            if ($this->verifyFileExist ($filePath)) @unlink ($filePath);
            else $is_success &= @copy ($original_filePath, $filePath);
            
            if ($this->verifyFileWriteable ($filePath)) {
              try {
                $imu = ImageUtility::create ($filePath, $this->options['image_utility_class'], array ());
                if ($this->verifyObject ($imu) && count ($varsion) && method_exists ($imu, $varsion[0])) {
                  call_user_func_array (array ($imu, array_shift ($varsion)), $varsion);
                  $imu->save ($filePath, true);
                }
              } catch (Exception $e) { $is_success = false; }
            }
          }
        }
      }

      if (!$this->options['save_original'] && file_exists ($original_filePath)) @unlink ($original_filePath);
      if ($is_success) $this->_saveColumnValue ($column_value);
    }

    return $is_success;
  }

  public function put ($temp_file_info) {
    if ($this->isError) $this->showError ("<fr>Error!</fr> This object not yet fully initialized!\nPlease confirm your program again.");
    if (!$this->verifyArrayFormat ($temp_file_info, array ('name', 'type', 'tmp_name', 'error', 'size'))) $this->showError ("<fr>Error!</fr> This file array format is error!\nIt must has 'name', 'type', 'tmp_name', 'error', 'size'!\nPlease confirm your program again.");
    
    $this->deleteOldFiles ();
    return $this->_createNewFiles ($temp_file_info);
  }

  public function getDbTableName () {return $this->isError?'':$this->ar_obj->table()->table;}
  public function getDbColumnName () {return $this->isError?'':$this->column_name;}
  public function getUploaderName () {return $this->isError?'':get_class ($this);}
  public function getUploaderFileName () {return $this->isError?'':$this->ObjName2FileName ($this->getUploaderName ());}
  public function getOtherColumnValue ($column_name) { return $this->isError?'': isset ($this->ar_obj->$column_name) && $this->verifyBase ($this->ar_obj->$column_name)?$this->ar_obj->$column_name:'';}

  public function getFileName () { return date ('Y-m-d_H_i_s'); }
  public function getVarsions () { return $this->d4_versions; }
  public function getSavePath () { return $this->getDbTableName () . '/' . $this->getDbColumnName () . '/' .floor ($this->getOtherColumnValue ('id') / 100) . '/' . ($this->getOtherColumnValue ('id') % 100); }

  private function _getFile ($key) {
    if ($this->isError) $this->showError ("<fr>Error!</fr> This object not yet fully initialized!\nPlease confirm your program again.");
    $ar_obj       = $this->ar_obj;
    $column_name  = $this->column_name;
    $column_value = (string)$ar_obj->$column_name;

    if ($this->verifyString ($column_value)) {
      $varsions = array_merge ($this->d4_versions, $this->getVarsions ());
      
      $key = array_key_exists ($key, $varsions) ? $key : '';

      $fileName = $key . $this->options['separate_symbol'] . $column_value;
      $absolute_path = $this->utilitySameLevelPath ($this->options['absolute_path'] . '/' . ($this->verifyString ($filePath = $this->utilityPath ($this->getSavePath ())) ? ($filePath . '/') : '') . '/' . $fileName);

      if (!$this->verifyFileExist ($absolute_path) && $this->verifyString ($key)) {
        $fileName = '' . $this->options['separate_symbol'] . $column_value;
        $absolute_path = $this->utilitySameLevelPath ($this->options['absolute_path'] . '/' . ($this->verifyString ($filePath = $this->utilityPath ($this->getSavePath ())) ? ($filePath . '/') : '') . '/' . $fileName);
      }

      if (!$this->verifyFileExist ($absolute_path) && $this->options['save_original']) {
        $fileName = $column_value;
        $absolute_path = $this->utilitySameLevelPath ($this->options['absolute_path'] . '/' . ($this->verifyString ($filePath = $this->utilityPath ($this->getSavePath ())) ? ($filePath . '/') : '') . '/' . $fileName);
      }

      if (!$this->verifyFileExist ($absolute_path)) $fileName = null;
      
      return $this->verifyString ($fileName) ? $fileName : null;
    } else {
      return null;
    }
  }
  public function getFilePath ($key = '') {
    return $this->verifyString ($fileName = $this->_getFile ($key)) ? $this->utilitySameLevelPath ($this->options['absolute_path'] . '/' . ($this->verifyString ($filePath = $this->utilityPath ($this->getSavePath ())) ? ($filePath . '/') : '') . '/' . $fileName) : null;
  }

  public function getDimension ($key = '') {
    $dimension = array ('width' => 0, 'height' => 0);
    if ($this->verifyFileExist ($file_path = $this->getFilePath ($key))) {
      $imu = ImageUtility::create ($file_path, $this->options['image_utility_class'], array ());
      $dimension = $imu->getDimension ();
    }
    return $dimension;
  }

  public function url ($key = '') {
    return $this->verifyString ($fileName = $this->_getFile ($key)) ? preg_replace("/(https?:\/)\/?/", "$1/", $this->utilitySameLevelPath ($this->utilityPath ($this->options['base_url']) . '/'. $this->utilityPath ($this->options['base_path'] . '/' . $this->utilityPath ($this->getSavePath ()) . '/' . $fileName))) : null;
  }

  private function _createSavePath ($savePath) {
    if (!$this->verifyFolderExist ($savePath)) {
      @mkdir ($savePath, 0777, true);
      @chmod($savePath, 0777);
    }
  }

  private function _createNewFiles ($temp_file_info) {
    if ($this->isError) $this->showError ("<fr>Error!</fr> This object not yet fully initialized!\nPlease confirm your program again.");
    
    $savePath = $this->utilityPath ($this->getSavePath ());
    $savePath = $this->utilitySameLevelPath ($this->options['absolute_path'] . '/' . ($this->verifyString ($savePath) ? ($savePath . '/') : ''));
    
    if ($this->options['auto_create_save_path']) $this->_createSavePath ($savePath);
    if (!$this->verifyFolderWriteable ($savePath)) $this->showError ("<fr>Error!</fr> The save folder path can not be <fr>write</fr>!\nFolder path : " . $savePath . "\nPlease confirm your program again.");
      
    $ar_obj       = $this->ar_obj;
    $column_name  = $this->column_name;
    $column_value = (string)$ar_obj->$column_name;
    
    $column_value = $this->getFileName () . ($this->options['auto_add_file_format'] ? ('.' . strtolower (pathinfo ($temp_file_info['name'], PATHINFO_EXTENSION))):'');

    $original_filePath = $savePath . $column_value;
    $is_success = @move_uploaded_file ($temp_file_info['tmp_name'], $original_filePath);
    
    if ($is_success && $this->verifyFileExist ($original_filePath)) {
      $varsions = array_merge ($this->d4_versions, $this->getVarsions ());
      if (count ($varsions)) {
        foreach ($varsions as $varsion_key => $varsion) {
          $filePath = $savePath . $varsion_key . $this->options['separate_symbol'] . $column_value;
          if ($this->verifyFileExist ($filePath)) @unlink ($filePath);
          else $is_success &= @copy ($original_filePath, $filePath);
          
          if ($this->verifyFileWriteable ($filePath)) {
            try {
              $imu = ImageUtility::create ($filePath, $this->options['image_utility_class'], array ());
              if ($this->verifyObject ($imu) && count ($varsion) && method_exists ($imu, $varsion[0])) {
                call_user_func_array (array ($imu, array_shift ($varsion)), $varsion);
                $imu->save ($filePath, true);
              }
            } catch (Exception $e) { $is_success = false; }
          }
        }
      }
    }

    if (!$this->options['save_original'] && file_exists ($original_filePath)) @unlink ($original_filePath);
    if ($is_success) $this->_saveColumnValue ($column_value);
    return $is_success;
  }

  public function deleteOldFiles () {
    if ($this->isError) $this->showError ("<fr>Error!</fr> This object not yet fully initialized!\nPlease confirm your program again.");
    $savePath = $this->utilityPath ($this->getSavePath ());
    $savePath = $this->utilitySameLevelPath ($this->options['absolute_path'] . '/' . ($this->verifyString ($savePath) ? ($savePath . '/') : ''));

    if ($this->verifyFolderExist ($savePath)) {
      if (!$this->verifyFolderWriteable ($savePath)) $this->showError ("<fr>Error!</fr> The save folder path can not be <fr>write</fr>!\nFolder path : " . $savePath . "\nPlease confirm your program again.");
      $ar_obj       = $this->ar_obj;
      $column_name  = $this->column_name;
      $column_value = (string)$ar_obj->$column_name;

      if ($this->verifyString ($column_value)) {

        if ($this->options['save_original']) {
          $filePath = $savePath . $column_value;
          if ($this->verifyFileExist ($filePath)) @unlink ($filePath);
        }

        $varsions = array_merge ($this->d4_versions, $this->getVarsions ());
        if (count ($varsions)) {
          foreach ($varsions as $varsion_key => $varsion) {
            $filePath = $savePath . $varsion_key . $this->options['separate_symbol'] . $column_value;
            if ($this->verifyFileExist ($filePath)) @unlink ($filePath);
          }
        }
      }

      $this->_saveColumnValue ('');
    }
  }

  private function _saveColumnValue ($value) {
    if ($this->verifyString ($value, null)) {
      $this->isError        = true;
      $ar_obj               = $this->ar_obj;
      $column_name          = $this->column_name;
      $ar_obj->$column_name = $value;
      $ar_obj->save ();
      $this->_xchgColumn ($ar_obj, $column_name);
    }
  }

  private function _xchgColumn ($ar_obj, $column_name) {
    $this->ar_obj = $ar_obj;
    $this->column_name = $column_name;
    if (isset ($ar_obj->$column_name)) {
      $this->column_value = (string)$ar_obj->$column_name;
      $ar_obj->$column_name = $this;
      $this->isError = false;
    }
  }

  private function _setSavePath () {
    $this->options['base_path'] = $this->utilityPath ($this->options['base_path']);
    $this->options['base_path'] = $this->verifyString ($this->options['base_path']) ? ($this->options['base_path'] . '/') : '';
    $this->options['absolute_path'] = $this->utilitySameLevelPath ($this->options['absolute_path'] . '/' . $this->options['base_path']);
  }

  private function _setOptions ($options = array()) {
    $this->options = array_merge ($this->d4_options, $options);
  }

  private function _initD4Variable () {
    $this->d4_versions  = array ("" => array ());

    if ($this->verifyObject ($CI =& get_instance ())) {
      $this->d4_options = array ( 'absolute_path'         => $CI->get_config ('d4_config', 'model_uploader', 'absolute_path'),
                                  'base_path'             => $CI->get_config ('d4_config', 'model_uploader', 'base_path'),
                                  'separate_symbol'       => $CI->get_config ('d4_config', 'model_uploader', 'separate_symbol'),
                                  'save_original'         => $CI->get_config ('d4_config', 'model_uploader', 'save_original'),
                                  'auto_create_save_path' => $CI->get_config ('d4_config', 'model_uploader', 'auto_create_save_path'),
                                  'auto_add_file_format'  => $CI->get_config ('d4_config', 'model_uploader', 'auto_add_file_format'),
                                  'base_url'              => $CI->get_config ('d4_config', 'model_uploader', 'base_url'),
                                  'image_utility_class'   => $CI->get_config ('d4_config', 'model_uploader', 'image_utility_class'));
    } else {
      $this->d4_options = array ( 'absolute_path'         => FCPATH,
                                  'base_path'             =>  'upload',
                                  'separate_symbol'       => '_',
                                  'save_original'         => true,
                                  'auto_create_save_path' => true,
                                  'auto_add_file_format'  => true,
                                  'base_url'              => base_url (),
                                  'image_utility_class'   => 'gd');
    }
  }

  public static function bind ($ar_obj, $column_name, $part_class_name = null, $options = array ()) {
    $_muu = new _ModelUploaderUtility (array ('ar_obj' => $ar_obj, 'column_name' => $column_name, 'part_class_name' => $part_class_name, 'options' => $options));
    if (TypeVerify::verifyObject ($obj = $_muu->getObj ())) return $obj;
    else TypeVerify::showError ("<fr>Error!</fr> The create ModelUploader object happen unknown error...\nPlease confirm your program again.");
  }
  public function __toString () {
    return (!$this->isError && $this->verifyString ($this->column_value)) ? $this->column_value : '';
  }

}

class _ModelUploaderUtility extends TypeVerify {
  private $options             = null;
  private $obj                 = null;
  private $d4_options          = null;
  private $d4_part_folder_path = null;

  public function __construct ($params = array ()) {
    if ($this->verifyArrayFormat ($params, array ('ar_obj', 'column_name', 'part_class_name', 'options'))) {
      try {
        $this->_initD4Variable ();
        $this->_setOptions ($params['options']);

        $this->_setPartFolderPath ();

        if (!$this->verifyFolderExist ($this->options['part_folder_path'])) $this->showError ("<fr>Error!</fr> The third_party folder path is not exist or not folder!\nFolder path : " . $this->options['part_folder_path'] . "\nPlease confirm your program again.");
        if (!$this->verifyObject ($params['ar_obj'])) $this->showError ("<fr>Error!</fr> The 'ar_obj' format error.\nIt must be a PHP-ActiveRecord object.\nPlease confirm your program again.");
        if (!$this->verifyString ($params['column_name'])) $this->showError ("<fr>Error!</fr> The 'column_name' format error.\nIt must be a non-empty string.\nPlease confirm your program again.");
        if ($this->verifyString ($params['part_class_name'])) $this->options['part_folder_path'] = $this->utilitySameLevelPath ($this->options['part_folder_path'] . '/' . $this->ObjName2FileName ($params['part_class_name']) . EXT);
        
        if ($this->verifyFileExist ($this->options['part_folder_path'])) {
          require_once $this->options['part_folder_path'];
          $this->obj = new $params['part_class_name'] ($params['ar_obj'], $params['column_name'], $params['options']);
        } else {
          $this->obj = new ModelUploader ($params['ar_obj'], $params['column_name'], $params['options']);
        }
      } catch (Exception $e) {
        $this->obj = null;
      }
    }
  }

  private function _initD4Variable () {
    $this->d4_options = array (
                          'part_folder_path'    => 'ModelUploader',
                        );
    $this->d4_part_folder_path = $this->utilitySameLevelPath (FCPATH . '/' . APPPATH . '/'. 'third_party' . '/');
  }

  private function _setOptions ($options = array()) {
    $this->options = array_merge ($this->d4_options, $options);
  }

  private function _setPartFolderPath () {
    $this->options['part_folder_path'] = $this->utilityPath ($this->options['part_folder_path']);
    $this->options['part_folder_path'] = $this->utilitySameLevelPath ($this->d4_part_folder_path . '/' . ($this->verifyString ($this->options['part_folder_path']) ? ($this->options['part_folder_path'] . '/') : '' ));
  }

  public function getObj () { return $this->obj; }
}