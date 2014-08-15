<?php 
  if ($promos) { ?>
    <div id='promos' class='row'>
<?php if (isset ($promos['promo1'])) { ?>
        <a href='<?php echo $promos['promo1']->link;?>' target='_blank'>
          <div class='col-md-5' id='promo1'>
            <div class='promo1_img'>
              <img src='<?php echo $promos['promo1']->file_name->url ('promo1');?>' />
            </div>
            <div class='promo1_text'>
              <div class='promo1_text_box'>
                <h4><?php echo $promos['promo1']->title;?></h4>
                <?php echo $promos['promo1']->text;?>
              </div>
            </div>
          </div>
        </a>
<?php } ?>
<?php if (isset ($promos['promo2']) && isset ($promos['promo3']) && isset ($promos['promo4']) && isset ($promos['promo5'])) { ?>
        <div class='col-md-4' id='promo2-5'>
          <div class='row'>
            <a href='<?php echo $promos['promo2']->link;?>' target='_blank'>
              <div class='col-md-6' id='promo2'>
                <img src='<?php echo $promos['promo2']->file_name->url ('promo2');?>'>
                <div class='promo2-5_text'>
                  <?php echo $promos['promo2']->title;?>
                </div>
              </div>
            </a>
            
            <a href='<?php echo $promos['promo3']->link;?>' target='_blank'>
              <div class='col-md-6' id='promo3'>
                <img src='<?php echo $promos['promo3']->file_name->url ('promo3');?>'>
                <div class='promo2-5_text'>
                  <?php echo $promos['promo3']->title;?>
                </div>
              </div>
            </a>
          </div>
          <div class='row'>
            <a href='<?php echo $promos['promo4']->link;?>' target='_blank'>
              <div class='col-md-6' id='promo4'>
                <img src='<?php echo $promos['promo4']->file_name->url ('promo4');?>'>
                <div class='promo2-5_text'>
                  <?php echo $promos['promo4']->title;?>
                </div>
              </div>
            </a>

            <a href='<?php echo $promos['promo5']->link;?>' target='_blank'>
              <div class='col-md-6' id='promo5'>
                <img src='<?php echo $promos['promo5']->file_name->url ('promo5');?>'>
                <div class='promo2-5_text'>
                  <?php echo $promos['promo5']->title;?>
                </div>
              </div>
            </a>
          </div>
        </div>
<?php } ?>

<?php if (isset ($promos['promo6'])) { ?>
        <a href='<?php echo $promos['promo6']->link;?>' target='_blank'>
          <div class='col-md-3' id='promo6'>
            <div class='promo6_img'>
              <img src='<?php echo $promos['promo6']->file_name->url ('promo6');?>'>
            </div>
            <div class='promo6_text'>
              <?php echo $promos['promo6']->text;?>
            </div>
          </div>
        </a>
<?php } ?>
    </div>
<?php 
  }