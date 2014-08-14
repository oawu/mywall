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

    $more_tags = ($count_tags = count ($picture->tags)) ? $count_tags < config ('picture_controller_config', 'more_tags_max_length') ? array_merge ($picture->tags, PictureTag::find ('all', array ('order' => 'RAND()', 'limit' => config ('picture_controller_config', 'more_tags_max_length') - $count_tags, 'conditions' => array ('id NOT IN (?)', field_array ($picture->tags, 'id'))))) : array_slice ($picture->tags, 0, config ('picture_controller_config', 'more_tags_max_length')) : PictureTag::find ('all', array ('order' => 'RAND()', 'limit' => config ('picture_controller_config', 'more_tags_max_length')));

    $this
    ->add_hidden (array ('id' => 'fb_sing_in_url', 'value' => facebook ()->login_url ('platform', 'fb_sing_in', $this->get_class (), $picture->id)))
    ->add_hidden (array ('id' => 'fetch_star_details_url', 'value' => base_url (array ($this->get_class (), 'fetch_star_details'))))
    ->add_hidden (array ('id' => 'set_score_url', 'value' => base_url (array ($this->get_class (), 'set_score'))))
         ->load_view (array ('picture' => $picture, 'more_tags' => $more_tags));
  }
  public function fetch_star_details () {
    if (!$this->is_ajax ())
      show_error ("It's not Ajax request!<br/>Please confirm your program again.");
    
    $id = $this->input_post ("id");
    
    if ($id && ($picture = Picture::find ('one', array ('conditions' => array ('id = ?', $id))))) {
      clear_cell ('pictures_cells', 'score_star', $picture->id);
      clear_cell ('pictures_cells', 'star_details', $picture->id);
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

    if (!($picture = Picture::find ('one', array ('select' => 'id', 'conditions' => array ('id = ?', $id)))))
      return $this->output_json (array ('status' => false, 'title' => '失敗', 'message' => '評分失敗，此景點暫時不提供評分，如有任何問題請通知管理人員!', 'action' => 'function () { $(this).OA_Dialog ("close"); }'));

    if ($unit_score = $picture->user_score ($user->id))
      return $this->output_json (array ('status' => false, 'title' => '提示', 'message' => '你應該已經評過分數囉，如有任何問題請通知管理人員!', 'action' => 'function () { $(this).OA_Dialog ("close"); }'));

    delay_job ('pictures', 'set_score', array ('picture_id' => $picture->id, 'score' => $score, 'user_id' => $user->id));
    $this->output_json (array ('status' => true, 'message' => '成功給分!!'));
  }

}
