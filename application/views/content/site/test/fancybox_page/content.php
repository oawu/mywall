<?php
  // 匯入相關 components
  if ($components) {
    foreach ($components as $component) {
      echo $component;
    }
  } ?>
  <!-- 表單 -->
  <form name='fm' method='POST' action='<?php echo base_url (array ('test', 'submit_page'));?>' enctype='multipart/form-data'>
    <input type='text' name='account' class='form-control account' value='oa'/>
    <br/>
    <input type='password' name='passwor' class='form-control passwor' value='1234567889'/>
    <br/>
    <input type='button' id='submit_button' class='OA-ui-OA_Button' value='submit'/>
  </form>