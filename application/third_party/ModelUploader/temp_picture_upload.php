 <?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
/**
 * @author      OA Wu <comdan66@gmail.com>
 * @copyright   Copyright (c) 2014 OA Wu Design
 */
class TempPictureUpload extends ModelUploader {

  public function getVarsions () { return array (); }
  public function getFileName () { return uniqid (rand () . '_'); }
}