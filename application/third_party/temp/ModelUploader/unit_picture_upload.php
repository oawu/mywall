<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @author      OA Wu <comdan66@gmail.com>
 * @copyright   Copyright (c) 2014 OA Wu Design
 */
class UnitPictureUpload extends ModelUploader {

  public function getVarsions () {
    return array (
            '' => array ('adaptiveResizeQuadrant', 640, 427, 'C'),
            '60x55C' => array ('adaptiveResizeQuadrant', 60, 55, 'C'),
            '100x100C' => array ('adaptiveResizeQuadrant', 100, 100, 'C'),
            '250x100C' => array ('adaptiveResizeQuadrant', 250, 100, 'C'),
            '190x135C' => array ('adaptiveResizeQuadrant', 190, 135, 'C'),
            '190x190W' => array ('resize', 190, 190, 'width'),
            '500x300C' => array ('adaptiveResizeQuadrant', 500, 300, 'C'),
          );
  }
  public function getFileName () { return uniqid (rand () . '_'); }
}