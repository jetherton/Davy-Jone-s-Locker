<h2><?php echo __("login"); ?></h2>
<p><?php echo __("login explanation");?></p>

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
				<?php echo __("user name");  ?>
			</td>
			<td>
				<?php echo Form::input('username', null, array('id'=>'username'));?>
			</td>
		</tr>
		<tr>
			<td>
				<?php echo __("password");  ?>
			</td>
			<td>
				<?php echo Form::password('password', null, array('id'=>'password'));?>
			</td>
		</tr>
	</table>
	<br/>
	<br/>
	<?php echo Form::submit("login_form",  __("login")); ?>
			
<?php echo Kohana_Form::close(); ?>