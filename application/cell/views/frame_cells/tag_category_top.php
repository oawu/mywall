<?php
  if ($categories) { ?>
    <div id='tag_category_top'>
<?php echo implode ('|',
            array_map (function ($category) {
              return anchor (base_url (array ('tags', implode (' ', $category->tags ()))), $category->name, "target='_blank'");
            }, $categories));?>
    </div>
<?php
  }
