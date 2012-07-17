
<h2><?php echo __("marking the passing of :passed", array(':passed'=>$passed->full_name()));?></h2>
<p><?php echo __("passed init explanation :passed", array(':passed'=>$passed->full_name()));?></p>





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

<?php echo Kohana_Form::open(); ?>
<table class="formfields">
	<tr>
		<td class="formfieldlabel">
			<?php echo Form::label('note', __("note"));  ?>
		</td>
		<td>
			<?php echo Form::textarea('note',''); ?>
		</td>
	</tr>
</table>

<?php echo Form::submit("passed_form",  __("submit")); ?>
	

</div>
			
<?php echo Kohana_Form::close(); ?>

