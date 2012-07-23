
<h2><?php echo __("thank you for your submission on the passing of :passed", array(':passed'=>$passed->full_name()));?></h2>
<p><?php echo __("The request to recognize :passed as passed away has been cancelled", array(':passed'=>$passed->full_name(), ':passed_id'=>$passed->id));?></p>





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
