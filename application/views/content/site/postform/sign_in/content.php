<?php
  if ($components)
    foreach ($components as $component)
      echo $component;
  $facebook = facebook (); ?>
<div id='pf_root'>
  <div class='pf_area'>
    <div class='pf_title'>立即登入，並上傳照片記錄自己吧！</div>
    <div class='pf_fb'>
      <a href='<?php echo call_user_func_array (array ($facebook, 'login_url'), array_merge (array ('platform', 'fb_sign_in', implode ('/', $current_uri))));?>'>
        <div class='icon-facebook3 pf_fb_button'>立馬使用 Facebook 登入</div>
      </a>
    </div>
  </div>
</div>