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
  <?php if ($user->banner) { ?>
          <div class='user_banner_img'>
            <img src='<?php echo $user->banner->url ('1000x350');?>' />
          </div>
  <?php } ?>
      </div>
      <div class='banner_filter'></div>
      <div id='user_avatar'><img src='<?php echo $user->avatar_url (100, 100);?>' /></div>
<?php echo render_cell ('users_cells', 'user_score', $user); ?>
    </div>