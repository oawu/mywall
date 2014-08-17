 <?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
/**
 * @author      OA Wu <comdan66@gmail.com>
 * @copyright   Copyright (c) 2014 OA Wu Design
 */
class UserUploader extends OrmImageUploader {
  public function getVersions () {
    return array (
            '' => array (),
            '50x50' => array ('resize', 50, 50, 'width'),
            '80x80' => array ('resize', 80, 80, 'width'),
            '100x100' => array ('resize', 100, 100, 'width'),
          );
  }
}