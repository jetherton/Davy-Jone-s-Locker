<?php 

	$view = new View('home/block');
	$field_data = $item->get_block_fields();
	
	$content = '<a href="'.url::base().'home/wish/view?id='.$item->id.'"><div class="inner_wish_block">';
	$i = 0;
	foreach($field_data as $fd)
	{
		$i++;
		if($i == 1)
		{
			$content .= '<h3>'.$fd.'</h3>';
		}
		else
		{
			$color = 'ffffff';
			
			$style = "";
			
			$content .= '<span style="color:#'.$color.';'.$style.'"> '.$fd.'</span><br/>';
		}
	}
	$content .= /*$item->form->title.*/'</div></a>';
	if($item->user_block_image){
		$view->background_image = URL::base().'uploads/'.$item->user_block_image;
	}
	$view->content = $content;
	$view->classes = array('wish_block');
	echo $view;
?>
