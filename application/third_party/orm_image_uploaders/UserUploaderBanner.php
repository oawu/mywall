 <?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
/**
 * @author      OA Wu <comdan66@gmail.com>
 * @copyright   Copyright (c) 2014 OA Wu Design
 */
class UserUploaderBanner extends OrmImageUploader {
  public function getVersions () {
    return array (
            '' => array (),
            '1000x350' => array ('adaptiveResizeQuadrant', 1000, 350, 't'),
          );
  }
}