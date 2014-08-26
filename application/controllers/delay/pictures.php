<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @author      OA Wu <comdan66@gmail.com>
 * @copyright   Copyright (c) 2014 OA Wu Design
 */
class Pictures extends Delay_controller {
  public function __construct () {
    parent::__construct ();
  }

  public function update_comments_count () {
    $picture_id = $this->input_post ('picture_id');
    if (($picture = Picture::find ('one', array ('select' => 'id, comments_count, updated_at', 'conditions' => array ('id = ?', $picture_id)))) && ($picture_comment = PictureComment::find ('one', array ('select' => 'COUNT(id) AS count', 'conditions' => array ('picture_id = ?', $picture->id))))) {
      $picture->comments_count = $picture_comment->count;
      $picture->save ();
      clean_cell ('pictures_cells', 'comments', 'picture_id_' . $picture->id . '/*');
    }
  }

  public function add_pageview () {
    $id = $this->input_post ('id');
    if ($picture = Picture::find ('one', array ('select' => 'id, pageview, updated_at', 'conditions' => array ('id = ?', $id))))
      Pageview::add_count ($picture, 'pageview', 1);
  }

  public function create () {
    $temp_id = $this->input_post ('temp_id');
    $user_id = $this->input_post ('user_id');
    $text = $this->input_post ('text');
    $tags = $this->input_post ('tags');
    $is_sync = $this->input_post ('is_sync');

    if (!($temp_id && $user_id && $text && $tags && ($temp_picture = TempPicture::find ('one', array ('conditions' => array ('id = ?', $temp_id))))))
      return false;

    if (verifyCreateOrm ($picture = Picture::create (array ('user_id' => $user_id, 'text' => $text, 'file_name' => '', 'pageview' => 0, 'score' => 0, 'is_sync' => $is_sync, 'comments_count' => 0))) && $picture->file_name->put ($temp_picture->file_name->path ())) {
      $pic_tag_ids = array ();
      foreach ($tags as $tag)
        if (($pic_tag = ($pic_tag = PictureTag::find ('one', array ('select' => 'id', 'conditions' => array ('name = ?', $tag)))) ? $pic_tag : PictureTag::create (array ('name' => $tag, 'picture_count' => '0'))) && array_push ($pic_tag_ids, $pic_tag->id))
          PictureTagMapping::create (array ('picture_id' => $picture->id, 'picture_tag_id' => $pic_tag->id));

      $temp_picture->model_name = get_class ($picture);
      $temp_picture->model_id = $picture->id;
      $temp_picture->save ();
      $temp_picture->recycle ();

      if ($pic_tag_ids)
        PictureTag::query ("UPDATE `picture_tags` SET `picture_count`=(SELECT COUNT(`id`) FROM `picture_tag_mappings` WHERE `picture_tag_id` = picture_tags.id) WHERE `id` IN (" . implode (',', $pic_tag_ids) . ")");

      delay_job ('users', 'update_pictures_count', array ('user_id' => $picture->user_id));
      delay_job ('user_actives', 'create_actives', array ('user_id' => $picture->user_id, 'kind' => 'po_picture', 'model_name' => get_class ($picture), 'model_id' => $picture->id));
      
      clean_cell ('main_cells', 'pictures', 'user_id_0/*');
      clean_cell ('main_cells', 'pictures', 'user_id_' . $picture->user_id . '/*');
      if ($picture->user->follow_me_users (array ('select' => 'id')))
        foreach ($picture->user->follow_me_users () as $follow_me_user)
          clean_cell ('main_cells', 'pictures', 'user_id_' . $follow_me_user->id . '/*');
      
      clear_cell ('users_cells', 'user_score', $picture->user_id);
      // clear_cell ('users_cells', 'banner', $picture->user_id);
    }
  }
}
