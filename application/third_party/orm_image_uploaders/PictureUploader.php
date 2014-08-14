 <?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
/**
 * @author      OA Wu <comdan66@gmail.com>
 * @copyright   Copyright (c) 2014 OA Wu Design
 */
class PictureUploader extends OrmImageUploader {
  public function getVersions () {
    return array (
            '' => array (),
            '100xW' => array ('resize', 100, 100, 'width'),
            '228xW' => array ('resize', 228, 228, 'width'),
            '640xW' => array ('resize', 640, 640, 'width'),
          );
  }
}