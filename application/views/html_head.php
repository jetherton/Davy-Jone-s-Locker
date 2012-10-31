<meta charset="utf-8">
	<title><?php echo __("site name")." :: ".$title ?></title>
	<link href='http://fonts.googleapis.com/css?family=Quicksand:700' rel='stylesheet' type='text/css'>
	<link href='http://fonts.googleapis.com/css?family=Reenie+Beanie' rel='stylesheet' type='text/css'>
	<?php foreach ($script_files as $file) echo HTML::script($file), PHP_EOL ?>
	<?php foreach ($script_views as $view) echo $view; ?>
	<?php foreach ($styles as $file => $type) echo HTML::style($file, array('media' => $type)), PHP_EOL ?>
