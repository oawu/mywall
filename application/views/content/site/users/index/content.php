<?php
  echo render_cell ('frame_cells', 'user_bar');
  echo render_cell ('frame_cells', 'main_banner');
  echo render_cell ('frame_cells', 'feature_bar');
  echo render_cell ('frame_cells', 'tag_category_top');
  echo render_cell ('users_cells', 'banner', $user); ?>

  <div id='not_banner' class='row'>
    <div class="col-md-8 left_area_col">

      <div class='active user_info'>
        <div class='user_info_area_left'>
        </div>
        <div class='user_info_area_right'>
    <?php echo $user->name;?>
        </div>
      </div>
<?php echo render_cell ('users_cells', 'user_feature', $user); ?>
      <div id='actives' data-id='<?php echo $user->id;?>' data-next_id='0'></div>
      <div id='end_point' class='icon-arrow-down8'></div>
    </div>

    <div class="col-md-4 rigth_area_col">
      <div class='unit_area'>
  <?php echo render_cell ('users_cells', 'my_follow', $user);
        echo render_cell ('users_cells', 'follow_me', $user); ?>
      </div>
    </div>
  </div>