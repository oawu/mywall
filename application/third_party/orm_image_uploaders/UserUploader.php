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
          );
  }
}