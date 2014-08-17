<?php
  echo render_cell ('frame_cells', 'user_bar');
  echo render_cell ('frame_cells', 'main_banner');
  echo render_cell ('frame_cells', 'feature_bar');
  echo render_cell ('frame_cells', 'tag_category_top');
?>
  <div id='user_banner'>
    <div id="contentContainer" class="trans3d"> 
      <section id="carouselContainer" class="trans3d">
  <?php if ($user->banner_pictures) {
          foreach ($user->banner_pictures as $banner_picture) { ?>
            <figure class="carouselItem trans3d">
              <div class="carouselItemInner trans3d">
                <img src='<?php echo $banner_picture->file_name->url ('230xW');?>' />
              </div>
            </figure>
    <?php }
        } ?>
      </section>
    </div>
    <div class='user_banner'>
      <div class='user_banner_img'>
        <img src='http://style.ioa.tw/upload/pictures/file_name/0/0/1/36/640xW_935380932_53f314a04da3f.jpg' />
      </div>
    </div>
    <div class='banner_filter'></div>
    <div id='user_avatar'>
      <img src='<?php echo $user->avatar_url (100, 100);?>' />
    </div>
  </div>
  <div id='not_banner' class='row'>
    <div class="col-md-8 left_area_col">

      <div class='active user_info'>
        <div class='user_info_area_left'>
        </div>
        <div class='user_info_area_right'>
          <?php echo $user->name;?>
        </div>
      </div>
      <div class='active user_feature'>
        <div class='user_feature_area_left'>
        </div>
        <div class='user_feature_area_right'>
          <a class='icon-pictures4 jqui_tooltip' href='' title='所有圖片'></a>
        </div>
      </div>

      <div id='actives' data-id='<?php echo $user->id;?>' data-next_id='0'>

          


      </div>

      <div id='end_point' class='icon-arrow-down8'></div>
    </div>
    <div class="col-md-4 rigth_area_col">
    
    </div>

  </div>
<!--   <div class='user_banner'>
    <img src='http://style.ioa.tw/upload/pictures/file_name/0/0/1/32/100xW_1961034057_53f2e2674006c.jpg' />
  </div> -->
  
  
  
