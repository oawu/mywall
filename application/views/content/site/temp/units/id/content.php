
<div class='root_panel'>
  <div class='banner_panel'>
    <div class='row'>
      <div class="col-md-<?php echo $banner_type == 'map' ? '12' : '6';?> map_area">
        <div class='map_panel'>
          <div id='map' data-latitude='<?php echo $unit->latitude;?>' data-longitude='<?php echo $unit->longitude;?>'></div>
          <i class="map-top"></i>
          <i class="map-right"></i>
          <i class="map-bottom"></i>
          <i class="map-left"></i>
        </div>
      </div>
<?php if ($banner_type == 'view') { ?>
        <div class="col-md-6 view_area">
          <div class='map_panel'>
            <div id='view' data-latitude='<?php echo $view->latitude;?>' data-longitude='<?php echo $view->longitude;?>' data-heading='<?php echo $view->heading;?>' data-pitch='<?php echo $view->pitch;?>' data-zoom='<?php echo $view->zoom;?>'></div>
            <i class="view-top"></i>
            <i class="view-right"></i>
            <i class="view-bottom"></i>
            <i class="view-left"></i>
          </div>
        </div>
<?php } else if ($banner_type == 'pic' && verifyObject ($picture = array_shift ($pictures))) { ?>
        <div class="col-md-6 picture_area">
          <div class='picture_panel fancybox' href='<?php echo $picture->picture_url ();?>' data-fancybox_title="" data-fancybox-group="fancybox-group-content_picture">
            <img id='main_picture' src='<?php echo $picture->picture_url ('500x300C');?>' />
          </div>
        </div>
<?php } ?>
    </div>
  </div>

  <div class='content_panel'>
    <div class='row'>
      <div class="col-md-8">
        <div class='main_panel'>
          <div class='user_panel'>
            <div class='row'>
              <div class="col-md-2">
                <div class='user_pic'>
                  <img src='<?php echo $unit->user->avatar_url (100, 80); ?>' />
                </div>
              </div>
              <div class="col-md-10">
                <div class='user_info'>
                  <div class='row user_name_area'>
                    <div class="col-md-8 user_name"><a href='https://www.facebook.com/<?php echo $unit->user->uid;?>' target='_blank'><?php echo $unit->user->name;?></a></div>
                    <div class="col-md-2 delete_unit">
                <?php if (identity ()->get_identity ('admins')) { ?>
                        <button type="button" class='btn btn-danger btn-sm' id='delete_unit' name='delete_unit' data-unit_id='<?php echo $unit->id;?>' data-loading-text="請稍候..">直接刪除</button>
                <?php } ?>
                    </div>
                    <div class="col-md-2 advice_unit">
                <?php if (true) { ?>
                        <button type="button" class='btn btn-primary btn-sm' id='advice_unit' name='advice_unit' data-unit_id='<?php echo $unit->id;?>' data-loading-text="請稍候..">提供建議</button>
                <?php } ?>
                    </div>
                  </div>
                  <div class='like_panel'>
                    <div class='row'>
                      <div class="col-md-8 like">
                        <div class="fb-like" data-href="<?php echo base_url ();?>" data-width="120" data-send="false" data-layout="button_count" data-action="like" data-show-faces="false" data-share="true"></div>
                      </div>
                      <div class="col-md-4 created_at" data-time='<?php echo $unit->created_at;?>'>
                        <?php echo $unit->created_at;?>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class='unit_panel'>
            <div class='main_unit'>
              <div class='unit_inside'>
                <div class='unit_head_panel'>
                  <div class='unit_head'>
                    <div class='row name_panel'>
                      <div class="col-md-9 name">
                        <?php echo $unit->name;?>
                      </div>
                      <div class="col-md-3 score" id='set_score' data-unit_id='<?php echo $unit->id; ?>' data-is_sign_in='<?php echo identity ()->get_identity ('sign_in') ? 1 : 0; ?>' data-is_set_scored='<?php echo verifyObject ($user_score = $unit->user_score (identity ()->get_session ('user_id'))) ? 1 : 0; ?>'>
                  <?php echo render_cell ('unit_cells', 'score_star', $unit); ?>
                      </div>
                    </div>
                    <div class='address'>
                      <?php echo $unit->address;?>
                    </div>
                  </div>
                </div>
          <?php if (count ($pictures) > 1) { ?>
                  <div class='unit_content_panel'>
                    <div class='unit_content'><?php echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . strip_tags (make_click_able_links ($unit->introduction, true, 'link'), '<a>');?></div>
                  </div>
                  <div class='row content_pictures'>
              <?php $i = 0;
                    foreach ($pictures as $picture) {
                      if (++$i < config ('unit_config', 'id', 'pictures', 'max_count')) { ?>
                        <div class='content_picture fancybox' href='<?php echo $picture->picture_url ();?>' data-fancybox_title="" data-fancybox-group="fancybox-group-content_picture"><img id='main_picture' src='<?php echo $picture->picture_url ('190x135C');?>' /></div>
                <?php }
                    } ?>
                  </div>
          <?php } else { ?>
                  <div class='unit_content_panel'>
                    <div class='unit_1_content'><?php if (verifyObject ($picture = array_shift ($pictures))) { ?><div class='content_1_picture fancybox' href='<?php echo $picture->picture_url ();?>' data-fancybox_title="" data-fancybox-group="fancybox-group-content_picture"><img id='main_picture' src='<?php echo $picture->picture_url ('190x135C');?>' /></div><?php }?><?php echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . strip_tags (make_click_able_links ($unit->introduction, true, 'link'), '<a>');?></div>
                  </div>
          <?php } ?>

                <div class='unit_foot_panel'>
                  <div class='unit_foot row'>
                    <div class="col-md-8 tags">
                <?php if (count ($tags)) {
                        foreach ($tags as $i => $tag) {
                          if ($i < config ('unit_config', 'id', 'main_tags_max_length')) { ?>
                            <span class='tag'><a href='<?php echo base_url (array ('units', 'tags', $tag->name));?>' target='_blank'><?php echo $tag->name; ?></a></span>
                      <?php if ($i < (count ($tags) - 1)) {?>
                              <span>|</span>
                      <?php }
                          }
                        }
                      } ?>
                    </div>
                    <div class="col-md-4 pageview">
                      累計瀏覽次數 <span><?php echo $unit->pageview + 1;?></span> 人!
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class='comment_panel'>

            <div class='create_comment_panel'>
        <?php if (identity ()->get_identity ('sign_in')) { ?>
                <div class='create_comment_area'>
                  <div class='comment_text_area'>
                    <div class='comment_loadding' id='comment_loadding'></div>
                    <input type='text' placeholder='在想些什麼?' value='' class='comment_text' id='comment_text' name='comment_text' />
                  </div>
                  <div class='create_comment_bottom row'>
                    <div class="col-md-6 sync_fb_area">
                      <label class='sync_fb'><input type="checkbox" name='sync_fb' id='sync_fb' value='true' checked/> 同步至 Facebook</label>
                    </div>
                    <div class="col-md-6 submit_comment_area">
                      <button type="button" id='submit_comment' name='submit_comment' class="btn btn-primary btn-sm submit_comment" data-loading-text="請稍候.." data-unit_id='<?php echo $unit->id; ?>' data-user_id='<?php echo identity ()->get_session ('user_id'); ?>'>留言</button>
                    </div>
                  </div>
                </div>
                <div class='alert comment_result_message' id='comment_result_message'></div>            
        <?php } else { ?>
                <div class='create_comment'>
                  <button type="button" id='create_comment' name='create_comment' class="btn btn-primary btn-sm" data-loading-text="請稍候..">我要留言!</button>
                </div>
        <?php } ?>
            </div>

            <div class='comment_list' id='comment_list'>
              <?php echo $comment_list; ?>
            </div>

            <div class='read_more_comment'>
        <?php if (isset ($next_id) && $next_id > 0) { ?>
                <button type="button" id='read_more_comment' name='read_more_comment' class="btn btn-info" data-loading-text="請稍候.." data-next_id='<?php echo $next_id; ?>' data-unit_id='<?php echo $unit->id; ?>'>看更多留言</button>
        <?php } ?>
            </div>

          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class='other_panel'>
    <?php echo render_cell ('unit_cells', 'star_details', $unit);
          echo render_cell ('unit_cells', 'more_tags', $more_tags, $unit); ?>
        </div>
      </div>
    </div>
  </div>
</div>