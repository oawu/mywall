 <?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
/**
 * @author      OA Wu <comdan66@gmail.com>
 * @copyright   Copyright (c) 2014 OA Wu Design
 */
class PromoUploader extends OrmImageUploader {
  public function getVersions () {
    return array (
            '' => array (),
            'promo1' => array ('adaptiveResizeQuadrant', 420, 380, 't'),
            'promo2' => array ('adaptiveResizeQuadrant', 170, 190, 't'),
            'promo3' => array ('adaptiveResizeQuadrant', 170, 190, 't'),
            'promo4' => array ('adaptiveResizeQuadrant', 170, 190, 't'),
            'promo5' => array ('adaptiveResizeQuadrant', 170, 190, 't'),
            'promo6' => array ('adaptiveResizeQuadrant', 250, 380, 't'),
          );
  }
}