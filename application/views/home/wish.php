<div id="right_menu">
	<ul>
		<li>
			<a href="<?php echo url::base().'home/wish/add' ?>"><?php echo __('add wish');?></a>
		</li>
	</ul>
</div>
		
<h2><?php echo __("wishes"); ?></h2>
<p><?php echo __("wishes explanation");?></p>

<table class="list_table">
	<thead>
		<tr class="header">
			<th style="width:200px;">
				<?php echo __('wish');?>
			</th>
			<th style="width:200px;">
				<?php echo __('tags');?>
			</th>
			<th style="width:300px;">
				<?php echo __('last edited');?>
			</th>
		</tr>
	</thead>
	<tbody>
	<?php
		if(count($wishes) == 0)
		{
			echo '<tr><td colspan="3">'.__('you have no wishes').'</td></tr>';
		}
		$i = 0;
		foreach($wishes as $wish){
			$i++;
			$odd_row = ($i % 2) == 0 ? 'class="odd_row"' : '';
		?>

	<tr <?php echo $odd_row; ?>>
		<td style="width:200px;">
			<a href="<?php echo url::base(). 'home/wish/edit?id='.$wish->id?>"> <?php echo $wish->title;?></a>
		</td>
		<td style="width:200px;">
			blank for now
		</td>
		<td style="width:300px;">
			<?php echo $wish->date_modified; ?>
		</td>
	</tr>
	<?php }?>
	</tbody>
</table>
