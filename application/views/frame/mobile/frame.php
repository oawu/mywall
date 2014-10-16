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

    <div id='container'>
      <?php echo isset ($content) && ($content !== '') ? $content : ''; ?>
    </div>
    
  </body>
</html>