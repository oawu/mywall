 <?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
/**
 * @author      OA Wu <comdan66@gmail.com>
 * @copyright   Copyright (c) 2014 OA Wu Design
 */
class TempPictureUploader extends OrmImageUploader {

  public function getVersions () {
    return array (
            '' => array ('adaptiveResizeQuadrant', 50, 27, 'C'),
            '100xW' => array ('resize', 100, 100, 'width'),
            '500xW' => array ('resize', 500, 500, 'width'),
            '1400xW' => array ('resize', 1400, 1400, 'width')
          );
  }

  public function getFileName () { return uniqid (rand () . '_'); }
}