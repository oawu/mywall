<?php
  echo render_cell ('frame_cells', 'user_bar');
  echo render_cell ('frame_cells', 'main_banner');
  echo render_cell ('frame_cells', 'feature_bar');
  echo render_cell ('frame_cells', 'tag_category_top');

  if ($user->banner_pictures && $user->banner) { ?>
    <div id='user_banner'>
      <div id="contentContainer" class="trans3d"> 
        <section id="carouselContainer" class="trans3d">
    <?php foreach ($user->banner_pictures as $banner_picture) { ?>
            <figure class="carouselItem trans3d">
              <div class="carouselItemInner trans3d">
                <img src='<?php echo $banner_picture->file_name->url ('230xW');?>' />
              </div>
            </figure>
    <?php } ?>
        </section>
      </div>
      <div class='user_banner'>
        <div class='user_banner_img'>
          <img src='<?php echo $user->banner->url ('1000x350');?>' />
        </div>
      </div>
      <div class='banner_filter'></div>
      <div id='user_avatar'><img src='<?php echo $user->avatar_url (100, 100);?>' /></div>
<?php echo render_cell ('users_cells', 'user_score', $user); ?>
    </div>
<?php
  } ?>

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