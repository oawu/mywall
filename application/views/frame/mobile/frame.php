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
    <!-- <div data-role="page" id="pageone">
      <div data-role="header">
        <h1>在此处写入标题</h1>
      </div>

      <div data-role="content">
        <p>在此处写入正文</p>
      </div>

      <div data-role="footer">
        <h1>在此处写入页脚文本</h1>
      </div>
    </div>  -->
  </body>
</html>