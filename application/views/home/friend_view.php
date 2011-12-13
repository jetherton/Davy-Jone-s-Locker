<div id="right_menu">
	put remove friend stuff here
</div>
		
<h2><?php echo $friend->first_name. ' '. $friend->last_name; ?></h2>
<p><?php echo __("friend view");?></p>



<table class="list_table">
	<tr>
		<th>
			<?php echo __('wish');?>
		</th>
		<th>
			<?php echo __('tags');?>
		</th>
	</tr>
	
	<?php
		if(count($wishes) == 0)
		{
			echo '<tr><td colspan="3">'.$friend->first_name.__('has shared no wishes').'</td></tr>';
		}
		$i = 0;
		foreach($wishes as $wish){
			$i++;
			$odd_row = ($i % 2) == 0 ? 'class="odd_row"' : '';
		?>

	<tr <?php echo $odd_row; ?>>
		<td>
			<a href="<?php echo url::base(). 'home/wish/view?id='.$wish->id?>"> <?php echo $wish->title;?></a>
		</td>
		<td>
			blank for now
		</td>
	</tr>
	<?php }?>
</table>
