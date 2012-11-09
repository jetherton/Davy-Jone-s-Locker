<?php 

	$view = new View('/home/block');
	$content = '<div class="update_html">'. $item->html .'</div>'.
							'<div class="update_time">'. Helper_Dates::mysql_to_short_relative($item->date_created).'</div>';
	$view->classes = array('update_block');
	$view->content = $content;
	echo $view; 
?>
