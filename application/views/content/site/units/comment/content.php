<div class='comment'>
  <div class='row'>
    <div class="col-md-2 comment_user_pic_col">
      <div class='comment_user_pic'>
        <img src='<?php echo $unit_comment->user->avatar_url (60, 60); ?>' />
      </div>
      <span class='comment_user_name'><a href='https://www.facebook.com/<?php echo $unit_comment->user->uid;?>' target='_blank'><?php echo $unit_comment->user->name;?></a></span>
    </div>
    <div class="col-md-10 comment_area_col">
      <div class='comment_area'>
        <div class='comment_message'><?php echo $unit_comment->message;?></div>
        <div class='comment_bottom row'>
          <div class="col-md-6 like">
            <div class="fb-like" data-href="<?php echo base_url (array ('units', 'comment', $unit_comment->id));?>" data-width="120" data-send="false" data-layout="button_count" data-action="like" data-show-faces="false" data-share="false"></div>
          </div>
          <div class="col-md-6 created_at" data-time='<?php echo $unit_comment->created_at;?>'><?php echo $unit_comment->created_at;?></div>
        </div>
      </div>                    
<?php if ($that->identity->get_identity ('sign_in') && (($that->identity->get_session ('user_id') == $unit_comment->user_id) || $that->identity->get_identity ('admins'))) { ?>
        <div class='delete_comment'>
          <button type="button" class='btn btn-danger btn-sm' name='delete_comment' data-loading-text="請稍候.." data-unit_comment_id='<?php echo $unit_comment->id;?>'>x</button>
        </div>
<?php } ?>
    </div>
  </div>
</div>