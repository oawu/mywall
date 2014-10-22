
<div class='picture'>
  <div class='image imgLiquid'>
    <img src='<?php echo $picture->file_name->url ('640xW');?>' />
  </div>

  <div class='user clearfix'>
    <div class='avatar'>
      <img src='<?php echo $picture->user->avatar->url ('50x50');?>' />
    </div>
    <div class='name'><?php echo $picture->user->name;?></div>
    <div class='timeago' data-time="<?php echo $picture->created_at;?>"></div>
  </div>

  <div class='content'><?php echo $picture->text;?></div>
  <div class='info clearfix'>
    <div class='tags'>
      <?php
        foreach ($picture->tags as $tag) {
          echo $tag->name;
        }
      ?>
    </div>
    <div class='stars'>
      <span class='icon-star8'></span>
      <span class='icon-star8'></span>
      <span class='icon-star7'></span>
      <span class='icon-star6'></span>
      <span class='icon-star6'></span>
    </div>
  </div>
</div>
