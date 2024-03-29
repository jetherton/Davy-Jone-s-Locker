<?php defined('SYSPATH') or die('No direct script access.');
/***********************************************************
* forms.php - View
* This software is copy righted by Etherton Technologies Ltd. 2011
* Writen by John Etherton <john@ethertontech.com>
* Started on 12/06/2011
*************************************************************/
?>
		
<h2><?php echo __("forms"); ?></h2>
<p><?php echo __("forms explanation");?></p>


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
<p>
<a class="button" id="add_form_button" href="<?php echo url::base(); ?>admin/forms/edit"><?php echo __('add form');?></a>
</p>
<table class="list_table" >
	<thead>
		<tr class="header">
			<th style="width:200px;">
				<?php echo __('form');?>
			</th>
			<th style="width:400px;">
				<?php echo __('description');?>
			</th>
			<th style="width:200px;">
				<?php echo __('category');?>
			</th>
			<th style="width:200px;">
				<?php echo __('actions');?>
			</th>
		</tr>
	</thead>
	<tbody style="height:700px;">
	<?php
		if(count($forms) == 0)
		{
			echo '<tr><td colspan="3">'.__('you have no forms').'</td></tr>';
		}
		$i = 0;
		foreach($forms as $form){
			$i++;
			$odd_row = ($i % 2) == 0 ? 'class="odd_row"' : '';
		?>

	<tr <?php echo $odd_row; ?> style="height:50px;">
		<td style="width:200px;">
			<?php echo substr($form->title, 0, 40); echo strlen($form->title) > 40 ? '...' : ''; ?>
		</td>
		<td style="width:400px;">
			<?php echo substr($form->description, 0, 50); echo strlen($form->description) > 50 ? '...' : ''; ?>
		</td>
		<td style="width:200px;">
			<?php echo ORM::factory('category',$form->category_id)->title; ?>
		</td>
		<td style="width:200px;">
			<a href="<?php echo url::base(); ?>admin/forms/edit?id=<?php echo $form->id;?>" > <?php echo __('edit');?></a>
			<a href="#" onclick="deleteForm(<?php echo $form->id?>);"> <?php echo __('delete');?></a>
		</td>
	</tr>
	<?php }?>
	</tbody>
</table>
<?php
echo Form::open(NULL, array('id'=>'edit_form_form')); 
echo Form::hidden('action','edit', array('id'=>'action'));
echo Form::hidden('form_id','0', array('id'=>'form_id'));
echo Form::close();
?>


