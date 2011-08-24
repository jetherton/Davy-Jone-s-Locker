<meta charset="utf-8">
<title><?php echo __("site name")." :: ".$title ?></title>
  <?php foreach ($styles as $file => $type) echo HTML::style($file, array('media' => $type)), PHP_EOL ?>
  <?php foreach ($scripts as $file) echo HTML::script($file), PHP_EOL ?>