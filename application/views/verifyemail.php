<h2><?php echo __("verify email"); ?></h2>
<p><?php echo __("verify email explanation");?></p>


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

<?php echo Kohana_Form::open(); ?>
	<table>
		<tr>
			<td>
				<?php echo Form::label('email_key', __("email key"));  ?>
			</td>
			<td>
				<?php echo Form::input('email_key');?>
			</td>			
		</tr>
	</table>
	<br/>
	<br/>
	<?php echo Form::submit("submit_key",  __("submit")); ?>
			
<?php echo Kohana_Form::close(); ?>
