<?php defined('SYSPATH') or die('No direct script access.');
/***********************************************************
* Categories.php - View
* This software is copy righted by Etherton Technologies Ltd. 2011
* Writen by John Etherton <john@ethertontech.com>
* Started on 12/06/2011
*************************************************************/
?>
		
<h2><?php echo $header ?></h2>
<p><?php echo __("form field edit explanation");?></p>


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

<div id="form_field_editor">
<?php 	
	echo Form::open(NULL, array('id'=>'edit_formfield_form')); 
	echo Form::hidden('action','edit', array('id'=>'action'));
	echo Form::hidden('form_id',$form_id, array('id'=>'form_id'));
	echo '<table><tr><td>';
	echo Form::label('title', __('title').": ");
	echo '</td><td>';
	echo Form::input('title', $data['title'], array('id'=>'title', 'style'=>'width:300px;'));
	echo '</td></tr><tr><td>';
	echo Form::label('description', __('description').": ");
	echo '</td><td>';
	echo Form::input('description', $data['description'], array('id'=>'description', 'style'=>'width:300px;'));
	echo '</td></tr><tr><td>';
	echo Form::label('order', __('order').": ");
	echo '</td><td>';
	echo Form::select('order', $orders, $data['order'],  array('id'=>'order'));
	echo '</td></tr><tr><td>';
	echo Form::label('required', __('required').": ");
	echo '</td><td>';
	echo Form::checkbox('required', $data['required'],  array('id'=>'required'));
	echo '</td></tr><tr><td>';
	echo Form::label('type', __('type').": ");
	echo '</td><td>';
	echo Form::select('type', Model_Formfields::get_human_readable_type(), $data['type'],  array('id'=>'type', 'onclick'=>'typeChange();'));
	echo '</td></tr><tr><td>';	
	echo Form::submit('edit', __('add edit'), array('id'=>'edit_button'));
	echo '</td><td></td></tr></table>';
	echo Form::close();
?>
</table>
</div>

<a style="margin-left:300px;"class="button" id="back_to_form_button" href="<?php echo url::base(); ?>admin/forms/edit?id=<?php echo $form_id;?>">&lt;&lt; <?php echo __('back to form');?></a>
<br/><br/>

<div style="float:clear; display:none;" id="options_div" >
<h2><?php echo __('form options');?></h2>

<a class="button" id="add_field_button" href="<?php echo url::base(); ?>admin/formfields/edit?id=<?php echo $form_id;?>"><?php echo __('add option');?></a>
<br/><br/>

<table class="list_table">
	<thead>
		<tr class="header">
			<th style="width:200px;">
				<?php echo __('Label');?>
			</th>
			<th style="width:200px;">
				<?php echo __('actions');?>
			</th>
		</tr>
	</thead>
	<tbody>
	<?php
		if(count($form_field_options) == 0)
		{
			echo '<tr><td colspan="4">'.__('you have no options').'</td></tr>';
		}
		$i = 0;
		foreach($form_field_options as $ffo){
			$i++;
			$odd_row = ($i % 2) == 0 ? 'class="odd_row"' : '';
		?>

	<tr <?php echo $odd_row; ?>>
		<td style="width:200px;">
			<?php echo $ffo->title;?>
		</td>
		<td style="width:200px;">
			<a href="<?php echo url::base(); ?>admin/formfields/edit?id=<?php echo $ffo->id;?>" <?php echo __('edit');?></a>
			<a href="#" onclick="deleteFormField(<?php echo $ffo->id?>);"> <?php echo __('delete');?></a>
		</td>
	</tr>
	<?php }?>
	</tbody>
</table>
</div>


