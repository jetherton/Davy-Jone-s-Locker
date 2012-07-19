<?php 

	$view = new View('home/block');
	$field_data = $item->get_block_fields();
	
	$content = '<a href="'.url::base().'home/wish/view?id='.$item->id.'"><div style="width:90px;min-height:90px;max-height:200px;">';
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
			$content .= '<p>'.$fd.'</p>';
		}
	}
	$content .= $item->form->title.'</div></a>';
	
	$view->content = $content;
	echo $view;
?>
