<div id='user_score'>
  <div class='user_score_area'>
    <div class='big_score'>
      <div class='score'>
  <?php echo number_format ($user->score, 2, '.', ',');?>
      </div>
      <div class='big_score_info'>參與度</div>
    </div>
    <div class='score_detail'>
      <div class='item row'>
        <div class="col-md-5">圖片數</div>
        <div class="col-md-1">:</div>
        <div class="col-md-6">
    <?php echo $user->pictures_count;?>
        </div>
      </div>
      <div class='item row'>
        <div class="col-md-5">回應數</div>
        <div class="col-md-1">:</div>
        <div class="col-md-6">
    <?php echo $user->to_picture_comments_count;?>
        </div>
      </div>
      <div class='item row'>
        <div class="col-md-5">粉絲數</div>
        <div class="col-md-1">:</div>
        <div class="col-md-6">
    <?php echo $user->be_follows_count;?>
        </div>
      </div>
      <div class='item row'>
        <div class="col-md-5">登入數</div>
        <div class="col-md-1">:</div>
        <div class="col-md-6">
    <?php echo $user->sign_in_count;?>
        </div>
      </div>
    </div>
  </div>
</div>