<?php
  // 匯入相關 components
  echo '<meta http-equiv="Content-type" content="text/html; charset=utf-8" /><pre>';
  if ($components) {
    foreach ($components as $component) {
      echo $component;
    }
  } ?>
  <!-- 表單 -->

<!-- Load Feather code -->
<!-- <script type="text/javascript" src="http://feather.aviary.com/js/feather.js"></script> -->

<!-- Instantiate Feather -->
<script type='text/javascript'>
   var featherEditor = new Aviary.Feather({
       apiKey: '098849b5d75ca9ad',
       apiVersion: 3,
       theme: 'dark', // Check out our new 'light' and 'dark' themes!
       tools: 'all',
       appendTo: '',
       language: 'zh_HANT',
       onSave: function(imageID, newURL) {
           var img = document.getElementById(imageID);
           img.src = newURL;
           console.info (newURL);
       },
       onError: function(errorObj) {
           alert(errorObj.message);
       },
       postUrl: "<?php echo base_url (array ('postform', 'submit_page'));?>"
   });
   function launchEditor(id, src) {
       featherEditor.launch({
           image: id,
           url: src
       });
      return false;
   }
</script>

<div id='injection_site'></div>

<img id='image1' src='http://style.ioa.tw/upload/pictures/file_name/0/0/1/39/640xW_1189952472_53faa6c47a11e.jpg'/>

<!-- Add an edit button, passing the HTML id of the image and the public URL of the image -->
<p><input type='image' src='http://images.aviary.com/images/edit-photo.png' value='Edit photo' 
  onclick="return launchEditor('image1', 'http://style.ioa.tw/upload/pictures/file_name/0/0/1/39/640xW_1189952472_53faa6c47a11e.jpg');" /></p>
<!-- 
  <form name='fm' method='POST' action='<?php echo base_url (array ('test', 'submit_page'));?>' enctype='multipart/form-data'>
    <input type='text' name='account' class='form-control account' value='oa'/>
    <br/>
    <input type='password' name='passwor' class='form-control passwor' value='1234567889'/>
    <br/>
    <input type='button' id='submit_button' class='OA-ui-OA_Button' value='submit'/>
  </form> -->