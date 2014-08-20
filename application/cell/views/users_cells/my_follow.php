  <div class='unit'>
    <div class='unit_title'>
      我 Follow 的人 (<span><?php echo count ($user->be_follow_users (array ('select' => 'id, name, avatar, uid, register_from', 'order' => 'id DESC')));?></span>)
    </div>
    <div class='unit_content_area' id='my_follow'>
<?php if ($user->be_follow_users ()) {
        foreach ($user->be_follow_users () as $be_follow_user) { ?>
          <div class='unit_content' data-id='<?php echo $be_follow_user->id;?>' onClick='window.location.assign ("<?php echo base_url (array ('users', $be_follow_user->id)); ?>");'>
            <img src='<?php echo $be_follow_user->avatar_url (100, 100);?>' />
            <div class='unit_text'><?php echo $be_follow_user->name;?></div>
          </div>
 <?php  }
      } else { ?>
        <div class='no_unit_content'>目前沒有 Follow 任何人..</div>
<?php } ?>
    </div>
  </div>