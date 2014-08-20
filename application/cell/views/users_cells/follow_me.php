  <div class='unit'>
    <div class='unit_title'>
      Follow 我的粉絲 (<span><?php echo count ($user->follow_me_users (array ('select' => 'id, name, avatar, uid, register_from', 'order' => 'id DESC'), true));?></span>)
    </div>
    <div class='unit_content_area' id='follow_me'>
<?php if ($user->follow_me_users ()) {
        foreach ($user->follow_me_users () as $follow_me_user) { ?>
          <div class='unit_content' data-id='<?php echo $follow_me_user->id;?>' onClick='window.location.assign ("<?php echo base_url (array ('users', $follow_me_user->id)); ?>");'>
            <img src='<?php echo $follow_me_user->avatar_url (100, 100);?>' />
            <div class='unit_text'><?php echo $follow_me_user->name;?></div>
          </div>
 <?php  }
      } else { ?>
        <div class='no_unit_content'>目前沒有任何人 Follow..</div>
<?php } ?>
    </div>
  </div>