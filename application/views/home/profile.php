<h2><?php echo __("profile header"); ?></h2>
<p><?php echo __("profile explanation");?></p>

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
				<?php echo __("email address");  ?>
			</td>
			<td>
				<?php echo Form::input('email');?>
			</td>
		</tr>
		<tr>
			<td>
				<?php echo __("user name");  ?>
			</td>
			<td>
				<?php echo Form::input('username');?>
			</td>
		</tr>
		<tr>
			<td>
				<?php echo __("password");  ?>
			</td>
			<td>
				<?php echo Form::password('password');?>
			</td>
		</tr>
		<tr>
			<td>
				<?php echo __("password again");  ?>
			</td>
			<td>
				<?php echo Form::password('password_confirm');?>
			</td>
		</tr>
	</table>
	<br/>
	<br/>
	<?php echo Form::submit("registration_form",  __("register")); ?>
			
<?php echo Kohana_Form::close(); ?>