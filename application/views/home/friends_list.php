

<table class="list_table">
	<tr>
		<th>
			<?php echo __('friend');?>
		</th>
		<th>
			<?php echo __('groups');?>
		</th>		
	</tr>
	
	<?php
		if(count($friends) == 0)
		{
			echo '<tr><td colspan="3">'.__('you have no friends').'</td></tr>';
		}
		$i = 0;
		foreach($friends as $friend){
			$i++;
			$odd_row = ($i % 2) == 0 ? 'class="odd_row"' : '';
		?>

	<tr <?php echo $odd_row; ?>>
		<td>
			<a href="<?php echo url::base(). 'home/friends/view?id='.$friend->id?>"> <?php echo $friend->first_name . ' ' . $friend->last_name;?></a>
		</td>
		<td>
			Group info
		</td>
	</tr>
	<?php }?>
</table>
