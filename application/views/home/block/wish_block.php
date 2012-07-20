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
			$color = $i % 4;
			$color = dechex($color * 50);
			$color = strlen($color) == 1 ? '0'.$color : $color;
			$color = 'cccc'.$color;
			
			$style = "";
			switch($i % 4)
			{
				case 0:
					$style='font-weight:bold;';
					break;
				case 1:					
					$style='font-size:120%;';
				case 2:
					$style='font-style:italic;';
				case 3:
					$style='font-size:75%;';
			}	
				
			$content .= '<span style="color:#'.$color.';'.$style.'"> '.$fd.'</span><br/>';
		}
	}
	$content .= /*$item->form->title.*/'</div></a>';
	
	$view->content = $content;
	echo $view;
?>
