<h2><?php echo __("profile header"); ?></h2>
<p><?php echo __("profile explanation");?></p>
<h4 class="whats_required"><?php echo __("whats required");?></h4>

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
	<table>
		<tr>
			<td>
				<?php echo __("email address");  ?>
			</td>
			<td>
				<?php echo Form::input('email', $user->email);?>
			</td>
		</tr>
		<tr>
			<td>
				<?php echo __("user name");  ?>
			</td>
			<td>
				<?php echo Form::input('username', $user->username);?>
			</td>
		</tr>
		<tr>
			<td>
				<?php echo __("first name");  ?>
			</td>
			<td>
				<?php echo Form::input('first_name', $user->first_name);?>
			</td>
		</tr>
		<tr>
			<td>
				<?php echo __("last name");  ?>
			</td>
			<td>
				<?php echo Form::input('last_name', $user->last_name);?>
			</td>
		</tr>
		<tr>
			<td>
				<?php echo __("current password");  ?>
			</td>
			<td>
				<?php echo Form::password('current_password');?>
			</td>
		</tr>		
		<tr>
			<td>
				<?php echo __("new password");  ?>
			</td>
			<td>
				<?php echo Form::password('password');?>
			</td>
		</tr>
		<tr>
			<td>
				<?php echo __("new password again");  ?>
			</td>
			<td>
				<?php echo Form::password('password_confirm');?>
			</td>
		</tr>
	</table>
	<br/>
	<br/>
	<?php echo Form::submit("profile_form",  __("update profile")); ?>
			
<?php echo Kohana_Form::close(); ?>