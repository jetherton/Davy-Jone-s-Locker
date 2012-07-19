		
<h1><?php echo $title; ?></h1>

<p><?php echo $description;?></p>

		<div class="block_holder" id="block_container" >
		
		<?php
		if(count($list) == 0)
		{
			echo '<p>'.$empty_string.'</p>';
		}
		foreach($list as $item)
		{
			$view = new View($block_view);
			$view->item = $item;			
			echo $view;
		}?>
		</div>
