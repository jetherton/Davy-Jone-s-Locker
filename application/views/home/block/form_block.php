<?php 
	
	$view = new View('home/block');
		
	
		$content = '<a href="'.url::base().'home/wish/add?form='.$item->id.'"><div style="width:90px;height:90px;"><h3>'. $item->title.'</h3></div></a>';
		$color = "#7FA37F";
		$view->content = $content;
		$view->background_image = url::base().'media/img/addForm.png';
		$view->color = $color;
		$view->classes = array('form_block', 'incomplete_block');
		echo $view;
?>
