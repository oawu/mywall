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
    <?php echo ''/*isset ($content) && ($content !== '') ? $content : ''*/; ?>

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
        <div id='pictures' data-columns >



          <div class='picture'>s
          </div>
          <div class='picture'>
            ddsa<br/>
            ddsa<br/>
          </div>
          <div class='picture'>s
          </div>
          <div class='picture'>
            d
          </div>
          <div class='picture'>s
          </div>
          <div class='picture'>
            d
          </div>
          <div class='picture'>s
          </div>
          <div class='picture'>
            d
          </div>
          <div class='picture'>s
          </div>
          <div class='picture'>
            d
          </div>
<!-- 
            <div class='img imgLiquid'>
              <img src='http://front-pic.style.fashionguide.com.tw/uploads/promo/picture/874/big_promo_picture_544081788f601.jpg' />
            </div>

            <div class='user'>
              <div class='avatar'>
                <img src='http://front-pic.style.fashionguide.com.tw/uploads/user/avatar/a3/fb/thumb_small_user_avatar_53479cfa3f89d.jpg' />
              </div>
              <div class='name'>
                yorkshire
              </div>
            </div>

            <div class='content'>
              抓緊夏日的尾巴！！ 就這樣穿～(σ・w・)σ Source: Google
            </div>

            <div class='info row'>
              <div class='col-md-6 stars'>
                <span class='icon-star8'></span>
                <span class='icon-star8'></span>
                <span class='icon-star7'></span>
                <span class='icon-star6'></span>
                <span class='icon-star6'></span>
              </div>
              <div class='col-md-6 timeago' data-time="2014-10-16 23:16:12">das</div>
            </div> -->




        </div>
      </div>

    </div> 

  </body>
</html>