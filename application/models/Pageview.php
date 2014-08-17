<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @author      OA Wu <comdan66@gmail.com>
 * @copyright   Copyright (c) 2014 OA Wu Design
 */
class Pageview extends OaModel {

  static  $table_name = 'pageviews';

  public function __construct ($attributes = array (), $guard_attributes = TRUE, $instantiating_via_find = FALSE, $new_record = TRUE) {
    parent::__construct ($attributes, $guard_attributes, $instantiating_via_find, $new_record);
  }

  public static function add_count ($object, $column_name, $count = 1) {
    if ($pageview = self::find ('one', array ('conditions' => array ('model_name = ? AND model_id = ? AND date = ?', get_class ($object), $object->id, date ('Y-m-d'))))) {
      $pageview->counts = $pageview->counts + 1;
      $pageview->save ();
    } else {
      self::create (array ('model_name' => get_class ($object), 'model_id' => $object->id, 'date' => date ('Y-m-d'), 'counts' => $count));
    }
    $object->$column_name = $object->$column_name + $count;
    $object->save ();
  }
}
