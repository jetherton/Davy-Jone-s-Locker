<h2><?php echo __("register"); ?></h2>
<p><?php echo __("register explanation");?></p>

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
				<?php echo Form::label('email_address', __("email address"));  ?>
			</td>
			<td>
				<?php echo Form::input('email');?>
			</td>
		</tr>
		<tr>
			<td>
				<?php echo Form::label('user_name', __("user name"));  ?>
			</td>
			<td>
				<?php echo Form::input('username');?>
			</td>
		</tr>
		<tr>
			<td>
				<?php echo Form::label('first_name', __("first name"));  ?>
			</td>
			<td>
				<?php echo Form::input('first_name');?>
			</td>
		</tr>
		<tr>
			<td>
				<?php echo Form::label('last_name', __("last name"));  ?>
			</td>
			<td>
				<?php echo Form::input('last_name');?>
			</td>
		</tr>
		<tr>
			<td>
				<?php echo Form::label('password', __("password"));  ?>
			</td>
			<td>
				<?php echo Form::password('password');?>
			</td>
		</tr>
		<tr>
			<td>
				<?php echo Form::label('password_again', __("password again"));  ?>
			</td>
			<td>
				<?php echo Form::password('password_confirm');?>
			</td>
		</tr>
	</table>
	<br/>
	<?php  echo Form::checkbox('terms'); echo Form::label('read_terms_of_use', __("read terms of use"));  ?>
	<br/>
	<br/>
	<?php echo Form::submit("registration_form",  __("register")); ?>
			
<?php echo Kohana_Form::close(); ?>