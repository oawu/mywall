<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @author      OA Wu <comdan66@gmail.com>
 * @copyright   Copyright (c) 2014 OA Wu Design
 */
class UnitView extends OaModel {

  static  $table_name = 'unit_views';

  public function __construct ($attributes = array (), $guard_attributes = TRUE, $instantiating_via_find = FALSE, $new_record = TRUE) {
    parent::__construct ($attributes, $guard_attributes, $instantiating_via_find, $new_record);
  }

  public function picture_url ($size = '') {
    return verifyString ($size) ? "http://maps.googleapis.com/maps/api/streetview?size=" . strtolower ($size) . "&location=" . $this->latitude . "," . $this->longitude . "&heading=" . $this->heading . "&pitch=" . $this->pitch . "&zoom=" . $this->zoom . "&sensor=false" : '';
  }
}
