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
            <?php echo count ($models) > 1 ? '分享了 ' . count ($models) . ' 張圖片。' : mb_strimwidth ($models[0]->text, 0, 450, '…', 'UTF-8');?>
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
                    <div class="col-md-3">
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
      default:
        break;
    }
  }