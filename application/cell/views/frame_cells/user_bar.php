<?php 
if (identity ()->get_identity ('sign_in')) { ?>
  <div id='user_bar' class='row'>
    <div class='col-md-6 left'>
      <a href='<?php echo base_url ();?>' class='icon-food4'> 我的牆</a>
    </div>
    <div class='col-md-6 right'>
      <a href='<?php echo base_url (array ('users', identity ()->get_session ('user_id')));?>'>我的頁面</a>
      |
      <a href='<?php echo base_url (array ('platform', 'sign_out'));?>'>登出</a>
    </div>
  </div>
<?php 
} else { ?>
  <div id='user_bar' class='row'>
    <div class='col-md-6 left'>
      <a href='<?php echo base_url ();?>' class='icon-food4'> 我的牆</a>
    </div>
    <div class='col-md-6 right'>
      <a href=''>我要註冊</a>
      |
      <a href=''>我要登入</a>
      |
      <a href='<?php echo facebook ()->login_url ('platform', 'fb_sign_in', 'main');?>' class='icon-facebook22'></a>
    </div>
  </div>
<?php 
}
