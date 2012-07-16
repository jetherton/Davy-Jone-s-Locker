

<table class="list_table">
	<thead>
		<tr class="header">
			<th>
				<?php echo __('name');?>
			</th>
			<th>
				<?php echo __('username') . ' / ' . __('email');?>
			</th>		
		</tr>
	</thead>
	<tbody>
	<?php
		if(count($passers) == 0)
		{
			echo '<tr><td colspan="2">'.__('you have no passers').'</td></tr>';			
		}
		$i = 0;
		foreach($passers as $passer){			
			$i++;
			$odd_row = ($i % 2) == 0 ? 'class="odd_row"' : '';
		?>

	<tr <?php echo $odd_row; ?>>
		<td>
			passer name
		</td>
		<td>
			email or user name 
		</td>
		
	</tr>
	<?php }
		echo '<tr><td colspan="2"><a href="#" onclick="return false;">'.__('add passers').'</a></td></tr>';
	?>
	</tbody>
</table>
