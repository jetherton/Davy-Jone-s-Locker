

<table class="list_table">
	<thead>
		<tr class="header">
			<th>
				<?php echo __('name');?>
			</th>
			<th>
				<?php echo __('delete');?>
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
					<a href="<?php echo url::base();?>home/friends/view?id=<?php echo $passer->id;?>"> <?php echo $passer->full_name(); ?></a>
				</td>
				<td>
					<a href="#" onclick="deletePasser(<?php echo $passer->id; ?>); return false;"><?php echo __('delete'); ?></a>
				</td>
				
			</tr>
	<?php }
	
		echo '<tr><td colspan="2" >';
		echo '<a class="button" style="float:right;" rel="#overlay"  title="'.__('add passers').'" href="'. url::base(). 'home/passing/addpasserfield" >'.__('add passers').'</a>';		
		echo '</td></tr>';
	?>
	</tbody>
</table>
