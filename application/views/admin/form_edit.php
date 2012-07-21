<?php defined('SYSPATH') or die('No direct script access.');
/***********************************************************
* Categories.php - View
* This software is copy righted by Etherton Technologies Ltd. 2011
* Writen by John Etherton <john@ethertontech.com>
* Started on 12/06/2011
*************************************************************/
?>
		
<h2><?php echo $header ?></h2>
<p><?php echo __("form edit explanation");?></p>

<a class="button" id="add_back_to_forms" href="<?php echo url::base(); ?>admin/forms"><?php echo __('back to forms');?></a>

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

<div id="category_editor">
<?php 	
	echo Form::open(NULL, array('id'=>'edit_form_form')); 
	echo Form::hidden('action','edit', array('id'=>'action'));
	echo Form::hidden('form_id','0', array('id'=>'form_id'));
	echo '<table><tr><td>';
	echo Form::label('title', __('title').": ");
	echo '</td><td>';
	echo Form::input('title', $data['title'], array('id'=>'title', 'style'=>'width:300px;'));
	echo '</td></tr><tr><td>';
	echo Form::label('description', __('description writer').": ");
	echo '</td><td>';
	echo Form::textarea('description', $data['description'], array('id'=>'description', 'style'=>'width:600px;'));
	echo '</td></tr><tr><td>';
	echo Form::label('description_reader', __('description reader').": ");
	echo '</td><td>';
	echo Form::textarea('description_reader', $data['description_reader'], array('id'=>'description_reader', 'style'=>'width:600px;'));	
	echo '</td></tr><tr><td>';
	echo Form::label('category_id', __('category').": ");
	echo '</td><td>';
	echo Form::select('category_id', $categories, $data['category_id'],  array('id'=>'category_id', 'onchange'=>'updateOrder();'));
	echo '</td></tr><tr><td>';	
	echo Form::label('order', __('order').": ");
	echo '</td><td>';
	$orders = array();	
	echo Form::select('order', $orders, count($categories) + 1,  array('id'=>'order'));
	echo '</td></tr><tr><td>';
	echo Form::label('more_than_one', __('more than one').": ");
	echo '</td><td>';
	echo Form::checkbox('more_than_one', 'more_than_one' , $data['more_than_one'] == '1', array('id'=>'more_than_one'));
	
	echo '</td></tr><tr><td>';
	echo Form::label('show_location', __('show location').": ");
	echo '</td><td>';
	echo Form::checkbox('show_location', 'show_location' , $data['show_location'] == '1', array('id'=>'show_location'));
	
	echo '</td></tr><tr><td>';
	echo Form::label('location_name', __('location name').": ");
	echo '</td><td>';
	echo Form::input('location_name', $data['location_name'], array('id'=>'location_name', 'style'=>'width:300px;'));
	
	echo '</td></tr><tr><td>';
	echo Form::label('show_pictures', __('show pictures').": ");
	echo '</td><td>';
	echo Form::checkbox('show_pictures', 'show_pictures' , $data['show_pictures'] == '1', array('id'=>'show_pictures'));
	
	echo '</td></tr><tr><td>';
	echo Form::label('pictures_name', __('pictures name').": ");
	echo '</td><td>';
	echo Form::input('pictures_name', $data['pictures_name'], array('id'=>'pictures_name', 'style'=>'width:300px;'));
	
	echo '</td></tr><tr><td>';
	echo Form::label('show_files', __('show files').": ");
	echo '</td><td>';
	echo Form::checkbox('show_files', 'show_files' , $data['show_files'] == '1', array('id'=>'show_files'));
	
	echo '</td></tr><tr><td>';
	echo Form::label('files_name', __('files name').": ");
	echo '</td><td>';
	echo Form::input('files_name', $data['files_name'], array('id'=>'files_name', 'style'=>'width:300px;'));
	
	
	echo '</td></tr><tr><td>';
	echo Form::submit('edit', __('add edit'), array('id'=>'edit_button'));
	echo '</td><td></td></tr></table>';
	echo Form::close();
?>
</table>
</div>


<h2><?php echo __('form fields');?></h2>
<?php if($data['id'] != 0){ ?>
<a class="button" id="add_field_button" href="<?php echo url::base(); ?>admin/formfields?form=<?php echo $data['id'];?>"><?php echo __('add field');?></a>
<br/><br/>
<?php } ?>
<table class="list_table">
	<thead>
		<tr class="header">
			<th style="width:200px;">
				<?php echo __('field');?>
			</th>
			<th style="width:400px;">
				<?php echo __('description');?>
			</th>
			<th style="width:200px;">
				<?php echo __('type');?>
			</th>
			<th style="width:200px;">
				<?php echo __('actions');?>
			</th>
		</tr>
	</thead>
	<tbody>
	<?php
		if(count($formfields) == 0)
		{
			echo '<tr><td colspan="4">'.__('you have no form fields').'</td></tr>';
		}
		$i = 0;
		foreach($formfields as $ff){
			$i++;
			$odd_row = ($i % 2) == 0 ? 'class="odd_row"' : '';
		?>

	<tr <?php echo $odd_row; ?>>
		<td style="width:200px;">
			<?php echo $ff->title;?>
		</td>
		<td style="width:400px;">
			<?php echo $ff->description; ?>
		</td>
		<td style="width:400px;">
			<?php $mapping = Model_Formfields::get_human_readable_type(); echo $mapping[$ff->type]; ?>
		</td>
		<td style="width:200px;">
			<a href="<?php echo url::base(); ?>admin/formfields?form=<?php echo $data['id']; ?>&id=<?php echo $ff->id;?>"> <?php echo __('edit');?></a>
			<a href="#" onclick="deleteFormField(<?php echo $ff->id?>);"> <?php echo __('delete');?></a>
		</td>
	</tr>
	<?php }?>
	</tbody>
</table>



