<t2>新增 <?php echo $feature_name?> <input type='button' data-is_save='<?php echo verifyObject ($view) ? 'true' : 'false';?>' value='' data-value='確認 <?php echo $feature_name?>' class='OA-ui-OA_Button' id='create_view'/> <input type="button" class='OA-ui-OA_Button' value="回 <?php echo $feature_name; ?> 列表" onClick='window.location.assign ("<?php echo $back_url; ?>");'/></t2>
        


<div id='view' data-latitude='<?php echo $view_latitude;?>' data-longitude='<?php echo $view_longitude;?>' data-heading='<?php echo $view_heading;?>' data-pitch='<?php echo $view_pitch;?>' data-zoom='<?php echo $view_zoom;?>'>
  <div id='map' data-latitude='<?php echo $object->latitude;?>' data-longitude='<?php echo $object->longitude;?>'></div>
</div>