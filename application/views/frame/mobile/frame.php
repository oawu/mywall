<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- <link rel="shortcut icon" href="<?php echo isset ($favicon) ? $favicon:'';?>" /> -->
    <?php echo isset ($meta) ? $meta:''; ?>
    <title data-ori="<?php echo isset ($title) ? $title:''; ?>"><?php echo isset ($title) ? $title:''; ?></title>

    <?php echo isset ($css) ? $css:''; ?>
    <?php echo isset ($javascript) ? $javascript:''; ?>

  </head>
  <body lang="zh-tw">
    <?php echo isset ($hidden) ? $hidden:'';?>
    

    <div id="main_page" data-role="page">
      
      <div id="left_panel" data-role="panel" data-position="left" data-display="reveal">  
        <div class='user clearfix'>
          <div class='avatar'>
            <img src='https://fbcdn-sphotos-c-a.akamaihd.net/hphotos-ak-xpa1/t31.0-8/10298268_869517886394888_9031627202240670647_o.jpg' />
          </div>
          <div class='info'>吳政賢
          </div>
          <div class='info'>comdan66@gmail.com
          </div>
        </div>
        <div class='separate'></div>
        <ul>  
          <li><a data-ajax="false" href="#"><span class='icon-home'></span> 首頁</a></li>  
          <li class='active'><a data-ajax="false" href="#"><span class='icon-image'></span> 我的照片</a></li>  
          <li><a data-ajax="false" href="#"><span class='icon-tag'></span> 追蹤類型</a></li>  
          <!-- <li><a data-ajax="false" href="#"><span class='icon-account-circle'></span> 個人資訊</a></li>   -->
          <li><a data-ajax="false" href="#"><span class='icon-camera'></span> 上傳照片</a></li>  
          <li><a datxa-ajax="false" href="#"><span class='icon-group'></span> 我的群組</a></li>  
          <li><a datxa-ajax="false" href="#"><span class='icon-info3'></span> 關於MyWall</a></li>  
        </ul>  
      </div>

      <div id="header" data-role="header" data-position="fixed" onclick="$.mobile.silentScroll(0)">  
        <div class='padding'>
          <a href="#left_panel"><div class='avatar'><img src='https://fbcdn-sphotos-c-a.akamaihd.net/hphotos-ak-xpa1/t31.0-8/10298268_869517886394888_9031627202240670647_o.jpg' /></div></a>

          <span class="title"><?php echo isset ($title) ? $title:''; ?></span>

          <a href="#right_menu"><div class='icon-cog2'></div></a>
        </div>
      </div>

      <div id='main_content' data-role="main" class="ui-content">
        <?php echo isset ($content) && ($content !== '') ? $content : ''; ?>
      </div>

    </div> 

  </body>
</html>