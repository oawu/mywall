<?php if (count ($star_details = $picture->star_details ()) && ($all_count = array_sum (array_map (function ($star_detail) { return $star_detail['count'];}, $star_details)))) { ?>
        <div class='star_details'>
          <div class='star_details_content row'>
            <div class='col-md-4 big_score_area'>
              <div class='big_score'>
                <?php echo number_format ($picture->score, 1, '.', ',');?>
              </div>
              <div class='score_count'>
                <?php echo number_format ($all_count, 0, '.', ',');?> 個公開評分的平均分數
              </div>
            </div>
            <div class='col-md-8 counts_area'>
        <?php foreach ($star_details as $star_detail) { ?>
                <div class='star_count row'>
                  <div class='col-md-3'><?php echo $star_detail['score'];?> 顆星
                  </div>
                  <div class='col-md-9'>
                    <div class='score_bar' style='width:<?php echo 100 * $star_detail['percent'];?>px;'></div><span class='score_value' title='<?php echo number_format ($star_detail['count'], 0, '.', ',');?>'><?php echo number_format ($star_detail['count'], 0, '.', ',');?><span>
                  </div>
                </div>
        <?php } ?>

            </div>
          </div>
        </div>
<?php }
