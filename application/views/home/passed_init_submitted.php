
<h2><?php echo __("marking the passing of :passed", array(':passed'=>$passed->full_name())). ' - '. __('submitted');?></h2>
<p><?php echo __("sorry for your loss");?></p>
<p><?php echo __("you can view the status of :passed :passed_id at", array(':passed'=>$passed->full_name(), ':passed_id'=>$passed->id));?></p>





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
<p><?php echo __("we have notified others to confirm the passing of :passed", array(':passed'=>$passed->first_name));?></p>

