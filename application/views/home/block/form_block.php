<?php 
	
	$view = new View('home/block');
		
	
		$content = '<a href="'.url::base().'home/wish/add?form='.$item->id.'"><div style="width:90px;height:90px;"><h3>'. $item->title.'</h3></div></a>';
		$color = "#7FA37F";
		
		
		if($item->default_image != null){
			$view->background_image = url::base().'uploads/'.$item->default_image;			
		} else {
			//$view->background_image = url::base().'media/img/addForm.png';
		}

		$view->content = $content;
		$view->color = $color;
		$view->classes = array('form_block', 'incomplete_block');
		echo $view;
?>
