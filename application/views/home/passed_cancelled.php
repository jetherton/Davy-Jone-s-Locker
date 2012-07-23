
<h2><?php echo __(":passed - request cancelled", array(':passed'=>$passed->full_name()));?></h2>






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

<p><?php echo __('the current attempt to mark :passed :passed_id as passed away has been cancelled and can not be restarted until the waiting period set by :passed has expried',		
		array(':passed'=>$passed->full_name(),
				':passed_id'=>$passed->id));?></p>
				
<p><?php echo __('record of cancelled attempt to mark :passed :passed_id as passed away',
		array(':passed'=>$passed->full_name(),
				':passed_id'=>$passed->id));?></p>


<?php 
$i = 0;
foreach($passed_requests as $passed_request) {
	echo '<div class="passed_info">';
	$passer = ORM::factory('user', $passed_request->passer_id);
	if($i == 0)
	{
		echo __(':passer first marked passing of :passed on :date at :time saying :note :passed_id', array(
				':passer'=>$passer->full_name(),
				':passed'=>$passed->full_name(),
				':passed_id'=>$passed->id,
				':date'=>date('l F jS Y',strtotime($passed_request->time)),
				':time'=>date('g:ia',strtotime($passed_request->time)),
				':note'=>$passed_request->note
				));
	}
	else
	{
		if($passed_request->confirm == '1')
		{
			echo __(':passer confirmed this on :date at :time saying :note', array(
					':passer'=>$passer->full_name(),
					':passed'=>$passed->full_name(),
					':passed_id'=>$passed->id,
					':date'=>date('l F jS Y',strtotime($passed_request->time)),
					':time'=>date('g:ia',strtotime($passed_request->time)),
					':note'=>$passed_request->note
			));
		}
		
		if($passed_request->confirm == '0')
		{
			echo __(':passer denied this on :date at :time saying :note', array(
					':passer'=>$passer->full_name(),
					':passed'=>$passed->full_name(),
					':passed_id'=>$passed->id,
					':date'=>date('l F jS Y',strtotime($passed_request->time)),
					':time'=>date('g:ia',strtotime($passed_request->time)),
					':note'=>$passed_request->note
			));
		}
		
	}
	
	$i++;	
	echo '</div>';
}?>



