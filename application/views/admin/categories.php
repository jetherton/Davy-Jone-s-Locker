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


<?php if(count($errors) > 0 )
{
?>
	<div class="errors">
	<?php echo __("error"); ?>
		<ul>
<?php 
	foreach($errors as $error)
	{
?>
		<li> <?php echo $error; ?></li>
<?php
	} 
	?>
		</ul>
	</div>
<?php 
}
?>

<?php if(count($messages) > 0 )
{
?>
	<div class="messages">
		<ul>
<?php 
	foreach($messages as $message)
	{
?>
		<li> <?php echo $message; ?></li>
<?php
	} 
	?>
		</ul>
	</div>
<?php 
}
?>

<table class="list_table">
	<thead>
		<tr class="header">
			<th style="width:200px;">
				<?php echo __('category');?>
			</th>
			<th style="width:400px;">
				<?php echo __('description');?>
			</th>
			<th style="width:200px;">
				<?php echo __('actions');?>
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
			
			$cat_description = str_replace("\n", '<br/>',str_replace("\r", '<br/>',str_replace("'", "\\'", $cat->description)));
		?>

	<tr <?php echo $odd_row; ?>>
		<td style="width:200px;">
			<?php echo $cat->title;?>
		</td>
		<td style="width:400px;">
			<?php echo $cat->description; ?>
		</td>
		<td style="width:200px;">
			<a href="#" onclick="editCat(<?php echo $cat->id?>,<?php echo $cat->order;?>,'<?php echo $cat->title;?>','<?php echo $cat_description;?>'); return false;"> <?php echo __('edit');?></a>
			<a href="#" onclick="deleteCategory(<?php echo $cat->id?>);"> <?php echo __('delete');?></a>
		</td>
	</tr>
	<?php }?>
	</tbody>
</table>

<div id="category_editor">
<h3 id="category_edit_add"><?php echo __('add/edit category'); ?></h3>
<?php 	
	echo Form::open(NULL, array('id'=>'edit_cat_form')); 
	echo Form::hidden('action','edit', array('id'=>'action'));
	echo Form::hidden('cat_id','0', array('id'=>'cat_id'));
	echo '<table><tr><td>';
	echo Form::label('title', __('title').": ");
	echo '</td><td>';
	echo Form::input('title', '', array('id'=>'title', 'style'=>'width:300px;'));
	echo '</td></tr><tr><td>';
	echo Form::label('description', __('description').": ");
	echo '</td><td>';
	echo Form::textarea('description', '', array('id'=>'description', 'style'=>'width:600px;'));
	echo '</td></tr><tr><td>';
	echo Form::label('parent_id', __('parent cat').": ");
	echo '</td><td>';
	echo Form::select('parent_id', $cat_dropdown, null);
	echo '</td></tr><tr><td>';
	echo Form::label('order', __('order').": ");
	echo '</td><td>';
	$orders = array();
	for($i = 1; $i <= count($categories) + 1; $i++)
	{
		$orders[$i] = $i;
	}
	
	echo Form::select('order', $orders, count($categories) + 1,  array('id'=>'order'));
	echo '</td></tr><tr><td>';
	echo Form::submit('edit', __('add edit'), array('id'=>'edit_button'));
	echo '</td><td></td></tr></table>';
	echo Form::close();
?>
</table>
</div>

