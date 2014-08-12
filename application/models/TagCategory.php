<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @author      OA Wu <comdan66@gmail.com>
 * @copyright   Copyright (c) 2014 OA Wu Design
 */
class TagCategory extends OaModel {

  static $table_name = 'tag_categories';

  public function __construct ($attributes = array (), $guard_attributes = TRUE, $instantiating_via_find = FALSE, $new_record = TRUE) {
    parent::__construct ($attributes, $guard_attributes, $instantiating_via_find, $new_record);

    OrmImageUploader::bind ('file_name');
    JsonBind::bind ('memo');
  }

  public function make_block9 () {
    if (($tags = $this->tags ()) && ($tag_ids = field_array (PictureTag::find ('all', array ('select' => 'id', 'order' => 'picture_count DESC', 'conditions' => array ('name IN (?)', $tags))), 'id')) && ($picture_ids = field_array (PictureTagMapping::find ('all', array ('select' => 'picture_id', 'conditions' => array ('picture_tag_id IN (?)', $tag_ids))), 'picture_id')) && (count ($pictures = Picture::find ('all', array ('select' => 'id, file_name', 'limit' => '9', 'order' => 'like_count DESC', 'conditions' => array ('id IN (?) AND year_week >= ?', $picture_ids, date ('YW', strtotime ('-1 weeks')))))) > 8)) {
      $temp_files = array ();
      foreach ($pictures as $picture)
        array_push ($temp_files, !$temp_files ? $picture->file_name->save_as ('380', array ('adaptiveResizeQuadrant', 130, 130, 't')) : $picture->file_name->save_as ('63', array ('adaptiveResizeQuadrant', 64, 64, 't')));

      $this->CI->load->library ('ImageUtility');
      $file_name = ImageUtility::make_block9 ($temp_files);
      $this->file_name->put ($file_name);

      $this->memo->picture_ids = field_array ($pictures, 'id');
      $this->memo->picture_count = PictureTagMapping::count (array ('conditions' => array ('picture_tag_id IN (?)', $tag_ids)));
      $this->memo->save ();
      return true;
    }
    return false;
  }

  public function tags () {
    return isset ($this->memo->tags) ? $this->memo->tags : array ($this->name);
  }
}