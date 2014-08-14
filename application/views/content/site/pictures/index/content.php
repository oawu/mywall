<?php
  echo render_cell ('frame_cells', 'user_bar');
  echo render_cell ('frame_cells', 'main_banner');
  echo render_cell ('frame_cells', 'feature_bar');
  echo render_cell ('frame_cells', 'tag_category_top');
?>

<div id='root' class='row'>
  <div class="col-md-8">
    <div id='left_area'>
      <div id='main'>
        
        <div id='main_img'>
          <img src='<?php echo $picture->file_name->url ('640xW');?>' />
        </div>

        <div id='main_not_pic'>
          <div id='main_info' class='row'>
            <div class="col-md-7 main_name">
              <?php echo $picture->user->name;?>
            </div>
            <div id='set_score' class="col-md-5 star_area" data-id='<?php echo $picture->id;?>' data-is_sign_in='<?php echo identity ()->get_identity ('sign_in') ? 1 : 0; ?>' data-is_set_scored='<?php echo ($user_score = $picture->user_score (identity ()->get_session ('user_id'))) ? 1 : 0; ?>'>
              <?php echo render_cell ('pictures_cells', 'score_star', $picture); ?>
            </div>
          </div>
          <div id='main_user_avatar'>
            <img src='<?php echo $picture->user->avatar_url (80, 80);?>' />
          </div>
          <div id='main_text'>
            <?php echo $picture->text;?>
          </div>
          <div id='main_bottom' class='row'>
            <div class="col-md-8 main_tags">
        <?php if (count ($picture->tags)) {
                foreach ($picture->tags as $i => $tag) {
                  if ($i < config ('picture_controller_config', 'main_tags_max_length')) { ?>
                    <span class='tag'><a href='<?php echo base_url (array ('tags', $tag->name));?>' target='_blank'><?php echo $tag->name; ?></a></span>
              <?php if ($i < (count ($picture->tags) - 1)) {?>
                      <span>|</span>
              <?php }
                  }
                }
              } ?>
            </div>
            <div class="col-md-4 timeago" data-time='<?php echo $picture->created_at;?>'></div>
          </div>
        </div>
        
      </div>
    </div>
    
    
  </div>
  <div class="col-md-4">
    <div id='right_area'>
<?php echo render_cell ('pictures_cells', 'star_details', $picture);
      echo render_cell ('pictures_cells', 'more_tags', $more_tags, $picture);?>
    </div>
  </div>
</div>