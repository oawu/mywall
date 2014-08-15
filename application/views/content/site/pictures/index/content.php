<?php
  echo render_cell ('frame_cells', 'user_bar');
  echo render_cell ('frame_cells', 'main_banner');
  echo render_cell ('frame_cells', 'feature_bar');
  echo render_cell ('frame_cells', 'tag_category_top');
?>

<div id='root' class='row'>
  <div class="col-md-8 left_area_col">
    <div id='left_area'>
<?php echo render_cell ('pictures_cells', 'main', $picture);
      echo render_cell ('pictures_cells', 'to_comment', $picture); ?>
      <div id='comments' data-id='<?php echo $picture->id;?>' data-next_id='0'></div>
<?php if (identity ()->get_identity ('sign_in') && ((identity ()->get_session ('user_id') == $picture->user_id) || identity ()->get_identity ('admins'))) { ?>
        <div class='delete_picture'>
          <button type="button" class='btn btn-danger btn-sm' name='delete_picture' data-loading-text="請稍候.." data-id='<?php echo $picture->id;?>'>x</button>
        </div>
<?php } ?>
    </div>
  </div>

  <div class="col-md-4 right_area_col">
    <div id='right_area'>
      <div id='set_score' class="star_area" data-id='<?php echo $picture->id;?>' data-is_sign_in='<?php echo identity ()->get_identity ('sign_in') ? 1 : 0; ?>' data-is_set_scored='<?php echo ($user_score = $picture->user_score (identity ()->get_session ('user_id'))) ? 1 : 0; ?>'>
  <?php echo render_cell ('pictures_cells', 'score_star', $picture); ?>
      </div>
<?php echo render_cell ('pictures_cells', 'star_details', $picture);
      echo render_cell ('pictures_cells', 'more_tags', $more_tags, $picture);?>
    </div>
  </div>
</div>