<?php 
  if ($picture->file_name->url ('228xW')) { ?>
    <div class='picture'>
      <a href='<?php echo base_url (array ('pictures', $picture->id));?>' target='_blank'>
        <div class='picture_pic'>
          <img src='<?php echo $picture->file_name->url ('228xW');?>' />
        </div>
      </a>
      <div class='picture_not_pic'>
        <div class='picture_user_name'>
          <a href='<?php echo base_url (array ('users', $picture->user_id));?>' target='_blank'>
            <?php echo $picture->user->name;?>
          </a>
        </div>
        <div class='picture_text'>
          <?php echo $picture->text;?>
        </div>
        <div class='picture_info row'>
          <div class='col-md-6 left'>
            <i class='icon-love'></i> <span><?php echo $picture->pageview;?></span>
          </div>
          <div class='col-md-6 right timeago' data-time='<?php echo $picture->created_at;?>'></div>
        </div>
        <a href='<?php echo base_url (array ('users', $picture->user_id));?>' target='_blank'>
          <div class='picture_user_avatar'>
            <img src='<?php echo $picture->user->avatar_url ();?>' />
          </div>
        </a>
      </div>
    </div>
<?php 
  }
      