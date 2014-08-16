<?php 
  if ($picture->file_name->url ('230xW')) { ?>
    <div class='picture'>
      <a href='<?php echo base_url (array ('pictures', $picture->id));?>'>
        <div class='picture_pic'>
          <img src='<?php echo $picture->file_name->url ('230xW');?>' />
        </div>
      </a>
      <div class='picture_not_pic'>
        <div class='picture_user_name'>
          <a href='<?php echo base_url (array ('users', $picture->user_id));?>'>
            <?php echo $picture->user->name;?>
          </a>
        </div>
        <div class='picture_text'>
          <?php echo $picture->text;?>
        </div>
        <div class='picture_info row'>
          <div class='col-md-6 left'>
            <?php echo render_cell ('pictures_cells', 'score_star', $picture); ?>
          </div>
          <div class='col-md-6 right timeago' data-time='<?php echo $picture->created_at;?>'></div>
        </div>
        <a href='<?php echo base_url (array ('users', $picture->user_id));?>'>
          <div class='picture_user_avatar'>
            <img src='<?php echo $picture->user->avatar_url (50, 50);?>' />
          </div>
        </a>
      </div>
    </div>
<?php 
  }
      