<?php defined('SYSPATH') or die('No direct script access.');
/***********************************************************
* Categories.php - View
* This software is copy righted by Etherton Technologies Ltd. 2011
* Writen by John Etherton <john@ethertontech.com>
* Started on 12/06/2011
*************************************************************/
?>
		
<h2><?php echo __("categories"); ?></h2>
<p><?php echo __("categories explanation");?></p>

<table class="list_table">
	<thead>
		<tr class="header">
			<th style="width:200px;">
				<?php echo __('category');?>
			</th>
			<th style="width:200px;">
				<?php echo __('description');?>
			</th>
		</tr>
	</thead>
	<tbody>
	<?php
		if(count($categories) == 0)
		{
			echo '<tr><td colspan="3">'.__('you have no categories').'</td></tr>';
		}
		$i = 0;
		foreach($categories as $cat){
			$i++;
			$odd_row = ($i % 2) == 0 ? 'class="odd_row"' : '';
		?>

	<tr <?php echo $odd_row; ?>>
		<td style="width:200px;">
			<a href="<?php echo url::base(). 'home/wish/edit?id='.$cat->id?>"> <?php echo $cat->title;?></a>
		</td>
		<td style="width:200px;">
			<?php echo $cat->description; ?>
		</td>
	</tr>
	<?php }?>
	</tbody>
</table>
