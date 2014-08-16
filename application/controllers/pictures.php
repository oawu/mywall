<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @author      OA Wu <comdan66@gmail.com>
 * @copyright   Copyright (c) 2014 OA Wu Design
 */
class Pictures extends Site_controller {
  public function __construct () {
    parent::__construct ();
  }

  public function index ($id = 0) {
    if (!($id && is_numeric ($id) && ($picture = Picture::find ('one', array ('conditions' => array ('id = ?', $id))))))
      redirect ();

    $more_tags = ($count_tags = count ($picture->tags)) ? $count_tags < config ('pictures_controller_config', 'more_tags_max_length') ? array_merge ($picture->tags, PictureTag::find ('all', array ('order' => 'RAND()', 'limit' => config ('pictures_controller_config', 'more_tags_max_length') - $count_tags, 'conditions' => array ('id NOT IN (?)', field_array ($picture->tags, 'id'))))) : array_slice ($picture->tags, 0, config ('pictures_controller_config', 'more_tags_max_length')) : PictureTag::find ('all', array ('order' => 'RAND()', 'limit' => config ('pictures_controller_config', 'more_tags_max_length')));
    
    delay_job ('pictures', 'add_pageview', array ('id' => $picture->id));

    $this
    ->add_hidden (array ('id' => 'fb_sing_in_url', 'value' => facebook ()->login_url ('platform', 'fb_sing_in', $this->get_class (), $picture->id)))
    ->add_hidden (array ('id' => 'delete_picture_url', 'value' => base_url (array ($this->get_class (), 'delete_picture'))))
    ->add_hidden (array ('id' => 'delete_comment_url', 'value' => base_url (array ($this->get_class (), 'delete_comment'))))
    ->add_hidden (array ('id' => 'fetch_star_details_url', 'value' => base_url (array ($this->get_class (), 'fetch_star_details'))))
    ->add_hidden (array ('id' => 'set_score_url', 'value' => base_url (array ($this->get_class (), 'set_score'))))
    ->add_hidden (array ('id' => 'submit_comment_url', 'value' => base_url (array ($this->get_class (), 'submit_comment'))))
    ->add_hidden (array ('id' => 'get_comments_url', 'value' => base_url (array ($this->get_class (), 'get_comments'))))
         ->load_view (array ('picture' => $picture, 'more_tags' => $more_tags));
  }
  public function delete_picture () {
    if (!$this->is_ajax ())
      show_error ("It's not Ajax request!<br/>Please confirm your program again.");
    
    if (!(($id = $this->input_post ('id')) && ($picture = Picture::find ('one', array ('select' => 'id, user_id', 'conditions' => array ('id = ?', $id))))))
      return $this->output_json (array ('status' => false, 'title' => '錯誤', 'message' => '參數錯誤，請稍候再試，或請通知程式設計人員!', 'action' => 'function () { $(this).OA_Dialog ("close"); }'));

    if (!(identity ()->get_identity ('sign_in') && ((identity ()->get_session ('user_id') == $picture->user_id) || identity ()->get_identity ('admins'))))
      return $this->output_json (array ('status' => false, 'title' => '失敗', 'message' => '刪除失敗! 您沒有權限刪除!', 'action' => 'function () { $(this).OA_Dialog ("close"); }'));
    
    $picture->recycle ();
    delay_job ('pictures', 'update_pictures_count', array ('user_id' => $picture->user_id));
    $this->output_json (array ('status' => true, 'title' => '成功', 'message' => '刪除成功!', 'action' => 'function(){window.location.assign ("' . base_url (array ('users', $picture->user_id)) . '");}'));
  }
  public function get_comments () {
    if (!$this->is_ajax ())
      show_error ("It's not Ajax request!<br/>Please confirm your program again.");
    if ($this->input_post ('id') && ($this->input_post ('next_id') >= 0) && ($comments_info = render_cell ('pictures_cells', 'comments', $this->input_post ('id'), $this->input_post ('next_id'))))
      $this->output_json (array ('status' => true, 'next_id' => $comments_info['next_id'], 'contents' => $comments_info['comments']));
    else 
      $this->output_json (array ('status' => false));
  }
  public function delete_comment () {
    if (!$this->is_ajax ())
      show_error ("It's not Ajax request!<br/>Please confirm your program again.");
    
    if (!(($comment_id = $this->input_post ('comment_id')) && ($comment = PictureComment::find ('one', array ('select' => 'id, picture_id, user_id', 'conditions' => array ('id = ?', $comment_id))))))
      return $this->output_json (array ('status' => false, 'title' => '錯誤', 'message' => '參數錯誤，請稍候再試，或請通知程式設計人員!', 'action' => 'function () { $(this).OA_Dialog ("close"); }'));

    if (!(identity ()->get_identity ('sign_in') && ((identity ()->get_session ('user_id') == $comment->user_id) || identity ()->get_identity ('admins'))))
      return $this->output_json (array ('status' => false, 'title' => '失敗', 'message' => '刪除失敗! 您沒有權限刪除!', 'action' => 'function () { $(this).OA_Dialog ("close"); }'));

    $comment->recycle ();
    delay_job ('pictures', 'update_comments_count', array ('picture_id' => $comment->picture_id));

    $this->output_json (array ('status' => true, 'title' => '成功', 'message' => '刪除成功!'));
  }
  public function submit_comment () {
    if (!$this->is_ajax ())
      show_error ("It's not Ajax request!<br/>Please confirm your program again.");
    
    if (!(($id = $this->input_post ('id')) && ($user_id = $this->input_post ('user_id')) && ($text = $this->input_post ('text'))))
      return $this->output_json (array ('status' => false, 'title' => '錯誤', 'message' => '參數錯誤，請稍候再試，或請通知程式設計人員!', 'action' => 'function () { $(this).OA_Dialog ("close"); }'));
    
    if (!(identity ()->get_identity ('sign_in') && ($user_id == $this->identity->get_session ('user_id')) && ($user = User::find ('one', array ('conditions' => array ('id = ?', $user_id))))))
      return $this->output_json (array ('status' => false, 'title' => '錯誤', 'message' => '請確認有使用 Facebook 登入，若登入後仍然有此狀況，請通知程式設計人員!', 'action' => 'function () { $(this).OA_Dialog ("close"); }'));

    if (!($picture = Picture::find ('one', array ('conditions' => array ('id = ?', $id)))))
      return $this->output_json (array ('status' => false, 'title' => '錯誤', 'message' => '錯誤的參數資訊，或請通知程式設計人員!', 'action' => 'function () { $(this).OA_Dialog ("close"); }'));

    if (!verifyCreateOrm ($picture_comment = PictureComment::create (array ('user_id' => $user->id, 'picture_id' => $picture->id, 'text' => $text))))
      return $this->output_json (array ('status' => false, 'title' => '錯誤', 'message' => '留言失敗，請通知程式設計人員!', 'action' => 'function () { $(this).OA_Dialog ("close"); }'));
    
    delay_job ('pictures', 'update_comments_count', array ('picture_id' => $picture->id));

    $this->output_json (array ('status' => true, 'message' => '留言成功!', 'content' => render_cell ('pictures_cells', 'comment', $picture_comment)));
  }
  public function fetch_star_details () {
    if (!$this->is_ajax ())
      show_error ("It's not Ajax request!<br/>Please confirm your program again.");
    
    $id = $this->input_post ("id");
    
    if ($id && ($picture = Picture::find ('one', array ('conditions' => array ('id = ?', $id))))) {
      // clear_cell ('pictures_cells', 'score_star', $picture->id);
      // clear_cell ('pictures_cells', 'star_details', $picture->id);
      $this->output_json (array ('status' => true, 'score_star' => render_cell ('pictures_cells', 'score_star', $picture), 'star_details' => render_cell ('pictures_cells', 'star_details', $picture)));
    } else { $this->output_json (array ('status' => false, 'message' => '參數資訊有誤，請稍候再試，或請通知程式設計人員!')); }
  }
  public function set_score () {
    if (!$this->is_ajax ())
      show_error ("It's not Ajax request!<br/>Please confirm your program again.");
    
    $id = $this->input_post ("id");
    $score = $this->input_post ("score");

    if (!($id && ($score > 0) && ($score < 6)))
      return $this->output_json (array ('status' => false, 'title' => '錯誤', 'message' => '評分錯誤，請稍候再試，或請通知程式設計人員!', 'action' => 'function () { $(this).OA_Dialog ("close"); }'));

    if (!(identity ()->get_identity ('sign_in') && ($user_id = identity ()->get_session ('user_id')) && ($user = User::find ('one', array ('select' => 'id', 'conditions' => array ('id = ?', $user_id))))))
      return $this->output_json (array ('status' => false, 'title' => '提示', 'message' => '你還沒登入喔！趕快按下確定，就可以輕鬆使用 Facebook 登入評分囉!', 'action' => 'function () { window.location.assign ("' . $this->fb->getLoginUrl (array ('redirect_uri' => base_url (array ('platform', 'fb_sing_in', implode ('|', array ($this->get_class (), 'id', $unit_id)))))) . '"); }'));

    if (!($picture = Picture::find ('one', array ('select' => 'id, score, updated_at', 'conditions' => array ('id = ?', $id)))))
      return $this->output_json (array ('status' => false, 'title' => '失敗', 'message' => '評分失敗，此景點暫時不提供評分，如有任何問題請通知管理人員!', 'action' => 'function () { $(this).OA_Dialog ("close"); }'));

    if ($unit_score = $picture->user_score ($user->id))
      return $this->output_json (array ('status' => false, 'title' => '提示', 'message' => '你應該已經評過分數囉，如有任何問題請通知管理人員!', 'action' => 'function () { $(this).OA_Dialog ("close"); }'));

    if (!(($picture_score = PictureScore::create (array ('picture_id' => $picture->id, 'user_id' => $user->id, 'value' => $score))) && ($picture_score = PictureScore::find ('one', array ('select' => 'SUM(value) AS sum, COUNT(id) as count', 'conditions' => array ('picture_id = ?', $picture->id))))))
      return $this->output_json (array ('status' => false, 'title' => '提示', 'message' => '評分數失敗，如有任何問題請通知管理人員!', 'action' => 'function () { $(this).OA_Dialog ("close"); }'));

    $picture->score = round ($picture_score->sum / $picture_score->count, 2);
    $picture->save ();
    clear_cell ('pictures_cells', 'score_star', $picture->id);
    clear_cell ('pictures_cells', 'star_details', $picture->id);

    $this->output_json (array ('status' => true, 'message' => '成功給分!!'));
  }

}
