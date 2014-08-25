<?php
  echo render_cell ('frame_cells', 'user_bar');
  echo render_cell ('frame_cells', 'main_banner');
  echo render_cell ('frame_cells', 'feature_bar');
  echo render_cell ('frame_cells', 'tag_category_top');
  echo render_cell ('users_cells', 'banner', $user); ?>

<div class='user_info'>
  <div class='user_feature_area_left'>
  <?php if (identity ()->get_identity ('sign_in')) {
        if (identity ()->get_session ('user_id') != $user->id) {
          if (!$user->follow_me_users (array ('select' => 'id')) || !in_array (identity ()->get_session ('user_id'), field_array ($user->follow_me_users (), 'id'))) { ?>
            <a class='icon-user-add jqui_tooltip' title='我想要 Follow 他！' data-is_enable='1' data-user_id='<?php echo identity ()->get_session ('user_id');?>' data-be_user_id='<?php echo $user->id;?>'></a>
    <?php } else { ?>
            <a class='icon-user-delete jqui_tooltip' title='我不想 Follow 他！' data-is_enable='1' data-user_id='<?php echo identity ()->get_session ('user_id');?>' data-be_user_id='<?php echo $user->id;?>'></a>
    <?php }
        }
      } else { ?>
        <a class='icon-user-add jqui_tooltip' href='<?php echo facebook ()->login_url ('platform', 'fb_sign_in', 'users', $user->id);?>' title='我想要 Follow 他！'></a>
<?php } ?>
  </div>
  <div class='user_feature_area_right'>
<?php
    if (identity ()->get_identity ('sign_in') && (identity ()->get_session ('user_id') == $user->id)) { ?>
      <a class='icon-camera6 jqui_tooltip fancybox_po_picture' title='PO圖片'></a>
<?php
    } ?>
    <a class='icon-uptime jqui_tooltip' href='<?php echo base_url (array ('users', $user->id));?>' title='時間軸'></a>
  </div>
</div>
<div id='pictures' data-user_id='<?php echo $user->id;?>' data-next_id='0'></div>
