<?php if (!identity ()->get_identity ('sign_in')) { ?>
        <div id='be_comment'>
            <a class="btn btn-primary btn-sm" href='<?php echo facebook ()->login_url ('platform', 'fb_sing_in', 'pictures', $picture->id);?>'>我要留言!</a>
        </div>
<?php } else { ?>
        <div id='to_comment'>
        <div class='to_comment_area'>
          <div class='text_area'>
            <div class='comment_loadding' id='comment_loadding'></div>
            <input type='text' placeholder='在想些什麼?' value='' class='to_comment_text' id='to_comment_text' name='to_comment_text' />
          </div>
          <div class='to_comment_bottom'>
            <button type="button" id='submit_comment' name='submit_comment' class="btn btn-primary btn-sm submit_comment" data-loading-text="請稍候.."
            data-id='<?php echo $picture->id; ?>'
            data-user_id='<?php echo identity ()->get_session ('user_id'); ?>'>
              留言
            </button>
          </div>
          <div class='comment_user_avatar'>
            <img src='<?php echo identity ()->user ()->avatar_url (50, 50);?>' />
          </div>
        </div>
      </div>
<?php } ?>
