<?php
  if ($active) {
    switch ($active->kind) {
      case 'po_picture':
        if ($models = (($model_name = $active->model_name) && ($models = $model_name::find ('all', array ('conditions' => array ('id IN (?)', explode (',', $active->model_ids))))) ? $models : array ())) { ?>
          <div class='active' data-kind='<?php echo count ($models) == 1 ? 'po_picture' : 'po_pictures';?>'>
            <div class='time_area'>
              <div class='time'>
                <span class='timeago' data-time='<?php echo $active->updated_at;?>'></span>
              </div>
            </div>
            <div class='point_area'>
              <div></div>
            </div>
            <div class='content_area'>
              <div class='content_panel'>
                <div class='content_text'>
            <?php echo count ($models) > 1 ? ((identity ()->get_identity ('sign_in') && (identity ()->get_session ('user_id') == $active->user_id) ? '我' : $active->user->name) . '分享了 ' . count ($models) . ' 張圖片。') : mb_strimwidth ($models[0]->text, 0, 450, '…', 'UTF-8');?>
                </div>
                <div class='content_img_area'>
            <?php $wh = (533 - count ($models) * 4) / count ($models);
                  foreach ($models as $model) { ?>
                    <a href='<?php echo base_url (array ('pictures', $model->id));?>'>
                      <div class='content_img' style='height: <?php echo $wh;?>px; width: <?php echo $wh;?>px'>
                        <img src='<?php echo $model->file_name->url ($wh > 300 ? '640xW': ($wh > 130 ? '230xW' : '100xW'));?>' />
                      </div>
                    </a>
            <?php }?>
                </div>
              </div>
            </div>
          </div>  
<?php   }
        break;
      case 'add_picture_comment':
        if ($models = (($model_name = $active->model_name) && ($models = $model_name::find ('all', array ('include' => array ('picture'), 'conditions' => array ('id IN (?)', explode (',', $active->model_ids))))) ? $models : array ())) { ?>
          <div class='active' data-kind='<?php echo count ($models) == 1 ? 'add_picture_comment' : 'add_picture_comments';?>'>
            <div class='time_area'>
              <div class='time'>
                <span class='timeago' data-time='<?php echo $active->updated_at;?>'></span>
              </div>
            </div>
            <div class='point_area'>
              <div></div>
            </div>
            <div class='content_area'>
              <div class='content_panel'>
          <?php if ((count ($models) == 1) && ($models = $models[0]) && $models->picture) { ?>
                  <div class='content_text row'>
                    <div class="col-md-9">
                      回應了一張圖片:「<?php echo mb_strimwidth ($models->text, 0, 250, '…', 'UTF-8');?>」。
                    </div>
                    <div class="col-md-3" style='overflow: visible;'>
                      <a href='<?php echo base_url (array ('pictures', $models->picture->id));?>'>
                        <div class='content_unit_img'>
                          <img src='<?php echo $models->picture->file_name->url ('100xW');?>' />
                        </div>
                      </a>
                    </div>
                  </div>
          <?php } else { ?>
                  <div class='content_text'>分別對以下圖片留言。</div>
                  <div class='content_unit_imgs'>
              <?php if ($models) {
                      $picture_ids = array ();
                      foreach ($models as $model) {
                        if ($model->picture && (!$picture_ids || !in_array ($model->picture->id, $picture_ids)) && array_push ($picture_ids, $model->picture->id)) { ?>
                          <a href='<?php echo base_url (array ('pictures', $model->picture->id));?>'>
                            <div class='content_unit_img'>
                              <img src='<?php echo $model->picture->file_name->url ('100xW');?>' />
                            </div>
                          </a>
                  <?php }
                      }
                    } ?>
                  </div>
          <?php } ?>
              </div>
            </div>
          </div>
<?php   }
        break;
      case 'be_follow':
        if ($models = (($model_name = $active->model_name) && ($models = $model_name::find ('all', array ('include' => array ('user'), 'conditions' => array ('be_user_id = ? AND user_id IN (?)', $active->user_id, explode (',', $active->model_ids))))) ? $models : array ())) { ?>
          <div class='active' data-kind='<?php echo count ($models) == 1 ? 'be_follow' : 'be_follows';?>'>
            <div class='time_area'>
              <div class='time'>
                <span class='timeago' data-time='<?php echo $active->updated_at;?>'></span>
              </div>
            </div>
            <div class='point_area'>
              <div></div>
            </div>
            <div class='content_area'>
              <div class='content_panel'>
          <?php if ((count ($models) == 1) && ($models = $models[0]) && $models->user) { ?>
                  <div class='content_text row'>
                    <div class="col-md-9">已被 <a href='<?php echo base_url (array ('users', $models->user_id));?>'><?php echo $models->user->name;?></a> Follow 了。</div>
                    <div class="col-md-3" style='overflow: visible;'>
                      <a href='<?php echo base_url (array ('users', $models->user_id));?>'>
                        <div class='content_unit_img avatar_o'>
                          <img src='<?php echo $models->user->avatar_url (100, 100);?>' />
                          <div class='unit_text'><?php echo $models->user->name;?></div>
                        </div>
                      </a>
                    </div>
                  </div>
          <?php } else { ?>
                  <div class='content_text'>已經被他們 Follow 了。</div>
                  <div class='content_unit_imgs'>
              <?php $ids = array ();
                    foreach ($models as $model) {
                      if ($model->user && (!$ids || !in_array ($model->user_id, $ids)) && array_push ($ids, $model->user_id)) { ?>
                        <a href='<?php echo base_url (array ('users', $model->user_id));?>'>
                          <div class='content_unit_img avatar_o'>
                            <img src='<?php echo $model->user->avatar_url (100, 100);?>' />
                            <div class='unit_text'><?php echo $model->user->name;?></div>
                          </div>
                        </a>
                <?php }
                    } ?>
                  </div>
          <?php } ?>
              </div>
            </div>
          </div>
<?php
        }
        break;
      case 'to_follow':
        if ($models = (($model_name = $active->model_name) && ($models = $model_name::find ('all', array ('include' => array ('be_user'), 'conditions' => array ('user_id = ? AND be_user_id IN (?)', $active->user_id, explode (',', $active->model_ids))))) ? $models : array ())) { ?>
          <div class='active' data-kind='<?php echo count ($models) == 1 ? 'to_follow' : 'to_follows';?>'>
            <div class='time_area'>
              <div class='time'>
                <span class='timeago' data-time='<?php echo $active->updated_at;?>'></span>
              </div>
            </div>
            <div class='point_area'>
              <div></div>
            </div>
            <div class='content_area'>
              <div class='content_panel'>
          <?php if ((count ($models) == 1) && ($models = $models[0]) && $models->be_user) { ?>
                  <div class='content_text row'>
                    <div class="col-md-9">已經在 Follow <a href='<?php echo base_url (array ('users', $models->be_user_id));?>'><?php echo $models->be_user->name;?></a> 了。</div>
                    <div class="col-md-3" style='overflow: visible;'>
                      <a href='<?php echo base_url (array ('users', $models->be_user_id));?>'>
                        <div class='content_unit_img avatar_o'>
                          <img src='<?php echo $models->be_user->avatar_url (100, 100);?>' />
                          <div class='unit_text'><?php echo $models->be_user->name;?></div>
                        </div>
                      </a>
                    </div>
                  </div>
          <?php } else { ?>
                  <div class='content_text'>已經在 Follow 他們了。</div>
                  <div class='content_unit_imgs'>
              <?php $ids = array ();
                    foreach ($models as $model) {
                      if ($model->be_user && (!$ids || !in_array ($model->be_user_id, $ids)) && array_push ($ids, $model->be_user_id)) { ?>
                        <a href='<?php echo base_url (array ('users', $model->be_user_id));?>'>
                          <div class='content_unit_img avatar_o'>
                            <img src='<?php echo $model->be_user->avatar_url (100, 100);?>' />
                            <div class='unit_text'><?php echo $model->be_user->name;?></div>
                          </div>
                        </a>
                <?php }
                    } ?>
                  </div>
          <?php } ?>
              </div>
            </div>
          </div>
<?php
        }
        break;
      default:
        break;
    }
  }