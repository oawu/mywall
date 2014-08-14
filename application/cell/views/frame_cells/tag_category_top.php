<?php
  if ($categories) { ?>
    <div id='tag_category_top'>
<?php echo implode ('|',
            array_map (function ($category) {
              return anchor (base_url (array ('tags', implode (' ', array_map ('urlencode', $category->tags ())))), $category->name, "");
            }, $categories));?>
    </div>
<?php
  }
