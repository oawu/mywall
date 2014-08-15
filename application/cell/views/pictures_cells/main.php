<div id='main'>
  <div id='main_img'>
    <img src='<?php echo $picture->file_name->url ('640xW');?>' />
  </div>

  <div id='main_not_pic'>
    <div id='main_info' class='row'>
      <div class="col-md-7 main_name">
        <a href='<?php echo base_url (array ('users', $picture->user_id));?>'>
    <?php echo $picture->user->name;?>
        </a>
      </div>
      <div class="col-md-5 like">
        <div class="fb-like" data-href="<?php echo base_url (array ('pictures', $picture->id));?>" data-width="120" data-send="false" data-layout="button_count" data-action="like" data-show-faces="false" data-share="true"></div>
      </div>
    </div>
    <div id='main_user_avatar'>
      <a href='<?php echo base_url (array ('users', $picture->user_id));?>'>
        <img src='<?php echo $picture->user->avatar_url (80, 80);?>' />
      </a>
    </div>
    <div id='main_text'>
<?php echo $picture->text;?>
    </div>
    <div id='main_bottom' class='row'>
      <div class="col-md-8 main_tags">
  <?php if (count ($picture->tags)) {
          foreach ($picture->tags as $i => $tag) {
            if ($i < config ('pictures_controller_config', 'main_tags_max_length')) { ?>
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