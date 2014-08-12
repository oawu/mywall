<?php
  if ($categories) { ?>
    <div id='tag_category_block9s'>
  <?php foreach ($categories as $category) { ?>
      <div class='tag_category_block9'>
        <div class='block9_title'><?php echo $category->name;?></div>
        <div class='block9_img'>
          <img src='<?php echo $category->file_name->url ();?>' />
    <?php if (isset ($category->memo->picture_ids) && $category->memo->picture_ids) {
            foreach ($category->memo->picture_ids as $i => $picture_id) { ?>
              <a href='<?php echo base_url (array ('pictures', $picture_id));?>' target='_blank' class='<?php echo 'block9_' . $i;?>'></a>
      <?php }
          } ?>
        </div>
        <div class='block9_info row'>
          <div class='col-md-6 left'>
            有<span><?php echo isset ($category->memo->picture_count) ? $category->memo->picture_count : 0;?></span>張圖
          </div>
          <div class='col-md-6 right'>
            <a href=''>看更多！</a>
          </div>
        </div>
      </div>    
  <?php } ?>
    </div>
<?php
  }
