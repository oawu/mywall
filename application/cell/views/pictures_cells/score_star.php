<?php
  if (count ($stars = $picture->score_star (5))) {
    foreach ($stars as $star) { ?>
      <span class='icon-star<?php echo $star + 4;?>' data-class='icon-star<?php echo $star + 4;?>'></span>
<?php  
    }
  }