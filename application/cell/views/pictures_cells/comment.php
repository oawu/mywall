<div class='comment'>
  <div class='content'>
    <div class='row comment_user_info'>
      <div class='col-md-8 comment_user_name'>
        <a href='<?php echo base_url (array ('users', $comment->user_id));?>'>
          <?php echo $comment->user->name;?>
        </a>
      </div>
      <div class='col-md-4 timeago' data-time='<?php echo $comment->created_at;?>'></div>
    </div>
    <div class='comment_area'>
      <div class='comment_text'>
  <?php echo $comment->text;?>
      </div>
    </div>
  </div>
  <a href='<?php echo base_url (array ('users', $comment->user_id));?>'>
    <div class='comment_user_avatar other_comments_user_avatar'>
      <img src='<?php echo $comment->user->avatar_url (50, 50);?>' />
    </div>
  </a>
<?php
  if (identity ()->get_identity ('sign_in') && ((identity ()->get_session ('user_id') == $comment->user_id) || identity ()->get_identity ('admins'))) { ?>
    <div class='delete_comment'>
      <button type="button" class='btn btn-danger btn-sm' name='delete_comment' data-loading-text="請稍候.." data-comment_id='<?php echo $comment->id;?>'>x</button>
    </div>
<?php
  } ?>
</div>