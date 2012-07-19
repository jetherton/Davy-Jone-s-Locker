<?php defined('SYSPATH') or die('No direct script access.');
/***********************************************************
* Categories.php - View
* This software is copy righted by Etherton Technologies Ltd. 2011
* Writen by John Etherton <john@ethertontech.com>
* Started on 12/06/2011
*************************************************************/
?>

<div id="right_menu" style="padding:12px;">
		<a class="button" id="back_to_form_button" href="<?php echo url::base(); ?>admin/forms/edit?id=<?php echo $form_id;?>">&lt;&lt; <?php echo __('back to form');?></a>
</div>
		
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
	echo Form::textarea('description', $data['description'], array('id'=>'description', 'style'=>'width:600px;'));
	echo '</td></tr><tr><td>';
	echo Form::label('order', __('order').": ");
	echo '</td><td>';
	echo Form::select('order', $orders, $data['order'],  array('id'=>'order'));
	echo '</td></tr><tr><td>';
	echo Form::label('required', __('required').": ");
	echo '</td><td>';
	echo Form::checkbox('required', 1, $data['required'] == 1,  array('id'=>'required'));
	echo '</td></tr><tr><td>';
	echo Form::label('type', __('type').": ");
	echo '</td><td>';
	echo Form::select('type', Model_Formfields::get_human_readable_type(), $data['type'],  array('id'=>'type', 'onclick'=>'typeChange();'));
	echo '</td></tr><tr><td>';	
	echo Form::label('islockable', __('is lockable').": ");
	echo '</td><td>';
	echo Form::checkbox('islockable', 1, $data['islockable'] == 1,  array('id'=>'islockable'));
	echo '</td></tr><tr><td>';
	echo Form::label('show_in_block', __('show in block').": ");
	echo '</td><td>';
	echo Form::checkbox('show_in_block', 1, $data['show_in_block'] == 1,  array('id'=>'show_in_block'));
	echo '</td></tr><tr><td>';	
	echo Form::submit('edit', __('add edit'), array('id'=>'edit_button'));
	echo '</td><td></td></tr></table>';
	echo Form::close();
?>
</table>
</div>



<div style="float:clear; display:none;" id="options_div" >
<h2><?php echo __('form options');?></h2>

<?php 	
	echo Form::open(NULL, array('id'=>'edit_formfieldoption_form')); 
	echo Form::hidden('action','edit_option', array('id'=>'option_action'));
	echo Form::hidden('id',0, array('id'=>'formfieldoption_id'));
	echo Form::hidden('formfield_id',$data['id'], array('id'=>'formfield_id'));
	echo '<table><tr><td>';
	echo Form::label('title', __('title').": ");
	echo '</td><td>';
	echo Form::input('title', null, array('id'=>'option_title', 'style'=>'width:300px;'));
	echo '</td></tr><tr><td>';
	echo Form::label('description', __('description').": ");
	echo '</td><td>';
	echo Form::input('description', null, array('id'=>'option_description', 'style'=>'width:300px;'));
	echo '</td></tr><tr><td>';
	echo Form::label('order', __('order').": ");
	echo '</td><td>';
	echo Form::select('order', $option_orders, null,  array('id'=>'option_order'));
	echo '</td><td></td></tr></table>';
	echo Form::close();
?>
<br/>
<a class="button" id="add_field_button" href="#" onclick="addEditOption();"><?php echo __('add option');?></a>
<br/><br/>

<table class="list_table">
	<thead>
		<tr class="header">
			<th style="width:200px;">
				<?php echo __('Label');?>
			</th>
			<th style="width:300px;">
				<?php echo __('description');?>
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
		<td style="width:300px;">
			<?php echo $ffo->description;?>
		</td>
		<td style="width:200px;">
			<a href="#" onclick="editFormFieldOption('<?php echo $ffo->title;?>',
			    '<?php echo $ffo->description;?>',
				<?php echo $ffo->order;?>,
				<?php echo $ffo->id;?>); return false;"><?php echo __('edit');?></a>
			<a href="#" onclick="deleteFormFieldOption(<?php echo $ffo->id?>);"> <?php echo __('delete');?></a>
		</td>
	</tr>
	<?php }?>
	</tbody>
</table>
</div>


