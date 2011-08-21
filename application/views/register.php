<h2><?php echo __("register"); ?></h2>
<p><?php echo __("register explanation");?></p>

<?php echo Form::open(); ?>
	<table>
		<tr>
			<td>
				<?php echo __("first name");  ?>
			</td>
			<td>
				<?php echo Form::input('first_name');?>
			</td>
		</tr>
		<tr>
			<td>
				<?php echo __("last name");  ?>
			</td>
			<td>
				<?php echo Form::input('last_name');?>
			</td>
		</tr>
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
				<?php echo Form::password('password_again');?>
			</td>
		</tr>
	</table>
	<br/>
	<?php  echo Form::checkbox('terms'); echo __("read terms of use");  ?>
	<br/>
	<br/>
	<?php echo Form::submit("registration_form",  __("register")); ?>
			
<?php echo Form::close(); ?>